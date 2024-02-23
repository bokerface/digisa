<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\TransactionItem;
use App\Traits\FileUpload;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService
{
    use FileUpload;

    public static $product;

    public static function productList($request, $sales = null)
    {
        $products = Product::when($request->has('category'), function ($q) use ($request) {
            $q->whereRaw("FIND_IN_SET(?, category_id)", $request->category);
        })
            ->when($request->has('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($sales, function ($q) {
                $q->with('transactionItems');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return $products;
    }
    public static function storeProduct($request)
    {
        DB::transaction(function () use ($request) {
            $data = Arr::except($request->validated(), ['thumbnail', 'file', 'category_id']);
            $categories = implode(',', $request->validated('category_id'));
            $finalData = Arr::add($data, 'category_id', $categories);
            // dd($finalData);
            // dd($request->validated());
            $product = Product::create($finalData);

            // upload thumbnail image
            $thumbnailPath = "products/{$product->id}/thumbnail/";
            $uploadedThumbnail = self::upload($request->validated('thumbnail'), $thumbnailPath);
            $product->update([
                'thumbnail' => $uploadedThumbnail
            ]);

            // upload document file
            $filePath = "products/{$product->id}/file/";
            $uploadedFile = self::upload($request->validated('file'), $filePath);
            $product->update([
                'file' => $uploadedFile
            ]);

            // dd($path);

            return $product;
        });
    }

    public static function productDetail($id, $userId = null)
    {
        $product = Product::find($id);

        $bought = false;
        if ($userId != null) {
            $items = TransactionItem::with('transaction')
                ->whereHas('transaction', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            $bought = in_array($product->id, $items->pluck('product_id')->toArray());
        }

        static::$product = $product;
        static::$product->is_bought = $bought;

        return new static;
    }

    public static function deleteProduct()
    {
        DB::transaction(function () {
            static::$product->delete();
        });
    }

    public static function updateProduct($request)
    {
        DB::transaction(function () use ($request) {
            $product = static::$product;
            $data = Arr::except($request->validated(), ['thumbnail', 'file', 'category_id']);
            $categories = implode(',', $request->validated('category_id'));
            $finalData = Arr::add($data, 'category_id', $categories);
            $product->update($finalData);

            // upload thumbnail image
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = "products/{$product->id}/thumbnail/";
                $uploadedThumbnail = self::upload($request->validated('thumbnail'), $thumbnailPath);
                $product->update([
                    'thumbnail' => $uploadedThumbnail
                ]);
            }

            // upload document file
            if ($request->hasFile('file')) {
                $filePath = "products/{$product->id}/file/";
                $uploadedFile = self::upload($request->validated('file'), $filePath);
                $product->update([
                    'file' => $uploadedFile
                ]);
            }
        });
    }

    public static function sales()
    {
        $perProduct  = Product::with('transactionItems')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $perCategory = Category::with('products', 'products.transactionItems')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return [
            'perProduct' => $perProduct,
            'perCategory' => $perCategory
        ];
    }

    public static function fetch()
    {
        return static::$product;
    }
}

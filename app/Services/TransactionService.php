<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionService
{
    public static $transaction;

    public static function transactionIndex()
    {
        $transactions = Transaction::with(
            [
                'transactionItems',
                'transactionItems.product',
                'user'
            ]
        )->orderBy('created_at', 'desc')
            ->get();

        return $transactions;
    }

    public static function createTransaction($userId, $request, $cart)
    {
        $transaction = DB::transaction(function () use ($userId, $request, $cart) {
            $transaction = Transaction::create($request->validated() +
                [
                    'user_id' => $userId,
                    'payment_amount' => $cart['total'],
                ]);

            foreach ($cart['cartItems'] as $item) {
                TransactionItem::create(
                    [
                        'transaction_id' => $transaction->id,
                        'product_id' => $item->product->id,
                        'price' => $item->product->price,
                    ]
                );
            }

            Cart::where('user_id', $userId)->delete();

            return $transaction;
        });

        return $transaction;
    }

    public static function fetch()
    {
        return static::$transaction;
    }

    public static function transactionDetail($id)
    {
        $transaction = Transaction::with(
            [
                'transactionItems',
                'transactionItems.product'
            ]
        )
            ->find($id);

        // dd($transaction);
        static::$transaction = $transaction;
        return new static;
    }

    public static function confirmTransactionPayment()
    {
        $transaction = static::$transaction;

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'status' => 'lunas',
            ]);

            foreach ($transaction->transactionItems as $item) {

                if ($item->product->file != null) {
                    $sourcePath = Crypt::decryptString($item->product->file);
                    $destinationPath = "transactions/" . $transaction->id . "/" . "products/" . $item->product->id;
                    $destinationFileName = $item->product->name . "." . pathinfo($sourcePath, PATHINFO_EXTENSION);
                    Storage::copy($sourcePath, $destinationPath . '/' . $destinationFileName);
                    $transactionFilePath =  $destinationPath . '/' . $destinationFileName;

                    $item->update([
                        'file' => $transactionFilePath,
                    ]);
                }

                if ($item->product->link_gdrive != null) {
                    $item->update([
                        'link_gdrive' => $item->product->link_gdrive
                    ]);
                }
            }
        });

        return $transaction;
    }

    public static function userTransactions($userId, $status = null)
    {
        $transactions = Transaction::with(
            [
                'user',
                'transactionItems',
                'transactionItems.product',
            ]
        )
            ->when($status != null, function ($query) use ($status) {
                $query->where('status', '=', $status);
            })
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $transactions;
    }

    public static function paidFiles($userId)
    {
        $transactionFiles = TransactionItem::with('transaction', 'product')
            ->whereHas('transaction', function ($query) use ($userId) {
                $query->where('user_id', $userId);
                $query->where('status', 'lunas');
            })
            ->get();

        return $transactionFiles;
    }
}

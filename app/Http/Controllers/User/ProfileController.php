<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);

        $unpaidTransactions = TransactionService::userTransactions($userId, 'pending');
        $downloadable = TransactionService::paidFiles($userId);

        return view('user.pages.profile.detail')
            ->with(compact('user', 'unpaidTransactions', 'downloadable'));
    }

    public function update(UpdateProfileRequest $request)
    {
        UserService::userDetail(Auth::user()->id)->update($request);

        return redirect()->back()->with('success', 'Profile berhasil dirubah.');
    }

    public function changePassword()
    {
        $user = User::find(Auth::user()->id);
        return view('user.pages.profile.password-edit-form')
            ->with(compact('user'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        $user = UserService::userDetail(Auth::user()->id);

        if (Hash::check($validated['old_password'], $user->fetch()->password)) {
            $user->update($request);
            return redirect()->to(route('user.profile'))->with('success', 'Password berhasil dirubah.');
        }

        return redirect()->back()->with('error', 'Password yang anda masukkan salah.');
    }
}

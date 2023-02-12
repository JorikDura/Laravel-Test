<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Регистрирует пользователя
     * @param Request $request
     * @return void
     */
    public function RegisterUser(Request $request) : void
    {
        $request->validate([
            'login' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_conf' => 'required|same:password'
        ]);

        $user = new User([
            'name' => $request->login,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->save();
        auth()->login($user);
    }

    /**
     * Авторизирует пользователя
     * @param Request $request
     * @return bool
     */
    public function LoginUser(Request $request): bool
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['name' => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            return true;
        }

        return false;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    public function showRegistrationView()
    {
        if (Auth::check()) {
            return redirect(route('lists.index'));
        }

        return view('registration');
    }

    public function showLoginView()
    {
        if (Auth::check()) {
            return redirect(route('lists.index'));
        }

        return view('authorization');
    }

    public function register(Request $request)
    {
        $this->userService->RegisterUser($request);

        return redirect(route('lists.index'));
    }

    public function login(Request $request)
    {
        if ($this->userService->LoginUser($request)) {
            return redirect(route('lists.index'));
        }

        return back()->withErrors(['Неправильный логин или пароль'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('user.showLoginView'));
    }
}

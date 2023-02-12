@extends('layouts.app')

@section('styles')
    <link href="{{mix('css/auth_styles.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('title', 'Регистрация')

@section('content')
    <div class="container">
        <div class="row content d-flex justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="box shadow bg-white p-4">
                    <h3 class="mb-4 text-center fs-1">Регистрация</h3>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <p class="alert alert-danger">{{$error}}</p>
                        @endforeach
                    @endif
                    <form class="mb-3" method="POST" action="{{route('user.showRegistrationView')}}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-0" id="login" name="login" value="{{old('login')}}">
                            <label for="login">Логин</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-0" id="email" name="email" value="{{old('email')}}">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-0" id="password" name="password">
                            <label for="password">Пароль</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-0" id="password_conf"
                                   name="password_conf">
                            <label for="password_conf">Подтверждение пароля</label>
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-dark btn-lg border-0 rounded-0">Зарегистрироваться</button>
                        </div>
                        <div class="mb-3 text-center">
                            <a href="{{route('user.showLoginView')}}" title="Войти" class="text-decoration-none">У меня
                                уже есть аккаунт</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

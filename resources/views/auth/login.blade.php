@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-xl-5 col-lg-6 col-md-8">

            <div class="card border-0">
                <div class="card-body p-0">
                    <!-- Form Section -->
                    <div class="px-2 py-2">
                        <div class="text-center mb-3">
                            <img src="{{ asset('sbadmin/img/logo.png') }}" alt="" style="width: 150px;">
                            <h5 class="font-weight-bold text-gray-800">Selamat Datang Kembali!</h5>
                            <p class="text-muted small">Silakan masuk ke akun Anda</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Oops!</strong> {{ $errors->first() }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form class="user" method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Input Group -->
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-gray-700 mb-2">
                                   Email
                                </label>
                                <input type="email"
                                    class="form-control form-control"
                                    name="email"
                                    placeholder="nama@example.com"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus>
                            </div>

                            <!-- Password Input Group -->
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-gray-700 mb-2">
                                    Password
                                </label>
                                <input type="password"
                                    class="form-control form-control"
                                    name="password"
                                    placeholder="Masukkan password Anda"
                                    required>
                            </div>

                            <div class="text-right">
                                <a class="small text-primary font-weight-bold" href="{{ url('password.request') }}">
                                    Lupa Password?
                                </a>
                            </div>
                            <!-- Login Button -->
                            <button type="submit" class="btn btn-danger btn-block font-weight-bold shadow-sm mt-4">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk Sekarang
                            </button>
                        </form>

                        <!-- Divider -->
                        <hr class="my-3">

                        <!-- Footer Links -->
                        <div class="text-center mt-3">
                            <p class="small text-muted mb-2">Belum punya akun?</p>
                            <a class="btn btn-outline-primary btn-sm px-4" href="{{ route('register') }}">
                                <i class="fas fa-user-plus mr-1"></i> Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

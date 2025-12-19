@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-xl-6 col-lg-7 col-md-9">

            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="px-2 py-3">
                        <div class="text-center mb-3">
                            <img src="{{ asset('sbadmin/img/logo.png') }}" alt="" style="width: 150px;">
                            <h1 class="h3 font-weight-bold text-gray-800">Buat Akun Baru</h1>
                            <p class="text-muted small">Silakan isi formulir di bawah untuk membuat akun Anda</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form class="user" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" class="form-control form-control pl-3" name="name"
                                    placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-gray-700 mb-1">Alamat Email</label>
                                <input type="email" class="form-control form-control pl-3" name="email"
                                    placeholder="nama@example.com" value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="small font-weight-bold text-gray-700 mb-1">Password</label>
                                    <input type="password" class="form-control form-control pl-3" name="password"
                                        placeholder="Minimal 8 karakter" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="small font-weight-bold text-gray-700 mb-1">Ulangi Password</label>
                                    <input type="password" class="form-control form-control pl-3"
                                        name="password_confirmation" placeholder="Konfirmasi password" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-gray-700 mb-1">Alamat Lengkap</label>
                                <input type="text" class="form-control form-control pl-3" name="alamat"
                                    placeholder="Alamat tempat tinggal" value="{{ old('alamat') }}" required>
                            </div>

                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                                <input type="text" class="form-control form-control pl-3" name="no_hp"
                                    placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}" required>
                            </div>

                            <button type="submit" class="btn btn-danger btn-block font-weight-bold shadow-sm">
                                <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="small text-muted mb-2">Sudah punya akun?</p>
                            <a class="btn btn-outline-primary btn-sm px-4" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt mr-1"></i> Masuk Disini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

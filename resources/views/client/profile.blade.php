@extends('layouts.client_app')

@section('title', 'Profil Saya')

@section('content')
    <div class="container pb-5">
        <!-- Back Button & Header -->
        <div class="d-flex align-items-center mb-4 pt-3">
            <a href="{{ route('pelanggan.dashboard') }}"
                class="btn btn-sm btn-light rounded-circle shadow-sm text-muted mr-3"
                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h5 class="font-weight-bold mb-0">Edit Profil</h5>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card border-0 shadow-sm animate-slide-up">
            <div class="card-body p-4">
                <!-- Profile Picture (Visual Only) -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3 position-relative"
                        style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; font-size: 2.5rem; font-weight: bold;">
                        {{ substr($user->name, 0, 1) }}
                        <div class="position-absolute bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 32px; height: 32px; bottom: 0; right: 0; border: 2px solid white;">
                            <i class="fas fa-camera text-muted" style="font-size: 0.8rem;"></i>
                        </div>
                    </div>
                    <h6 class="font-weight-bold mb-0">{{ $user->name }}</h6>
                    <span class="text-muted small">{{ $user->email }}</span>
                </div>

                <form action="{{ route('pelanggan.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Account Info -->
                    <h6 class="font-weight-bold text-primary mb-3 text-uppercase small" style="letter-spacing: 1px;">
                        Informasi Akun</h6>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-muted mb-1">Nama Lengkap</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0 rounded-left"><i
                                        class="fas fa-user text-muted"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control bg-light border-0 rounded-right"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-muted mb-1">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0 rounded-left"><i
                                        class="fas fa-envelope text-muted"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control bg-light border-0 rounded-right"
                                value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-muted mb-1">Password Baru <span
                                class="font-weight-normal text-muted font-italic">(Kosongkan jika tidak ubah)</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0 rounded-left"><i
                                        class="fas fa-lock text-muted"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control bg-light border-0 rounded-right"
                                placeholder="******">
                        </div>
                    </div>

                    <hr class="border-light my-4">

                    <!-- Personal Info -->
                    <h6 class="font-weight-bold text-primary mb-3 text-uppercase small" style="letter-spacing: 1px;">Data
                        Diri</h6>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-muted mb-1">Nomor HP / WhatsApp</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0 rounded-left"><i
                                        class="fas fa-phone-alt text-muted"></i></span>
                            </div>
                            <input type="text" name="no_hp" class="form-control bg-light border-0 rounded-right"
                                value="{{ old('no_hp', $pelanggan->no_hp ?? '') }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-muted mb-1">Alamat Lengkap</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0 rounded-left" style="height: auto;"><i
                                        class="fas fa-map-marker-alt text-muted"></i></span>
                            </div>
                            <textarea name="alamat" class="form-control bg-light border-0 rounded-right" rows="3"
                                required>{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block rounded-pill py-3 shadow-sm font-weight-bold">
                        SIMPAN PERUBAHAN
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
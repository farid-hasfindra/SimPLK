@extends('layouts.app')

@section('title', 'Buat Booking Baru')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Booking Baru</h1>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.booking.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="hewan_id">Pasien (Hewan)</label>
                    <select class="form-control select2" id="hewan_id" name="hewan_id" required>
                        <option value="">Pilih Hewan</option>
                        @foreach($hewans as $hewan)
                            <option value="{{ $hewan->id }}" {{ old('hewan_id') == $hewan->id ? 'selected' : '' }}>
                                {{ $hewan->nama_hewan }} ({{ $hewan->jenis_hewan }}) - Pemilik: {{ $hewan->pelanggan->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jadwal_id">Jadwal Dokter</label>
                    <select class="form-control" id="jadwal_id" name="jadwal_id" required>
                        <option value="">Pilih Jadwal</option>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id }}" data-hari="{{ $jadwal->hari }}" {{ old('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                                {{ $jadwal->dokter->user->name }} - {{ $jadwal->hari }} ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Pastikan tanggal yang dipilih sesuai dengan HARI jadwal praktek.</small>
                </div>

                <div class="form-group">
                    <label for="tanggal_booking">Tanggal Booking</label>
                    <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" value="{{ old('tanggal_booking') }}" required>
                </div>

                <div class="form-group">
                    <label for="keluhan_awal">Keluhan Awal</label>
                    <textarea class="form-control" id="keluhan_awal" name="keluhan_awal" rows="3" required>{{ old('keluhan_awal') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Booking</button>
            </form>
        </div>
    </div>
@endsection

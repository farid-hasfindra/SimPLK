@extends('layouts.app')

@section('title', 'Edit Hewan')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Hewan</h1>
        <a href="{{ route('admin.hewan.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.hewan.update', $hewan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="pelanggan_id">Pemilik (Pelanggan)</label>
                    <select class="form-control @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required>
                        <option value="">Pilih Pelanggan</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id', $hewan->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                {{ $pelanggan->user->name }} - {{ $pelanggan->no_hp }}
                            </option>
                        @endforeach
                    </select>
                    @error('pelanggan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_hewan">Nama Hewan</label>
                    <input type="text" class="form-control @error('nama_hewan') is-invalid @enderror" id="nama_hewan" name="nama_hewan" value="{{ old('nama_hewan', $hewan->nama_hewan) }}" required>
                    @error('nama_hewan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_hewan">Jenis Hewan</label>
                    <select class="form-control @error('jenis_hewan') is-invalid @enderror" id="jenis_hewan" name="jenis_hewan" required>
                        <option value="">Pilih Jenis</option>
                        <option value="Kucing" {{ old('jenis_hewan', $hewan->jenis_hewan) == 'Kucing' ? 'selected' : '' }}>Kucing</option>
                        <option value="Anjing" {{ old('jenis_hewan', $hewan->jenis_hewan) == 'Anjing' ? 'selected' : '' }}>Anjing</option>
                        <option value="Kelinci" {{ old('jenis_hewan', $hewan->jenis_hewan) == 'Kelinci' ? 'selected' : '' }}>Kelinci</option>
                        <option value="Burung" {{ old('jenis_hewan', $hewan->jenis_hewan) == 'Burung' ? 'selected' : '' }}>Burung</option>
                        <option value="Lainnya" {{ old('jenis_hewan', $hewan->jenis_hewan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_hewan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ras">Ras (Opsional)</label>
                    <input type="text" class="form-control @error('ras') is-invalid @enderror" id="ras" name="ras" value="{{ old('ras', $hewan->ras) }}">
                    @error('ras')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir (Perkiraan)</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $hewan->tanggal_lahir) }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection

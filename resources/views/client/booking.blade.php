@extends('layouts.client_app')

@section('title', 'Buat Booking')

@section('content')
<div class="container pb-5">
    
    <div class="text-center mb-4 animate-fade-up">
        <h5 class="font-weight-bold">Buat Janji Temu</h5>
        <p class="text-muted small">Lengkapi formulir di bawah ini untuk booking</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0 rounded-lg animate-fade-up">
            <h6 class="font-weight-bold mb-2 small"><i class="fas fa-exclamation-triangle mr-2"></i>Periksa Kembali</h6>
            <ul class="mb-0 pl-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-lg animate-fade-up">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card animate-fade-up delay-100 mb-4" style="overflow: hidden;">
        <div class="card-body p-4">
            <form action="{{ route('pelanggan.booking.store') }}" method="POST" id="bookingForm">
                @csrf

                <!-- Section 1: Pilih Hewan -->
                <div class="section mb-4">
                    <label class="font-weight-bold small text-muted letter-spacing-1 mb-3 d-block">1. PILIH HEWAN</label>
                    <div class="form-group">
                        <div class="input-group shadow-sm rounded-lg" style="overflow: hidden;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3">
                                    <i class="fas fa-paw text-primary"></i>
                                </span>
                            </div>
                            <select class="form-control border-0 h-auto py-3 bg-white" name="hewan_id" id="hewan_id" required style="font-size: 1rem;">
                                <option value="">-- Pilih Hewan --</option>
                                @foreach ($hewans as $hewan)
                                    <option value="{{ $hewan->id }}" {{ old('hewan_id') == $hewan->id ? 'selected' : '' }}>
                                        {{ $hewan->nama_hewan }} ({{ $hewan->jenis_hewan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($hewans->isEmpty())
                            <div class="mt-2">
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Anda belum punya hewan.
                                </small>
                                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-sm btn-link pl-0">Tambah Hewan</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Section 2: Pilih Dokter & Jadwal -->
                <div class="section mb-4">
                    <label class="font-weight-bold small text-muted letter-spacing-1 mb-3 d-block">2. PILIH JADWAL</label>
                    <div class="form-group">
                         <div class="input-group shadow-sm rounded-lg" style="overflow: hidden;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3">
                                    <i class="fas fa-user-md text-primary"></i>
                                </span>
                            </div>
                            <select class="form-control border-0 h-auto py-3 bg-white" name="jadwal_id" id="jadwal_id" required style="font-size: 1rem;">
                                <option value="">-- Pilih Dokter & Jadwal --</option>
                                @foreach ($jadwals as $jadwal)
                                    @if ($jadwal->status == 'aktif')
                                        <option value="{{ $jadwal->id }}" 
                                            data-dokter="{{ $jadwal->dokter->user->name }}"
                                            data-hari="{{ $jadwal->hari }}"
                                            data-waktu="{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}"
                                            {{ request('jadwal_id') == $jadwal->id || old('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                                            Dr. {{ $jadwal->dokter->user->name }} - {{ $jadwal->hari }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Preview Jadwal -->
                        <div id="jadwalPreview" class="mt-3 p-3 rounded-lg bg-light animate-fade-up border-0" style="display: none;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle p-2 mr-3 shadow-sm">
                                    <i class="fas fa-clock text-success"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold mb-0 text-dark" id="previewDokter"></h6>
                                    <small class="text-muted" id="previewHari"></small>
                                </div>
                            </div>
                            <div class="badge badge-success px-3 py-1 mt-1 font-weight-normal" id="previewWaktu"></div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Tanggal & Keluhan -->
                <div class="section mb-4">
                    <label class="font-weight-bold small text-muted letter-spacing-1 mb-3 d-block">3. DETAIL BOOKING</label>
                    
                    <div class="form-group mb-4">
                        <label class="small text-muted font-weight-bold mb-1 ml-1">TANGGAL RENCANA DATANG</label>
                        <div class="input-group shadow-sm rounded-lg" style="overflow: hidden;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3">
                                    <i class="far fa-calendar-alt text-primary"></i>
                                </span>
                            </div>
                            <input type="date" class="form-control border-0 h-auto py-3 bg-white" name="tanggal_booking" id="tanggal_booking" 
                                min="{{ date('Y-m-d') }}" required value="{{ old('tanggal_booking') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted font-weight-bold mb-1 ml-1">KELUHAN / ALASAN</label>
                        <textarea class="form-control shadow-sm border-0 rounded-lg p-3 bg-white" name="keluhan_awal" id="keluhan_awal" rows="3" required
                            placeholder="Contoh: Kucing muntah-muntah sejak pagi..." style="resize: none;">{{ old('keluhan_awal') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block btn-lg rounded-pill shadow-lg mt-5 font-weight-bold py-3 transition-transform">
                    KIRIM BOOKING
                </button>
                 <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-link btn-block text-muted mt-2" style="text-decoration: none;">
                    Batal
                </a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview Jadwal Logic
        const jadwalSelect = document.getElementById('jadwal_id');
        const jadwalPreview = document.getElementById('jadwalPreview');
        const previewDokter = document.getElementById('previewDokter');
        const previewHari = document.getElementById('previewHari');
        const previewWaktu = document.getElementById('previewWaktu');

        function updatePreview() {
            if (jadwalSelect.value) {
                const selectedOption = jadwalSelect.options[jadwalSelect.selectedIndex];
                const dokter = selectedOption.getAttribute('data-dokter');
                const hari = selectedOption.getAttribute('data-hari');
                const waktu = selectedOption.getAttribute('data-waktu');

                previewDokter.textContent = 'Dr. ' + dokter;
                previewHari.textContent = 'Hari Praktek: ' + hari;
                previewWaktu.textContent = waktu;
                
                jadwalPreview.style.display = 'block';
                // Trigger animation
                jadwalPreview.classList.remove('animate-fade-up');
                void jadwalPreview.offsetWidth; // trigger reflow
                jadwalPreview.classList.add('animate-fade-up');
            } else {
                jadwalPreview.style.display = 'none';
            }
        }

        jadwalSelect.addEventListener('change', updatePreview);

        // Run on load if value exists
        if (jadwalSelect.value) {
            updatePreview();
        }

        // Date Validation
        const tanggalInput = document.getElementById('tanggal_booking');
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tomorrowFormatted = tomorrow.toISOString().split('T')[0];

        tanggalInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0,0,0,0); // reset time part

            if (selectedDate <= today) {
                alert('Mohon pilih tanggal mulai besok atau setelahnya');
                this.value = tomorrowFormatted;
            }
        });

        // Submit Animation
        const bookingForm = document.getElementById('bookingForm');
        bookingForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>MEMPROSES...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');

            // Timeout for demo feel (remove in production if using real AJAX)
            // setTimeout(() => {
            //     submitBtn.innerHTML = originalText;
            //     submitBtn.disabled = false;
            // }, 3000);
        });
    });
</script>

<style>
    .letter-spacing-1 { letter-spacing: 1px; }
    .form-control:focus { box-shadow: none; background-color: #fcfcfc; }
    .transition-transform:active { transform: scale(0.98); }
</style>
@endsection

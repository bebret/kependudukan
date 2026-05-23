@extends('app')

@section('title', 'Dashboard - SIPENDUK')

@push('styles')
<style>
    /* Styling khusus untuk card statistik di dashboard */
    .stat-badge {
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: bold;
    }
    .badge-up { background-color: rgba(16, 185, 129, 0.2); color: var(--success-color); }
    .badge-down { background-color: rgba(239, 68, 68, 0.2); color: var(--danger-color); }
    
    .stat-value {
        font-size: 2.2rem;
        font-weight: bold;
        margin: 15px 0 5px;
    }
    .stat-title {
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }
    .stat-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    
    /* Warna border atas */
    .border-top-blue { border-top: 4px solid var(--accent-blue); }
    .border-top-yellow { border-top: 4px solid var(--warning-color); }
    .border-top-green { border-top: 4px solid var(--success-color); }
    .border-top-red { border-top: 4px solid var(--danger-color); }

    /* Penyesuaian tabel kustom di dashboard */
    .table-custom {
        color: var(--text-main);
        margin-bottom: 0;
    }
    .table-custom thead th {
        background-color: rgba(255, 255, 255, 0.02);
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
    }
    .table-custom tbody td {
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        color: var(--text-main);
        padding: 12px 8px;
    }
    .table-custom tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.01);
    }
</style>
@endpush

@section('content')

<div class="top-header">
    <div>
        <h1>Dashboard</h1>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div>
        <a href="{{ route('penduduk.create') }}" class="btn btn-custom-blue">
            <i class="fas fa-plus me-1"></i> Tambah Penduduk
        </a>
    </div>
</div>

<div class="px-4 pb-4">
    
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card-custom border-top-blue h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div style="background: rgba(59, 130, 246, 0.2); padding: 8px; border-radius: 8px;">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <span class="stat-badge badge-up"><i class="fas fa-arrow-up"></i> Data</span>
                </div>
                <div class="stat-value">{{ number_format($statistik['total_penduduk']) }}</div>
                <div class="stat-title">Total Penduduk</div>
                <div class="stat-desc">Semua yang terdaftar di sistem</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-custom border-top-yellow h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div style="background: rgba(245, 158, 11, 0.2); padding: 8px; border-radius: 8px;">
                        <i class="fas fa-home text-warning"></i>
                    </div>
                    <span class="stat-badge badge-up"><i class="fas fa-arrow-up"></i> KK</span>
                </div>
                <div class="stat-value">{{ number_format($statistik['total_keluarga']) }}</div>
                <div class="stat-title">Total Keluarga</div>
                <div class="stat-desc">Jumlah Kartu Keluarga aktif</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-custom border-top-green h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div style="background: rgba(16, 185, 129, 0.2); padding: 8px; border-radius: 8px;">
                        <i class="fas fa-heartbeat text-success"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($statistik['penduduk_hidup']) }}</div>
                <div class="stat-title">Penduduk Hidup</div>
                <div class="stat-desc">
                    Laki: {{ $statistik['laki_laki'] }} | Pr: {{ $statistik['perempuan'] }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-custom border-top-red h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div style="background: rgba(239, 68, 68, 0.2); padding: 8px; border-radius: 8px;">
                        <i class="fas fa-book-dead text-danger"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($statistik['penduduk_mati']) }}</div>
                <div class="stat-title">Meninggal</div>
                <div class="stat-desc">Penduduk yang telah wafat</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card-custom h-100">
                <h5 class="mb-4" style="font-size: 1.1rem;">Statistik Demografi</h5>
                <div style="position: relative; height: 220px; width: 100%;">
                    <canvas id="demografiChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-custom h-100">
                <h5 class="mb-4" style="font-size: 1.1rem;">Akses Cepat</h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('penduduk.create') }}" class="btn btn-outline-light text-start" style="border-color: var(--border-color);">
                        <i class="fas fa-user-plus text-primary me-2"></i> Tambah Penduduk
                    </a>
                    <a href="{{ route('keluarga.create') }}" class="btn btn-outline-light text-start" style="border-color: var(--border-color);">
                        <i class="fas fa-home text-warning me-2"></i> Tambah Keluarga
                    </a>
                    <a href="{{ route('penduduk.index') }}" class="btn btn-outline-light text-start" style="border-color: var(--border-color);">
                        <i class="fas fa-list text-success me-2"></i> Lihat Data Penduduk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card-custom h-100">
                <h5 class="mb-4" style="font-size: 1.1rem; color: #f1f5f9;">
                    <i class="fas fa-user-clock me-2 text-primary"></i> Pendaftaran Penduduk Terbaru
                </h5>
                <div class="table-responsive">
                    <table class="table table-custom" style="font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th style="color: #94a3b8;">NIK</th>
                                <th style="color: #94a3b8;">Nama</th>
                                <th style="color: #94a3b8;">Jenis Kelamin</th>
                                <th style="color: #94a3b8;">Tanggal Input</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendudukTerbaru ?? [] as $pt)
                                <tr>
                                    <td style="font-family: monospace; color: #999999;">{{ $pt->nik }}</td>
                                    
                                    <td style="color: #999999;"><strong>{{ $pt->nama }}</strong></td>
                                    
                                    <td>
                                        @if(strtolower($pt->jenis_kelamin) == 'laki-laki')
                                            <span class="badge bg-primary px-2 py-1"><i class="fas fa-mars me-1"></i> Laki-laki</span>
                                        @else
                                            <span class="badge px-2 py-1" style="background-color: #ec4899; color: white;"><i class="fas fa-venus me-1"></i> Perempuan</span>
                                        @endif
                                    </td>
                                    
                                    <td style="color: #94a3b8;">{{ $pt->created_at->format('d-m-Y H:i') }} WIB</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4" style="color: #64748b;">
                                        <i class="fas fa-inbox d-block mb-2" style="font-size: 1.5rem; opacity: 0.5;"></i>
                                        Belum ada data pendaftaran baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        

        <div class="col-md-4">
            <div class="card-custom h-100">
                <h5 class="mb-4" style="font-size: 1.1rem;"><i class="fas fa-chart-pie me-2 text-info"></i> Rasio Jenis Kelamin</h5>
                <div style="position: relative; height: 220px; width: 100%;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi Grafik Batang (Demografi)
        const ctx = document.getElementById('demografiChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Laki-laki', 'Perempuan', 'Kawin', 'Belum Kawin'],
                datasets: [{
                    label: 'Jumlah Orang',
                    data: [
                        {{ $statistik['laki_laki'] ?? 0 }},
                        {{ $statistik['perempuan'] ?? 0 }},
                        {{ $statistik['kawin'] ?? 0 }},
                        {{ $statistik['belum_kawin'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)', // Biru
                        'rgba(236, 72, 153, 0.8)', // Pink
                        'rgba(16, 185, 129, 0.8)', // Hijau
                        'rgba(239, 68, 68, 0.8)'   // Merah
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Wajib false karena tingginya sudah dikunci via wrapper HTML CSS
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#334155' },
                        ticks: { color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    }
                }
            }
        });

        // 2. Inisialisasi Grafik Donut (Rasio Gender)
        const ctxGender = document.getElementById('genderChart').getContext('2d');
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [
                        {{ $statistik['laki_laki'] ?? 0 }},
                        {{ $statistik['perempuan'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)', 
                        'rgba(236, 72, 153, 0.8)'  
                    ],
                    borderColor: '#1e293b', 
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Wajib false karena tingginya sudah dikunci via wrapper HTML CSS
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            boxWidth: 12,
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
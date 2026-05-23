<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Data Kependudukan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS Reset & Variabel Warna Dark Mode mirip gambar */
        :root {
            --bg-main: #0f172a;      /* Latar belakang utama */
            --bg-sidebar: #1e293b;   /* Latar belakang sidebar & kartu */
            --text-main: #f8fafc;    /* Teks utama (putih) */
            --text-muted: #94a3b8;   /* Teks abu-abu */
            --accent-blue: #3b82f6;  /* Biru tombol/aksen */
            --border-color: #334155; /* Garis pembatas */
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Layout Sidebar & Main Content */
        .wrapper {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar Styling */
        .sidebar-brand {
            padding: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand img {
            width: 30px;
            height: 30px;
            border-radius: 8px;
        }

        .sidebar-nav {
            padding: 20px 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-category {
            padding: 10px 20px 5px;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s;
            gap: 15px;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: var(--text-main);
            background-color: rgba(255,255,255,0.05);
            border-left: 3px solid var(--accent-blue);
        }

        .sidebar-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Header atas (Dashboard Header) */
        .top-header {
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-header h1 {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }
        
        .top-header p {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.85rem;
        }

        /* Card Customization */
        .card-custom {
            background-color: var(--bg-sidebar);
            border: none;
            border-radius: 12px;
            padding: 20px;
            color: var(--text-main);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Tombol Custom */
        .btn-custom-blue {
            background-color: var(--accent-blue);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
        }
        .btn-custom-blue:hover { background-color: #2563eb; color: white;}

        .footer {
            margin-top: auto;
            padding: 20px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            border-top: 1px solid var(--border-color);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div style="background: var(--accent-blue); width: 30px; height: 30px; border-radius: 8px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-users" style="font-size: 14px;"></i>
                </div>
                SIPENDUK
            </div>
            
            <ul class="sidebar-nav">
                <li class="sidebar-category">Utama</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('penduduk.index') }}" class="sidebar-link {{ request()->routeIs('penduduk.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i> Data Penduduk
                    </a>
                </li>
                <li>
                    <a href="{{ route('keluarga.index') }}" class="sidebar-link {{ request()->routeIs('keluarga.*') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Data Keluarga
                    </a>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            
            <div class="px-4 pt-3">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            @yield('content')

            <footer class="footer">
                &copy; {{ date('Y') }} Aplikasi Data Kependudukan - BINUS Semester 4
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @stack('scripts')
</body>
</html>
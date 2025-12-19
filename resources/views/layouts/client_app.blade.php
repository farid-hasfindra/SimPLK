<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'SimPLK Mobile')</title>

    <!-- Fonts: Nunito (Rounded, Friendly) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons & Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            /* Animalia Brand Palette */
            --primary: #E63946;
            /* Animalia Red */
            --primary-dark: #C02E39;
            --accent: #FFC107;
            /* Animalia Gold */
            --accent-hover: #FFB300;
            --bg-body: #FFFDF9;
            /* Warm White */
            --text-dark: #2C3E50;
            --text-muted: #7F8C8D;
            --white: #ffffff;
            --radius-xl: 30px;
            --radius-lg: 20px;
            --radius-md: 12px;
            --shadow-float: 0 10px 30px rgba(230, 57, 70, 0.2);
            --shadow-card: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Nunito', sans-serif;
            color: var(--text-dark);
            padding-bottom: 100px;
            /* Space for nav */
            overflow-x: hidden;
            /* Subtle Pattern: Paw Prints */
            background-image:
                radial-gradient(var(--accent) 0.5px, transparent 0.5px),
                radial-gradient(var(--accent) 0.5px, var(--bg-body) 0.5px);
            background-size: 30px 30px;
            background-position: 0 0, 15px 15px;
            background-attachment: fixed;
        }

        /* --- Animations --- */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pop {
            animation: popIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        /* --- Global Component Overrides --- */
        .card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .btn {
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 25px;
            border: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.3);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(230, 57, 70, 0.5);
            color: white;
        }

        .btn-accent {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }

        .btn-accent:hover {
            background: var(--accent-hover);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.5);
        }

        /* --- Header --- */
        .header-curve {
            background: var(--white);
            padding: 15px 20px 20px 20px;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 10;
        }

        .header-curve::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            background: linear-gradient(to right, rgba(230, 57, 70, 0.05), rgba(255, 193, 7, 0.05));
            z-index: -1;
        }

        .header-profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 18px;
            background: var(--primary);
            color: white;
            padding: 2px;
            border: 2px solid var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.2);
        }

        /* --- Floating Nav --- */
        /* --- Floating Nav --- */
        .nav-capsule {
            position: fixed;
            bottom: 20px;
            bottom: calc(20px + env(safe-area-inset-bottom));
            left: 0;
            right: 0;
            margin: 0 auto;
            /* Force horizontal centering */
            transform: none;
            /* Disable transform centering */
            background: #ffffff;
            width: 95%;
            max-width: 400px;
            height: 70px;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);

            /* GRID LAYOUT for Perfect Symmetry */
            display: grid;
            grid-template-columns: 1fr 1fr 60px 1fr 1fr;
            align-items: center;
            justify-items: center;
            padding: 0 10px;
            z-index: 1000;
        }

        .nav-link-custom {
            color: #bdc3c7;
            text-align: center;
            text-decoration: none !important;
            transition: 0.3s;
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .nav-link-custom i {
            font-size: 1.3rem;
            margin-bottom: 4px;
        }

        .nav-link-custom span {
            font-size: 0.65rem;
            font-weight: 700;
            display: block;
        }

        .nav-link-custom.active,
        .nav-link-custom:hover {
            color: var(--primary);
        }

        .nav-link-custom.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            width: 5px;
            height: 5px;
            background: var(--accent);
            border-radius: 50%;
        }

        .nav-action-btn-wrapper {
            position: relative;
            width: 60px;
            height: 60px;
            pointer-events: none;
        }

        .nav-action-btn {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 10px 25px rgba(230, 57, 70, 0.4);

            /* FIXED ALIGNMENT: Margin for lift, Transform for rotation only */
            margin-top: -35px;
            transform: rotate(45deg);

            border: 4px solid var(--bg-body);
            transition: 0.3s;
            pointer-events: auto;
            cursor: pointer;
        }

        .nav-action-btn i {
            transform: rotate(-45deg);
        }

        .nav-action-btn:hover {
            /* Scale without shifting position */
            transform: rotate(45deg) scale(1.1);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: white;
            text-decoration: none;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Header -->
    <div class="header-curve">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="text-muted font-weight-bold mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">VET
                    HOSPITAL</h6>
                <h4 class="font-weight-800 text-dark mb-0">Hi, {{ Auth::user()->name }} <i
                        class="fas fa-paw text-warning ml-1"></i></h4>
            </div>
            <a href="{{ route('pelanggan.profile') }}"
                class="header-profile-img shadow-sm animate-pop text-decoration-none">
                {{ substr(Auth::user()->name, 0, 1) }}
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="mt-3">
        @yield('content')
    </div>

    <!-- Navigation -->
    <div class="nav-capsule animate-slide-up delay-3">
        <a href="{{ route('pelanggan.dashboard') }}"
            class="nav-link-custom {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
        </a>

        <a href="{{ route('pelanggan.jadwal') }}"
            class="nav-link-custom {{ request()->routeIs('pelanggan.jadwal') ? 'active' : '' }}">
            <i class="far fa-calendar-check"></i>
        </a>

        <div class="nav-action-btn-wrapper">
            <a href="{{ route('pelanggan.booking') }}" class="nav-action-btn">
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <a href="{{ route('pelanggan.riwayat') }}"
            class="nav-link-custom {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>
        </a>

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link-custom">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Critical: Force scroll to top
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual';
        }

        window.scrollTo(0, 0);

        document.addEventListener("DOMContentLoaded", function () {
            window.scrollTo(0, 0);
        });

        window.onload = function () {
            setTimeout(function () { window.scrollTo(0, 0); }, 1);
            setTimeout(function () { window.scrollTo(0, 0); }, 50);
        };
    </script>
    @stack('scripts')
</body>

</html>
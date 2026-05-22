<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediBook — @yield('title', 'Gestion Médicale')</title>
    <link rel="icon" type="image/x-icon" href="data:image/jpeg;base64,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">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;500;600;700&family=Satoshi:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
    <style>
        :root {
            --teal: #0d9488;
            --navy: #0f172a;
            --card: #162032;
        }

        * {
            font-family: 'Satoshi', sans-serif;
        }

        .font-display {
            font-family: 'Clash Display', sans-serif;
        }

        body {
            background: var(--navy);
            color: #e2e8f0;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .teal-gradient {
            background: linear-gradient(135deg, #0d9488, #0891b2);
        }

        .card {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-link {
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(13, 148, 136, 0.15);
            border-left-color: #0d9488;
            color: #5eead4;
        }

        .btn-teal {
            background: linear-gradient(135deg, #0d9488, #0891b2);
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(13, 148, 136, 0.3);
        }

        .btn-teal:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 25px rgba(13, 148, 136, 0.45);
        }

        .status-pending {
            background: #854d0e22;
            color: #fbbf24;
            border: 1px solid #854d0e55;
        }

        .status-accepted {
            background: #14532d22;
            color: #4ade80;
            border: 1px solid #14532d55;
        }

        .status-completed {
            background: #1e3a5f22;
            color: #60a5fa;
            border: 1px solid #1e3a5f55;
        }

        .status-cancelled {
            background: #4c051922;
            color: #f87171;
            border: 1px solid #7f1d1d55;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.5s 0.0s ease both;
        }

        .fade-up-2 {
            animation: fadeUp 0.5s 0.1s ease both;
        }

        .fade-up-3 {
            animation: fadeUp 0.5s 0.2s ease both;
        }

        .fade-up-4 {
            animation: fadeUp 0.5s 0.3s ease both;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #0d9488 !important;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2) !important;
        }
    </style>
</head>

<body class="min-h-screen">

    @auth
    <div class="flex min-h-screen">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-64 fixed h-full z-30 flex flex-col"
            style="background:rgba(15,23,42,0.95);backdrop-filter:blur(20px);border-right:1px solid rgba(255,255,255,0.07)">

            {{-- Logo --}}
            <div class="p-6" style="border-bottom:1px solid rgba(255,255,255,0.07)">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl teal-gradient flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                    </div>
                    <span class="font-display text-xl text-white font-semibold">
                        Medi<span style="color:#2dd4bf">Book</span>
                    </span>
                </div>
            </div>

            {{-- User info --}}
            <div class="p-5" style="border-bottom:1px solid rgba(255,255,255,0.07)">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0" style="border:2px solid #0d9488">
                        @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                            class="w-full h-full object-cover" alt="avatar">
                        @else
                        <div class="w-full h-full teal-gradient flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                        </div>
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-white text-sm font-medium truncate">
                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                        </p>
                        <p class="text-xs" style="color:#2dd4bf">
                            {{ auth()->user()->isDoctor() ? __('app.doctor') : __('app.patient') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                @if(auth()->user()->isDoctor())
                <a href="{{ route('doctor.dashboard') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                    </svg>
                    {{ __('app.dashboard') }}
                </a>
                <a href="{{ route('doctor.appointments') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('doctor.appointments*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    {{ __('app.appointments') }}
                </a>
                <a href="{{ route('doctor.messages') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('doctor.messages*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    {{ __('app.messages') }}
                </a>
                <a href="{{ route('doctor.blocked-dates') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('doctor.blocked-dates*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" />
                    </svg>
                    {{ __('app.unavailability') }}
                </a>
                <a href="{{ route('doctor.profile') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('doctor.profile*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    {{ __('app.profile') }}
                </a>
                @else
                <a href="{{ route('patient.dashboard') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                    </svg>
                    {{ __('app.dashboard') }}
                </a>
                <a href="{{ route('patient.doctors') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('patient.doctors*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    {{ __('app.doctors') }}
                </a>
                <a href="{{ route('patient.appointments') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('patient.appointments*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    {{ __('app.my_appointments') }}
                </a>
                <a href="{{ route('patient.messages') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('patient.messages*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    {{ __('app.messages') }}
                </a>
                <a href="{{ route('patient.profile') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-300 {{ request()->routeIs('patient.profile*') ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    {{ __('app.profile') }}
                </a>
                @endif
            </nav>

            {{-- Logout --}}
            <div class="p-4" style="border-top:1px solid rgba(255,255,255,0.07)">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-slate-400
                               hover:text-red-400 hover:bg-red-900/20 transition-all">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===== MAIN ===== --}}
        <main class="flex-1 min-h-screen" style="margin-left:256px">

            {{-- Top bar --}}
            <header class="sticky top-0 z-20 px-8 py-4 flex items-center justify-between"
                style="background:rgba(15,23,42,0.9);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,0.07)">
                <h1 class="font-display text-lg font-semibold text-white">
                    @yield('page-title', __('app.dashboard'))
                </h1>
                <div class="text-sm text-slate-400">
                    {{ now()->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY') }}
                </div>
                {{-- Sélecteur langue --}}
                <div class="flex items-center gap-1">
                    @foreach(['fr'=>'FR','en'=>'EN','ar'=>'AR'] as $locale=>$label)
                    @if(app()->getLocale() === $locale)
                    <a href="{{ route('lang.switch', $locale) }}"
                        class="px-2.5 py-1 rounded-lg text-xs font-medium transition-all"
                        style="background:rgba(13,148,136,0.3);color:#2dd4bf;border:1px solid rgba(13,148,136,0.4)">
                        {{ $label }}
                    </a>
                    @else
                    <a href="{{ route('lang.switch', $locale) }}"
                        class="px-2.5 py-1 rounded-lg text-xs font-medium transition-all"
                        style="color:#64748b;border:1px solid transparent">
                        {{ $label }}
                    </a>
                    @endif
                    @endforeach
                </div>
            </header>

            {{-- Alerts --}}
            <div class="px-8 pt-6">
                @if(session('success'))
                <div class="mb-4 px-5 py-3 rounded-xl text-sm"
                    style="background:#14532d33;color:#4ade80;border:1px solid #14532d66">
                    ✓ {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 px-5 py-3 rounded-xl text-sm"
                    style="background:#4c051933;color:#f87171;border:1px solid #7f1d1d66">
                    ✗ {{ session('error') }}
                </div>
                @endif
            </div>

            {{-- Page content --}}
            <div class="px-8 pb-8 pt-2">
                @yield('content')
            </div>
        </main>
    </div>

    @else
    {{-- Pages publiques (login/register) --}}
    @yield('content')
    @endauth

    @stack('scripts')
</body>

</html>
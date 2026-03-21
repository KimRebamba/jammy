<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Shop') — Jammy Music</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('guitar-solid-full.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'] } } } }</script>
    @endif
    <style>
        .font-sans { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="font-sans bg-gradient-to-b from-stone-100 to-stone-200 text-stone-900 min-h-screen flex flex-col">
    {{-- Header --}}
    <header class="bg-gradient-to-r from-stone-900 via-stone-800 to-stone-900 text-stone-100 shadow-xl border-b border-amber-500/20">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ session('user') && session('user')->role === 'customer' ? url('/customer/index') : url('/') }}" class="inline-flex flex-col sm:flex-row sm:items-center gap-0 sm:gap-2">
                <span class="inline-flex items-center gap-2 text-xl font-bold tracking-tight text-amber-400 hover:text-amber-300 transition-colors">
                    <i class="fa-solid fa-guitar text-2xl"></i>
                    <span>Jammy Music</span>
                </span>
                <span class="text-xs text-stone-400 font-normal hidden sm:inline">— Your stage starts here.</span>
            </a>
            <nav class="flex flex-wrap items-center gap-1 sm:gap-2 text-sm">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-house w-4 text-center"></i><span class="hidden sm:inline">Home</span></a>
                @if(session('user') && session('user')->role === 'customer')
                    <a href="/customer/index" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-gauge w-4 text-center"></i><span class="hidden sm:inline">Dashboard</span></a>
                @endif
                <a href="/shop" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-shop w-4 text-center"></i><span class="hidden sm:inline">Shop</span></a>
                <a href="/shop/browse" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-magnifying-glass w-4 text-center"></i><span class="hidden sm:inline">Search</span></a>
                @if(session('user') && session('user')->role === 'customer')
                    <a href="/cart" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-cart-shopping w-4 text-center"></i><span class="hidden sm:inline">Cart</span></a>
                    <a href="/orders" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-box-open w-4 text-center"></i><span class="hidden sm:inline">Orders</span></a>
                    <a href="/reviews" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-star w-4 text-center"></i><span class="hidden sm:inline">Reviews</span></a>
                    <a href="/customer/profile" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-user w-4 text-center"></i><span class="hidden sm:inline">Profile</span></a>
                    <a href="/logout" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-400 hover:text-amber-400 hover:bg-white/5 transition-all"><i class="fa-solid fa-right-from-bracket"></i><span class="hidden sm:inline">Logout</span></a>
                @else
                    <a href="/login" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-right-to-bracket w-4 text-center"></i><span class="hidden sm:inline">Log in</span></a>
                    <a href="/register" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-amber-400/90 hover:text-amber-300 hover:bg-white/10 transition-all duration-200"><i class="fa-solid fa-user-plus w-4 text-center"></i><span class="hidden sm:inline">Sign up</span></a>
                @endif
            </nav>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-6xl mx-auto w-full px-4 py-2 mt-2">
            <p class="text-sm text-emerald-800 bg-emerald-100 border border-emerald-300 rounded-xl px-4 py-2.5 shadow-sm inline-flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-600"></i>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-6xl mx-auto w-full px-4 py-2 mt-2">
            <p class="text-sm text-red-800 bg-red-100 border border-red-300 rounded-xl px-4 py-2.5 shadow-sm inline-flex items-center gap-2"><i class="fa-solid fa-circle-exclamation text-red-600"></i>{{ session('error') }}</p>
        </div>
    @endif

    <main class="max-w-6xl mx-auto w-full px-4 py-8 flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-stone-900 text-stone-400 text-sm mt-auto border-t border-amber-500/10">
        <div class="max-w-6xl mx-auto px-4 py-6 flex flex-wrap justify-between items-center gap-4">
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-guitar text-amber-500/70"></i>© {{ date('Y') }} Jammy Music — Your stage starts here.</span>
            <a href="/home" class="text-stone-500 hover:text-amber-400 transition-colors inline-flex items-center gap-1"><i class="fa-solid fa-arrow-left text-xs"></i> Back to Home</a>
        </div>
    </footer>
</body>
</html>

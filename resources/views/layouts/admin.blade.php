<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') — Jammy Music Admin</title>
     <link rel="icon" type="image/svg+xml" href="{{ asset('guitar-solid-full.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                        colors: {
                            jammy: {
                                dark: '#0b1020',
                                accent: '#f59e0b',
                            },
                        },
                    },
                },
            }
        </script>
    @endif
    <style>
        .font-sans { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }

        /* DataTables dark theme tweaks for Jammy admin */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #e2e8f0;
            font-size: 0.75rem;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: rgba(15,23,42,0.9);
            border: 1px solid rgba(51,65,85,0.9);
            color: #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.25rem 0.5rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            border: 1px solid transparent;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: rgba(248,189,88,0.15);
            border-color: rgba(245,158,11,0.6);
            color: #fde68a !important;
        }

        .dt-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.75rem;
        }
    </style>
</head>
<body class="font-sans bg-slate-950 text-slate-100 min-h-screen flex flex-col">
    <header class="border-b border-amber-500/15 bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-2.5 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-500/15 border border-amber-400/40 flex items-center justify-center">
                    <i class="fa-solid fa-sliders text-amber-400 text-base"></i>
                </div>
                <div>
                    <a href="/admin/dashboard" class="block text-lg font-semibold tracking-tight text-slate-50 hover:text-amber-400/90 transition-colors">
                        Jammy Music Admin
                    </a>
                    <p class="text-xs text-slate-400">
                        Control room for your music gear store
                    </p>
                </div>
            </div>
            <nav class="flex flex-wrap items-center gap-0.5 text-sm sm:text-[15px]">
                <a href="/admin/dashboard" class="inline-flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-slate-200 hover:text-amber-400 hover:bg-slate-800/80 transition-all"><i class="fa-solid fa-gauge-high w-3.5 text-center"></i><span class="hidden lg:inline">Dashboard</span></a>
                <a href="/admin/products" class="inline-flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-slate-800/80 transition-all"><i class="fa-solid fa-box w-3.5 text-center"></i><span class="hidden lg:inline">Products</span></a>
                <a href="/admin/orders" class="inline-flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-slate-800/80 transition-all"><i class="fa-solid fa-truck-fast w-3.5 text-center"></i><span class="hidden lg:inline">Orders</span></a>
                <a href="/admin/reviews" class="inline-flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-slate-800/80 transition-all"><i class="fa-solid fa-star w-3.5 text-center"></i><span class="hidden lg:inline">Reviews</span></a>
                <a href="/admin/reports" class="inline-flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-slate-800/80 transition-all"><i class="fa-solid fa-chart-line w-3.5 text-center"></i><span class="hidden lg:inline">Reports</span></a>
                <a href="/logout" class="inline-flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-slate-400 hover:text-amber-300 hover:bg-slate-900 transition-all"><i class="fa-solid fa-right-from-bracket w-3.5 text-center"></i><span class="hidden lg:inline">Logout</span></a>
            </nav>
        </div>
    </header>

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

    <footer class="border-t border-amber-500/10 bg-slate-950 text-xs text-slate-500 mt-auto">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-3">
            <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-sliders text-amber-500/50"></i>© {{ date('Y') }} Jammy Music — Inventory, orders & backstage operations.</span>
            <a href="/home" class="text-slate-400 hover:text-amber-300 transition-colors inline-flex items-center gap-1"><i class="fa-solid fa-arrow-left text-xs"></i> Back to customer site</a>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Traction Day</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- DataTables CSS --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <style>
        /* Styling tambahan buat DataTables biar nyatu sama tema */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-bottom: 1.5rem;
            margin-top: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #DC2626 !important;
            /* red-600 */
            color: white !important;
            border-color: #DC2626 !important;
            /* red-600 */
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.5rem;
        }
    </style>
</head>

<body class="bg-slate-100">

    <div class="relative min-h-screen md:flex">
        <!-- Tombol Hamburger (Hanya muncul di HP) -->
        <div class="bg-slate-800 text-gray-100 flex justify-between md:hidden">
            <a href="{{ route('admin.dashboard') }}" class="block p-4 text-white font-bold">Traction Day CMS</a>
            <button id="sidebar-toggle" class="p-4 focus:outline-none focus:bg-slate-700">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-slate-800 text-slate-100 w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out z-20">
            <a href="{{ route('admin.dashboard') }}" class="text-white flex items-center space-x-2 px-4">
                <i class="fas fa-rocket text-2xl text-red-500"></i>
                <span class="text-2xl font-extrabold">Traction Day</span>
            </a>

            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 mt-4 rounded-md
                    {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    <i class="fas fa-chart-bar fa-fw w-6"></i>
                    <span class="mx-3">Hasil Vote</span>
                </a>
                <a href="{{ route('admin.voters.index') }}"
                    class="flex items-center px-4 py-2 mt-4 rounded-md
                    {{ request()->routeIs('admin.voters.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    <i class="fas fa-users fa-fw w-6"></i>
                    <span class="mx-3">Daftar Voters</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center px-4 py-2 mt-4 rounded-md
                    {{ request()->routeIs('admin.products.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    <i class="fas fa-box fa-fw w-6"></i>
                    <span class="mx-3">Produk</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-2 mt-4 rounded-md
                    {{ request()->routeIs('admin.categories.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    <i class="fas fa-tags fa-fw w-6"></i>
                    <span class="mx-3">Kategori</span>
                </a>
                <a href="{{ route('admin.linkGenerator.index') }}"
                    class="flex items-center px-4 py-2 mt-4 rounded-md
                    {{ request()->routeIs('admin.linkGenerator.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    <i class="fas fa-link fa-fw w-6"></i>
                    <span class="mx-3">Link Generator</span>
                </a>
                <a href="/voting" target="_blank"
                    class="flex items-center px-4 py-2 mt-8 border-t border-slate-700 pt-4 text-gray-400 hover:bg-slate-700 hover:text-white rounded-md">
                    <i class="fas fa-vote-yea fa-fw w-6"></i>
                    <span class="mx-3">Lihat Halaman Voting</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        {{-- DI SINI PERUBAHANNYA: Tambah min-w-0 biar kontennya nurut --}}
        <main class="flex-1 p-4 md:p-8 min-w-0">
            <h1 class="text-3xl font-bold text-slate-800 mb-6">@yield('title', 'Dashboard')</h1>
            @yield('content')
        </main>
    </div>

    {{-- Script tidak berubah --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#FFFFFF',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif
    </script>
</body>

</html>

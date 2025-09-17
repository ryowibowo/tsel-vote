<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Traction Day</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome (buat ikon) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

    {{-- CSS untuk DataTables.js --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        /* Kustomisasi kecil buat DataTables biar lebih cakep */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d2d6dc;
            padding: 5px 10px;
            border-radius: 5px;
            margin-left: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #ef4444;
            color: white !important;
            border: 1px solid #ef4444;
        }
    </style>
</head>

<body class="bg-slate-100">

    <div class="flex h-screen bg-slate-200 font-sans">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-900 text-white flex flex-col shadow-lg">
            <div class="px-6 py-5 border-b border-slate-700 flex items-center space-x-3">
                <i class="fas fa-rocket text-red-500 text-2xl"></i>
                <h2 class="text-xl font-bold">Traction CMS</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                {{-- DIUBAH DI SINI --}}


                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition-colors
              {{ request()->routeIs('admin.products.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700' }}">
                    <i class="fas fa-box fa-fw w-6"></i>
                    <span class="ml-3">Produk</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition-colors
              {{ request()->routeIs('admin.categories.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700' }}">
                    <i class="fas fa-tags fa-fw w-6"></i>
                    <span class="ml-3">Kategori</span>
                </a>

                <a href="{{ route('admin.linkGenerator.index') }}"
                    class="flex items-center px-4 py-2 mt-4 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md
        {{ request()->routeIs('admin.linkGenerator.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-link w-6"></i>
                    <span class="mx-3">Link Generator</span>
                </a>

                <a href="{{ route('admin.voters.index') }}"
                    class="flex items-center px-4 py-2 mt-4 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md
        {{ request()->routeIs('admin.voters.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span class="mx-3">Daftar Voters</span>
                </a>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition-colors
              {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-700' }}">
                    <i class="fas fa-chart-bar fa-fw w-6"></i>
                    <span class="ml-3">Hasil Vote</span>
                </a>

                <a href="/voting" target="_blank"
                    class="flex items-center px-4 py-2 rounded-lg text-gray-400 hover:bg-slate-700 transition-colors mt-8 border-t border-slate-700 pt-4">
                    <i class="fas fa-vote-yea fa-fw w-6"></i>
                    <span class="ml-3">Lihat Halaman Voting</span>
                </a>
            </nav>

        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-slate-800">@yield('title', 'Dashboard')</h1>
                <div class="text-sm text-slate-500">
                    Welcome, Admin!
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- jQuery (wajib ada sebelum DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    {{-- DataTables.js --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    {{-- SweetAlert2.js (buat notifikasi) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Inisialisasi DataTables untuk semua tabel yang punya id="dataTable"
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });

        // Tampilkan notifikasi SweetAlert kalau ada session 'success'
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            })
        @endif
    </script>

</body>

</html>

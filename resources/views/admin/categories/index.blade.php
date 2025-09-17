@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.categories.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Kategori Baru
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Nama Kategori</th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $category->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{-- Link EDIT yang bener --}}
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="text-indigo-600 hover:text-indigo-900">Edit</a>

                            {{-- Tombol HAPUS yang bener (pake form) --}}
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                class="inline-block ml-4"
                                onsubmit="return confirm('Yakin mau hapus kategori ini? Semua produk di dalamnya juga akan terhapus!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-10 text-gray-500">
                            Data kategori masih kosong.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

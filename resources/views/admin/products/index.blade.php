@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-xl">
        <div class="mb-6">
            <a href="{{ route('admin.products.create') }}"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Tambah Produk Baru
            </a>
        </div>

        <table id="dataTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    {{-- TAMBAH INI --}}
                    <th scope="col" class="px-6 py-3">No.</th>
                    <th scope="col" class="px-6 py-3">Gambar</th>
                    <th scope="col" class="px-6 py-3">Nama Produk</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3">Votes</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        {{-- TAMBAH INI --}}
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover rounded-md shadow-sm">
                            @else
                                <span class="text-gray-400 text-xs">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 font-bold">{{ $product->votes }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="font-medium text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                class="inline-block ml-4" onsubmit="return confirm('Yakin mau hapus produk ini, bre?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        {{-- DIUBAH JADI 6 --}}
                        <td colspan="6" class="text-center py-10">Data produk kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

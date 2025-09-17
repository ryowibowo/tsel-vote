@extends('layouts.admin')
@section('title', 'Tambah Produk Baru')
@section('content')
    <div class="bg-white shadow-md rounded-lg p-8">
        {{-- TAMBAHIN INI, WAJIB BUAT UPLOAD FILE! --}}
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk:</label>
                <input type="text" name="name" id="name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                <select name="category_id" id="category_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                {{-- Ganti dari icon jadi image --}}
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Produk:</label>
                <input type="file" name="image" id="image"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>
            <div class="flex items-center justify-start">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="ml-4 font-bold text-sm text-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('content')
    <div class="bg-white shadow-md rounded-lg p-8">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk:</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                <select name="category_id" id="category_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar Produk
                    (Opsional):</label>
                <input type="file" name="image" id="image"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                @if ($product->image)
                    <div class="mt-2">
                        {{-- Benerin path assetnya --}}
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                            class="w-20 h-20 object-cover rounded">
                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                    </div>
                @endif
            </div>
            <div class="flex items-center justify-start">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="ml-4 font-bold text-sm text-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

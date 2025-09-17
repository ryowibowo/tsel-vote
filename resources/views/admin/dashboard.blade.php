@extends('layouts.admin')

@section('title', 'Dashboard Hasil Vote')

@section('content')
    @forelse ($categories as $category)
        <div class="bg-white p-6 rounded-lg shadow-xl mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 border-b pb-3">{{ $category->name }}</h2>

            <div class="space-y-6 mt-4">
                @forelse ($category->products as $product)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center">
                                <span class="font-bold text-gray-700 mr-3">{{ $loop->iteration }}.</span>
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" class="w-10 h-10 rounded-md object-cover mr-3">
                                @endif
                                <span class="font-semibold text-gray-800">{{ $product->name }}</span>
                            </div>
                            <span class="font-bold text-lg text-red-600">{{ $product->votes_count }} Votes</span>
                        </div>

                        {{-- BAGIAN INI YANG DIBENERIN --}}
                        @php
                            // Ganti baris di bawah ini. Kita langsung pake $totalVotes dari controller.
                            $percentage = $totalVotes > 0 ? ($product->votes_count / $totalVotes) * 100 : 0;
                        @endphp

                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-red-500 h-4 rounded-full text-xs font-medium text-white text-center p-0.5 leading-none"
                                style="width: {{ $percentage }}%">
                                @if ($percentage > 10)
                                    {{ number_format($percentage, 1) }}%
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-5">Belum ada produk di kategori ini.</p>
                @endforelse
            </div>
        </div>
    @empty
        <div class="bg-white p-6 rounded-lg shadow-xl text-center">
            <p class="text-gray-500 py-10">Belum ada kategori atau data vote yang masuk.</p>
        </div>
    @endforelse
@endsection

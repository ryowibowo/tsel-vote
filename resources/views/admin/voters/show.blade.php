@extends('layouts.admin')

@section('title', 'Detail Vote: ' . $voter->full_name)

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-xl mb-8">
        <div class="border-b pb-4 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ $voter->full_name }}</h2>
            <p class="text-gray-600">NIK: {{ $voter->nik }}</p>
        </div>

        {{-- BAGIAN FIXED --}}
        @if (isset($groupedVotes['FIXED']))
            <h3 class="text-xl font-semibold text-gray-700 mb-4 mt-6">Pilihan Kategori FIXED (5):</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($groupedVotes['FIXED'] as $vote)
                    <div class="border rounded-lg p-3 text-center">
                        @if ($vote->product->image)
                            <img src="{{ asset($vote->product->image) }}" alt="{{ $vote->product->name }}"
                                class="w-full h-24 object-contain mb-2 rounded">
                        @endif
                        <p class="text-sm font-semibold text-gray-800">{{ $vote->product->name }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- BAGIAN MOBILE --}}
        @if (isset($groupedVotes['MOBILE']))
            <h3 class="text-xl font-semibold text-gray-700 mb-4 mt-8 pt-4 border-t">Pilihan Kategori MOBILE (5):</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($groupedVotes['MOBILE'] as $vote)
                    <div class="border rounded-lg p-3 text-center">
                        @if ($vote->product->image)
                            <img src="{{ asset($vote->product->image) }}" alt="{{ $vote->product->name }}"
                                class="w-full h-24 object-contain mb-2 rounded">
                        @endif
                        <p class="text-sm font-semibold text-gray-800">{{ $vote->product->name }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('admin.voters.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar
                Voters</a>
        </div>
    </div>
@endsection

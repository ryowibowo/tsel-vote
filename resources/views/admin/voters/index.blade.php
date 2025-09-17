@extends('layouts.admin')
@section('title', 'Daftar Voters')
@section('content')
    <div class="bg-white p-6 rounded-lg shadow-xl">
        <div class="mb-6">
            <a href="{{ route('admin.voters.export') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                <i class="fas fa-file-excel mr-2"></i> Export ke Excel
            </a>
        </div>
        <table id="dataTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No.</th>
                    <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-3">NIK</th>
                    <th scope="col" class="px-6 py-3">Waktu Vote</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($voters as $voter)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $voter->full_name }}</td>
                        <td class="px-6 py-4">{{ $voter->nik }}</td>
                        <td class="px-6 py-4">{{ $voter->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.voters.show', $voter->id) }}"
                                class="font-medium text-blue-600 hover:underline">Lihat Detail Vote</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10">Belum ada data voter yang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

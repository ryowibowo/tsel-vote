@extends('layouts.admin')

@section('title', 'Generate Link Sampel')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Link Generator</h2>
        <p class="text-gray-600 mb-6">Masukkan Nama dan NIK untuk membuat link voting unik. Link ini bisa dicopy dan dikirim
            manual via email.</p>

        <div class="space-y-4">
            <div>
                <label for="inputNama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="inputNama"
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm"
                    placeholder="Contoh: Budi Santoso">
            </div>
            <div>
                <label for="inputNik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" id="inputNik"
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm"
                    placeholder="Contoh: 123456789">
            </div>
            <div>
                <button id="generateBtn"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg w-full">
                    Generate Link
                </button>
            </div>
        </div>

        {{-- Hasilnya akan muncul di sini --}}
        <div id="resultSection" class="mt-8 pt-6 border-t hidden">
            <label class="block text-sm font-medium text-gray-700">Hasil Link:</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" id="outputUrl" readonly
                    class="flex-1 block w-full rounded-none rounded-l-md px-3 py-2 bg-gray-100 border-gray-300 text-gray-500">
                <button id="copyBtn"
                    class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Copy
                </button>
            </div>
        </div>
    </div>

    <script>
        // Ambil semua elemen
        const inputNama = document.getElementById('inputNama');
        const inputNik = document.getElementById('inputNik');
        const generateBtn = document.getElementById('generateBtn');
        const resultSection = document.getElementById('resultSection');
        const outputUrl = document.getElementById('outputUrl');
        const copyBtn = document.getElementById('copyBtn');

        // Siapin URL dasar dari route Laravel
        const baseUrl = "{{ route('voting.index') }}";

        generateBtn.addEventListener('click', () => {
            const nama = inputNama.value;
            const nik = inputNik.value;

            if (!nama || !nik) {
                alert('Nama dan NIK wajib diisi!');
                return;
            }

            // Encode nama biar spasi dan karakter aneh jadi aman di URL
            const encodedName = encodeURIComponent(nama);

            // Gabungin semua jadi URL final
            const finalUrl = `${baseUrl}?nik=${nik}&nama=${encodedName}`;

            // Tampilin hasilnya
            outputUrl.value = finalUrl;
            resultSection.classList.remove('hidden');
        });

        copyBtn.addEventListener('click', () => {
            outputUrl.select();
            document.execCommand('copy');

            // Kasih feedback visual
            copyBtn.textContent = 'Copied!';
            setTimeout(() => {
                copyBtn.textContent = 'Copy';
            }, 2000);
        });
    </script>
@endsection

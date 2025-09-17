<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Voter;
use App\Models\Vote; // Jangan lupa tambahin ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    public function index(Request $request)
    {
        $fixedCategory = Category::with('products')->where('name', 'FIXED')->first();
        $mobileCategory = Category::with('products')->where('name', 'MOBILE')->first();

        // 2. "Intip" URL, ada parameter 'nik' dan 'nama' nggak?
        $nikFromUrl = $request->query('nik');
        $nameFromUrl = $request->query('nama');

        // 3. Kirim semua data ke view
        return view('voting', [
            'fixedCategory' => $fixedCategory,
            'mobileCategory' => $mobileCategory,
            'nikFromUrl' => $nikFromUrl,
            'nameFromUrl' => $nameFromUrl,
        ]);
    }

    public function checkNik(Request $request)
    {
        $request->validate(['nik' => 'required|string']);

        // Cek ke tabel voters apakah NIK sudah ada.
        // exists() lebih cepet, cuma balikin true/false.
        $isExist = Voter::where('nik', $request->nik)->exists();

        return response()->json(['exists' => $isExist]);
    }

    // --- FUNGSI VOTE DIROMBAK TOTAL ---
    public function vote(Request $request)
    {
        // 1. Validasi data yang masuk dari frontend
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nik'       => 'required|string|unique:voters,nik', // Pastikan NIK belum pernah vote
            'fixed_ids' => 'required|array|size:5', // Wajib array & isinya HARUS 5
            'mobile_ids' => 'required|array|size:5', // Wajib array & isinya HARUS 5
            'fixed_ids.*' => 'exists:products,id', // Pastikan semua ID produk yang dikirim valid
            'mobile_ids.*' => 'exists:products,id',
        ]);

        // 2. Pakai Transaction: Kalau ada satu error, semua proses dibatalin. SUPER AMAN.
        DB::transaction(function () use ($request) {
            // a. Simpan dulu data orangnya ke tabel 'voters'
            $voter = Voter::create([
                'full_name' => $request->full_name,
                'nik'       => $request->nik,
            ]);

            // b. Gabungin semua 10 ID produk yang dipilih
            $allProductIds = array_merge($request->fixed_ids, $request->mobile_ids);

            // c. Simpan setiap pilihan satu per satu ke tabel 'votes'
            foreach ($allProductIds as $productId) {
                Vote::create([
                    'voter_id'   => $voter->id, // Hubungkan ke ID si voter
                    'product_id' => $productId,
                ]);
            }

            // d. Update counter di tabel 'products' secara efisien
            Product::whereIn('id', $allProductIds)->increment('votes');
        });

        // 3. Kasih tau frontend kalau semua proses berhasil
        return response()->json(['success' => true]);
    }
}

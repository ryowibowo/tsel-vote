<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Jurus baru, bre:
        // 1. Ambil semua KATEGORI.
        // 2. Untuk setiap kategori, ambil juga relasi PRODUK-nya.
        // 3. Untuk setiap produk, hitung jumlah VOTE-nya dan langsung URUTKAN.
        $categories = Category::with([
            'products' => function ($query) {
                $query->withCount('votes')->orderBy('votes_count', 'desc');
            },
        ])->get();

        // Kita juga butuh total semua vote buat ngitung persentase nanti
        $totalVotes = Vote::count();

        return view('admin.dashboard', [
            'categories' => $categories,
            'totalVotes' => $totalVotes,
        ]);
    }
}

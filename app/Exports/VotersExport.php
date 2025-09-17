<?php

namespace App\Exports;

use App\Models\Voter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VotersExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        // Ambil semua data voter, sekalian sama history vote, produk, dan kategorinya
        $voters = Voter::with(['votes.product.category'])->get();

        // Kita akan "render" data ini ke dalam sebuah file view khusus Excel
        return view('exports.voters', [
            'voters' => $voters
        ]);
    }
}

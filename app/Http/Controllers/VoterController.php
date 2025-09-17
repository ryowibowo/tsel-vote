<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use Illuminate\Http\Request;
use App\Exports\VotersExport;
use Maatwebsite\Excel\Facades\Excel;

class VoterController extends Controller
{
    public function index()
    {
        $voters = Voter::latest()->get();
        return view('admin.voters.index', ['voters' => $voters]);
    }

    public function show(Voter $voter)
    {
        $voter->load('votes.product.category');
        $groupedVotes = $voter->votes->groupBy('product.category.name');

        return view('admin.voters.show', [
            'voter' => $voter,
            'groupedVotes' => $groupedVotes
        ]);
    }

    public function export()
    {
        return Excel::download(new VotersExport, 'hasil_vote_traction_day.xlsx');
    }
}

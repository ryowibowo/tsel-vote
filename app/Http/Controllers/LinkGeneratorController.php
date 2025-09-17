<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkGeneratorController extends Controller
{
    public function index()
    {
        return view('admin.tools.link_generator');
    }
}

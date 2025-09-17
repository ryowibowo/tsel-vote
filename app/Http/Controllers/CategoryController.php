<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Fungsi buat nampilin semua kategori
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    // Fungsi buat nampilin form tambah kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // Fungsi buat nyimpen kategori baru
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // --- FUNGSI BARU UNTUK EDIT ---
    public function edit(Category $category)
    {
        // $category ini otomatis diisi Laravel sesuai ID di URL
        return view('admin.categories.edit', ['category' => $category]);
    }

    // --- FUNGSI BARU UNTUK UPDATE ---
    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);

        // Update data kategori yang ada
        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    // --- FUNGSI BARU UNTUK HAPUS ---
    public function destroy(Category $category)
    {
        // Hapus data kategori dari database
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}

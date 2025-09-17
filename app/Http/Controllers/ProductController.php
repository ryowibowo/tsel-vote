<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        // Cek apakah ada file gambar yang di-upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Bikin nama file unik biar ga bentrok
            $filename = time() . '_' . $file->getClientOriginalName();
            // Pindahin file ke public/products
            $file->move(public_path('products'), $filename);
            // Simpen path-nya buat dimasukin ke database
            $imagePath = 'products/' . $filename;
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk baru berhasil ditambahkan!');
    }

    // --- FUNGSI BARU UNTUK EDIT ---
    public function edit(Product $product)
    {
        // $product ini otomatis diisi sama Laravel sesuai ID di URL
        $categories = Category::all();
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    // --- FUNGSI BARU UNTUK UPDATE ---
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image; // Path gambar lama
        // Cek kalau ada gambar BARU yang di-upload
        if ($request->hasFile('image')) {
            // Hapus gambar LAMA biar ga numpuk
            if ($product->image) {
                File::delete(public_path($product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('products'), $filename);
            $imagePath = 'products/' . $filename; // Path gambar baru
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // --- FUNGSI BARU UNTUK HAPUS ---
    public function destroy(Product $product)
    {
        // Hapus data produk dari database
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}

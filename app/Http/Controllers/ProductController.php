<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

    
        $gambarPath = null;
        if ($request->hasFile('image')) {
            $gambarPath = $request->file('image')->store('gambar_produk', 'public');
        }
    
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $gambarPath,
        ]);
    
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            // 'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);
    
        $product = Product::findOrFail($id);
        
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        // $product->stock = $validated['stock'];
    
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('storage/product_images/' . $product->image))) {
                unlink(public_path('storage/product_images/' . $product->image));
            }
    
            $product->image = $request->file('image')->store('product_images', 'public');
        }
    
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }
    
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path('storage/' . $product->image))) {
            unlink(public_path('storage/' . $product->image));
        }
    
        $product->delete();

        return redirect()->route('products.index')->with('deleted', 'Berhasil menghapus data');
    }

    public function upgradeStock(Request $request, $id)
{


    $product = Product::find($id);
    $stock = $product->stock;


    return view('products.upgrade', compact('stock','product'));
}

public function updateStock(Request $request, $id)
{
    $request->validate([
        'stock' => 'required|numeric|min:0',
    ]);

    $product = Product::findOrFail($id);

    $product->update([
        'stock' => $request->stock,
    ]);
    return redirect()->route('products.index')->with('success', 'Stock berhasil diperbarui!');
}


}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('admin.pages.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Create Product
        $product = Product::create($request->only('name', 'description', 'price', 'stock', 'category_id'));

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imagePath = $image->store('photos/products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'is_main' => $key === 0, // Menandakan gambar pertama adalah gambar utama
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Update Product
        $product->update($request->only('name', 'description', 'price', 'stock', 'category_id'));

        // Handle image upload if available
        if ($request->hasFile('images')) {
            // Hapus gambar lama dari storage dan database
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image); // hapus file fisik
                $oldImage->delete(); // hapus dari DB
            }
            $product->images()->delete();
            foreach ($request->file('images') as $key => $image) {
                $imagePath = $image->store('photos/products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'is_main' => $key === 0, // Menandakan gambar pertama adalah gambar utama
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mencari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Jika produk memiliki gambar, hapus gambar dari storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete(); // Hapus dari database juga
        }

        // Hapus produk dari database
        $product->delete();

        // Redirect kembali ke halaman produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

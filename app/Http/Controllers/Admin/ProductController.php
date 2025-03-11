<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category', 'productDetails.color'])
            ->orderBy('id', 'asc')->get();
        $brands = Brand::all();
        $categories = Category::all();
        $colors = Color::all();

        return view('admin.products.index', compact('products', 'brands', 'categories', 'colors'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $colors = Color::all();

        return view('admin.products.create', compact('brands', 'categories', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'sometimes|boolean',
            'color_id' => 'required|exists:colors,id',
            'size' => 'required|string|max:10',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getRealPath())->getSecurePath();
            $thumbnailPath = $uploadedFileUrl;
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'status' => $request->boolean('status')
        ]);

        ProductDetail::create([
            'product_id' => $product->id,
            'color_id' => $request->color_id,
            'size' => $request->size,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::with('productDetails')->findOrFail($id);
        $brands = Brand::all();
        $categories = Category::all();
        $colors = Color::all();

        return view('admin.products.edit', compact('product', 'brands', 'categories', 'colors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'sometimes|boolean',
            'color_id' => 'required|exists:colors,id',
            'size' => 'required|string|max:10',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                $publicId = pathinfo($product->thumbnail, PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getRealPath())->getSecurePath();
            $product->thumbnail = $uploadedFileUrl;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'status' => $request->boolean('status')
        ]);

        $productDetail = ProductDetail::firstOrNew(['product_id' => $product->id]);

        if ($productDetail) {
            $productDetail->update([
                'color_id' => $request->color_id,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'quantity' => $request->quantity,
            ]);
        } else {
            ProductDetail::create([
                'product_id' => $product->id,
                'color_id' => $request->color_id,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->thumbnail) {
            preg_match('/\/v\d+\/(.+?)\.\w+$/', $product->thumbnail, $matches);
            if (!empty($matches[1])) {
                Cloudinary::destroy($matches[1]);
            }
        }

        ProductDetail::where('product_id', $id)->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = !$product->status;
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Status updated successfully!');
    }
}

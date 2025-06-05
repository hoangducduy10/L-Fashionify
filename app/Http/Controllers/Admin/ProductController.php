<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UploadProductImages;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductImage;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category', 'productDetails.color'])
            ->orderBy('id', 'asc')->get();

        return view('admin.products.index', [
            'products' => $products,
            'brands' => Brand::all(),
            'categories' => Category::all(),
            'colors' => Color::all(),
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'brands' => Brand::all(),
            'categories' => Category::all(),
            'colors' => Color::all(),
        ]);
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $uploadedFile = $request->file('thumbnail');
            $uploadResponse = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'products/thumbnails',
                'transformation' => [['quality' => 'auto', 'fetch_format' => 'auto']]
            ]);
            $thumbnailPath = $uploadResponse->getSecurePath();
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

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $storagePath = $image->store('private/uploads');
                dispatch(new UploadProductImages(Storage::path($storagePath), $product->id));
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully! Images are uploading in the background.');
    }

    public function edit($id)
    {
        $product = Product::with('productDetails')->find($id);
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $product = Product::findOrFail($id);

        // Xóa ảnh cũ trên Cloudinary nếu có
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                $publicId = pathinfo(parse_url($product->thumbnail, PHP_URL_PATH), PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            $uploadedFile = $request->file('thumbnail');
            $uploadResponse = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'products/thumbnails',
                'transformation' => [['quality' => 'auto', 'fetch_format' => 'auto']]
            ]);
            $product->thumbnail = $uploadResponse->getSecurePath();
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'status' => $request->boolean('status')
        ]);

        ProductDetail::updateOrCreate(
            ['product_id' => $product->id],
            [
                'color_id' => $request->color_id,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'quantity' => $request->quantity,
            ]
        );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $storagePath = $image->store('private/uploads');
                dispatch(new UploadProductImages(Storage::path($storagePath), $product->id));
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully! Images are uploading in the background.');
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

        $productImages = ProductImage::where('product_id', $id)->get();
        foreach ($productImages as $image) {
            if ($image->url) {
                preg_match('/\/v\d+\/(.+?)\.\w+$/', $image->url, $matches);
                if (!empty($matches[1])) {
                    $publicId = $matches[1];
                    Cloudinary::destroy($publicId);
                }
            }
        }

        ProductDetail::where('product_id', $id)->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        CloudinaryService::deleteImage($image->url);

        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = !$product->status;
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Status updated successfully!');
    }
}

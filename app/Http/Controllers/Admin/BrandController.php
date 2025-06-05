<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'asc')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'sometimes|boolean'
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getRealPath())->getSecurePath();
            $thumbnailPath = $uploadedFileUrl;
        }

        Brand::create([
            'name' => $request->name,
            'thumbnail' => $thumbnailPath,
            'status' => $request->boolean('status')
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
    }


    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'sometimes|boolean'
        ]);

        $brand = Brand::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            if ($brand->thumbnail) {
                $publicId = pathinfo($brand->thumbnail, PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getRealPath())->getSecurePath();
            $brand->thumbnail = $uploadedFileUrl;
        }

        $brand->update([
            'name' => $request->name,
            'status' => $request->boolean('status')
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
    }


    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->thumbnail) {
            $publicId = pathinfo($brand->thumbnail, PATHINFO_FILENAME);
            Cloudinary::destroy($publicId);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully!');
    }


    public function toggleStatus($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = !$brand->status;
        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Status updated successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        if ($request->ajax()) {
            return response()->json(['data' => $categories]);
        }
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        $url = null;
        $public_id = null;
        if ($request->hasFile('image')) {
            $cloudinaryImage = $request->file('image')->storeOnCloudinary('categories');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
        }
        $category = new Category([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_url' => $url,
            'image_public_id' => $public_id,
        ]);

        $category->save();

        return redirect()->route('category')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('contents')->find($id);
        if (!$category) {
            return redirect()->route('category.show')
            ->with('error', 'Category dengan ID ' . $id . ' tidak ditemukan.');
        }
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('category.edit')
            ->with('error', 'Category dengan ID ' . $id . ' tidak ditemukan.');
        }
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('category.edit')
            ->with('error', 'Content dengan Title ' . $category->title . ' tidak ditemukan.');
        }
        $validated = $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);
        if($request->hasFile('image')){
            Cloudinary::destroy($category->image_public_id);
            $cloudinaryImage = $request->file('image')->storeOnCloudinary('categories');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
            $category->update([
                'image_url' => $url,
                'image_public_id' => $public_id,
            ]);
        }
        $category->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);
        return redirect()->route('category')->with('status', 'Data category berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Content gagal dihapus. Data tidak ditemukan.',
            ], 404); // Menggunakan kode status HTTP 404 untuk resource not found
        }
        Cloudinary::destroy($category->image_public_id);
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category berhasil dihapus.',
        ], 200);
    }
}

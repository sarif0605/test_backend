<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $contents = Content::with('category', 'user')->where('user_id', $userId)->orderBy('created_at', 'DESC')->get();
        if ($request->ajax()) {
            return response()->json(['data' => $contents]);
        }
        return view('content.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id');
        return view('content.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $url = null;
        $public_id = null;

        if ($request->hasFile('image')) {
            $cloudinaryImage = $request->file('image')->storeOnCloudinary('products');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
        }

        $content = new Content([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_url' => $url,
            'image_public_id' => $public_id,
            'user_id' => $user->id,
            'category_id' => $validated['category_id']
        ]);

        $content->save();

        return redirect()->route('content')->with('success', 'Content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $content = Content::with('category', 'user', 'comments')->find($id);
        if (!$content) {
            return redirect()->route('content.show')
                ->with('error', 'Prospect dengan ID ' . $id . ' tidak ditemukan.');
        }
        $averageRating = $content->comments->avg('rating') ?? 0;
        return view('content.show', compact('content', 'averageRating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $content = Content::find($id);
        $categories = Category::pluck('title', 'id');
        if (!$content) {
            return redirect()->route('content.edit')
            ->with('error', 'Content dengan ID ' . $id . ' tidak ditemukan.');
        }
        return view('content.edit', compact('content', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $content = Content::find($id);
        if (!$content) {
            return redirect()->route('content.edit')
            ->with('error', 'Content dengan Title ' . $content->title . ' tidak ditemukan.');
        }
        $validated = $request->validate([
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        if($request->hasFile('image')){
            Cloudinary::destroy($content->image_public_id);
            $cloudinaryImage = $request->file('image')->storeOnCloudinary('products');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
            $content->update([
                'image_url' => $url,
                'image_public_id' => $public_id,
            ]);
        }
        $content->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id']
        ]);
        return redirect()->route('content')->with('status', 'Data content berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $content = Content::find($id);

        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Content gagal dihapus. Data tidak ditemukan.',
            ], 404);
        }
        Cloudinary::destroy($content->image_public_id);
        $content->delete();
        return response()->json([
            'success' => true,
            'message' => 'Content berhasil dihapus.',
        ], 200);
    }
}
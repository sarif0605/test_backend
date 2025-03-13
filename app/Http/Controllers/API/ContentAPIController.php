<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ContentAPIController extends Controller
{
    public function showThreeContent()
    {
        try {
            $contents = Content::with('user', 'category')
                ->orderBy('created_at', 'DESC')
                ->take(3)
                ->get();

            return response()->json([
                'success' => true,
                'message' => count($contents) > 0 ? 'Berhasil mengambil data' : 'Data masih kosong',
                'data' => $contents
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id){
        $content = Content::with('user', 'category', 'comments')->find($id);
        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $content
        ]);
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 8);
        $searchQuery = $request->input('query');
        $contentsQuery = Content::with('user', 'category');
        if ($searchQuery) {
            $contentsQuery->where(function (Builder $builder) use ($searchQuery) {
                $builder->where('title', 'like', '%' . $searchQuery . '%')
                        ->orWhere('content', 'like', '%' . $searchQuery . '%');
            });
        }
        $contents = $contentsQuery->paginate($size, ['*'], 'page', $page);
        return response()->json([
            'success' => true,
            'data' => $contents,
        ]);
    }
}
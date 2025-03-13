<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CategoryAPIController extends Controller
{
    public function showAll()
    {
        try {
            $categpry = Category::orderBy('created_at', 'DESC')
                ->get();
            return response()->json([
                'success' => true,
                'message' => count($categpry) > 0 ? 'Berhasil mengambil data' : 'Data masih kosong',
                'data' => $categpry
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
        $categpry = Category::with('contents')->find($id);
        if (!$categpry) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $categpry
        ]);
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 8);
        $searchQuery = $request->input('query');
        $categoryQuery = Category::query();
        if ($searchQuery) {
            $categoryQuery->where(function (Builder $builder) use ($searchQuery) {
                $builder->where('title', 'like', '%' . $searchQuery . '%')
                        ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }
        $contents = $categoryQuery->paginate($size, ['*'], 'page', $page);
        return response()->json([
            'success' => true,
            'data' => $contents,
        ]);
    }
}

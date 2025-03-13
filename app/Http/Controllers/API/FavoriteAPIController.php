<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteAPIController extends Controller
{
    public function addFavorite(Request $request)
    {
        $validatedData = $request->validate([
            'content_id' => 'required|exists:contents,id' // Sesuaikan dengan tabel yang digunakan
        ]);
        $user = auth()->user();
        // Cek apakah sudah ada di favorit
        $favorite = Favorite::firstOrCreate([
            'user_id' => $user->id,
            'content_id' => $validatedData['content_id']
        ]);
        return response()->json([
            'message' => 'Added to favorites successfully',
            'data' => new FavoriteResource($favorite)
        ], 201);
    }

    // Hapus dari favorit
    public function removeFavorite(Request $request)
    {
        $validatedData = $request->validate([
            'content_id' => 'required|exists:contents,id'
        ]);
        $user = auth()->user();

        // Hapus dari favorit jika ada
        $favorite = Favorite::where('user_id', $user->id)
            ->where('content_id', $validatedData['content_id'])
            ->first();

        if (!$favorite) {
            return response()->json([
                'message' => 'Favorite not found'
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Removed from favorites successfully'
        ], 200);
    }

    // List favorit user
    public function getFavorites()
    {
        $user = auth()->user();
        $favorites = Favorite::with('content')->where('user_id', $user->id)->get();
        return response()->json([
            'message' => 'Success',
            'data' => FavoriteResource::collection($favorites)
        ]);
    }

}

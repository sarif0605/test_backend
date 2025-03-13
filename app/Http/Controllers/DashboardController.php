<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isPemateri = $user->role == 'pemateri';

        // Query Builder untuk filtering berdasarkan user jika pemateri
        $contentQuery = Content::query();
        if ($isPemateri) {
            $contentQuery->where('user_id', $user->id);
        }

        // Hitung jumlah konten bulan ini
        $contentThisMonth = (clone $contentQuery)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Ambil 3 gambar terbaru
        $threeImages = (clone $contentQuery)
            ->whereNotNull('image_url')
            ->latest('created_at')
            ->take(3)
            ->get();

        // Hitung jumlah konten per bulan dengan kondisi user jika pemateri
        $monthlyContentCount = Content::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->when($isPemateri, fn($query) => $query->where('user_id', $user->id)) // Filter jika pemateri
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Inisialisasi array 12 bulan dengan nilai 0
        $contentData = array_fill(0, 12, 0);
        foreach ($monthlyContentCount as $month => $count) {
            $contentData[$month - 1] = $count; // Bulan di array 0-based
        }

        // Nama bulan dalam format full (January, February, ...)
        $monthNames = array_map(fn($i) => Carbon::create()->month($i)->format('F'), range(1, 12));

        return view('dashboard', [
            'contentThisMonth' => $contentThisMonth,
            'contentData' => $contentData,
            'labels' => $monthNames,
            'images' => $threeImages
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BannerClick;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard() {
    $memberCount = DB::table('add_members')->count();
    $chapterCount = DB::table('chapters')->count(); // ✅ Added chapter count
    return view('admin.dashboard', [
        'memberCount' => $memberCount,
        'chapterCount' => $chapterCount, // ✅ Pass it to the view
    ]);
}

    

    public function logout(Request $request)
{
    Auth::logout(); // Logout the user
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate CSRF token

    return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
}

public function viewBannerClicks(Request $request)
{
    $query = BannerClick::query();

    if ($request->filled('type')) {
        $query->where('banner_type', $request->type);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('updated_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('updated_at', '<=', $request->end_date);
    }

    // Main data for table
    $clicks = $query->orderByDesc('click_count')->get();

    // Grouped data for chart
    $clickSummary = (clone $query)
        ->select('banner_type', DB::raw('SUM(click_count) as total_clicks'))
        ->groupBy('banner_type')
        ->get();

    return view('admin.banner_clicks', compact('clicks', 'clickSummary'));
}


    public function exportBannerClicks(): StreamedResponse
    {
        $fileName = 'banner_clicks_' . now()->format('Ymd_His') . '.csv';
        $clicks = BannerClick::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($clicks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Banner Type', 'Image Path', 'Redirect URL', 'Click Count', 'Created At']);

            foreach ($clicks as $click) {
                fputcsv($handle, [
                    $click->id,
                    $click->banner_type,
                    $click->image_path,
                    $click->redirect_url,
                    $click->click_count,
                    $click->created_at,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }


}

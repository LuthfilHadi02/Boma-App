<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Facility;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Pendapatan per bulan (12 bulan terakhir)
        $pendapatanBulanan = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $pendapatanBulanan[] = [
                'label'  => $date->format('M Y'),
                'amount' => Payment::where('status', 'paid')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('amount'),
            ];
        }

        // Booking per olahraga
        $bookingPerOlahraga = Booking::join('facilities', 'bookings.facility_id', '=', 'facilities.id')
            ->selectRaw('facilities.type, COUNT(*) as total')
            ->groupBy('facilities.type')
            ->pluck('total', 'type')
            ->toArray();

        // Lapangan tersibuk
        $lapanganTersibuk = Facility::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        // Statistik bulan ini
        $thisMonth = [
            'pendapatan' => Payment::where('status', 'paid')
                ->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('amount'),
            'booking'    => Booking::whereYear('created_at', $year)->whereMonth('created_at', $month)->count(),
            'user_baru'  => User::whereYear('created_at', $year)->whereMonth('created_at', $month)->count(),
        ];

        // User baru per bulan
        $userBulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $userBulanan[] = [
                'label' => $date->format('M Y'),
                'count' => User::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(),
            ];
        }

        return view('admin.analytics.index', compact(
            'pendapatanBulanan', 'bookingPerOlahraga', 'lapanganTersibuk', 'thisMonth', 'userBulanan', 'year', 'month'
        ));
    }

    public function exportPdf(Request $request)
    {
        // Requires barryvdh/laravel-dompdf
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        $payments  = Payment::with('booking.facility', 'booking.user')
            ->where('status', 'paid')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $total = $payments->sum('amount');
        $label = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $html = view('admin.analytics.export-pdf', compact('payments', 'total', 'label'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return $pdf->download("laporan-keuangan-{$year}-{$month}.pdf");
        }

        return response($html)->header('Content-Type', 'text/html');
    }
}
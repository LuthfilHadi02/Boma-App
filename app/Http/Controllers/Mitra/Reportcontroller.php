<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    private function facilityIds(): array
    {
        $mitra = Auth::user()->mitra;
        if (!$mitra) return [];
        return Facility::where('mitra_id', $mitra->id)->pluck('id')->toArray();
    }

    public function index(Request $request)
    {
        $facilityIds = $this->facilityIds();
        $year  = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Pendapatan per bulan (6 bulan terakhir)
        $pendapatanBulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $pendapatanBulanan[] = [
                'label'  => $date->format('M Y'),
                'amount' => Payment::where('status', 'paid')
                    ->whereHas('booking', fn($q) => $q->whereIn('facility_id', $facilityIds))
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('amount'),
            ];
        }

        // Detail transaksi bulan ini
        $transaksi = Payment::with('booking.facility', 'booking.user')
            ->where('status', 'paid')
            ->whereHas('booking', fn($q) => $q->whereIn('facility_id', $facilityIds))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->get();

        $totalBulanIni = $transaksi->sum('amount');

        return view('mitra.reports.index', compact('pendapatanBulanan', 'transaksi', 'totalBulanIni', 'year', 'month'));
    }
}
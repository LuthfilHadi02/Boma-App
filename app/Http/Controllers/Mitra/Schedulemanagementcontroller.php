<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleManagementController extends Controller
{
    private function mitraFacilities()
    {
        $mitra = Auth::user()->mitra;
        if (!$mitra) return collect();
        return Facility::where('mitra_id', $mitra->id)->get();
    }

    public function index()
    {
        $facilities = $this->mitraFacilities();
        $facilityIds = $facilities->pluck('id');
        $schedules = Schedule::with('facility')->whereIn('facility_id', $facilityIds)->orderBy('facility_id')->orderBy('day_of_week')->get();

        return view('mitra.schedules.index', compact('facilities', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'day_of_week' => 'required|string',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);

        $this->authorizeFacility($request->facility_id);

        Schedule::create([
            'facility_id'  => $request->facility_id,
            'day_of_week'  => $request->day_of_week,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'is_available' => true,
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $this->authorizeFacility($schedule->facility_id);

        $request->validate([
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'is_available' => 'boolean',
        ]);

        $schedule->update($request->only(['start_time', 'end_time', 'is_available']));

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorizeFacility($schedule->facility_id);
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    private function authorizeFacility(int $facilityId): void
    {
        $ids = $this->mitraFacilities()->pluck('id')->toArray();
        abort_unless(in_array($facilityId, $ids), 403, 'Akses ditolak.');
    }
}
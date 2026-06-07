<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Latihan Saya - BOMA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col justify-between">

@include('partials.navbar')

    <main class="flex-1 container mx-auto px-4 py-10 max-w-5xl">
        <div class="mb-8">
            <div class="inline-block bg-teal-100 text-teal-800 text-xs font-bold px-3 py-1 rounded-full mb-2">
                DATA AKTIVITAS ATLET
            </div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Agenda Latihan Yang Lu Ikuti</h1>
            <p class="text-sm text-gray-500 mt-1">Berikut daftar jadwal latihan resmi divisi Badan Olahraga Mahasiswa yang telah Anda daftarkan.</p>
        </div>

        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl flex items-center shadow-sm">
                <span class="mr-2 text-base">✅</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Agenda / Divisi</th>
                            <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                            <th class="px-6 py-4">Jam Latihan</th>
                            <th class="px-6 py-4">Lokasi GOR / Tempat</th>
                            <th class="px-6 py-4 text-center">Status Kehadiran</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700 font-medium">
                        @forelse($mySchedules as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-400 font-normal">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <span class="p-2 bg-teal-50 text-[#008774] rounded-lg text-xs">🏟️</span>
                                        <span class="font-bold text-gray-900">{{ $item->title }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 border border-gray-200 text-gray-800 rounded-lg text-xs font-semibold whitespace-nowrap shadow-3xs">
                                        <i class="far fa-clock text-gray-400 text-sm"></i> 
                                        {{ $item->time ?? '16.00 - 18.00' }} WIB
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 font-normal">
                                    {{ $item->location ?? 'Lapangan Kampus UPI di Cibiru' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        
                                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs whitespace-nowrap">
                                            <i class="fas fa-check-circle mr-1 text-emerald-500"></i> Terdaftar Resmi
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form id="form-batal-{{ $item->id }}" action="{{ route('jadwal.batal', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="button" onclick="konfirmasiBatal('{{ $item->id }}')" class="inline-flex items-center justify-center text-xs bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg border border-red-200 transition cursor-pointer shadow-3xs whitespace-nowrap">
                                            <i class="fas fa-trash-alt mr-1 text-red-500"></i> Batalkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                                    <span class="text-4xl block mb-3">🏋️‍♂️</span>
                                    <h3 class="text-sm font-semibold text-gray-800">Lu Belum Daftar Latihan Apa-apa bray</h3>
                                    <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">Silahkan buka Kalender Latihan BOMA lalu pilih tanggal yang ada eventnya buat gabung latihan bray!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

@include('partials.footer-mini')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function konfirmasiBatal(id) {
        Swal.fire({
            title: 'Apakah Lu Beneran Mau Batal? ⚠️',
            text: "Sisa kuota latihan bakal dilepas dan orang lain bisa ngerebut slot lu lho, bray!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#008774',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Gak Jadi',
            customClass: { popup: 'rounded-2xl' }
        }).then((result) => {
            // Kalau user klik "Ya, Batalkan!", submit form-nya secara otomatis bray!
            if (result.isConfirmed) {
                document.getElementById('form-batal-' + id).submit();
            }
        });
    }
</script>   
</body>
</html>
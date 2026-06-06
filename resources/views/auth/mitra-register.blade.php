<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mitra GOR - BOMA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-['Poppins'] min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="w-full max-w-xl bg-white rounded-2xl shadow-xl border border-slate-100 p-8 space-y-6 my-8">
        
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-bold text-[#008774] tracking-tight">Kemitraan GOR BOMA</h2>
            <p class="text-sm text-slate-500">Isi data akun dan legalitas GOR lu dengan lengkap untuk divalidasi Admin.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-3 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-sm shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Ditambahkan enctype karena ada upload dokumen berkas -->
        <form action="{{ route('mitra.register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <!-- SEKSI 1 -->
            <div class="relative flex py-2 items-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                <div class="flex-grow border-t border-dashed border-slate-200"></div>
                <span class="flex-shrink mx-3">1. Akun Pengelola</span>
                <div class="flex-grow border-t border-dashed border-slate-200"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Nama Lengkap</label>
                    <div class="relative flex items-center">
                        <i class="fa-solid fa-user absolute left-4 text-slate-400 text-sm"></i>
                        <input type="text" name="name" placeholder="Mursyid Daniswara" value="{{ old('name') }}" required
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Email Resmi</label>
                    <div class="relative flex items-center">
                        <i class="fa-solid fa-envelope absolute left-4 text-slate-400 text-sm"></i>
                        <input type="email" name="email" placeholder="owner@gor.com" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Password</label>
                    <div class="relative flex items-center">
                        <i class="fa-solid fa-lock absolute left-4 text-slate-400 text-sm"></i>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" required
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Ulangi Password</label>
                    <div class="relative flex items-center">
                        <i class="fa-solid fa-shield absolute left-4 text-slate-400 text-sm"></i>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi" required
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                    </div>
                </div>
            </div>

            <!-- SEKSI 2 -->
            <div class="relative flex py-2 items-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                <div class="flex-grow border-t border-dashed border-slate-200"></div>
                <span class="flex-shrink mx-3">2. Profil & Berkas GOR</span>
                <div class="flex-grow border-t border-dashed border-slate-200"></div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-semibold text-slate-700">Nama Bisnis GOR / Arena</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-building-flag absolute left-4 text-slate-400 text-sm"></i>
                    <input type="text" name="brand_name" placeholder="Contoh: GOR Futsal Bersaudara" value="{{ old('brand_name') }}" required
                        class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-semibold text-slate-700">Alamat Lengkap Arena</label>
                <div class="relative flex items-start">
                    <i class="fa-solid fa-map-location-dot absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                    <textarea name="address" rows="2" placeholder="Jl. Raya Cibiru No. 123, Kabupaten Bandung..." required
                        class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700 resize-none">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Nama Bank</label>
                    <input type="text" name="bank_name" placeholder="BCA / Mandiri" value="{{ old('bank_name') }}" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                </div>
                <div class="space-y-1 sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-700">Nomor Rekening Pencairan</label>
                    <input type="text" name="bank_account_number" placeholder="Contoh: 7831412xxx" value="{{ old('bank_account_number') }}" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-semibold text-slate-700">Nama Pemilik Rekening</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-id-card-clip absolute left-4 text-slate-400 text-sm"></i>
                    <input type="text" name="bank_account_name" placeholder="Harus sesuai buku tabungan" value="{{ old('bank_account_name') }}" required
                        class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white focus:ring-4 focus:ring-teal-500/10 text-slate-700">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-semibold text-slate-700">Dokumen Identitas / SIUP (PDF/JPG, Max 2MB)</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-file-shield absolute left-4 text-slate-400 text-sm"></i>
                    <input type="file" name="identity_document" required
                        class="w-full pl-11 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-[#008774] focus:bg-white file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-[#008774] hover:file:bg-teal-100 text-slate-500">
                </div>
            </div>

            <button type="submit" 
                class="w-full py-3 bg-[#008774] hover:bg-[#006a5b] text-white font-semibold text-sm rounded-xl shadow-lg transition-all active:scale-[0.98] mt-4">
                Ajukan Kemitraan GOR
            </button>
        </form>

        <div class="text-center text-xs text-slate-500">
            Sudah memiliki akun mitra? <a href="{{ route('login') }}" class="text-[#008774] font-semibold hover:underline">Log In disini</a>
        </div>

    </div>

</body>
</html>
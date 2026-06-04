<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kemitraan Disetujui</title>
</head>
<body style="background-color: #f4f4f5; font-family: 'Segoe UI', sans-serif; padding: 30px;">
    <div style="max-width: 550px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 40px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #008774; margin: 0; font-size: 24px;">BOMA UPI CIBIRU</h2>
        </div>
        <hr style="border: 0; border-top: 1px dashed #e2e8f0; margin-bottom: 25px;">
        
        <h3 style="color: #1e293b; margin-top: 0;">Halo, {{ $mitra->user->name }}!👋</h3>
        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Kabar gembira! Tim verifikator Badan Olahraga Mahasiswa (BOMA) UPI Cibiru telah selesai memeriksa berkas legalitas GOR Anda.
        </p>
        
        <div style="background-color: #f1f5f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <table style="width: 100%; font-size: 14px; color: #334155;">
                <tr><td><strong>Nama GOR:</strong></td><td>{{ $mitra->brand_name }}</td></tr>
                <tr><td><strong>Status Kemitraan:</strong></td><td style="color: #059669; font-weight: bold;">RESMI DISETUJUI (APPROVED)</td></tr>
            </table>
        </div>

        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Sekrung lapak Anda sudah aktif di sistem. Silakan masuk ke dashboard untuk mulai mendaftarkan lapangan olahraga Anda agar bisa langsung disewa oleh ratusan tim mahasiswa!
        </p>

        <div style="text-align: center; margin-top: 30px;">
            <a href="http://127.0.0.1:8000/login" style="background-color: #008774; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">Masuk ke Dashboard Mitra</a>
        </div>

        <hr style="border: 0; border-top: 1px dashed #e2e8f0; margin-top: 35px; margin-bottom: 15px;">
        <p style="color: #94a3b8; font-size: 11px; text-align: center; margin: 0;">Email ini dikirim otomatis oleh Sistem Booking BOMA Aplikasi Integrated Core.</p>
    </div>
</body>
</html>
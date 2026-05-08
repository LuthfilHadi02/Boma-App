// === FITUR GANTI GAMBAR GALERI ===
function changeImage(thumbElement) {
    // Ambil gambar utama
    const mainImage = document.getElementById('mainImage');
    
    // Ganti source gambar utama dengan source thumbnail yang di-klik
    mainImage.src = thumbElement.src;

    // Hapus efek "active" (border hijau) dari semua thumbnail
    const thumbs = document.querySelectorAll('.thumb');
    thumbs.forEach(t => t.classList.remove('active'));

    // Tambahin efek "active" ke thumbnail yang baru aja di-klik
    thumbElement.classList.add('active');
}

// === FITUR KALKULATOR HARGA BOOKING ===
function hitungTotal() {
    // Misal harga per jamnya Rp 100.000
    const hargaPerJam = 100000;
    
    // Ambil value durasi yang dipilih user dari dropdown
    const selectDurasi = document.getElementById('durasiSelect');
    const jam = parseInt(selectDurasi.value);

    // Hitung total
    const total = hargaPerJam * jam;

    // Format angkanya ke bentuk Rupiah
    const formatRupiah = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(total);

    // Tembak hasilnya ke elemen HTML
    document.getElementById('totalHarga').innerText = formatRupiah;
}
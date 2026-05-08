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

// Pura-puranya jam 19:00 dan 20:00 udah dipesen sama anak sipil
const jamPenuh = [19, 20]; 
const jamBuka = 8;   // Buka jam 08:00
const jamTutup = 23; // Tutup jam 23:00

function updatePilihanJam() {
    const selectDurasi = document.getElementById('durasiSelect');
    const selectJam = document.getElementById('jamSelect');
    
    // Ambil durasi yang dipilih (ubah ke angka)
    const durasi = parseInt(selectDurasi.value);

    // Kosongin opsi jam setiap kali user ganti durasi
    selectJam.innerHTML = '<option value="" selected disabled>Pilih jam mulai ...</option>';

    if (!durasi) return; // Kalau belum milih durasi, stop aja

    // Looping dari jam buka, TAPI berhentinya dikurangin durasi biar ga bablas lewat jam tutup
    // Contoh: Tutup jam 23, main 2 jam. Maksimal start jam 21.
    for (let i = jamBuka; i <= jamTutup - durasi; i++) {
        let jamMulai = i.toString().padStart(2, '0') + ':00';
        let jamSelesai = (i + durasi).toString().padStart(2, '0') + ':00';

        let opsiBaru = document.createElement('option');
        opsiBaru.value = jamMulai;
        opsiBaru.text = `${jamMulai} - ${jamSelesai}`;

        // LOGIKA BENTROK: Ngecek apakah dalam rentang waktu main, ada jam yang udah "Penuh"
        let isBentrok = false;
        for (let j = 0; j < durasi; j++) {
            if (jamPenuh.includes(i + j)) {
                isBentrok = true;
                break;
            }
        }

        // Kalau nabrak jadwal orang, matiin opsinya!
        if (isBentrok) {
            opsiBaru.disabled = true;
            opsiBaru.text += " (Jadwal Bentrok / Penuh)";
        }

        // Masukin ke HTML
        selectJam.appendChild(opsiBaru);
    }
}


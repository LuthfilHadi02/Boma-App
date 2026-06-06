document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. LOGIKA DROPDOWN PROFILE ---
    const profileTrigger = document.querySelector('.profile-trigger');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (profileTrigger && dropdownMenu) {
        profileTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Biar klik nggak langsung tembus ke window
            dropdownMenu.classList.toggle('show');
            profileTrigger.classList.toggle('active');
        });

        // Klik di mana saja buat nutup dropdown
        window.addEventListener('click', function(e) {
            if (!profileTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                profileTrigger.classList.remove('active');
            }
        });
    } else {
        // Cek ini cuma pas lu lagi kodingan doang
        console.warn("Info: Elemen dropdown tidak ditemukan, mungkin sedang tidak login.");
    }

    // --- 2. LOGIKA TOMBOL SEARCH FILTER ---
    const btnSearch = document.querySelector('.btn-search');
    if (btnSearch) {
        btnSearch.addEventListener('click', function() {
            const tgl = document.getElementById('filterTanggal')?.value;
            const cabang = document.getElementById('filterCabang')?.value;
            const kecamatan = document.getElementById('filterKecamatan')?.value;

            if (!tgl && !cabang && !kecamatan) {
                alert("Pilih minimal satu filter dulu pak (Tanggal, Cabang, atau Kecamatan)!");
                return;
            }
            
            // Contoh aksi: Bisa lu ganti ke redirect URL atau AJAX nanti
            alert(`Mencari Lapangan:\n📅 Tanggal: ${tgl || 'Semua'}\n🏃 Cabang: ${cabang || 'Semua'}\n📍 Kec: ${kecamatan || 'Semua'}`);
        });
    }
});
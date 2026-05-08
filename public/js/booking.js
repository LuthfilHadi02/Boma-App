document.addEventListener('DOMContentLoaded', function() {
    
// =========================================
    // 1. LOGIKA DROPDOWN PROFILE
    // =========================================
    const profileTrigger = document.querySelector('.profile-trigger');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (profileTrigger && dropdownMenu) {
        profileTrigger.addEventListener('click', function(e) {
            e.preventDefault(); 
            dropdownMenu.classList.toggle('show'); 
            profileTrigger.classList.toggle('active'); 
            
        });

        window.addEventListener('click', function(e) {
            if (!profileTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                profileTrigger.classList.remove('active');
            }
        });
    } else {
        console.error("Waduh, elemen profile-trigger atau dropdown-menu nggak ketemu di HTML!");
    }

    // =========================================
    // 2. LOGIKA KLIK KARTU LAPANGAN
    // =========================================
    // Ambil semua card yang ada di grid-banyak maupun grid-4
    const fieldCards = document.querySelectorAll('.card-img-overlay, .card-standard');
    
    fieldCards.forEach(card => {
        // Ubah kursor jadi tangan biar user tau ini bisa diklik
        card.style.cursor = 'pointer'; 
        
        card.addEventListener('click', function() {
            // Ambil nama lapangan dari tag <h3> di dalem card yang diklik
            const namaLapangan = this.querySelector('h3').innerText;
            
            // ALERT DUMMY (Nanti ini diganti jadi redirect ke halaman detail)
            // Contoh redirect Laravel nanti: window.location.href = `/booking/${id}`;
            alert(`Sabar pak, halaman detail buat ${namaLapangan} lagi dibikin!`);
        });
    });

// =========================================
    // 3. LOGIKA TOMBOL SEARCH FILTER
    // =========================================
    const btnSearch = document.querySelector('.btn-search');
    
    if (btnSearch) {
        btnSearch.addEventListener('click', function() {
            // Tangkap semua isi inputannya
            const tgl = document.getElementById('filterTanggal').value;
            const cabang = document.getElementById('filterCabang').value;
            const kecamatan = document.getElementById('filterKecamatan').value;

            // Validasi simpel: Kalau kosong semua, ingetin
            if (!tgl && !cabang && !kecamatan) {
                alert("Pilih minimal satu filter dulu pak (Tanggal, Cabang, atau Kecamatan)!");
                return;
            }

            // Kalau ada isinya, munculin pop-up data (Nanti ini diganti jadi narik data dari database)
            alert(`Mencari Lapangan:\n\n📅 Tanggal: ${tgl ? tgl : 'Semua Hari'}\n🏃 Cabang: ${cabang ? cabang : 'Semua Olahraga'}\n📍 Kecamatan: ${kecamatan ? kecamatan : 'Semua Area'}`);
        });
    }

});
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalKegiatan');
    const step1 = document.getElementById('stepKonfirmasi');
    const step2 = document.getElementById('stepDataDiri');
    const modalTitle = document.getElementById('modalTitle');
    const modalSub = document.getElementById('modalSub');

    // Munculin modal pas tanggal diklik (selalu balik ke Step 1)
    window.openModal = function() {
        step1.style.display = 'block';
        step2.style.display = 'none';
        modalTitle.innerText = "Daftar Kegiatan";
        modalSub.innerText = "Selasa, 14 April 2026";
        modal.style.display = 'flex';
    };

    // Fungsi transisi ke Form Data Diri
    window.showFormDiri = function() {
        step1.style.display = 'none'; // Sembunyiin konfirmasi
        step2.style.display = 'block'; // Munculin form
        modalTitle.innerText = "Isi Data Diri"; 
        modalSub.innerText = "Latihan Basket"; 
    };

    // Tutup modal
    window.closeModal = function() {
        modal.style.display = 'none';
    };

    // Pasang event klik ke semua kotak tanggal
    document.querySelectorAll('.date-cell').forEach(cell => {
        cell.onclick = window.openModal;
    });

    // Tutup modal kalau klik area luar
    window.onclick = function(event) {
        if (event.target == modal) {
            window.closeModal();
        }
    };
});
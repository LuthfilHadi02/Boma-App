'use strict';

document.addEventListener('DOMContentLoaded', function () {
    console.log("BOMA Admin Workspace Engine Loaded successfully.");

    // Sederhana: Tambahkan penanganan efek klik transisi halus pada menu sidebar
    const sidebarLinks = document.querySelectorAll('.boma-sidebar .nav-link');
    
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Hapus kelas aktif dari link menu sebelumnya
            sidebarLinks.forEach(item => item.classList.remove('active'));
            // Tambahkan kelas aktif ke menu yang sedang di klik
            this.classList.add('active');
        });
    });
});
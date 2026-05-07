document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================
    // 0. MINI DATABASE JADWAL (DUMMY DATA)
    // =========================================
    // Ingat: Bulan di JS dimulai dari 0. Jadi April = 3, Mei = 4, dst.
    const dataJadwal = [
        { tgl: 14, bulan: 3, tahun: 2026, kegiatan: "Latihan Basket", tempat: "Lapangan Kampus UPI di Cibiru", gambar: "/src/Basket.png" },
        { tgl: 20, bulan: 3, tahun: 2026, kegiatan: "Jadwal Futsal", tempat: "GOR Gymnasium UPI", gambar: "/src/Futsal.png" },
        // Gua tambahin 1 jadwal di bulan Mei buat lu ngetes ganti bulan
        { tgl: 5, bulan: 4, tahun: 2026, kegiatan: "Latihan Bulu Tangkis", tempat: "Hall Badminton Kampus", gambar: "/src/BuluTangkis.png" } 
    ];


    // =========================================
    // 1. LOGIKA KALENDER DINAMIS
    // =========================================
    const daysContainer = document.getElementById("calendar-days");
    const currentDateElement = document.querySelector(".calendar-month");
    const prevNextIcon = document.querySelectorAll(".nav-arrow");

    let date = new Date();
    let currYear = date.getFullYear();
    let currMonth = date.getMonth();

    const months = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];

    const renderCalendar = () => {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay();
        let startDay = firstDayofMonth === 0 ? 6 : firstDayofMonth - 1;
        let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
        let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay();
        let endDay = lastDayofMonth === 0 ? 6 : lastDayofMonth - 1;
        let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

        let daysHTML = "";

        // Tanggal redup bulan sebelumnya
        for (let i = startDay; i > 0; i--) {
            daysHTML += `<div class="date-cell faded">${lastDateofLastMonth - i + 1}</div>`;
        }

        // Tanggal bulan sekarang
        for (let i = 1; i <= lastDateofMonth; i++) {
            
            // CARI JADWAL DI DATABASE MINI
            // Ngecek: Apakah di tanggal (i), bulan (currMonth), dan tahun (currYear) ini ada data jadwal?
            let jadwalHariIni = dataJadwal.find(j => j.tgl === i && j.bulan === currMonth && j.tahun === currYear);

            if (jadwalHariIni) {
                // JIKA ADA JADWAL: Kasih warna gelap, kasih nama kegiatan, dan BISA DIKLIK
                daysHTML += `<div class="date-cell dark-event" onclick="window.openModal(${i}, ${currMonth}, ${currYear}, '${jadwalHariIni.kegiatan}', '${jadwalHariIni.tempat}', '${jadwalHariIni.gambar}')">
                                ${i}
                                <span class="tiny-text">${jadwalHariIni.kegiatan}</span>
                             </div>`;
            } else {
                // JIKA KOSONG: Tampil angka biasa, GABISA DIKLIK
                daysHTML += `<div class="date-cell">${i}</div>`;
            }
        }

        // Tanggal redup bulan depannya
        for (let i = endDay; i < 6; i++) {
            daysHTML += `<div class="date-cell faded">${i - endDay + 1}</div>`;
        }

        currentDateElement.innerText = `${months[currMonth]} ${currYear}`;
        daysContainer.innerHTML = daysHTML;
    }

    renderCalendar();

    // Fungsi ganti bulan
    prevNextIcon.forEach((icon, index) => {
        icon.addEventListener("click", () => {
            if (index === 0) {
                currMonth--; 
            } else {
                currMonth++; 
            }
            
            if (currMonth < 0) {
                currMonth = 11; 
                currYear--;     
            } else if (currMonth > 11) {
                currMonth = 0;  
                currYear++;     
            }
            renderCalendar();
        });
    });


    // =========================================
    // 2. LOGIKA MODAL POP-UP
    // =========================================
    const modal = document.getElementById('modalKegiatan');
    const step1 = document.getElementById('stepKonfirmasi');
    const step2 = document.getElementById('stepDataDiri');

    // Tangkap data yang dikirim dari HTML
    window.openModal = function(tanggal, bulanIndex, tahun, namaKegiatan, tempat, gambar) {
        step1.style.display = 'block';
        step2.style.display = 'none';
        
        let formatWaktu = `${tanggal} ${months[bulanIndex]} ${tahun}`;

        // Ubah teks Header Modal
        document.getElementById('modalTitle').innerText = "Daftar Kegiatan";
        document.getElementById('modalSub').innerText = formatWaktu;
        
        // Ubah isi Konten Modal (Biar dinamis!)
        document.getElementById('modalAgenda').innerText = namaKegiatan;
        document.getElementById('modalWaktu').innerText = formatWaktu;
        document.getElementById('modalTempat').innerText = tempat;
        document.getElementById('modalImg').src = gambar;

        modal.style.display = 'flex';
        // Tambahin ini biar tiap buka modal, animasinya mulai dari awal lagi
        const container = modal.querySelector('.modal-container');
    container.style.animation = 'none';
    container.offsetHeight; /* pancing browser buat refresh */
    container.style.animation = 'moveIn 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards';
    };

    window.showFormDiri = function() {
        step1.style.display = 'none';
        step2.style.display = 'block';
        document.getElementById('modalTitle').innerText = "Isi Data Diri"; 
        document.getElementById('modalSub').innerText = "Formulir Pendaftaran"; 
    };

    window.closeModal = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            window.closeModal();
        }
    };
});


//validasi input user
window.validasiDanKirim = function() {
    // Ambil nilai dari input
    const nama = document.getElementById('inputNama').value.trim();
    const prodi = document.getElementById('inputProdi').value.trim();
    const angkatan = document.getElementById('inputAngkatan').value.trim();

    // Cek satu-satu
    if (nama === "" || prodi === "" || angkatan === "") {
        alert('Silahkan isi data diri dengan benar!');
    } else {
        // Kalau semua aman
        alert(`${nama}! Terima kasih telah mendaftar untuk sesi latihan ini.`);
        closeModal();
        
        // Reset form biar pas buka lagi udah kosong
        document.querySelector('.form-diri').reset();
    }
};
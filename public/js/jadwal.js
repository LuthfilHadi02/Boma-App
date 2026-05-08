document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================
    // 1. LOGIKA KALENDER DINAMIS
    // =========================================
    const daysContainer = document.getElementById("calendar-days");
    const currentDateElement = document.querySelector(".calendar-month");
    const prevNextIcon = document.querySelectorAll(".nav-arrow");

    let date = new Date();
    // Gua paksa mulai dari Mei 2026 biar pas demo datanya langsung keliatan
    let currYear = 2026; 
    let currMonth = 4; // 4 itu Mei (0 = Januari)

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
            
            // FORMAT TANGGAL SESUAI DATABASE: YYYY-MM-DD
            let strBulan = (currMonth + 1).toString().padStart(2, '0');
            let strTgl = i.toString().padStart(2, '0');
            let fullDate = `${currYear}-${strBulan}-${strTgl}`;

            // CEK DI DATABASE (dataJadwalDB dikirim dari Blade)
            let jadwalHariIni = window.dataJadwalDB ? window.dataJadwalDB[fullDate] : null;

            if (jadwalHariIni) {
                // JIKA ADA JADWAL DB: BISA DIKLIK (Kirim data lengkap ke modal)
                daysHTML += `<div class="date-cell dark-event" 
                                onclick="window.openModal('${jadwalHariIni.id}', '${jadwalHariIni.title}', '${fullDate}', '${jadwalHariIni.time}', '${jadwalHariIni.location}', ${jadwalHariIni.current_quota}, ${jadwalHariIni.max_quota})">
                                ${i}
                                <span class="tiny-text">${jadwalHariIni.title}</span>
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
            currMonth = index === 0 ? currMonth - 1 : currMonth + 1;
            if (currMonth < 0 || currMonth > 11) {
                date = new Date(currYear, currMonth, new Date().getDate());
                currYear = date.getFullYear();
                currMonth = date.getMonth();
            } else {
                date = new Date();
            }
            renderCalendar();
        });
    });

    // =========================================
    // 2. LOGIKA MODAL POP-UP (Pake Data Database)
    // =========================================
    const modal = document.getElementById('modalKegiatan');
    const step1 = document.getElementById('stepKonfirmasi');
    const step2 = document.getElementById('stepDataDiri');

    // Nangkep data lemparan dari klik Kalender
    window.openModal = function(id, namaKegiatan, tanggalDb, jam, tempat, current_quota, max_quota) {
        step1.style.display = 'block';
        step2.style.display = 'none';
        
        // Ubah Teks Modal
        document.getElementById('modalTitle').innerText = "Daftar Kegiatan";
        document.getElementById('modalSub').innerText = tanggalDb;
        document.getElementById('modalAgenda').innerText = namaKegiatan;
        document.getElementById('modalWaktu').innerText = jam;
        document.getElementById('modalTempat').innerText = tempat;
        
        // Default gambar kegiatan
        document.getElementById('modalImg').src = "/src/Futsal.png";

        // URUSAN LOGIKA KUOTA & TOMBOL
        const persentase = (current_quota / max_quota) * 100;
        document.getElementById('kuotaTeks').innerText = `${current_quota}/${max_quota} Terisi`;
        document.getElementById('kuotaBar').style.width = `${persentase}%`;
        
        const btnLanjut = document.getElementById('btnLanjutIsiData');
        
        // Set Action Form-nya ngarah ke Database Laravel
        document.getElementById('formIkutLatihan').action = `/jadwal/ikut/${id}`;

        if(current_quota >= max_quota) {
            // PENUH!
            document.getElementById('kuotaBar').style.background = '#FF4B4B'; 
            document.getElementById('kuotaPeringatan').style.display = 'block';
            btnLanjut.style.background = '#94a3b8';
            btnLanjut.innerText = 'Kuota Habis';
            btnLanjut.disabled = true; // Gak bisa lanjut ke step form
        } else {
            // AMAN!
            document.getElementById('kuotaBar').style.background = '#059669'; 
            document.getElementById('kuotaPeringatan').style.display = 'none';
            btnLanjut.style.background = ''; // Balik ke CSS asli
            btnLanjut.innerText = 'Ya';
            btnLanjut.disabled = false; // Bisa diklik ke form
        }

        modal.style.display = 'flex';

        // Pancing refresh animasi css
        const container = modal.querySelector('.modal-container');
        container.style.animation = 'none';
        container.offsetHeight; 
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

// =========================================
// 3. STICKY NAVBAR TRANSISI
// =========================================
const navbar = document.querySelector('.navbar');
    
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.style.background = 'rgba(0, 135, 116, 0.9)'; // Hijau transparan
        navbar.style.backdropFilter = 'blur(10px)';
        navbar.style.height = '70px';
        navbar.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
    } else {
        navbar.style.background = '#008774'; // Warna asli CSS lu
        navbar.style.backdropFilter = 'none';
        navbar.style.height = '80px';
        navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    }
    navbar.style.transition = 'all 0.3s ease';
});
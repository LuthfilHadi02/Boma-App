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
    }
    
    // =========================================
    // 2. LOGIKA KALENDER DINAMIS SAKTI (ANTI-BUG)
    // =========================================
    const daysContainer = document.getElementById("calendar-days");
    const currentDateElement = document.querySelector(".calendar-month");
    const prevNextIcon = document.querySelectorAll(".nav-arrow");

    // FIX UTAMA: Kalender otomatis ngebaca bulan berjalan sekarang (JUNI 2026) bray!
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

        for (let i = startDay; i > 0; i--) {
            daysHTML += `<div class="date-cell faded">${lastDateofLastMonth - i + 1}</div>`;
        }

        for (let i = 1; i <= lastDateofMonth; i++) {
            let strBulan = (currMonth + 1).toString().padStart(2, '0');
            let strTgl = i.toString().padStart(2, '0');
            let fullDate = `${currYear}-${strBulan}-${strTgl}`;

            // Ngebaca array hasil groupBy dari backend Controller bray
            let jadwalHariIni = window.dataJadwalDB ? window.dataJadwalDB[fullDate] : null;

            if (jadwalHariIni && jadwalHariIni.length > 0) {
                let eventUtama = jadwalHariIni[0]; 
                
                daysHTML += `<div class="date-cell dark-event" style="cursor:pointer;"
                                onclick="window.openModal('${eventUtama.id}', '${eventUtama.title}', '${fullDate}', '${eventUtama.time}', '${eventUtama.location}', ${eventUtama.current_quota}, ${eventUtama.max_quota})">
                                ${i}
                                <span class="tiny-text">${eventUtama.title}</span>
                             </div>`;
            } else {
                daysHTML += `<div class="date-cell">${i}</div>`;
            }
        }

        for (let i = endDay; i < 6; i++) {
            daysHTML += `<div class="date-cell faded">${i - endDay + 1}</div>`;
        }

        currentDateElement.innerText = `${months[currMonth]} ${currYear}`;
        daysContainer.innerHTML = daysHTML;
    }

    renderCalendar();

    prevNextIcon.forEach((icon, index) => {
        icon.addEventListener("click", () => {
            currMonth = index === 0 ? currMonth - 1 : currMonth + 1;
            if (currMonth < 0 || currMonth > 11) {
                date = new Date(currYear, currMonth, 1);
                currYear = date.getFullYear();
                currMonth = date.getMonth();
            }
            renderCalendar();
        });
    });

    // =========================================
    // 3. LOGIKA MODAL POP-UP (CLEAN DARI ELEMENT HANTU)
    // =========================================
    const modal = document.getElementById('modalKegiatan');
    const step1 = document.getElementById('stepKonfirmasi');

    window.openModal = function(id, namaKegiatan, tanggalDb, jam, tempat, current_quota, max_quota) {
        
        // 🛡️ CEGATAN LOGIN MAHASISWA
        if (!window.isUserLoggedIn) {
            Swal.fire({
                title: 'Akses Terkunci, Cuy!',
                text: 'Lu wajib masuk/login menggunakan akun Mahasiswa terlebih dahulu kalau mau melihat detail agenda atau gabung ke jadwal latihan divisi BOMA.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#008774',
                cancelButtonColor: '#ef4444',
                confirmButtonText: '<i class="fas fa-sign-in-alt"></i> Login Sekarang',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/login";
                }
            });
            return;
        }

        // Jalankan transian modal bray
        if (step1) step1.style.display = 'block';
        
        document.getElementById('modalTitle').innerText = "Daftar Kegiatan Latihan";
        document.getElementById('modalSub').innerText = tanggalDb;
        document.getElementById('modalAgenda').innerText = namaKegiatan;
        document.getElementById('modalWaktu').innerText = jam;
        document.getElementById('modalTempat').innerText = tempat;
        
        // Gambar dinamis bray
        let imgTag = document.getElementById('modalImg');
        if (imgTag) {
            imgTag.src = namaKegiatan.toLowerCase().includes('basket') ? "/src/Basket.png" : "/src/Futsal.png";
        }

        // Hitung Progress Bar Kuota Latihan bray
        const persentase = (current_quota / max_quota) * 100;
        document.getElementById('kuotaTeks').innerText = `${current_quota}/${max_quota} Terisi`;
        document.getElementById('kuotaBar').style.width = `${persentase}%`;
        
        const btnLanjut = document.getElementById('btnLanjutIsiData');
        const formAction = document.getElementById('formIkutLatihan');
        
        if (formAction) {
            formAction.action = `/jadwal/ikut/${id}`;
        }

        // Pengunci tombol jika kuota penuh pak bray
        if(current_quota >= max_quota) {
            document.getElementById('kuotaBar').style.background = '#FF4B4B'; 
            document.getElementById('kuotaPeringatan').style.display = 'block';
            if (btnLanjut) {
                btnLanjut.style.background = '#94a3b8';
                btnLanjut.innerText = 'Kuota Habis';
                btnLanjut.disabled = true;
            }
        } else {
            document.getElementById('kuotaBar').style.background = '#059669'; 
            document.getElementById('kuotaPeringatan').style.display = 'none';
            if (btnLanjut) {
                btnLanjut.style.background = ''; 
                btnLanjut.innerText = 'Ya, Ikut!';
                btnLanjut.disabled = false;
            }
        }

        if (modal) modal.style.display = 'flex';

        const container = modal.querySelector('.modal-container');
        if (container) {
            container.style.animation = 'none';
            container.offsetHeight; 
            container.style.animation = 'moveIn 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards';
        }
    };

    window.closeModal = function() {
        if (modal) modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            window.closeModal();
        }
    };

    // =========================================
    // 4. STICKY NAVBAR TRANSISI
    // =========================================
    const navbar = document.querySelector('.navbar');
        
    window.addEventListener('scroll', () => {
        if (!navbar) return;
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(0, 135, 116, 0.9)'; 
            navbar.style.backdropFilter = 'blur(10px)';
            navbar.style.height = '70px';
            navbar.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        } else {
            navbar.style.background = '#008774'; 
            navbar.style.backdropFilter = 'none';
            navbar.style.height = '80px';
            navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        }
        navbar.style.transition = 'all 0.3s ease';
    });
});
document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================
    // 1. LOGIKA DROPDOWN PROFILE
    // =========================================
    const profileTrigger = document.querySelector('.profile-trigger');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (profileTrigger && dropdownMenu) {
        profileTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Amankan dari pemicu klik luar area
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
    // 2. CEGATAN LOGIN SWEETALERT (CARD LAPANGAN)
    // =========================================
    const cardLinks = document.querySelectorAll('.card-link');
    
    cardLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Paksa matikan dulu jalur bawaan HTML biar SweetAlert / Navigasi terkontrol penuh
            e.preventDefault(); 
            
            const isAuth = this.getAttribute('data-auth') === 'true';
            const detailUrl = this.getAttribute('href'); // Ambil rute /detail-lapangan/id
            
            if (!isAuth) {
                Swal.fire({
                    title: 'Akses Terkunci, Cuy!',
                    text: 'Lu wajib masuk/login menggunakan akun Mahasiswa terlebih dahulu kalau mau booking lapangan di BOMA App.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#008774',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: '<i class="fas fa-sign-out-alt"></i> Login Sekarang',
                    cancelButtonText: 'Kembali',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/login'; // Lempar ke halaman login
                    }
                });
            } else {
                // SUNTIKAN FIX UTAMA: Kalau sudah login, gas terbang ke halaman detail!
                window.location.href = detailUrl;
            }
        });
    });

    // =========================================
    // 3. LOGIKA TOMBOL SEARCH FILTER (ATAS)
    // =========================================
    const btnSearch = document.querySelector('.btn-search');
    if (btnSearch) {
        btnSearch.addEventListener('click', function() {
            const tgl = document.getElementById('filterTanggal').value;
            const cabang = document.getElementById('filterCabang').value;
            const kecamatan = document.getElementById('filterKecamatan').value;

            if (!tgl && !cabang && !kecamatan) {
                alert("Pilih minimal satu filter dulu pak (Tanggal, Cabang, atau Kecamatan)!");
                return;
            }
            alert(`Mencari Lapangan:\n\n📅 Tanggal: ${tgl ? tgl : 'Semua Hari'}\n🏃 Cabang: ${cabang ? cabang : 'Semua Olahraga'}\n📍 Kecamatan: ${kecamatan ? kecamatan : 'Semua Area'}`);
        });
    }

    // =========================================
    // 4. LIVE SEARCH INPUT (FILTER KATEGORI)
    // =========================================
    const searchInput = document.querySelector('.search-btn input');
    const searchTargets = document.querySelectorAll('.card, .visi-box, .misi-box, .section-title, .footer-col');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            searchTargets.forEach(target => {
                const text = target.innerText.toLowerCase();
                if (text.includes(searchTerm)) {
                    target.style.display = 'block';
                    target.style.opacity = '1';
                } else {
                    target.style.display = 'none'; // Ubah dari '' ke 'none' biar beneran ilang pas disaring bray
                }
            });
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = e.target.value.toLowerCase();
                const firstMatch = Array.from(searchTargets).find(target => {
                    return target.innerText.toLowerCase().includes(searchTerm) && 
                           target.style.display !== 'none';
                });

                if (firstMatch) {
                    window.scrollTo({
                        top: firstMatch.offsetTop - 100,
                        behavior: 'smooth'
                    });
                    
                    firstMatch.style.outline = '2px solid #008774';
                    setTimeout(() => { firstMatch.style.outline = 'none'; }, 2000);
                }
            }
        });
    }

    // =========================================
    // 5. SMOOTH SCROLL MENU
    // =========================================
    document.querySelectorAll('.nav-links a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // =========================================
    // 6. REVEAL ANIMATION (MUNCUL PAS SCROLL)
    // =========================================
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.card, .visi-box, .misi-box').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(40px)';
        el.style.transition = 'all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1)';
        revealObserver.observe(el);
    });
});

// =========================================
// 7. STICKY NAVBAR (DI LUAR DOM CONTENT LOADED BIAR GERAK CEPET)
// =========================================
const navbar = document.querySelector('.navbar');
if (navbar) {
    window.addEventListener('scroll', () => {
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
}

// Global function bray biar gak skoping eror
window.toggleMitraWidget = function(event) {
    if(event) {
        event.stopPropagation();
    }
    const popCard = document.getElementById('mitraPopCard');
    if (popCard) {
        if(popCard.classList.contains('show-widget')) {
            popCard.classList.remove('show-widget');
            setTimeout(() => { popCard.style.display = 'none'; }, 200);
        } else {
            popCard.style.display = 'block';
            setTimeout(() => { popCard.classList.add('show-widget'); }, 10);
        }
    }
}
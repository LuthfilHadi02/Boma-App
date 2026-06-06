 document.addEventListener('DOMContentLoaded', function() {
            // 1. LOGIKA DROPDOWN PROFILE
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

            // 2. LOGIKA TOMBOL SEARCH FILTER
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
        });

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

    const cardLinks = document.querySelectorAll('.card-link');
    
    cardLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const isAuth = this.getAttribute('data-auth') === 'true';
            
            if (!isAuth) {
                e.preventDefault(); // Batalkan pindah halaman
                Swal.fire({
                    title: 'Oops!',
                    text: 'Login dulu ya buat booking lapangan!',
                    icon: 'warning',
                    confirmButtonText: 'Login Sekarang',
                    confirmButtonColor: '#008774'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/login'; // Lempar ke halaman login
                    }
                });
            }
        });
    });
});
    
    // =========================================
    // 1. STICKY NAVBAR (HIJAU TRANSISI)
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

    // =========================================
    // 2. LIVE SEARCH (FILTER KATEGORI)
    // =========================================

    const searchInput = document.querySelector('.search-btn input');
    
    // Target yang mau lu cari (Card Kategori, Visi Misi, Berita)
    const searchTargets = document.querySelectorAll('.card, .visi-box, .misi-box, .section-title, .footer-col');

    if (searchInput) {
        // 1. FUNGSI FILTER (Pas Ngetik)
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            searchTargets.forEach(target => {
                const text = target.innerText.toLowerCase();
                if (text.includes(searchTerm)) {
                    target.style.display = 'block'; // Atau sesuai display aslinya (flex/grid)
                    target.style.opacity = '1';
                } else {
                    target.style.display = '';
                }
            });
        });

        // 2. FUNGSI ENTER & AUTO-SCROLL
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = e.target.value.toLowerCase();
                
                // Cari elemen pertama yang "masih kelihatan" dan cocok sama keyword
                const firstMatch = Array.from(searchTargets).find(target => {
                    return target.innerText.toLowerCase().includes(searchTerm) && 
                           target.style.display !== '';
                });

                if (firstMatch) {
                    window.scrollTo({
                        top: firstMatch.offsetTop - 100, // Offset biar gak kepentok navbar
                        behavior: 'smooth'
                    });
                    
                    // Kasih highlight dikit biar user tau itu hasilnya
                    firstMatch.style.outline = '2px solid var(--accent-color)';
                    setTimeout(() => { firstMatch.style.outline = 'none'; }, 2000);
                }
            }
        });
    }

    // =========================================
    // 3. SMOOTH SCROLL MENU
    // =========================================
    document.querySelectorAll('.nav-links a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Offset tinggi navbar
                    behavior: 'smooth'
                });
            }
        });
    });

    // =========================================
    // 4. REVEAL ANIMATION (MUNCUL PAS SCROLL)
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


    function toggleMitraWidget(event) {
        if(event) {
            event.stopPropagation(); // Biar pas ngeklik tombol close gak memicu trigger buka lagi
        }
        const popCard = document.getElementById('mitraPopCard');
        
        if(popCard.classList.contains('show-widget')) {
            popCard.classList.remove('show-widget');
            setTimeout(() => { popCard.style.display = 'none'; }, 200);
        } else {
            popCard.style.display = 'block';
            setTimeout(() => { popCard.classList.add('show-widget'); }, 10);
        }
    }


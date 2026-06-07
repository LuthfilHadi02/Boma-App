{{-- resources/views/partials/footer.blade.php --}}
<footer class="site-footer" id="articles">
    <div class="container">
        <div class="footer-grid">
            
            <div class="footer-col">
                <h4>BADAN OLAHRAGA MAHASISWA</h4>
                <p class="footer-address">
                    Jl. Pendidikan No.15, Cibiru Wetan, <br>
                    Kec. Cileunyi, Kabupaten Bandung, <br>
                    Jawa Barat 40625.
                </p>
                <div class="copyright-bottom">
                    © 2026 BOMA UPI Cibiru.
                </div>
            </div>

            <div class="footer-col">
                <h4>TENTANG KAMI</h4>
                <ul>
                    {{-- 🚀 LOGIKA PINTER: Kalau di home otomatis smooth scroll, kalau di luar home otomatis terbang balik ke home bray --}}
                    <li><a href="{{ Request::is('/') ? '#profil' : url('/#profil') }}">Data Atlet & Staff</a></li>
                    <li><a href="{{ Request::is('/') ? '#recent' : url('/#recent') }}">Dokumentasi Kegiatan</a></li>
                    <li><a href="{{ Request::is('/') ? '#kategori' : url('/#kategori') }}">E-Learning Olahraga</a></li>
                    <li><a href="{{ Request::is('/') ? '#articles' : url('/#articles') }}">Ikatan Alumni BOMA</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>KONTAK KAMI</h4>
                <div class="contact-info">
                    <p><i class="fa-solid fa-envelope"></i> boma@upicibiru.ac.id</p>
                    <p><i class="fa-solid fa-phone"></i> (022) 7801332</p>
                </div>
                <div class="social-pills">
                    <a href="https://www.instagram.com/boma_upicibiru/" target="_blank" class="pill">
                        <i class="fa-brands fa-instagram"></i> Instagram
                    </a>
                    <a href="#" class="pill">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://www.youtube.com/@KampusUPI" target="_blank" class="pill">
                        <i class="fa-brands fa-youtube"></i> YouTube
                    </a>
                </div>
            </div>

        </div>
    </div>
</footer>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lapangan - BOMA</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}"> 
</head>
<body>

    <header class="navbar">
        <div class="container nav-content">
            <div class="logo-area">
                <img src="https://via.placeholder.com/50x50/ffffff/008774?text=BOMA" alt="Logo">
                <div>Badan Olahraga<br>Mahasiswa</div>
            </div>
            <nav class="nav-links">
                <a href="#">MyProfil</a>
                <a href="#">BOMA</a>
                <a href="#">Visi Misi</a>
                <a href="#">Divisi</a>
                <a href="#">Berita</a>
                <a href="#">Jadwal Latihan</a>
                <a href="#" class="active">Sewa Lapangan</a>
                <a href="#">Tentang Kami</a>
                <a href="#" class="logout">Logout</a>
            </nav>
            <div class="nav-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search">
            </div>
        </div>
    </header>

    <main class="container detail-container">
        
        <div class="detail-header">
            <h1>Triditi Futsal Corner</h1>
            <div class="subtitle">
                <i class="fa-solid fa-location-dot"></i> Kota Bandung &nbsp;|&nbsp; 
                <span class="stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                </span> 
                <span class="reviews-count">(340 reviews)</span>
            </div>
        </div>

        <div class="detail-layout">
            <div class="content-left">
                
                <div class="gallery">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1000&q=80" alt="Main" class="main-img" id="mainImage">
                    <div class="thumbnails">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=300&q=80" alt="Thumb 1" class="thumb active" onclick="changeImage(this)">
                        <img src="https://images.unsplash.com/photo-1551958219-acbc608c6aff?auto=format&fit=crop&w=300&q=80" alt="Thumb 2" class="thumb" onclick="changeImage(this)">
                        <img src="https://images.unsplash.com/photo-1511886929837-354d827aae26?auto=format&fit=crop&w=300&q=80" alt="Thumb 3" class="thumb" onclick="changeImage(this)">
                    </div>
                </div>

                <section class="info-section">
                    <h2>Description</h2>
                    <p>Triditi Futsal Corner - Sport Centre Terbesar di Kota Bandung.</p>
                    <ul class="simple-list">
                        <li><i class="fa-regular fa-futbol"></i> 2 Lapangan Futsal</li>
                        <li><i class="fa-solid fa-mug-hot"></i> Fasilitas makan & minum, main kapan saja tanpa khawatir cuaca</li>
                        <li><i class="fa-solid fa-users"></i> Cocok untuk latihan, sparing, atau sekadar fun game</li>
                        <li><i class="fa-solid fa-phone"></i> More Info: 0812-3456-7890</li>
                    </ul>

                    <h3 class="aturan-title">Aturan Umum</h3>
                    <ol class="aturan-list">
                        <li>Sewa/reservasi bersifat final dan tidak dapat dikembalikan atau diganti dengan uang.</li>
                        <li>Pemain wajib hadir tepat waktu. Keterlambatan permainan mengikuti sisa dari jam yang disewakan.</li>
                        <li>Pemain bertanggung jawab atas barang pribadi masing-masing. BOMA tidak bertanggung jawab atas kehilangan atau kerusakan.</li>
                        <li>Penggunaan sandal di dalam area lapangan dilarang.</li>
                        <li>Perkelahian atau tindakan merusak ketertiban di lapangan tidak diperbolehkan.</li>
                        <li>Dilarang meludah, merokok, mengunyah permen karet, atau membawa makanan ke dalam lapangan.</li>
                        <li>Jika lapangan tidak bisa digunakan karena kendala dari tim kami, pelanggan yang sudah booking diperkenankan reschedule sesuai ketersediaan lapangan.</li>
                        <li>Jika menyewa untuk acara/event, maka pihak penyewa harus mendaftarkan list nama yang akan datang.</li>
                    </ol>
                </section>

                <section class="info-section">
                    <h2>Fasilitas</h2>
                    <div class="fasilitas-grid">
                        <div class="fas-item"><i class="fa-solid fa-square-parking"></i> Free Parkir</div>
                        <div class="fas-item"><i class="fa-solid fa-utensils"></i> Tersedia Makanan dan Minuman</div>
                        <div class="fas-item"><i class="fa-solid fa-restroom"></i> WC / Toilet</div>
                        <div class="fas-item"><i class="fa-solid fa-couch"></i> Tempat Yang Nyaman</div>
                        <div class="fas-item"><i class="fa-solid fa-video"></i> CCTV</div>
                    </div>
                    
                    <a href="#" class="gmaps-link">Buka di Gmaps</a>
                    <div class="map-container">
                        <img src="https://via.placeholder.com/800x300/e2e8f0/64748b?text=Peta+Google+Maps" alt="Map">
                        <div class="map-pin"><i class="fa-solid fa-location-dot"></i></div>
                    </div>
                </section>

                <section class="info-section">
                    <h2>Ulasan</h2>
                    <div class="rating-summary">
                        <span class="rating-score">4,30</span>
                        <span class="rating-total">/ 5 (340 Ulasan)</span>
                    </div>
                    <div class="stars big-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke" style="color: #cbd5e1;"></i>
                    </div>

                    <div class="review-filters">
                        <div class="filter-btn"><i class="fa-solid fa-filter"></i> Filter by:</div>
                        <select><option>Rekomendasi</option></select>
                        <select><option>Kecamatan</option></select>
                        <select><option>Rating</option></select>
                        <div class="search-review">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Search Review">
                        </div>
                    </div>

                    <div class="review-list">
                        <div class="review-item">
                            <img src="https://via.placeholder.com/50" alt="User" class="avatar">
                            <div class="review-content">
                                <div class="rev-header">
                                    <div>
                                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                        <h4>Mark G <i class="fa-solid fa-circle-check" style="color: #3b82f6;"></i></h4>
                                        <span class="rev-date">2 Oktober 2025</span>
                                    </div>
                                    <div class="helpful-btn">Helpful? <span>Yes</span></div>
                                </div>
                                <h5>Bagus Sekali</h5>
                                <p>Layanannya memuaskan, sangat bersih.</p>
                            </div>
                        </div>
                        <hr>
                        <div class="review-item">
                            <img src="https://via.placeholder.com/50" alt="User" class="avatar">
                            <div class="review-content">
                                <div class="rev-header">
                                    <div>
                                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                        <h4>Ahmad <i class="fa-solid fa-circle-check" style="color: #3b82f6;"></i></h4>
                                        <span class="rev-date">10 Oktober 2025</span>
                                    </div>
                                    <div class="helpful-btn">Helpful? <span>Yes</span></div>
                                </div>
                                <h5>Bagus Saja</h5>
                                <p>Penjaga nya kurang ramah.</p>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="#" style="color: #008774; text-decoration: none; font-weight: 500;">Lihat Lebih Banyak</a>
                    </div>
                </section>
            </div>

            <div class="sidebar-right">
                <div class="booking-card">
                    <h3>Booking</h3>
                    
                    <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-box">
                            <input type="date" value="2026-05-14">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Booking Jam/Sesi</label>
                        <div class="input-box">
                            <select id="durasiSelect" onchange="hitungTotal()">
                                <option value="1">Pilih durasi ... (1 Jam)</option>
                                <option value="2">2 Jam</option>
                                <option value="3">3 Jam</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Pilih Jam</label>
                        <div class="input-box">
                            <select>
                                <option>Pilih jam mulai ...</option>
                                <option>19:00 - 20:00</option>
                                <option>20:00 - 21:00</option>
                            </select>
                        </div>
                    </div>

                    <div class="price-calc">
                        <p>Total Booking</p>
                        <h2 id="totalHarga">Rp 100.000</h2>
                    </div>

                    <button class="btn-confirm">Konfirmasi Booking</button>
                    <button class="btn-wishlist"><i class="fa-regular fa-heart"></i> Save To Wishlist</button>
                </div>
            </div>
        </div>

        <section class="nearby-section">
            <h2>Lapangan Terdekat</h2>
            <div class="nearby-grid">
                <div class="nearby-card">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=400&q=80" alt="Lapangan">
                    <div class="nc-content">
                        <h4>Triditi Futsal Corner Area A</h4>
                        <div class="nc-info"><i class="fa-regular fa-clock"></i> Duration 2 hours</div>
                        <div class="nc-info"><i class="fa-solid fa-car"></i> Transport Facility</div>
                        <div class="nc-info"><i class="fa-solid fa-users"></i> Family Plan</div>
                        
                        <div class="nc-footer">
                            <div class="stars-mini"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span style="font-size:10px; color:#999; margin-left:5px;">500 reviews</span></div>
                            <div class="nc-price">$35.00 <br><span>per session</span></div>
                        </div>
                    </div>
                </div>
                <div class="nearby-card">
                    <img src="https://images.unsplash.com/photo-1551958219-acbc608c6aff?auto=format&fit=crop&w=400&q=80" alt="Lapangan">
                    <div class="nc-content">
                        <h4>Futsal Erlangga Premium</h4>
                        <div class="nc-info"><i class="fa-regular fa-clock"></i> Duration 2 hours</div>
                        <div class="nc-info"><i class="fa-solid fa-car"></i> Transport Facility</div>
                        <div class="nc-info"><i class="fa-solid fa-users"></i> Family Plan</div>
                        <div class="nc-footer">
                            <div class="stars-mini"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span style="font-size:10px; color:#999; margin-left:5px;">320 reviews</span></div>
                            <div class="nc-price">$35.00 <br><span>per session</span></div>
                        </div>
                    </div>
                </div>
                <div class="nearby-card">
                    <img src="https://images.unsplash.com/photo-1511886929837-354d827aae26?auto=format&fit=crop&w=400&q=80" alt="Lapangan">
                    <div class="nc-content">
                        <h4>Rabbani Basket Indoor</h4>
                        <div class="nc-info"><i class="fa-regular fa-clock"></i> Duration 2 hours</div>
                        <div class="nc-info"><i class="fa-solid fa-car"></i> Transport Facility</div>
                        <div class="nc-info"><i class="fa-solid fa-users"></i> Family Plan</div>
                        <div class="nc-footer">
                            <div class="stars-mini"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span style="font-size:10px; color:#999; margin-left:5px;">150 reviews</span></div>
                            <div class="nc-price">$55.00 <br><span>per session</span></div>
                        </div>
                    </div>
                </div>
                <div class="nearby-card">
                    <img src="https://images.unsplash.com/photo-1629851606558-7c8dd76e2cba?auto=format&fit=crop&w=400&q=80" alt="Lapangan">
                    <div class="nc-content">
                        <h4>Gor Hidayat VIP Court</h4>
                        <div class="nc-info"><i class="fa-regular fa-clock"></i> Duration 2 hours</div>
                        <div class="nc-info"><i class="fa-solid fa-car"></i> Transport Facility</div>
                        <div class="nc-info"><i class="fa-solid fa-users"></i> Family Plan</div>
                        <div class="nc-footer">
                            <div class="stars-mini"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span style="font-size:10px; color:#999; margin-left:5px;">80 reviews</span></div>
                            <div class="nc-price">$55.00 <br><span>per session</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="container">
            </div>
    </footer>

    <script src="{{ asset('js/detail.js') }}"></script>
</body>
</html>
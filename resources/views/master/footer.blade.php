<!-- Footer Start -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-main">
            <div class="footer-brand-block">
                <a class="footer-brand" href="{{ route('home') }}" aria-label="Balai Air Tanah">
                    <img src="{{ asset('images/logo-pu.png') }}" alt="Logo Kementerian Pekerjaan Umum">
                    <span>
                        <strong>Balai Air Tanah</strong>
                        <small>Direktorat Jenderal Sumber Daya Air</small>
                    </span>
                </a>
                <p>
                    Pusat layanan teknis air tanah untuk mendukung pengelolaan, pengujian, pengkajian,
                    dan konservasi air tanah secara berkelanjutan.
                </p>
                <div class="footer-social-links" aria-label="Media sosial Balai Air Tanah">
                    <ul>
                        <li><a href="https://x.com/pupr_sda" target="_blank" rel="noopener noreferrer" aria-label="X"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.instagram.com/pu_sda_balaiairtanah/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.facebook.com/p/balaiairtanah-100063971832730/" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.youtube.com/@pu_sda" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>

            <nav class="footer-link-block" aria-label="Tautan profil">
                <h3>Profil</h3>
                <ul>
                    <li><a href="{{ route('profil.index') }}">Profil Balai</a></li>
                    <li><a href="{{ route('profil.tugas_dan_fungsi') }}">Tugas dan Fungsi</a></li>
                    <li><a href="{{ route('profil.visi_misi') }}">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('profil.lokasi_dan_kontak') }}">Lokasi dan Kontak</a></li>
                </ul>
            </nav>

            <nav class="footer-link-block" aria-label="Tautan layanan">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="{{ route('pelayanan_publik.standar_pelayanan') }}">Standar Pelayanan</a></li>
                    <li><a href="{{ route('pelayanan_publik.permintaan_pelayanan') }}">Permintaan Pelayanan</a></li>
                    <li><a href="{{ route('pelayanan_publik.e_ppid') }}">E-PPID</a></li>
                    <li><a href="{{ route('pelayanan_publik.layanan_pengaduan') }}">Layanan Pengaduan</a></li>
                </ul>
            </nav>

            <address class="footer-contact-block">
                <h3>Hubungi Kami</h3>
                <ul>
                    <li>
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <span>Jl. Ir. H. Juanda No.193, Dago, Coblong, Kota Bandung, Jawa Barat 40135</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <a href="tel:+622220463967">(022) 20463967</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <a href="mailto:balaiairtanah@pu.go.id">balaiairtanah@pu.go.id</a>
                    </li>
                </ul>
            </address>
        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} Balai Air Tanah. Seluruh hak cipta dilindungi.</p>
            <a href="https://sda.pu.go.id/" target="_blank" rel="noopener noreferrer">Direktorat Jenderal Sumber Daya Air</a>
        </div>
    </div>
</footer>
<!-- Footer End -->

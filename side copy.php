<style>
    .app-brand-logo {
        width: 44px;
        height: 22px;
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.php" class="app-brand-link">
            <img src="./assets/img/branding/logo.png" alt="Nama Logo" class="app-brand-logo demo">
            <span class="app-brand-text demo menu-text fw-bold ms-2">Zieda Bakery</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z" fill="currentColor" fill-opacity="0.6" />
                <path d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z" fill="currentColor" fill-opacity="0.38" />
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- BERANDA -->
        <li class="menu-item" id="menu-beranda">
            <a href="home.php" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div>Beranda</div>
            </a>
        </li>
        <!-- HISTORY -->
        <li class="menu-item" id="menu-history">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-history"></i>
                <div>History</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" id="menu-history-login">
                    <a href="history_login.php" class="menu-link">History Login</a>
                </li>
                <li class="menu-item" id="menu-history-entri">
                    <a href="history_entri.php" class="menu-link">History Entri</a>
                </li>
            </ul>
        </li>
        <!-- DATA MASTER -->
        <li class="menu-item" id="menu-data-master">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-database"></i>
                <div>Data Master</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" id="menu-data-info">
                    <a href="info.php" class="menu-link">Data Info</a>
                </li>
                <li class="menu-item" id="menu-data-petugas">
                    <a href="petugas.php" class="menu-link">Data Petugas</a>
                </li>
                <li class="menu-item" id="menu-data-donatur">
                    <a href="donatur.php" class="menu-link">Data Donatur</a>
                </li>
                <li class="menu-item" id="menu-wilayah-kerja">
                    <a href="#" class="menu-link">Wilayah Kerja</a>
                </li>
                <li class="menu-item" id="menu-data-kaleng">
                    <a href="#" class="menu-link">Data Kaleng</a>
                </li>
            </ul>
        </li>
        <!-- PETUGAS -->
        <li class="menu-item" id="menu-petugas">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-account"></i>
                <div>Petugas</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" id="menu-lap-per-tanggal">
                    <a href="#" class="menu-link">Lap. Per Tanggal</a>
                </li>
                <li class="menu-item" id="menu-lap-per-bulan">
                    <a href="#" class="menu-link">Lap. Per Bulan</a>
                </li>
                <li class="menu-item" id="menu-lap-per-tahun">
                    <a href="#" class="menu-link">Lap. Per Tahun</a>
                </li>
                <li class="menu-item" id="menu-lap-per-kecamatan">
                    <a href="#" class="menu-link">Lap. Per Kecamatan</a>
                </li>
                <li class="menu-item" id="menu-lap-per-desa">
                    <a href="#" class="menu-link">Lap. Per Desa</a>
                </li>
                <li class="menu-item" id="menu-lap-peringkat-kecamatan">
                    <a href="#" class="menu-link">Lap. Peringkat Kecamatan</a>
                </li>
                <li class="menu-item" id="menu-lap-peringkat-petugas">
                    <a href="#" class="menu-link">Lap. Peringkat Petugas</a>
                </li>
            </ul>
        </li>
        <!-- KASIR -->
        <li class="menu-item" id="menu-kasir">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-cash"></i>
                <div>Kasir</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" id="menu-input-kaleng">
                    <a href="#" class="menu-link">Input Kaleng</a>
                </li>
                <li class="menu-item" id="menu-konfirmasi-setor">
                    <a href="#" class="menu-link">Konfirmasi Setor</a>
                </li>
            </ul>
        </li>
        <!-- PENGELUARAN -->
        <li class="menu-item" id="menu-pengeluaran">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-currency-usd"></i>
                <div>Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" id="menu-data-tujuan-pengeluaran">
                    <a href="#" class="menu-link">Data Tujuan Pengeluaran</a>
                </li>
                <li class="menu-item" id="menu-data-pengeluaran">
                    <a href="#" class="menu-link">Data Pengeluaran</a>
                </li>
                <li class="menu-item" id="menu-lap-per-tanggal-pengeluaran">
                    <a href="#" class="menu-link">Lap. Per Tanggal</a>
                </li>
                <li class="menu-item" id="menu-lap-per-bulan-pengeluaran">
                    <a href="#" class="menu-link">Lap. Per Bulan</a>
                </li>
                <li class="menu-item" id="menu-lap-per-tahun-pengeluaran">
                    <a href="#" class="menu-link">Lap. Per Tahun</a>
                </li>
                <li class="menu-item" id="menu-lap-per-sumber-pengeluaran">
                    <a href="#" class="menu-link">Lap. Per Sumber</a>
                </li>
                <li class="menu-item" id="menu-lap-per-tujuan-pengeluaran">
                    <a href="#" class="menu-link">Lap. Per Tujuan</a>
                </li>
            </ul>
        </li>
        <!-- HISTORY SALDO -->
        <li class="menu-item" id="menu-history-saldo">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-clock-outline"></i>
                <div>History Saldo</div>
            </a>
        </li>
        <!-- Pengaturan -->
        <li class="menu-item" id="menu-pengaturan">
            <a href="setting.php" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-cog-outline"></i>
                <div>Pengaturan APP</div>
            </a>
        </li>
    </ul>
</aside>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
    $(document).ready(function() {
        var currentPage = window.location.pathname.split('/').pop();
        $('.menu-item').removeClass('active');
        $('.menu-item a[href="' + currentPage + '"]').closest('.menu-item').addClass('active');
    });
</script> -->
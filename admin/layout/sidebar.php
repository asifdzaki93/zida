<style>
    .app-brand-logo {
        width: 44px;
        height: 22px;
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.php" class="app-brand-link">
            <img src="<?php echo $base_url; ?>/assets//img/branding/ZIEDA.png" alt="Nama Logo" class="app-brand-logo demo">
            <span class="app-brand-text demo menu-text fw-bold ms-2"><?= $nameapp; ?></span>
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
            <a href="javascript:;" onclick='loadPage("index.php")' class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div>Beranda</div>
            </a>
        </li>
        <!-- HISTORY -->
        <li class="menu-item">
            <a href="javascript:;" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-book-open-page-variant"></i>
                <div>Data</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:;" onclick='loadPage("penjualan.php")' class="menu-link">Penjualan</a>
                </li>
                <li class="menu-item">
                    <a href="javascript:;" onclick='loadPage("produksi.php")' class="menu-link">Produksi</a>
                </li>
                <li class="menu-item">
                    <a href="javascript:;" onclick='loadPage("packing.php")' class="menu-link">Packing</a>
                </li>
                <li class="menu-item">
                    <a href="javascript:;" onclick='loadPage("pengiriman.php")' class="menu-link">Pengiriman</a>
                </li>
            </ul>
        </li>
        <li class="menu-item" id="menu-beranda">
            <a href="javascript:;" onclick='loadPage("master_data.php")' class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-badge-account-horizontal"></i>
                <div>Master Data</div>
            </a>
        </li>
        <!-- BERANDA -->
        <!-- <li class="menu-item" id="menu-beranda">
            <a href="https://web.watchapp.my.id/" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-whatsapp"></i>
                <div>WA Gateway</div>
            </a> -->
        </li>
        <!-- BERANDA -->

        <li class="menu-item" id="menu-beranda">
            <a href="javascript:;" onclick='loadPage("wasetting.php")' class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-whatsapp"></i>
                <div>WA Setting</div>
            </a>
        </li>


    </ul>
</aside>
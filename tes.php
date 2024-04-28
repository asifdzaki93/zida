<?php
error_reporting(0);
session_start();
include "./../library/config/koneksi.php";
include "sesi.php";
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
?>

    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo "$url" ?>/adminlte/plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-interaction/main.min.css">
    <link rel="stylesheet" href="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-daygrid/main.min.css">
    <link rel="stylesheet" href="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-timegrid/main.min.css">
    <link rel="stylesheet" href="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-bootstrap/main.min.css">
    <!-- script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
    <script src="<?php echo "$url" ?>/adminlte/plugins/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css"> -->



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Halaman Utama</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Halaman Utama</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"><!-- Small boxes (Stat box) -->


            <!-- Small boxes (retail bulan ini) -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                <?php
                                $bulan1 = date('Y-m-01');
                                $bulan2 = date('Y-m-d');
                                $mutasis = mysqli_query($connect, "SELECT * from sales_data WHERE user='$_SESSION[namauser]' AND due_date = '' AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                $mutasi = mysqli_num_rows($mutasis);
                                ?><?php
                                    if ($mutasi == 0) {
                                        $mt = 0;
                                    } else {
                                        $mt = $mutasi;
                                    }
                                    echo number_format($mt, 0, ',', '.');
                                    ?>
                            </h3>

                            <p>Transaksi Retail Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3  col-md-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                <?php
                                $bulan1 = date('Y-m-01');
                                $bulan2 = date('Y-m-d');
                                $mutasis = mysqli_query($connect, "SELECT * from sales_data WHERE user='$_SESSION[namauser]' AND due_date != '' AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                $mutasi = mysqli_num_rows($mutasis);
                                ?><?php
                                    if ($mutasi == 0) {
                                        $mt = 0;
                                    } else {
                                        $mt = $mutasi;
                                    }
                                    echo number_format($mt, 0, ',', '.');
                                    ?>
                            </h3>

                            <p>Transaksi Pre Order Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cart-plus"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3  col-md-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                <?php
                                $bulan1 = date('Y-m-01');
                                $bulan2 = date('Y-m-d');
                                $dataomset = mysqli_query($connect, "SELECT SUM(totalorder) as total FROM sales_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                $n = mysqli_fetch_array($dataomset);

                                if ($n['total'] == '') {
                                    $omset = 0;
                                } elseif ($n['total'] < 1000000) {
                                    $omset = number_format($n['total']);
                                } elseif ($n['total'] > 1000000) {
                                    $omset = number_format(($n['total'] / 1000000), 2, ',', '.') . ' Jt';
                                }
                                echo 'Rp. ' . $omset;
                                ?>
                            </h3>

                            <p>Total Penjualan Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3  col-md-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                <?php
                                $bulan1 = date('Y-m-01');
                                $bulan2 = date('Y-m-d');
                                $dataomsets = mysqli_query($connect, "SELECT SUM(totalorder) as totalpurchase FROM purchasing_data WHERE user='$_SESSION[namauser]'  AND `date` BETWEEN '$bulan1' AND '$bulan2' ");
                                $p = mysqli_fetch_array($dataomsets);
                                $dataspend = mysqli_query($connect, "SELECT SUM(nominal) as totalspend FROM spending WHERE user='$_SESSION[namauser]'  AND `date` BETWEEN '$bulan1' AND '$bulan2' ");
                                $sp = mysqli_fetch_array($dataspend);
                                if (($p['totalpurchase'] + $sp['totalspend']) == '') {
                                    $omset2 = 0;
                                } elseif (($p['totalpurchase'] + $sp['totalspend']) < 1000000) {
                                    $omset2 = number_format(($p['totalpurchase'] + $sp['totalspend']), 0, ',', '.');
                                } elseif (($p['totalpurchase'] + $sp['totalspend']) > 1000000) {
                                    $omset2 = number_format((($p['totalpurchase'] + $sp['totalspend']) / 1000000), 2, ',', '.') . ' Jt';
                                }
                                echo 'Rp. ' . $omset2;
                                ?>
                            </h3>
                            <p>Total Pengeluaran Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dolly-flatbed"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-boxes"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Paket Terkini</span>
                            <span class="info-box-number">
                                <?php
                                $plgn = mysqli_query($connect, "SELECT * from product WHERE user='$_SESSION[namauser]' AND packages='YES'");
                                $plg = mysqli_num_rows($plgn);
                                echo number_format($plg, 0, ',', '.') . ' Paket';
                                ?>
                                <!--<small>%</small> -->
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-birthday-cake"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Produk Terkini</span>
                            <span class="info-box-number">
                                <?php
                                $plgn = mysqli_query($connect, "SELECT * from product WHERE user='$_SESSION[namauser]' AND packages='NO'");
                                $plg = mysqli_num_rows($plgn);
                                echo number_format($plg, 0, ',', '.') . ' Produk';
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pelanggan Terkini</span>
                            <span class="info-box-number">
                                <?php
                                $plgn = mysqli_query($connect, "SELECT * from customer WHERE user='$_SESSION[namauser]'");
                                $plg = mysqli_num_rows($plgn);
                                echo number_format($plg, 0, ',', '.') . ' Orang';
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Staff Terkini</span>
                            <span class="info-box-number">
                                <?php
                                $plgn = mysqli_query($connect, "SELECT * from users WHERE master='$_SESSION[namauser]'");
                                $plg = mysqli_num_rows($plgn);
                                echo number_format($plg, 0, ',', '.') . ' Orang';
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h5 class="card-title">Rekap Pre Order Bulanan</h5>
                            <div class="card-tools">
                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i></button>

                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <!--<div class="btn-group">
<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
<i class="fas fa-wrench"></i>
</button>
<div class="dropdown-menu dropdown-menu-right" role="menu">
<a href="#" class="dropdown-item">Action</a>
<a href="#" class="dropdown-item">Another action</a>
<a href="#" class="dropdown-item">Something else here</a>
<a class="dropdown-divider"></a>
<a href="#" class="dropdown-item">Separated link</a>
</div>
</div>-->
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">

                                        <?php
                                        $from1 = tgl_indo(date('Y-m-01'));
                                        $to1 = tgl_indo(date('Y-m-d'));
                                        ?>

                                        <strong>Grafik Keuangan (<?php echo '01 s/d ' . $to1; ?>)</strong>
                                    </p>
                                    <div class="chart">

                                        <canvas id="salesChart" height="120" style="height: 100px;"></canvas>
                                    </div>


                                </div>

                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong> Pre Order Bulan Ini
                                            <?php
                                            $aaaaa = mysqli_query($connect, "SELECT * from sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00' AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                            $aaaa = mysqli_num_rows($aaaaa);
                                            echo $aaaa;
                                            ?>
                                        </strong>
                                    </p>

                                    <div class="progress-group">
                                        Pesanan Belum Diproduksi
                                        <span class="float-right">
                                            <b>
                                                <?php
                                                $eeeee = mysqli_query($connect, "SELECT * from sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00' AND status ='pre order'  AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                                $eeee = mysqli_num_rows($eeeee);
                                                echo $eeee;
                                                ?>
                                            </b>/
                                            <?php
                                            echo $aaaa;
                                            ?>
                                        </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning" style="width: 
<?php
    $eee = ($eeee / $aaaa) * 100;
    echo $eee;
?>
%"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pesanan Sudah Diproduksi
                                        <span class="float-right">
                                            <b>
                                                <?php
                                                $bbbbb = mysqli_query($connect, "SELECT * from sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00' AND status= 'finish'  AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                                $bbbb = mysqli_num_rows($bbbbb);
                                                echo $bbbb;
                                                ?>
                                            </b>/
                                            <?php
                                            echo $aaaa;
                                            ?>
                                        </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width: 
                                                <?php
                                                $bbb = ($bbbb / $aaaa) * 100;
                                                echo $bbb;
                                                ?>
                                            %">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pesanan Selesai
                                        <span class="float-right"><b>
                                                <?php
                                                $ccccc = mysqli_query($connect, "SELECT * from sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00' AND status= 'paid off' AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                                $cccc = mysqli_num_rows($ccccc);
                                                echo $cccc;
                                                ?>
                                            </b>/
                                            <?php
                                            echo $aaaa;
                                            ?>
                                        </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 
                                            <?php
                                            $ccc = ($cccc / $aaaa) * 100;
                                            echo $ccc;
                                            ?>
                                            %">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pesanan Dibatalkan
                                        <span class="float-right">
                                            <b>
                                                <?php
                                                $ddddd = mysqli_query($connect, "SELECT * from sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00' AND status= 'cancel' AND date BETWEEN '$bulan1' AND '$bulan2' ");
                                                $dddd = mysqli_num_rows($ddddd);
                                                echo $dddd;
                                                ?>
                                            </b>/
                                            <?php
                                            echo $aaaa;
                                            ?>
                                        </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-danger" style="width: 
                                            <?php
                                            $ddd = ($dddd / $aaaa) * 100;
                                            echo $ddd;
                                            ?>
                                            %">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        <span class="progress-text">Pelunasan Pesanan</span>
                                        <span class="float-right"><b>
                                                <?php
                                                $payorders = mysqli_query($connect, "SELECT SUM(totalpay) as totalpy FROM sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00'  AND status IN ('pre order', 'finish') AND `date` BETWEEN '$bulan1' AND '$bulan2' ");
                                                $pay = mysqli_fetch_array($payorders);
                                                echo 'Rp. ' . number_format($pay['totalpy'], 0, ',', '.');
                                                ?>
                                            </b>/
                                            <?php
                                            $preorders = mysqli_query($connect, "SELECT SUM(totalorder) as totalpo FROM sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00'  AND status IN ('pre order', 'finish') AND `date` BETWEEN '$bulan1' AND '$bulan2' ");
                                            $po = mysqli_fetch_array($preorders);
                                            echo 'Rp. ' . number_format($po['totalpo'], 0, ',', '.');
                                            ?>
                                        </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" style="width: 
                                            <?php
                                            $lunas = ($pay['totalpy'] / $po['totalpo']) * 100;
                                            echo $lunas;
                                            ?>
                                            %">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">

                                        <?php
                                        $bulan1 = date('Y-m-01');
                                        $bulan2 = date('Y-m-d');
                                        //langsung
                                        //sekarang
                                        $dataomset = mysqli_query($connect, "SELECT SUM(totalorder) as total FROM sales_data WHERE user='$_SESSION[namauser]' AND status='paid off' AND date='$bulan2' ");
                                        $n = mysqli_fetch_array($dataomset);
                                        //kemarin
                                        $bulan_1 = date('Y-m-d', strtotime('-1 days', strtotime($bulan2)));
                                        $dataomset_1 = mysqli_query($connect, "SELECT SUM(totalorder) as total FROM sales_data WHERE user='$_SESSION[namauser]' AND status='paid off' AND date='$bulan_1' ");
                                        $n_1 = mysqli_fetch_array($dataomset_1);


                                        //pro order
                                        //sekarang
                                        $dataomsetb = mysqli_query($connect, "SELECT SUM(totalpay) as total FROM sales_data WHERE user='$_SESSION[namauser]' AND status='pre order' AND date='$bulan2' ");
                                        $nb = mysqli_fetch_array($dataomsetb);
                                        //kemarin
                                        $bulanb_1 = date('Y-m-d', strtotime('-1 days', strtotime($bulan2)));
                                        $dataomsetb_1 = mysqli_query($connect, "SELECT SUM(totalpay) as total FROM sales_data WHERE user='$_SESSION[namauser]' AND status='pre order' AND date='$bulanb_1' ");
                                        $nb_1 = mysqli_fetch_array($dataomsetb_1);


                                        $msk_1  = ($n_1['total'] + $nb_1['total']);
                                        $msk    = ($n['total'] + $nb['total']);


                                        $selisih = abs($msk_1 - $msk);
                                        $eee = (($selisih / $msk) * 100);
                                        if ($msk_1 > $msk) {
                                            echo '<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i>';
                                        } elseif ($msk_1 < $msk) {
                                            echo '<span class="description-percentage text-success"><i class="fas fa-caret-up"></i>';
                                        } elseif ($msk_1 = $msk) {
                                            echo '<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i>';
                                        }
                                        echo ' ' . floor($eee) . ' % <br><small> Selisih Rp. ';
                                        echo format_rupiah($selisih) . '</small>';
                                        ?>
                                        </span>
                                        <h5 class="description-header">
                                            <?php


                                            if ($n['total'] == '') {
                                                $omset = 0;
                                            } elseif ($msk !== '') {
                                                $omset = number_format($msk);
                                            }
                                            ?><?php echo 'Rp. ' . $omset;
                                                ?>
                                        </h5>
                                        <span class="description-text">PENDAPATAN (Hari Ini)</span>
                                    </div>
                                    <!-- <?php
                                            echo
                                            $n_1['total'] . '<br>' .
                                                $n['total'] . '<br>' .
                                                $nb_1['total'] . '<br>' .
                                                $nb['total'] . '<br>' .
                                                $msk_1 . '<br>' .
                                                $msk . '<br>' .
                                                $selisih . '<br>';
                                            ?> -->
                                </div>

                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <?php
                                        $bulan1         = date('Y-m-01');
                                        $bulan2         = date('Y-m-d');
                                        $dataomsets     = mysqli_query($connect, "SELECT SUM(totalorder) as totalpurchase FROM purchasing_data WHERE user='$_SESSION[namauser]'  AND `date`='$bulan2' ");
                                        $p              = mysqli_fetch_array($dataomsets);
                                        $dataspend      = mysqli_query($connect, "SELECT SUM(nominal) as totalspend FROM spending WHERE user='$_SESSION[namauser]'  AND `date`='$bulan2' ");
                                        $sp             = mysqli_fetch_array($dataspend);
                                        $pengeluaran    = $p['totalorder'] + $sp['totalspend'];

                                        if ($pengeluaran == '') {
                                            $omset2 = 0;
                                        } elseif ($pengeluaran < 1000000) {
                                            $omset2 = number_format(($p['totalpurchase'] + $sp['totalspend']));
                                        } elseif ($pengeluaran > 1000000) {
                                            $omset2 = number_format((($p['totalpurchase'] + $sp['totalspend']) / 1000000), 2, ',', '.') . ' Jt';
                                        }

                                        $bulan_1        = date('Y-m-d', strtotime('-1 days', strtotime($bulan2)));
                                        $dataomsets_1   = mysqli_query($connect, "SELECT SUM(totalorder) as totalpurchase FROM purchasing_data WHERE user='$_SESSION[namauser]'  AND `date`='$bulan_1' ");
                                        $ns_1           = mysqli_fetch_array($dataomsets_1);
                                        $dataspend_1    = mysqli_query($connect, "SELECT SUM(nominal) as totalspend FROM spending WHERE user='$_SESSION[namauser]'  AND `date`='$bulan_1' ");
                                        $sp_1           = mysqli_fetch_array($dataspend_1);
                                        $pengeluaran_1  = $ns_1['totalpurchase'] + $sp_1['totalspend'];

                                        $selisihs       = abs($pengeluaran - $pengeluaran_1);
                                        $fff = ($selisihs / $pengeluaran) * 100;

                                        if ($pengeluaran_1 > $pengeluaran) {
                                            echo '<span class="description-percentage text-success"><i class="fas fa-caret-down"></i>';
                                        } elseif ($pengeluaran_1 < $pengeluaran) {
                                            echo '<span class="description-percentage text-danger"><i class="fas fa-caret-up"></i>';
                                        } elseif ($pengeluaran_1 = $pengeluaran) {
                                            echo '<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i>';
                                        }

                                        echo ' ' . floor($fff) . ' % <br><small> Selisih Rp. ';
                                        echo format_rupiah($selisihs) . '</small>';
                                        ?>

                                        </span>
                                        <h5 class="description-header">
                                            <?php echo 'Rp. ' . $omset2; ?>
                                        </h5>
                                        <span class="description-text">PENGELUARAN (Hari Ini)</span>
                                    </div>

                                </div>

                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">

                                        <?php

                                        $laba   = ($n['total'] + $nb['total']) - ($p['totalpurchase'] + $sp['totalspend']);
                                        $laba_1 = ($n_1['total'] + $nb_1['total']) - $pengeluaran_1;
                                        $selisihlb  = abs($laba - $laba_1);
                                        $ggg        = ($selisihlb / $laba) * 100;

                                        if ($laba_1 > $laba) {
                                            echo '<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i>';
                                        } elseif ($laba_1 < $laba) {
                                            echo '<span class="description-percentage text-success"><i class="fas fa-caret-up"></i>';
                                        } elseif ($laba_1 = $laba) {
                                            echo '<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i>';
                                        }

                                        echo ' ' . floor($ggg) . ' % <br><small> Selisih Rp. ';
                                        echo format_rupiah($selisihlb) . '</small>';
                                        ?>
                                        </span>
                                        <h5 class="description-header">
                                            <?php
                                            echo 'Rp. ' . number_format(($laba), 0, ',', '.');
                                            ?>
                                        </h5>
                                        <span class="description-text">LABA KOTOR (Hari Ini)</span>
                                    </div>

                                </div>

                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <?php
                                        $preordere = mysqli_query($connect, "SELECT SUM(totalpay) as totalpaye ,SUM(totalorder) as totalpoe FROM sales_data WHERE user='$_SESSION[namauser]' AND due_date != '0000-00-00'  AND status IN ('pre order', 'finish') AND `due_date` ='$bulan2' ");
                                        $poe = mysqli_fetch_array($preordere);
                                        ?>
                                        <span class="description-percentage text-danger">
                                            <?php
                                            echo 'Rp. ' . number_format($poe['totalpoe'], 0, ',', '.') . ' - ';
                                            echo 'Rp. ' . number_format($poe['totalpaye'], 0, ',', '.');
                                            ?>
                                        </span>

                                        <h5 class="description-header">
                                            <?php
                                            echo 'Rp. ' . number_format(($poe['totalpoe'] - $poe['totalpaye']), 0, ',', '.');
                                            ?>
                                        </h5>
                                        <span class="description-text">PIUTANG JATUH TEMPO (HARI INI)</span>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- produksi kirim-->

            <div class="row">
                <div class="col-md-4">
                    <!-- <div class="card card-primary collapsed-card"> -->
                    <div class="card card-primary ">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Harian Toko <span class="right badge badge-danger">Beta</span></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="chart-responsive">
                                        <canvas id="pieChart" height="200"></canvas>
                                    </div>
                                    <h6 style="text-align:center">
                                        Data ini merangkum pemasukan dari penjualan retail dan uang muka yang masuk dari pre order
                                    </h6>
                                </div>

                                <!--<div class="col-md-4">
            <ul class="chart-legend clearfix">
                <?php
                $data       = mysqli_query(
                    $connect,
                    "SELECT * 
                    FROM users WHERE master='$_SESSION[namauser]'
                    ORDER BY full_name DESC"
                );
                //melakukan looping
                foreach ($data as $key) {
                    echo  '<li><i class="far fa-circle text-danger"></i><small>' . $key['full_name'] . '</small></li>';
                }
                ?>
            </ul>
            </div>-->

                            </div>

                        </div>

                        <div class="card-footer p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <div class='nav-link'>
                                        Akumulasi Semua Cabang
                                        <span class="float-right text-success">
                                            <?php
                                            $skrg = date('Y-m-d');
                                            $pesanan4 = mysqli_query(
                                                $connect,
                                                "SELECT *, 
                                                users.full_name AS penanggungjawab,
                                                SUM(IF(sales_data.totalpay <= sales_data.totalorder, sales_data.totalorder+sales_data.changepay, sales_data.totalpay-sales_data.changepay)) AS jml
                                                FROM sales_data
                                                JOIN users ON sales_data.operator = users.phone_number
                                                WHERE sales_data.date = '$skrg' 
                                                AND sales_data.user='$_SESSION[namauser]' 
                                                AND status NOT IN ('cancel') 
                                                GROUP BY `sales_data`.`user`
                                                ORDER BY jml DESC;"
                                            );
                                            $data = mysqli_query($connect, "SELECT * FROM users WHERE master='$_SESSION[namauser]' ORDER BY full_name DESC");
                                            $jumm = mysqli_fetch_array($pesanan4);
                                            echo "Rp. " . number_format($jumm['jml'], 0, ',', '.') . ",- &nbsp";
                                            ?>
                                            <i class="fas fa-cart-arrow-down">&nbsp</i>
                                        </span>
                                    </div>
                                </li>

                                <?php

                                $nomer = 1;
                                $skrg    = date('Y-m-d');
                                //date('Y-m-d');
                                $pesanan3 = mysqli_query(
                                    $connect,
                                    "SELECT *, 
                                    users.full_name AS penanggungjawab,
                                    SUM(IF(sales_data.totalpay <= sales_data.totalorder, sales_data.totalorder+sales_data.changepay, sales_data.totalpay-sales_data.changepay)) AS jml
                                    FROM sales_data
                                    JOIN users ON sales_data.operator = users.phone_number
                                    WHERE sales_data.date = '$skrg' 
                                    AND sales_data.user='$_SESSION[namauser]' 
                                    AND status NOT IN ('cancel') 
                                    GROUP BY sales_data.operator
                                    ORDER BY jml DESC;
                                    "
                                );
                                $data  = mysqli_query(
                                    $connect,
                                    "SELECT * FROM users WHERE master='$_SESSION[namauser]' ORDER BY full_name DESC"
                                );
                                //melakukan looping
                                foreach ($pesanan3 as $key) :
                                ?>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <?php echo $key['penanggungjawab']; ?>
                                            <span class="float-right text-success">
                                                <?php echo "Rp. " . number_format($key['jml'], 0, ',', '.') . ",- &nbsp"; ?>
                                                <i class="fas fa-cart-arrow-down">&nbsp</i>
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>

                </div>
                <div class="col-md-4">
                    <!-- quick email widget -->
                    <div class="card card-success">
                        <div class="card-header">
                            <i class="fa fa-money"></i>
                            <h3 class="card-title">Transaksi Retail Hari Ini</h3>
                            <div class="card-tools">
                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <table name="orderbaru" id="orderbaru" class="table-sm table-striped dt-responsive nowrap dt-table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <!--<th>Tanggal</th>-->
                                            <th>No Nota</th>
                                            <th>Total Order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $hrini = date('Y-m-d');
                                        $no = 1;
                                        $posting = mysqli_query($connect, "SELECT * FROM sales_data WHERE status='paid off' AND date='$hrini' AND user='$_SESSION[namauser]' ORDER BY id_sales_data DESC");
                                        $jumlah = mysqli_num_rows($posting);
                                        if ($jumlah > 0) {
                                            while ($p = mysqli_fetch_array($posting)) {
                                        ?>

                                                <tr>
                                                    <td style="text-align:left"><?php echo $no++; ?></td>
                                                    <!--<td style="text-align:left"><?php echo $p['date']; ?></td>-->
                                                    <td style="text-align:center">
                                                        <a class="btn btn-success btn-sm" href="https://pro.kasir.vip/app/code-<?php echo $p['no_invoice']; ?>" role="button"><?php echo $p['no_invoice']; ?></a>
                                                    </td>
                                                    <td style="text-align:right"> <?php echo 'Rp.' . number_format($p['totalorder']); ?>,-</td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td>-</td>
                                                <!--<td>-(</td>-->
                                                <td>Belum Ada Transaksi :</td>
                                                <td>-</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a>
                                <a class="btn btn-success btn-sm" href="https://zieda.id/pro/report/history" target="_blank" role="button"><?php echo 'Lihat Semua' ?></a>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <!-- quick email widget -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <i class="fa fa-money"></i>
                            <h3 class="card-title">
                                Pre Order Masuk Hari Ini
                            </h3>
                            <div class="card-tools">
                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <table name="orderbaru2" id="orderbaru2" class="table-sm table-striped dt-responsive nowrap dt-table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <!--<th>Tanggal</th>-->
                                            <th>No Nota</th>
                                            <th>Total Order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $hrini = date('Y-m-d');
                                        $no = 1;
                                        $posting = mysqli_query($connect, "SELECT * FROM sales_data WHERE status='pre order' AND date='$hrini' AND user='$_SESSION[namauser]' ORDER BY id_sales_data DESC");
                                        $jumlah = mysqli_num_rows($posting);
                                        if ($jumlah > 0) {
                                            while ($p = mysqli_fetch_array($posting)) {
                                        ?>

                                                <tr>
                                                    <td style="text-align:left"><?php echo $no++; ?></td>
                                                    <!--<td style="text-align:left"><?php echo $p['date']; ?></td>-->
                                                    <td style="text-align:center">
                                                        <a class="btn btn-warning btn-sm" href="https://pro.kasir.vip/app/code-<?php echo $p['no_invoice']; ?>" role="button"><?php echo $p['no_invoice']; ?></a>
                                                    </td>
                                                    <td style="text-align:right"> <?php echo 'Rp.' . number_format($p['totalorder']); ?>,-</td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td>-</td>
                                                <!--<td>-(</td>-->
                                                <td>Belum Ada Transaksi :</td>
                                                <td>-</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <form method="post" action="https://zieda.id/pro/report/h_order">
                                <button class="btn btn-warning btn-sm" type="submit" name="first_date" value="<?php echo date('Y-m-d'); ?>">Lihat Semua</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- produksi kirim-->

            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-danger">
                                    <h3 class="card-title">Produksi Pagi</h3>
                                    <div class="card-tools">
                                        <!-- Maximize Button -->
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                            <i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php $tanggal_besok = date('Y-m-d', strtotime('+1 day')); ?>
                                    <?php $url1 = 'https://zieda.id/pro/pdf/produksi_pagi.php?tanggal_awal=' . $skrg . '&tanggal_akhir=' . $skrg . '&user=082322345757'; ?>
                                    <?php $url2 = 'https://zieda.id/pro/pdf/produksi.php?tanggal_awal=' . $tanggal_besok . '&tanggal_akhir=' . $tanggal_besok . '&user=082322345757'; ?>

                                    <iframe src="<?= $url1 ?>" width="100%" height="800"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-danger">
                                    <h3 class="card-title">Produksi Sore</h3>
                                    <div class="card-tools">
                                        <!-- Maximize Button -->
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                            <i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <iframe src="<?= $url2 ?>" width="100%" height="800"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h3 class="card-title">Pre Order Pengiriman Hari Ini</h3>

                            <div class="card-tools">
                                <button onclick="window.open('https://zieda.id/pro/pdf/pengiriman.php', '_blank')" class="btn btn-tool"><i class="fas fa-print"></i></button>
                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table id=example2 class="table-sm dt-table dt-responsive table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 1%">
                                            No.
                                        </th>
                                        <th class="text-center" style="width: 25%">
                                            Pesanan
                                        </th>
                                        <th style="width: 19%">
                                            Gambar
                                        </th>
                                        <th style="width: 20%">
                                            Pembayaran
                                        </th>
                                        <th style="width: 20%" class="text-center">
                                            Status
                                        </th>
                                        <th class="text-center" style="width: 25%">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;

                                    //due_date='$hrini' AND
                                    $posting = mysqli_query($connect, "
                                    SELECT * ,
                                    (CASE 
                                        WHEN `note` LIKE '%pagi%'  THEN 'pagi'
                                        WHEN `note` LIKE '%pg%'  THEN 'pagi'
                                        WHEN `note` LIKE '%pgi%'  THEN 'pagi'
                                        WHEN `note` LIKE '%siang%'  THEN 'pagi'
                                        WHEN `note` LIKE '%sg%'  THEN 'pagi'
                                        WHEN `note` LIKE '%sore%'  THEN 'sore'
                                        WHEN `note` LIKE '%sor%'  THEN 'sore'
                                        WHEN `note` LIKE '%sre%'  THEN 'sore'
                                        WHEN `note` LIKE '%sr%'  THEN 'sore'
                                        WHEN `note` LIKE '%malam%'  THEN 'sore'
                                        WHEN `note` LIKE '%malm%'  THEN 'sore'
                                        WHEN `note` LIKE '%mlm%'  THEN 'sore'
                                        WHEN `note` LIKE '%mlam%'  THEN 'sore'
                                        WHEN `note` LIKE '%6m%'  THEN 'sore'
                                        WHEN `note` LIKE '%6 m%'  THEN 'sore'
                                        WHEN `note` LIKE '%6.m%'  THEN 'sore'
                                        WHEN `note` LIKE '%6p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%6 p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%6.p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%7m%'  THEN 'sore'
                                        WHEN `note` LIKE '%7 m%'  THEN 'sore'
                                        WHEN `note` LIKE '%7.m%'  THEN 'sore'
                                        WHEN `note` LIKE '%7p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%7 p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%7.p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%8m%'  THEN 'sore'
                                        WHEN `note` LIKE '%8 m%'  THEN 'sore'
                                        WHEN `note` LIKE '%8.m%'  THEN 'sore'
                                        WHEN `note` LIKE '%8p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%8 p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%8.p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%9m%'  THEN 'sore'
                                        WHEN `note` LIKE '%9 m%'  THEN 'sore'
                                        WHEN `note` LIKE '%9.m%'  THEN 'sore'
                                        WHEN `note` LIKE '%9p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%9 p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%9.p%'  THEN 'pagi'
                                        WHEN `note` LIKE '%10%'  THEN 'pagi'
                                        WHEN `note` LIKE '%11%'  THEN 'pagi'
                                        WHEN `note` LIKE '%12%'  THEN 'pagi'
                                        WHEN `note` LIKE '%13%'  THEN 'pagi'
                                        WHEN `note` LIKE '%14%'  THEN 'pagi'
                                        WHEN `note` LIKE '%15%'  THEN 'pagi'
                                        WHEN `note` LIKE '%16%'  THEN 'pagi'
                                        WHEN `note` LIKE '%17%'  THEN 'sore'
                                        WHEN `note` LIKE '%18%'  THEN 'sore'
                                        WHEN `note` LIKE '%19%'  THEN 'sore'
                                        WHEN `note` LIKE '%20%'  THEN 'sore'
                                        WHEN `note` LIKE '%21%'  THEN 'sore'
                                        WHEN `note` LIKE '%22%'  THEN 'sore'
                                        WHEN `note` LIKE '%23%'  THEN 'sore'
                                        WHEN `note` LIKE '%1%'  THEN 'pagi'
                                        WHEN `note` LIKE '%2%'  THEN 'pagi'
                                        WHEN `note` LIKE '%3%'  THEN 'pagi'
                                        WHEN `note` LIKE '%4%'  THEN 'pagi'
                                        WHEN `note` LIKE '%5%'  THEN 'sore'
                                        WHEN `note` LIKE '%6%'  THEN 'pagi'
                                        WHEN `note` LIKE '%7%'  THEN 'pagi'
                                        WHEN `note` LIKE '%8%'  THEN 'pagi'
                                        WHEN `note` LIKE '%9%'  THEN 'pagi'
                                        ELSE 'pagi'
                                    END) AS shift
                                    FROM sales_data 
                                    WHERE due_date!='0000-00-00' 
                                    AND due_date='$hrini' 
                                    AND user='$_SESSION[namauser]' 
                                    ORDER BY shift ASC, id_store ASC, totalorder DESC");
                                    $jumlah = mysqli_num_rows($posting);
                                    if ($jumlah > 0) {
                                        while ($p = mysqli_fetch_array($posting)) {
                                            $cus = mysqli_query($connect, "SELECT * FROM customer WHERE id_customer='$p[id_customer]'");
                                            $c = mysqli_fetch_array($cus)
                                    ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php echo $no++; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a>
                                                        <a class="btn btn-danger btn-sm" href="https://pro.kasir.vip/app/code-<?php echo $p['no_invoice']; ?>" target="_blank" role="button"><?php echo $p['no_invoice']; ?></a>
                                                    </a>
                                                    <br />
                                                    <small>
                                                        <?php
                                                        $catatannya = $p['note'];
                                                        //$hasil = str_replace(['Jam Acara : ', ' Jenis Pengiriman : ', ' | ',' Catatan : ' ], ['#', '#', '#', '#'], $catatannya);
                                                        $hasil = str_replace(
                                                            ['Event hours:', 'Jam acara : ', 'Jam Acara : ', ' Waktu Pengiriman : ', ' Jenis Pengiriman : ', ' | ', ' Catatan : ', 'nn', 'nInput', 'nAdm', 'ninput', 'nadm'],
                                                            ['#', '#', '#', '#', '#', '#', '#', '
                                                            ', '
                                                            Input', '
                                                            Adm', ' 
                                                            Input', '
                                                            Adm'],
                                                            $catatannya
                                                        );
                                                        $starting_string = $hasil;
                                                        $result_array = preg_split("/#/", $starting_string);
                                                        $jamkr = $result_array[1];
                                                        $wktkr = $result_array[2];
                                                        $destinasi = $result_array[3];
                                                        $cttn = $result_array[4];

                                                        echo '
                            <p class="text-left">
                                <i class="fas fa-user-circle"></i> ' . ucwords('&nbsp&nbsp' . $c[name_customer]) . '
                                <br> <i class="fas fa-phone-square"></i>' . '&nbsp&nbsp&nbsp' . $c['telephone'] . '
                                <br><i class="fas fa-user-clock"></i>' . '&nbsp&nbsp Acara : ' . $jamkr . ' 
                                <br><i class="fas fa-shipping-fast"></i>' . '&nbsp&nbsp' . $wktkr . ' | ' . $destinasi . ' 
                            </p>
                            <p class="text-justify">
                                <i class="fas fa-clipboard-check"></i>' . '&nbsp&nbsp' . $cttn . ' 
                            </p>'; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <ul class="list-inline">
                                                        <?php
                                                        $imgcustom = "https://pro.kasir.vip/geten/images/order/" . $p[img];
                                                        if ($p[img] !== "") {
                                                            echo '
                                        <li class="list-inline-item">
                                            <div style="align-items: center"><a href=' . $imgcustom . '>
                                                <img class="rounded-image" src=' . $imgcustom . ' />
                                            </a>
                                            </div>
                                        </li>
                                        ';
                                                        }
                                                        $pesanane = mysqli_query($connect, "SELECT * FROM sales WHERE no_invoice='$p[no_invoice]'");
                                                        while ($ps = mysqli_fetch_array($pesanane)) {
                                                            $wqw = mysqli_query($connect, "SELECT * FROM product WHERE id_product='$ps[id_product]' ");
                                                            $wow = mysqli_fetch_array($wqw);
                                                            $sumber = "https://pro.kasir.vip/geten/images/" . $wow[folder] . "/" . $wow[img];
                                                            $kosong = "https://pro.kasir.vip/geten/images/no_image.jpg";


                                                            if ($wow[folder] !== "") {
                                                                echo '
                                        <li class="list-inline-item">
                                            <div style="align-items: center"><a href=' . $sumber . '>
                                                <img class="circular-image" src=' . $sumber . ' />
                                            </a>
                                            </div>
                                        </li>
                                        ';
                                                            } else {
                                                                echo '
                                        <li class="list-inline-item">
                                            <div style="align-items: center"><a href=' . $kosong . '>
                                                <img class="circular-image" src=' . $kosong . ' />
                                            </a>
                                            </div>
                                        </li>
                                        ';
                                                            }

                                                        ?>

                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                                <td class="project_progress">
                                                    <div class="progress progress-sm">
                                                        <?php
                                                        $per = ((int)$p['totalpay'] / (int)$p['totalorder']) * 100;
                                                        //if($per > 20){echo 'bg-orange';}elseif($per > 40 ){echo 'bg-yellow';}elseif($per > 60 ){echo 'bg-blue';}elseif($per > 80 ){echo 'bg-green';}else{echo 'bg-red';}
                                                        ?>
                                                        <div class="progress-bar bg-green" role="progressbar" aria-volumenow="<?= $per; ?>" aria-volumemin="0" aria-volumemax="100" style="width: <?= $per; ?>%">
                                                        </div>
                                                    </div>
                                                    <small>
                                                        <?php
                                                        $persen = ((int)$p['totalpay'] / (int)$p['totalorder']) * 100;
                                                        $dbyr   = format_rupiah($p['totalpay']);
                                                        $drttl  = format_rupiah($p['totalorder']);
                                                        $kurg   = format_rupiah($p['totalorder'] - $p['totalpay']);
                                                        echo '<div class="text-center"><b>Dibayar ' . floor($persen) . '% </b></div>' . '<br> Total : Rp. ' . $drttl . ' <br>Dibayar : Rp. ' . $dbyr . '<br>Kurang : Rp. ' . $kurg; ?>
                                                    </small>
                                                </td>
                                                <td class="project-state">
                                                    <?php
                                                    if ($p['status'] == 'pre order') {
                                                        echo '<span class="badge badge-warning">Belum Diproduksi
                                </span>';
                                                    } elseif ($p['status'] == 'finish') {
                                                        echo '<span class="badge badge-primary">Sudah Diproduksi
                                </span>';
                                                    } elseif ($p['status'] == 'paid off') {
                                                        echo '<span class="badge badge-success">Pesanan Selesai
                                </span>';
                                                    } elseif ($p['status'] == 'cancel') {
                                                        echo '<span class="badge badge-danger">Pesanan Batal
                                </span>';
                                                    }
                                                    ?>
                                                    <?php
                                                    echo "<br><small><i style='text-align: justify;'>" . ucwords($c[address]) . "</i><small> ";
                                                    ?>
                                                </td>
                                                <td class="project-actions text-center">

                                                    <a class="btn btn-success btn-sm" href="https://pro.kasir.vip/pdf/invoice.php?no_invoice=<?= $p[no_invoice]; ?>">
                                                        <i class='fas fa-file-alt'></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-sm" href="https://pro.kasir.vip/pdf/material.php?no_invoice=<?= $p[no_invoice]; ?>">
                                                        <i class='fas fa-dolly'></i>
                                                    </a>

                                                    <!-- Button trigger modal -->
                                                    <?php if ($p[status] != 'finish' && $p[status] != 'paid off') { ?>
                                                        <button type="button" class="btn btn-warning mt-2" data-toggle="modal" data-target="#modal-<?= $p[no_invoice]; ?>">
                                                            Selesai
                                                        </button>
                                                    <?php } elseif ($p[status] = 'paid off') { ?>
                                                        <button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#m-<?= $p[no_invoice]; ?>">
                                                            Selesai
                                                        </button>
                                                    <?php } ?>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal-<?= $p[no_invoice]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-warning">
                                                                    <h5 class="modal-title" id="exampleModalLabel">QC Produksi - <?= $p[no_invoice]; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="https://zieda.id/pro/geten/transaction/finishorder.php?key=<?= $_SESSION['idnya']; ?>&no_invoice=<?= $p[no_invoice]; ?>" method="post">
                                                                        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                                                        <lord-icon src="https://cdn.lordicon.com/zncllhmn.json" trigger="loop" delay="500" colors="primary:#121331" state="intro" style="width:150px;height:150px">
                                                                        </lord-icon>
                                                                        <h5>
                                                                            Apakah anda sudah memastikan
                                                                            bahwa pesanan ini sudah selesai di produksi
                                                                            dan siap untuk dikirimkan?
                                                                        </h5>
                                                                        <p style="text-align:left; font-size: 12px;">*Ini akan merubah status pesanan menjadi "Sudah Diproduksi"
                                                                            dan tidak bisa diurungkan</p>
                                                                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="m-<?= $p[no_invoice]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-success">
                                                                    <h5 class="modal-title" id="exampleModalLabel">QC Payment - <?= $p[no_invoice]; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="https://zieda.id/pro/geten/sales/updateorder.php" method="post">
                                                                        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                                                        <lord-icon src="https://cdn.lordicon.com/hpmjntem.json" trigger="loop" delay="1500" colors="primary:#121331" style="width:150px;height:150px">
                                                                        </lord-icon>

                                                                        <input type="hidden" name="key" value="<?= $_SESSION['idnya']; ?>" />
                                                                        <input type="hidden" name="no_invoice" value="<?= $p[no_invoice]; ?>" />
                                                                        <input type="hidden" name="totalpay" value="<?= $p[totalorder]; ?>" />
                                                                        <h6 style="color: maroon">
                                                                            Kekurangan Pembayaran Sebesar : Rp. <?php echo ($p[totalorder] - $p[totalpay]); ?>
                                                                        </h6>
                                                                        <h5>
                                                                            Apakah anda sudah memastikan
                                                                            Pelunasan pesanan ini dan Product telah diterima Pembeli?
                                                                        </h5>
                                                                        <p style="text-align:left; font-size: 12px;">*Ini akan merubah status pesanan menjadi "Selesai"
                                                                            dan tidak bisa diurungkan</p>
                                                                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                Belum Ada Transaksi Hari Ini :(
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <!-- /.card -->

                </div>
            </div>

            <!-- laporan harian produksi -->

            <div class="row">
                <div class="col-12">
                    <div class="card collapsed-card">

                        <div class="card-header bg-info">
                            Keterangan
                            <div class="card-tools">
                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-plus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <p align="justify">
                                    * Warna Membedakan Status Pesanan,<br>
                                    * Jika Pesanan diblok warna, berarti dalam catatan jam kirim tidak ada keterangan pagi siang sore atau malam.<br>
                                    * jika Pesanan Terdapat keterangan pagi siang sore atau malam maka Berawalan Lingkaran berwarna.<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-danger">
                            Monitoring Kalender Pesanan
                            <div class="card-tools">
                                <!-- Maximize Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas id="chartPenjualan"></canvas>

                </div>
            </div>

            <div class="card collapsed-card">
                <div class="card-header bg-danger">
                    Produk Ter Laris Bulan Ini
                    <div class="card-tools">
                        <!-- Maximize Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        // mengambil semua data store dengan user = '082322345757'
                        $store_query = "SELECT * FROM store WHERE user = '082322345757' ORDER BY id_store";
                        $store_result = mysqli_query($connect, $store_query);

                        // menentukan rentang waktu satu bulan sebelum tanggal sekarang
                        $before_month = date("Y-m-d", strtotime("-1 month"));
                        $today = date("Y-m-d");

                        // loop setiap store
                        while ($store = mysqli_fetch_array($store_result)) {
                            // mengambil 10 produk terlaris dari setiap store
                            $product_query = "SELECT p.name_product, SUM(s.amount) AS total_sold
                                        FROM sales s
                                        JOIN product p ON s.id_product = p.id_product
                                        WHERE s.id_store = '{$store['id_store']}'
                                        AND s.date BETWEEN '$before_month' AND '$today'
                                        GROUP BY p.id_product
                                        ORDER BY total_sold DESC
                                        LIMIT 10";

                            $product_query2 = "SELECT SUM(amount) AS total_sold
                                        FROM sales 
                                        WHERE id_store = '{$store['id_store']}'
                                        AND date BETWEEN '$before_month' AND '$today'
                                        ";
                            $product_result = mysqli_query($connect, $product_query);
                            $product_result2 = mysqli_query($connect, $product_query2);
                            $amount = mysqli_fetch_array($product_result2);


                            // membuat card untuk setiap store
                            echo '<div class="col-lg-4" id="accordion">
                      <div class="card card-primary card-outline">';
                            echo '<div class="card-header">';
                            echo '<a class="d-block w-100" data-toggle="collapse" href="#collapseOne"><h4 class="card-title w-100">' . $store['name_store'] . ' (' . $amount[total_sold] . ' Produk Terjual)</h4>';
                            echo '</div>';
                            echo '<div id="collapseOne" class="collapse show" data-parent="#accordion"><div class="card-body  p-0">';
                            echo '<table class="table table-sm table-striped">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th style="width: 10px">#</th>
                                    <th>Produk</th>
                                    <th>Penjualan</th>
                                    <th style="width: 45px">Terjual</th>';
                            echo '</tr>';
                            echo '</thead></a>';
                            echo '<tbody>';
                            // loop setiap produk
                            $nomer = 1;
                            while ($product = mysqli_fetch_array($product_result)) {
                                echo '<tr>';
                                echo '<td>' . $nomer++ . '</td>';
                                echo '<td>' . ucwords(strtolower($product['name_product'])) . ' | ' . $product['total_sold'] . '  </td>';
                                echo '<td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger" style="width: ' . (($product['total_sold'] / $amount[total_sold]) * 100) . '%"></div>
                                    </div><br>
                                    
                                  </td>';
                                echo '<td>' . '<span class="badge bg-danger">' . ceil((($product['total_sold'] / $amount[total_sold]) * 100)) . '%</span>' . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        ?>
                    </div>
                </div>
            </div>





        </div>



        </div><!-- /.container-fluid -->
        </div>

        <script src="<?php echo "$url" ?>/adminlte/plugins/moment/moment.min.js"></script>
        <script src="<?php echo "$url" ?>/adminlte/plugins/fullcalendar/main.min.js"></script>
        <script src="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-daygrid/main.min.js"></script>
        <script src="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-timegrid/main.min.js"></script>
        <script src="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-interaction/main.min.js"></script>
        <script src="<?php echo "$url" ?>/adminlte/plugins/fullcalendar-bootstrap/main.min.js"></script>

        <!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'id',
                    eventLimit: true, // allow "more" link when there are too many events
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    themeSystem: 'bootstrap',
                    nowIndicator: true,
                    //defaultDate: new Date(), // Use this line to use the current date: new Date(),
                    editable: true,
                    navLinks: true,
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end) {
                        $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                        $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                        $('#ModalAdd').modal('show');
                    },
                    events: [
                        <?php
                        //melakukan koneksi ke database
                        //$koneksi    = mysqli_connect('localhost', 'root', '', 'latihan');
                        //mengambil data dari tabel jadwal
                        $data       = mysqli_query(
                            $connect,
                            "SELECT * 
                        FROM sales_data WHERE due_date!='0000-00-00' AND `user`='$_SESSION[namauser]' ORDER BY id_sales_data DESC"
                        );
                        //melakukan looping
                        while ($d = mysqli_fetch_array($data)) {
                        ?> {
                                title: '<?php
                                        $tagihan = ($d['totalorder'] - $d['totalpay']);
                                        if ($tagihan > 0) {
                                            $nom = "-Rp. " . number_format(($d['totalorder'] - $d['totalpay']), 0, ',', '.');
                                        } else {
                                            $nom = "Lunas";
                                        }
                                        $titel = $d['no_invoice'] . " | " . $nom . " | (" . $d['status'] . ") | " . $d['note'];
                                        echo $titel ?>', //menampilkan title dari tabel
                                start: '<?php
                                        if (preg_match("/pagi/i", $d['note'])) {
                                            $jam = ' 08:00:00';
                                        } elseif (preg_match("/pg/i", $d['note'])) {
                                            $jam = ' 08:00:00';
                                        } elseif (preg_match("/pgi/i", $d['note'])) {
                                            $jam = ' 08:00:00';
                                        } elseif (preg_match("/siang/i", $d['note'])) {
                                            $jam = ' 10:00:00';
                                        } elseif (preg_match("/sg/i", $d['note'])) {
                                            $jam = ' 10:00:00';
                                        } elseif (preg_match("/sore/i", $d['note'])) {
                                            $jam = ' 14:00:00';
                                        } elseif (preg_match("/sor/i", $d['note'])) {
                                            $jam = ' 14:00:00';
                                        } elseif (preg_match("/sre/i", $d['note'])) {
                                            $jam = ' 14:00:00';
                                        } elseif (preg_match("/sr/i", $d['note'])) {
                                            $jam = ' 14:00:00';
                                        } elseif (preg_match("/malam/i", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/malm/i", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/mlm/i", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/mlam/i", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/6m/i", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/6 m/i", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/6.m/i", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/6p/i", $d['note'])) {
                                            $jam = ' 06:00:00';
                                        } elseif (preg_match("/6 p/i", $d['note'])) {
                                            $jam = ' 06:00:00';
                                        } elseif (preg_match("/6.p/i", $d['note'])) {
                                            $jam = ' 06:00:00';
                                        } elseif (preg_match("/7m/i", $d['note'])) {
                                            $jam = ' 19:00:00';
                                        } elseif (preg_match("/7 m/i", $d['note'])) {
                                            $jam = ' 19:00:00';
                                        } elseif (preg_match("/7.m/i", $d['note'])) {
                                            $jam = ' 19:00:00';
                                        } elseif (preg_match("/7p/i", $d['note'])) {
                                            $jam = ' 07:00:00';
                                        } elseif (preg_match("/7 p/i", $d['note'])) {
                                            $jam = ' 07:00:00';
                                        } elseif (preg_match("/7.p/i", $d['note'])) {
                                            $jam = ' 07:00:00';
                                        } elseif (preg_match("/8m/i", $d['note'])) {
                                            $jam = ' 20:00:00';
                                        } elseif (preg_match("/8 m/i", $d['note'])) {
                                            $jam = ' 20:00:00';
                                        } elseif (preg_match("/8.m/i", $d['note'])) {
                                            $jam = ' 20:00:00';
                                        } elseif (preg_match("/8p/i", $d['note'])) {
                                            $jam = ' 08:00:00';
                                        } elseif (preg_match("/8 p/i", $d['note'])) {
                                            $jam = ' 08:00:00';
                                        } elseif (preg_match("/8.p/i", $d['note'])) {
                                            $jam = ' 08:00:00';
                                        } elseif (preg_match("/9m/i", $d['note'])) {
                                            $jam = ' 21:00:00';
                                        } elseif (preg_match("/9 m/i", $d['note'])) {
                                            $jam = ' 21:00:00';
                                        } elseif (preg_match("/9.m/i", $d['note'])) {
                                            $jam = ' 21:00:00';
                                        } elseif (preg_match("/9p/i", $d['note'])) {
                                            $jam = ' 09:00:00';
                                        } elseif (preg_match("/9 p/i", $d['note'])) {
                                            $jam = ' 09:00:00';
                                        } elseif (preg_match("/9.p/i", $d['note'])) {
                                            $jam = ' 09:00:00';
                                        } elseif (preg_match("/10/", $d['note'])) {
                                            $jam = ' 10:00:00';
                                        } elseif (preg_match("/11/", $d['note'])) {
                                            $jam = ' 11:00:00';
                                        } elseif (preg_match("/12/", $d['note'])) {
                                            $jam = ' 12:00:00';
                                        } elseif (preg_match("/13/", $d['note'])) {
                                            $jam = ' 13:00:00';
                                        } elseif (preg_match("/14/", $d['note'])) {
                                            $jam = ' 14:00:00';
                                        } elseif (preg_match("/15/", $d['note'])) {
                                            $jam = ' 15:00:00';
                                        } elseif (preg_match("/16/", $d['note'])) {
                                            $jam = ' 16:00:00';
                                        } elseif (preg_match("/17/", $d['note'])) {
                                            $jam = ' 17:00:00';
                                        } elseif (preg_match("/18/", $d['note'])) {
                                            $jam = ' 18:00:00';
                                        } elseif (preg_match("/19/", $d['note'])) {
                                            $jam = ' 19:00:00';
                                        } elseif (preg_match("/20/", $d['note'])) {
                                            $jam = ' 20:00:00';
                                        } elseif (preg_match("/21/", $d['note'])) {
                                            $jam = ' 21:00:00';
                                        } elseif (preg_match("/22/", $d['note'])) {
                                            $jam = ' 22:00:00';
                                        } elseif (preg_match("/23/", $d['note'])) {
                                            $jam = ' 23:00:00';
                                        } elseif (preg_match("/1/", $d['note'])) {
                                            $jam = ' 13:00:00';
                                        } elseif (preg_match("/2/", $d['note'])) {
                                            $jam = ' 14:00:00';
                                        } elseif (preg_match("/3/", $d['note'])) {
                                            $jam = ' 15:00:00';
                                        } elseif (preg_match("/4/", $d['note'])) {
                                            $jam = ' 16:00:00';
                                        } elseif (preg_match("/5/", $d['note'])) {
                                            $jam = ' 17:00:00';
                                        } elseif (preg_match("/6/", $d['note'])) {
                                            $jam = ' 06:00:00';
                                        } elseif (preg_match("/7/", $d['note'])) {
                                            $jam = ' 07:00:00';
                                        } elseif (preg_match("/8/", $d['note'])) {
                                            $jam = ' 08:00:00';
                                        } elseif (preg_match("/9/", $d['note'])) {
                                            $jam = ' 09:00:00';
                                        } else {
                                            $jam = '';
                                        }
                                        echo $d['due_date'] . $jam; ?>', //menampilkan tgl mulai dari tabel
                                end: '<?php

                                        echo $d['due_date'] . $jam; ?>', //menampilkan tgl selesai dari tabel
                                url: 'https://pro.kasir.vip/app/code-<?php echo $d['no_invoice'] ?>',
                                backgroundColor: '<?php
                                                    if ($d['status'] == 'pre order') {
                                                        echo '#dc3545';
                                                    } elseif ($d['status'] == 'process') {
                                                        echo '#40E0D0';
                                                    } elseif ($d['status'] == 'finish') {
                                                        echo '#FFD700';
                                                    } elseif ($d['status'] == 'paid off') {
                                                        echo '#008000';
                                                    } elseif ($d['status'] == 'debt') {
                                                        echo '#FF0070';
                                                    } elseif ($d['status'] == 'Sukses') {
                                                        echo '#008000';
                                                    } elseif ($d['status'] == 'billing') {
                                                        echo '#000';
                                                    } elseif ($d['status'] == 'cancel') {
                                                        echo '#000';
                                                    } elseif ($d['status'] == 'Gagal') {
                                                        echo '#000';
                                                    }
                                                    ?>',
                                borderColor: '<?php
                                                if ($d['status'] == 'pre order') {
                                                    echo '#dc3545';
                                                } elseif ($d['status'] == 'process') {
                                                    echo '#40E0D0';
                                                } elseif ($d['status'] == 'finish') {
                                                    echo '#FFD700';
                                                } elseif ($d['status'] == 'paid off') {
                                                    echo '#008000';
                                                } elseif ($d['status'] == 'debt') {
                                                    echo '#FF0070';
                                                } elseif ($d['status'] == 'Sukses') {
                                                    echo '#008000';
                                                } elseif ($d['status'] == 'billing') {
                                                    echo '#000';
                                                } elseif ($d['status'] == 'cancel') {
                                                    echo '#000';
                                                } elseif ($d['status'] == 'Gagal') {
                                                    echo '#000';
                                                }
                                                ?>'
                            },
                        <?php } ?>
                    ],

                    selectOverlap: function(event) {
                        return event.rendering === 'background';
                    }
                });

                calendar.render();
            });
        </script>


        <script>
            var ctx = document.getElementById("Chart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [{}],
                    datasets: [{
                        label: '',
                        data: [],
                        backgroundColor: [],
                        borderColor: [],
                        borderWidth: 1
                    }],
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>

        <script>
            var kotaCanvas = document.getElementById("salesChart");

            Chart.defaults.global.defaultFontFamily = "Helvetica";
            Chart.defaults.global.defaultFontColor = "black";
            Chart.defaults.global.defaultFontSize = 11;

            var dataFirst = {
                label: "Pemasukan",
                <?php

                $tanggal_awal = date('Y-m-01');
                $tanggal_akhir = date('Y-m-t');

                //untuk mengambil nilai pencapaian pemasukan

                $sql_pemasukan      = "SELECT date, 
                SUM(IF(sales_data.totalpay <= sales_data.totalorder, sales_data.totalorder+sales_data.changepay, sales_data.totalpay-sales_data.changepay))as total 
                FROM sales_data WHERE user='$_SESSION[namauser]' AND status NOT IN ('cancel') AND date BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY date";
                $query_pemasukan    = mysqli_query($connect, $sql_pemasukan);

                //untuk mengambil nilai pencapaian pengeluaran
                $sql_pengeluaran    = "SELECT date, SUM(totalnominal) as total FROM spending_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY date";
                $query_pengeluaran  = mysqli_query($connect, $sql_pengeluaran);

                //untuk mengambil nilai pencapaian belanja produk
                $sql_belanja_produk = "SELECT date, SUM(totalorder) as total FROM purchasing_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY date";
                $query_belanja_produk = mysqli_query($connect, $sql_belanja_produk);

                //untuk mengambil nilai pencapaian pre order masuk
                //SELECT date, SUM(totalpay) as total FROM sales_data WHERE user='082322345757' AND due_date !='0000-00-00' AND status IN ('pre order', 'finish') AND date BETWEEN '2022-10-01' AND '2022-10-12' GROUP BY date
                $sql_po = "SELECT date, SUM(totalpay) as total FROM sales_data WHERE user='$_SESSION[namauser]' AND due_date !='0000-00-00' AND status IN ('pre order', 'finish') AND date BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY date";
                $query_po = mysqli_query($connect, $sql_po);

                //untuk mengambil bulan dari januari sampai juni
                $sql_label          = "SELECT date FROM sales_data WHERE user='$_SESSION[namauser]' AND date BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY date ";
                $query_label        = mysqli_query($connect, $sql_label);
                ?>
                data: [
                    <?php foreach ($query_pemasukan as $key) {
                        echo  '"' . $key['total'] . '",';
                    }
                    ?>
                ],
                lineTension: 0.3,
                fill: false,
                borderColor: 'green',
                backgroundColor: 'transparent',
                pointBorderColor: 'green',
                pointBackgroundColor: 'green',
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHitRadius: 7,
                pointBorderWidth: 1,
                pointStyle: 'rect',
            };

            var datathird = {
                label: "Belanja Produk",
                data: [
                    <?php foreach ($query_belanja_produk as $key) {
                        echo  '"' . $key['total'] . '",';
                    }
                    ?>
                ],
                lineTension: 0.3,
                fill: false,
                borderColor: 'red',
                backgroundColor: 'transparent',
                pointBorderColor: 'red',
                pointBackgroundColor: 'red',
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHitRadius: 7,
                pointBorderWidth: 1,
                pointStyle: 'rect'
            };


            var dataSecond = {
                label: "Pengeluaran",
                data: [
                    <?php foreach ($query_pengeluaran as $key) {
                        echo  '"' . $key['total'] . '",';
                    }
                    ?>
                ],
                lineTension: 0.3,
                fill: false,
                borderColor: 'blue',
                backgroundColor: 'transparent',
                pointBorderColor: 'blue',
                pointBackgroundColor: 'blue',
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHitRadius: 7,
                pointBorderWidth: 1,
                pointStyle: 'cross'
            };



            var kotaData = {
                labels: [<?php foreach ($query_label as $key) {
                                echo  '"' . $key['date'] . '",';
                            } ?>],
                datasets: [dataFirst, dataSecond, datathird]
            };

            var chartOptions = {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        fontColor: 'black'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            userCallback: function(label, index, labels) {
                                // when the floored value is the same as the value we have a whole number
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 0,
                        }
                    }]

                },


            };

            var lineChart = new Chart(kotaCanvas, {
                type: 'line',
                data: kotaData,
                options: chartOptions
            });
        </script>
        <script>
            PDFObject.embed("https://zieda.id/pro/pdf/produksi_pagi.php?tanggal_awal=2023-01-21&tanggal_akhir=2023-01-21&user=082322345757", "#pdf-viewer", {
                pdfOpenParams: {
                    view: "FitH",
                    pagemode: "thumbs"
                }
            });
        </script>

        <script>
            PDFObject.embed("https://zieda.id/pro/pdf/produksi.php?tanggal_awal=2023-01-22&tanggal_akhir=2023-01-22&user=082322345757", "#pdf-viewer2", {
                pdfOpenParams: {
                    view: "FitH",
                    pagemode: "thumbs"
                }
            });
        </script>

    <?php } ?>
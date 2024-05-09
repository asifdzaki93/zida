<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?php echo $base_url; ?>/assets/img/branding/ZIEDA.png" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/fonts/materialdesignicons.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/fonts/fontawesome.css" />
<!-- Menu waves for no-customizer fix -->
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/node-waves/node-waves.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/fullcalendar/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/apex-charts/apex-charts.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/swiper/swiper.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/select2/select2.css" />


<!-- Page CSS -->
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/css/pages/app-chat.css" />
<link rel="stylesheet" href="<?php echo $base_url; ?>/admin/js/history.css">
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/css/pages/app-calendar.css" />
<style>
    .card-img-left {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .card-body {
        padding: 10px;
    }

    .card-title,
    .card-text {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }

    .price-text {
        color: red;
        font-weight: bold;
    }

    .floating-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        border: none;
    }
</style>


<audio id="beepSound" src="<?php echo $base_url; ?>assets/audio/beep-29.mp3" style="display: none;"></audio>
<audio id="trash" src="<?php echo $base_url; ?>assets/audio/button-21.mp3" style="display: none;"></audio>



<!-- Helpers -->
<script src="<?php echo $base_url; ?>/assets/vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="<?php echo $base_url; ?>/assets/vendor/js/template-customizer.js"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="<?php echo $base_url; ?>/assets/js/config.js"></script>
<script>
    // Create a JavaScript variable to store the base URL from PHP
    var baseUrl = '<?php echo $base_url; ?>';
</script>
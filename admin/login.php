<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template">

<?php
include 'data/base_sistem.php';
include 'data/koneksi.php';
$error = '';
if ($mysqli->is_auth) {
  header('Location: home.php');
}
if (!empty($_POST['phone_number'])) {
  $phone_number = $mysqli->real_escape_string($_POST['phone_number'] ?? '');
  $password = md5($_POST['password'] ?? '');
  $query = $mysqli->query(
    "SELECT id_session from users where phone_number = '$phone_number' and password = '$password'"
  );
  $result = $query->fetch_assoc();
  if ($result) {
    $_SESSION['id_session'] = $result['id_session'];
    header('Location: home.php');
  } else {
    $error = 'Nomor HP atau Password salah!';
  }
}
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $nameapp ?></title>

    <meta name="description" content="" />

    <?php include 'layout/head.php'; ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendor/css/pages/page-auth.css" />

</head>
<body>
  <!-- Content -->

  <div class="authentication-wrapper authentication-cover">
    <!-- Logo -->
    <a class="auth-cover-brand d-flex align-items-center gap-2">
      <span class="app-brand-logo demo w-px-100">
          <img src="<?php echo $base_url; ?>assets/img/branding/ZIEDA.png" alt="Nama Logo"
                class="app-brand-logo demo w-100">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2"><?= $nameapp ?></span>
    </a>
    <!-- /Logo -->
    <div class="authentication-inner row m-0">
      <!-- /Left Section -->
      <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-5 pb-2">
        <img src="<?php echo $base_url; ?>assets/img/illustrations/auth-login-illustration-light.png" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="illustrations/auth-login-illustration-light.png" data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
        <img src="<?php echo $base_url; ?>assets/img/illustrations/auth-cover-login-mask-light.png" class="authentication-image" alt="mask" data-app-light-img="illustrations/auth-cover-login-mask-light.png" data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
      </div>
      <!-- /Left Section -->

      <!-- Login -->
      <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
        <div class="w-px-400 mx-auto pt-5 pt-lg-0">
          <h4 class="mb-2 fw-semibold">Selamat datang di <?= $nameapp ?>! 👋</h4>
          <p class="mb-4">Silahkan login untuk melanjutkan</p>
          <p class="text-danger mb-2"><?php echo $error; ?></p>
          <form id="formAuthentication" class="mb-3" method="POST">
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="phone_number" name="phone_number"
               placeholder="08xxxxxx" autofocus value="<?php echo $_POST['phone_number'] ?? ''; ?>"/>
              <label for="phone_number">Nomor HP</label>
            </div>
            <div class="mb-3">
              <div class="form-password-toggle">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <label for="password">Password</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3 d-flex justify-content-between">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember-me" id="remember-me" />
                <label class="form-check-label" for="remember-me"> Ingat Saya </label>
              </div>
            </div>
            <button class="btn btn-primary d-grid w-100">Masuk</button>
          </form>
        </div>
      </div>
      <!-- /Login -->
    </div>
  </div>

  <!-- / Content -->
  <?php include 'layout/basic_script.php'; ?>
  </body>
</html>

<?php
session_start();
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'db_zieda';
$user_master = '082322345757';
$id_session = $_SESSION['id_session'] ?? '';
// $id_session = 'abb265f97030e0417a67ee49d877f6cd';

// Koneksi dan memilih database di server
$connect = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno()) {
  echo 'Database connection failed : ' . mysqli_connect_error();
}

//Menggunakan objek mysqli untuk membuat koneksi dan menyimpan nya dalam variabel $mysqli
class NewMysqli extends mysqli
{
  public $data_user;
  public $data_user_avatar = 'https://zieda.id/pro/geten/images/foto/avatar.png';
  public $data_master;
  public $user_master = 'nothing';
  public $user_master_query = "user = 'nothing'";
  public $tanggal_sekarang;
  public $id_session;
  public $is_auth = false;
  public function check_auth()
  {
    if (empty($this->id_session)) {
      $headers = null;
      if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER['Authorization']);
      } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        //Nginx or fast CGI
        $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
      } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(
          array_map('ucwords', array_keys($requestHeaders)),
          array_values($requestHeaders)
        );
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
          $headers = trim($requestHeaders['Authorization']);
        }
      }
      $this->id_session = explode(' ', $headers)[1] ?? '';
    }
    if (empty($this->id_session)) {
      return false;
    } else {
      $id_session = $this->real_escape_string($this->id_session);
      $getusers = $this->query("SELECT * FROM users WHERE id_session='$id_session' AND blokir = 'N'");
      $this->data_user = $getusers->fetch_assoc();
      if ($this->data_user != null) {
        $this->is_auth = true;
        $this->user_master = $this->data_user['master'];
        if (!(empty($this->data_user['img']) || $this->data_user['img'] == 'avatar.png')) {
          $this->data_user_avatar = 'https://zieda.id/pro/geten/images/' . $this->data_user['img'];
        }
        $this->user_master_query = "user = '" . $this->user_master . "'";
        $masterakun = $this->query("SELECT * FROM users WHERE phone_number='" . $this->data_user['master'] . "'");
        $this->data_master = $masterakun->fetch_assoc();
        return true;
      }
      return false;
    }
  }
}
$mysqli = new NewMysqli($server, $username, $password, $database);
$mysqli->set_charset('utf8');

$koneksi = mysqli_connect($server, $username, $password, $database);

$mysqli->id_session = $id_session;
$mysqli->check_auth();
// $mysqli->user_master = $user_master;
// $mysqli->user_master_query = "user = '$user_master'";
$mysqli->tanggal_sekarang = date('2023-08-d');

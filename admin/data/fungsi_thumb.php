<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 20/08/2019
 * Time: 11:48 AM
 */

// Upload gambar
function UploadImage($fupload_name)
{
  //direktori gambar
  $uploaddate = date('m-d-y-H');

  $buatfolder = $_SERVER['DOCUMENT_ROOT'] . '/geten/images/';

  $destination_path = $buatfolder . $uploaddate;
  $namafolder = $buatfolder . $uploaddate . '/';

  if (!is_dir($destination_path)) {
    mkdir($destination_path, 0777);
  }

  $vdir_upload = $namafolder;
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES['img']['tmp_name'], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 200;
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im, $vdir_upload . 'small_' . $fupload_name);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

function UploadFoto($fupload_name)
{
  //direktori gambar
  $uploaddate = date('m-d-y-H');

  $buatfolder = $_SERVER['DOCUMENT_ROOT'] . '/geten/images/foto/';

  $destination_path = $buatfolder . $uploaddate;
  $namafolder = $buatfolder . $uploaddate . '/';

  if (!is_dir($destination_path)) {
    mkdir($destination_path, 0777);
  }

  $vdir_upload = $namafolder;
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES['img']['tmp_name'], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 200;
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im, $vdir_upload . 'small_' . $fupload_name);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

function UploadBanner($fupload_name)
{
  //direktori gambar
  $uploaddate = date('m-d-y-H');

  $buatfolder = $_SERVER['DOCUMENT_ROOT'] . '/geten/images/banner/';

  $destination_path = $buatfolder . $uploaddate;
  $namafolder = $buatfolder . $uploaddate . '/';

  if (!is_dir($destination_path)) {
    mkdir($destination_path, 0777);
  }

  $vdir_upload = $namafolder;
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES['img']['tmp_name'], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 750;
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im, $vdir_upload . 'small_' . $fupload_name);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

function UploadLogo($fupload_name)
{
  //direktori gambar
  $uploaddate = date('m-d-y-H');
  $buatfolder = $_SERVER['DOCUMENT_ROOT'] . '/geten/images/logo/';

  $destination_path = $buatfolder . $uploaddate;
  $namafolder = $buatfolder . $uploaddate . '/';

  if (!is_dir($destination_path)) {
    mkdir($destination_path, 0777);
  }

  $vdir_upload = $namafolder;
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES['img']['tmp_name'], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 165;
  $dst_height = ($dst_width / $src_width) * $src_height;

  $dst_width2 = 500;
  $dst_height = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  $im2 = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im, $vdir_upload . 'small_' . $fupload_name);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

function UploadReceipt($fupload_name)
{
  //direktori gambar
  $uploaddate = date('m-d-y-H');

  $buatfolder = $_SERVER['DOCUMENT_ROOT'] . '/geten/images/receipt/';

  $destination_path = $buatfolder . $uploaddate;
  $namafolder = $buatfolder . $uploaddate . '/';

  if (!is_dir($destination_path)) {
    mkdir($destination_path, 0777);
  }

  $vdir_upload = $namafolder;
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES['img']['tmp_name'], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 200;
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im, $vdir_upload . 'small_' . $fupload_name);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

function UploadOrder($fupload_name)
{
  //direktori gambar
  $uploaddate = date('m-d-y-H');

  $buatfolder = $_SERVER['DOCUMENT_ROOT'] . '/geten/images/order/';

  $destination_path = $buatfolder . $uploaddate;
  $namafolder = $buatfolder . $uploaddate . '/';

  if (!is_dir($destination_path)) {
    mkdir($destination_path, 0777);
  }

  $vdir_upload = $namafolder;
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES['img']['tmp_name'], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 200;
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im, $vdir_upload . 'small_' . $fupload_name);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

<?php
// Ganti URL ini dengan URL Apps Script Web App kamu
$script_url = "https://script.google.com/macros/s/AKfycbyK33rHRq7WUfhii-n5Jm7oLSIY79GYwZFo-Oqe0O0SXtBgazonqhJDOvfwg613zD7uUw/exec";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $post_fields = [
    'jenis_laporan' => $_POST['jenis_laporan'],
    'pelapor' => $_POST['pelapor'],
    'tanggal' => $_POST['tanggal'],
    'waktu' => $_POST['waktu'],
    'lokasi_kejadian' => $_POST['lokasi_kejadian'],
    'deskripsi' => $_POST['deskripsi'],
    'nama' => $_POST['nama'],
    'kontak' => $_POST['kontak']
  ];

  // File handling
  $file_tmp = $_FILES['file_upload']['tmp_name'];
  $file_name = $_FILES['file_upload']['name'];
  $file_type = $_FILES['file_upload']['type'];

  $cfile = new CURLFile($file_tmp, $file_type, $file_name);
  $post_fields['file_upload'] = $cfile;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $script_url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  if(curl_errno($ch)){
    echo "Gagal: " . curl_error($ch);
  } else {
    echo "Respon: " . $response;
    header("Location: index_2.php?status=success");
  }
  curl_close($ch);
}

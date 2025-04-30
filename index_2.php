<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Form Laporan</title>
</head>
<body>
  <form method="POST" enctype="multipart/form-data">
    <label>Nama:</label>
    <input type="text" name="nama"><br>
    <label>Kontak:</label>
    <input type="text" name="kontak"><br>
    <label>Jenis Laporan:</label>
    <select name="jenis_laporan">
      <option value="Kekerasan">Kekerasan</option>
      <option value="Pelecehan">Pelecehan</option>
    </select><br>
    <label>Pelapor:</label>
    <select name="pelapor">
      <option value="Korban">Korban</option>
      <option value="Saksi">Saksi</option>
    </select><br>
    <label>Tanggal Kejadian:</label>
    <input type="date" name="tanggal"><br>
    <label>Waktu Kejadian:</label>
    <input type="time" name="waktu"><br>
    <label>Lokasi Kejadian:</label>
    <input type="text" name="lokasi_kejadian"><br>
    <label>Deskripsi:</label>
    <textarea name="deskripsi"></textarea><br>
    <label>Bukti (file):</label>
    <input type="file" name="file_upload"><br>
    <button type="submit" name="submit">Kirim</button>
  </form>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
  $script_url = "https://script.google.com/macros/s/AKfycbw3RphWFqRxpsqWyH9yULfaNzNuGC9cbg7InyLsRfGQJ2hn4gRGUgGDki74pmRyHaj4-A/exec"; // Ganti dengan URL Apps Script kamu

  $postData = [
    'nama' => $_POST['nama'],
    'kontak' => $_POST['kontak'],
    'jenis_laporan' => $_POST['jenis_laporan'],
    'pelapor' => $_POST['pelapor'],
    'tanggal' => $_POST['tanggal'],
    'waktu' => $_POST['waktu'],
    'lokasi_kejadian' => $_POST['lokasi_kejadian'],
    'deskripsi' => $_POST['deskripsi'],
  ];

  // Proses file upload
  if (!empty($_FILES['file_upload']['tmp_name'])) {
    $file_content = file_get_contents($_FILES['file_upload']['tmp_name']);
    $postData['file_upload'] = base64_encode($file_content);
    $postData['file_name'] = $_FILES['file_upload']['name'];
    $postData['file_type'] = $_FILES['file_upload']['type'];
  }

  // Setup cURL request
  $ch = curl_init($script_url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // Send the request
  $result = curl_exec($ch);
  if(curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
  } else {
    echo "<script>alert(" . json_encode($result) . ")</script>";
    
  }

  curl_close($ch);
}
?>



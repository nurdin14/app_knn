<?php
  $conn = mysqli_connect('localhost', 'root', '', 'db_knn'); // Ganti 'nama_database' dengan nama database yang digunakan

  if(isset($_POST['simpan'])){
    // Data yang akan diprediksi
    $prediksi = [
      'ips' => $_POST['ips'],
      'jks' => $_POST['jks'],
      'k' => $_POST['k'],
    ];

    // Jumlah tetangga terdekat
    $k = $prediksi['k'];

    // Ambil data dari tabel tb_nilai
    $dataset = mysqli_query($conn, "SELECT * FROM tb_nilai");

    // Fetch data dari hasil query
    $dataset_array = [];
    while ($value = mysqli_fetch_assoc($dataset)) {
        $dataset_array[] = $value;
    }

    // Hitung jarak antara data prediksi dengan data lain dalam dataset
    foreach ($dataset_array as $key => $value) {
     $jarak = sqrt(pow($value['ips'] - $prediksi['ips'], 2)+
                   pow($value['jks'] - $prediksi['jks'], 2));
      $dataset_array[$key]["jarak"] = $jarak;
    }

    // Urutkan data siswa berdasarkan jarak terdekat
    usort($dataset_array, function($a, $b) {
      return $a["jarak"] - $b["jarak"];
    });

    // Tentukan k data terdekat
    $k_set = array_slice($dataset_array, 0, $k);

    // Hitung frekuensi setiap kelas pada k tetangga terdekat
    $frekuensi = array("Naik" => 0, "Turun" => 0);
    foreach ($k_set as $value) {
      if ($value["keterangan"] == "Naik") {
        $frekuensi["Naik"]++;
      } else {
        $frekuensi["Turun"]++;
      }
    }
    
    // // Hitung persentase
    // $total_k = $frekuensi["Naik"] + $frekuensi["Turun"];
    // $persentase_naik = ($frekuensi["Naik"] / $total_k) * 100;
    // $persentase_turun = ($frekuensi["Turun"] / $total_k) * 100;
    
    // Tentukan prediksi kelas
    if ($frekuensi["Naik"] > $frekuensi["Turun"]) {
      $prediksi_kelas = "Naik";
    } else {
      $prediksi_kelas = "Turun";
    }

    // Menghitung akurasi prediksi
    $akurasi = 0;
    foreach ($k_set as $value) {
      if ($value["keterangan"] == $prediksi_kelas) {
        $akurasi++;
      }
    }
    $akurasi = ($akurasi / $k) * 100;
  }
?>

<b>Dataset</b>
<table border="1">
  <tr>
    <th>No.</th>
    <th>Semester</th>
    <th>IPS</th>
    <th>JKS</th>
    <th>Kelas</th>
  </tr>
<?php
  // Ambil data dari tabel tb_nilai
  $dataset = mysqli_query($conn, "SELECT * FROM tb_nilai");
  $no = 1;
  while ($row = mysqli_fetch_assoc($dataset)) {
?>
    <tr>
      <td><?= $no++; ?></td>
      <td><?= $row['id_nilai']; ?></td>
      <td><?= $row['ips']; ?></td>
      <td><?= $row['jks']; ?></td>
      <td><?= $row['keterangan']; ?></td>
    </tr>
<?php
  }
?>
</table>
<br>

<form action="" method="post">
  <table>
    <tr>
        <td>IPS</td>
        <td>:</td>
        <td>
          <input type="text" name="ips">
        </td>
    </tr>
    <tr>
        <td>Jumlah SKS</td>
        <td>:</td>
        <td>
          <input type="text" name="jks">
        </td>
    </tr>
    <tr>
        <td>Jumlah K</td>
        <td>:</td>
        <td>
          <input type="text" name="k">
        </td>
    </tr>
    <tr>
      <td><button type="submit" name="simpan">Prediksi</button></td>
    </tr>
</table>
<?php 
  if(isset($_POST['simpan'])){
?>

<hr>
<b>Hitung Jarak</b>
<table border="1">
  <tr>
    <th>No.</th>
    <th>IPS</th>
    <th>Jumlah SKS</th>
    <th>Kelas</th>
    <th>Jarak</th>
  </tr>
  <?php
    $no = 1;
    foreach ($dataset_array as $data) {
      ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $data['ips']; ?></td>
        <td><?= $data['jks']; ?></td>
        <td><?= $data['keterangan']; ?></td>
        <td><?= $data['jarak'];?></td>
      </tr>
    <?php } ?>
</table>

<hr>
<b>Ambil K Data Jarak Terkecil</b>
<table border="1">
  <tr>
    <th>Semester</th>
    <th>IPS</th>
    <th>Jumlah SKS</th>
    <th>Kelas</th>
    <th>Jarak</th>
  </tr>
<?php 
    foreach ($k_set as $value) {
?>
      <tr>
        <td><?= $value['id_nilai']; ?></td>
        <td><?= $value['ips']; ?></td>
        <td><?= $value['jks']; ?></td>
        <td><?= $value['keterangan']; ?></td>
        <td><?= $value["jarak"]; ?></td>
      </tr>      
<?php } ?>
</table>

<?php 
    // Hasil Prediksi
?>
  <hr>
  <b>Hasil Prediksi</b>
  <table border="1" cell-padding="2" cell-spacing="0">
    <tr>
        <td>IPS</td>
        <td>:</td>
        <td><?= $prediksi["ips"]; ?></td>
    </tr>
    <tr>
        <td>Keteranggan</td>
        <td>:</td>
        <td>Kesimpulannya kemungkinan Anda akan <?= $prediksi_kelas; ?></td>
    </tr>
    <tr>
        <td>Akurasi</td>
        <td>:</td>
        <td>Akurasi prediksi sebesar <?= number_format($akurasi, 0); ?>%</td>
    </tr>
  </table>
<?php } ?>
</form>

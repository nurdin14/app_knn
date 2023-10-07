<b>Dataset</b>
<table border="1">
  <tr>
    <th>No.</th>
    <th>Nama</th>
    <th>Jumlah SKS</th>
    <th>IPK</th>
    <th>Kelas</th>
  </tr>
<?php 
  $dataset = array(
        array("No." => 1, "nama" => "Dodi", "jks" => 24, "ipk" =>89, "kelas" => "Naik"),
        array("No." => 2, "nama" => "Didi", "jks" => 24, "ipk" =>55, "kelas" => "Turun"),
        array("No." => 3, "nama" => "Dede", "jks" => 12, "ipk" =>90, "kelas" => "Naik"),
        array("No." => 4, "nama" => "Didin", "jks" => 18, "ipk" =>60, "kelas" => "Turun"),
        array("No." => 5, "nama" => "Nurdin", "jks" => 13, "ipk" =>55, "kelas" => "Turun")
    );
  $no = 1;
  foreach ($dataset as $v) : ?>

      <tr>
        <td><?= $no++; ?></td>
        <td><?= $v['nama']; ?></td>
        <td><?= $v['jks']; ?></td>
        <td><?= $v['ipk']; ?></td>
        <td><?= $v['kelas']; ?></td>
      </tr>
<?php endforeach; ?>
  </table>
  <br>
<form action="" method="post">
  <table>
    <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="nama"></td>
    </tr>
    <tr>
        <td>Jumlah SKS</td>
        <td>:</td>
        <td>
          <input type="text" name="jks">
        </td>
    </tr>
    <tr>
        <td>IPK</td>
        <td>:</td>
        <td>
          <input type="text" name="ipk">
        </td>
    </tr>
    <tr>
      <td><button type="submit" name="simpan">Prediksi</button></td>
    </tr>
</table>
<?php 
  if(isset($_POST['simpan'])){

    // Data yang akan diprediksi
    $prediksi = [
      'nama' => $_POST['nama'],
      'jks' => $_POST['jks'],
      'ipk' => $_POST['ipk']
    ];

    // Jumlah tetangga terdekat
    $k = 3;
?>

<hr>
<b>Hitung Jarak</b>
<table border="1">
  <tr>
    <th>No.</th>
    <th>Nama</th>
    <th>Jumlah SKS</th>
    <th>IPK</th>
    <th>Kelas</th>
    <th>Jarak</th>
  </tr>
  <?php
    // Hitung jarak antara data prediksi dengan data lain dalam dataset
    $no = 1;
    foreach ($dataset as $key => $value) { 
      $jarak = sqrt(pow($value['jks'] - $prediksi['jks'], 2)+
                    pow($value['ipk'] - $prediksi['ipk'], 2));
      $dataset[$key]["jarak"] = $jarak;      
      ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $value['nama']; ?></td>
        <td><?= $value['jks']; ?></td>
        <td><?= $value['ipk']; ?></td>
        <td><?= $value['kelas']; ?></td>
        <td><?= number_format($dataset[$key]["jarak"], 0); ?></td>
      </tr>
    <?php } ?>
 
</table>

<hr>
<b>Ambil K Data Jarak Terkecil</b>
<table border="1">
  <tr>
    <th>Nama</th>
    <th>Jumlah SKS</th>
    <th>IPK</th>
    <th>Kelas</th>
    <th>Jarak</th>
  </tr>
<?php 
    // Urutkan data siswa berdasarkan jarak terdekat
    usort($dataset, function($a, $b) {
      return $a["jarak"] - $b["jarak"];
    });

    // Tentukan k data terdekat
    $k_set = array_slice($dataset, 0, $k);
    // Hitung frekuensi setiap kelas pada k tetangga terdekat
    $frekuensi = array("Naik" => 0, "Turun" => 0);
    foreach ($k_set as $value) {
      if ($value["kelas"] == "Naik") {
        $frekuensi["Naik"]++;
        $hitung_naik = count(array_filter($k_set, function($data) { return $data["kelas"] == "Naik"; })) / count($dataset) * 100;
      } else {
        $frekuensi["Turun"]++;
        $hitung_turun = count(array_filter($k_set, function($data) { return $data["kelas"] == "Turun"; })) / count($dataset) * 100;
      } ?>
      <tr>
        <td><?= $value['nama']; ?></td>
        <td><?= $value['jks']; ?></td>
        <td><?= $value['ipk']; ?></td>
        <td><?= $value['kelas']; ?></td>
        <td><?= number_format($value["jarak"], 0); ?></td>
      </tr>      
<?php } ?>
      <tr>
        <td colspan = "4" align="right">Naik</td>
        <td><?= $hitung_naik; ?>%</td>
      </tr>
      <tr>
        <td colspan = "4" align="right">Turun</td>
        <td><?= $hitung_turun; ?>%</td>
      </tr>
</table>

<?php 
    // Tentukan prediksi kelas
    if ($frekuensi["Naik"] > $frekuensi["Turun"]) {
      $prediksi_kelas = 1;
    } else {
      $prediksi_kelas = 0;
    }
?>
  <hr>
  <b>Hasil Prediksi</b>
  <table border="1" cell-padding="2" cell-spacing="0">
    <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><?= $prediksi["nama"]; ?></td>
    </tr>
    <tr>
        <td>Jumlah SKS</td>
        <td>:</td>
        <td><?= $prediksi["jks"]; ?></td>
    </tr>
    <tr>
        <td>IPK</td>
        <td>:</td>
        <td><?= $prediksi["ipk"]; ?></td>
    </tr>
    <tr>
        <td>Keteranggan</td>
        <td>:</td>
        <td>Kesimpulannya kemungkinan anda akan <?= ($prediksi_kelas == 1 ? "Naik" : "Turun"); ?></td>
    </tr>

</table>
<?php } ?>
</form>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KNN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <h2>--</h2>
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="../logout.php"> Logout
          <i class="fas fa-user"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light"> <h2>E-Prediksi</h2></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php 
              session_start();
              if($_SESSION['level'] =="") {
                header('location:../login.php');
              }
              echo $_SESSION['level'];
            ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if ($_SESSION['level'] == "Mahasiswa" and $_SESSION['level'] == "Dosen") { ?>
            <li class="nav-item menu-open" style="display:none">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Manage Data
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../list-mhs/v_tampil.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Mahasiswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../list-nilai/v_tampil.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Nilai</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } else if ($_SESSION['level'] == "Admin") { ?>
              <li class="nav-item menu-open">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-edit"></i>
                  <p>
                    Manage Data
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../list-mhs/v_tampil.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Mahasiswa</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../list-nilai/v_tampil.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Nilai</p>
                    </a>
                  </li>
                </ul>
              </li>
          <?php } ?>
          <li class="nav-item">
            <a href="v_tampil.php" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Prediksi
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= $_SESSION['level'] ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $_SESSION['level'] ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                           <h3>Form Prediksi</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="" method="post">
                              <?php
                                include '../koneksi/conn.php'; 
                                $id = $_GET['id_mhs'];
                                $arr = mysqli_query($conn, "SELECT * FROM tb_nilai where id_mhs = '$id'");
                                while($m = mysqli_fetch_assoc($arr)){
                              ?>
                              <div class="form-group row">
                                  <label for="inputEmail3" class="col-sm-2 col-form-label">IPS</label>
                                  <div class="col-sm-10">
                                  <input type="text" name="ips" value="<?= $m['ips'] ?>" class="form-control" placeholder="Masukan Nilai IPS Terakhir">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="inputEmail3" class="col-sm-2 col-form-label">SKS</label>
                                  <div class="col-sm-10">
                                  <input type="text" name="jks" value="<?= $m['jks'] ?>" class="form-control" placeholder="Masukan Jumlah SKS">
                                  </div>
                              </div>
                              <?php } ?>
                              <div class="form-group row">
                                  <label for="inputEmail3" class="col-sm-2 col-form-label">K</label>
                                  <div class="col-sm-10">
                                  <input type="number" name="k" class="form-control" placeholder="Masukan K Misal K = 3">
                                  </div>
                              </div>
                              
                              </div>
                              <!-- /.card-body -->
                              <div class="card-footer">
                              <button type="submit" name="kirim" class="btn btn-info">Proses</button>
                              </div>
                              <!-- /.card-footer -->
                          
                          <?php 
                                if(isset($_POST['kirim'])) {
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
                                
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">Hitung Jarak</div>
                  <div class="card-body">
                    <table class="table table-bordered table-striped">
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
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="card-header">Ambil Data Jarak Terkecil</div>
                  <div class="card-body">
                    <table class="table table-bordered table-striped">
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
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="card-header">Hasil Prediksi</div>
                  <div class="card-body">
                    <table class="table table-bordered table-striped">
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
                  </div>
                </div>
              </div>
            </div>
        </div>

</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>E-inventory</strong>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../assets/plugins/moment/moment.min.js"></script>
<script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../assets/dist/js/pages/dashboard.js"></script>
<!-- DataTables  & Plugins -->
<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/plugins/jszip/jszip.min.js"></script>
<script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
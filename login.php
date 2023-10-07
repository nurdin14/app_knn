<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Prediksi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>--Silahkan Login--</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Useraname" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col">
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
        <?php 
          include 'koneksi/conn.php';
          session_start();
          if(isset($_POST['login'])) {

            $username = $_POST['username'];
            $password = $_POST['password'];
  
            $query = mysqli_query($conn, "SELECT * FROM tb_login where username='$username' and password='$password'");
            $cek = mysqli_num_rows($query);
  
            if($cek > 0) {
              $data = mysqli_fetch_assoc($query);
              if($data['level'] == "Akademik")
              {
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 'Akademik';
                header("location:list-mhs/v_tampil.php");
              } else if ($data['level'] == "Dosen"){
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 'Dosen';
                header("location:prediksi/v_tampil.php");
              } else if($data['level'] == "Mahasiswa"){
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 'Mahasiswa';
                header("location:prediksi/v_tampil.php");
              } else {
                echo "Username dan Password anda tidak ditemukan";
              }
            }
          }

        ?>
      </form>

      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>

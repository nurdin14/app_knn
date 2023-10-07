<?php
include '../koneksi/conn.php';
    $id = $_GET['id_mhs'];
    $query = mysqli_query($conn, "DELETE FROM tb_mhs WHERE id_mhs = '$id'");
    if($query)
        {
            echo "<script>
                    alert('Data Berhasil Dihapus');
                    window.location='v_tampil.php'
                  </script>";
        } else {
            echo "<script>
            alert('Data Gagal Dihapus');
            window.location='v_tampil.php'
          </script>";
        }
?>
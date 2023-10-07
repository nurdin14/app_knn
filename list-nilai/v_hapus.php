<?php
include '../koneksi/conn.php';
    $id = $_GET['id_nilai'];
    $query = mysqli_query($conn, "DELETE FROM tb_nilai WHERE id_nilai = '$id'");
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
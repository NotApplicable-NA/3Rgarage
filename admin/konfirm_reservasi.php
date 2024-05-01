<?php

include '../components/connect.php';

//session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_reservasi'])){
   $reservasi_id = $_POST['reservasi_id'];
   $reservasi_status = $_POST['reservasi_status'];
   $reservasi_status = filter_var($reservasi_status, FILTER_SANITIZE_STRING);
   $update_reservasi = $conn->prepare("UPDATE `reservasi` SET reservasi_status = ? WHERE id = ?");
   $update_reservasi->execute([$reservasi_status, $reservasi_id]);
   $message[] = 'status reservasi diperbarui!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_reservasi = $conn->prepare("DELETE FROM `reservasi` WHERE id = ?");
   $delete_reservasi->execute([$delete_id]);
   header('location:reservasi_reservasi.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reservasi Service Motor</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">Reservasi Service Motor.</h1>

<div class="box-container">

   <?php
      $select_reservasi = $conn->prepare("SELECT * FROM `reservasi` ORDER BY tanggal");
      $select_reservasi->execute();
      if($select_reservasi->rowCount() > 0){
         $no_order = 1;
         while($fetch_reservasi = $select_reservasi->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Nomor Order : <span><?= $fetch_reservasi['no_order']; ?></span> </p>
      <p> Reservasi Masuk : <span><?= $fetch_reservasi['ditetapkan']; ?></span> </p>
      <p> Nama : <span><?= $fetch_reservasi['name']; ?></span> </p>
      <p> Jenis Motor : <span><?= $fetch_reservasi['motor']; ?></span> </p>
      <p> Plat Nomor : <span><?= $fetch_reservasi['plat']; ?></span> </p>
      <p> Tanggal Reservasi : <span><?= $fetch_reservasi['tanggal']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="reservasi_id" value="<?= $fetch_reservasi['id']; ?>">
         <select name="reservasi_status" class="select">
            <option selected disabled><?= $fetch_reservasi['reservasi_status']; ?></option>
            <option value="pending">Tolak</option>
            <option value="completed">Terima</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="update" class="option-btn" name="update_reservasi">
         <a href="ditetapkan.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('hapus pesanan?');">hapus</a>
        </div>
      </form>
   </div>
   <?php
   $no_order++;
         }
      }else{
         echo '<p class="empty">tidak ada pesanan ditetapkan!</p>';
      }
   ?>

</div>

</section>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>
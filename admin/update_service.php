<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_service'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $select_service = $conn->prepare("SELECT * FROM `jenis_service` WHERE name = ?");
   $select_service->execute([$name]);

   if($select_service->rowCount() > 0){
      $message[] = 'Jenis service sudah ada!';
   }else{

      $insert_service = $conn->prepare("INSERT INTO `jenis_service`(name, details, price) VALUES(?,?,?)");
      $insert_service->execute([$name, $details, $price]);
      $message[] = 'Jenis service baru berhasil ditambahkan!';
   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_service = $conn->prepare("DELETE FROM `jenis_service` WHERE id = ?");
   header('location:update_service.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Jenis Service</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-service">

   <h1 class="heading">Tambahkan Produk</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>jenis_service (wajib)</span>
            <input type="text" class="box" required maxlength="100" placeholder="masukkan jenis" name="name">
         </div>
         <div class="inputBox">
            <span>Harga service (wajib)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="masukkan harga service" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
         <div class="inputBox">
            <span>Deskripsi Service (wajib)</span>
            <textarea name="details" placeholder="masukkan deskripsi service" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      
      <input type="submit" value="Tambahkan Jenis Service" class="btn" name="add_service">
   </form>

</section>

<section class="show-service">

   <h1 class="heading">Jenis Service Ditambahkan.</h1>

   <div class="box-container">

   <?php
      $select_service = $conn->prepare("SELECT * FROM `jenis_service`");
      $select_service->execute();
      if($select_service->rowCount() > 0){
         while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <div class="name"><?= $fetch_service['name']; ?></div>
      <div class="price">Rp.<span><?= $fetch_service['price']; ?></span>/-</div>
      <div class="details"><span><?= $fetch_service['details']; ?></span></div>
      <div class="flex-btn">
         <a href="ubah_service.php?update=<?= $fetch_service['id']; ?>" class="option-btn">update</a>
         <a href="update_service.php?delete=<?= $fetch_service['id']; ?>" class="delete-btn" onclick="return confirm('hapus jenis service ini?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">belum ada jenis service yang ditambahkan!</p>';
      }
   ?>
   
   </div>

</section>








<script src="../js/admin_script.js"></script>
   
</body>
</html>
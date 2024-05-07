<?php

include 'components/connect.php';


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'pemesanan berhasil dilakukan!';
   }else{
      $message[] = 'keranjang kosong';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header_shop.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Pesanan Anda</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= 'Rp.'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">keranjang kosong!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Total : <span>Rp.<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>tempatkan pesanan anda</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Nama anda :</span>
            <input type="text" name="name" placeholder="masukkan nama anda" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Nomor anda :</span>
            <input type="number" name="number" placeholder="masukkan nomor anda" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email anda:</span>
            <input type="email" name="email" placeholder="masukkan email anda" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Metode Pembayaran :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash On Delivery</option>
               <option value="credit card">Credit Card</option>
               <option value="paytm">utang dulu</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Nama Jalan/perumahan :</span>
            <input type="text" name="flat" placeholder="Masukkan nama Jalan/Perumahan" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Desa/Kecamatan :</span>
            <input type="text" name="street" placeholder="Masukkan nama Desa/Kecamatan" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Kabupaten/Kota :</span>
            <input type="text" name="city" placeholder="Masukkan nama Kabupaten/Kota" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Provinsi:</span>
            <input type="text" name="state" placeholder="Masukkan nama Provinsi" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Negara :</span>
            <input type="text" name="country" placeholder="Masukkan nama Negara" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Kode pos :</span>
            <input type="number" min="0" name="pin_code" placeholder="Masukkan Kode Pos, isi (-) jika tidak mengetahui kode pos" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'enabeled'; ?>" value="pesan">

   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
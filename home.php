<?php

include 'components/connect.php';


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>3R Garage</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/oli1.jpeg" alt="">
         </div>
         <div class="content">
            <span>Sedia berbagai macam oli motor</span>
            <h3>Harga bersaing</h3>
            <a href="home.php" class="btn">Belanja Sekarang</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/spare.jpg" alt="">
         </div>
         <div class="content">
         <span>Sedia berbagai Sparepart Motor</span>
            <h3>Harga bersaing</h3>
            <a href="category.php?category=smartphone" class="btn">Belanja Sekarang</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/ban.jpg" alt="">
         </div>
         <div class="content">
            <span>Sedia berbagai Sparepart Motor</span>
            <h3>Harga bersahabat</h3>
            <a href="shop.php" class="btn">Belanja Sekarang.</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <h1 class="heading">Pilih Layanan Sesuai Kebutuhan Anda</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="reservasi.php" class="swiper-slide slide">
   <img src="images/icon-3.png" alt="">
      <h3>Reservasi Service</h3>
   </a>

   <a href="category.php?category=tv" class="swiper-slide slide">
   <img src="images/icon-3.png" alt="">
      <h3>Reservasi Service di rumah</h3>
   </a>
   <a href="category.php?category=camera" class="swiper-slide slide">
   <img src="images/icon-3.png" alt="">
      <h3>Reservasi Service Emergency</h3>
   </a>
   <a href="shopp.php" class="swiper-slide slide">
   <img src="images/icon-3.png" alt="">
      <h3>Belanja Sparepart</h3>
   </a>


   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>










<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 4,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 1,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
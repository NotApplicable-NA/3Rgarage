<?php

include 'components/connect.php';


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

$hari_ini=date("Y-n-j");
$query="SELECT tanggal,antrian FROM tb_antrian WHERE tanggal='$hari_ini' LIMIT 1";
$result=mysqli_query($query) or die(mysqli_error());
if(mysqli_num_rows($result)>0)
{
	//jika ada maka ambil nilainya
	$row=mysqli_fetch_array($result);
	$antrian=$row['antrian'];
	$query="UPDATE tb_antrian set antrian=antrian+1 WHERE tanggal='$hari_ini' LIMIT 1";
	mysqli_query($query) or die(mysqli_error());
}
else
{
	//jika tidak ada maka sisipkan data
	$antrian=1;
	$query="INSERT INTO tb_antrian(tanggal,antrian) VALUES('$hari_ini',1)";
	mysqli_query($query) or die(mysqli_error());
}
if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $motor = $_POST['motor'];
   $motor = filter_var($motor, FILTER_SANITIZE_STRING);
   $plat = $_POST['plat'];
   $plat = filter_var($plat, FILTER_SANITIZE_STRING);
   $tanggal = $_POST['tanggal'];
   $tanggal = filter_var($tanggal, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `reservasi` WHERE name = ? AND motor = ? AND plat = ? AND tanggal = ?");
   $select_message->execute([$name, $motor, $plat, $tanggal]);

   if($select_message->rowCount() > 0){
      $message[] = 'reservasi telah dilakukan';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `reservasi`(user_id, name, motor, plat, tanggal) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $motor, $plat, $tanggal]);

      $message[] = 'Reservasi terkirim';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reservasi Service Motor</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Reservasi Service Motor</h3>
      <input type="text" name="name" placeholder="masukkan nama" required maxlength="20" class="box">
      <input type="text" name="motor" placeholder="masukkan jenis motor" required maxlength="50" class="box">
      <input type="text" name="plat" placeholder="masukkan plat nomor" required maxlength="20" class="box">
      <input type="date" name="tanggal" placeholder="masukkan tanggal reservasi" class="box">
      <input type="submit" value="Kirim Reservasi" name="send" class="btn">
   </form>

</section>












<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
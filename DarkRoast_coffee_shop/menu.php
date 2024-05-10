<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   $product_calories = $_POST['product_calories'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image, calories) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image', '$product_calories')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h1> MENU </h1>
   <p> <a href="home.php">home</a> / <a href="menu.php">menu</a></p>
</div>

<section class="products">

   <h1 class="title">Coffee Options</h1>

   <div class="box-container">
      <!-- Predefined coffee items -->
      <form action="" method="post" class="box">
         <img class="image" src="images/spanish-shop1.jpeg" alt="Spanich Coffee">
         <div class="name">Spanich Coffee</div>
         <div class="name">23 SAR</div>
         <div class="calories">Calories: 100</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="Spanich Coffee">
         <input type="hidden" name="product_price" value="23">
         <input type="hidden" name="product_image" value="spanich-shop1.jpeg">
         <input type="hidden" name="product_calories" value="100">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>

      <form action="" method="post" class="box">
         <img class="image" src="images/latte-shop5.jpeg" alt="Latte Coffee">
         <div class="name">Latte Coffee</div>
         <div class="name">17 SAR</div>
         <div class="calories">Calories: 118</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="Latte Coffee">
         <input type="hidden" name="product_price" value="17">
         <input type="hidden" name="product_image" value="latte-shop5.jpeg">
         <input type="hidden" name="product_calories" value="118">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>

      <form action="" method="post" class="box">
         <img class="image" src="images/flat-shop2.jpeg" alt="Flat White Coffee">
         <div class="name">Flat White Coffee</div>
         <div class="name">20 SAR</div>
         <div class="calories">Calories: 110</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="Flat White Coffee">
         <input type="hidden" name="product_price" value="20">
         <input type="hidden" name="product_image" value="falt-shop2.jpeg">
         <input type="hidden" name="product_calories" value="110">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>

      <form action="" method="post" class="box">
         <img class="image" src="images/cortado-shop3.jpeg" alt="Cortado Coffee">
         <div class="name">Cortado Coffee</div>
         <div class="name">21 SAR</div>
         <div class="calories">Calories: 102</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="Cortado Coffee">
         <input type="hidden" name="product_price" value="21">
         <input type="hidden" name="product_image" value="cortado-shop3.jpeg">
         <input type="hidden" name="product_calories" value="102">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
       
         <form action="" method="post" class="box">
         <img class="image" src="images/cupcino-shop4.jpeg" alt="Cuppcino Coffee">
         <div class="name">Cuppcino Coffee</div>
         <div class="name">23 SAR </div>
         <div class="calories">Calories: 130</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="Cuppcino Coffee">
         <input type="hidden" name="product_price" value="23">
         <input type="hidden" name="product_image" value="cupcino-shop4.jpeg">
         <input type="hidden" name="product_calories" value="130">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
       
      <form action="" method="post" class="box">
         <img class="image" src="images/EspressO.jpeg" alt="Espersso Coffee">
         <div class="name">Espresso Coffee</div>
         <div class="name">15 SAR </div>
         <div class="calories">Calories: 111</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="Espresso Coffee">
         <input type="hidden" name="product_price" value="15">
         <input type="hidden" name="product_image" value="Espress0.jpeg">
         <input type="hidden" name="product_calories" value="111">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
       
       <form action="" method="post" class="box">
         <img class="image" src="images/drip.jpeg" alt="filter Coffee">
         <div class="name">filter Coffee</div>
         <div class="name">27 SAR </div>
         <div class="calories">Calories: 10</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="filter Coffee">
         <input type="hidden" name="product_price" value="27">
         <input type="hidden" name="product_image" value="drip.jpeg">
         <input type="hidden" name="product_calories" value="10">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
       
       
        <form action="" method="post" class="box">
         <img class="image" src="images/amrecano.jpeg" alt="amrecano Coffee">
         <div class="name">amrecano Coffee</div>
         <div class="name">22 SAR </div>
         <div class="calories">Calories: 44</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="amrecano Coffee">
         <input type="hidden" name="product_price" value="22">
         <input type="hidden" name="product_image" value="amrecano.jpeg">
         <input type="hidden" name="product_calories" value="44">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
       
        <form action="" method="post" class="box">
         <img class="image" src="images/Machiatto.jpeg" alt="machiatto coffee">
         <div class="name">machiatto coffee</div>
         <div class="name">25 SAR </div>
         <div class="calories">Calories: 44</div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="machitto Coffee">
         <input type="hidden" name="product_price" value="25">
         <input type="hidden" name="product_image" value="Machiatto.jpeg">
         <input type="hidden" name="product_calories" value="44">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
       


       


   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>

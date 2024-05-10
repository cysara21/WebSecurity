<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   $update_cart_stmt = mysqli_prepare($conn, "UPDATE `cart` SET quantity = ? WHERE id = ?");
   mysqli_stmt_bind_param($update_cart_stmt, "ii", $cart_quantity, $cart_id);
   mysqli_stmt_execute($update_cart_stmt) or die('query failed');
   mysqli_stmt_close($update_cart_stmt);
   $message[] = 'cart quantity updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_stmt = mysqli_prepare($conn, "DELETE FROM `cart` WHERE id = ?");
   mysqli_stmt_bind_param($delete_stmt, "i", $delete_id);
   mysqli_stmt_execute($delete_stmt) or die('query failed');
   mysqli_stmt_close($delete_stmt);
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   $delete_all_stmt = mysqli_prepare($conn, "DELETE FROM `cart` WHERE user_id = ?");
   mysqli_stmt_bind_param($delete_all_stmt, "i", $user_id);
   mysqli_stmt_execute($delete_all_stmt) or die('query failed');
   mysqli_stmt_close($delete_all_stmt);
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>shopping cart</h3>
   <p> <a href="home.php">home</a> / cart </p>
</div>

<section class="shopping-cart">

   <h1 class="title">products added</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart_stmt = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE user_id = ?");
         mysqli_stmt_bind_param($select_cart_stmt, "i", $user_id);
         mysqli_stmt_execute($select_cart_stmt);
         $result = mysqli_stmt_get_result($select_cart_stmt);
         if(mysqli_num_rows($result) > 0){
            while($fetch_cart = mysqli_fetch_assoc($result)){   
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price"><?php echo $fetch_cart['price']; ?> SAR</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="update" class="option-btn">
         </form>
         <div class="sub-total"> sub total : <span><?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?> SAR</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">your cart is empty</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
   </div>

   <div class="cart-total">
      <p>grand total : <span><?php echo $grand_total; ?> SAR</span></p>
      <div class="flex">
         <a href="menu.php" class="option-btn">continue shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
      </div>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>

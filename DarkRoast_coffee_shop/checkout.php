<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){
    // Initialize validation flag
    $valid = true;

    // Validate name with regex: allow only letters, spaces, and hyphens
    if(preg_match("/^[a-zA-Z\s-]+$/", $_POST['name'])){
        $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
    } else {
        $valid = false;
        $name_error = 'Please enter a valid name.';
    }

    // Validate email with filter_var() function
    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
    } else {
        $valid = false;
        $email_error = 'Please enter a valid email address.';
    }

    // Validate phone number: must be 10 digits
    $number = htmlspecialchars($_POST['phone_number']);
    if(isset($number) && strlen($number) == 10 && ctype_digit($number)){
        // Proceed with the rest of your code if $valid is still true
    } else {
        $valid = false;
        // If phone number is not provided or not 10 digits, set error message
        $number_error = 'Please enter a valid  phone number.';
    }

    // Validate address with regex: allow letters, numbers, spaces, commas, and hyphens
    if(preg_match("/^[a-zA-Z0-9\s,-]+$/", $_POST['address']) && preg_match("/^[a-zA-Z0-9\s,-]+$/", $_POST['city']) && preg_match("/^[a-zA-Z0-9\s,-]+$/", $_POST['country'])){
        $address = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['address'].','. $_POST['city'].', '. $_POST['country']));
    } else {
        $valid = false;
        $address_error = 'Please enter a valid address, city, and country.';
    }

    // Check if payment method is selected
    if(isset($_POST['method'])){
        $method = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['method']));
    } else {
        $valid = false;
        $method_error = 'Please select a payment method.';
    }
    
    $placed_on = date('d-M-Y');

    // If all validations pass, proceed with order placement
    if($valid) {
        $cart_total = 0;
        $cart_products = [];

        $cart_stmt = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE user_id = ?");
        mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
        mysqli_stmt_execute($cart_stmt);
        $cart_result = mysqli_stmt_get_result($cart_stmt);

        if(mysqli_num_rows($cart_result) > 0){
            while($cart_item = mysqli_fetch_assoc($cart_result)){
                $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
                $sub_total = ($cart_item['price'] * $cart_item['quantity']);
                $cart_total += $sub_total;
            }
        }

        $total_products = implode(' , ', $cart_products);

        $order_stmt = mysqli_prepare($conn, "SELECT * FROM `orders` WHERE name = ? AND phone_number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
        mysqli_stmt_bind_param($order_stmt, "ssssssd", $name, $number, $email, $method, $address, $total_products, $cart_total);
        mysqli_stmt_execute($order_stmt);
        mysqli_stmt_store_result($order_stmt);

        if($cart_total == 0){
            $message[] = 'Your cart is empty';
        } else {
            if(mysqli_stmt_num_rows($order_stmt) > 0){
                $message[] = 'Order already placed!';
            } else {
                $insert_order_stmt = mysqli_prepare($conn, "INSERT INTO `orders`(user_id, name, email, phone_number, method, address, total_products, total_price, placed_on) VALUES(?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                mysqli_stmt_bind_param($insert_order_stmt, "issssssd", $user_id, $name, $email, $number, $method, $address, $total_products, $cart_total);
                mysqli_stmt_execute($insert_order_stmt);
                $message[] = 'Order placed successfully!';
                
                $delete_cart_stmt = mysqli_prepare($conn, "DELETE FROM `cart` WHERE user_id = ?");
                mysqli_stmt_bind_param($delete_cart_stmt, "i", $user_id);
                mysqli_stmt_execute($delete_cart_stmt);
            }
        }
    } else {
        // Display error message if order submission failed due to invalid input
        $message[] = 'Order submission failed due to invalid input.';
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">home</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart_stmt = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE user_id = ?");
      mysqli_stmt_bind_param($select_cart_stmt, "i", $user_id);
      mysqli_stmt_execute($select_cart_stmt);
      $select_cart_result = mysqli_stmt_get_result($select_cart_stmt);
      
      if(mysqli_num_rows($select_cart_result) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart_result)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p><?php echo $fetch_cart['name']; ?><span> <?php echo $fetch_cart['price'] . ' SAR (' . $fetch_cart['quantity'] . 'x)'; ?></span></p>

   <?php
      }
   }else{
      echo '<p class="empty">Your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> Grand total : <span><?php echo $grand_total; ?> SAR</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span> Name :</span>
            <input type="text" name="name" required placeholder="Enter your full name">
            <?php if(isset($name_error)) echo '<div style="color: black; font-weight: bold; background-color: #ffcccc; padding: 5px; border: 1px solid #ff0000; border-radius: 5px;">'.$name_error.'</div>'; ?>
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" required placeholder="Enter your email">
            <?php if(isset($email_error)) echo '<div style="color: black; font-weight: bold; background-color: #ffcccc; padding: 5px; border: 1px solid #ff0000; border-radius: 5px;">'.$email_error.'</div>'; ?>
         </div>
         <div class="inputBox">
            <span>Phone :</span>
            <input type="text"  name="phone_number" required placeholder="e.g. 05********">
            <?php if(isset($number_error)) echo '<div style="color: black; font-weight: bold; background-color: #ffcccc; padding: 5px; border: 1px solid #ff0000; border-radius: 5px;">'.$number_error.'</div>'; ?>
         </div>
         <div class="inputBox">
            <span>Address:</span>
            <input type="text"  name="address"  required placeholder="e.g. street name , flat.no ">
            <?php if(isset($address_error)) echo '<div style="color: black; font-weight: bold; background-color: #ffcccc; padding: 5px; border: 1px solid #ff0000; border-radius: 5px;">'.$address_error.'</div>'; ?>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" required placeholder="Enter your country">
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" required placeholder="Enter your city">
         </div>
         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method">
               <option value="cash on delivery">Cash on delivery</option>
               <option value="credit card">Credit card</option>
               <option value="paypal">Paypal</option>
            </select>
            <?php if(isset($method_error)) echo '<div style="color: black; font-weight: bold; background-color: #ffcccc; padding: 5px; border: 1px solid #ff0000; border-radius: 5px;">'.$method_error.'</div>'; ?>
         </div>
      </div>
      <input type="submit" value="Order now" class="btn" name="order_btn">
   </form>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>







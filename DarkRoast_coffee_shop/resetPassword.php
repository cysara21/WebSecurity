<?php

include 'config.php';

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn,$_POST['email']);
   $email=htmlspecialchars($email,ENT_QUOTES, 'UTF-8'); 
   

   
   
    //used for verifying the existance of users
   $existed_email=mysqli_query($conn, "SELECT email FROM `users` WHERE email = '$email'") or die('query failed');
   
   
   //to prevent enumerating emails by attacker; an ambigous message will be displaed either if the email exists or not
    
   if(mysqli_num_rows($existed_email) > 0){
      $message[] ='If your email has been registred, then the reset link will be sent to you.';
      } 
   
   //if not exist
   else{
         $message[] = 'If your email has been registred, then the reset link will be sent to you.';}
   }



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Reset Your Password</h3>
      <p>You can reset your password after reciving an email</p>
      <input type="email" id="email" name="email" placeholder="enter your email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|edu|gov|mil|biz|info)" required class="box">
      
      <input type="submit" name="submit" value="Send" class="btn">
      
   </form>

</div>

</body>
</html>

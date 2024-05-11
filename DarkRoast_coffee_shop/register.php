<?php

include 'config.php';

if(isset($_POST['submit'])){
   
   //sanitize input data
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, sha1($_POST['password'])); //using and hashing[SHA1] to protect password
   $pass_for_checking=mysqli_real_escape_string($conn,$_POST['password']); //will not stored only for checing bc it is raw without hash and salt 
   $cpass = mysqli_real_escape_string($conn, sha1($_POST['cpassword']));
   $user_type =mysqli_real_escape_string($conn,'user'); //mandatory option 
   
   //prevent xss 
   $name=htmlspecialchars($name,ENT_QUOTES, 'UTF-8');
   $email=htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
   $pass=htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');
   $cpass=htmlspecialchars($cpass, ENT_QUOTES, 'UTF-8');
   $pass_for_checking=htmlspecialchars($pass_for_checking, ENT_QUOTES, 'UTF-8');
   
   
   //checking the strength of the password
   $strong_pass=(strlen($pass_for_checking)>=8 && preg_match('/[a-z]/',$pass_for_checking) && preg_match('/[A-Z]/',$pass_for_checking) && preg_match('/\d/',$pass_for_checking) && preg_match('/[^a-zA-Z0-9]/',$pass_for_checking));
   
   
    //used for verifying the existance of users
   $existed_users=mysqli_query($conn, "SELECT name,email FROM `users` WHERE name='$name' OR email = '$email'") or die('query failed');
   
   //if a value greater than 0 is returned then it means the email or username exists   
   if(mysqli_num_rows($existed_users) > 0){
      $message[] = 'User is either already exist, or bloked';} 
   
   //if not exist; will check the input data
   else{

      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';}
         
      else if($strong_pass==false){
        $message[] ='Weak password';
      }   

      else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'Registered successfully!';
         header('location:login.php');
      }
   }}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

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
      <h3>Register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" id="email" name="email" placeholder="enter your email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|edu|gov|mil|biz|info)" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <input type="text" name="user_type" placeholder="Customer" disabled class="box"> 
         

      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>

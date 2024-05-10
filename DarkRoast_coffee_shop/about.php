<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images\coffeeShop.jpeg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Choosing our cafe means immersing yourself in a coffee experience like no other. Our commitment to quality begins with the careful selection of beans from the most exceptional regions worldwide. We prioritize every step of the process, from the moment the beans are handpicked to the moment they are brewed into your cup, ensuring that only the finest flavors are delivered to your palate. Our skilled baristas are true artists, meticulously crafting each beverage with precision and care, resulting in a sensory journey through enticing flavors and captivating aromas. But our cafe is more than just coffee. It's a place where warmth and hospitality embrace you, where you can savor the richness of our brews and create lasting memories with loved ones. Each cup tells a unique story, inviting you to be a part of our coffee culture and experience the joy that comes from shared moments. Choose our cafe, and let us take you on a remarkable journey of taste, aroma, and heartfelt hospitality.</p>
         
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/faisal.jpeg" alt="">
         <p>Amazing coffee and friendly service! My go-to spot for a perfect cup of joe. Such a fun experience and I will come again!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Faisal Hamad</h3>
      </div>

      <div class="box">
         <img src="images/Dana.jpeg" alt="">
         <p>Hands down the best latte in town. The baristas know their stuff and consistently deliver perfection in a cup.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Dana khalid</h3>
      </div>

      <div class="box">
         <img src="images/Mohammed.jpeg" alt="">
         <p>This cafe is my go-to for a relaxing afternoon. The ambiance is inviting, and the coffee is always on point.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Mohammed Ali</h3>
      </div>

      <div class="box">
         <img src="images/Hadeel.jpeg" alt="">
         <p>I appreciate their commitment to sustainability. Great coffee with a conscience.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-o"></i>

         </div>
         <h3>Hadeel Fahad</h3>
      </div>

      <div class="box">
         <img src="images/Turki.jpeg" alt="">
         <p>This cafe feels like home. Always greeted with a smile and my favorite brew.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Turki Badr</h3>
      </div>

      <div class="box">
         <img src="images/Yara.jpeg" alt="">
         <p>Fantastic coffee and welcoming atmosphere. A must-visit spot for any coffee lover!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Yara Abdullah</h3>
      </div>

   </div>

</section>

<section class="authors">

   <h1 class="title">Our Popular Coffee</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/drip.jpeg" alt="">
         
         <h3>Filter Coffee</h3>
      </div>

      <div class="box">
         <img src="images/flat-shop2.jpeg" alt="">

         <h3>Flat White Coffee</h3>
      </div>

      <div class="box">
         <img src="images/EspressO.jpeg" alt="">
         
         <h3>Espresso Coffee</h3>
      </div>

   </div>

</section>



<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
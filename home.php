<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ELITE ESTATE</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
   .hero-section {
      background-image: url(images/bg.png); /* Replace with your image */
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      color: white;
      text-align: center; /* Center the text */
      overflow: hidden; /* Clip the animation */
  }

  .overlay {
      background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center; /* Vertically center content */
      align-items: center;      /* Horizontally center content */
  }

  .hero-content {
      z-index: 1; /* Ensure text is above the overlay */
      max-width: 80%;   /* Limit text width for readability */
  }

  .hero-title {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0;
      transform: translateY(-20px);
      animation: fadeInUp 1s ease-out 0.5s forwards;
  }

  .hero-text {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0;
      transform: translateY(-15px);
      animation: fadeInUp 1s ease-out 0.7s forwards;
  }

  .cta-button {
      background-color:rgb(97, 9, 60); /* Example button color */
      color: white;
      padding: 0.75rem 1.5rem;
      text-decoration: none;
      border-radius: 5px;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
      opacity: 0;
      transform: translateY(-10px);
      animation: fadeInUp 1s ease-out 0.9s forwards;
  }

  .cta-button:hover {
      background-color:rgb(65, 50, 59); /* Darker shade on hover */
  }

  @keyframes fadeInUp {
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  @media (max-width: 768px) {
      .hero-title {
          font-size: 2.5rem;
      }
      .hero-text {
          font-size: 1rem;
      }
  }

  @media (max-width: 576px) {
      .hero-title {
          font-size: 2rem;
      }
      .hero-text {
          font-size: 0.9rem;
      }
      .cta-button {
          font-size: 1rem;
          padding: 0.75rem 1rem;
      }
  }
</style>
</head>
<body>
   
<!-- header section starts  -->

<header class="header">

   <nav class="navbar nav-1">
      <section class="flex">
         <a href="home.html" class="logo"><i class="fas fa-house"></i>Elite Estate</a>

         <ul>
            <li><a href="#">Post Property<i class="fas fa-paper-plane"></i></a></li>
         </ul>
      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
               <li><a href="#" class="help-link">Buy<i class="fas fa-angle-down"></i></a>
               <ul class="help-dropdown">
                     <li><a href="list2.html">House</a></li>
                     <li><a href="list3.php">Flat</a></li>
                     <li><a href="furnish1.html">Furnished</a></li>
                  </ul>
               </li>
               <li><a href="#" class="help-link">Sell<i class="fas fa-angle-down"></i></a>
               <ul class="help-dropdown">
                     <li><a href="post.php">Post property</a></li>
                     <li><a href="dash.html">Dashboard</a></li>
                  </ul>
               </li>
               <li> <a href="#" class="help-link">Rent<i class="fas fa-angle-down"></i></a>
               <ul class="help-dropdown">
                     <li><a href="house.html">House</a></li>
                     <li><a href="Flat.html">Flat</a></li>
                     
                  
                  </ul>
               </li>
               <li>
               <a href="#" class="help-link">Help<i class="fas fa-angle-down"></i></a>
               <ul class="help-dropdown">
               <li><a  href="about.html">About Us</a></li>
               <li><a  href="contact.html">Contact Us</a></li>
               <li><a  href="contact.html#faq">FAQ</a></li>
               </ul>
</li>

<style>
    .help-link {

  color: #333; /
  transition: color 0.1s ease-in-out; 
  cursor: pointer;
}

.help-link:hover {
  color: #007bff; 
}


.help-link:hover i {
  transform: rotate(180deg); 
}
.help-dropdown li {
    font-size: 3rem;
      
      opacity: 0;
      transform: translateY(-20px);
      animation: fadeInUp 1s ease-out 0.1s forwards;
   
}

.help-dropdown li a {
   

      font-size: 1.2rem;
      
      opacity: 0;
      transform: translateY(-15px);
      animation: fadeInUp 1s ease-out 0.3s forwards; 
}

.help-dropdown li a:hover {
    font-size: 1.2rem;
      
      opacity: 0;
      transform: translateY(-15px);
      animation: fadeInUp 1s ease-out 0.7s forwards; 

  background-color: #f0f0f0; /* Add a background color on hover for visual feedback */
}

  
</style>

            </ul>
         </div>

         <ul>
            <li><a href="#">Saved <i class="far fa-heart"></i></a></li>
            <li><a href="#" class="help-link">Account<i class="fas fa-angle-down"></i></a>
            <ul class="help-dropdown">
                  <li><a href="login.html">Login</a></li>
                  <li><a href="register.html">Register</a></li>
               </ul>
            </li>
         </ul>
      </section>
   </nav>

</header>
<div class="hero-section">
   <div class="overlay">
       <div class="hero-content">
           <h1 class="hero-title">Discover Your Dream Home</h1>
           <p class="hero-text">We help you find the perfect property for your needs.</p>
           <a href="#listings-section" class="cta-button">Search Properties</a>
       </div>
   </div>
</div>


<!-- header section ends -->

<!-- home section starts  -->


<div class="home" >


      <section class="center">
  
  
          <form action="search.html" method="post"  >
  
              <h3>Find your perfect home</h3>
              <div class="box">
                  <p>Enter location </p>
                  <input type="text" name="location" required maxlength="50" placeholder="Enter City Name" class="input">
              </div>
              <div class="flex">
                  <div class="box">
                      <p>Property Type </p>
                      <select name="type" class="input" required>
                          <option value="flat">Flat</option>
                          <option value="house">House</option>
  
                      </select>
                  </div>
                  <div class="box">
                      <p>How many Marla </p>
                      <select name="bhk" class="input" required>
                          <option value="1">1 Marla</option>
                          <option value="2">2 Marla</option>
                          <option value="3">3 Marla</option>
                          <option value="4">4 Marla</option>
                          <option value="5">5 Marla</option>
                          <option value="6">6 Marla</option>
                          <option value="7">7 Marla</option>
                          <option value="8">8 Marla</option>
                          <option value="9">9 Marla</option>
                      </select>
                  </div>
                  <div class="box">
                      <p>Minimum budget </p>
                      <select name="minimum" class="input" required>
                          <option value="5000000">5 lac</option>
                          <option value="1000000">10 lac</option>
                          <option value="2000000">20 lac</option>
                          <option value="3000000">30 lac</option>
                          <option value="4000000">40 lac</option>
                          <option value="4000000">40 lac</option>
                          <option value="5000000">50 lac</option>
                          <option value="6000000">60 lac</option>
                          <option value="7000000">70 lac</option>
                          <option value="8000000">80 lac</option>
                          <option value="9000000">90 lac</option>
                          <option value="10000000">1 Cr</option>
                          <option value="20000000">2 Cr</option>
                          <option value="30000000">3 Cr</option>
                          <option value="40000000">4 Cr</option>
                          <option value="50000000">5 Cr</option>
                          <option value="60000000">6 Cr</option>
                          <option value="70000000">7 Cr</option>
                          <option value="80000000">8 Cr</option>
                          <option value="90000000">9 Cr</option>
                          <option value="100000000">10 Cr</option>
                          <option value="150000000">15 Cr</option>
                          <option value="200000000">20 Cr</option>
                      </select>
                  </div>
                  <div class="box">
                      <p>Maximum budget</p>
                      <select name="maximum" class="input" required>
                          <option value="5000000">5 lac</option>
                          <option value="1000000">10 lac</option>
                          <option value="2000000">20 lac</option>
                          <option value="3000000">30 lac</option>
                          <option value="4000000">40 lac</option>
                          <option value="4000000">40 lac</option>
                          <option value="5000000">50 lac</option>
                          <option value="6000000">60 lac</option>
                          <option value="7000000">70 lac</option>
                          <option value="8000000">80 lac</option>
                          <option value="9000000">90 lac</option>
                          <option value="10000000">1 Cr</option>
                          <option value="20000000">2 Cr</option>
                          <option value="30000000">3 Cr</option>
                          <option value="40000000">4 Cr</option>
                          <option value="50000000">5 Cr</option>
                          <option value="60000000">6 Cr</option>
                          <option value="70000000">7 Cr</option>
                          <option value="80000000">8 Cr</option>
                          <option value="90000000">9 Cr</option>
                          <option value="100000000">10 Cr</option>
                          <option value="150000000">15 Cr</option>
                          <option value="200000000">20 Cr</option>
                      </select>
                  </div>
              </div>
              <input type="submit" value="search property" name="search" class="btn">
          </form>
   
  

 
<script>
   const slider = document.getElementById('imageSlider');
   const backgroundImage = document.getElementById('backgroundImage');
   let currentSlide = 0;

   function nextSlide() {
       currentSlide = (currentSlide + 1) % 3; // Cycle through 0, 1, 2
       slider.style.transform = `translateX(-${currentSlide * (100 / 3)}%)`;

       // Background image logic
       backgroundImage.classList.remove('active'); // Hide current background
       setTimeout(() => { // Small delay to sync with transition
           backgroundImage.src = (currentSlide + 1 > 3) ? `image${(currentSlide + 1)%4}.jpg` : `image${currentSlide + 1}.jpg`;
           backgroundImage.classList.add('active'); // Show new background
       }, 500); // Half the transition time
   }

   setInterval(nextSlide, 3000);
</script>
</section> 
</div>


<!-- home section ends -->

<!-- services section starts  -->

<section class="services">

   <h1 class="heading">Our Services</h1>

   <div class="box-container1">
    <div class="box1">
        <img src="images/buy house.png" alt="">
        <h3>Buy house</h3>
        <p>Real estate is land and any permanent structures or improvements attached to the land.</p>
    </div>
    <div class="box1">
        <img src="images/rent house.png" alt="">
        <h3>Rent house</h3>
        <p>Provide description of the property, including any unique features. Eg numbers of rooms, bathrooms, or the style.</p>
    </div>
    <div class="box1">
        <img src="images/sell house.png" alt="">
        <h3>Sell house</h3>
        <p>Include information about the property (Number of Bedrooms, bathrooms, Size of rooms), the payment process.</p>
    </div>
    <div class="box1">
        <img src="images/flat and buildings.png" alt="">
        <h3>Flats</h3>
        <p>Flats are more affordable. Typically consist of multiple rooms, bedrooms, kitchen, bathroom.</p>
    </div>
   
     <div class="box1">
         <img src="images/b.flats.png" alt="">
         <h3>Building</h3>
         <p>A building is an enclosed structure with a roof and walls, usually standing permanently in one place.</p>
      </div>

      <div class="box1">
         <img src="images/24hour.png" alt="">
         <h3>24/7 service</h3>
         <p>Our services are available 24/7, so you can always reach us when you need assistance.you can approach.</p>
      </div>
      <div class="box1">
         <img src="images/hier agents.png" alt="">
         <h3>Hiring Agents</h3>
         <p>If you want to visit place then hire agents to conduct property viewings and provide exceptional service.</p>
      </div>
      <div class="box1">
         <img src="images/advertisment.png" alt="">
         <h3>Advertisment by banner</h3>
         <p> Advertisment help you to Advertising your project, promoting events,or enhancing brand visibility.</p>
      </div>

      <div class="box1">
         <img src="images/feedback.png" alt="">
         <h3>Feedback & Helpcenter</h3>
         <p>Visit our help center for FAQs, support, and to share your feedback so we can better serve you.</p>
      </div>

   </div>

<style>
.box-container1 {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
    max-width: 1000px;
    margin: 50px auto;
}

.box1 {
    width: 300px;
    height: 350px;
    padding: 20px;
    border: 1px solid #ccc;
    margin: 10px;
    text-align: center;
    transition: transform 0.5s ease-in-out; /* Smooth transition for zoom effect */
    overflow: hidden; /* Ensure the zoomed content doesn't overflow */
}

.box1 img {
    width: 50%;
    height: auto;
    
    transition: transform 0.5s ease-in-out; /* Smooth transition for image zoom */
}

.box1:hover {
    transform: scale(1.1); /* Enlarge the box on hover */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); /* Add shadow for better effect */
}

.box1:hover img {
    transform: scale(1.3); /* Slightly enlarge the image on hover */
}


@media (max-width: 700px) {
    .box-container1 {
        flex-direction: column; /* Stack boxes vertically on small screens */
    }
    .box1 {
        width: 90%; /* Let boxes take up most of the width on small screens */
       
        margin: 10px auto; /* Center the boxes */
    }
    

   
}

    .services .box-container1 .box1 p{
   line-height: 2;
   font-size: 1.6rem;
   color: var(--light-color);
   padding-top: .5rem;
}
.p{
    font-size:3rem;
}
</style>

     

</section>
<!-- services section ends -->

<!-- listings section starts  -->

<
<!-- listings section starts  -->

<section class="listings" id="listings-section">

   <h1 class="heading">latest listings</h1>

   <div class="box-container">

      <div class="box" data-house-id="123"> <div class="admin">
         <img src="images/profile.png" alt="Avatar" class="avatar">
         <div>
             <p>Azam Ryyaz <span class="house-number">(House #123)</span></p> <span>03-01-2020</span>
         </div>
     </div>
     <div class="thumb">
         <p class="total-images"><i class="far fa-image"></i><span>4</span></p>
         <p class="type"><span>house</span><span>sale</span></p>
         <form action="" method="post" class="save">
             <button type="submit" name="save" value="123" class="far fa-heart"></button> </form>
         <img src="images/house-img-1.webp" alt="">
     </div>
     <h3 class="name">7 Marla</h3>
     <p class="location"><i class="fas fa-map-marker-alt"></i><span>Tehsil, Mandibhauddin, Pakistan</span></p>
     <div class="flex">
         <p><i class="fas fa-bed"></i><span>3</span></p>
         <p><i class="fas fa-bath"></i><span>2</span></p>
         <p><i class="fas fa-maximize"></i><span>750sqft</span></p>
     </div>
     <a href="vf1.php" class="btn">view property</a>
 </div>
      <div class="box" data-house-id="124">
         <div class="admin">
            <img src="images/man_7790130.png" alt="Avatar" class="avatar">
            <div>
               <p>Shahid Hussain <span class="house-number">(House #124)</span></p>
               <span>06-20-2022</span>
            </div>
         </div>
         <div class="thumb">
            <p class="total-images"><i class="far fa-image"></i><span>4</span></p>
            <p class="type"><span>House</span><span>Sale</span></p>
            <form action="" method="post" class="save">
               <button type="submit" name="save" class="far fa-heart"></button>
            </form>
            <img src="images/h4.jpg" alt="">
         </div>
         <h3 class="name">6 Marla</h3>
         <p class="location"><i class="fas fa-map-marker-alt"></i><span>Tehsil, Phalia, Pakistan</span></p>
         <div class="flex">
            <p><i class="fas fa-bed"></i><span>4</span></p>
            <p><i class="fas fa-bath"></i><span>2</span></p>
            <p><i class="fas fa-maximize"></i><span>600sqft</span></p>
         </div>
         <a href="vf2.html" class="btn">view property</a>
      </div>

      <div class="box" data-house-id="123">
         <div class="admin">
            <img src="images/man_4140048.png" alt="Avatar" class="avatar">
            <div>
               <p>Yasir khan  <span class="house-number">(House #124)</span></p>
               <span>05-10-2022</span>
            </div>
         </div>
         <div class="thumb">
            <p class="total-images"><i class="far fa-image"></i><span>4</span></p>
            <p class="type"><span>House</span><span>Sale</span></p>
            <form action="" method="post" class="save">
               <button type="submit" name="save" class="far fa-heart"></button>
            </form>
            <img src="images/home img1.jpg" alt="">
         </div>
         <h3 class="name">7.5 Marla</h3>
         <p class="location"><i class="fas fa-map-marker-alt"></i><span>Tehsil, Mandibhauddin,Pakistan</span></p>
         <div class="flex">
            <p><i class="fas fa-bed"></i><span>4</span></p>
            <p><i class="fas fa-bath"></i><span>3</span></p>
            <p><i class="fas fa-maximize"></i><span>650sqft</span></p>
         </div>
         <a href="vf3.html" class="btn">view property</a>
      </div>

   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="list2.html" class="inline-btn">view all</a>
   </div>

</section>

<!-- listings section ends -->
<!-- listings section ends -->










<!-- footer section starts  -->

<footer class="footer">

   <section class="flex">
      <div class="box">
         <a href="tel:1234567890"><i class="fas fa-phone"></i><span>123456789</span></a>
         <a href="tel:1112223333"><i class="fas fa-phone"></i><span>1112223333</span></a>
         <a href="mailto:shaikhanas@gmail.com"><i class="fas fa-envelope"></i><span>hajrahamad@gmail.com</span></a>
         <a href="#"><i class="fas fa-map-marker-alt"></i><span>Pakistan, Mandi bhauddin - 50400</span></a>
      </div>
      </div>

      <div class="box">
         <a href="home.html" class="a"><span>Home</span></a>
         <a href="about.html" class="b"><span>About</span></a>
         <a href="contact.html" class="c"><span>Contact</span></a>
         <a href="listings.html" class="d"><span>All listings</span></a>
         <a href="#" class="e"><span>Saved properties</span></a>
      </div>

      <div class="box">
         <a href="#"><i class="fab fa-facebook-f"></i><span>&nbsp;&nbsp;Facebook</span></a>
         <a href="#"><i class="fab fa-twitter"></i><span>&nbsp;&nbsp;Twitter</span></a>
         <a href="#"><i class="fab fa-linkedin"></i><span>&nbsp;&nbsp;Linkedin</span></a>
         <a href="#"><i class="fab fa-instagram"></i><span>&nbsp;&nbsp;Instagram</span></a>

      </div>

   </section>


   <div class="credit">&copy; copyright @ 2024-2025 by <span>ELITE ESTATE</span> | all rights reserved!</div>

</footer>

<!-- footer section ends -->


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
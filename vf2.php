<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Property</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="save.css">
</head>
<body>
   
<!-- header section starts  -->
<?php include'header.php' ?>


<section class="view-property">

   <div class="details">
      <div class="thumb">
         <div class="big-image">
            <img src="images/vs2.jpg" alt="">
         </div>
         <div class="small-images">
            <img src="images/h20.webp" alt="">
            <img src="images/h201.webp" alt="">
            <img src="images/h202.webp" alt="">
            <img src="images/h203.webp" alt="">
            <img src="images/h204.webp" alt="">
            <img src="images/h205.webp" alt="">
           
         </div>
      </div>
      <h3 class="name">Modern House</h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span>Tehsil, Phalia, Pakistan</span></p>
      <div class="info">
         <p><i class="fas fa-tag"></i><span>35 lac</span></p>
         <p><i class="fas fa-user"></i><span>Shahid Hussain</span></p>
         <p><i class="fas fa-phone"></i><a href="tel:1234567890">+92343434333</a></p>
         <p><i class="fas fa-house"></i><span>Sale</span></p>
         <p><i class="fas fa-calendar"></i><span>06-20-2022</span></p>
      </div>
      <h3 class="title">Details</h3>
      <div class="flex">
         <div class="box">
            <p><i>Rooms :</i><span>6 Marla</span></p>
            <p><i>deposit amount :</i><span>23 lac</span></p>
            <p><i>Status :</i><span>Ready to move</span></p>
            <p><i>Bedroom :</i><span>4</span></p>
            <p><i>Bathroom :</i><span>2</span></p>
            <p><i>Balcony :</i><span>0</span></p>
         </div>
         <div class="box">
            <p><i>carpet area :</i><span>600sqft</span></p>
            <p><i>age :</i><span>2.5 years</span></p>
            <p><i>Room floor :</i><span>2</span></p>
            <p><i>Total floors :</i><span>3</span></p>
            <span>Semi-furnished</span></p>
            <p><i>Loan :</i><span>Not Available</span></p>
         </div>
      </div>
      <h3 class="title">Amenities</h3>
      <div class="flex">
         <div class="box">
            <p><i class="fas fa-check"></i><span>lifts</span></p>
            <p><i class="fas fa-check"></i><span>security guards</span></p>
            <p><i class="fas fa-times"></i><span>play ground</span></p>
            <p><i class="fas fa-check"></i><span>gardens</span></p>
            <p><i class="fas fa-check"></i><span>water supply</span></p>
            <p><i class="fas fa-check"></i><span>power backup</span></p>
         </div>
         <div class="box">
            <p><i class="fas fa-check"></i><span>parking area</span></p>
            <p><i class="fas fa-check"></i><span>gym</span></p>
            <p><i class="fas fa-check"></i><span>shopping mall</span></p>
            <p><i class="fas fa-times"></i><span>hospital</span></p>
            <p><i class="fas fa-times"></i><span>schools</span></p>
            <p><i class="fas fa-times"></i><span>market area</span></p>
         </div>
      </div>
      <h3 class="title">Description</h3>
      <p class="description">"This stunning 2-bedroom, 2-bath home offers over 750 sq ft of living space. Highlights include a gourmet kitchen with granite countertops, a luxurious master suite, and a finished basement. Enjoy outdoor living on the large deck overlooking the private backyard. Situated in a sought-after school district. Schedule your private tour!".</p>
    <button id="savePropertyBtn" class="inline-btn">Save Property</button>
<script>
  const saveBtn = document.getElementById('savePropertyBtn');

  const property = {
    id: "102",
    title: "Modern House",
    image: "images/h4.jpg",
    location: "Tehsil, Phalia, Pakistan",
    price: "35 lac",
    agent: "Shahid Hussain",
    phone: "+92343434333",
    type: "Sale",
    date: "06-20-2022",
    rooms: "6 Marla",
    deposit: "23 lac",
    status: "Semi-furnished",
    carpet: "600 sqft",
    age: "2 year",
    floor: "3"
  };


  let saved = JSON.parse(localStorage.getItem('savedProperties')) || [];

  if (saved.some(p => p.id === property.id)) {
    saveBtn.textContent = "Saved";
    saveBtn.disabled = true;
  }

  saveBtn.addEventListener('click', () => {
    let saved = JSON.parse(localStorage.getItem('savedProperties')) || [];
    if (!saved.some(p => p.id === property.id)) {
      saved.push(property);
      localStorage.setItem('savedProperties', JSON.stringify(saved));
      saveBtn.textContent = "Saved";
      saveBtn.disabled = true;
      alert("Property saved!");
      window.location.href = "saved.php";  
    } else {
      alert("This property is already saved.");
    }
  });
</script>
      <?php if (isset($_SESSION['user_id'])): ?>
         <a href="agent1.php" class="inline-btn">Contact Agent</a>
         <a href="buyer.html" class="inline-btn">Buy Now</a>
      <?php else: ?>
         <a href="login.php" class="inline-btn">Contact Agent</a>
         <a href="login.php" class="inline-btn">Buy Now</a>
      <?php endif; ?>
   </div>
        <div id="map-container">
            <h3><b>Property Location</b></h3>
            <p>Pakistan, Mandi bhauddin-50400</p>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3304.879194283788!2d73.48790377496253!3d32.5843286805851!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3922833938a15c8b%3A0xcc964e6955401678!2sMandi%20Bahauddin%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2sus!4v1713709098913!5m2!1sen!2sus"
                        width="1150" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
            </div>
        </div>
      </form>
   </div>

</section>


<?php include'footer.php' ?>



<script src="js/script.js"></script>

</body>
</html>
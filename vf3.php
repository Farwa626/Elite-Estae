
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?><!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Property</title>

  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

 
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="save.css">
 <style>
     
    </style>
</head>
<body>
   

   
<?php include'header.php' ?>



<section class="view-property">

   <div class="details">
      <div class="thumb">
         <div class="big-image">
            <img src="images/home img1.jpg" alt="">
         </div>
         <div class="small-images">
            <img src="images/nf/a1.jpg" alt="">
            <img src="images/nf/a2.jpg" alt="">
            <img src="images/nf/a10.jpg" alt="">
            <img src="images/nf/a5.jpg" alt="">
            <img src="images/nf/a6.jpg" alt="">
            <img src="images/nf/a7.jpg" alt="">
            <img src="images/nf/a3.jpg" alt="">
         </div>
      </div>
      <h3 class="name">The Modern Oasis</h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span>Pakistan , Mandi bhauddin-50400</span></p>
      <div class="info">
         <p><i class="fas fa-tag"></i><span>28.5 lac</span></p>
         <p><i class="fas fa-user"></i><span>Yasir Khan</span></p>
         <p><i class="fas fa-phone"></i><a href="tel:1234567890">+92343434333</a></p>
         <p><i class="fas fa-house"></i><span>Sale</span></p>
         <p><i class="fas fa-calendar"></i><span>05-10-2022</span></p>
      </div>
      <h3 class="title">Details</h3>
      <div class="flex">
         <div class="box">
            <p><i>Rooms :</i><span>7.5 Marla</span></p>
            <p><i>deposit amount :</i><span>23 lac</span></p>
            <p><i>Status :</i><span>Ready to move</span></p>
            <p><i>Bedroom :</i><span>4</span></p>
            <p><i>Bathroom :</i><span>3</span></p>
            <p><i>Balcony :</i><span>0</span></p>
         </div>
         <div class="box">
            <p><i>carpet area :</i><span>650sqft</span></p>
            <p><i>age :</i><span>1 years</span></p>
            <p><i>Room floor :</i><span>2</span></p>
            <p><i>Total floors :</i><span>2</span></p>
            <p><i>Furnished :</i>
            <p><i>Loan :</i><span>Available</span></p>
         </div>
      </div>
      <h3 class="title">Amenities</h3>
      <div class="flex">
         <div class="box">
            <p><i class="fas fa-times"></i><span>lifts</span></p>
            <p><i class="fas fa-check"></i><span>security guards</span></p>
            <p><i class="fas fa-times"></i><span>play ground</span></p>
            <p><i class="fas fa-check"></i><span>gardens</span></p>
            <p><i class="fas fa-check"></i><span>water supply</span></p>
            <p><i class="fas fa-check"></i><span>power backup</span></p>
         </div>
         <div class="box">
            <p><i class="fas fa-check"></i><span>parking area</span></p>
            <p><i class="fas fa-times"></i><span>gym</span></p>
            <p><i class="fas fa-times"></i><span>shopping mall</span></p>
            <p><i class="fas fa-check"></i><span>hospital</span></p>
            <p><i class="fas fa-check"></i><span>schools</span></p>
            <p><i class="fas fa-times"></i><span>market area</span></p>
         </div>
      </div>
      <h3 class="title">Description</h3>
      <p class="description">Modern 4 Bed, 3 Bath Home (650+ sq ft). Features a gourmet kitchen (granite), luxurious master suite, finished basement, and large deck with private backyard. Excellent school district. Inquire for a private showing.</p>
 <button id="savePropertyBtn" class="inline-btn">Save Property</button>
<script>
  const saveBtn = document.getElementById('savePropertyBtn');

  const property = {
    id: "113",
    title: "Modern oasis",
    image: "images/home img1.jpg",
    location: "Tehsil, Phalia, Pakistan",
    price: "28.5 lac",
    agent: "Yasir Khan",
    phone: "+92343434333",
    type: "Sale",
    date: "05-10-2022",
    rooms: "7.5Marla",
    deposit: "23 lac",
    status: "Semi-furnished",
    carpet: "650 sqft",
    age: "1 year",
    floor: "32"
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
 <a href="agent1.html" class="inline-btn">Contact Agent</a>
<a href="buyer.html" class="inline-btn">Buy Now</a>

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
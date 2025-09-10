<?php
include 'db.php';
if(isset($_GET['view'])){
    $id = intval($_GET['view']);
    $query = $conn->prepare("SELECT * FROM properties WHERE id=?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $property = $result->fetch_assoc();
} else {
    header("Location: listings.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($property['title']); ?></title>

  <!-- Font Awesome + Style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

  <style>
    .property-container { max-width: 1000px; margin: 20px auto; padding: 20px; }
    .main-image img { width: 90%; max-height: 400px; object-fit: cover; border-radius: 10px; }
    .gallery { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
    .gallery img { width: 120px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; transition: 0.3s; }
    .gallery img:hover { transform: scale(1.05); }
    .details { margin-top: 20px; font-size:1.5rem;}
    .details h2 { margin-bottom: 10px; font-size:2.8rem; }
    .info { display: flex; color:rgb(139, 97, 132); font-size:2.5rem; gap: 20px; margin: 15px 0; flex-wrap: wrap; }
    .info p { display: flex; align-items:center; font-size:2.5rem;  gap: 6px; }
    .owner { display: flex; align-items:  center; font-size:2.5rem; margin: 20px 0; }
    .owner img { width: 80px; height: 80px; font-size:2.0rem; border-radius: 50%; margin-right: 10px; }
    .price { font-size: 28px; font-weight: bold; color: green; margin-top: 15px; }
    .amenities { margin-top: 20px; font-size:2.2rem; }
    .amenities h3 { margin-bottom: 10px; color:rgb(139, 97, 132) }
    .amenities ul { list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 15px; }
    .amenities li { background: #f4f4f4; padding: 8px 12px; border-radius: 8px; }

  </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="property-container">

  <!-- Main Image -->
  <div class="main-image">
    <img id="mainImage" src="<?php echo htmlspecialchars($property['main_image']); ?>" alt="Main Property Image">
  </div>

  <!-- Gallery -->
  <div class="gallery">
    <?php
      $galleryImages = !empty($property['gallery_images']) ? explode(",", $property['gallery_images']) : [];
      foreach($galleryImages as $img){ ?>
        <img src="<?php echo htmlspecialchars($img); ?>" alt="Gallery Image" onclick="changeImage(this)">
    <?php } ?>
  </div>

  <!-- Details -->
 <!-- Owner Info -->
      <div class="owner">
      <img src="<?php echo htmlspecialchars($property['avatar']); ?>" alt="Owner Avatar">
      <div>
        <h4><?php echo htmlspecialchars($property['ownerName']); ?></h4>
        <p>Contact: <?php echo htmlspecialchars($property['phone']); ?></p>
      </div>
    </div>
    
    <!-- Price -->
    <p class="price"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($property['price']); ?></p>


        <div class="info">
      <p><i class="fas fa-bed"></i> <?php echo htmlspecialchars($property['rooms']); ?> Rooms</p>
      <p><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['baths']); ?> Baths</p>
      <p><i class="fas fa-maximize"></i> <?php echo htmlspecialchars($property['size']); ?></p>
      <p><i class="fas fa-calendar"></i> <?php echo date("d-m-Y", strtotime($property['date_posted'])); ?></p>
    </div>


  <div class="details">
    <h2><?php echo htmlspecialchars($property['title']); ?></h2>
    <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($property['location']); ?></p>
<?php if (!empty($property['amenities'])): ?>


  <div class="amenities">
    <h3><i class="fas fa-check-circle"></i> Amenities</h3>
    <ul>
      <?php 
        $amenities = explode(",", $property['amenities']); 
        foreach($amenities as $amenity): ?>
          <li><?php echo htmlspecialchars(trim($amenity)); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>



    <!-- Description -->
    <h3><p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p></h3>

   

  </div>

</section>



<!-- Image Switcher Script -->
<script>
  function changeImage(el) {
    document.getElementById('mainImage').src = el.src;
  }
</script>
<?php include 'footer.php'; ?>
</body>
</html>

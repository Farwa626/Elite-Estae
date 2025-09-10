<?php
session_start();
?>
<?php
include 'db.php';
$result = $conn->query("SELECT * FROM properties ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Listings</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .owner {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
.owner-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}
.thumb {
    position: relative;
}
.thumb img {
    width: 100%;
    border-radius: 8px;
}

.total-images { left: 10px; }
.type { right: 10px; }
.flex {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
}
.flex-btn {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}
</style>
</head>
<body>
<?php include 'header.php' ?>

<section class="listings">
    <h1 class="heading">Our Houses</h1>
    <div class="box-container">

        <?php if ($result->num_rows > 0) { ?>
            <?php while($row = $result->fetch_assoc()) { 
                // gallery images count
                $galleryImages = !empty($row['gallery_images']) ? explode(",", $row['gallery_images']) : [];
                $galleryCount = count($galleryImages);
            ?>
                <div class="box">
                    
                    <!-- Owner Info -->
                    <div class="owner">
                        <img src="<?php echo htmlspecialchars($row['avatar']); ?>" alt="Owner Avatar" class="owner-avatar">
                        <div>
                            <h3><?php echo htmlspecialchars($row['ownerName']); ?> (House #<?php echo $row['id']; ?>)</h3>
                            <p><?php echo date("d-m-Y", strtotime($row['date_posted'])); ?></p>
                        </div>
                    </div>

                    <!-- Property Image -->
                    <div class="thumb">
                        <p class="total-images"><i class="fas fa-image"></i> <?php echo $galleryCount; ?></p>
                        </form>
                        <img src="<?php echo htmlspecialchars($row['main_image']); ?>" alt="Property Image">
                    </div>

                    <!-- Title / Size -->
                    <h3 class="name"><?php echo htmlspecialchars($row['title']); ?></h3>

                    <!-- Location -->
                    <p class="location"><i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($row['location']); ?></span>
                    </p>

                    <!-- Rooms / Baths / Size -->
                    <div class="flex">
                        <p><i class="fas fa-bed"></i><span><?php echo htmlspecialchars($row['rooms']); ?> Rooms</span></p>
                        <p><i class="fas fa-bath"></i><span><?php echo htmlspecialchars($row['baths']); ?> Baths</span></p>
                        <p><i class="fas fa-maximize"></i><span><?php echo htmlspecialchars($row['size']); ?></span></p>
                    </div>

                    <!-- View Property Button -->
                    <a href="property1.php?view=<?php echo htmlspecialchars($row['id']); ?>" class="btn">View Property</a>

                    <!-- Price + Owner -->

                    
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No properties found!</p>
        <?php } ?>

    </div>
</section>
      <div class="pagination">
        <a href="#">&laquo;</a>
         <a href="home.php" >1</a>
         <a href="list2.html">2</a>
          <a href="list3.php"class="active">3</a>
          <a href="list.html">4</a>

<?php include 'footer.php' ?>
<script src="js/script.js"></script>
</body>
</html>

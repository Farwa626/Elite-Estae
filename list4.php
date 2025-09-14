<?php
include 'db.php';

// Buildings fetch
$buildings = $conn->query("SELECT * FROM buildings WHERE status='Active' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Listings</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Buildings</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; }
        .container { width:70%; margin:auto; }
        .building { background:#fff; margin-bottom:40px; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        .building img { width:100%; height:400px; object-fit:cover; border-radius:12px; }
        .building h2 { margin:10px 0; }
        .btn { display:inline-block; padding:10px 16px; margin-top:10px; width: 150px; height: 50px; background: rgb(139, 97, 132); color:#fff; border:none; cursor:pointer; text-decoration:none; text-align:center; line-height:30px; }
        .btn:hover { background: rgba(61, 7, 52, 1); }
        .flats { margin-top:20px; display: block; }
        .flat { background:#f9f9f9; margin-bottom:10px; padding:12px; border-radius:8px; border:1px solid #ddd; display:flex; justify-content:space-between; transition:0.3s; }
        .flat:hover { background:#e3f2fd; }
        .price { font-weight:bold; color:#1976d2; }
    </style>
</head>
<body>
    <?php include 'header.php' ?>
    <div class="container">
        <h1>Available Buildings</h1>

        <?php while($b = $buildings->fetch_assoc()) { ?>
            <div class="building">
                <img src="<?php echo $b['main_image']; ?>" alt="Building">
                <h2><?php echo $b['name']; ?></h2>
                <p><b>Location:</b> <?php echo $b['location']; ?> | <b>Year Built:</b> <?php echo $b['year_built']; ?></p>
                <p><?php echo $b['description']; ?></p>

                <!-- Flats List -->
                <div class="flats" id="flats-<?php echo $b['id']; ?>">
                    <h3>Flats in <?php echo $b['name']; ?></h3>
                    <?php
                    $flats = $conn->query("SELECT * FROM flats WHERE building_id=".$b['id']." ORDER BY price ASC");
                    while($f = $flats->fetch_assoc()) { ?>
                        <div class="flat">
                            <span>Flat <?php echo $f['flat_no']; ?> - <?php echo $f['rooms']; ?> Rooms</span>
                            <span class="price">Rs <?php echo number_format($f['price']); ?></span>
                        </div>
                    <?php } ?>
                    
                    <!-- View Flats Button -->
                    <a class="btn" href="flats4.php?building_id=<?php echo $b['id']; ?>">View Flats</a>
                </div>
            </div>
        <?php } ?>

        <div class="pagination">
            <a href="#">&laquo;</a>
            <a href="home.php">1</a>
            <a href="list2.html" class="active">2</a>
            <a href="#">&raquo;</a>
        </div>
    </div>
</body>
<?php include 'footer.php' ?>
</html>

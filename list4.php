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
    <title>🏢 Buildings</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0;  }
        .container { width:70%; margin:auto; }
        .building { background:#fff; margin-bottom:40px; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        .building img { width:100%; height:400px; object-fit:cover; border-radius:12px; }
        .building h2 { margin:10px 0; }
        .btn { display:inline-block; padding:10px 16px; margin-top:10px; background: rgb(139, 97, 132);; color:#fff; border:none; border-radius:6px; cursor:pointer; text-decoration:none; }
        .btn:hover { background: rgba(61, 7, 52, 1);; }
        .flats { margin-top:20px; display:none; }
        .flat { background:#f9f9f9; margin-bottom:10px; padding:12px; border-radius:8px; border:1px solid #ddd; cursor:pointer; display:flex; justify-content:space-between; transition:0.3s; }
        .flat:hover { background:#e3f2fd; }
        .flat-details { display:none; padding:15px; background:#fff; border-radius:8px; margin-top:10px; border:1px solid #ccc; }

        /* Slider */
        .slider { position: relative; width: 100%; max-height: 300px; overflow: hidden; border-radius: 10px; margin-bottom: 10px; }
        .slider img { width: 100%; display: none; object-fit: cover; border-radius: 10px; opacity: 0; transition: opacity 0.5s ease-in-out; }
        .slider img.active { display: block; opacity: 1; }
        .slider .prev, .slider .next {
            position: absolute; top: 50%; transform: translateY(-50%);
            background: rgba(0,0,0,0.5); color: #fff;
            padding: 8px 12px; border: none; cursor: pointer;
            border-radius: 50%; font-size: 18px;
        }
        .slider .prev { left: 10px; }
        .slider .next { right: 10px; }
        .slider .prev:hover, .slider .next:hover { background: rgba(0,0,0,0.8); }

        /* Thumbnails */
        .thumbnails { display: flex; gap: 10px; margin-top: 10px; justify-content: center; flex-wrap: wrap; }
        .thumbnails img {
            width: 60px; height: 60px; object-fit: cover;
            border-radius: 6px; cursor: pointer; opacity: 0.6;
            border: 2px solid transparent; transition: 0.3s;
        }
        .thumbnails img:hover { opacity: 0.9; }
        .thumbnails img.active-thumb { opacity: 1; border-color: #1976d2; }

        .price { font-weight:bold; color:#1976d2; }
    </style>

    <script>
        function toggleFlats(id) {
            var el = document.getElementById("flats-"+id);
            el.style.display = (el.style.display === "block") ? "none" : "block";
        }
        function toggleDetails(id) {
            var el = document.getElementById("flat-"+id);
            el.style.display = (el.style.display === "block") ? "none" : "block";
        }

        function moveSlide(flatId, step) {
            let slider = document.getElementById("slider-" + flatId);
            let slides = slider.getElementsByClassName("slide");
            let thumbs = document.getElementById("thumbs-" + flatId).getElementsByTagName("img");

            let currentIndex = -1;
            for (let i = 0; i < slides.length; i++) {
                if (slides[i].classList.contains("active")) {
                    currentIndex = i;
                    slides[i].classList.remove("active");
                    thumbs[i].classList.remove("active-thumb");
                    break;
                }
            }

            let newIndex = (currentIndex + step + slides.length) % slides.length;
            slides[newIndex].classList.add("active");
            thumbs[newIndex].classList.add("active-thumb");
        }

        function showSlide(flatId, index) {
            let slider = document.getElementById("slider-" + flatId);
            let slides = slider.getElementsByClassName("slide");
            let thumbs = document.getElementById("thumbs-" + flatId).getElementsByTagName("img");

            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
                thumbs[i].classList.remove("active-thumb");
            }
            slides[index].classList.add("active");
            thumbs[index].classList.add("active-thumb");
        }
    </script>
</head>
<body>
    <?php include 'header.php' ?>
    <div class="container">
        <h1>🏢 Available Buildings</h1>

        <?php while($b = $buildings->fetch_assoc()) { ?>
            <div class="building">
                <img src="<?php echo $b['main_image']; ?>" alt="Building">
                <h2><?php echo $b['name']; ?></h2>
                <p><b>Location:</b> <?php echo $b['location']; ?> | <b>Year Built:</b> <?php echo $b['year_built']; ?></p>
                <p><?php echo $b['description']; ?></p>

                <!-- Button to show flats -->
                <button class="btn" onclick="toggleFlats(<?php echo $b['id']; ?>)">🏠 View Flats</button>

                <!-- Flats (hidden by default) -->
                <div class="flats" id="flats-<?php echo $b['id']; ?>">
                    <h3>Flats in <?php echo $b['name']; ?></h3>
                    <?php
                    $flats = $conn->query("SELECT * FROM flats WHERE building_id=".$b['id']." ORDER BY price ASC");
                    while($f = $flats->fetch_assoc()) { ?>
                        <div class="flat" onclick="toggleDetails(<?php echo $f['id']; ?>)">
                            <span>Flat <?php echo $f['flat_no']; ?> - <?php echo $f['rooms']; ?> Rooms</span>
                            <span class="price">Rs <?php echo number_format($f['price']); ?></span>
                        </div>
                        <div class="flat-details" id="flat-<?php echo $f['id']; ?>">
                            <?php if (!empty($f['images'])) {
                                $flatImages = explode(",", $f['images']); ?>
                                <div class="slider" id="slider-<?php echo $f['id']; ?>">
                                    <?php foreach ($flatImages as $idx => $img) { 
                                        $imgPath = trim($img);
                                        if ($imgPath != "") { ?>
                                            <img src="<?php echo $imgPath; ?>" 
                                                 class="slide <?php echo $idx === 0 ? 'active' : ''; ?>" 
                                                 alt="Flat Image">
                                    <?php } } ?>
                                    <button class="prev" onclick="event.stopPropagation(); moveSlide(<?php echo $f['id']; ?>, -1)">&#10094;</button>
                                    <button class="next" onclick="event.stopPropagation(); moveSlide(<?php echo $f['id']; ?>, 1)">&#10095;</button>
                                </div>
                                <!-- Thumbnails -->
                                <div class="thumbnails" id="thumbs-<?php echo $f['id']; ?>">
                                    <?php foreach ($flatImages as $idx => $img) { 
                                        $imgPath = trim($img);
                                        if ($imgPath != "") { ?>
                                            <img src="<?php echo $imgPath; ?>" 
                                                 class="<?php echo $idx === 0 ? 'active-thumb' : ''; ?>" 
                                                 onclick="event.stopPropagation(); showSlide(<?php echo $f['id']; ?>, <?php echo $idx; ?>)">
                                    <?php } } ?>
                                </div>
                            <?php } ?>
                            <p><b>Floor:</b> <?php echo $f['floor_no']; ?></p>
                            <p><b>Rooms:</b> <?php echo $f['rooms']; ?> | <b>Baths:</b> <?php echo $f['baths']; ?></p>
                            <p><b>Size:</b> <?php echo $f['size']; ?></p>
                            <p><b>Status:</b> <?php echo $f['status']; ?></p>
                            <p><b>Description:</b> <?php echo $f['description']; ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
          </div>
    
        <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="home.php" >1</a>
        <a href="list2.html">2</a>
        <a href="list3.php">3</a>
        <a href="list.html"class="active">4</a>
        <a href="#">&raquo;</a>
</body>
<?php include 'footer.php' ?>
</html>

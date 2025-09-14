<?php
include 'db.php';

// Building ID query string se lo
if (!isset($_GET['building_id'])) {
    die("Building ID not provided");
}

$building_id = intval($_GET['building_id']);

// Building info fetch
$building = $conn->query("SELECT * FROM buildings WHERE id=$building_id")->fetch_assoc();
if (!$building) {
    die("Building not found");
}

// Us building ke flats fetch
$flats = $conn->query("SELECT * FROM flats WHERE building_id=$building_id ORDER BY price ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $building['name']; ?> - Flats</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="save.css">

    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; }
        .container { width:80%; margin:auto; padding:20px; }

        h1 { margin-bottom:20px; }

        .flat { 
            background:#fff; padding:12px; border-radius:8px; 
            border:1px solid #ddd; margin-bottom:10px; 
            cursor:pointer; display:flex; justify-content:space-between;
            transition:0.3s;
        }
        .flat:hover { background:#e3f2fd; }

        .flat-details { 
            display:none; 
            padding:15px; margin-bottom:20px;
            background:#fff; border:1px solid #ccc; border-radius:8px;
        }

        /* Slider */
        .slider { position:relative; width:100%; height:350px; overflow:hidden; border-radius:10px; margin-bottom:10px; }
        .slider img { width:100%; height:100%; object-fit:cover; display:none; }
        .slider img.active { display:block; }
        .slider .prev, .slider .next {
            position:absolute; top:50%; transform:translateY(-50%);
            background:rgba(0,0,0,0.5); color:#fff;
            padding:10px; border:none; cursor:pointer;
            border-radius:50%; font-size:20px;
        }
        .slider .prev { left:10px; }
        .slider .next { right:10px; }

        .thumbnails { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; margin-top:10px; }
        .thumbnails img {
            width:70px; height:70px; object-fit:cover; border-radius:6px;
            cursor:pointer; opacity:0.6; border:2px solid transparent;
        }
        .thumbnails img.active-thumb { opacity:1; border-color:#1976d2; }
    </style>

    <script>
        function toggleDetails(flatId) {
            let allDetails = document.querySelectorAll('.flat-details');
            allDetails.forEach(d => d.style.display = "none"); // ek waqt me ek hi open hoga
            let el = document.getElementById("flat-"+flatId);
            el.style.display = "block";
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
    <h1>Flats in <?php echo $building['name']; ?></h1>

    <?php while($f = $flats->fetch_assoc()) { ?>
        <!-- Flat list -->
        <div class="flat" onclick="toggleDetails(<?php echo $f['id']; ?>)">
            <span>Flat <?php echo $f['flat_no']; ?> - <?php echo $f['rooms']; ?> Rooms</span>
            <span style="font-weight:bold; color:#1976d2;">Rs <?php echo number_format($f['price']); ?></span>
        </div>

        <!-- Flat details -->
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
<?php include 'footer.php' ?>
</body>
</html>

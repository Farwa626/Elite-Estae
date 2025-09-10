<?php
include 'db.php';

$uploadDir = "uploads/";
$message = "";

// ==================== DELETE HANDLER ====================
if (isset($_GET['delete_building'])) {
    $id = intval($_GET['delete_building']);
    $conn->query("DELETE FROM buildings WHERE id=$id");
    $conn->query("DELETE FROM flats WHERE building_id=$id");
    $message = "❌ Building deleted!";
}
if (isset($_GET['delete_flat'])) {
    $id = intval($_GET['delete_flat']);
    $conn->query("DELETE FROM flats WHERE id=$id");
    $message = "❌ Flat deleted!";
}

// ==================== SAVE OR UPDATE ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ---------- SAVE BUILDING ----------
    if (isset($_POST['save_building'])) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $floors = $_POST['floors'];
        $year_built = $_POST['year_built'];
        $status = $_POST['status'];
        $description = $_POST['description'];

        // Main image upload
        $mainImagePath = "";
        if (!empty($_FILES['main_image']['name'])) {
            $mainImagePath = $uploadDir . uniqid() . "_" . basename($_FILES['main_image']['name']);
            move_uploaded_file($_FILES['main_image']['tmp_name'], $mainImagePath);
        }

        $stmt = $conn->prepare("INSERT INTO buildings (name, location, floors, year_built, status, description, main_image) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("ssissss", $name, $location, $floors, $year_built, $status, $description, $mainImagePath);
        $stmt->execute();
        $building_id = $stmt->insert_id;

        // Flats insert
        if (!empty($_POST['flat_no'])) {
            foreach ($_POST['flat_no'] as $i => $flat_no) {
                if (empty($flat_no)) continue;

                $floor_no = $_POST['floor_no'][$i];
                $rooms = $_POST['rooms'][$i];
                $baths = $_POST['baths'][$i];
                $size = $_POST['size'][$i];
                $price = $_POST['price'][$i];
                $fstatus = $_POST['fstatus'][$i];
                $fdesc = $_POST['fdescription'][$i];

                $imagePaths = [];
                if (!empty($_FILES['flat_images']['name'][$i][0])) {
                    foreach ($_FILES['flat_images']['name'][$i] as $k => $imgName) {
                        if (empty($imgName)) continue;
                        $flatImagePath = $uploadDir . uniqid() . "_" . basename($imgName);
                        move_uploaded_file($_FILES['flat_images']['tmp_name'][$i][$k], $flatImagePath);
                        $imagePaths[] = $flatImagePath;
                    }
                }
                $imagesString = implode(",", $imagePaths);

                $stmtF = $conn->prepare("INSERT INTO flats (building_id, flat_no, floor_no, rooms, baths, size, price, status, description, images) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $stmtF->bind_param("isiiiissss", $building_id, $flat_no, $floor_no, $rooms, $baths, $size, $price, $fstatus, $fdesc, $imagesString);
                $stmtF->execute();
            }
        }
        $message = "✅ Building & Flats Added!";
    }

    // ---------- UPDATE FLAT ----------
    if (isset($_POST['update_flat'])) {
        $flat_id = intval($_POST['flat_id']);
        $flat_no = $_POST['flat_no'];
        $floor_no = $_POST['floor_no'];
        $rooms = $_POST['rooms'];
        $baths = $_POST['baths'];
        $size = $_POST['size'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $desc = $_POST['description'];

        // Get old images from DB
        $old = $conn->query("SELECT images FROM flats WHERE id=$flat_id")->fetch_assoc();
        $oldImages = !empty($old['images']) ? explode(",", $old['images']) : [];

        // New images
        $newImages = [];
        if (!empty($_FILES['flat_images']['name'][0])) {
            foreach ($_FILES['flat_images']['name'] as $k => $imgName) {
                if (empty($imgName)) continue;
                $flatImagePath = $uploadDir . uniqid() . "_" . basename($imgName);
                move_uploaded_file($_FILES['flat_images']['tmp_name'][$k], $flatImagePath);
                $newImages[] = $flatImagePath;
            }
        }

        // Merge old + new
        $allImages = array_merge($oldImages, $newImages);
        $imagesString = implode(",", $allImages);

        $stmt = $conn->prepare("UPDATE flats SET flat_no=?, floor_no=?, rooms=?, baths=?, size=?, price=?, status=?, description=?, images=? WHERE id=?");
        $stmt->bind_param("siiiissssi", $flat_no, $floor_no, $rooms, $baths, $size, $price, $status, $desc, $imagesString, $flat_id);
        $stmt->execute();
        $message = "✅ Flat Updated!";
    }
}

// ==================== FETCH DATA ====================
$buildings = $conn->query("SELECT * FROM buildings ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Building & Flats Manager</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; padding:20px; }
        .card { background:#fff; padding:20px; border-radius:8px; margin-bottom:20px; box-shadow:0 3px 6px rgba(0,0,0,0.1); }
        input, select, textarea { margin:5px 0; padding:8px; width:100%; border:1px solid #ccc; border-radius:5px; }
        .flat-row { background:#f9f9f9; padding:10px; margin-bottom:10px; border-radius:6px; }
        button { padding:8px 14px; background:#1976d2; color:#fff; border:none; border-radius:5px; cursor:pointer; }
        button:hover { background:#0d47a1; }
        img.thumb { width:50px; height:50px; object-fit:cover; margin:2px; border-radius:4px; }
        .actions a { margin-left:10px; text-decoration:none; }
    </style>
    <script>
        function addFlatRow() {
            let container = document.getElementById("flats-container");
            let div = document.createElement("div");
            div.classList.add("flat-row");
            div.innerHTML = `
                <input type="text" name="flat_no[]" placeholder="Flat No">
                <input type="number" name="floor_no[]" placeholder="Floor No">
                <input type="number" name="rooms[]" placeholder="Rooms">
                <input type="number" name="baths[]" placeholder="Baths">
                <input type="text" name="size[]" placeholder="Size">
                <input type="text" name="price[]" placeholder="Price">
                <select name="fstatus[]">
                    <option value="Available">Available</option>
                    <option value="Sold">Sold</option>
                    <option value="Rented">Rented</option>
                </select>
                <textarea name="fdescription[]" placeholder="Description"></textarea>
                <input type="file" name="flat_images[][ ]" multiple>
            `;
            container.appendChild(div);
        }
    </script>
</head>
<body>
    <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

    <div class="card">
        <h2>➕ Add Building with Flats</h2>
        <form method="POST" enctype="multipart/form-data">
            <h3>🏢 Building Info</h3>
            <input type="text" name="name" placeholder="Building Name" required>
            <input type="text" name="location" placeholder="Location">
            <input type="number" name="floors" placeholder="Floors">
            <input type="text" name="year_built" placeholder="Year Built">
            <select name="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="file" name="main_image">

            <h3>🏠 Flats Info</h3>
            <div id="flats-container"></div>
            <button type="button" onclick="addFlatRow()">➕ Add Flat</button>
            <br><br>
            <button type="submit" name="save_building">💾 Save Building & Flats</button>
        </form>
    </div>

    <!-- ==================== LIST ==================== -->
    <div class="card">
        <h2>📋 Buildings & Flats</h2>
        <?php while ($b = $buildings->fetch_assoc()) { ?>
            <h3>
                🏢 <?php echo $b['name']; ?> (<?php echo $b['location']; ?>)
                <span class="actions">
                    <a href="?delete_building=<?php echo $b['id']; ?>" onclick="return confirm('Delete this building?')" style="color:red;">❌ Delete</a>
                </span>
            </h3>
            <?php if ($b['main_image']) { ?>
                <img src="<?php echo $b['main_image']; ?>" class="thumb">
            <?php } ?>
            <p><?php echo $b['description']; ?></p>

            <?php
            $flats = $conn->query("SELECT * FROM flats WHERE building_id=" . $b['id']);
            while ($f = $flats->fetch_assoc()) {
                ?>
                <div style="margin:10px 0; padding:10px; border:1px solid #ccc; border-radius:6px;">
                    <b>Flat No:</b> <?php echo $f['flat_no']; ?> |
                    <b>Price:</b> <?php echo $f['price']; ?> |
                    <b>Status:</b> <?php echo $f['status']; ?>
                    <span class="actions">
                        <a href="?delete_flat=<?php echo $f['id']; ?>" onclick="return confirm('Delete this flat?')" style="color:red;">❌ Delete</a>
                        <a href="javascript:void(0)" onclick="document.getElementById('update-form-<?php echo $f['id']; ?>').style.display='block'" style="color:green;">✏️ Update</a>
                    </span>
                    <br>
                    <?php
                    if (!empty($f['images'])) {
                        $imgs = explode(",", $f['images']);
                        foreach ($imgs as $img) {
                            if (!empty($img)) echo "<img src='$img' class='thumb'>";
                        }
                    }
                    ?>

                    <!-- Update Form (hidden by default) -->
                    <div id="update-form-<?php echo $f['id']; ?>" style="display:none; margin-top:10px; background:#f9f9f9; padding:10px; border-radius:6px;">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="flat_id" value="<?php echo $f['id']; ?>">
                            <input type="text" name="flat_no" value="<?php echo $f['flat_no']; ?>" placeholder="Flat No">
                            <input type="number" name="floor_no" value="<?php echo $f['floor_no']; ?>" placeholder="Floor No">
                            <input type="number" name="rooms" value="<?php echo $f['rooms']; ?>" placeholder="Rooms">
                            <input type="number" name="baths" value="<?php echo $f['baths']; ?>" placeholder="Baths">
                            <input type="text" name="size" value="<?php echo $f['size']; ?>" placeholder="Size">
                            <input type="text" name="price" value="<?php echo $f['price']; ?>" placeholder="Price">
                            <select name="status">
                                <option value="Available" <?php if($f['status']=="Available") echo "selected"; ?>>Available</option>
                                <option value="Sold" <?php if($f['status']=="Sold") echo "selected"; ?>>Sold</option>
                                <option value="Rented" <?php if($f['status']=="Rented") echo "selected"; ?>>Rented</option>
                            </select>
                            <textarea name="description" placeholder="Description"><?php echo $f['description']; ?></textarea>
                            <p>Add More Images:</p>
                            <input type="file" name="flat_images[]" multiple>
                            <br>
                            <button type="submit" name="update_flat">💾 Save Update</button>
                            <button type="button" onclick="document.getElementById('update-form-<?php echo $f['id']; ?>').style.display='none'">❌ Cancel</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <hr>
        <?php } ?>
    </div>
</body>
</html>

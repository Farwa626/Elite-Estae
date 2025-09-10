<?php
// suggestpro.php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$properties = json_decode(file_get_contents("property.json"), true);

$property = null;
foreach ($properties as $p) {
    if ($p['id'] == $id) {
        $property = $p;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Suggested Property</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
    .property-card {
      border: 1px solid #ccc;
      border-radius: 12px;
      padding: 20px;
      margin: 50px auto;
      max-width: 500px;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      background: #fff;
    }
    .property-card img {
      width: 100%;
      border-radius: 12px;
      margin-bottom: 15px;
    }
    .property-card h2 {
      margin-bottom: 10px;
      color: #530d44;
    }
    .property-card p {
      margin: 6px 0;
    }
    .btn {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      background: #530d44;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
    }
    .btn:hover {
      background: #722f61;
    }
  </style>
</head>
<?php include 'header.php' ?>
<body>

<?php if ($property): ?>
  <div class="property-card">
      <img src="<?= $property['image'] ?>" alt="<?= $property['title'] ?>">
      <h2><?= $property['title'] ?></h2>
      <p><strong>Location:</strong> <?= $property['location'] ?></p>
      <p><strong>Owner:</strong> <?= $property['owner'] ?></p>
      <p><strong>Size:</strong> <?= $property['size'] ?></p>
      <p><strong>Bedrooms:</strong> <?= $property['bedrooms'] ?> | 
         <strong>Bathrooms:</strong> <?= $property['bathrooms'] ?></p>
      <a href="<?= $property['link'] ?>" class="btn">View Details</a>
  </div>
<?php else: ?>
  <p style="text-align:center; margin-top:50px;">Property not found!</p>
<?php endif; ?>

</body>
<?php include 'footer.php' ?>
</html>

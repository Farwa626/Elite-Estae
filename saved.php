<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Saved Properties</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
  
  <style>
    #savedPropertiesContainer {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
    }

    .saved-card {
      border: 1px solid #ccc;
      padding: 15px;
      width: 250px;
      font-family: sans-serif;
      background: white;
    }

    .saved-card img {
      width: 100%;
      height: auto;
    }

    .saved-card h3 {
      margin: 10px 0 5px;
      font-size: 18px;
    }

    .saved-card p {
      margin: 4px 0;
      font-size: 14px;
    }

    .saved-card button {
      margin-top: 10px;
      padding: 6px 12px;
      background-color: #d9534f;
      color: white;
      border: none;
      cursor: pointer;
    }

    .saved-card button:hover {
      background-color: #c9302c;
    }

  </style>
</head>
<body>
  <?php include 'header.php' ?>

  <h2>Saved Properties</h2>
  <div id="savedPropertiesContainer"></div>

  <script>
  const container = document.getElementById('savedPropertiesContainer');
  let saved = JSON.parse(localStorage.getItem('savedProperties')) || [];

  function displaySavedProperties() {
    container.innerHTML = "";

    if (saved.length === 0) {
      container.innerHTML = "<p>No saved properties found.</p>";
      return;
    }

    saved.forEach((property) => {
      const card = document.createElement('div');
      card.className = "saved-card";

      card.innerHTML = `
        <img src="${property.image}" alt="${property.title}">
        <h3>${property.title}</h3>
        <p><strong>Location:</strong> ${property.location}</p>
        <p><strong>Price:</strong> ${property.price}</p>
        <p><strong>Agent:</strong> ${property.agent}</p>
        <p><strong>Phone:</strong> ${property.phone}</p>
        <p><strong>Type:</strong> ${property.type}</p>
        <button onclick="removeProperty('${property.id}')">Remove</button>
      `;

      container.appendChild(card);
    });
  }

  function removeProperty(id) {
    saved = saved.filter(property => property.id !== id);
    localStorage.setItem('savedProperties', JSON.stringify(saved));
    displaySavedProperties();
  }

  displaySavedProperties();
</script>

  <?php include 'footer.php' ?>
</body>
</html>

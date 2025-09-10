<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elite Estate | Blog</title>
  <link rel="stylesheet" href="news.css">
  <link rel="stylesheet" href="animation.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
<?php include 'header.php' ?>
  <!-- Hero Section -->
  <section class="hero">
    <h1>Elite Estate Blog</h1>
    <p>Your trusted source for real estate news, property advice, and renovation tips.</p>
  </section>
  <!-- Blog Layout -->
  <main class="blog-container">
    <!-- Blog Posts -->
    <div class="posts">
      <article class="card">
        <img src="images/news pic.png" alt="Real Estate News">
        <h2>Latest Real Estate News</h2>
        <p>updated with property market trends, housing policies, and upcoming projects.</p>
        <a href="news1data.php">Read More →</a>
      </article>

      <article class="card">
        <img src="images/adviser.jpg" alt="Property Advice">
        <h2>Expert Advice for Buyers</h2>
        <p>Helpful tips to guide you in buying, selling, or renting your dream property.</p>
        <a href="news2data.php">Read More →</a>
      </article>

      <article class="card">
        <img src="images/home renovation.png" alt="Renovation Tips">
        <h2>House Renovation Tips</h2>
        <p>Discover smart ways to upgrade your home and increase its market value.</p>
        <a href="news3data.php">Read More →</a>
      </article>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
  <h2><i class="fas fa-clock"></i> Recent Posts</h2>
  <ul>
    <li><a href="investment-2025.php"><i class="fas fa-chart-line"></i> Top 5 Investment Locations 2025</a></li>
    <li><a href="renovation-mistake.php"><i class="fas fa-tools"></i> Renovation Mistakes to Avoid</a></li>
    <li><a href="tips.php"><i class="fas fa-hand-holding-usd"></i> Mortgage Tips for First-Time Buyers</a></li>
  </ul>
</aside>

  </main>
  <?php include 'footer.php' ?>
</body>
</html>

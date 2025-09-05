<header class="header">
  <nav class="navbar nav-1">
    <section class="flex">
      <a href="home.php" class="logo"><i class="fas fa-house"></i><b>ELITE ESTATE</b></a>
      <ul>
        <li><a href="view property/post property.html">post property<i class="fas fa-paper-plane"></i></a></li>
      </ul>
    </section>
  </nav>

  <nav class="navbar nav-2">
    <section class="flex">
      <div id="menu-btn" class="fas fa-bars"></div>

      <div class="menu">
        <ul>
          <!-- Buy -->
          <li>
            <a href="temp.php" class="help-link">Buy<i class="fas fa-angle-down"></i></a>
            <ul class="help-dropdown">
              <li><a href="list2.php">House</a></li>
              <li><a href="flat3.php">Flat</a></li>
              <li><a href="furnish1.php">Furnished</a></li>
            </ul>
          </li>

          <!-- Sell -->
          <li>
            <a href="request.php" class="help-link">Sell<i class="fas fa-angle-down"></i></a>
            <ul class="help-dropdown">
              <li><a href="post property.php">Post property</a></li>
              <li><a href="addpromotion.php">Dashboard</a></li>
            </ul>
          </li>

          <!-- Rent -->
          <li>
            <a href="#" class="help-link">Rent<i class="fas fa-angle-down"></i></a>
            <ul class="help-dropdown">
              <li><a href="house.php">House</a></li>
              <li><a href="Rflats.php">Flat</a></li>
            </ul>
          </li>

          <!-- Help -->
          <li>
            <a href="agentpanel.php" class="help-link">Help<i class="fas fa-angle-down"></i></a>
            <ul class="help-dropdown">
              <li><a href="about1.php">About Us</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li><a href="contact.php#faq">FAQ</a></li>
            </ul>
          </li>


  
        <li>
        <a href="#" class="help-link">Agents<i class="fas fa-angle-down"></i></a>
            <ul class="help-dropdown">
              <li><a href="agent1.php">Our Agents</a></li>
              <li><a href="agent request.php">Request for Agent</a></li>
            </ul>
          </li>
     </ul>
      </div>

       <ul>
        <li><a href="saved.php">Saved <i class="far fa-heart"></i></a></li>
        <li>
          <a href="add dumy.php" class="help-link">Account <i class="fas fa-angle-down"></i></a>
          <ul class="help-dropdown">
            <?php if (isset($_SESSION['user_id'])): ?>
              <li><a href="#"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
              <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
              <li><a href="login1.php">Login</a></li>
              <li><a href="register.php">Register</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </section>
  </nav>
</header>

<style>
/* --- Common Styles --- */
.help-link {
  color: #333;
  cursor: pointer;
  transition: color 0.2s ease;
}

.help-link:hover {
  color: #007bff;
}

.help-link i {
  margin-left: 5px;
  transition: transform 0.3s ease;
}

li:hover > a.help-link i {
  transform: rotate(180deg);
}

/* Dropdown hidden initially */
.help-dropdown {
  max-height: 0;
  overflow: hidden;
  list-style: none;
  padding: 0;
  margin: 0;
  transition: max-height 0.5s ease;
}

/* Desktop hover open */
@media (min-width: 769px) {
  li:hover > .help-dropdown {
    max-height: 500px;
  }
  li:hover > .help-dropdown li {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Dropdown items */
.help-dropdown li {
  opacity: 0;
  transform: translateY(-10px);
  transition: all 0.6s ease;
}

li:hover > .help-dropdown li:nth-child(1) { transition-delay: 0.1s; }
li:hover > .help-dropdown li:nth-child(2) { transition-delay: 0.2s; }
li:hover > .help-dropdown li:nth-child(3) { transition-delay: 0.3s; }
li:hover > .help-dropdown li:nth-child(4) { transition-delay: 0.4s; }

.help-dropdown li a {
  display: block;
  padding: 8px 12px;
  font-size: 1rem;
  color: #333;
  text-decoration: none;
  transition: background 0.3s;
}

.help-dropdown li a:hover {
  background: #f0f0f0;
}

/* --- Mobile Styles --- */
@media (max-width: 768px) {
  .menu {
    display: none;
    flex-direction: column;
    background: #fff;
    width: 100%;
  }
  .menu.active {
    display: flex;
  }
  .help-dropdown.active {
    max-height: 500px;
  }
  .help-dropdown.active li {
    opacity: 1;
    transform: translateY(0);
  }
  .help-dropdown.active li:nth-child(1) { transition-delay: 0.1s; }
  .help-dropdown.active li:nth-child(2) { transition-delay: 0.2s; }
  .help-dropdown.active li:nth-child(3) { transition-delay: 0.3s; }
  .help-dropdown.active li:nth-child(4) { transition-delay: 0.4s; }
}
</style>

<script>
const menuBtn = document.getElementById("menu-btn");
const menu = document.querySelector(".menu");
const dropdownLinks = document.querySelectorAll(".help-link");

menuBtn.addEventListener("click", () => {
  menu.classList.toggle("active");
});

// Mobile dropdown toggle
dropdownLinks.forEach(link => {
  link.addEventListener("click", e => {
    if (window.innerWidth <= 768) {
      e.preventDefault();
      const dropdown = link.nextElementSibling;
      dropdown.classList.toggle("active");
    }
  });
});
</script>

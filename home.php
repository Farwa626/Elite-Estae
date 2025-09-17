<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE ESTATE</title>
    <link rel="shortcut icon" href="Elite estate.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href ="css/agent1.css">
    
    <style>
       
        body {
            background-color: rgb(230, 214, 245); 
#splash {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(35, 12, 59, 0.6);
          backdrop-filter: blur(8px);
          display: flex;
          justify-content: center;
          align-items: center;
          flex-direction: column;
          color: white;
          font-family: Arial, sans-serif;
          font-size: 28px;
          z-index: 1000;
        }
        #splash h1 {
          margin: 0;
          animation: fadeIn 0.5s ease-in-out;
        }
        #splash p {
          font-size: 16px;
          margin-top: 10px;
          opacity: 0.8;
        }

       
        #main {
          display: none;
        }

        @keyframes fadeIn {
          from { opacity: 0; }
          to { opacity: 1; }
        }        
        /* Hero Section Styles */
        .hero-section {
            background-image: url(images/bg.png);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero-content {
            z-index: 1;
            max-width: 80%;
        }

        .hero-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInUp 1s ease-out 0.5s forwards;
        }

        .hero-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(-15px);
            animation: fadeInUp 1s ease-out 0.7s forwards;
        }

        .cta-button {
            background-color: rgb(97, 9, 60);
            color: white;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInUp 1s ease-out 0.9s forwards;
        }

        .cta-button:hover {
            background-color: rgb(65, 50, 59);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-text {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            .hero-text {
                font-size: 0.9rem;
            }
            .cta-button {
                font-size: 1rem;
                padding: 0.75rem 1rem;
            }
        }

        .home .center form {
            background-color: #834983ff;
            padding: 40px; 
            width: 90%; 
            max-width: 600px;
            margin: 80px auto;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            position: relative;
        }
    /* Search Box */
    .search-box {
      text-align: center;
      margin-bottom: 10px;
      position: relative;
    }
    .search-box input {
      padding: 10px 18px;
      width: 350px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 25px;
      outline: none;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    .search-box input:focus {
      border-color: #007BFF;
      box-shadow: 0 4px 12px rgba(0,123,255,0.2);
    }
    /* Suggestions dropdown */
    #suggestions {
      max-width: 350px;
      margin: 6px auto 0;
      border-radius: 6px;
      background: #fff;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      z-index: 100;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      overflow: hidden;
      animation: fadeIn 0.2s ease-in-out;
    }
    #suggestions div {
      padding: 8px 12px;
      cursor: pointer;
      border-bottom: 1px solid #f1f1f1;
      transition: background 0.2s ease;
      font-size: 14px;
      white-space: nowrap;       
      overflow: hidden;          
      text-overflow: ellipsis;   
    }
    #suggestions div:last-child {
      border-bottom: none;
    }
    #suggestions div:hover {
      background: #f7f9fc;
    }
    /* Property details card */
    #propertyDetails {
      margin-top: 40px;
      display: none;
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
      border-radius: 12px;
      padding: 18px;
      text-align: center;
      background: #fff;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      animation: fadeIn 0.3s ease-in-out;
    }
    #propertyDetails img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    #propertyDetails h3 {
      margin: 12px 0 6px;
      color: #333;
      font-size: 20px;
    }
    #propertyDetails p {
      margin: 4px 0;
      color: #555;
      font-size: 14px;
    }
    #propertyDetails a {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 15px;
      background: #007BFF;
      color: white;
      text-decoration: none;
      border-radius: 20px;
      font-size: 14px;
      transition: background 0.3s ease;
    }
    #propertyDetails a:hover {
      background: #0056b3;
    }
    /* Smooth fade-in animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-5px); }
      to { opacity: 1; transform: translateY(0); }
    }



        /* Services section styles */
        .box-container1 {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            max-width: 1000px;
            margin: 50px auto;
        }

        .box1 {
            width: 300px;
            height: 350px;
            padding: 20px;
            border: 1px solid #1f0213ff;
            margin: 10px;
            text-align: center;
            transition: transform 0.5s ease-in-out;
            overflow: hidden;
        }

        .box1 img {
            width: 50%;
            height: auto;
            transition: transform 0.5s ease-in-out;
        }

        .box1:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .box1:hover img {
            transform: scale(1.3);
        }

        @media (max-width: 700px) {
            .box-container1 {
                flex-direction: column;
            }
            .box1 {
                width: 90%;
                margin: 10px auto;
            }
        }

        .services .box-container1 .box1 p {
            line-height: 2;
            font-size: 1.6rem;
            color: var(--light-color);
            padding-top: .5rem;
        }

        .p {
            font-size: 3rem;
        }

       
        
        .agent-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: nowrap;
            padding: 50px;
            overflow-x: auto;
        }
        .agent-box {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 30px;
            width: 350px;
            margin: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 1s ease forwards;
            opacity: 0;
            text-align: center;
    
        }
        .agent-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .agent-box img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 4px solid #ddd;
        }
        .agent-box h2 {
            font-size: 2.5rem;
            color: #530d44ff;
            margin-bottom: 15px;
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif
        }
        .agent-box p {
            font-size: 1.9rem;
            color: #555;
            margin-bottom: 10px;
        }
        .hire-btn {
            display: inline-block;
            background-color: #10af10ff;
            color: rgb(238, 230, 234);
            padding: 20px 23px;
            border-radius: 10px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s ease;
             font-size: 1.2rem;
        }
        .hire-btn:hover {
            background-color: #722f61;
        }
    </style>
</head>
<body>
  <div id="splash">
    <i class="fas fa-house fa-2x"></i>
    <h1>Elite Estate</h1>
    <p>Your Trusted Property Partner</p>
</div>

<?php include 'header.php'; ?>
<div id="main" style="display:none;"> 
    <div class="hero-section">
        <div class="overlay">
            <div class="hero-content">
                <h1 class="hero-title">Discover Your Dream Home</h1>
                <p class="hero-text">We help you find the perfect property for your needs.</p>
                <a href="#listings-section" class="cta-button">Search Properties</a>
            </div>
        </div>
    </div>
<div class="home">
<section class="center">
  <div class="search-box">
    <input type="text" id="searchInput" placeholder="Search by title or location...">
    <div id="suggestions"></div>
  </div>

  <div id="propertyDetails"></div>
</section>
    <section class="services">
        <h1 class="heading">Our Services</h1>
        <div class="box-container1">
            <div class="box1">
                <a href="list2.php">
                    <img src="images/buy house.png" alt="">
                </a>
                <h3>Buy house</h3>
                <p>Real estate is land and any permanent structures or improvements attached to the land.</p>
            </div>
            <div class="box1">
                <a href="house.php">
                    <img src="images/rent house.png" alt="">
                </a>
                <h3>Rent house</h3>
                <p>Provide description of the property, including any unique features. Eg numbers of rooms, bathrooms, or the style.</p>
            </div>
            <div class="box1">
                <a href="property.php">
                    <img src="images/sell house.png" alt="">
                </a>
                <h3>Sell house</h3>
                <p>Include information about the property (Number of Bedrooms, bathrooms, Size of rooms), the payment process.</p>
            </div>
            <div class="box1">
                <a href="Rflats.php">
                    <img src="images/flat and buildings.png" alt="">
                </a>
                <h3>Flats</h3>
                <p>Flats are more affordable. Typically consist of multiple rooms, bedrooms, kitchen, bathroom.</p>
            </div>
            <div class="box1">
                <a href="furnish1.php">
                    <img src="images/b.flats.png" alt="">
                </a>
                <h3>Building</h3>
                <p>A building is an enclosed structure with a roof and walls, usually standing permanently in one place.</p>
            </div>
            <div class="box1">
                <a href="hajraahmad12@gmail.com">
                    <img src="images/gamil services.png" alt="">
                </a>
                <h3>24/7 service</h3>
                <p>Our services are available 24/7, so you can always reach us when you need assistance.you can approach.</p>
            </div>
            <div class="box1">
                <a href="agent1.php">
                    <img src="images/hier agents.png" alt="">
                </a>
                <h3>Hiring Agents</h3>
                <p>If you want to visit place then hire agents to conduct property viewings and provide exceptional service.</p>
            </div>
            <div class="box1">
                <a href="Blog.php">
                    <img src="images/blog.png" alt="">
                </a>
                <h3>Blogs</h3>
                <p>Advertisment help you to Advertising your project, promoting events,or enhancing brand visibility.</p>
            </div>
            <div class="box1">
                <a href="contact.php#faq">
                    <img src="images/feedback.png" alt="">
                </a>
                <h3>Feedback & Helpcenter</h3>
                <p>Visit our help center for FAQs, support, and to share your feedback so we can better serve you.</p>
            </div>
        </div>
    </section> 
  <header style="background-color: #111; color: white; padding: 20px; text-align: center;text-size-adjust: 100px;">
        <h1>Meet Our Agents</h1>
        <p><h2>Find your trusted property consultant</h2></p>
    </header>

    <section class="agent-container">

   <div class="agent-box" style="animation-delay: 0s">
  <img src="images/agents pic5.jpg" alt="Agent 1">
  <h2>Alia Aftab</h2>
  <p><strong>ID:</strong> 7012</p>
  <p><strong>Experience:</strong> 4 years</p>
   <p><strong>Phone:</strong> <a href="tel:923471637162">03471637162</a></p>
  <p><strong>Email:</strong> <a href="mailto:alia23@gmail.com">alia23@gmail.com</a></p>
  <a href="https://wa.me/923121234567?text=Hi%20Alia%2C%20I%20am%20interested%20in%20your%20services" class="hire-btn">
  <i class="fab fa-whatsapp"></i> Chat on WhatsApp
</a>
</div>
      <div class="agent-box" style="animation-delay: 0.2s">
    <img src="images/agents pic4.jpg" alt="Agent 2">
    <h2>Aira Yousaf</h2>
    <p><strong>ID:</strong> 7020</p>
    <p><strong>Experience:</strong> 6 years</p>
     <p><strong>Phone:</strong> <a href="tel:923194672479">0319-4672479</a></p>
         <p><strong>Email:</strong> <a href="mailto:alia23@gmail.com">alia23@gmail.com</a></p>
         <a href="https://wa.me/923121234567?text=Hi%20Alia%2C%20I%20am%20interested%20in%20your%20services" class="hire-btn">
  <i class="fab fa-whatsapp"></i> Chat on WhatsApp
</a>
</div>
        <div class="agent-box" style="animation-delay: 0.4s">
            <img src="images/agents pic 6.jpg" alt="Agent 3">
            <h2>Nayyab ahmad</h2>
            <p><strong>ID:</strong> 7035</p>
            <p><strong>Experience:</strong> 5 years</p>
           <p><strong>Phone:</strong> <a href="tel:923428772209">0342-8772209</a></p>
                <p><strong>Email:</strong> <a href="mailto:alia23@gmail.com">alia23@gmail.com</a></p>
         <a href="https://wa.me/923121234567?text=Hi%20Alia%2C%20I%20am%20interested%20in%20your%20services" class="hire-btn">
  <i class="fab fa-whatsapp"></i> Chat on WhatsApp
</a>
        </div>

    </section>
<section class="listings" id="listings-section">

   <h1 class="heading">latest listings</h1>

   <div class="box-container">

      <div class="box" data-house-id="123"> <div class="admin">
         <img src="images/profile.png" alt="Avatar" class="avatar">
         <div>
             <p>Azam Ryyaz <span class="house-number">(House #123)</span></p> <span>03-01-2020</span>
         </div>
     </div>
     <div class="thumb">
            <p class="total-images"><i class="far fa-image"></i><span>7</span></p>
         <form action="" method="post" class="save"></form>
        <img src="images/vs1.jpg" alt="">
     </div>
     <h3 class="name">7 Marla</h3>
     <p class="location"><i class="fas fa-map-marker-alt"></i><span>Tehsil, Mandibhauddin, Pakistan</span></p>
     <div class="flex">
         <p><i class="fas fa-bed"></i><span>3</span></p>
         <p><i class="fas fa-bath"></i><span>2</span></p>
         <p><i class="fas fa-maximize"></i><span>750sqft</span></p>
     </div>
     <a href="vf1.php" class="btn">view property</a>
 </div>
      <div class="box" data-house-id="124">
         <div class="admin">
            <img src="images/man_7790130.png" alt="Avatar" class="avatar">
            <div>
               <p>Shahid Hussain <span class="house-number">(House #124)</span></p><span>06-20-2022</span>
            </div>
         </div>
         <div class="thumb">
            <p class="total-images"><i class="far fa-image"></i><span>6</span></p>
            <form action="" method="post" class="save">
               
            </form>
            <img src="images/vs2.jpg" alt="">
         </div>
         <h3 class="name">6 Marla</h3>
         <p class="location"><i class="fas fa-map-marker-alt"></i><span>Tehsil, Phalia, Pakistan</span></p>
         <div class="flex">
            <p><i class="fas fa-bed"></i><span>4</span></p>
            <p><i class="fas fa-bath"></i><span>2</span></p>
            <p><i class="fas fa-maximize"></i><span>600sqft</span></p>
         </div>
         <a href="vf2.php" class="btn">view property</a>
      </div>

      <div class="box" data-house-id="123">
         <div class="admin">
            <img src="images/man_4140048.png" alt="Avatar" class="avatar">
            <div>
               <p>Yasir khan  <span class="house-number">(House #125)</span></p>
               <span>05-10-2022</span>
            </div>
         </div>
         <div class="thumb">
            <p class="total-images"><i class="far fa-image"></i><span>7</span></p>
            <img src="images/home img1.jpg" alt="">
         </div>
         <h3 class="name">7.5 Marla</h3>
         <p class="location"><i class="fas fa-map-marker-alt"></i><span>Tehsil, Mandibhauddin,Pakistan</span></p>
         <div class="flex">
            <p><i class="fas fa-bed"></i><span>4</span></p>
            <p><i class="fas fa-bath"></i><span>3</span></p>
            <p><i class="fas fa-maximize"></i><span>650sqft</span></p>
         </div>
         <a href="vf3.php" class="btn">view property</a>
      </div>

   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="list2.php" class="inline-btn">view all</a>
   </div>

</section>

<?php include 'footer.php'; ?>



  <script>
     setTimeout(() => {
        document.getElementById("splash").style.display = "none";
        document.getElementById("main").style.display = "block";
    }, 2500);

    let properties = [];

   
    async function loadProperties() {
      try {
        let response = await fetch("property.json");
        properties = await response.json();
      } catch (error) {
        console.error("Error loading properties", error);
      }
    }


    function showSuggestions(list, queryWords, dbResults = "") {
      let suggestions = document.getElementById("suggestions");
      suggestions.innerHTML = "";

      if (list.length > 0) {
        list.slice(0, 5).forEach(item => {
          let div = document.createElement("div");
          let text = item.title + " • " + item.location;

  
          let highlighted = text;
          queryWords.forEach(word => {
            let regex = new RegExp("(" + word + ")", "gi");
            highlighted = highlighted.replace(regex, "<b>$1</b>");
          });

          div.innerHTML = highlighted;
          div.style.cursor = "pointer";
          div.addEventListener("click", () => showPropertyDetails(item));
          suggestions.appendChild(div);
        });
      }

 
      if (dbResults.trim() !== "") {
        let dbDiv = document.createElement("div");
        dbDiv.innerHTML = "<hr><b>Database Results:</b>" + dbResults;
        suggestions.appendChild(dbDiv);
      }

   
      if (list.length === 0 && dbResults.trim() === "") {
        suggestions.innerHTML = `<div>No results found</div>`;
      }
    }

    function showPropertyDetails(item) {

      window.location.href = "suggestpro.php?id=" + encodeURIComponent(item.id);
    }

    
    document.getElementById("searchInput").addEventListener("input", function () {
      let query = this.value.toLowerCase().trim();

      if (!query) {
        document.getElementById("suggestions").innerHTML = "";
        return;
      }

      let words = query.split(/\s+/);


      let filtered = properties.filter(item => {
        let text = (item.title + " " + item.location).toLowerCase();
        return words.every(word => text.includes(word));
      });

      fetch("search.php?q=" + encodeURIComponent(query))
        .then(res => res.text())
        .then(dbResults => {
          showSuggestions(filtered, words, dbResults);
        })
        .catch(() => {
          showSuggestions(filtered, words, "");
        });
    });

    document.addEventListener("click", function (e) {
      if (!e.target.closest(".search-box")) {
        document.getElementById("suggestions").innerHTML = "";
      }
    });

    // Load properties on page load
    loadProperties();
</script>

</body>
</html>

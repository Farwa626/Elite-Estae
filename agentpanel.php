<?php
session_start();
include "db.php";

// 🚪 Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: agentpanel.php");
    exit;
}

// 🔑 Login Check (by agent_code)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $agent_code = $_POST['agent_code'];

    $stmt = $conn->prepare("SELECT * FROM agents WHERE email=? AND agent_code=?");
    $stmt->bind_param("ss", $email, $agent_code);
    $stmt->execute();
    $agent = $stmt->get_result()->fetch_assoc();

    if ($agent) {
        $_SESSION['agent_id'] = $agent['agent_id'];
        $_SESSION['agent_name'] = $agent['name'];
    } else {
        $error = "Invalid credentials!";
    }
}

// ✅ If logged in
if (isset($_SESSION['agent_id'])) {
    $agent_id = $_SESSION['agent_id'];

    // Get Agent Info
    $agentData = $conn->query("SELECT * FROM agents WHERE agent_id=$agent_id")->fetch_assoc();

    // Count Stats
    $prop_count = $conn->query("SELECT COUNT(*) as total FROM properties")->fetch_assoc()['total'];

    // Properties
    $properties = $conn->query("SELECT id, title, location, price, status, ownername, phone, date_posted FROM properties ORDER BY date_posted DESC");

    // ➕ Add Property Request
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_property'])) {
        $title = $_POST['title'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $ownername = $_POST['ownername'];
        $phone = $_POST['phone'];
        $status = "pending";

        $stmt = $conn->prepare("INSERT INTO properties (title, location, price, ownername, phone, status, date_posted) VALUES (?,?,?,?,?,?,NOW())");
        $stmt->bind_param("ssssss", $title, $location, $price, $ownername, $phone, $status);
        $stmt->execute();
        $success = "Your property request has been sent to admin.";
    }

    // ✏️ Update Profile
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $experience = $_POST['experience'];

        // Profile Picture Upload
        $picture = $agentData['picture'];
        if (!empty($_FILES['picture']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            $target_file = $target_dir . time() . "_" . basename($_FILES["picture"]["name"]);
            move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
            $picture = $target_file;
        }

        $stmt = $conn->prepare("UPDATE agents SET name=?, email=?, phone=?, experience=?, picture=? WHERE agent_id=?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $experience, $picture, $agent_id);
        if ($stmt->execute()) {
            $_SESSION['agent_name'] = $name;
            $success_profile = "Profile updated successfully!";
            $agentData = $conn->query("SELECT * FROM agents WHERE agent_id=$agent_id")->fetch_assoc(); // refresh
        } else {
            $error_profile = "Failed to update profile!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Agent Panel - EliteEstate</title>
  <style>
    body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background:#f4f6f9; margin:0; padding:0; color:#333; }
    header { background:#007BFF; color:#fff; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 3px 6px rgba(0,0,0,0.1); }
    header h1 { margin:0; font-size:22px; }
    header nav a { color:#fff; margin-left:20px; text-decoration:none; font-weight:500; }
    header nav a:hover { text-decoration:underline; }

    .container { width:95%; max-width:1100px; margin:30px auto; background:#fff; padding:25px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.08); }
    h2 { margin-bottom:20px; color:#222; font-size:24px; }
    h3 { color:#444; margin-bottom:15px; }

    .tabs { display:flex; gap:12px; margin-bottom:20px; border-bottom:2px solid #eee; padding-bottom:8px; flex-wrap:wrap; }
    .tab { padding:10px 20px; background:#f1f3f6; border-radius:6px 6px 0 0; cursor:pointer; transition:0.3s; font-weight:500; }
    .tab:hover { background:#e1e5eb; }
    .tab.active { background:#007BFF; color:#fff; font-weight:bold; }
    .tab-content { display:none; }
    .tab-content.active { display:block; animation: fadeIn 0.4s ease; }

    table { width:100%; border-collapse:collapse; margin-top:15px; font-size:15px; }
    table thead { background:#007BFF; color:#fff; }
    th, td { padding:12px 10px; border:1px solid #ddd; text-align:left; }
    tr:nth-child(even) { background:#f9f9f9; }

    .btn { padding:10px 18px; background:#007BFF; color:white; border:none; border-radius:6px; cursor:pointer; transition:0.3s; font-size:15px; }
    .btn:hover { background:#0056b3; }

    .form-group { margin-bottom:12px; }
    label { display:block; margin-bottom:5px; font-weight:600; color:#444; }
    input[type="text"], input[type="number"], input[type="email"], input[type="file"] { width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; transition:0.3s; }
    input:focus { border-color:#007BFF; outline:none; box-shadow:0 0 6px rgba(0,123,255,0.2); }

    .success { color:green; margin:10px 0; font-weight:bold; }
    .error { color:red; margin:10px 0; font-weight:bold; }

    .profile-card { display:flex; align-items:center; gap:20px; background:#f9f9f9; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); max-width:600px; margin-bottom:20px; }
    .profile-card img { width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #007BFF; }
    .profile-info p { margin:6px 0; font-size:15px; }
    .profile-info b { color:#007BFF; }

    @keyframes fadeIn { from {opacity:0; transform:translateY(5px);} to {opacity:1; transform:translateY(0);} }
  </style>
  <script>
    function openTab(tabName) {
      var contents = document.getElementsByClassName("tab-content");
      for (var i=0;i<contents.length;i++) { contents[i].classList.remove("active"); }
      var tabs = document.getElementsByClassName("tab");
      for (var i=0;i<tabs.length;i++) { tabs[i].classList.remove("active"); }
      document.getElementById(tabName).classList.add("active");
      document.getElementById("tab-"+tabName).classList.add("active");
    }
  </script>
</head>
<body>

<?php if (!isset($_SESSION['agent_id'])): ?>
<!-- 🔑 Login Form -->
<header>
  <h1>EliteEstate - Agent Login</h1>
</header>
<div class="container">
  <h2>Login to Your Account</h2>
  <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
  <form method="post">
    <input type="hidden" name="login" value="1">
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label>Agent Code</label>
      <input type="text" name="agent_code" required>
    </div>
    <button class="btn">Login</button>
  </form>
</div>

<?php else: ?>
<!-- 🎯 Agent Panel -->
<header>
  <h1>EliteEstate - Agent Panel</h1>
  <nav>
    <span>👤 <?= $_SESSION['agent_name'] ?></span>
    <a href="?logout=1">Logout</a>
  </nav>
</header>

<div class="container">
  <!-- Tabs -->
  <div class="tabs">
    <div class="tab active" id="tab-dashboard" onclick="openTab('dashboard')">Dashboard</div>
    <div class="tab" id="tab-properties" onclick="openTab('properties')">My Properties</div>
    <div class="tab" id="tab-add" onclick="openTab('add')">Add Property</div>
    <div class="tab" id="tab-profile" onclick="openTab('profile')">Profile</div>
  </div>

  <!-- 📊 Dashboard -->
  <div class="tab-content active" id="dashboard">
    <h3>Dashboard Overview</h3>
    <p>Total Properties: <b><?= $prop_count ?></b></p>
  </div>

  <!-- 🏠 Properties -->
  <div class="tab-content" id="properties">
    <h3>All Properties</h3>
    <table>
      <thead>
        <tr><th>Title</th><th>Location</th><th>Price</th><th>Status</th><th>Owner</th><th>Phone</th><th>Date Posted</th></tr>
      </thead>
      <tbody>
      <?php while($p = $properties->fetch_assoc()): ?>
      <tr>
        <td><?= $p['title'] ?></td>
        <td><?= $p['location'] ?></td>
        <td><?= $p['price'] ?></td>
        <td><?= ucfirst($p['status']) ?></td>
        <td><?= $p['ownername'] ?></td>
        <td><?= $p['phone'] ?></td>
        <td><?= $p['date_posted'] ?></td>
      </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- ➕ Add Property -->
  <div class="tab-content" id="add">
    <h3>Request New Property</h3>
    <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
    <form method="post">
      <input type="hidden" name="add_property" value="1">
      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" required>
      </div>
      <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" required>
      </div>
      <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" required>
      </div>
      <div class="form-group">
        <label>Owner Name</label>
        <input type="text" name="ownername" required>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" required>
      </div>
      <button class="btn">Submit Request</button>
    </form>
  </div>

  <!-- 👤 Profile -->
  <div class="tab-content" id="profile">
    <h3>My Profile</h3>
    <?php if(isset($success_profile)) echo "<div class='success'>$success_profile</div>"; ?>
    <?php if(isset($error_profile)) echo "<div class='error'>$error_profile</div>"; ?>

    <div class="profile-card">
      <img src="<?= !empty($agentData['picture']) ? $agentData['picture'] : 'https://via.placeholder.com/100' ?>" alt="Profile Picture">
      <div class="profile-info">
        <p><b>Name:</b> <?= $agentData['name'] ?></p>
        <p><b>Email:</b> <?= $agentData['email'] ?></p>
        <p><b>Agent Code:</b> <?= $agentData['agent_code'] ?></p>
        <p><b>Phone:</b> <?= $agentData['phone'] ?></p>
        <p><b>Experience:</b> <?= $agentData['experience'] ?> years</p>
        <p><b>Joined:</b> <?= $agentData['created_at'] ?></p>
      </div>
    </div>

    <h3>Edit Profile</h3>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_profile" value="1">
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="<?= $agentData['name'] ?>" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= $agentData['email'] ?>" required>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="<?= $agentData['phone'] ?>" required>
      </div>
      <div class="form-group">
        <label>Experience (years)</label>
        <input type="number" name="experience" value="<?= $agentData['experience'] ?>" required>
      </div>
      <div class="form-group">
        <label>Profile Picture</label>
        <input type="file" name="picture" accept="image/*">
      </div>
      <button class="btn">Update Profile</button>
    </form>
  </div>
</div>
<?php endif; ?>
</body>
</html>

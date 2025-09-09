<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: admin login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <style>
    body { margin:0; font-family: Arial, sans-serif; background:#f4f6f9; }
    .top-header {
      background:#6a1b9a; color:white; padding:15px;
      display:flex; align-items:center; justify-content:space-between;
      font-size:22px; font-weight:bold;
      position:fixed; top:0; left:0; width:100%; z-index:1000;
    }
    .menu-toggle { font-size:24px; cursor:pointer; background:none; border:none; color:white; }
    .container { display:flex; margin-top:60px; }
    .sidebar {
      width:220px; background:#4a148c; color:white;
      display:flex; flex-direction:column; justify-content:space-between;
      position:fixed; top:60px; bottom:0; left:0;
      transition:width 0.3s ease; overflow:hidden;
    }
    .sidebar.collapsed { width:70px; }
    .sidebar-menu { flex:1; overflow-y:auto; }
    .sidebar button {
      background:none; border:none; color:white; text-align:left;
      padding:14px 15px; cursor:pointer; font-size:16px; width:100%;
      display:flex; align-items:center; gap:12px; white-space:nowrap;
    }
    .sidebar button:hover { background:#6a1b9a; padding-left:25px; }
    .sidebar button.active { background:#311b92; font-weight:bold; }
    .sidebar-footer { padding:15px; border-top:1px solid rgba(255,255,255,0.2); }
    .sidebar-footer a {
      color:white; text-decoration:none; display:block;
      padding:10px; background:#6a1b9a; border-radius:6px; text-align:center;
    }
    .sidebar-footer a:hover { background:#51227a; }
    .main-content {
      flex:1; padding:20px; margin-left:220px;
      transition: margin-left 0.3s ease; min-height:100vh;
    }
    .collapsed ~ .main-content { margin-left:70px; }
    .form-box, .welcome-box {
      background:white; padding:20px; border-radius:8px;
      box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-top:20px; max-width:100%;
      animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn { from {opacity:0; transform: translateY(10px);} to {opacity:1; transform: translateY(0);} }
    label { display:block; margin-top:10px; font-weight:bold; }
    input, textarea {
      width:100%; padding:8px; margin-top:5px;
      border:1px solid #ccc; border-radius:5px;
    }
    button.submit-btn {
      margin-top:15px; padding:10px; background:#6a1b9a;
      border:none; color:white; border-radius:5px; cursor:pointer; width:100%;
      transition: background 0.3s;
    }
    button.submit-btn:hover { background:#4a148c; }
    .form-box table {
      width: 100%; border-collapse: collapse; margin-top: 20px;
    }
    .form-box th, .form-box td {
      border: 1px solid #ddd; padding: 12px; text-align: left;
    }
    .form-box th { background-color: #f2f2f2; }
    .status-message {
      padding: 15px; margin-top: 20px; border-radius: 8px; font-weight: bold; display: none;
    }
    .status-message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .status-message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
  </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elitestate";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("❌ Connection failed: " . $conn->connect_error); }

// Messages
$status_message = ''; $status_class = '';
if (isset($_GET['status']) && isset($_GET['message'])) {
  $status_class = $_GET['status'];
  $status_message = htmlspecialchars($_GET['message']);
}
?>

<!-- Header -->
<div class="top-header">
  <span>🏠 Admin Panel</span>
  <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
</div>

<div class="container">
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-menu">
      <button onclick="showSection('welcome', this)">🏡 <span>Dashboard</span></button>
      <button onclick="showSection('property', this)">🏠 <span>Add Property</span></button>
      <button onclick="showSection('propertyreq', this)">📥 <span>Property Requests</span></button>
      <button onclick="showSection('rental-bookings', this)">📋 <span>Rental Bookings</span></button>
      <button onclick="showSection('agent', this)">👤 <span>Add Agent</span></button>
      <a href="admin user.php"><button>🧑‍🤝‍🧑 <span>User Management</span></button></a>
      <button onclick="showSection('feedback', this)">💬 <span>Feedback</span></button>
      <a href="admin notification.php"><button>🔔 <span>Notifications</span></button></a>
    </div>
    <div class="sidebar-footer">
      <a href="home.php">🌐 Go to Website</a>
    </div>
  </div>

  <!-- Main -->
  <div class="main-content">
    <!-- Status Message -->
    <div id="status-message" class="status-message <?php echo $status_class; ?>" 
         style="<?php echo ($status_message ? 'display:block;' : 'display:none;'); ?>">
      <?php echo $status_message; ?>
    </div>

    <!-- Dashboard -->
    <div id="welcome" class="welcome-box">
      <h2>👋 Welcome, Admin!</h2>
      <p>Use the menu on the left to manage properties, agents, feedback, and bookings.</p>
    </div>

    <!-- Add Property -->
    <div id="property" class="form-box" style="display:none;">
      <a href="property_manager.php" class="btn">🏡 Go to Property Manager</a>
        <a href="building.php" class="btn">🏢 Go to Building Manager</a>
    </div>

    <!-- Property Requests -->
    <div id="propertyreq" class="form-box" style="display:none;">
      <h2>📥 Property Requests</h2>
      <table>
        <thead><tr><th>ID</th><th>Owner</th><th>Email</th><th>Title</th><th>Location</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM request ORDER BY id DESC");
          if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['owner_name']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['title']}</td>
                      <td>{$row['location']}</td>
                      <td>".ucfirst($row['approval_status'])."</td>
                      <td>
                        <a href='accept.php?id={$row['id']}' style='color:green;'>Approve</a> | 
                        <a href='reject.php?id={$row['id']}' style='color:red;'>Reject</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='7'>No requests found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Rental Bookings -->
    <div id="rental-bookings" class="form-box" style="display:none;">
      <h2>📋 Rental Booking Requests</h2>
      <table>
        <thead><tr><th>ID</th><th>Property Title</th><th>Full Name</th><th>Email</th><th>Phone</th><th>Move-in Date</th><th>Action</th></tr></thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
          if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>".htmlspecialchars($row['property_title'])."</td>
                      <td>".htmlspecialchars($row['full_name'])."</td>
                      <td>".htmlspecialchars($row['email'])."</td>
                      <td>".htmlspecialchars($row['phone'])."</td>
                      <td>{$row['move_in_date']}</td>
                      <td><a href='delete.php?id={$row['id']}' style='color:red;' onclick=\"return confirm('Delete this booking?');\">Delete</a></td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='7'>No bookings found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

<!-- Add Agent -->
<div id="agent" class="form-box" style="display:none;">
  <h2>👤 Pending Agent Requests</h2>

  <?php
  if(isset($_POST['agent_action']) && isset($_POST['agent_id'])){
      $action = $_POST['agent_action'];
      $agentId = intval($_POST['agent_id']);
      $agentCode = isset($_POST['agent_code']) ? trim($_POST['agent_code']) : '';

      // Fetch request data
      $res = $conn->query("SELECT * FROM agent_requests WHERE id=$agentId AND approval_status='pending'");
      if($res && $res->num_rows > 0){
          $agent = $res->fetch_assoc();

          if($action === 'approve'){
              if(empty($agentCode)){
                  echo "<div class='status-message error'>❌ Please enter a valid Agent Code to approve</div>";
              } else {
                  // Check duplicate agent code
                  $check = $conn->query("SELECT * FROM agents WHERE agent_code='$agentCode'");
                  if($check && $check->num_rows > 0){
                      echo "<div class='status-message error'>❌ This Agent Code already exists. Choose another.</div>";
                  } else {
                      // Insert into agents table
                      $stmt = $conn->prepare("INSERT INTO agents (agent_code, name, email, phone, experience, cnic) VALUES (?, ?, ?, ?, ?, ?)");
                      if(!$stmt){
                          die("Prepare failed: " . $conn->error);
                      }
                      $stmt->bind_param("ssssss", $agentCode, $agent['name'], $agent['email'], $agent['phone'], $agent['experience'], $agent['cnic']);
                      if(!$stmt->execute()){
                          die("Execute failed: " . $stmt->error);
                      }

                      // Update agent_requests table
                      $conn->query("UPDATE agent_requests SET approval_status='approved' WHERE id=$agentId");

                      // Send email to agent
                      $to = $agent['email'];
                      $subject = "Agent Request Approved - EliteState";
                      $agentPanelLink = "https://yourdomain.com/agentpanel.php?agent_code=$agentCode";
                      $message = "
Dear {$agent['name']},

Congratulations! Your agent request has been approved by admin.

Your unique Agent Code is: {$agentCode}

You can access your agent panel using the link below:
$agentPanelLink

Please keep your agent code safe for login.

Regards,
EliteState Admin
                      ";
                      $headers = "From: admin@elitestate.com";
                      @mail($to, $subject, $message, $headers);

                      echo "<div class='status-message success'>✅ Agent approved with code $agentCode. Email sent to {$agent['email']}.</div>";
                  }
              }
          }
          elseif($action === 'reject'){
              $conn->query("UPDATE agent_requests SET approval_status='rejected' WHERE id=$agentId");
              echo "<div class='status-message error'>❌ Agent request rejected</div>";
          }
      }
  }

  // Fetch pending agent requests
$result = $conn->query("SELECT * FROM agent_requests WHERE approval_status='pending' ORDER BY id DESC");
if($result && $result->num_rows > 0){
    echo "<table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>CNIC</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Experience</th>
                <th>Agent Code</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>";
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <form method='POST'> <!-- har row ka apna form -->
                  <td>{$row['id']}</td>
                  <td>".htmlspecialchars($row['name'])."</td>
                  <td>".htmlspecialchars($row['cnic'])."</td>
                  <td>".htmlspecialchars($row['email'])."</td>
                  <td>".htmlspecialchars($row['phone'])."</td>
                  <td>".htmlspecialchars($row['experience'])."</td>
                  <td><input type='text' name='agent_code' placeholder='Enter code' required></td>
                  <td>
                    <input type='hidden' name='agent_id' value='{$row['id']}'>
                    <button type='submit' name='agent_action' value='approve' style='color:green; background:none; border:none; cursor:pointer;'>Approve</button> | 
                    <button type='submit' name='agent_action' value='reject' style='color:red; background:none; border:none; cursor:pointer;'>Reject</button>
                  </td>
                </form>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>No pending agent requests</p>";
}
?>
</div>








    <!-- Feedback -->
    <div id="feedback" class="form-box" style="display:none;">
      <h2>💬 Feedback Settings</h2>
      <form>
        <label><input type="checkbox"> Enable Feedback</label>
        <label><input type="checkbox"> Auto Approve Feedback</label>
        <button type="submit" class="submit-btn">Save Settings</button>
      </form>
    </div>
  </div>
</div>

<script>
  function showSection(id, btn) {
    document.querySelectorAll('.form-box, .welcome-box').forEach(box => box.style.display = "none");
    document.getElementById(id).style.display = "block";
    document.querySelectorAll('.sidebar button').forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
  }
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('collapsed');
  }
</script>
</body>
</html>
<?php $conn->close(); ?>

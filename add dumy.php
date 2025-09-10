<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: admin login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elitestate";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Include PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to auto-generate agent code
function generateAgentCode($conn){
    $result = $conn->query("SELECT agent_code FROM agents ORDER BY agent_id DESC LIMIT 1");
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        $lastCode = $row['agent_code']; // e.g. "AGT005"
        $num = intval(substr($lastCode, 3));
        $newNum = $num + 1;
        return "AGT" . str_pad($newNum, 3, "0", STR_PAD_LEFT);
    } else {
        return "AGT001";
    }
}

$status_message = "";
$status_class = "";

/* ✅ If admin approves */
if(isset($_POST['approve'])){
    $request_id = intval($_POST['request_id']);
    $agent_code = generateAgentCode($conn);

    $result = $conn->query("SELECT * FROM agent_requests WHERE id=$request_id");
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();

        $stmt = $conn->prepare("INSERT INTO agents 
            (name, email, agent_code, phone, cnic, picture, id_file, experience, created_at) 
            VALUES (?,?,?,?,?,?,?,?,NOW())");

        $empty = "";
        $stmt->bind_param("sssssssi", 
            $row['name'], 
            $row['email'], 
            $agent_code, 
            $row['phone'], 
            $row['cnic'], 
            $empty, 
            $empty, 
            $row['experience']
        );

        if($stmt->execute()){
            $status_message = "✅ Agent approved successfully! Agent Code: $agent_code";
            $status_class = "success";

            // Send approval email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'eliteestate130@gmail.com';
                $mail->Password   = 'mgheovhvkxgtemro'; // Gmail app password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('eliteestate130@gmail.com', 'Elite State Admin');
                $mail->addAddress($row['email'], $row['name']);

                $mail->isHTML(true);
                $mail->Subject = "Your Agent Request Approved!";
                $mail->Body = "
                    <div style='font-family:Arial,sans-serif; line-height:1.6; color:#333;'>
                        <h2 style='color:#6a1b9a;'>Congratulations, {$row['name']}!</h2>
                        <p>Your agent request has been <strong style='color:green;'>approved successfully</strong>.</p>
                        
                        <p><strong>Your Agent Code:</strong> 
                           <span style='background:#f4f4f4; padding:5px 10px; border-radius:4px;'>{$agent_code}</span>
                        </p>

                        <p>You can now log in to your agent account:</p>
                        <p>
                            🔗 <a href='http://localhost/desgin/agentpanel.php' 
                                 style='background:#6a1b9a; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;'>
                                 Go to Agent Panel
                            </a>
                        </p>

                        <hr>
                        <p><strong>Your Details:</strong><br>
                        📧 Email: {$row['email']}<br>
                        📞 Phone: {$row['phone']}<br>
                        🆔 CNIC: {$row['cnic']}<br>
                        💼 Experience: {$row['experience']} years</p>

                        <p style='margin-top:20px;'>Welcome to <strong>Elite State</strong> 🎉</p>
                    </div>
                ";

                $mail->send();
            } catch (Exception $e) {
                $status_message .= " (Email could not be sent)";
            }

            // Delete from requests
            $conn->query("DELETE FROM agent_requests WHERE id=$request_id");
        } else {
            $status_message = "❌ Error inserting into agents table.";
            $status_class = "error";
        }
        $stmt->close();
    }
}


if(isset($_POST['reject'])){
    $request_id = intval($_POST['request_id']);

    $result = $conn->query("SELECT * FROM agent_requests WHERE id=$request_id");
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();

        // Insert into rejected_agents
        $stmt = $conn->prepare("INSERT INTO rejected_agents 
            (name, email, phone, cnic, experience, rejected_at) 
            VALUES (?,?,?,?,?,NOW())");
        $stmt->bind_param("ssssi", 
            $row['name'], 
            $row['email'], 
            $row['phone'], 
            $row['cnic'], 
            $row['experience']
        );

        if($stmt->execute()){
            $status_message = "❌ Agent request rejected.";
            $status_class = "error";

            // Send rejection email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'eliteestate130@gmail.com';
                $mail->Password   = 'mgheovhvkxgtemro';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('eliteestate130@gmail.com', 'Elite State Admin');
                $mail->addAddress($row['email'], $row['name']);

                $mail->isHTML(true);
                $mail->Subject = "Your Agent Request Rejected";
                $mail->Body = "
                    <div style='font-family:Arial,sans-serif; line-height:1.6; color:#333;'>
                        <h2 style='color:#b71c1c;'>Sorry, {$row['name']}!</h2>
                        <p>Unfortunately, your agent request has been <strong style='color:red;'>rejected</strong>.</p>
                        <p>If you believe this was a mistake, please contact our support team at 
                           <a href='mailto:eliteestate130@gmail.com'>eliteestate130@gmail.com</a>.</p>
                        <p style='margin-top:20px;'>Thank you for showing interest in <strong>Elite State</strong>.</p>
                    </div>
                ";

                $mail->send();
            } catch (Exception $e) {
                $status_message .= " (Rejection email could not be sent)";
            }

            // Delete from requests
            $conn->query("DELETE FROM agent_requests WHERE id=$request_id");
        }
        $stmt->close();
    }
}
?>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elitestate";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }


if(isset($_POST['assign_request'])){
    $request_id = $_POST['request_id'];
    $agent_id = $_POST['agent_id'];

    $stmt = $conn->prepare("UPDATE request SET assigned_agent_id=? WHERE id=?");
    $stmt->bind_param("ii", $agent_id, $request_id);
    $stmt->execute();

    echo "<div class='success'>Request #$request_id assigned successfully!</div>";
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
      transition: background-color 0.3s;

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
      <button onclick="showSection('property', this)">🏠 <span>Manage Listing</span></button>
      <button onclick="showSection('propertyreq', this)">📥 <span>Property Requests</span></button>
      <button onclick="showSection('rental-bookings', this)">📋 <span>Rental Bookings</span></button>
      <button onclick="showSection('agent', this)">👤 <span>Manage Agents</span></button>
      <a href="admin user.php"><button>🧑‍🤝‍🧑 <span>User Management</span></button></a>
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
   <!-- Dashboard -->
<div id="welcome" class="welcome-box">
  <h2>📊 Admin Dashboard</h2>
  
  <?php
    
    $totalProperties = $conn->query("SELECT COUNT(*) AS total FROM property")->fetch_assoc()['total'] ?? 10;
    $pendingPropertyRequests = $conn->query("SELECT COUNT(*) AS total FROM request WHERE approval_status='pending'")->fetch_assoc()['total'] ?? 2;
    $totalUsers = $conn->query("SELECT COUNT(*) AS total FROM register")->fetch_assoc()['total'] ?? 5;
    $activeAgents = $conn->query("SELECT COUNT(*) AS total FROM agents")->fetch_assoc()['total'] ?? 3;
    $pendingAgentRequests = $conn->query("SELECT COUNT(*) AS total FROM agent_requests")->fetch_assoc()['total'] ?? 2;
    $totalBookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'] ?? 7;
  ?>

  <!-- Summary Cards -->
  <div style="display:flex; flex-wrap:wrap; gap:15px; margin-top:15px;">
    <div style="flex:1; min-width:150px; background:#6a1b9a; color:white; padding:15px; border-radius:8px; text-align:center;">
      <h3>Total Properties</h3>
      <p style="font-size:24px; font-weight:bold;"><?php echo $totalProperties; ?></p>
    </div>
    <div style="flex:1; min-width:150px; background:#ff9800; color:white; padding:15px; border-radius:8px; text-align:center;">
      <h3>Pending Property Requests</h3>
      <p style="font-size:24px; font-weight:bold;"><?php echo $pendingPropertyRequests; ?></p>
    </div>
    <div style="flex:1; min-width:150px; background:#4a148c; color:white; padding:15px; border-radius:8px; text-align:center;">
      <h3>Total Users</h3>
      <p style="font-size:24px; font-weight:bold;"><?php echo $totalUsers; ?></p>
    </div>
    <div style="flex:1; min-width:150px; background:#28a745; color:white; padding:15px; border-radius:8px; text-align:center;">
      <h3>Active Agents</h3>
      <p style="font-size:24px; font-weight:bold;"><?php echo $activeAgents; ?></p>
    </div>
    <div style="flex:1; min-width:150px; background:#f44336; color:white; padding:15px; border-radius:8px; text-align:center;">
      <h3>Pending Agent Requests</h3>
      <p style="font-size:24px; font-weight:bold;"><?php echo $pendingAgentRequests; ?></p>
    </div>
    <div style="flex:1; min-width:150px; background:#2196f3; color:white; padding:15px; border-radius:8px; text-align:center;">
      <h3>Total Bookings</h3>
      <p style="font-size:24px; font-weight:bold;"><?php echo $totalBookings; ?></p>
    </div>
  </div>

  <!-- Recent Activities -->
  <h3 style="margin-top:30px;">Recent Activities</h3>
  <div style="display:flex; flex-wrap:wrap; gap:15px;">
    <!-- Recent Properties -->
    <div style="flex:1; min-width:250px; background:white; padding:15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
      <h4>Recent Properties</h4>
      <table style="border":1px; width="100%" cellpadding="5" style="border-collapse:collapse;">
        <tr><th>Title</th><th>Owner</th><th>Status</th></tr>
        <tr><td>Villa 101</td><td>John Doe</td><td>Available</td></tr>
        <tr><td>Flat 302</td><td>Jane Smith</td><td>Rented</td></tr>
      </table>
    </div>

    <!-- Recent Bookings -->
    <div style="flex:1; min-width:250px; background:white; padding:15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
      <h4>Recent Bookings</h4>
      <table style="border:1px  width:100%; border-collapse:collapse; padding:5px;">

        <tr><th>Property</th><th>User</th><th>Date</th></tr>
        <tr><td>Villa 101</td><td>Ali Khan</td><td>2025-09-08</td></tr>
        <tr><td>Flat 302</td><td>Sara Ahmed</td><td>2025-09-09</td></tr>
      </table>
    </div>

    <!-- Pending Agent Requests -->
    <div style="flex:1; min-width:250px; background:white; padding:15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
      <h4>Pending Agent Requests</h4>
      <?php
        $res = $conn->query("SELECT * FROM agent_requests ORDER BY id DESC LIMIT 5");
        if($res && $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                echo "<div style='border:1px solid #ccc; padding:5px; margin-bottom:5px; border-radius:4px;'>
                        <strong>{$row['name']}</strong> ({$row['email']}) | 📞 {$row['phone']} | CNIC: {$row['cnic']}
                      </div>";
            }
        } else {
            echo "<p>No pending requests.</p>";
        }
      ?>
    </div>
  </div>
</div>


    <!-- Add Property -->
    <div id="property" class="form-box" style="display:none;">
      <a href="property_manager.php" class="btn">🏡 Go to Property Manager</a>
        <a href="building.php" class="btn">🏢 Go to Building Manager</a>
    </div>

    <!-- Property Requests -->
<div id="propertyreq" class="form-box" style="display:block;">
  <h2>📥 Property Requests</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Owner</th>
        <th>Email</th>
        <th>Title</th>
        <th>Location</th>
        <th>Status</th>
        <th>Assign to Agent</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Only show approved requests
      $result = $conn->query("SELECT * FROM request WHERE approval_status = 'pending' ORDER BY id DESC");


      $agents = $conn->query("SELECT agent_id, name FROM agents");

      if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['owner_name']}</td>
                  <td>{$row['email']}</td>
                  <td>{$row['title']}</td>
                  <td>{$row['location']}</td>
                  <td>".ucfirst($row['status'])."</td>
                  <td>";
                  
          if($row['status'] == 'approved') {
            echo "<form method='post' style='display:flex; gap:5px;'>
                    <input type='hidden' name='request_id' value='{$row['id']}'>
                    <select name='agent_id' required>
                      <option value=''>--Select Agent--</option>";
            while($agent = $agents->fetch_assoc()) {
              echo "<option value='{$agent['agent_id']}'>{$agent['name']}</option>";
            }
            echo "</select>
                  <button type='submit' name='assign_request'>Assign</button>
                  </form>";
            $agents->data_seek(0); // reset for next row
          } else {
            echo "-";
          }

          echo "</td>
                  <td>
                    <a href='accept request.php?id={$row['id']}' style='color:green;'>Approve</a> | 
                    <a href='reject.php?id={$row['id']}' style='color:red;'>Reject</a>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='8'>No requests found</td></tr>";
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

<!-- Agent Section -->
<div id="agent" class="form-box" style="display:none;">
  <h2>👤 Pending Agent Requests</h2>

  <?php if($status_message): ?>
    <div class="status-message <?php echo $status_class; ?>" 
         style="margin-bottom:15px; padding:10px; border-radius:6px;">
      <?php echo $status_message; ?>
    </div>
  <?php endif; ?>

  <!-- ✅ Pending Requests -->
  <?php
  $res = $conn->query("SELECT * FROM agent_requests");
  if($res && $res->num_rows > 0){
      while($row = $res->fetch_assoc()){
          echo "<div style='border:1px solid #ccc; padding:10px; margin:10px; border-radius:6px;'>
              <strong>{$row['name']}</strong> ({$row['email']})<br>
              📞 Phone: {$row['phone']} | 💼 Exp: {$row['experience']} yrs | 🆔 CNIC: {$row['cnic']}
              <form method='POST' style='margin-top:10px; display:inline-block;'>
                  <input type='hidden' name='request_id' value='{$row['id']}'>
                  <button type='submit' name='approve' style='background:green; color:white; padding:5px 10px; border:none; border-radius:4px; cursor:pointer;'>Approve</button>
              </form>
              <form method='POST' style='margin-top:10px; display:inline-block;'>
                  <input type='hidden' name='request_id' value='{$row['id']}'>
                  <button type='submit' name='reject' style='background:red; color:white; padding:5px 10px; border:none; border-radius:4px; cursor:pointer;'>Reject</button>
              </form>
          </div>";
      }
  } else {
      echo "<p>No pending requests ✅</p>";
  }
  ?>

  <hr style="margin:20px 0;">

  <!-- ✅ Approved Agents -->
  <h2>✔ Approved Agents</h2>
  <?php
  $resApproved = $conn->query("SELECT * FROM agents ORDER BY created_at DESC");
  if($resApproved && $resApproved->num_rows > 0){
      while($row = $resApproved->fetch_assoc()){
          echo "<div style='border:1px solid #28a745; padding:10px; margin:10px; border-radius:6px; background:#e8f5e9;'>
              <strong>{$row['name']}</strong> ({$row['email']})<br>
              🆔 Agent Code: <b>{$row['agent_code']}</b><br>
              📞 Phone: {$row['phone']} | 🆔 CNIC: {$row['cnic']} | 💼 Exp: {$row['experience']} yrs
          </div>";
      }
  } else {
      echo "<p>No approved agents yet.</p>";
  }
  ?>

  <hr style="margin:20px 0;">

  <!-- ❌ Rejected Agents -->
  <h2>❌ Rejected Agents</h2>
  <?php
  $resRejected = $conn->query("SELECT * FROM rejected_agents ORDER BY rejected_at DESC");
  if($resRejected && $resRejected->num_rows > 0){
      while($row = $resRejected->fetch_assoc()){
          echo "<div style='border:1px solid #dc3545; padding:10px; margin:10px; border-radius:6px; background:#fcebea;'>
              <strong>{$row['name']}</strong> ({$row['email']})<br>
              📞 Phone: {$row['phone']} | 🆔 CNIC: {$row['cnic']} | 💼 Exp: {$row['experience']} yrs
          </div>";
      }
  } else {
      echo "<p>No rejected agents yet.</p>";
  }
  ?>
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


<?php
include 'db.php';

// --- HANDLE ACTIONS (block/unblock/delete) ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == "block") {
        $conn->query("UPDATE register SET status='blocked' WHERE id=$id");
    } elseif ($action == "unblock") {
        $conn->query("UPDATE register SET status='active' WHERE id=$id");
    } elseif ($action == "delete") {
        $conn->query("DELETE FROM register WHERE id=$id");
    }
    header("Location: admin_user.php");
    exit;
}

// --- ADD USER ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO register (name,email,password,created_at,status) VALUES (?,?,?,NOW(),'active')");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

    header("Location: admin_user.php");
    exit;
}

// --- SEARCH & FILTER ---
$where = "1=1"; // default condition
$search = "";
$statusFilter = "";

if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}

if (!empty($_GET['status'])) {
    $statusFilter = $_GET['status'];
    if ($statusFilter == "active" || $statusFilter == "blocked") {
        $where .= " AND status='$statusFilter'";
    }
}

// --- FETCH USERS ---
$result = $conn->query("SELECT * FROM register WHERE $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>User Management</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top:20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align:center; }
    th { background:#f5f5f5; }
    .form-container { margin-top: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; }
    .blocked { color: red; font-weight: bold; }
    .active { color: green; font-weight: bold; }
    .filter-box { margin:20px 0; padding:10px; background:#f5f5f5; border:1px solid #ddd; }
  </style>
</head>
<body>

<h2>👥 User Management</h2>

<!-- SEARCH + FILTER FORM -->
<div class="filter-box">
  <form method="GET">
    <input type="text" name="search" placeholder="Search by name/email" value="<?php echo htmlspecialchars($search); ?>">
    <select name="status">
      <option value="">All</option>
      <option value="active" <?php if($statusFilter=="active") echo "selected"; ?>>Active</option>
      <option value="blocked" <?php if($statusFilter=="blocked") echo "selected"; ?>>Blocked</option>
    </select>
    <button type="submit">🔍 Search</button>
    <a href="admin_user.php">Reset</a>
  </form>
</div>

<!-- USERS TABLE -->
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Password (Hashed)</th>
    <th>Created At</th>
    <th>Status</th>
    <th>Actions</th>
  </tr>
  <?php while($user = $result->fetch_assoc()) { ?>
  <tr>
    <td><?php echo $user['id']; ?></td>
    <td><?php echo htmlspecialchars($user['name']); ?></td>
    <td><?php echo htmlspecialchars($user['email']); ?></td>
    <td><?php echo htmlspecialchars($user['password']); ?></td>
    <td><?php echo $user['created_at']; ?></td>
    <td class="<?php echo $user['status']; ?>">
        <?php echo ucfirst($user['status']); ?>
    </td>
    <td>
      <?php if($user['status'] == 'active') { ?>
        <a href="?action=block&id=<?php echo $user['id']; ?>">🚫 Block</a>
      <?php } else { ?>
        <a href="?action=unblock&id=<?php echo $user['id']; ?>">✅ Unblock</a>
      <?php } ?>
       | <a href="?action=delete&id=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?')">🗑️ Delete</a>
    </td>
  </tr>
  <?php } ?>
</table>

>
<!-- ADD USER FORM -->
<div class="form-container">
  <h3>➕ Add New User</h3>
  <form method="POST" autocomplete="off">
    <input type="hidden" name="add_user" value="1">
    <label>Name: <input type="text" name="name" required autocomplete="off"></label><br><br>
    <label>Email: <input type="email" name="email" required autocomplete="off"></label><br><br>
    <label>Password: <input type="password" name="password" required autocomplete="new-password"></label><br><br>
    <button type="submit">Add User</button>
  </form>
</div>


</body>
</html>

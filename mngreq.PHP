<?php
include "db.php";

// Agar admin ne accept/reject kiya
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']); // SQL injection se bachne ke liye intval
    $action = $_GET['action'];

    if ($action === "accept") {
        $sql = "UPDATE request SET approval_status='accepted' WHERE id=$id";
    } elseif ($action === "reject") {
        $sql = "UPDATE request SET approval_status='rejected' WHERE id=$id";
    }
    mysqli_query($conn, $sql);
}

// Sab requests fetch karo
$result = mysqli_query($conn, "SELECT * FROM request ORDER BY id DESC");
?>

<table>
  <tr>
    <th>ID</th>
    <th>Owner</th>
    <th>Email</th>
    <th>Title</th>
    <th>Type</th>
    <th>Status</th>
    <th>Location</th>
    <th>Image</th>
    <th>Approval</th>
    <th>Action</th>
  </tr>

  <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?= $row['id']; ?></td>
      <td><?= htmlspecialchars($row['owner_name']); ?></td>
      <td><?= htmlspecialchars($row['email']); ?></td>
      <td><?= htmlspecialchars($row['title']); ?></td>
      <td><?= htmlspecialchars($row['type']); ?></td>
      <td><?= htmlspecialchars($row['status']); ?></td>
      <td><?= htmlspecialchars($row['location']); ?></td>
      <td>
        <?php if (!empty($row['image'])) { ?>
          <img src="uploads/<?= htmlspecialchars($row['image']); ?>" width="80">
        <?php } ?>
      </td>
      <td><?= ucfirst($row['approval_status']); ?></td>
      <td>
        <?php if ($row['approval_status'] === 'pending') { ?>
          <a href="?action=accept&id=<?= $row['id']; ?>" class="btn accept">Accept</a>
          <a href="?action=reject&id=<?= $row['id']; ?>" class="btn reject">Reject</a>
        <?php } else { ?>
          <b><?= ucfirst($row['approval_status']); ?></b>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</table>

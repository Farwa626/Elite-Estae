<?php include 'db.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Requests Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #6a1b9a;
            border-bottom: 2px solid #6a1b9a;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        thead {
            background-color: #6a1b9a;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-links a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .action-links a.approve {
            color: green;
        }
        .action-links a.reject {
            color: red;
        }
        .action-links a.view {
            color: blue;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📥 Property Requests</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Location</th>
                <th>Price</th>
                <th>Type</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Phone</th>
                <th>Created</th>
                <th>Approved</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ✅ Fetch all properties (requests) from the database
            $sql = "SELECT * FROM property_requests ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['title']); ?></td>
                        <td><?= htmlspecialchars($row['location']); ?></td>
                        <td><?= number_format($row['price']); ?></td>
                        <td><?= htmlspecialchars($row['type']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['owner']); ?></td>
                        <td><?= htmlspecialchars($row['phone']); ?></td>
                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                        <td><?= $row['approved'] ? "✅ Yes" : "❌ No"; ?></td>
                        <td class="action-links">
                            <a href="approve.php?id=<?= urlencode($row['id']); ?>" class="approve">Approve</a> |
                            <a href="reject.php?id=<?= urlencode($row['id']); ?>" class="reject">Reject</a> |
                            <a href="view.php?id=<?= urlencode($row['id']); ?>" class="view">View</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="11" style="text-align: center;">No property requests found</td>
                </tr>
            <?php
            }
            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
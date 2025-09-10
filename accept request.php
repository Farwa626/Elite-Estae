<?php
session_start();
include "db.php";

// Include PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if request ID is provided
if(!isset($_GET['id'])){
    die("Request ID not provided.");
}

$request_id = intval($_GET['id']);

// Handle Assign + Approve form submission
if(isset($_POST['assign_request'])){
    $agent_id = intval($_POST['agent_id']);

    // 1️⃣ Update request: approve
    $stmt = $conn->prepare("UPDATE request SET approval_status='approved' WHERE id=?");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();

    // 2️⃣ Fetch request data
    $stmt2 = $conn->prepare("SELECT owner_name, email, title, type, status, location, bedrooms, bathrooms, area, image 
                             FROM request WHERE id=?");
    $stmt2->bind_param("i", $request_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $request = $result->fetch_assoc();

    $owner_name = $request['owner_name'];
    $email      = $request['email'];
    $title      = $request['title'];
    $location   = $request['location'];
    $bedrooms   = $request['bedrooms'];
    $bathrooms  = $request['bathrooms'];
    $area       = $request['area'];
    $image      = $request['image'];

    // 3️⃣ Insert property into properties table with agent assignment
    $stmt3 = $conn->prepare("INSERT INTO properties 
        (ownerName, title, location, bedroom, bathroom, size, main_image, status, date_posted, statusfor, assigned_agent_id) 
        VALUES (?,?,?,?,?,?,?,'active',NOW(),'assigned',?)");

    $stmt3->bind_param("sssssssi", 
        $owner_name, $title, $location, $bedrooms, $bathrooms, $area, $image, $agent_id
    );
    $stmt3->execute();

    // ---------------- EMAIL TO OWNER ----------------
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'eliteestate130@gmail.com'; // Your Gmail
        $mail->Password   = 'mgheovhvkxgtemro';         // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('eliteestate130@gmail.com', 'EliteEstate Admin');
        $mail->addAddress($email, $owner_name);

        $mail->isHTML(true);
        $mail->Subject = "Your Property Request Approved";
        $mail->Body    = "
            Hello $owner_name,<br><br>
            Your property request for <b>$title</b> has been approved and assigned to one of our agents.<br>
            Our team will contact you soon.<br><br>
            Thanks,<br>EliteEstate
        ";

        $mail->send();
    } catch (Exception $e) {
        echo "<div style='color:red;'>Owner email not sent. Error: {$mail->ErrorInfo}</div>";
    }

    // ---------------- EMAIL TO AGENT ----------------
    $stmt4 = $conn->prepare("SELECT email, name FROM agents WHERE agent_id=?");
    $stmt4->bind_param("i", $agent_id);
    $stmt4->execute();
    $agentData = $stmt4->get_result()->fetch_assoc();
    $agentEmail = $agentData['email'];
    $agentName  = $agentData['name'];

    $mail2 = new PHPMailer(true);
    try {
        $mail2->isSMTP();
        $mail2->Host       = 'smtp.gmail.com';
        $mail2->SMTPAuth   = true;
        $mail2->Username   = 'eliteestate130@gmail.com';
        $mail2->Password   = 'mgheovhvkxgtemro';
        $mail2->SMTPSecure = 'tls';
        $mail2->Port       = 587;

        $mail2->setFrom('eliteestate130@gmail.com', 'EliteEstate Admin');
        $mail2->addAddress($agentEmail, $agentName);

        $mail2->isHTML(true);
        $mail2->Subject = "New Property Assigned to You";
        $mail2->Body    = "
            Hello $agentName,<br><br>
            A new property request has been assigned to you.<br><br>
            <b>Title:</b> $title <br>
            <b>Location:</b> $location <br>
            <b>Bedrooms:</b> $bedrooms <br>
            <b>Bathrooms:</b> $bathrooms <br>
            <b>Area:</b> $area sqft <br><br>
            Please contact the owner: <b>$owner_name ($email)</b>.<br><br>
            Thanks,<br>EliteEstate
        ";

        $mail2->send();
    } catch (Exception $e) {
        echo "<div style='color:red;'>Agent email not sent. Error: {$mail2->ErrorInfo}</div>";
    }

    echo "<div style='color:green;'>Request approved, property assigned, and emails sent successfully!</div>";

    // Redirect back after 3 seconds
    header("refresh:3;url=add dumy.php");
    exit;
}

// 4️⃣ Fetch request info to display assign form
$stmt3 = $conn->prepare("SELECT * FROM request WHERE id=?");
$stmt3->bind_param("i", $request_id);
$stmt3->execute();
$request_data = $stmt3->get_result()->fetch_assoc();

// 5️⃣ Fetch all agents
$agents = $conn->query("SELECT agent_id, name FROM agents");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve & Assign Request</title>
    <style>
        body { font-family:sans-serif; margin:30px; }
        .form-box { max-width:500px; padding:20px; border:1px solid #ccc; border-radius:8px; }
        select, button { padding:10px; margin-top:10px; width:100%; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Approve & Assign Request #<?= $request_data['id'] ?></h2>
    <p><b>Owner:</b> <?= $request_data['owner_name'] ?></p>
    <p><b>Email:</b> <?= $request_data['email'] ?></p>
    <p><b>Title:</b> <?= $request_data['title'] ?></p>
    <p><b>Location:</b> <?= $request_data['location'] ?></p>

    <form method="post">
        <label>Select Agent to Assign:</label>
        <select name="agent_id" required>
            <option value="">--Select Agent--</option>
            <?php while($agent = $agents->fetch_assoc()): ?>
                <option value="<?= $agent['agent_id'] ?>"><?= $agent['name'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="assign_request">Approve & Assign</button>
    </form>
</div>

</body>
</html>

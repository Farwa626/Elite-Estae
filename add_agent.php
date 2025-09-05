<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmAgent'])) {
    // DB connection
    $conn = new mysqli("localhost", "root", "", "elitestate"); // apni DB config yahan dalna

    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    // Form fields
    $name  = $_POST['agentName'] ?? '';
    $email = $_POST['agentEmail'] ?? '';
    $phone = $_POST['agentPhone'] ?? '';
    $experience = $_POST['agentExperience'] ?? 0;

    // Uploads folder
    $uploadDir = "uploads/";

    // Handle Agent Picture Upload
    $picturePath = "";
    if (!empty($_FILES['agentPicture']['name'])) {
        $picturePath = $uploadDir . time() . "_pic_" . basename($_FILES['agentPicture']['name']);
        move_uploaded_file($_FILES['agentPicture']['tmp_name'], $picturePath);
    }

    // Handle Agent ID Upload
    $idFilePath = "";
    if (!empty($_FILES['agentID']['name'])) {
        $idFilePath = $uploadDir . time() . "_id_" . basename($_FILES['agentID']['name']);
        move_uploaded_file($_FILES['agentID']['tmp_name'], $idFilePath);
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO agents (name, email, phone, picture, id_file, experience) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $email, $phone, $picturePath, $idFilePath, $experience);
    $stmt->execute();

    $newAgentId = $stmt->insert_id;

    // Close DB
    $stmt->close();
    $conn->close();

    // Agent box HTML
    $newAgent = "
    <div class='agent-box'>
        <img src='" . ($picturePath ?: "images/default-agent.png") . "' alt='Agent'>
        <h2>$name</h2>
        <p><strong>ID:</strong> $newAgentId</p>
        <p><strong>Experience:</strong> $experience years</p>
        <p><strong>Phone:</strong> <a href='tel:$phone'>$phone</a></p>
        <p><strong>Email:</strong> <a href='mailto:$email'>$email</a></p>
        <a href='buyer.html' class='hire-btn'>Hire Agent</a>
    </div>
    ";

    // File path
    $filePath = "agent1.php";

    // File content read
   // File content read
$content = file_get_contents($filePath);

// Insert at placeholder instead of every </section>
$content = str_replace("<!-- agent-placeholder -->", $newAgent . "\n<!-- agent-placeholder -->", $content);

// Save file back
file_put_contents($filePath, $content);


    header("Location: agent1.php");
    exit();
}
?>

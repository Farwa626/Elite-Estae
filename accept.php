<?php
include 'db.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Request ko approve karo
    $update = "UPDATE request SET approval_status='approved' WHERE id=$id";
    if ($conn->query($update) === TRUE) {

        // User ka record nikaalo
        $result = $conn->query("SELECT owner_name, email, title FROM request WHERE id=$id");
        if ($result && $row = $result->fetch_assoc()) {
            $ownerName = $row['owner_name'];
            $email     = $row['email'];
            $property  = $row['title'];

            // === PHPMailer se email bhejna ===
            $mail = new PHPMailer(true);
            try {
                // SMTP settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';   // Gmail SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'eliteestate130@gmail.com'; // apna Gmail
                $mail->Password   = 'mgheovhvkxgtemro';   // Gmail app password (normal password nahi chalega)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Sender & recipient
                $mail->setFrom('eliteestate130@gmail.com', 'EliteState Admin');
                $mail->addAddress($email, $ownerName);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = "✅ Your Property Request Approved";
                $mail->Body    = "
                    <p>Hello <b>$ownerName</b>,</p>
                    <p>Your property request for <b>$property</b> has been <span style='color:green;'>APPROVED ✅</span>.</p>
                    <p>Our team will contact you soon with further details.</p>
                    <br>
                    <p>Best Regards,<br>EliteState Team</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Mailer Error: {$mail->ErrorInfo}");
            }
        }
    }

    header("Location: admin_dashboard.php?section=requests");
    exit;
}
?>

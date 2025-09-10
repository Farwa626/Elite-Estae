<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Request ko reject karo
    $update = "UPDATE request SET approval_status='rejected' WHERE id=$id";
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
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'eliteestate@gmail.com';
                $mail->Password   = 'mgheovhvkxgtemro';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('eliteestate@gmail.com', 'EliteState Admin');
                $mail->addAddress($email, $ownerName);

                $mail->isHTML(true);
                $mail->Subject = " Your Property Request Rejected";
                $mail->Body    = "
                    <p>Hello <b>$ownerName</b>,</p>
                    <p>We are sorry to inform you that your property request for <b>$property</b> has been <span style='color:red;'>REJECTED </span>.</p>
                    <p>You can update and re-submit your request if needed.</p>
                    <br>
                    <p>Regards,<br>EliteState Team</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Mailer Error: {$mail->ErrorInfo}");
            }
        }
    }

    header("Location: add dumy.php?section=requests");
    exit;
}
?>

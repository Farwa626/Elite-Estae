<?php
// blocked.php
session_start();
// Optionally destroy session to be safe
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Account Blocked</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { font-family: Arial, sans-serif; background:#fff6f6; margin:0; display:flex; align-items:center; justify-content:center; height:100vh; }
    .box { max-width:600px; padding:24px; border-radius:10px; background:#fff; box-shadow:0 6px 18px rgba(0,0,0,0.06); text-align:center; }
    h1 { color:#c53030; margin-bottom:8px; }
    p { color:#555; }
    a.btn { display:inline-block; margin-top:18px; padding:10px 16px; background:#6a1b9a; color:#fff; border-radius:6px; text-decoration:none; }
  </style>
</head>
<body>
  <div class="box">
    <h1>🚫 آپکا اکاونٹ بلاک ہے</h1>
    <p>آپ کا اکاونٹ Admin نے بلاک کر دیا ہے۔ اگر آپ سمجھتے ہیں کہ یہ غلطی ہے تو براہِ کرم administrator سے رابطہ کریں یا support@yourdomain.com پر ای میل کریں۔</p>
    <a class="btn" href="contact.php">Contact Admin</a>
  </div>
</body>
</html>

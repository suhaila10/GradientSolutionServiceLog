<?php
session_start();

@include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: login1.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $mesej = [];

    // Debugging: output user_id to see if it's correct
    //echo "User ID: $user_id ";

    // Debugging: output the SQL query to see the actual query being executed
    $insert = "INSERT INTO inquiries (user_id, subject, message, answered, created_at) 
               VALUES ('$user_id', '$subject', '$message', 0, CURRENT_TIMESTAMP)";
    //echo "SQL Query: $insert"; 

    if(mysqli_query($conn, $insert)) {
        $mesej[] = "Inquiry submitted successfully!";
        echo '<script>alert("Inquiry submitted successfully!"); window.location.href="userview_enquiry.php";</script>';
    } else {
        $mesej[]= "Error: " . mysqli_error($conn);
    }
}

?>
<?php include 'navbar.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Inquiry</title>
    <link rel="stylesheet" href="enquiry.css">
    <link rel="stylesheet" href="style.css">
    <style>

    body {
        background-color: #eee;
        margin: 0;
        padding: 0;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <form action="" method="post">
        <?php
      if(isset($mesej)){
         foreach($mesej as $msg){
            echo '<div class="message">'.$msg.'</div>';
         }
      } 
      ?>
            <h3>Submit Enquiry</h3>
            <label for="subject">Subject:</label>
            <input type="text" name="subject" required style="color: #333; background-color: #eee;">

            <label for="message">Message:</label>
            <textarea name="message" rows="4" required style="color: #333; background-color: #eee;"></textarea>

            <input type="submit" name="submit" value="Submit Inquiry" class="form-btn">
        </form>
    </div>
</div>

</body>
</html>

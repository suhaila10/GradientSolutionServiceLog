<?php
session_start();

@include 'config.php';
include 'navbar.html';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: login1.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's inquiries
$select = "SELECT * FROM inquiries WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $select);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inquiries</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style for the form container */

body {
    background: #f4f4f4;
}
.container {
    max-width: 800px;
    margin: auto;
    padding: 40px; /* Increase the padding for more space */
    background: #f4f4f4;
}

/* Style for the form */
.form-container {
    padding: 40px; /* Increase the padding for more space */
    border-radius: 8px;
    margin-bottom: 20px;
    background: #fff;
    width: 100%;
}

/* Style for form labels */
label {
    display: block;
    margin-bottom: 16px;
    font-weight: bold;
    font-size: 20px; /* Increase the font size for labels */
}

/* Style for form input fields */
input[type="text"],
textarea {
    width: 100%;
    padding: 12px; /* Increase the padding for input fields */
    margin-bottom: 24px; /* Increase the margin for more spacing between input fields */
    box-sizing: border-box;
    font-size: 16px; /* Increase the font size for input fields */
}

/* Style for form submit button */
input[type="submit"] {
    background: #3498db;
    color: #fff;
    padding: 15px 30px; /* Increase the padding for the submit button */
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px; /* Increase the font size for the submit button */
}

/* ... (other styles remain unchanged) */


/* Style for inquiries container */
.inquiry-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;

}

/* Style for individual inquiries */
.inquiry {
    background: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    flex: 1 1 45%; /* Adjust the width as needed */
}

/* Style for answered inquiries */
.answered {
    background: #d4edda; /* Green background for answered inquiries */
}

/* Style for unanswered inquiries */
.unanswered {
    background: #ffebee; /* Red background for unanswered inquiries */
}

/* Style for admin reply container */
.reply-container {
    margin-top: 20px;
}

/* Style for form button */
.form-btn {
    background: #3498db;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Style for error messages */
.error-msg {
    color: #ff0000;
    margin-bottom: 10px;
}

    </style>

</head>
<body>

<div class="container">
    <div class="inquiry-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $statusClass = ($row['answered'] == 1) ? 'answered' : 'unanswered';
            echo "<div class='inquiry $statusClass'>";
            echo "<p><strong>User ID:</strong> {$row['user_id']}</p>";  // Display user id
            echo "<p><strong>Subject:</strong> {$row['subject']}</p>";
            echo "<p><strong>Message:</strong> {$row['message']}</p>";

            if ($row['answered'] == 1) {
                echo "<p class='answered'><strong>Response:</strong> {$row['response']}</p>";
            }

            echo "<p><strong>Status:</strong> " . ($row['answered'] == 1 ? 'Answered' : 'Unanswered') . "</p>";
            echo "<p><strong>Submitted At:</strong> {$row['created_at']}</p>";

            echo "</div>";
        }
        ?>
    </div>
</div>

</body>
</html>

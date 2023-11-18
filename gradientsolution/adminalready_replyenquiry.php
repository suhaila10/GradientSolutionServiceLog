<?php
session_start();

@include 'config.php';
include 'adminnavbar.html';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('location: login1.php');
    exit();
}

// Fetch answered inquiries
$select = "SELECT * FROM inquiries WHERE answered = 1 ORDER BY created_at DESC";
$result = mysqli_query($conn, $select);
?>

<style>
    /* Add your styles for answered inquiries here */
    .inquiry.answered {
        background: #d4edda; /* Green background for answered inquiries */
    }

    body {
    background: #f4f4f4;
    }
    
    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background: #f4f4f4;
    }

    /* Style for the form */
    .form-container {
        background: #f4f4f4;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        width: 100%;
    }

    /* Style for form labels */
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    /* Style for form input fields */
    input[type="text"],
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        box-sizing: border-box;
    }

    /* Style for form submit button */
    input[type="submit"] {
        background: #3498db;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Style for inquiries container */
    .inquiry-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .inquiry {
    background: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    flex: 0 0 31%; /* Adjust the width as needed for three boxes per row */
    margin-bottom: 20px; /* Add margin between the boxes */
    }

    h2 {
        margin-bottom: 10px;
        margin-left: 20px;
        font-size: 48px;
        text-align: center;
    }
</style>

<h2>ALL OF THIS ENQUIRIES IS ANSWERED</h2>
<div class="inquiry-container">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='inquiry answered'>";
        echo "<p><strong>Username:</strong> <a href='user_details.php?user_id={$row['user_id']}'>{$row['user_id']}</a></p>";
        echo "<p><strong>Subject:</strong> {$row['subject']}</p>";
        echo "<p><strong>Message:</strong> {$row['message']}</p>";
        echo "<p class='answered'><strong>Response:</strong> {$row['response']}</p>";
        echo "<p><strong>Status:</strong> Answered</p>";
        echo "<p><strong>Submitted At:</strong> {$row['created_at']}</p>";
        echo "</div>";
    }
    ?>
</div>

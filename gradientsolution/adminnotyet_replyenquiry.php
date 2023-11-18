<?php
session_start();

@include 'config.php';
include 'adminnavbar.html';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('location: login1.php');
    exit();
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('location: login1.php');
    exit();
}

// Initialize $noResult
$noResult = false;

// Initialize the SQL condition
$searchCondition = '';

// Check if a user_id is provided in the URL
if (isset($_GET['user_id'])) {
    // Escape the user_id to prevent SQL injection
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    // Define the search condition
    $searchCondition = " AND user_id = '$user_id'";
}

// Fetch unanswered inquiries
$select = "SELECT * FROM inquiries WHERE answered = 0" . $searchCondition . " ORDER BY created_at DESC";
$result = mysqli_query($conn, $select);

// Check the number of rows returned
if (mysqli_num_rows($result) === 0) {
    $noResult = true;
}
?>

<style>
    /* Add your styles for unanswered inquiries here */
    .inquiry.unanswered {
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
        padding: 20px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    body {
    background: #f4f4f4;
    }

    .container {
        max-width: 600px;
        margin-right: auto;
        padding: 20px;
        background: #f4f4f4;
    }

    /* Style for the form */
    .form-container {
        background: #f4f4f4;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
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

    /* Style for individual inquiries */
    .inquiry {
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        flex: 1 1 45%; /* Adjust the width as needed */
    }

    h2 {
        margin-bottom: 10px;
        margin-left: 20px;
        font-size: 48px;
        text-align: center;
    }

    .search-container {
    display: flex;
    flex-direction: column; /* Stack the search box and button vertically */
    align-items: center; /* Center horizontally */
    margin: 20px 0; /* Add some margin between the search container and inquiry box */
    }

    /* Style for the search box */
    .search-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    /* Style for the search button */
    .search-container .form-btn {
        width: auto;
        padding: 8px 16px;
        align-items: center;
    }

</style>

<h2>THIS IS ALL UNANSWERED ENQUIRIES!</h2>
<div class="search-container">
    <form action="" method="get">
        <label for="user_id">Search by User ID:</label>
        <input type="text" name="user_id" placeholder="Enter User ID">
        <button type="submit" class="form-btn">Search</button>
    </form>
    <div class="inquiry-container">
    <?php
    if ($noResult) {
        echo "No inquiry record from this user.";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display user details as a link to the user details page
            echo "<div class='inquiry unanswered'>";
            echo "<p><strong>Username:</strong> <a href='user_details.php?user_id={$row['user_id']}'>{$row['user_id']}</a></p>";
            echo "<p><strong>Subject:</strong> {$row['subject']}</p>";
            echo "<p><strong>Message:</strong> {$row['message']}</p>";
            echo "<p><strong>Status:</strong> Unanswered</p>";
            echo "<p><strong>Submitted At:</strong> {$row['created_at']}</p>";
            // Admin reply form
            echo "<div class='reply-container'>";
            echo "<form action='' method='post'>";
            echo "<label for='response'>Response:</label>";
            echo "<textarea name='response' rows='4' required></textarea>";
            echo "<input type='hidden' name='inquiry_id' value='{$row['id']}'>";
            echo "<input type='submit' name='reply' value='Reply' class='form-btn'>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
    }
    ?>
</div>



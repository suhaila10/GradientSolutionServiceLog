<?php
session_start();

@include 'config.php';

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
    $searchCondition = " WHERE user_id = '$user_id'";
}

// Fetch inquiries based on the search condition
$select = "SELECT * FROM inquiries" . $searchCondition . " ORDER BY created_at DESC";
$result = mysqli_query($conn, $select);
?>



<?php include 'adminnavbar.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiries by Clients</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style for the form container */
body {
    background: #f4f4f4;
}
.container {
    max-width: 1600px;
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

/* Style for unanswered inquiries */
.unanswered {
    background: #ffebee; /* Red background for unanswered inquiries */
}

/* Style for answered inquiries */
.answered {
    background: #d4edda; /* Green background for answered inquiries */
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
</head>
<body>
<h2>PLEASE RESPONSE!</h2>

<div class="search-container">
    <form action="" method="get">
        <label for="user_id">Search by Username:</label>
        <input type="text" name="user_id" placeholder="Enter Username">
        <button type="submit" class="form-btn">Search</button>
    </form>
</div>

<div class="container">
  
    <div class="inquiry-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $statusClass = ($row['answered'] == 1) ? 'answered' : 'unanswered';
            echo "<div class='inquiry $statusClass'>";
            echo "<p><strong>Username:</strong> <a href='user_details.php?user_id={$row['user_id']}'>{$row['user_id']}</a></p>";
            echo "<p><strong>Subject:</strong> {$row['subject']}</p>";
            echo "<p><strong>Message:</strong> {$row['message']}</p>";

            if ($row['answered'] == 1) {
                echo "<p class='answered'><strong>Response:</strong> {$row['response']}</p>";
            }

            echo "<p><strong>Status:</strong> " . ($row['answered'] == 1 ? 'Answered' : 'Unanswered') . "</p>";
            echo "<p><strong>Submitted At:</strong> {$row['created_at']}</p>";

            // Admin reply form
            if ($row['answered'] == 0) {
                echo "<div class='reply-container'>";
                echo "<form action='' method='post'>";
                echo "<label for='response'>Response:</label>";
                echo "<textarea name='response' rows='4' required></textarea>";
                echo "<input type='hidden' name='inquiry_id' value='{$row['id']}'>";
                echo "<input type='submit' name='reply' value='Reply' class='form-btn'>";
                echo "</form>";
                echo "</div>";
            }

            echo "</div>";
        }
        ?>
    </div>
</div>

<?php
// Admin reply logic
if (isset($_POST['reply'])) {
    $inquiry_id = $_POST['inquiry_id'];
    $response = mysqli_real_escape_string($conn, $_POST['response']);

    // Update the inquiry with admin response
    $update = "UPDATE inquiries SET response = '$response', answered = 1 WHERE id = $inquiry_id";
    mysqli_query($conn, $update);
}
?>

</body>
</html>

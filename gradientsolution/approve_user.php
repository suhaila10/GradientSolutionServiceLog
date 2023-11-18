<?php
@include 'config.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Update the user's approval status to 1 (approved)
    $updateQuery = "UPDATE user_form SET approval = 1 WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // User approval successful
        header('location: admin_approval.php');
    } else {
        // User approval failed
        echo "Failed to approve the client.";
    }
} else {
    echo "Invalid request";
}
?>

<?php
 @include 'config.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // You can either delete the user's account or set approval status to 2 (rejected)
    // Here, we'll set approval status to 2
    $updateQuery = "UPDATE user_form SET approval = 2 WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // User rejection successful
        header('location: admin_approval.php');
    } else {
        // User rejection failed
        echo "Failed to reject the client.";
    }
} else {
    echo "Invalid request";
}
?>

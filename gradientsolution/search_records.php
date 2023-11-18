<?php
// Assuming you have a database connection in config.php

include 'config.php';

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($conn, $_POST['query']);

    // Query to fetch search results (adjust this based on your database structure)
    $sql = "SELECT * FROM inquiries WHERE subject LIKE '%$query%' OR message LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="result">';
            echo '<p><strong>User ID:</strong> ' . $row['user_id'] . '</p>';
            // Display other fields as needed
            echo '</div>';
        }
    }
}
?>

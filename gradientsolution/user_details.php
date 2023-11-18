<?php
@include 'config.php';
include 'adminnavbar.html';

// Check if a user ID is provided in the URL
if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    // Query to fetch user details based on the user ID
    $selectUser = "SELECT * FROM user_form WHERE user_id = '$user_id'";
    $resultUser = mysqli_query($conn, $selectUser);

    if (mysqli_num_rows($resultUser) === 1) {
        $userDetails = mysqli_fetch_assoc($resultUser);
        
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE, edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Details</title>


   <style>
      /* Add your custom CSS styles for the table here */
      body {
         font-family: Arial, sans-serif;
      }

      header {
         background-color: #007ACC;
         color: #fff;
         padding: 10px;
         text-align: center;
      }

      main {
         margin: 20px;
      }

      .user-details {
         display: flex;
         flex-direction: column;
         align-items: center;
         background-color: :#eee;
         }
         
      h2{
         margin-bottom: 10px;
         margin-left: 20px;
         font-size: 48px;
         color: #333;
         text-align: center;
      }
      table {
         border-collapse: collapse;
         width: 90%;
         margin-top: 20px;
         margin: 20px;
      }

      table, th, td {
         border: 1px solid #ddd;
      }

      th, td {
         padding: 12px;
         text-align: left;
      }

      th {
         background-color: black;
         color: #fff;
      }
      .back-button {
         display: block;
         text-align: center;
         margin-top: 20px;
      }
      
      .back-button a {
         background-color: #007ACC;
         color: #fff;
         text-decoration: none;
         padding: 10px 20px;
         border-radius: 5px;
      }
   </style>
</head>
<body>

<main>
    <div class="user-details">
        <h2>User Details</h2>
        <?php
        if (isset($userDetails)) {
            echo "<table>";
            echo "<tr><th>Username</th><th>Name</th><th>Email</th></tr>";
            echo "<tr>";
            echo "<td>{$userDetails['user_id']}</td>";
            echo "<td>{$userDetails['name']}</td>";
            echo "<td>{$userDetails['email']}</td>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "User not found.";
        }
        ?>
    </div>
    <div class="back-button">
        <a href="adminreply_enquiry.php">Back to Enquiry Page</a>
    </div>
</main>
</body>
</html>

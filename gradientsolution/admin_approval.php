<?php
@include 'config.php';
include 'adminnavbar.html';
session_start();

// Check if the user is logged in as an admin
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'admin') {
    // Query to get users with approval status set to 0
    $query = "SELECT * FROM user_form WHERE approval = 0";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = 'Error fetching users: ' . mysqli_error($conn);
    }
} else {
    header('location: login1.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="approval.css">

    <style>
      .center-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .navbar-header {
            color: #fff; /* Set the font color to white */
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
      h2 {
         margin-bottom: 10px;
         margin-left: 20px;
         font-size: 48px;
         color: #333;
         text-align: center;
      }
      p {
        text-align: center;
        font-size: 20px;
      }
      </style>
</head>
<body>
<div class="admin-approval-container">
        <h2>Client's Account Approval Page</h2>
        <?php if (isset($error)): ?>
            <p class="error-msg"><?php echo $error; ?></p>
        <?php else: ?>
            <?php if (!empty($users)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Accept</th>
                            <th>Reject</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['user_id']; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><a href="approve_user.php?user_id=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to approve this customer?')">Approve</a></td>
                                <td><a href="reject_user.php?user_id=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to reject this account?')">Reject</a></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No client pending approval.</p>
            <?php endif; ?>
        <?php endif; ?>
        <div class="back-button">
        <a href="admin_dashboard.php">
            <button class="form-btn" style="background-color: transparent;">Back to Dashboard</button>
        </a>
    </div>
    </div>
</body>
</html>

<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login1.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>User Dashboard</title>
    <style>
         body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 20px;
            text-align: center;
        }
        main {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }

        .card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            margin: 10px;
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .dashboard-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dashboard-button:hover {
            background-color: #2980b9;
        }

        .center-card {
            margin: 0 auto;
            display: block;
        }


    </style>
</head>

<body>

<header>
    <h1><img src="images/logo.png" alt="" width="62.5" height="41.63" margin-top="40px">GRADIENT SOLUTION SERVICE LOG</h1>
</header>


<nav>
    <a class="active" href="userdashboard.php">Home</a>
    <a href="display_records.php" target="_top">Records</a>
    <a href="usersubmit_enquiry.php">Submit Enquiry</a>
    <a href="userview_enquiry.php">View Enquiry</a>
    <a href="logout.php">Logout <span class="glyphicon glyphicon-log-out"></span></a>
</nav>

<section>
    <div class="center-card card">
        <h2 style="text-align: center; font-size: 28px; width=100%;">Welcome, <?php echo $_SESSION['user_id']; ?></h2>
    </div>
</section>



<main>
    <div class="card">
        <h2>View Records</h2>
        <p>Click here to view records</p>
        <button onclick="window.location.href='display_records.php'" class="dashboard-button">View</button>
    </div>

    <div class="card" class="dashboard-button">
        <h2>Submit Enquiries</h2>
        <p>Click here to submit enquiries</p>
        <button onclick="window.location.href='usersubmit_enquiry.php'" class="dashboard-button">Submit</button>
    </div>

    <div class="card">
        <h2>View Enquiries</h2>
        <p>Check all enquiries</p>
        <button onclick="window.location.href='userview_enquiry.php'" class="dashboard-button">Check</button>
    </div>

    <div class="card">
        <h2>User Manual</h2>
        <p>Check user manual</p>
        <button onclick="window.location.href='um/clientusermanual.pdf'" class="dashboard-button">Show</button>

    </div>
</main>

<footer>
    &copy; 2023 GRADIENT SOLUTION SERVICE LOG
</footer>

</body>
</html>


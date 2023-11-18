<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('location: login1.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Dashboard</title>
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

        footer {
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h1>Gradient Solution Service Log</h1>
</header>

<main>
    <div class="card" id="addCard">
        <h2>Add New Records</h2>
        <p>Click here to add new records</p>
        <button onclick="window.location.href='acservices.php'">Add</button>
    </div>

    <div class="card" id="displayCard">
        <h2>Display Records</h2>
        <p>View service records here</p>
        <button onclick="window.location.href='admindisplay_records.php'">Display</button>
    </div>

    <div class="card" id="unansweredCard">
        <h2>Check Enquiries</h2>
        <p>Check all enquiries</p>
        <button onclick="window.location.href='adminreply_enquiry.php'">Check</button>
    </div>

    <div class="card" id="totalUsersCard">
        <h2>Account Approval</h2>
        <p>View request accounts</p>
        <button onclick="window.location.href='admin_approval.php'">View</button>
    </div>

    <div class="card" id="totalUsersCard">
        <h2>User Manual PDF</h2>
        <p>View user manual in PDF</p>
        <button onclick="window.location.href='teamusermanual.pdf'">Show</button>

    </div>
</main>

<footer>
    <p>&copy; 2023 Team Dashboard</p>
</footer>

</body>
</html>

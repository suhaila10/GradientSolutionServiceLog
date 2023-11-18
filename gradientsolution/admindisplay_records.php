<?php
session_start();
include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
   header('location: login1.php');
   exit();
}

// Initialize $noResult
$noResult = false;

if (isset($_GET['searchType'])) {
   $searchType = mysqli_real_escape_string($conn, $_GET['searchType']);
   
   if ($searchType === 'date') {
       $searchValue = mysqli_real_escape_string($conn, $_GET['search']);
       // You need to format the date correctly for the SQL query
       $formattedDate = date('Y-m-d', strtotime($searchValue));
       $query = "SELECT * FROM services WHERE date = '$formattedDate'";
   } elseif ($searchType === 'user_id') {
       $searchValue = mysqli_real_escape_string($conn, $_GET['usernameSearch']);
       $query = "SELECT * FROM services WHERE user_id = '$searchValue'";
   } else {
       $query = "SELECT * FROM services";
   }
} else {
   // If no search parameter, fetch all records
   $query = "SELECT * FROM services";
}

$result = mysqli_query($conn, $query);

// Check if there are records
if ($result) {
   $records = mysqli_fetch_all($result, MYSQLI_ASSOC);

   // Check if no records are found
   $noResult = empty($records) && isset($_GET['search']);
} else {
   $error = 'Error fetching records: ' . mysqli_error($conn);
}
?>


<?php include 'adminnavbar.html'; ?>

<div class="records-container">
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Display Records - Admin</title>
   <link rel="stylesheet" href="style.css">
   <!-- Include jQuery and jQuery UI Datepicker -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(function () {
            // Attach the date picker to the date input field
            $("#datepicker").datepicker();
        });
    </script>
   

   <!-- Custom CSS -->
   <style>
    
      

      h2, h3 {
         text-align: center;
         margin-bottom: 10px;
         margin-left: 20px;
         font-size: 48px;
         color: #333;
         text-align: center;
      
      }


      .table-container {
         max-height: 800px;
         overflow-y: 100%;
         width: 100%;
      }

      table {
         border-collapse: collapse;
         width: 100%;
      }

      th, td {
         border: 1px solid #ddd;
         padding: 12px;
         text-align: left;
      }

      th {
         background-color: black;
         color: #fff;
         position: sticky;
         top: 0;
      }
      .delete-link {
      color: #fff;
      background-color: #e74c3c; /* Red color */
      padding: 8px 12px;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
      }

      .delete-link:hover {
         background-color: #c0392b; /* Darker red color on hover */
      }

      .update-link {
         color: #fff;
         background-color: #008000; /* Red color */
         padding: 8px 12px;
         text-decoration: none;
         border-radius: 4px;
         transition: background-color 0.3s ease;
      }

      .update-link:hover {
         background-color: #466D1D; /* Darker red color on hover */
      } 

      .records-container {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 20px;
      width: 100%; /* Set the width to 100% */
      overflow-x: auto; /* Enable horizontal scrolling if needed */
      box-sizing: border-box; /* Include padding in the width calculation */
      }  

      .search-container {
         width: 80%; /* Set the width to 80% (adjust as needed) */
         margin-top: 10px;
      }
   </style> 
</head>
<body>

<div class="records-container">
   <h2>All Records</h2>

   <!-- Search Bar for Date -->
   <div class="search-container">
         <form action="" method="get">
            <!-- Date search input with date picker -->
            <input type="text" id="datepicker" name="search" class="search-box" placeholder="Search by Date">
            <!-- User ID search input -->
            <input type="text" name="usernameSearch" class="search-box" placeholder="Search by Username">
            <select name="searchType" class="search-type">
               <option value="date">Search by Date</option>
               <option value="user_id">Search by Username</option>
            </select>
            <button type="submit" class="search-btn">Search</button>
         </form>
      </div>

<div class="table-container">
   <?php if ($noResult): ?>
        <p>No result found for the selected date.</p>
    <?php elseif (isset($error)): ?>
        <p class="error-msg"><?php echo $error; ?></p>
    <?php else: ?>
        <table>
        <thead>
            <tr>
              <th>Date</th>
               <th>Username</th>
               <th>Indoor Location</th>
               <th>No Unit (Indoor)</th>
               <th>Model (Indoor)</th>
               <th>Outdoor Location</th>
               <th>No System (Outdoor)</th>
               <th>Model (Outdoor)</th>
               <th>AMP (Outdoor)</th>
               <th>Volt (Outdoor)</th>
               <th>PSI</th>
               <th>Work Description</th>
               <th>Notes</th>
               <th>Image</th>
               <th>Update</th>
               <th>Delete</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($records as $record): ?>
               <tr>
                  <td><?php echo isset($record['date']) ? $record['date'] : ''; ?></td>
                  <td><?php echo isset($record['user_id']) ? $record['user_id'] : ''; ?></td>
                  <td><?php echo isset($record['ilocation']) ? $record['ilocation'] : ''; ?></td>
                  <td><?php echo isset($record['ino_unit']) ? $record['ino_unit'] : ''; ?></td>
                  <td><?php echo isset($record['imodel']) ? $record['imodel'] : ''; ?></td>
                  <td><?php echo isset($record['olocation']) ? $record['olocation'] : ''; ?></td>
                  <td><?php echo isset($record['ono_system']) ? $record['ono_system'] : ''; ?></td>
                  <td><?php echo isset($record['omodel']) ? $record['omodel'] : ''; ?></td>
                  <td><?php echo isset($record['oamp']) ? $record['oamp'] : ''; ?></td>
                  <td><?php echo isset($record['ovolt']) ? $record['ovolt'] : ''; ?></td>
                  <td><?php echo isset($record['oetc']) ? $record['oetc'] : ''; ?></td>
                  <td><?php echo isset($record['work_desc']) ? $record['work_desc'] : ''; ?></td>
                  <td><?php echo isset($record['notes']) ? $record['notes'] : ''; ?></td>
                  <td>
                     <?php if (isset($record['image'])): ?>
                     <img src="uploaded_img/<?php echo $record['image']; ?>" alt="Image" style='max-width: 200px; max-height: 200px;'>
                     <?php endif; ?>
                  </td>
                  <td><a class="update-link" href="update.php?id=<?php echo $record['id']; ?>" onclick="return confirm('Are you sure you want to update/edit this record?')">Edit</a></td>
                  <td><a class="delete-link" href="delete_records.php?id=<?php echo $record['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a></td>

               </tr>
            <?php endforeach; ?>
         </tbody>
        </table>
                     </div>
    <?php endif; ?>

   
</div>
</div>

</body>
</html>

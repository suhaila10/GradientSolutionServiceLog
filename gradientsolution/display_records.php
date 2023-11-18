<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login1.php');
    exit();
}

// Handle the search
if (isset($_GET['search'])) {
    $search_date = mysqli_real_escape_string($conn, $_GET['search']);

    $query = "SELECT * FROM services WHERE user_id = '$_SESSION[user_id]' AND date = '$search_date'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = 'Error fetching records: ' . mysqli_error($conn);
    }
} else {
    // Fetch all records if no search is performed
    $query = "SELECT * FROM services WHERE user_id = '$_SESSION[user_id]'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = 'Error fetching records: ' . mysqli_error($conn);
    }
}
?>
<?php include 'navbar.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="back_btn.css">
   <title>Display Records</title>

   <!-- Custom CSS -->
   <style>
      
         .records-container {
         display: flex;
         flex-direction: column;
         align-items: center;
         background-color: :#eee;
         }
         
      h2, h3, p {
         margin-bottom: 10px;
         margin-left: 20px;
         font-size: 24px;
         color: #333;
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

      .view-more {
         color: #3498db;
         cursor: pointer;
      }

      
      /* Style for the search bar */
      .search-container {
         margin-bottom: 20px;
         margin-left: 20px;
      }

      .search-box {
         padding: 10px;
         font-size: 16px;
         border: 1px solid #ccc;
         border-radius: 4px;
      }

      .search-btn {
         padding: 10px;
         font-size: 16px;
         cursor: pointer;
      }

      .no-records-msg {
         font-size: 18px;
         color: #333;
         margin-top: 10px;
      }
   </style>
</head>
<body>


<div class="records-container">
   <h2>Records for username: <?php echo $_SESSION['user_id']; ?></h2>

   <!-- Search Bar -->
   <div class="search-container">
      <form action="" method="get">
         <input type="date" name="search" class="search-box" placeholder="Search by Date">
         <button type="submit" class="search-btn">Search</button>
      </form>
   </div>

   <?php if (isset($error)): ?>
      <p class="error-msg"><?php echo $error; ?></p>
   <?php else: ?>
      <?php if (count($records) > 0): ?>
         <table>
            <thead>
               <tr>
                  <th>Date</th>
                  <th>Work Description</th>
                  <th>Notes</th>
                  <th>Image</th>
                  <th>View More</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($records as $record): ?>
                  <tr>
                     <td><?php echo isset($record['date']) ? $record['date'] : ''; ?></td>
                     <td><?php echo isset($record['work_desc']) ? $record['work_desc'] : ''; ?></td>
                     <td><?php echo isset($record['notes']) ? $record['notes'] : ''; ?></td>
                     <td>
                        <?php
                           $imagePath = 'uploaded_img/' . $record['image'];
                           echo isset($record['image']) ? "<img src='$imagePath' alt='Image' style='max-width: 200px; max-height: 200px;'>" : '';
                        ?>
                     </td>
                     <td><a href="viewmore.php?record_id=<?php echo $record['id']; ?>">View More</a></td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      <?php else: ?>
         <p class="no-records-msg">There are no records found.</p>
         <a href="display_records.php"<button class="button12" style="vertical-align:middle"><span>Back </span></buttoncenter> </a>
      <?php endif; ?>
   <?php endif; ?>

</div>

</body>
</html>

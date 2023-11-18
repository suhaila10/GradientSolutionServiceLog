<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login1.php');
    exit();
}

// Check if the record ID is provided in the URL
if (isset($_GET['record_id'])) {
    $record_id = mysqli_real_escape_string($conn, $_GET['record_id']);

    // Fetch the specific record
    $query = "SELECT * FROM services WHERE id = '$record_id' AND user_id = '$_SESSION[user_id]'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
    } else {
        $error = 'Error fetching record details: ' . mysqli_error($conn);
    }
} else {
    // Redirect if record ID is not provided
    header('Location: display_records.php');
    exit();
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
   <title>View More</title>

   <!-- Custom CSS -->
   <style>
      
      .records-container {
         display: flex;
         flex-direction: column;
         align-items: center;
      }

      h2, h3 {
         margin-bottom: 10px;
         margin-left: 20px;
         font-size: 24px;
         color: #333;
      }
      table {
         border-collapse: collapse;
         width: 95%;
         margin-top: 10px;
         margin-left: 20px;
         margin-bottom: 50px;
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

      /* Add Print Styles */
      @media print {
         body * {
            visibility: hidden;
         }
         .records-container, .records-container * {
            visibility: visible;
         }
      }

      /* Add Print Button Styles */
      .print-button {
         background-color: #04BADE;
         color: white;
         padding: 10px 15px;
         cursor: pointer;
         border: none;
         border-radius: 4px;
         align-items: center;
         margin-bottom: 5px;
      }


   </style>
</head>
<body>


<div class="records-container">
   <h2>Record Details</h2>

   <?php if (isset($error)): ?>
      <p class="error-msg"><?php echo $error; ?></p>
   <?php else: ?>
      <!-- Display Date, Work Description, Notes, and Image in a table -->
      <table>
         <thead>
            <tr>
               <th>Date</th>
               <th>Work Description</th>
               <th>Notes</th>
               <th>Image</th>
            </tr>
         </thead>
         <tbody>
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
            </tr>
         </tbody>
      </table>

      <!-- Display Indoor Details in a table -->
      <h3>Indoor</h3>
      <table>
         <thead>
            <tr>
               <th>Location</th>
               <th>No Unit</th>
               <th>Model</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td><?php echo isset($record['ilocation']) ? $record['ilocation'] : ''; ?></td>
               <td><?php echo isset($record['ino_unit']) ? $record['ino_unit'] : ''; ?></td>
               <td><?php echo isset($record['imodel']) ? $record['imodel'] : ''; ?></td>
            </tr>
         </tbody>
      </table>

      <!-- Display Outdoor Details in a table -->
      <h3>Outdoor</h3>
      <table>
         <thead>
            <tr>
               <th>Location</th>
               <th>No System</th>
               <th>Model</th>
               <th>AMP</th>
               <th>Volt</th>
               <th>PSI</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td><?php echo isset($record['olocation']) ? $record['olocation'] : ''; ?></td>
               <td><?php echo isset($record['ono_system']) ? $record['ono_system'] : ''; ?></td>
               <td><?php echo isset($record['omodel']) ? $record['omodel'] : ''; ?></td>
               <td><?php echo isset($record['oamp']) ? $record['oamp'] : ''; ?></td>
               <td><?php echo isset($record['ovolt']) ? $record['ovolt'] : ''; ?></td>
               <td><?php echo isset($record['oetc']) ? $record['oetc'] : ''; ?></td>
            </tr>
         </tbody>
      </table>
   <?php endif; ?>

   <!-- Add Print Button -->
   <button class="print-button" onclick="printRecord()">Print Record</button>

   <script>
      function printRecord() {
         window.print();
      }
   </script>

</div>

</body>
</html>

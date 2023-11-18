<?php
session_start();

include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('location: login1.php');
    exit();
}

if (isset($_POST['submit'])) {
    $message = []; // Initialize an array to store messages

    // AC Unit Indoor
    if (isset($_POST['submit'])) {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $ilocation = mysqli_real_escape_string($conn, $_POST['ilocation']);
        $ino_unit = mysqli_real_escape_string($conn, $_POST['ino_unit']);
        $imodel = mysqli_real_escape_string($conn, $_POST['imodel']);
        $olocation = mysqli_real_escape_string($conn, $_POST['olocation']);
        $ono_system = mysqli_real_escape_string($conn, $_POST['ono_system']);
        $omodel = mysqli_real_escape_string($conn, $_POST['omodel']);
        $oamp = mysqli_real_escape_string($conn, $_POST['oamp']);
        $ovolt = mysqli_real_escape_string($conn, $_POST['ovolt']);
        $oetc = mysqli_real_escape_string($conn, $_POST['oetc']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $work_desc = mysqli_real_escape_string($conn, $_POST['work_desc']);
        $note = isset($_POST['note']) ? mysqli_real_escape_string($conn, $_POST['note']) : ''; // Check if 'note' is set
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' . $image;

        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO `services` (user_id, ilocation, ino_unit, imodel, olocation, ono_system, omodel, oamp, ovolt, oetc, date, work_desc, notes, image) 
            VALUES ('$user_id','$ilocation', '$ino_unit', '$imodel','$olocation', '$ono_system', '$omodel', '$oamp', '$ovolt', '$oetc','$date', '$work_desc', '$note', '$image')") or die('Query failed: ' . mysqli_error($conn));

            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Record added successfully';
            } else {
                $message[] = 'Record failed - ' . mysqli_error($conn);
            }
        }
    }
}
?>

<?php include 'adminnavbar.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Record Service</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
   <?php
      if(isset($message)){
         foreach($message as $msg){
            echo '<div class="message">'.$msg.'</div>';
         }
      } 
      ?>

      <!-- Customer's user id -->
      <h3>Client's username</h3>
      <input type="text" name="user_id" placeholder="enter client's username" class="box" required>

      <!-- Indoor Section -->
      <h3>Indoor</h3>
      <input type="text" name="ilocation" placeholder="enter location" class="box" required>
      <input type="text" name="ino_unit" placeholder="enter no unit" class="box" required>
      <input type="text" name="imodel" placeholder="enter model" class="box" required>

      <!-- Outdoor Section -->
      <h3>Outdoor</h3>
      <input type="text" name="olocation" placeholder="enter location" class="box" required>
      <input type="text" name="ono_system" placeholder="enter no system" class="box" required>
      <input type="text" name="omodel" placeholder="enter model" class="box" required>
      <input type="text" name="oamp" placeholder="enter amp" class="box" required>
      <input type="text" name="ovolt" placeholder="enter volt" class="box" required>
      <input type="text" name="oetc" placeholder="refrigerant pressure(psi)" class="box" required>

      <!-- Maintenance Record Section -->
      <h3>Record Maintenance</h3>
      <input type="date" name="date" placeholder="enter date" class="box" required>
      <input type="text" name="work_desc" placeholder="work description" class="box" required>
      <input type="text" name="note" placeholder="enter notes" class="box" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">

      <!-- Submit Button -->
      <input type="submit" name="submit" value="Submit All Forms" class="btn">
   </form>
</div>

</body>
</html>
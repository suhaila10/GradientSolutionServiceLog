<?php
include 'config.php';

if (isset($_GET['id'])) {
    $record_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the specific record
    $query = "SELECT * FROM services WHERE id = '$record_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
    } else {
        $error = 'Error fetching record details: ' . mysqli_error($conn);
    }
} else {
    // Redirect if record ID is not provided
    header('Location: admindisplayrecords.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission for updating the record
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
    $note = isset($_POST['note']) ? mysqli_real_escape_string($conn, $_POST['note']) : '';

    // Handle image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' . $image;

        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
    } else {
        // If no new image is provided, keep the existing image
        $image = $record['image'];
    }

    $updateQuery = "UPDATE services SET
         user_id='$user_id',
        ilocation='$ilocation',
        ino_unit='$ino_unit',
        imodel='$imodel',
        olocation='$olocation',
        ono_system='$ono_system',
        omodel='$omodel',
        oamp='$oamp',
        ovolt='$ovolt',
        oetc='$oetc',
        date='$date',
        work_desc='$work_desc',
        notes='$note',
        image='$image'
        WHERE id='$record_id'";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $successMessage = 'Record updated successfully';
        echo '<script>alert("Record updated successfully");</script>';
        echo '<script>window.location.href = "admindisplay_records.php";</script>';
    } else {
        $errorMessage = 'Record update failed: ' . mysqli_error($conn);
        echo '<script>alert("Record cannot be added");</script>';
        echo '<script>window.location.href = "admindisplay_records.php";</script>';
    }
}
?>

<?php include 'adminnavbar.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="style.css">
    <style>
        <!-- Additional styles for better presentation -->

        .update-form-container {
            width: 60%;
            padding: 20px;
        }

        .update-form-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .update-form-container .update-form {
            display: flex;
            flex-direction: column;
        }

        .update-form-container .update-form label {
            margin-bottom: 10px;
            color: #333;
        }

        .update-form-container .update-form input {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .update-form-container .update-form textarea {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .update-form-container .update-form button {
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .update-form-container .update-form button:hover {
            background-color: #2980b9;
        }

        .error-msg {
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .success-msg {
            color: #27ae60;
            margin-bottom: 10px;
        }
        h2{
         margin-bottom: 10px;
         margin-left: 20px;
         font-size: 48px;
         color: #333;
         text-align: center;
      }
    </style>
</head>
<body>

<div class="form-container">
<div class="update-form-container">
    <h2>Update Record</h2>

    <?php if (isset($errorMessage)): ?>
        <p class="error-msg"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <?php if (isset($successMessage)): ?>
        <p class="success-msg"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <?php if (isset($record)): ?>
        <form action="" method="post" enctype="multipart/form-data" class="update-form">
            <label for="user_id">Client's Username:</label>
            <input type="text" name="user_id" value="<?php echo $record['user_id']; ?>" required>

            <!-- Indoor Section -->
            <h3>Indoor</h3>
            <label class="label">Location:</label>
            <input type="ilocation" name="ilocation" value="<?php echo $record['ilocation']; ?>" required>
            <label class="label" for="ino_unit">Indoor No. Unit:</label>
            <input type="ino_unit" name="ino_unit" value="<?php echo $record['ino_unit']; ?>" required>
            <label class="label" for="imodel">Indoor AC Model:</label>
            <input type="text" name="imodel" value="<?php echo $record['imodel']; ?>" required>
           
            <!-- Outdoor Section -->
            <h3>Outdoor</h3>
            <label class="label">Location:</label>
            <input type="olocation" name="olocation" value="<?php echo $record['olocation']; ?>" required>
            <label class="label">Outdoor No. Unit:</label>
            <input type="ono_system" name="ono_system" value="<?php echo $record['ono_system']; ?>" required>
            <label class="label" for="omodel">Outdoor AC Model:</label>
            <input type="text" name="omodel" value="<?php echo $record['omodel']; ?>" required>
            <label class="label" for="oamp">Outdoor AMP:</label>
            <input type="text" name="oamp" value="<?php echo $record['oamp']; ?>">
            <label class="label" for="ovolt">Outdoor VOLT:</label>
            <input type="text" name="ovolt" value="<?php echo $record['ovolt']; ?>">
            <label class="label" for="oetc">PSI:</label>
            <input type="text" name="oetc" value="<?php echo $record['oetc']; ?>">

            <!-- Add other fields... -->
            <!-- Maintenance Record Section -->
            <h3>Record Maintenance</h3>
            <label for="date">Date:</label>
            <input type="date" name="date" value="<?php echo $record['date']; ?>" required>
            <label for="work_desc">Work Description:</label>
            <input type="text" name="work_desc" value="<?php echo $record['work_desc']; ?>" required>
            <label for="note">Notes:</label>
            <input type="text" name="note" value="<?php echo $record['notes']; ?>">
            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">

            <button type="submit">Update Record</button>
        </form>
    <?php endif; ?>
</div>
    </div>

</body>
</html>
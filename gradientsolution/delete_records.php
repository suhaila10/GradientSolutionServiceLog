<html>
<head>
<title>Delete Service Record</title>
<link rel="stylesheet" href="stye2.css">
<style>
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
<?php
//call file to connect server gradient solution
include ("config.php");
?>

<div class="container">
<h2>Delete Service Record</h2>

<?php
//look for a valid user id, either through GET or POST
if ((isset ($_GET['id']))&& (is_numeric($_GET['id'])))
{
	$id = $_GET['id'];
}
else if ((isset ($_POST['id']))&& (is_numeric($_POST['id'])))
{
	$id = $_POST['id'];
}
else
{
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		if ($_POST['sure']=='Yes') //Delete the record
		{
			//make the query
			$q = "DELETE FROM services WHERE id = $id LIMIT 1";
			$result = @mysqli_query ($conn, $q); //run the query
			
			if (mysqli_affected_rows($conn) == 1) //if there was a problem
			//display message
			{
				echo '<script>alert("The record has been deleted");
				window.location.href="admindisplay_records.php";</script>';
			}
			else
			{
				//display error message
				echo '<p class="error">The record could not be deleted.<br>
				Probably because it does not exist or due to system error.</p>';
				
				echo '<p>'.mysqli_error($conn).'<br> Query:'.$q.'</p>';
				//debugging message
			}
		}
		else 
		{
			echo '<script>alert("The record has NOT been deleted");
			window.location.href="admindisplay_records.php";</script>';
		}
	}
		else 
		{
			//display the form
			//retrieve the member's data
			
			$q= "SELECT user_id, date FROM services WHERE id =$id";
			$result = @mysqli_query ($conn, $q); //run the query
			
			if (mysqli_num_rows($result)==1)
			{
				//get admin information
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
				echo "<h3>Are you sure you want to permanently delete {$row['user_id']} on {$row['date']}?</h3>";
				echo'<form action="delete_records.php" method="post">
				<input id = "submit-no" type="submit" name="sure" value="Yes">
				<input id = "submit-no" type="submit" name="sure" value="No">
				<input type ="hidden" name="id" value="'.$id.'">
				
				</form>';
			}
			
			else
			{ //if it didn't run
			  //message
			  echo '<p class = "error">This page has been accessed in error<p>';
			  echo '<p> $nbsp;</p>';
			} //end of it (result)
		}
		mysqli_close($conn); //close the databse connection_aborted

		?>
</body>
</html>
				
<?php
	
	// Figure out which image to like
	$filename = $_GET['file'];
	$my_database = "david_database";
	$my_username = "david_caman";
	$my_password = "kuR[GuBHE801";
	$my_table = "photos2";
	
	
	// Figure out if the person has liked this image before
	session_start();
	$likedArray; 
	if(!isset($_SESSION['ig_files']) || ( isset($_SESSION['ig_files']) && $_SESSION['ig_files'] == "" ) )
	{
		$likedArray = array();
	}
	else
	{
		$likedArray = explode("|", $_SESSION['ig_files']);
	}
	
	$matchFound = false;
	
	for($i = 0; $i<count($likedArray);++$i)
	{
		if ($likedArray[$i] == $filename) 
		{
			$matchFound = true;
			break;
		}
	}
	
	if($matchFound)
	{
		echo "n";
	}
	else
	{
		$likedArray[] = $filename;
	
		// Send the like to the database
		$conn = new mysqli("localhost",$my_username,$my_password,$my_database);
	
		$stm = "UPDATE $my_table SET likes = likes + 1 WHERE filename = ?";
		$stmt = $conn->prepare($stm);
		$stmt->bind_param("s", $filename);
		
		$stmt->execute();
		
		$stmt->close();
		$conn->close();

		echo "y";
	}
	
	$_SESSION['ig_files'] = implode("|",$likedArray);
	
	
	
	// Tell the page that the like was successful.
	
	
?>

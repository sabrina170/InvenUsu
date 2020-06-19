<?php

include('db.php');
include("function.php");

if(isset($_POST["idEntrega"]))
{
	$image = get_image_name($_POST["idEntrega"]);
	if($image != '')
	{
		unlink("upload/" . $image);
	}
	$statement = $connection->prepare(
		"DELETE FROM entregas WHERE idEntrega = :idEntrega"
	);
	$result = $statement->execute(
		array(
			':idEntrega'	=>	$_POST["idEntrega"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Data Deleted';
	}
}



?>
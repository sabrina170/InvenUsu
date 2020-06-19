<?php

function upload_image()
{
	if(isset($_FILES["Imagen"]))
	{
		$extension = explode('.', $_FILES['Imagen']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = './upload/' . $new_name;
		move_uploaded_file($_FILES['Imagen']['tmp_name'], $destination);
		return $new_name;
	}
}

function get_image_name($idEntrega)
{
	include('db.php');
	$statement = $connection->prepare("SELECT Imagen FROM Entregas WHERE idEntrega = '$idEntrega'");
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["Imagen"];
	}
}

function get_total_all_records()
{
	include('db.php');
	$statement = $connection->prepare("SELECT * FROM Entregas");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>
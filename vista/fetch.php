<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM Entregas ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE Usuario_codigo LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Direccion_Llegada LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Distrito LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Latitud LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Longitud LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Guia_Trans LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Guia_Remi LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Guia_Cliente LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Estado LIKE "%'.$_POST["search"]["value"].'%" ';
	
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY idEntrega DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	$image = '';
	if($row["Imagen"] != '')
	{
		$image = '<img src="upload/'.$row["Imagen"].'" class="img-thumbnail" width="50" height="35" />';
	}
	else
	{
		$image = '';
	}
	$sub_array = array();
	
	$sub_array[] = $row["Usuario_codigo"];
	$sub_array[] = $row["Direccion_Llegada"];
	$sub_array[] = $row["Distrito"];
	$sub_array[] = $row["Latitud"];
	$sub_array[] = $row["Longitud"];
	$sub_array[] = $row["Guia_Trans"];
	$sub_array[] = $row["Guia_Remi"];
	$sub_array[] = $row["Guia_Cliente"];
	$sub_array[] = $row["Estado"];
	$sub_array[] = $row["Observaciones"];
	$sub_array[] = $image;
	$sub_array[] = '<button type="button" name="update" idEntrega="'.$row["idEntrega"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" idEntrega="'.$row["idEntrega"].'" class="btn btn-danger btn-xs delete">Delete</button>';
	$sub_array[] = '<button type="button" name="visualizar" idEntrega="'.$row["idEntrega"].'" class="btn btn-success btn-xs visualizar">Visualizar</button>';

	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>
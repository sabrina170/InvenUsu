<?php
include('db.php');
include('function.php');
if(isset($_POST["idEntrega"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM Entregas 
		WHERE idEntrega = '".$_POST["idEntrega"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		
		$output["Usuario_codigo"] = $row["Usuario_codigo"];
		$output["Direccion_Llegada"] = $row["Direccion_Llegada"];
		$output["Distrito"] = $row["Distrito"];
		$output["Latitud"] = $row["Latitud"];
		$output["Longitud"] = $row["Longitud"];
		$output["Guia_Trans"] = $row["Guia_Trans"];
		$output["Guia_Remi"] = $row["Guia_Remi"];
		$output["Guia_Cliente"] = $row["Guia_Cliente"];
		$output["Estado"] = $row["Estado"];
		$output["Observaciones"] = $row["Observaciones"];


		if($row["Imagen"] != '')
		{
			$output['Imagen'] = '<img src="upload/'.$row["Imagen"].'" class="img-thumbnail" width="250" height="285" /><input type="hidden" name="hidden_user_image" value="'.$row["Imagen"].'" />';
		}
		else
		{
			$output['Imagen'] = '<input type="hidden" name="hidden_user_image" value="" />';
		}
	}
	echo json_encode($output);
}
?>
<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$image = '';
		if($_FILES["Imagen"]["name"] != '')
		{
			$image = upload_image();
		}
		$statement = $connection->prepare("
		INSERT INTO Entregas (Usuario_codigo,Direccion_Llegada, Distrito, Latitud, Longitud,Guia_Trans, Guia_Remi,Guia_Cliente, Estado, Observaciones, Imagen) 
			VALUES (:Usuario_codigo, :Direccion_Llegada,:Distrito,:Latitud,:Longitud,
			:Guia_Trans,:Guia_Remi,:Guia_Cliente,:Estado,:Observaciones,:Imagen)
		");
		$result = $statement->execute(
			array(
				':Usuario_codigo'	=>	$_POST["Usuario_codigo"],
				':Direccion_Llegada'	=>	$_POST["Direccion_Llegada"],
				':Distrito'	=>	$_POST["Distrito"],
				':Latitud'	=>	$_POST["Latitud"],
				':Longitud'	=>	$_POST["Longitud"],
				':Guia_Trans'	=>	$_POST["Guia_Trans"],
				':Guia_Remi'	=>	$_POST["Guia_Remi"],
				':Guia_Cliente'	=>	$_POST["Guia_Cliente"],
				':Estado'	=>	$_POST["Estado"],
				':Observaciones'	=>	$_POST["Observaciones"],
				':Imagen'		=>	$image
			)
		);
		if(!empty($result))
		{
			echo 'Entrega insertada exitosamente';
		}
	}

	if($_POST["operation"] == "AddUser")
	{
		
		$statement = $connection->prepare("
		INSERT INTO usuarios (codigonum,nombre,usuario,email,password,privilegio,fecha_registro) 
			VALUES (:codigonum, :nombre,:usuario,:email,:password,
			:privilegio,current_timestamp())
		");
		$result = $statement->execute(
			array(
				':codigonum'	=>	$_POST["codigonum"],
				':nombre'	=>	$_POST["nombre"],
				':usuario'	=>	$_POST["usuario"],
				':email'	=>	$_POST["email"],
				':password'	=>	$_POST["password"],
				':privilegio'	=>	$_POST["privilegio"]
				
			)
		);
		if(!empty($result))
		{
			echo 'Usuario insertado exitosamente';
		}else{
			echo 'error en el insert';
		}
	}


	if($_POST["operation"] == "Edit")
	{
		$image = '';
		if($_FILES["Imagen"]["name"] != '')
		{
			$image = upload_image();
		}
		else
		{
			$image = $_POST["hidden_user_image"];
		}
		$statement = $connection->prepare(
			"UPDATE entregas 
			SET Usuario_codigo = :Usuario_codigo, Direccion_Llegada = :Direccion_Llegada,
			Distrito = :Distrito, Latitud = :Latitud, Longitud = :Longitud, Guia_Trans = :Guia_Trans, 
			Guia_Remi = :Guia_Remi, 
			Guia_Cliente = :Guia_Cliente,Observaciones = :Observaciones,Estado = :Estado,
			 Imagen = :Imagen  
			WHERE idEntrega = :idEntrega
			"
		);
		$result = $statement->execute(
			array(
				':Usuario_codigo'	=>	$_POST["Usuario_codigo"],
				':Direccion_Llegada'	=>	$_POST["Direccion_Llegada"],
				':Distrito'	=>	$_POST["Distrito"],
				':Latitud'	=>	$_POST["Latitud"],
				':Longitud'	=>	$_POST["Longitud"],
				':Guia_Trans'	=>	$_POST["Guia_Trans"],
				':Guia_Remi'	=>	$_POST["Guia_Remi"],
				':Guia_Cliente'	=>	$_POST["Guia_Cliente"],
				':Estado'	=>	$_POST["Estado"],
				':Observaciones'	=>	$_POST["Observaciones"],
				':Imagen'		=>	$image,
				':idEntrega'			=>	$_POST["idEntrega"]
			)
		);
		if(!empty($result))
		{
			echo 'Entrega actualizada exitosamente';
		}
	}

	if($_POST["operation"] == "Visualizar")
	{
		$image = '';
		if($_FILES["Imagen2"]["name"] != '')
		{
			$image = upload_image();
		}
		else
		{
			$image = $_POST["hidden_user_image"];
		}

		
		$statement = $connection->prepare(
			"UPDATE entregas 
			SET Usuario_codigo = :Usuario_codigo, Direccion_Llegada = :Direccion_Llegada,
			Distrito = :Distrito, Latitud = :Latitud, Longitud = :Longitud, Guia_Trans = :Guia_Trans, 
			Guia_Remi = :Guia_Remi, 
			Guia_Cliente = :Guia_Cliente,Observaciones = :Observaciones,Estado = :Estado,
			 Imagen = :Imagen  
			WHERE idEntrega = :idEntrega
			"
		);
		$result = $statement->execute(
			array(
				':Usuario_codigo'	=>	$_POST["Usuario_codigo2"],
				':Direccion_Llegada'	=>	$_POST["Direccion_Llegada2"],
				':Distrito'	=>	$_POST["Distrito2"],
				':Latitud'	=>	$_POST["Latitud2"],
				':Longitud'	=>	$_POST["Longitu2d"],
				':Guia_Trans'	=>	$_POST["Guia_Trans2"],
				':Guia_Remi'	=>	$_POST["Guia_Remi2"],
				':Guia_Cliente'	=>	$_POST["Guia_Cliente2"],
				':Estado'	=>	$_POST["Estado2"],
				':Observaciones'	=>	$_POST["Observaciones2"],
				':Imagen'		=>	$image,
				':idEntrega'			=>	$_POST["idEntrega"]
			)
		);
		if(!empty($result))
		{
			echo 'Entrega actualizada exitosamente';
		}
	}
}

?>
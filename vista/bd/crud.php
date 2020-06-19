<?php
include_once '../bd/Conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   

$idEntrega = (isset($_POST['idEntrega'])) ? $_POST['idEntrega'] : '';
$Usuario_codigo = (isset($_POST['Usuario_codigo'])) ? $_POST['Usuario_codigo'] : '';
$Direccion_Llegada = (isset($_POST['Direccion_Llegada'])) ? $_POST['Direccion_Llegada'] : '';
$Distrito = (isset($_POST['Distrito'])) ? $_POST['Distrito'] : '';
$Latitud = (isset($_POST['Latitud'])) ? $_POST['Latitud'] : '';
$Longitud = (isset($_POST['Longitud'])) ? $_POST['Longitud'] : '';
$Guia_Trans = (isset($_POST['Guia_Trans'])) ? $_POST['Guia_Trans'] : '';
$Guia_Remi = (isset($_POST['Guia_Remi'])) ? $_POST['Guia_Remi'] : '';
$Guia_Cliente = (isset($_POST['Guia_Cliente'])) ? $_POST['Guia_Cliente'] : '';
$Estado = (isset($_POST['Estado'])) ? $_POST['Estado'] : '';
$Observaciones = (isset($_POST['Observaciones'])) ? $_POST['Observaciones'] : '';
$Imagen = (isset($_FILES['Imagen'])) ? $_FILES['Imagen'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

//--------------DE USUARIOO--------------------------

$codigo = (isset($_POST['codigo'])) ? $_POST['codigo'] : '';
$codigonum = (isset($_POST['codigonum'])) ? $_POST['codigonum'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$privilegio = (isset($_POST['privilegio'])) ? $_POST['privilegio'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';




switch($opcion){
    case 1: //alta
        
     

        $consulta = "INSERT INTO `entregas`(`idEntrega`, `Usuario_codigo`, `Direccion_Llegada`,
         `Distrito`, `Latitud`, `Longitud`, `Guia_Trans`, `Guia_Remi`, `Guia_Cliente`, 
         `Estado`, `Observaciones`, `Imagen`, `fecha`) VALUES ('$idEntrega', '$Usuario_codigo', '$Direccion_Llegada',
          '$Distrito', '$Latitud', '$Longitud', '$Guia_Trans', '$Guia_Remi', '$Guia_Cliente',
          ' $Estado', '$Observaciones','$Imagen',current_timestamp() ); ";	
      
          

        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

       // move_uploaded_file($Imagen['tbm_name'],$ruta);
        copy($Imagen['tmp_name'], $ruta);

        
        $consulta = "SELECT * FROM entregas ORDER BY idEntrega DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE Entregas SET Usuario_codigo='$Usuario_codigo', Direccion_Llegada='$Direccion_Llegada',
         Distrito='$Distrito',
         Latitud='$Latitud', Longitud='$Longitud', Guia_Trans='$Guia_Trans',Guia_Remi='$Guia_Remi',
         Guia_Cliente='$Guia_Cliente', Estado='$Estado' , Observaciones='$Observaciones', Imagen='$Imagen'  WHERE idEntrega='$idEntrega' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM entregas WHERE idEntrega='$idEntrega' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;         
    case 3://baja
        $consulta = "DELETE FROM entregas WHERE idEntrega='$idEntrega' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break; 
    case 4: 
        $consulta = "UPDATE Entregas SET Usuario_codigo='$Usuario_codigo', Direccion_Llegada='$Direccion_Llegada',
         Distrito='$Distrito',
         Latitud='$Latitud', Longitud='$Longitud', Guia_Trans='$Guia_Trans',Guia_Remi='$Guia_Remi',
         Guia_Cliente='$Guia_Cliente', Estado='$Estado' , Observaciones='$Observaciones', Imagen='$Imagen' WHERE idEntrega='$idEntrega' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM entregas WHERE idEntrega='$idEntrega' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;  
    case 5:
        $consulta="INSERT INTO `usuarios` (`codigo`, `codigonum`, `nombre`, `usuario`, `email`, `password`, `privilegio`, `fecha_registro`)
        VALUES ('$codigo', '$codigonum', '$nombre', '$usuario', '$email', md5('$password'), '$privilegio', current_timestamp()); ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

<!DOCTYPE html>
<html lang="es">
  <head>
    <?php session_start();?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />  

    <title>Inventario 2</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <link rel="stylesheet" type="text/css" href="assets/css/overhang.min.css" />

     <!-- Bootstrap CSS -->
	 <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">       
  
  </head>

  <body>

<?php
if (isset($_SESSION["usuario"])) {
    if ($_SESSION["usuario"]["privilegio"] == 1) {
        header("location:admin.php");
    }
} else {
    header("location:login.php");
}
?>

<!-- Menu -->
<nav class="navbar navbar-success bg-success">
<img src="Images/logo.jpeg" style="height:60px; width:120px;" alt="">
  <form class="form-inline">
  <a href="cerrar-sesion.php" class="btn btn-light">Cerrar sesión</a>
  </form>
</nav>


<div class="container" >
	<div class="starter-template">
			<div class="container text-center" style="margin:20px;">
				<h1><strong>Bienvenido</strong> <?php echo $_SESSION["usuario"]["nombre"]; ?></h1>
				<p>Panel de control | <span class="btn btn-info"><?php echo $_SESSION["usuario"]["privilegio"] == 1 ? 'Admin' : 'Cliente'; ?></span></p>
			</div>
</div>

<?php
		
		include 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$id=$_SESSION["usuario"]["codigo"];
$consulta=" SELECT * FROM entregas WHERE Usuario_codigo='$id';";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<div>
        <div class="row">
 <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="example" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Codigo Cliente</th>                                
                                <th>Direccion</th>
                                <th>Distrito</th>  
                                <th>Latitud</th>  
                                <th>Longitud</th>  
                                <th>GuiaT</th>  
                                <th>GuiaR</th>  
                                <th>GuiaC</th>
                                <th>Estado</th>  
                                <th>Observaciones</th>  
                                                   
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['idEntrega'] ?></td>
                                <td><?php echo $dat['Usuario_codigo'] ?></td>
                                <td><?php echo $dat['Direccion_Llegada'] ?></td>
                                <td><?php echo $dat['Distrito'] ?></td>
                                <td><?php echo $dat['Latitud'] ?></td>
                                <td><?php echo $dat['Longitud'] ?></td>
                                <td><?php echo $dat['Guia_Trans'] ?></td>
                                <td><?php echo $dat['Guia_Remi'] ?></td>   
                                <td><?php echo $dat['Guia_Cliente'] ?></td>
                                <td><?php echo $dat['Estado'] ?></td>
                                <td><?php echo $dat['Observaciones'] ?></td>
                                
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>

	</div>
</div><!-- /.container -->

</di>
</div>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  
	<script type="text/javascript" src="assets/js/overhang.min.js"></script>
    <script src="assets/js/app.js"></script>
	 
	<script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
    <script type="text/javascript" src="main2.js"></script>


  </body>
</html>
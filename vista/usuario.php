<?php include 'partials/head.php';?>


<?php
if (isset($_SESSION["usuario"])) {
    if ($_SESSION["usuario"]["privilegio"] == 1) {
        header("location:admin.php");
    }
} else {
    header("location:login.php");
}
?>

<?php include 'partials/menu.php';?>
<div class="container">
	<div class="starter-template">
		<br>
		<br>
		<br>
		<div class="jumbotron">
			<div class="container text-center">
				<h1><strong>Bienvenido</strong> <?php echo $_SESSION["usuario"]["nombre"]; ?></h1>
				<p>Panel de control | <span class="label label-info"><?php echo $_SESSION["usuario"]["privilegio"] == 1 ? 'Admin' : 'Cliente'; ?></span></p>
				<p>
					<a href="cerrar-sesion.php" class="btn btn-primary btn-lg">Cerrar sesión</a>
				</p>
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
 <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Codigo Cliente</th>                                
                                <th>Direccion</th>
                                <th>Distrito</th>  
                                <th>Latitud</th>  
                                <th>Longitud</th>  
                                <th>Guia_trans</th>  
                                <th>Guia_Remi</th>  
                                <th>Guia_Cliente</th>
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

<?php include 'partials/footer.php';?>
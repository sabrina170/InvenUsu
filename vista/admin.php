<?php 
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

        $condition	=	'';
        if(isset($_REQUEST['xid']) and $_REQUEST['xid']!=""){
			$condition	.=	' AND idEntrega LIKE "%'.$_REQUEST['xid'].'%" ';
		}
        
        if(isset($_REQUEST['xdireccion']) and $_REQUEST['xdireccion']!=""){
			$condition	.=	' AND Direccion_Llegada LIKE "%'.$_REQUEST['xdireccion'].'%" ';
        }
        if(isset($_REQUEST['xcodigo']) and $_REQUEST['xcodigo']!=""){
			$condition	.=	' AND codigonum LIKE "%'.$_REQUEST['xcodigo'].'%" ';
        }
        if(isset($_REQUEST['xdistrito']) and $_REQUEST['xdistrito']!=""){
			$condition	.=	' AND Distrito LIKE "%'.$_REQUEST['xdistrito'].'%" ';
        }
        if(isset($_REQUEST['xlatitud']) and $_REQUEST['xlatitud']!=""){
			$condition	.=	' AND Latitud LIKE "%'.$_REQUEST['xlatitud'].'%" ';
        }
        if(isset($_REQUEST['xlongitud']) and $_REQUEST['xlongitud']!=""){
			$condition	.=	' AND Longitud LIKE "%'.$_REQUEST['xlongitud'].'%" ';
        }
        if(isset($_REQUEST['xguiatrans']) and $_REQUEST['xguiatrans']!=""){
			$condition	.=	' AND Guia_Trans LIKE "%'.$_REQUEST['xguiatrans'].'%" ';
        }
        if(isset($_REQUEST['xguiaremi']) and $_REQUEST['xguiaremi']!=""){
			$condition	.=	' AND Guia_Remi LIKE "%'.$_REQUEST['xguiaremi'].'%" ';
        }
        if(isset($_REQUEST['xguiacliente']) and $_REQUEST['xguiacliente']!=""){
			$condition	.=	' AND Guia_Cliente LIKE "%'.$_REQUEST['xguiacliente'].'%" ';
        }
        if(isset($_REQUEST['xestado']) and $_REQUEST['xestado']!=""){
			$condition	.=	' AND Estado LIKE "%'.$_REQUEST['xestado'].'%" ';
		}

        $consulta="SELECT * from Entregas";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        $consulta2="SELECT * from usuarios";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();
        $data2=$resultado2->fetchAll(PDO::FETCH_ASSOC);

        $consulta3="SELECT e.idEntrega, usuario.codigonum, e.Direccion_Llegada,
        e.Distrito, e.Latitud, e.Longitud, e.Guia_Trans, e.Guia_Remi, e.Guia_Cliente, e.Estado, e.Observaciones FROM 
         entregas e JOIN usuarios  usuario ON e.Usuario_codigo= usuario.codigo WHERE 1".$condition."";
        $resultado3 = $conexion->prepare($consulta3);
        $resultado3->execute();
        $data3=$resultado3->fetchAll(PDO::FETCH_ASSOC);

       


        if(isset($_POST["export_data"])) {
            if(!empty($data3)) {
            $filename = "reporte_entregas.xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
           
            $mostrar_columnas = false;
           
            foreach($data3 as $dat) {
            if(!$mostrar_columnas) {
            echo implode("\t", array_keys($dat)) . "\n";
            $mostrar_columnas = true;
            }
            echo implode("\t", array_values($dat)) . "\n";
            }
           
            }else{
            echo 'No hay datos a exportar';
            }
            exit;
        }


        
?>

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
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="main.css">  
      
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">       
  
  </head>

  <body> 
  <?php
if (isset($_SESSION["usuario"])) {
    if ($_SESSION["usuario"]["privilegio"] == 2) {
        header("location:usuario.php");
    }
} else {
    header("location:login.php");
}
?>

<!--Menuuu-->
<nav class="navbar navbar-success bg-success">
    <img src="Images/logo.jpeg" style="height:60px; width:120px;" alt="">
  <form class="form-inline">
  <a href="cerrar-sesion.php" class="btn btn-light">Cerrar sesión</a>
  </form>
</nav>

     
<!-- Header-->
<div class="container">
			<div class="container text-center">
				<h1><strong>Bienvenido</strong> <?php echo $_SESSION["usuario"]["nombre"]; ?></h1>
				<p>Panel de control | <span class="btn btn-warning"><?php echo $_SESSION["usuario"]["privilegio"] == 1 ? 'Admin' : 'Cliente'; ?></span></p>
			</div>
</div><!-- /.container -->

   
<!-- Buscador de Admin-->
<div class="container2" style="margin:20px; border: 3px #142538 inset;">

            <form method="post" style="margin:20px">
            <div class="form-row">
            <div class="col">
				<a style="margin-left:1230px" ><i class="fa fa-minus" aria-hidden="true"></i></a>
            </div>
            </div>
            <br>
            <div class="form-row">
            <div class="col">
                <input type="number" class="form-control" placeholder="Id Cliente" name="xid"/>
            </div>
           
            <div class="col">
                <input type="number"class="form-control" placeholder="Codigo" name="xcodigo"/>
            </div>    
            <div class="col">
                <input type="text" class="form-control" placeholder="Direccion" name="xdireccion"/>
            </div>
            <div class="col">
                                    <select name="xdistrito" id="" class="form-control">
                                        <option value="">Distrito</option>
                                        <?php
                                            foreach($data as $dat)
                                            {
                                        ?>
                                            <option value="<?php echo $dat['Distrito'] ?>"><?php echo $dat['Distrito'] ?></option>
                                        <?php        
                                            }
                                        ?>
                                    </select>
                                    </div>
            </div>
            <br>
            <div class="form-row">
            <div class="col">
                <input type="float" class="form-control" placeholder="Latitud" name="latitud"/>
            </div>
            <div class="col">
                <input type="float" class="form-control" placeholder="Longitud" name="xlongitud"/>
            </div>
            <div class="col">
				<input type="number" class="form-control" placeholder="Guia Transitable" name="xguiatrans"/>
            </div>
            <div class="col">
                <input type="number" class="form-control" placeholder="Guia Remitente" name="xguiaremi"/>
            </div>
            <div class="col">
				<input type="number" class="form-control" placeholder="Guia Cliente" name="xguiacliente"/>
            </div>
            <div class="col">
                                    <select name="xestado" id="" class="form-control">
                                        <option value="">Estado</option>
                                        <?php
                                            foreach($data as $dat)
                                            {
                                        ?>
                                            <option value="<?php echo $dat['Estado'] ?>"><?php echo $dat['Estado'] ?></option>
                                        <?php        
                                            }
                                        ?>
                                    </select> 
                                    </div>
            </div>
            <br>
            
            <div class="col">
				<button style="margin-left:1153px" class="btn btn-info" name="buscar" type="submit"><i class="fa fa-search" aria-hidden="true"></i>Consultar</button>
            </div>
            
            
			</form>
    </div>      
    
  <!-- tabla de entregas -->
<div class="container2" style="margin:20px; border-bolor:green;">
        <div class="row" style="margin:10px">
        
            <!--<a class="btn btn-primary" href="index.php" role="button">Mostrar lista total</a>  --> 
       
        <form  style="margin:10px;" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <button class="btn btn-info" type="button" id="btnUsuario"  data-toggle="modal"><i class="fa fa-cog" aria-hidden="true"></i>Usuarios</button>
                <button type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-info">Export to excel</button>
                <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button> 
        </form>
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Codigo</th>                                
                                <th>Direccion</th>
                                <th>Distrito</th>  
                                <th>Latitud</th>  
                                <th>Longitud</th>  
                                <th>GuiaT</th>  
                                <th>GuiaR</th>  
                                <th>GuiaC</th>
                                <th>Estado</th>  
                                <th>Obser.</th>  
                                <th>Acciones</th>                   
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data3 as $dat) {
                                $respuesta = $dat['Estado'];
                                if($dat['Estado']=='Falta'){
                                    echo $color="red";
                                }if($dat['Estado']=='Proceso'){
                                    echo $color='yellow';
                                }if($dat['Estado']=='Entregado'){
                                    echo $color='green';
                                }                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['idEntrega'] ?></td>
                                <td><?php echo $dat['codigonum'] ?></td>
                                <td><?php echo $dat['Direccion_Llegada'] ?></td>
                                <td><?php echo $dat['Distrito'] ?></td>
                                <td><?php echo $dat['Latitud'] ?></td>
                                <td><?php echo $dat['Longitud'] ?></td>
                                <td><?php echo $dat['Guia_Trans'] ?></td>
                                <td><?php echo $dat['Guia_Remi'] ?></td>   
                                <td><?php echo $dat['Guia_Cliente'] ?></td>
                                <td><p color="<?php echo $color ?>"><?php echo $respuesta ?></p></td>
                                <td><?php echo $dat['Observaciones'] ?></td>
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>
        </div>  
    </div>    
      
      
<!-- Insertar y editar-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="formPersonas">    
            <div class="modal-body">
                <div class="form-group">
                <label for="nombre" class="col-form-label">Codigo:</label>
                <select name="codigo" id="Usuario_codigo" class="form-control">
                                        <option value="">Codigo</option>
                                        <?php
                                            foreach($data2 as $dat)
                                            {
                                        ?>
                                            <option value="<?php echo $dat['codigo'] ?>"><?php echo $dat['codigonum'] ?></option>
                                        <?php        
                                            }
                                        ?>
                                    </select>
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Direccion:</label>
                <input type="text" class="form-control" id="Direccion_Llegada">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Distrito:</label>
                <input type="text" class="form-control" id="Distrito">
                </div>   
                <div class="form-group">
                <label for="nombre" class="col-form-label">Latitud:</label>
                <input type="float" class="form-control" id="Latitud">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Longitud:</label>
                <input type="float" class="form-control" id="Longitud">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Guia_Trans:</label>
                <input type="number" class="form-control" id="Guia_Trans">
                </div>
                <div class="form-group">
                <label for="nombre" class="col-form-label">Guia_Remi:</label>
                <input type="number" class="form-control" id="Guia_Remi">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Guia_Cliente:</label>
                <input type="number" class="form-control" id="Guia_Cliente">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Estado:</label>
                <input type="text" class="form-control" id="Estado">
                </div>       
                <div class="form-group">
                <label for="edad" class="col-form-label">Observaciones:</label>
                <input type="text" class="form-control" id="Observaciones">
                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>    

<!-- Modal Editar -->
<div class="modal fade" id="modalCRUD2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="formPersonas2">    
            <div class="modal-body">
                <div class="form-group">
                <label for="nombre" class="col-form-label">Codigo:</label>
                <select name="codigo" id="Usuario_codigo3" class="form-control">
                                        <option value="">Codigo</option>
                                        <?php
                                            foreach($data2 as $dat)
                                            {
                                        ?>
                                            <option value="<?php echo $dat['codigo'] ?>"><?php echo $dat['codigonum'] ?></option>
                                        <?php        
                                            }
                                        ?>
                                    </select>
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Direccion:</label>
                <input type="text" class="form-control" id="Direccion_Llegada3">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Distrito:</label>
                <input type="text" class="form-control" id="Distrito3">
                </div>   
                <div class="form-group">
                <label for="nombre" class="col-form-label">Latitud:</label>
                <input type="float" class="form-control" id="Latitud3">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Longitud:</label>
                <input type="float" class="form-control" id="Longitud3">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Guia_Trans:</label>
                <input type="number" class="form-control" id="Guia_Trans3">
                </div>
                <div class="form-group">
                <label for="nombre" class="col-form-label">Guia_Remi:</label>
                <input type="number" class="form-control" id="Guia_Remi3">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Guia_Cliente:</label>
                <input type="number" class="form-control" id="Guia_Cliente3">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Estado:</label>
                <input type="text" class="form-control" id="Estado3">
                </div>       
                <div class="form-group">
                <label for="edad" class="col-form-label">Observaciones:</label>
                <input type="text" class="form-control" id="Observaciones3">
                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  

<!-- Modal Detalles-->
<div class="modal fade" id="modalVER" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="form">   
        <fieldset disabled> 
        <div class="modal-body">
                <div class="form-group">
                <label for="nombre" class="col-form-label">Codigo del Cliente:</label>
                <input type="number" class="form-control" id="Usuario_codigo2">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Direccion:</label>
                <input type="text" class="form-control" id="Direccion_Llegada2">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Distrito:</label>
                <input type="text" class="form-control" id="Distrito2">
                </div>   
                <div class="form-group">
                <label for="nombre" class="col-form-label">Latitud:</label>
                <input type="float" class="form-control" id="Latitud2">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Longitud:</label>
                <input type="float" class="form-control" id="Longitud2">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Guia_Trans:</label>
                <input type="number" class="form-control" id="Guia_Trans2">
                </div>
                <div class="form-group">
                <label for="nombre" class="col-form-label">Guia_Remi:</label>
                <input type="number" class="form-control" id="Guia_Remi2">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Guia_Cliente:</label>
                <input type="number" class="form-control" id="Guia_Cliente2">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Estado:</label>
                <input type="text" class="form-control" id="Estado2">
                </div>       
                <div class="form-group">
                <label for="edad" class="col-form-label">Observaciones:</label>
                <input type="text" class="form-control" id="Observaciones2">
                </div>     
            </div>
            </fieldset>
        </form>    
        </div>
    </div>
</div>

<!-- Registro Usuarios-->
<div class="modal fade" id="modalUSU" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="formUsu">   
        <div class="modal-body">
                <div class="form-group">
                <label for="nombre" class="col-form-label">Codigo:</label>
                <input type="number" class="form-control" id="codigonum">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Usuario:</label>
                <input type="text" class="form-control" id="usuario">
                </div>   
                <div class="form-group">
                <label for="nombre" class="col-form-label">Email:</label>
                <input type="text" class="form-control" id="email">
                </div>
                <div class="form-group">
                <label for="pais" class="col-form-label">Password:</label>
                <input type="password" class="form-control" id="password">
                </div>                
                <div class="form-group">
                <label for="edad" class="col-form-label">Privilegio:</label>
                <select name="privilegio" id="privilegio">
                <option value="1">Administrador</option>
                <option value="2">Cliente</option>
                </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>


     <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  
	<script type="text/javascript" src="assets/js/overhang.min.js"></script>
    <script src="assets/js/app.js"></script>
	 
	<script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>  

  </body>
</html>



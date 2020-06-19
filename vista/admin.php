<?php
include_once 'db.php';



$consulta2="SELECT * from usuarios";
        $resultado2 = $connection->prepare($consulta2);
        $resultado2->execute();
        $data2=$resultado2->fetchAll(PDO::FETCH_ASSOC);

        $consulta="SELECT * from Entregas";
        $resultado = $connection->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);



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

        $query = "SELECT * FROM Entregas WHERE 1".$condition."";
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC); 


//exportar la data a un excecl

if(isset($_POST["export_data"])) {
    if(!empty($data)) {
    $filename = "reporte_entregas.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=".$filename);
   
    $mostrar_columnas = false;
   
    foreach($data as $dat) {
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
<html>
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
     
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="main.css">  
      
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  

	
		<style>
			body
			{
				margin:0;
				padding:0;
				background-color:#f1f1f1;
			}
			.box
			{
				width:1270px;
				padding:20px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:25px;
			}
		</style>
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
        <nav class="navbar" style="background-color:green;">
            <img src="Images/logo.jpeg" style="height:60px; width:120px;" alt="">
        
        <a style="margin-left:1000px;" href="cerrar-sesion.php" class="btn btn-primary">Cerrar sesión</a>
     
        </nav>
    <!-- Header-->
    <div class="container">
                <div class="container text-center">
                    <h1><strong>Bienvenido</strong> <?php echo $_SESSION["usuario"]["nombre"]; ?></h1>
                    <p>Panel de control | <span class="btn btn-warning"><?php echo $_SESSION["usuario"]["privilegio"] == 1 ? 'Admin' : 'Cliente'; ?></span></p>
                </div>
    </div><!-- /.container -->




<div class="container box">
<form  style="margin:10px;" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

                <button class="btn btn-info" type="button" id="btnUsuario"  data-toggle="modal"><i class="fa fa-cog" aria-hidden="true"></i>Usuarios</button>
                <button type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-info">Export to excel</button>
                <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success ">Nuevo</button> 
               
        </form>
			<div class="table-responsive">
				
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							
							<th width="10%">Codigo</th>
							<th width="10%">Direccion</th>
							<th width="10%">Distrito</th>
							<th width="10%">LAT</th>
							<th width="10%">LON</th>
							<th width="10%">GuiaT</th>
							<th width="10%">GuiaR</th>
							<th width="10%">GuiaC</th>
							<th width="10%">Estado</th>
							<th width="10%">Obs.</th>
							<th width="10%">Imagen</th>
							<th width="10%">Edit</th>
							<th width="10%">Delete</th>
							<th width="10%">Ver</th>
						</tr>
					</thead>
				</table>
				
			</div>
		</div>

<!-- Insertar y actualizar-->
<div id="userModal" class="modal fade">
	<div class="modal-dialog">
	
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Entrega</h4>
				</div>
				<div class="modal-body">
					<label>Codigo:</label>
					<select name="Usuario_codigo" id="Usuario_codigo"  class="form-control">
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
					<br />
					<label>Dirección:</label>
					<input type="text" name="Direccion_Llegada" id="Direccion_Llegada" class="form-control" />
					
					<label>Distrito:</label>
					<input type="text" name="Distrito" id="Distrito" class="form-control" />
					<br />
					<label>Latitud</label>
					<input type="float" name="Latitud" id="Latitud" class="form-control" />
					<br />
					<label>Longitud</label>
					<input type="float" name="Longitud" id="Longitud" class="form-control" />
					<br />
					<label>GuiaT:</label>
					<input type="number" name="Guia_Trans" id="Guia_Trans" class="form-control" />
					<br />
					<label>GuiaR :</label>
					<input type="number" name="Guia_Remi" id="Guia_Remi" class="form-control" />
					<br />
					<label>GuiaC</label>
					<input type="number" name="Guia_Cliente" id="Guia_Cliente" class="form-control" />
					<br />
					<label>Estado:</label>
					<select name="Estado" id="Estado"  class="form-control" >
					<option value="Entregado">Entregado</option>
					<option value="Resagado">Resagado</option>
					<option value="Pendiente">Pendiente</option>
					<option value="Stock">Stock</option>
					</select>
					<br />
					<label>Observaciones:</label>
					<input type="text" name="Observaciones" id="Observaciones" class="form-control" />
					<br />
					<label>Image</label>
					<input type="file" name="Imagen" id="Imagen" />
					<span id="user_uploaded_image"></span>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="idEntrega" id="idEntrega" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Insertar Uusuarios -->
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
                <select name="privilegio"  class="form-control" id="privilegio">
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

<!-- visualizar entregas-->

<div id="userModal2" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
		 
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add User</h4>
				</div>
				<fieldset disabled>
				<div class="modal-body">
					<label>Codigo:</label>
					<input type="text" name="Usuario_codigo" id="Usuario_codigo2" class="form-control" />
					<br />
					<label>Direccion:</label>
					<input type="text" name="Direccion_Llegada" id="Direccion_Llegada2" class="form-control" />
					<br />
					<label>Distrito:</label>
					<input type="text" name="Distrito" id="Distrito2" class="form-control" />
					<br />
					<label>Latitud</label>
					<input type="float" name="Latitud" id="Latitud2" class="form-control" />
					<br />
					<label>Longitud</label>
					<input type="float" name="Longitud" id="Longitud2" class="form-control" />
					<br />
					<label>GuiaT:</label>
					<input type="number" name="Guia_Trans" id="Guia_Trans2" class="form-control" />
					<br />
					<label>GuiaR :</label>
					<input type="number" name="Guia_Remi" id="Guia_Remi2" class="form-control" />
					<br />
					<label>GuiaC</label>
					<input type="number" name="Guia_Cliente" id="Guia_Cliente2" class="form-control" />
					<br />
					<label>Estado:</label>
					<select name="Estado" id="Estado2"  class="form-control" >
					<option value="Entregado">Entregado</option>
					<option value="Resagado">Resagado</option>
					<option value="Pendiente">Pendiente</option>
					<option value="Stock">Stock</option>
					</select>
					<br />
					<label>Observaciones:</label>
					<input type="text" name="Observaciones" id="Observaciones2" class="form-control" />
					<br />
					<label>Image</label>
					<input type="file" name="Imagen" id="Imagen2" />
					<span id="user_uploaded_image2"></span>
				</div>
				
			</div>
			</fieldset>
		</form>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        
	<script type="text/javascript" src="assets/js/overhang.min.js"></script>
    <script src="assets/js/app.js"></script>

      
     
    <script type="text/javascript" src="main.js"></script>  


<script type="text/javascript" language="javascript" >


  $(document).ready(function(){
	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Agregar Entrega");
		$('#action').val("Add");
		$('#operation').val("Add");
		$('#user_uploaded_image').html('');
	});

	$('#add_buttonUser').click(function(){
		$('#user_fo')[0].reset();
		$('.modal-title').text("Agregar Usuario");
		$('#action').val("AddUser");
		$('#operation').val("AddUser");
	});

	$(document).on('submit', '#user_fo', function(event){
		event.preventDefault();
		var codigonum = $('#codigonum').val();
		var nombre = $('#nombre').val();
		var usuario = $('#usuario').val();
		var email = $('#email').val();
		var password = $('#password').val();
		var privilegio = $('#privilegio').val();
		
		if(usuario != '' && password != '')
		{
			$.ajax({
				url:"insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#user_fo')[0].reset();
					$('#userMo').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Estos campos son requeridos");
		}
	});
	
	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 3, 4],
				"orderable":false,
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var Usuario_codigo = $('#Usuario_codigo').val();
		var Direccion_Llegada = $('#Direccion_Llegada').val();
		var Distrito = $('#Distrito').val();
		var Latitud = $('#Latitud').val();
		var Longitud = $('#Longitud').val();
		var Guia_Trans = $('#Guia_Trans').val();
		var Guia_Remi = $('#Guia_Remi').val();
		var Guia_Cliente = $('#Guia_Cliente').val();
		var Estado = $('#Estado').val();
		var Observaciones = $('#Observaciones').val();
		var Imagen = $('#Imagen').val().split('.').pop().toLowerCase();
		if(Imagen != '')
		{
			if(jQuery.inArray(Imagen, ['gif','png','jpg','jpeg']) == -1)
			{
				alert("Invalid Image File");
				$('#Imagen').val('');
				return false;
			}
		}	
		if(Usuario_codigo != '' && Direccion_Llegada != '')
		{
			$.ajax({
				url:"insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Both Fields are Required");
		}
	});
	
	$(document).on('click', '.update', function(){
		var idEntrega = $(this).attr("idEntrega");
		$.ajax({
			url:"fetch_single.php",
			method:"POST",
			data:{idEntrega:idEntrega},
			dataType:"json",
			success:function(data)
			{
				$('#userModal').modal('show');
				$('#Usuario_codigo').val(data.Usuario_codigo);
				$('#Direccion_Llegada').val(data.Direccion_Llegada);
				$('#Distrito').val(data.Distrito);
				$('#Latitud').val(data.Latitud);
				$('#Longitud').val(data.Longitud);
				$('#Guia_trans').val(data.Guia_Trans);
				$('#Guia_Remi').val(data.Guia_Remi);
				$('#Guia_Cliente').val(data.Guia_Cliente);
				$('#Estado').val(data.Estado);
				$('#Observaciones').val(data.Observaciones);

				$('.modal-title').text("Editar Entrega");
				$('#idEntrega').val(idEntrega);
				$('#user_uploaded_image').html(data.Imagen);
				$('#action').val("Edit");
				$('#operation').val("Edit");
			}
		})
	});

	$(document).on('click', '.visualizar', function(){
		var idEntrega = $(this).attr("idEntrega");
		$.ajax({
			url:"fetch_single.php",
			method:"POST",
			data:{idEntrega:idEntrega},
			dataType:"json",
			success:function(data)
			{
				$('#userModal2').modal('show');
				$('#Usuario_codigo2').val(data.Usuario_codigo);
				$('#Direccion_Llegada2').val(data.Direccion_Llegada);
				$('#Distrito2').val(data.Distrito);
				$('#Latitud2').val(data.Latitud);
				$('#Longitud2').val(data.Longitud);
				$('#Guia_trans2').val(data.Guia_Trans);
				$('#Guia_Remi2').val(data.Guia_Remi);
				$('#Guia_Cliente2').val(data.Guia_Cliente);
				$('#Estado2').val(data.Estado);
				$('#Observaciones2').val(data.Observaciones);

				$('.modal-title').text("Ver Entrega");
				$('#idEntrega').val(idEntrega);
				$('#user_uploaded_image2').html(data.Imagen);
				$('#action').val("Visualizar");
				$('#operation').val("Visualizar");
			}
		})
	});
	
	
	$(document).on('click', '.delete', function(){
		var idEntrega = $(this).attr("idEntrega");
		if(confirm("¿Estas seguro que quieres eliminar esto?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{idEntrega:idEntrega},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});
	
	
});
</script>



</body>
</html>




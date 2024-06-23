<?php
session_start();
require_once 'segacceso/segacceso.php';
require_once 'connections/connsegusuario.php';
date_default_timezone_set('America/Argentina/Salta');


/* actualizar imagen */
if (isset ($_REQUEST['imgperfil'])) {
    
    $tipo = array('image/JPG','image/jpeg','image/jpg','image/png','iamge/JPEG','iamge/PNG');

	if (in_array ($_FILES['imagen']['type'],$tipo) ) {
	
		// comprobar que el tamaño del archivo sea inferior a 290 KB	
		if( ($_FILES['imagen']['size'])>300000 ) {
 
			$err = 'Esta intentando subir un archivo que supera el tamaño permitido'; 
		
		} else {

			// consulta foto anterior    
			$fotoanterior = mysqli_query ($conexion, "SELECT usuario_avatar FROM segusuario.usuarios WHERE usuario_id ='$_SESSION[usuario_id]'");

			$row_fotoanterior = mysqli_fetch_array($fotoanterior);
	
			//guardar la foto
			$nombrefoto=$_SESSION['usuario_id'].'_'.date ('YmjHis').'.jpg'; // nombre compuesto por año mes dia hora minuto y segundos
			$ruta= $_FILES['imagen']['tmp_name'];
			$destino='../acceso/users/fotoperfil/'.$nombrefoto;
			move_uploaded_file($ruta, $destino);
    
			// eliminar foto anterior
			if (($row_fotoanterior['usuario_avatar']=='female-avatar.png') or ($row_fotoanterior['usuario_avatar']=='male-avatar.png')) {
				
			} else {
				unlink('../acceso/users/fotoperfil/'.$row_fotoanterior['usuario_avatar']);
			}
			
			// guardar ruta
			mysqli_query ($conexion, "UPDATE usuarios SET usuario_avatar= '$nombrefoto' WHERE usuario_id = '$_SESSION[usuario_id]'")
			or die("Problemas al subir la imagen ");

			header("Location: $_SERVER[PHP_SELF]");
		
		}
	
	} else {
		$err = 'Formato incorrecto';
	}
}


/* actualizar nombre de usuario */
if (isset ($_REQUEST['cuenta'])) {
    
	mysqli_query ($conexion, "UPDATE usuarios SET usuario_cuenta= '$_REQUEST[cuenta]' WHERE usuario_id = '$_SESSION[usuario_id]'")
	or die("Problemas al actualizar usuario ");

	header("Location: ../acceso/login.php?upd=usupd");
}


/* actualizar mail*/
if (isset ($_REQUEST['mail'])) {

	mysqli_query ($conexion, "UPDATE usuarios SET usuario_email= '$_REQUEST[mail]' WHERE usuario_id = '$_SESSION[usuario_id]'")
	or die("Problemas al actualizar e-mail ");
    
	header("Location: $_SERVER[PHP_SELF]");
}


/* actualizar psw*/
if (isset ($_REQUEST['psw'])) {

    $psw_new=$_REQUEST['psw'];
    $char=$_REQUEST['idchar'];
    $pass_new = crypt($psw_new,md5($char));;
    
	mysqli_query ($conexion, "UPDATE usuarios SET usuario_pass= '$pass_new' WHERE usuario_id = '$_SESSION[usuario_id]'")
	or die("Problemas al actualizar contraseña ");
    
    header("Location: ../acceso/login.php?upd=passupd");
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
	<script type="text/javascript" defer src="js/setting.js"></script>
</head>
<body>
	<header>
		<div id="main"> 
			<div id="logo"><?php include 'logotipo.php' ?></div>
			<div id="opt-usuario"><?php include 'datoscuenta.php' ?></div>
        </div>
	</header>
    
	<nav id="nav">
		<?php include 'menu.php' ?>
	</nav>
        
    <section>
		<article>
			<div class="marg_cont"> 
				
				<h3>Mis datos</h3>
				<br>
				<hr>
                   
				<?php
				// consulta datos usuario
				
				$usuid = $_SESSION['usuario_id'];
				$usuario = mysqli_query ($conexion, "SELECT * FROM segusuario.usuarios WHERE usuario_id='$usuid'");
				$row_usuario = mysqli_fetch_array($usuario);
				
				?>
                  
				<form action="settings_usuario.php" method="post" id="volver"></form>
				
				<table class="settings" width="70%">

					<!-- ================ foto de perfil ===================== -->   
					<?php
					if (isset ($_REQUEST['edit']) and $_REQUEST['edit'] == 'usfoto') { ?>
								
						<tr>
							<td colspan="3">        
								
								<!-- form foto de perfil -->
								
								<form  enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" >
									<input type="hidden" name="imgperfil" value="1">
									
									<table width="100%">
										<tr>
											<td width="240">
												<label>Nueva foto de perfil</label>
											</td>
											<td>
												<output id="list"></output>
											</td>
											<td>
												<input type="file" id="imagen" name="imagen" required />
											</td>
											<td>
												<input type="submit" class="botones aceptar" value="Guardar cambios">
												<input type="submit" class="botones cancel" value="Cancelar" form="volver">
											</td>
										</tr>
									</table>
								</form>
								  
								<!-- fin form cuenta -->
								   
							</td>
						</tr>
					
					<?php
					} else { ?>
					
						<tr class="alternar">
							<td width="250">
								Foto de perfil
							</td>
							<td>
								<img class="thumb" src="<?= '../acceso/users/fotoperfil/'.$row_usuario['usuario_avatar'] ?>" />
							</td>
							<td>
								<a href="<?= $_SERVER['PHP_SELF'].'?edit=usfoto' ?>">Editar</a>
							</td>
						</tr>
						
					<?php
					} ?>
					
						<!-- ============ -->                                     
																												 
						<tr>
							<td width="250">
								Nombre y Apellido
							</td>
							<td>
								<?= utf8_encode($row_usuario['usuario_nombre'].' '.$row_usuario['usuario_apellido']) ?>
							</td>
							<td>
								&nbsp;
							</td>
						</tr>
						  
						<!-- ================ nombre de cuenta ===================== -->
						  
						<?php
						if (isset ($_REQUEST['edit']) and $_REQUEST['edit'] =='uscuenta') { ?>
							   
						<tr>
							<td colspan="3">        
							   
								<!-- form cuenta -->
								
								<form name="nvacta" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
								
									<table width="100%" >
										<tr>
											<td width="240">
												<label>Nuevo nombre de usuario</label>
											</td>
											<td>
												<input type="text" name="cuenta" pattern="[a-z0-9].{4,}" title="Solo debe contener letras en minusculas y una longitud minima de 4 caracteres" autofocus placeholder="<?php echo utf8_encode($row_usuario['usuario_cuenta']);?>" required >
											</td>
											<td>
												<input type="submit" class="botones aceptar" value="Guardar cambios">
												<input type="submit" class="botones cancel" value="Cancelar" form="volver">
											</td>
										</tr>
									</table>
									
								</form>
								
								<!-- fin form cuenta -->
								
							</td>
						</tr>

						<?php
						} else { ?>
							
						<tr class="alternar">
							<td>
								Nombre de usuario
							</td>
							<td>
								<?= utf8_encode($row_usuario['usuario_cuenta']) ?>
							</td>
							<td>
								<a href="<?= $_SERVER['PHP_SELF'].'?edit=uscuenta' ?>">Editar</a>
							</td>
						</tr>
						
						<?php
						} ?>
						  
						<!-- ================ e-mail ===================== -->
						
						<?php
						if (isset ($_REQUEST['edit']) and $_REQUEST['edit'] =='usmail') { ?>
							   
						<tr>
							<td colspan="3">        
								<!-- form mail -->
								
								<form name="email" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
								
									<table width="100%" >
										<tr>
											<td width="240">
												<label>Nuevo E-mail</label>
											</td>
											<td>
												<input type="email" name="mail" <?php if ($row_usuario['usuario_email']!=NULL) { echo 'placeholder="'. utf8_encode($row_usuario['usuario_email']).'"';} ?> autofocus  required>
											</td>
											<td>
												<input type="submit" class="botones aceptar" value="Guardar cambios">
												<input type="submit" class="botones cancel" value="Cancelar" form="volver">
											</td>
										</tr>
									</table>
									
								</form>
								
								<!-- fin form mail -->

							</td>
						</tr>
						
						<?php
						} else { ?>
						  
						<tr class="alternar">
							<td>
								E-mail
							</td>
							<td>
								<?php if ($row_usuario['usuario_email']==NULL){ echo '<em>Sin registro.</em>';}  else { echo utf8_encode($row_usuario['usuario_email']);} ?>
							</td>
							<td>
								<a href="<?= $_SERVER['PHP_SELF'].'?edit=usmail' ?>">Editar</a>
							</td>
						</tr>
						
						<?php
						} ?>
						  
						<!-- ================ password ===================== -->
						  
						<?php
						if (isset ($_REQUEST['edit']) and $_REQUEST['edit'] =='uspsw') { ?>
							   
						<tr>
							<td colspan="3">        
							   
								<!-- form mail -->
								
								<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" >
								
									<table width="100%" >
										<tr>
											<td width="240">
												<label>Nueva contraseña</label>
											</td>
											<td>
												<input type="hidden" name="idchar" value="<?= $row_usuario['usuario_idchar'] ?>">
												<input name="psw" type="password" autocomplete="new_password" autofocus value="" pattern=".{4,}" title="La contraseña debe contener como minimo 4 caracteres" required>
											</td>
											<td>
												<input type="submit" class="botones aceptar" value="Guardar cambios">
												<input type="submit" class="botones cancel" value="Cancelar" form="volver">
											</td>
										</tr>
									</table>
									
								</form>
								
								<!-- fin form mail -->
							
							</td>
						</tr>
						
						<?php
						} else { ?>
						
						<tr class="alternar">
							<td>
								Contraseña
							</td>
							<td>
								***********
							</td>
							<td>
								<a href="<?= $_SERVER['PHP_SELF'].'?edit=uspsw' ?>">Editar</a>
							</td>
						</tr>
						
						<?php
						} ?>
				</table>
                  
				<hr>
			
			</div>
		</article>
    </section>
    
	<footer>
		<?php include 'footer.php' ?>
	</footer>

</body>
</html>
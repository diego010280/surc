<?php 

$usuid=$_SESSION['usuario_id'];

$usuario= mysqli_query ($conexion, "SELECT * FROM segusuario.usuarios WHERE usuario_id='$usuid'");
$row_usuario = mysqli_fetch_array($usuario);

?>

<div id="cuenta">
	<!--<div id="ayuda"></div>-->
	<img id="avatar" src="<?php echo '../acceso/users/fotoperfil/'.$row_usuario['usuario_avatar'] ?>" />
	<div id="datos-cuenta">
                      
		<!-- menu cuenta -->                     
		<nav class="vertical">
			<ul>
				<li><a href="#"><div id="nomb_usu"><?= utf8_encode(ucwords(strtolower($row_usuario['usuario_nombre'].' '.$row_usuario['usuario_apellido'])))?></div><div class="puntos"></div></a>
					<ul>
						<li><a href="settings_usuario.php">Datos de usuario</a></li>
						<li><a href="#">Notificaciones</a></li>
						<li><a href="segacceso/salir.php">Cerrar módulo</a></li>
						<li><a href="segacceso/logout.php">Salir</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</div>
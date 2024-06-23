<?php

$mod = $_SESSION['moduleid'];
$usid = $_SESSION['usuario_id'];



// consulta para const menu
/*$obj = mysqli_query ($conexion, "SELECT DISTINCT(objetos.objeto_id) AS IdObjeto, objetos.objeto_descrip, permiso_ejec, objetos.objeto_link FROM autorizacion
	INNER JOIN perfiles ON perfiles.perfil_id = autorizacion.autorizacion_perfil_id
	INNER JOIN objetos ON objetos.objeto_modulo_id = perfiles.perfil_modulo_id
	INNER JOIN permisos ON permisos.permiso_perfil_id = perfiles.perfil_id AND permisos.permiso_objeto_id = objetos.objeto_id
	WHERE autorizacion.autorizacion_usuario_id = '$usid' AND perfiles.perfil_modulo_id = '$mod' AND objetos.objeto_activo =1 AND objetos.objeto_titulo=1 AND (objetos.objeto_padre IS NULL or objetos.objeto_padre=0) AND objetos.objeto_vercomo IN (1,3) ");
*/


$obj = mysqli_query ($conexion, "SELECT DISTINCT(objetos.objeto_id) AS IdObjeto, objetos.objeto_descrip, permiso_ejec, objetos.objeto_link, autorizacion_perfil_id
	FROM autorizacion
	INNER JOIN perfiles ON perfiles.perfil_id = autorizacion.autorizacion_perfil_id
    INNER JOIN objetos ON objetos.objeto_modulo_id = perfiles.perfil_modulo_id
	INNER JOIN permisos ON permisos.permiso_perfil_id = perfiles.perfil_id AND permisos.permiso_objeto_id = objetos.objeto_id
	WHERE autorizacion.autorizacion_usuario_id = '$usid' AND perfiles.perfil_modulo_id = '$mod' AND objetos.objeto_activo = 1 AND objetos.objeto_titulo = 1
	AND (objetos.objeto_padre IS NULL or objetos.objeto_padre=0) AND objetos.objeto_vercomo IN (1,3)
	/*GROUP BY IdObjeto*/") or die("Problemas con select obj: ".mysqli_error($conexion));;

$num_row_obj = $obj->num_rows;
$row_obj = mysqli_fetch_array($obj);

?>

   <!-- menu horizontal -->
   	<ul class="menu">
				<li><a href="ctrlpanel.php">Inicio</a></li>

		<?php

    if ($num_row_obj > 0) {



			mysqli_data_seek($obj,0);
			while ($row_obj = mysqli_fetch_array($obj)) {

				if($row_obj['permiso_ejec'] == 1) { ?>

					<li>
						<a class="stop" href="#"><span><?= utf8_encode($row_obj['objeto_descrip']) ?></span></a>

						<?php
						// consulta hijos
						$hijos = mysqli_query ($conexion, "SELECT DISTINCT(objetos.objeto_id) AS IdObjeto, objetos.objeto_link, objetos.objeto_descrip
							FROM autorizacion
							JOIN perfiles ON perfiles.perfil_id = autorizacion.autorizacion_perfil_id
							JOIN permisos ON permisos.permiso_perfil_id = perfiles.perfil_id
							JOIN objetos on objetos.objeto_id = permisos.permiso_objeto_id
							WHERE autorizacion_usuario_id = '$usid' AND perfil_modulo_id = '$mod' AND objetos.objeto_vercomo IN (1,3) AND objeto_titulo = 1 AND objeto_activo = 1
							AND objeto_padre= $row_obj[IdObjeto] AND permiso_ejec = 1 ");

						if ($hijos->num_rows > 0) { ?>
							<ul>
								<?php
								while ($row_hijos = mysqli_fetch_array($hijos)) { ?>

									<li><a href="<?= $row_hijos['objeto_link'] ?>"><span><?= utf8_encode($row_hijos['objeto_descrip']) ?></span></a></li>

								<?php
								} ?>
							</ul>
						<?php
						} ?>

					</li>
				<?php
				}
			}
    }

		$perfil=	mysqli_query($conexion,"SELECT * FROM perfiles WHERE perfil_modulo_id='$mod'") or die("Problemas con perfil surc: ".mysqli_error($conexion));
		$num_row_perfil = $perfil->num_rows;

		if ($num_row_perfil >0) {

				while ($row_perfil = mysqli_fetch_array($perfil)) {
								// if ($row_perfil['perfil_id']==97) {
								if ($row_perfil['perfil_id']==154) {?>		
									<li>


										<form action="../vif/segacceso/checks_intermod.php" method="post">
										<div class="irModulo">Modulo VIF&nbsp;&raquo;</div>
										<input type="hidden" name="usuarioid" value="<?=$_SESSION['usuario_id']?>">
										<input type="hidden" name="usuariochar" value="usu">
										<input type="hidden" name="moduloid" value="<?=$_SESSION['moduleid']?>">
									</form>

								</li>
							<?php
								break;
						}

				}
		}
    ?>



	</ul>

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
       /* if (!empty(mysqli_num_rows($obj))) {

			while ($row_obj = mysqli_fetch_array($obj)) {

				if($row_obj['permiso_ejec'] == 1) { ?>

					<li><a href="<?= $row_obj['objeto_link'] ?>"><?= utf8_encode($row_obj['objeto_descrip']) ?></a>

						<?php
						// consulta hijos
						$hijos = mysqli_query ($conexion, "SELECT DISTINCT(objetos.objeto_id) AS IdObjeto, objetos.objeto_link, objetos.objeto_descrip
							FROM autorizacion
							inner join perfiles on perfiles.perfil_id = autorizacion.`autorizacion_perfil_id`
							inner join permisos on permisos.permiso_perfil_id = perfiles.perfil_id
							inner join objetos on objetos.objeto_id = permisos.permiso_objeto_id
							WHERE autorizacion_usuario_id = '$usid' and perfil_modulo_id = '$mod' and objeto_vercomo in (1,3) and objeto_titulo = 1 and objeto_activo = 1
							and objeto_padre = $row_obj[IdObjeto] and permiso_ejec = 1
							order by objeto_orden");

						if (!empty(mysqli_num_rows($hijos))) { ?>
							<ul>
								<?php
								while ($row_hijos = mysqli_fetch_array($hijos)) { ?>

									<li><a href="<?=  $row_hijos['objeto_link'] ?>"><?= utf8_encode($row_hijos['objeto_descrip']) ?></a></li>

								<?php
								}  ?>
							</ul>
						<?php
						} ?>
					</li>
				<?php
				}
			}
        } */
        
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
        
        
        
        
        
        ?>
	</ul>

<?php
session_start();
//require_once ('lib/pdf/mpdf.php');
//require_once('administracion/segacceso.php');
//require_once('Connections/conn_dgrh.php');
///date_default_timezone_set('America/Argentina/Salta');

require_once ('../rrhh/lib/pdf/mpdf.php');
require_once('../rrhh/administracion/segacceso.php');
require_once('../rrhh/Connections/conn_dgrh.php');
date_default_timezone_set('America/Argentina/Salta');

$datosform123= mysqli_query ($conexion, "SELECT ck_formu_id,ck_depen_id,GEN_Organismos_Descripcion,ck_fecha,ck_legajo_jn,ck_jerarquia_jn,RRHH_TipoGrados_Desc,ck_edi_plantas,ck_edi_antiguedad,ck_edi_esalquilado,ck_edi_dimensiones,ck_edi_cantpol,ck_edi_cantcivil,
							ck_edi_paredes,ck_edi_pisos,ck_edi_techos,ck_edi_cielorraso,ck_edi_resultado,ck_edi_paredes_material,ck_edi_pisos_material,ck_edi_techo_material,ck_edi_cielo_material,
							ck_elec_tabl,ck_elec_simb,ck_elec_difer,ck_elec_termo,ck_elec_tierra,ck_elec_emb,ck_elec_gral,ck_elec_resultado,
							ck_sani_agua,ck_sani_sani,ck_sani_pol,ck_sani_pub,ck_sani_disc,ck_sani_gral,ck_sani_resultado,
							ck_edi_paredesv.valor_desc AS ck_edi_paredes_v,ck_edi_pisosv.valor_desc AS ck_edi_pisos_v,ck_edi_techosv.valor_desc AS ck_edi_techos_v,ck_edi_cielorrasov.valor_desc AS ck_edi_cielorraso_v,
							ck_elec_tablv.valor_desc AS ck_elec_tabl_v,ck_elec_simbv.valor_desc AS ck_elec_simb_v,ck_elec_diferv.valor_desc AS ck_elec_difer_v,ck_elec_termov.valor_desc AS ck_elec_termo_v,
							ck_elec_tierrav.valor_desc AS ck_elec_tierra_v,ck_elec_embv.valor_desc AS ck_elec_emb_v,ck_elec_gralv.valor_desc AS ck_elec_gral_v						
							FROM ck_formulario 
							INNER JOIN gen_organismos ON ck_depen_id = gen_organismos.GEN_ORGANISMOS_Id
							INNER JOIN rrhh_tipogrados ON ck_jerarquia_jn = rrhh_tipogrados.RRHH_TipoGrados_Id	
							INNER JOIN ck_valoracion AS ck_edi_paredesv ON ck_edi_paredes = ck_edi_paredesv.valor_id 
							INNER JOIN ck_valoracion AS ck_edi_pisosv ON ck_edi_pisos = ck_edi_pisosv.valor_id 
							INNER JOIN ck_valoracion AS ck_edi_techosv ON ck_edi_techos = ck_edi_techosv.valor_id 
							INNER JOIN ck_valoracion AS ck_edi_cielorrasov ON ck_edi_cielorraso = ck_edi_cielorrasov.valor_id 
							INNER JOIN ck_valoracion AS ck_elec_tablv ON ck_elec_tabl = ck_elec_tablv.valor_id 
							INNER JOIN ck_valoracion AS ck_elec_simbv ON ck_elec_simb = ck_elec_simbv.valor_id 
							INNER JOIN ck_valoracion AS ck_elec_diferv ON ck_elec_difer = ck_elec_diferv.valor_id 
							INNER JOIN ck_valoracion AS ck_elec_termov ON ck_elec_termo = ck_elec_termov.valor_id 
							INNER JOIN ck_valoracion AS ck_elec_tierrav ON ck_elec_tierra = ck_elec_tierrav.valor_id 
							INNER JOIN ck_valoracion AS ck_elec_embv ON ck_elec_emb = ck_elec_embv.valor_id 
							INNER JOIN ck_valoracion AS ck_elec_gralv ON ck_elec_gral = ck_elec_gralv.valor_id 					
							WHERE ck_formu_id = $_REQUEST[ck_formu_id]")
								or die("Problemas en el select:".mysqli_error($conexion));
		$row_datosform123 = mysqli_fetch_array($datosform123);	

		$datosform3= mysqli_query ($conexion, "SELECT ck_formu_id,ck_legajo_jn,RRHH_ApeNom,ck_sani_agua,ck_sani_sani,ck_sani_pol,ck_sani_pub,ck_sani_disc,ck_sani_gral,ck_sani_resultado,
							ck_sani_aguav.valor_desc AS ck_sani_agua_v,ck_sani_saniv.valor_desc AS ck_sani_sani_v,ck_sani_polv.valor_desc AS ck_sani_pol_v,			
							ck_sani_pubv.valor_desc AS ck_sani_pub_v,ck_sani_discv.valor_desc AS ck_sani_disc_v,ck_sani_gralv.valor_desc AS ck_sani_gral_v
							FROM ck_formulario 
							INNER JOIN view_datospers ON ck_legajo_jn = view_datospers.RRHH_DatosPers_Legajo	
							INNER JOIN ck_valoracion AS ck_sani_aguav ON ck_sani_agua = ck_sani_aguav.valor_id 
							INNER JOIN ck_valoracion AS ck_sani_saniv ON ck_sani_sani = ck_sani_saniv.valor_id 
							INNER JOIN ck_valoracion AS ck_sani_polv ON ck_sani_pol = ck_sani_polv.valor_id 
							INNER JOIN ck_valoracion AS ck_sani_pubv ON ck_sani_pub = ck_sani_pubv.valor_id 
							INNER JOIN ck_valoracion AS ck_sani_discv ON ck_sani_disc = ck_sani_discv.valor_id 
							INNER JOIN ck_valoracion AS ck_sani_gralv ON ck_sani_gral = ck_sani_gralv.valor_id 
											
							WHERE ck_formu_id = $_REQUEST[ck_formu_id]")
								or die("Problemas en el select:".mysqli_error($conexion));
		$row_datosform3 = mysqli_fetch_array($datosform3);	

$segundo= mysqli_query ($conexion, "SELECT ck_formu_id,ck_esp_calef,ck_esp_calef_fun,ck_esp_electrog,ck_esp_electrog_fun,ck_esp_aacond,ck_esp_aacond_fun,ck_esp_venti,ck_esp_venti_fun,ck_esp_fumigado,ck_esp_gral,ck_esp_resultado,
							ck_eva_saleme,ck_eva_hojas,ck_eva_salsen,ck_eva_luces_eme,ck_eva_luces_cant,ck_eva_luces_func,ck_eva_rampa,ck_eva_planos,ck_eva_gral,ck_eva_esc_ancho,ck_eva_salida_ancho,ck_eva_resultado,
							ck_inc_matafuego,ck_inc_mataf_cant,ck_inc_mataf_carg,ck_inc_mataf_acc,ck_inc_mataf_chap,ck_inc_gral,ck_inc_resultado,
							ck_esp_calefv.valor_desc AS ck_esp_calef_v,ck_esp_calef_funv.valor_desc AS ck_esp_calef_fun_v,ck_esp_electrogv.valor_desc AS ck_esp_electrog_v,ck_esp_electrog_funv.valor_desc AS ck_esp_electrog_fun_v,
							ck_esp_aacondv.valor_desc AS ck_esp_aacond_v,ck_esp_aacond_funv.valor_desc AS ck_esp_aacond_fun_v,ck_esp_ventiv.valor_desc AS ck_esp_venti_v,ck_esp_venti_funv.valor_desc AS ck_esp_venti_fun_v,
							ck_esp_fumigadov.valor_desc AS ck_esp_fumigado_v,ck_esp_gralv.valor_desc AS ck_esp_gral_v,
							ck_eva_salemev.valor_desc AS ck_eva_saleme_v,ck_eva_hojasv.valor_desc AS ck_eva_hojas_v,ck_eva_salsenv.valor_desc AS ck_eva_salsen_v,ck_eva_luces_emev.valor_desc AS ck_eva_luces_eme_v,ck_eva_sal_eme_cant,
							ck_eva_luces_funcv.valor_desc AS ck_eva_luces_func_v,ck_eva_rampav.valor_desc AS ck_eva_rampa_v,ck_eva_planosv.valor_desc AS ck_eva_planos_v,ck_eva_gralv.valor_desc AS ck_eva_gral_v,
							ck_inc_matafuegov.valor_desc AS ck_inc_matafuego_v,ck_inc_mataf_cargv.valor_desc AS ck_inc_mataf_carg_v,ck_inc_mataf_accv.valor_desc AS ck_inc_mataf_acc_v,ck_inc_mataf_chapv.valor_desc AS ck_inc_mataf_chap_v,ck_inc_gralv.valor_desc AS ck_inc_gral_v
							FROM ck_formulario 
							INNER JOIN ck_valoracion AS ck_esp_calefv ON ck_esp_calef = ck_esp_calefv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_calef_funv ON ck_esp_calef_fun = ck_esp_calef_funv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_electrogv ON ck_esp_electrog = ck_esp_electrogv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_electrog_funv ON ck_esp_electrog_fun = ck_esp_electrog_funv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_aacondv ON ck_esp_aacond = ck_esp_aacondv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_aacond_funv ON ck_esp_aacond_fun = ck_esp_aacond_funv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_ventiv ON ck_esp_venti = ck_esp_ventiv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_venti_funv ON ck_esp_venti_fun = ck_esp_venti_funv.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_fumigadov ON ck_esp_fumigado = ck_esp_fumigadov.valor_id 
							INNER JOIN ck_valoracion AS ck_esp_gralv ON ck_esp_gral = ck_esp_gralv.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_salemev ON ck_eva_saleme = ck_eva_salemev.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_hojasv ON ck_eva_hojas = ck_eva_hojasv.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_salsenv ON ck_eva_salsen = ck_eva_salsenv.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_luces_emev ON ck_eva_luces_eme = ck_eva_luces_emev.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_luces_funcv ON ck_eva_luces_func = ck_eva_luces_funcv.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_rampav ON ck_eva_rampa = ck_eva_rampav.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_planosv ON ck_eva_planos = ck_eva_planosv.valor_id 
							INNER JOIN ck_valoracion AS ck_eva_gralv ON ck_eva_gral = ck_eva_gralv.valor_id 
							INNER JOIN ck_valoracion AS ck_inc_matafuegov ON ck_inc_matafuego = ck_inc_matafuegov.valor_id 
							INNER JOIN ck_valoracion AS ck_inc_mataf_cargv ON ck_inc_mataf_carg = ck_inc_mataf_cargv.valor_id 
							INNER JOIN ck_valoracion AS ck_inc_mataf_accv ON ck_inc_mataf_acc = ck_inc_mataf_accv.valor_id 
							INNER JOIN ck_valoracion AS ck_inc_mataf_chapv ON ck_inc_mataf_chap = ck_inc_mataf_chapv.valor_id 
							INNER JOIN ck_valoracion AS ck_inc_gralv ON ck_inc_gral = ck_inc_gralv.valor_id 
							
							WHERE ck_formu_id = $_REQUEST[ck_formu_id]")
								or die("Problemas en el select:".mysqli_error($conexion));
		$row_segundo = mysqli_fetch_array($segundo);	
		
$tercero= mysqli_query ($conexion, "SELECT ck_formu_id,ck_mob_escr,ck_mob_arm,ck_mob_pc,ck_mob_impr,ck_mob_silla,ck_mob_silla_sufi,ck_mob_resultado,
							ck_prot_conos,ck_prot_chale,ck_prot_lint,ck_prot_antib,ck_prot_casco,ck_prot_bast,ck_prot_escudo,ck_prot_equipo,ck_prot_equipo_suf,ck_prot_gral,ck_prot_resultado,
							ck_aux_botiq,ck_aux_botiq_acc,ck_aux_resultado,ck_celda_hay,ck_celda_cant,ck_celda_dim,ck_celda_dete,ck_celda_estudio,ck_celda_inifuga,ck_celda_ilum,ck_celda_sani,
							ck_celda_agua,ck_celda_gral,ck_celda_resultado,ck_puntajefinal,ck_lp_carga,ck_valoracion,ck_confirmado,
							ck_mob_escrv.valor_desc AS ck_mob_escr_v,ck_mob_armv.valor_desc AS ck_mob_arm_v,ck_mob_pcv.valor_desc AS ck_mob_pc_v,ck_mob_imprv.valor_desc AS ck_mob_impr_v,
							ck_mob_sillav.valor_desc AS ck_mob_silla_v,ck_mob_silla_sufiv.valor_desc AS ck_mob_silla_sufi_v,ck_mob_escr_cant,ck_mob_arm_cant,ck_mob_pc_cant,ck_mob_impr_cant,ck_mob_silla_cant,
							ck_prot_conosv.valor_desc AS ck_prot_conos_v,ck_prot_chalev.valor_desc AS ck_prot_chale_v,ck_prot_lintv.valor_desc AS ck_prot_lint_v,ck_prot_antibv.valor_desc AS ck_prot_antib_v,
							ck_prot_cascov.valor_desc AS ck_prot_casco_v,ck_prot_bastv.valor_desc AS ck_prot_bast_v,ck_prot_escudov.valor_desc AS ck_prot_escudo_v,ck_prot_equipov.valor_desc AS ck_prot_equipo_v,
							ck_prot_equipo_sufv.valor_desc AS ck_prot_equipo_suf_v,ck_prot_gralv.valor_desc AS ck_prot_gral_v,ck_prot_conos_cant,ck_prot_chale_cant,ck_prot_lint_cant,ck_prot_antib_cant,ck_prot_casco_cant,ck_prot_bast_cant,ck_prot_escudo_cant,ck_prot_equipo_cant,
							ck_aux_botiqv.valor_desc AS ck_aux_botiq_v,ck_aux_botiq_accv.valor_desc AS ck_aux_botiq_acc_v,ck_aux_botiq_cant,
							ck_celda_hayv.valor_desc AS ck_celda_hay_v,ck_celda_estudiov.valor_desc AS ck_celda_estudio_v,ck_celda_inifugav.valor_desc AS ck_celda_inifuga_v,ck_celda_ilumv.valor_desc AS ck_celda_ilum_v,ck_celda_saniv.valor_desc AS ck_celda_sani_v,
							ck_celda_aguav.valor_desc AS ck_celda_agua_v,ck_celda_gralv.valor_desc AS ck_celda_gral_v
							FROM ck_formulario 
							INNER JOIN ck_valoracion AS ck_mob_escrv ON ck_mob_escr = ck_mob_escrv.valor_id 							
							INNER JOIN ck_valoracion AS ck_mob_armv ON ck_mob_arm = ck_mob_armv.valor_id 							
							INNER JOIN ck_valoracion AS ck_mob_pcv ON ck_mob_pc = ck_mob_pcv.valor_id 							
							INNER JOIN ck_valoracion AS ck_mob_imprv ON ck_mob_impr = ck_mob_imprv.valor_id 							
							INNER JOIN ck_valoracion AS ck_mob_sillav ON ck_mob_silla = ck_mob_sillav.valor_id 							
							INNER JOIN ck_valoracion AS ck_mob_silla_sufiv ON ck_mob_silla_sufi = ck_mob_silla_sufiv.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_conosv ON ck_prot_conos = ck_prot_conosv.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_chalev ON ck_prot_chale = ck_prot_chalev.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_lintv ON ck_prot_lint = ck_prot_lintv.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_antibv ON ck_prot_antib = ck_prot_antibv.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_cascov ON ck_prot_casco = ck_prot_cascov.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_bastv ON ck_prot_bast = ck_prot_bastv.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_escudov ON ck_prot_escudo = ck_prot_escudov.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_equipov ON ck_prot_equipo = ck_prot_equipov.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_equipo_sufv ON ck_prot_equipo_suf = ck_prot_equipo_sufv.valor_id 							
							INNER JOIN ck_valoracion AS ck_prot_gralv ON ck_prot_gral = ck_prot_gralv.valor_id 							
							INNER JOIN ck_valoracion AS ck_aux_botiqv ON ck_aux_botiq = ck_aux_botiqv.valor_id 							
							INNER JOIN ck_valoracion AS ck_aux_botiq_accv ON ck_aux_botiq_acc = ck_aux_botiq_accv.valor_id 	
							INNER JOIN ck_valoracion AS ck_celda_hayv ON ck_celda_hay = ck_celda_hayv.valor_id 	
							INNER JOIN ck_valoracion AS ck_celda_estudiov ON ck_celda_estudio = ck_celda_estudiov.valor_id 							
							INNER JOIN ck_valoracion AS ck_celda_inifugav ON ck_celda_inifuga = ck_celda_inifugav.valor_id 							
							INNER JOIN ck_valoracion AS ck_celda_ilumv ON ck_celda_ilum = ck_celda_ilumv.valor_id 							
							INNER JOIN ck_valoracion AS ck_celda_saniv ON ck_celda_sani = ck_celda_saniv.valor_id 							
							INNER JOIN ck_valoracion AS ck_celda_aguav ON ck_celda_agua = ck_celda_aguav.valor_id 							
							INNER JOIN ck_valoracion AS ck_celda_gralv ON ck_celda_gral = ck_celda_gralv.valor_id 							
							WHERE ck_formu_id = $_REQUEST[ck_formu_id]")
								or die("Problemas en el select:".mysqli_error($conexion));
		$row_tercero = mysqli_fetch_array($tercero);									

		
if ($row_datosform123['ck_edi_esalquilado'] == A) {
	$condicion_ed = Alquilado;
}elseif ($row_datosform123['ck_edi_esalquilado'] == P){
	$condicion_ed = Propio;	
}elseif ($row_datosform123['ck_edi_esalquilado'] == C){
	$condicion_ed = Comodato;
}

$cuadro = 'Malo: <input type="checkbox"> Regular: <input type="checkbox"> Bueno: <input type="checkbox"> Muy Bueno: <input type="checkbox">';
$cuadro2 = 'Si: <input type="checkbox"> No: <input type="checkbox">';

$fechaordenada = DATE('d-m-Y',strtotime($row_datosform123['ck_fecha']));
if ($row_datosform123['ck_edi_paredes'] == 7) { $ck_edi_paredes_p = $cuadro; } else { $ck_edi_paredes_p = $row_datosform123['ck_edi_paredes_v']; }
if ($row_datosform123['ck_edi_pisos'] == 7) { $ck_edi_pisos_p = $cuadro; } else { $ck_edi_pisos_p = $row_datosform123['ck_edi_pisos_v']; }
if ($row_datosform123['ck_edi_techos'] == 7) { $ck_edi_techos_p = $cuadro; } else { $ck_edi_techos_p = $row_datosform123['ck_edi_techos_v']; }
if ($row_datosform123['ck_edi_cielorraso'] == 7) { $ck_edi_cielorraso_p = $cuadro; } else { $ck_edi_cielorraso_p = $row_datosform123['ck_edi_cielorraso_v']; }
	
if ($row_datosform123['ck_elec_tabl'] == 7) { $ck_elec_tabl_p = $cuadro2; } else { $ck_elec_tabl_p = $row_datosform123['ck_elec_tabl_v']; }
if ($row_datosform123['ck_elec_simb'] == 7) { $ck_elec_simb_p = $cuadro2; } else { $ck_elec_simb_p = $row_datosform123['ck_elec_simb_v']; }
if ($row_datosform123['ck_elec_difer'] == 7) { $ck_elec_difer_p = $cuadro2; } else { $ck_elec_difer_p = $row_datosform123['ck_elec_difer_v']; }
if ($row_datosform123['ck_elec_termo'] == 7) { $ck_elec_termo_p = $cuadro2; } else { $ck_elec_termo_p = $row_datosform123['ck_elec_termo_v']; }
if ($row_datosform123['ck_elec_tierra'] == 7) { $ck_elec_tierra_p = $cuadro2; } else { $ck_elec_tierra_p = $row_datosform123['ck_elec_tierra_v']; }
if ($row_datosform123['ck_elec_emb'] == 7) { $ck_elec_emb_p = $cuadro2; } else { $ck_elec_emb_p = $row_datosform123['ck_elec_emb_v']; }
if ($row_datosform123['ck_elec_gral'] == 7) { $ck_elec_gral_p = $cuadro; } else { $ck_elec_gral_p = $row_datosform123['ck_elec_gral_v']; }

if ($row_datosform3['ck_sani_agua'] == 7) { $ck_sani_agua_p = $cuadro2; } else { $ck_sani_agua_p = $row_datosform3['ck_sani_agua_v']; }
if ($row_datosform3['ck_sani_sani'] == 7) { $ck_sani_sani_p = $cuadro2; } else { $ck_sani_sani_p = $row_datosform3['ck_sani_sani_v']; }
if ($row_datosform3['ck_sani_pol'] == 7) { $ck_sani_pol_p = $cuadro2; } else { $ck_sani_pol_p = $row_datosform3['ck_sani_pol_v']; }
if ($row_datosform3['ck_sani_pub'] == 7) { $ck_sani_pub_p = $cuadro2; } else { $ck_sani_pub_p = $row_datosform3['ck_sani_pub_v']; }
if ($row_datosform3['ck_sani_disc'] == 7) { $ck_sani_disc_p = $cuadro2; } else { $ck_sani_disc_p = $row_datosform3['ck_sani_disc_v']; }
if ($row_datosform3['ck_sani_gral'] == 7) { $ck_sani_gral_p = $cuadro; } else { $ck_sani_gral_p = $row_datosform3['ck_sani_gral_v']; }

if ($row_segundo['ck_esp_calef'] == 7) { $ck_esp_calef_p = $cuadro2; } else { $ck_esp_calef_p = $row_segundo['ck_esp_calef_v']; }
if ($row_segundo['ck_esp_calef_fun'] == 7) { $ck_esp_calef_fun_p = $cuadro; } else { $ck_esp_calef_fun_p = $row_segundo['ck_esp_calef_fun_v']; }
if ($row_segundo['ck_esp_electrog'] == 7) { $ck_esp_electrog_p = $cuadro2; } else { $ck_esp_electrog_p = $row_segundo['ck_esp_electrog_v']; }
if ($row_segundo['ck_esp_electrog_fun'] == 7) { $ck_esp_electrog_fun_p = $cuadro; } else { $ck_esp_electrog_fun_p = $row_segundo['ck_esp_electrog_fun_v']; }
if ($row_segundo['ck_esp_aacond'] == 7) { $ck_esp_aacond_p = $cuadro2; } else { $ck_esp_aacond_p = $row_segundo['ck_esp_aacond_v']; }
if ($row_segundo['ck_esp_aacond_fun'] == 7) { $ck_esp_aacond_fun_p = $cuadro; } else { $ck_esp_aacond_fun_p = $row_segundo['ck_esp_aacond_fun_v']; }
if ($row_segundo['ck_esp_venti'] == 7) { $ck_esp_venti_p = $cuadro2; } else { $ck_esp_venti_p = $row_segundo['ck_esp_venti_v']; }
if ($row_segundo['ck_esp_venti_fun'] == 7) { $ck_esp_venti_fun_p = $cuadro; } else { $ck_esp_venti_fun_p = $row_segundo['ck_esp_venti_fun_v']; }
if ($row_segundo['ck_esp_fumigado'] == 7) { $ck_esp_fumigado_p = $cuadro2; } else { $ck_esp_fumigado_p = $row_segundo['ck_esp_fumigado_v']; }
if ($row_segundo['ck_esp_gral'] == 7) { $ck_esp_gral_p = $cuadro; } else { $ck_esp_gral_p = $row_segundo['ck_esp_gral_v']; }

if ($row_segundo['ck_eva_saleme'] == 7) { $ck_eva_saleme_p = $cuadro2; } else { $ck_eva_saleme_p = $row_segundo['ck_eva_saleme_v']; }
if ($row_segundo['ck_eva_hojas'] == 7) { $ck_eva_hojas_p = $cuadro2; } else { $ck_eva_hojas_p = $row_segundo['ck_eva_hojas_v']; }
if ($row_segundo['ck_eva_salsen'] == 7) { $ck_eva_salsen_p = $cuadro2; } else { $ck_eva_salsen_p = $row_segundo['ck_eva_salsen_v']; }
if ($row_segundo['ck_eva_luces_eme'] == 7) { $ck_eva_luces_eme_p = $cuadro2; } else { $ck_eva_luces_eme_p = $row_segundo['ck_eva_luces_eme_v']; }
if ($row_segundo['ck_eva_luces_func'] == 7) { $ck_eva_luces_func_p = $cuadro2; } else { $ck_eva_luces_func_p = $row_segundo['ck_eva_luces_func_v']; }
if ($row_segundo['ck_eva_rampa'] == 7) { $ck_eva_rampa_p = $cuadro2; } else { $ck_eva_rampa_p = $row_segundo['ck_eva_rampa_v']; }
if ($row_segundo['ck_eva_planos'] == 7) { $ck_eva_planos_p = $cuadro2; } else { $ck_eva_planos_p = $row_segundo['ck_eva_planos_v']; }
if ($row_segundo['ck_eva_gral'] == 7) { $ck_eva_gral_p = $cuadro; } else { $ck_eva_gral_p = $row_segundo['ck_eva_gral_v']; }

if ($row_segundo['ck_inc_matafuego'] == 7) { $ck_inc_matafuego_p = $cuadro2; } else { $ck_inc_matafuego_p = $row_segundo['ck_inc_matafuego_v']; }
if ($row_segundo['ck_inc_mataf_carg'] == 7) { $ck_inc_mataf_carg_p = $cuadro2; } else { $ck_inc_mataf_carg_p = $row_segundo['ck_inc_mataf_carg_v']; }
if ($row_segundo['ck_inc_mataf_acc'] == 7) { $ck_inc_mataf_acc_p = $cuadro2; } else { $ck_inc_mataf_acc_p = $row_segundo['ck_inc_mataf_acc_v']; }
if ($row_segundo['ck_inc_mataf_chap'] == 7) { $ck_inc_mataf_chap_p = $cuadro2; } else { $ck_inc_mataf_chap_p = $row_segundo['ck_inc_mataf_chap_v']; }
if ($row_segundo['ck_inc_gral'] == 7) { $ck_inc_gral_p = $cuadro; } else { $ck_inc_gral_p = $row_segundo['ck_inc_gral_v']; }

if ($row_tercero['ck_mob_escr'] == 7) { $ck_mob_escr_p = $cuadro; } else { $ck_mob_escr_p = $row_tercero['ck_mob_escr_v']; }
if ($row_tercero['ck_mob_arm'] == 7) { $ck_mob_arm_p = $cuadro; } else { $ck_mob_arm_p = $row_tercero['ck_mob_arm_v']; }
if ($row_tercero['ck_mob_pc'] == 7) { $ck_mob_pc_p = $cuadro; } else { $ck_mob_pc_p = $row_tercero['ck_mob_pc_v']; }
if ($row_tercero['ck_mob_impr'] == 7) { $ck_mob_impr_p = $cuadro; } else { $ck_mob_impr_p = $row_tercero['ck_mob_impr_v']; }
if ($row_tercero['ck_mob_silla'] == 7) { $ck_mob_silla_p = $cuadro; } else { $ck_mob_silla_p = $row_tercero['ck_mob_impr_v']; }
if ($row_tercero['ck_mob_silla_sufi'] == 7) { $ck_mob_silla_sufi_p = $cuadro2; } else { $ck_mob_silla_sufi_p = $row_tercero['ck_mob_silla_sufi_v']; }

if ($row_tercero['ck_prot_conos'] == 7) { $ck_prot_conos_p = $cuadro2; } else { $ck_prot_conos_p = $row_tercero['ck_prot_conos_v']; }
if ($row_tercero['ck_prot_chale'] == 7) { $ck_prot_chale_p = $cuadro2; } else { $ck_prot_chale_p = $row_tercero['ck_prot_chale_v']; }
if ($row_tercero['ck_prot_lint'] == 7) { $ck_prot_lint_p = $cuadro2; } else { $ck_prot_lint_p = $row_tercero['ck_prot_lint_v']; }
if ($row_tercero['ck_prot_antib'] == 7) { $ck_prot_antib_p = $cuadro2; } else { $ck_prot_antib_p = $row_tercero['ck_prot_antib_v']; }
if ($row_tercero['ck_prot_casco'] == 7) { $ck_prot_casco_p = $cuadro2; } else { $ck_prot_casco_p = $row_tercero['ck_prot_casco_v']; }
if ($row_tercero['ck_prot_bast'] == 7) { $ck_prot_bast_p = $cuadro2; } else { $ck_prot_bast_p = $row_tercero['ck_prot_bast_v']; }
if ($row_tercero['ck_prot_escudo'] == 7) { $ck_prot_escudo_p = $cuadro2; } else { $ck_prot_escudo_p = $row_tercero['ck_prot_escudo_v']; }
if ($row_tercero['ck_prot_equipo'] == 7) { $ck_prot_equipo_p = $cuadro2; } else { $ck_prot_equipo_p = $row_tercero['ck_prot_equipo_v']; }
if ($row_tercero['ck_prot_equipo_suf'] == 7) { $ck_prot_equipo_suf_p = $cuadro2; } else { $ck_prot_equipo_suf_p = $row_tercero['ck_prot_equipo_suf_v']; }
if ($row_tercero['ck_prot_gral'] == 7) { $ck_prot_gral_p = $cuadro; } else { $ck_prot_gral_p = $row_tercero['ck_prot_gral_v']; }

if ($row_tercero['ck_aux_botiq'] == 7) { $ck_aux_botiq_p = $cuadro2; } else { $ck_aux_botiq_p = $row_tercero['ck_aux_botiq_v']; }
if ($row_tercero['ck_aux_botiq_acc'] == 7) { $ck_aux_botiq_acc_p = $cuadro2; } else { $ck_aux_botiq_acc_p = $row_tercero['ck_aux_botiq_acc_v']; }

if ($row_tercero['ck_celda_hay'] == 7) { $ck_celda_hay_p = $cuadro2; } else { $ck_celda_hay_p = $row_tercero['ck_celda_hay_v']; }
if ($row_tercero['ck_celda_estudio'] == 7) { $ck_celda_estudio_p = $cuadro2; } else { $ck_celda_estudio_p = $row_tercero['ck_celda_estudio_v']; }
if ($row_tercero['ck_celda_inifuga'] == 7) { $ck_celda_inifuga_p = $cuadro2; } else { $ck_celda_inifuga_p = $row_tercero['ck_celda_inifuga_v']; }
if ($row_tercero['ck_celda_ilum'] == 7) { $ck_celda_ilum_p = $cuadro2; } else { $ck_celda_ilum_p = $row_tercero['ck_celda_ilum_v']; }
if ($row_tercero['ck_celda_sani'] == 7) { $ck_celda_sani_p = $cuadro2; } else { $ck_celda_sani_p = $row_tercero['ck_celda_sani_v']; }
if ($row_tercero['ck_celda_agua'] == 7) { $ck_celda_agua_p = $cuadro2; } else { $ck_celda_agua_p = $row_tercero['ck_celda_agua_v']; }
if ($row_tercero['ck_celda_gral'] == 7) { $ck_celda_gral_p = $cuadro2; } else { $ck_celda_gral_p = $row_tercero['ck_celda_gral_v']; }


$html ='

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borrador Checklist</title>
	<style type="text/css">
		body {
			font-family:Arial;
			font-size:0.9em;
		}
		.head1{
			padding-top:10px;
			margin-left:33px;
			text-decoration:underline;
			line-height:150%
		}
		.head2{
			text-align:center;
			text-decoration:underline;
			font-weight:bold;
			font-size:0.8em;
		}
		.parrafo{
			white-space:pre-line;
			line-height:154%;
			text-align:justify;
		}
	</style>
</head>

<body>
	<div class="head1"><img src="reportes/imagenes/escudopoliciasalta.jpg" width="32" height="39" /></div>
	<div style="padding-top:8px;margin-left:4px;">POLICIA DE SALTA</div>
	<div style="padding-left:8px;">
		
		<p class="head2" style="font-size:12px">(BORRADOR) FORMULARIO CHECKLIST DE DEPENDENCIAS Nº '.$row_datosform123['ck_formu_id'].'</p>
		<table border=0 style="font-size:0.9em;">
			<tr>
				<td width=50%>Dependencia:  '.utf8_encode($row_datosform123['GEN_Organismos_Descripcion']).'</td>
				<td width=50%></td>
				<td>Fecha:  '.$fechaordenada.'</td>
			<tr>	
			<tr>
				<td>Jefe de Dependencia: (L.P.'.$row_datosform123['ck_legajo_jn'].") ".utf8_encode($row_datosform123['RRHH_TipoGrados_Desc']." ".$row_datosform3['RRHH_ApeNom']).'</td>
			</tr>
		</table>
		
		<p class="head2">1° MODULO - CARACTERISTICAS CONSTRUCTIVAS DEL EDIFICIO</p>
		
		<table border=0  width=100% style="font-size:0.8em;" >
			
			<tr>
				<td width=10%>a) Número de plantas: </td>
				<td width=10%>'.$row_datosform123['ck_edi_plantas'].'</td>
				<td width=20%></td>
				<td width=15%>b) Antiguedad del edificio: </td></td>
				<td width=10%>'.$row_datosform123['ck_edi_antiguedad']."  años".'</td>				
			</tr>			
			<tr>
				<td width=15%>c) Dimensiones del terreno: </td>
				<td width=10%>'.$row_datosform123['ck_edi_dimensiones']."  Mts2".'</td>
				<td width=5%></td>
				<td width=15%>d) El edificio es: </div>
				<td width=10%>'.$condicion_ed.'</td>				
			</tr>
		</table>
		<table border=0 width=100% style="font-size:0.8em;">
			<tr>
				<td width=25%>e) Personas que usan las instalaciones:
				<td width=18%>Personal policial: '.$row_datosform123['ck_edi_cantpol'].'</div>
				<td width=38%>Personal civil: '.$row_datosform123['ck_edi_cantcivil'].'</div>		
			</tr>
		</table>
		<table border=0 width=100%>
		
			<tr>
				<td width=40% align="center">CONDICIONES EDILICIAS</td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=50%>1.1 Paredes (Material: '.utf8_encode($row_datosform123['ck_edi_paredes_material']).' ) </td>		
				<td width=15% align="center">'.utf8_encode($ck_edi_paredes_p).'</div>
				<td width=15% align="center" rowspan=5>'.utf8_encode($row_datosform123['ck_edi_resultado']).'</div>				
			</tr>
			<tr>
				<td width=90%>1.2 Pisos (Material: '.utf8_encode($row_datosform123['ck_edi_pisos_material']).' ) </td>	
				<td width=15% align="center">'.utf8_encode($ck_edi_pisos_p).'</div>
							
			</tr>
			<tr>
				<td width=90%>1.3 Techos (Material: '.utf8_encode($row_datosform123['ck_edi_techo_material']).' ) </td>	
				<td width=15% align="center">'.utf8_encode($ck_edi_techos_p).'</div>
							
			</tr>
			<tr>
				<td width=90%>1.4 Cielorrasos (Material: '.utf8_encode($row_datosform123['ck_edi_cielo_material']).' ) </td>	
				<td width=15% align="center">'.utf8_encode($ck_edi_cielorraso_p).'</div>				
			</tr>
		</table>
		<p class="head2" >2° MODULO - INSTALACIONES ELECTRICAS</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>2.1 Posee tablero eléctrico</td>
				<td width=15% align="center">'.$ck_elec_tabl_p.'</div>
				<td width=15% align="center" rowspan=7>'.$row_datosform123['ck_elec_resultado'].'</div>				
			</tr>
			<tr>
				<td width=90%>2.2- Posee el tablero el "Simbolo de riesgo eléctrico"</td>
				<td width=15% align="center">'.$ck_elec_simb_p.'</div>							
			</tr>
			<tr>
				<td width=90%>2.3- El tablero cuenta con "Interruptor diferencial"</td>
				<td width=15% align="center">'.$ck_elec_difer_p.'</div>							
			</tr>
			<tr>
				<td width=90%>2.4- El tablero cuenta con "Interruptor termomagnético"</td>
				<td width=15% align="center">'.$ck_elec_termo_p.'</div>				
			</tr>
			<tr>
				<td width=90%>2.5- Las Instalaciones Electrica posee "Sistema de puesta a tierra"</td>
				<td width=15% align="center">'.$ck_elec_tierra_p.'</div>							
			</tr>
			<tr>
				<td width=90%>2.6- El circuito eléctrico se encuentra embutido en su totalidad</td>
				<td width=15% align="center">'.$ck_elec_emb_p.'</div>							
			</tr>
			<tr>
				<td width=90%>2.7- Estado general de los componentes del circuito eléctrico</td>
				<td width=15% align="center">'.$ck_elec_gral_p.'</div>				
			</tr>
		</table>
		<p class="head2">3° MODULO - INSTALACIONES SANITARIAS</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>3.1- Disponde de agua potable</td>
				<td width=15% align="center">'.$ck_sani_agua_p.'</div>
				<td width=15% align="center" rowspan=6>'.$row_datosform123['ck_sani_resultado'].'</div>				
			</tr>
			<tr>
				<td width=90%>3.2- Dispone de sanitarios</td>
				<td width=15% align="center">'.$ck_sani_sani_p.'</div>							
			</tr>
			<tr>
				<td width=90%>3.3- Dispone de sanitarios para uso del personal únicamente</td>
				<td width=15% align="center">'.$ck_sani_pol_p.'</div>							
			</tr>
			<tr>
				<td width=90%>3.4- Dispone de sanitarios para el uso del público únicamente</td>
				<td width=15% align="center">'.$ck_sani_pub_p.'</div>				
			</tr>
			<tr>
				<td width=90%>3.5- Dispone de sanitarios para el uso de personas con discapacidad</td>
				<td width=15% align="center">'.$ck_sani_disc_p.'</div>							
			</tr>
			<tr>
				<td width=90%>3.6- Estado general de los sanitarios</td>
				<td width=15% align="center">'.$ck_sani_gral_p.'</div>							
			</tr>
		</table>

		<p class="head2">4° MODULO - INSTALACIONES ESPECIALES</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>4.1- Posee calefacción a gas natural, eléctrico, Etc.</td>
				<td width=15% align="center">'.$ck_esp_calef_p.'</div>
				<td width=15% align="center" rowspan=10>'.$row_segundo['ck_esp_resultado'].'</div>				
			</tr>			
			<tr>
				<td width=90%>4.2- Estado general de los equipos de calefacción</td>
				<td width=15% align="center">'.$ck_esp_calef_fun_p.'</div>							
			</tr>
			<tr>
				<td width=90%>4.3- Posee grupo electrógeno</td>
				<td width=15% align="center">'.$ck_esp_electrog_p.'</div>							
			</tr>
			<tr>
				<td width=90%>4.4- Estado general del grupo electrógeno</td>
				<td width=15% align="center">'.$ck_esp_electrog_fun_p.'</div>				
			</tr>
			<tr>
				<td width=90%>4.5- Posee aire acondicionado</td>
				<td width=15% align="center">'.$ck_esp_aacond_p.'</div>							
			</tr>
			<tr>
				<td width=90%>4.6- Estado general del aire acondicionado</td>
				<td width=15% align="center">'.$ck_esp_aacond_fun_p.'</div>							
			</tr>
			<tr>
				<td width=90%>4.7- Posee ventiladores</td>
				<td width=15% align="center">'.$ck_esp_venti_p.'</div>							
			</tr>
			<tr>
				<td width=90%>4.8- Estado general de los ventiladores</td>
				<td width=15% align="center">'.$ck_esp_venti_fun_p.'</div>				
			</tr>
			<tr>
				<td width=90%>4.9- El edificio se encuentra fumigado</td>
				<td width=15% align="center">'.$ck_esp_fumigado_p.'</div>							
			</tr>
			<tr>
				<td width=90%>4.10- Estado general de los equipos o elementos descriptos</td>
				<td width=15% align="center">'.$ck_esp_gral_p.'</div>							
			</tr>			
		</table>
		<p class="head2">5° MODULO - INSTALACIONES DE EVACUACIÓN</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>5.1- Dispone de salidas de emergencia</td>
				<td width=15% align="center">'.$ck_eva_saleme_p.'</div>
				<td width=15% align="center" rowspan=11>'.$row_segundo['ck_eva_resultado'].'</div>				
			</tr>
			<tr>
				<td width=90%>5.1.1- Cantidad de salidas de emergencia</td>
				<td width=15% align="center">'.$row_segundo['ck_eva_sal_eme_cant'].'</div>	
			</tr>
			<tr>
				<td width=90%>*- Ancho de la salida de emergencia en Mts.: </td>									
				<td width=15% align="center">'.$row_segundo['ck_eva_salida_ancho'].'</div>
			</tr>	
			<tr>
				<td width=90%>5.2- Las puerta de salida al exterior tienen apertura hacia afuera</td>
				<td width=15% align="center">'.$ck_eva_hojas_p.'</div>							
			</tr>
			<tr>
				<td width=90%>5.3- Salida de emergencia señalizada</td>
				<td width=15% align="center">'.$ck_eva_salsen_p.'</div>							
			</tr>
			<tr>
				<td width=90%>5.4- Posee luces de emergencia</td>
				<td width=15% align="center">'.$ck_eva_luces_eme_p.'</div>				
			</tr>
			<tr>
				<td width=90%>5.4.1- Cantidad de luces de emergencia: </td>
				<td width=15% align="center">'.$row_segundo['ck_eva_luces_cant'].'</div>							
			</tr>
			
			<tr>
				<td width=90%>5.5- Funcionan todas las luces de emergencia</td>
				<td width=15% align="center">'.$ck_eva_luces_func_p.'</div>							
			</tr>
			<tr>
				<td width=90%>5.6- Posee rampa P/personas con discapacidad motriz</td>
				<td width=15% align="center">'.$ck_eva_rampa_p.'</div>							
			</tr>
		
			<tr>
				<td width=90%>5.7- Posee plano de evacuación</td>
				<td width=15% align="center">'.$ck_eva_planos_p.'</div>				
			</tr>
			<tr>
				<td width=90%>5.8- Estado general de las instalaciones descriptas</td>
				<td width=15% align="center">'.$ck_eva_gral_p.'</div>							
			</tr>
			<tr>
				<td width=90%>*- Si tiene escalera el edificio, ancho en Mts.: </td>									
				<td width=15% align="center">'.$row_segundo['ck_eva_esc_ancho'].'</div>
			</tr>
			
		</table><br><br>
		
		<p class="head2">6° MODULO - INSTALACIONES DE PROTECCIÓN CONTRA INCENDIO</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>6.1- Posee matafuegos</td>
				<td width=15% align="center">'.$ck_inc_matafuego_p.'</div>
				<td width=15% align="center" rowspan=6>'.$row_segundo['ck_inc_resultado'].'</div>				
			</tr>
			<tr >
				<td width=90% >6.1.1. Cantidad de matafuegos: </td>
				<td width=15% align="center">'.$row_segundo['ck_inc_mataf_cant'].'</div>		
			</tr>
			<tr>
				<td width=90%>6.2- Los matafuegos se encuentran cargados</td>
				<td width=15% align="center">'.$ck_inc_mataf_carg_p.'</div>							
			</tr>
			<tr>
				<td width=90%>6.3- Los matafuegos se encuentran colgados, visible y accesible</td>
				<td width=15% align="center">'.$ck_inc_mataf_acc_p.'</div>				
			</tr>
			<tr>
				<td width=90%>6.4- Posee chapa baliza los matafuegos</td>
				<td width=15% align="center">'.$ck_inc_mataf_chap_p.'</div>							
			</tr>
			<tr>
				<td width=90%>6.5- Estado general de los extintores</td>
				<td width=15% align="center">'.$ck_inc_gral_p.'</div>							
			</tr>			
		</table>	
		<p class="head2">7° MODULO - MOBILIARIOS</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>7.1- Escritorios (Cantidad: '.$row_tercero['ck_mob_escr_cant'].' )</td>
				<td width=15% align="center">'.$ck_mob_escr_p.'</div>
				<td width=15% align="center" rowspan=6>'.$row_tercero['ck_mob_resultado'].'</div>				
			</tr>
			<tr>
				<td width=90%>7.2- Armarios (Cantidad: '.$row_tercero['ck_mob_arm_cant'].' )</td>
				<td width=15% align="center">'.$ck_mob_arm_p.'</div>							
			</tr>
			<tr>
				<td width=90%>7.3- Computadoras (Cantidad: '.$row_tercero['ck_mob_pc_cant'].' )</td>
				<td width=15% align="center">'.$ck_mob_pc_p.'</div>				
			</tr>
			<tr>
				<td width=90%>7.4- Impresoras (Cantidad: '.$row_tercero['ck_mob_impr_cant'].' )</td>
				<td width=15% align="center">'.$ck_mob_impr_p.'</div>							
			</tr>
			<tr>
				<td width=90%>7.5- Sillas (Cantidad: '.$row_tercero['ck_mob_silla_cant'].' )</td>
				<td width=15% align="center">'.$ck_mob_silla_p.'</div>							
			</tr>
			<tr>
				<td width=90%>7.6- Son suficientes para el trabajo diario</td>
				<td width=15% align="center">'.$ck_mob_silla_sufi_p.'</div>							
			</tr>			
		</table>
		<p class="head2">8° MODULO - ELEMENTOS DE TRABAJO Y PROTECCIÓN</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>8.1- Posee conos reflectivos (Cantidad: '.$row_tercero['ck_prot_conos_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_conos_p.'</div>
				<td width=15% align="center" rowspan=10>'.$row_tercero['ck_prot_resultado'].'</div>				
			</tr>
			<tr>
				<td width=90%>8.2- Posee chalecos reflectivos (Cantidad: '.$row_tercero['ck_prot_chale_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_chale_p.'</div>							
			</tr>
			<tr>
				<td width=90%>8.3- Posee linternas (Cantidad: '.$row_tercero['ck_prot_lint_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_lint_p.'</div>				
			</tr>
			<tr>
				<td width=90%>8.4- Posee chalecos antibalas (Cantidad: '.$row_tercero['ck_prot_antib_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_antib_p.'</div>							
			</tr>
			<tr>
				<td width=90%>8.5- Posee casco de protección (Cantidad: '.$row_tercero['ck_prot_casco_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_casco_p.'</div>							
			</tr>
			<tr>
				<td width=90%>8.6- Posee bastones o varitas (Cantidad: '.$row_tercero['ck_prot_bast_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_bast_p.'</div>							
			</tr>			
			<tr>
				<td width=90%>8.7- Posee escudo de protección (Cantidad: '.$row_tercero['ck_prot_escudo_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_escudo_p.'</div>				
			</tr>
			<tr>
				<td width=90%>8.8- Posee equipo de protección individual(codera, rodillera, muslera,Etc) (Cantidad: '.$row_tercero['ck_prot_equipo_cant'].' )</td>
				<td width=15% align="center">'.$ck_prot_equipo_p.'</div>							
			</tr>
			<tr>
				<td width=90%>8.9- Los elementos son suficientes para cubrir las necesidades de los efectivos de turno (El más numeroso)</td>
				<td width=15% align="center">'.$ck_prot_equipo_suf_p.'</div>							
			</tr>
			<tr>
				<td width=90%>8.10- Estado general de los elementos	</td>
				<td width=15% align="center">'.$ck_prot_gral_p.'</div>							
			</tr>	
		</table>
		<p class="head2">9° MODULO - ELEMENTOS DE PRIMEROS AUXILIOS</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>9.1- Posee botiquín de primeros auxilios (Cantidad: '.$row_tercero['ck_aux_botiq_cant'].' )</td>
				<td width=15% align="center">'.$ck_aux_botiq_p.'</div>
				<td width=15% align="center" rowspan=2>'.$row_tercero['ck_aux_resultado'].'</div>				
			</tr>
			
			<tr>
				<td width=90%>9.2- Esta disponible, equipado y accesible</td>
				<td width=15% align="center">'.$ck_aux_botiq_acc_p.'</div>							
			</tr>
		</table>	
		<p class="head2">10° MODULO -CONDICIONES EDILICIAS PARA EL ALOJAMIENTO DE DETENIDOS (Completar si Posee)</p>
		<table border=0 width=100%>
			<tr>
				<td width=40% align="center"></td>
				<td width=45% align="center">Valoración</td>
				<td width=15% align="center">RESULTADO</td>				
			</tr>
			<tr>
				<td width=90%>*- Posee celdas para alojar detenidos</td>
				<td width=15% align="center">'.$ck_celda_hay_p.'</div>
				<td width=15% align="center" rowspan=10>'.$row_tercero['ck_celda_resultado'].'</div>				
			</tr>
			<tr>
				<td width=90%>*- Número de celdas: </td>	
				<td width=15% align="center">'.$row_tercero['ck_celda_cant'].'</div>			
			</tr>
			
			<tr>
				<td width=90%>*- Dimensiones de la celda (Mts2): </td>					
				<td width=15% align="center">'.$row_tercero['ck_celda_dim'].'</div>	
			</tr>
			<tr>
				<td width=90%>*- Cantidad de detenidos en la fecha: </td>				
				<td width=15% align="center">'.$row_tercero['ck_celda_dete'].'</div>	
			</tr>
			<tr>
				<td width=90%>10.1- Posee estudio por profesional competente de la cantidad de detenidos que puede alojar una celda</td>
				<td width=15% align="center">'.$ck_celda_estudio_p.'</div>							
			</tr>
			<tr>
				<td width=90%>10.2- Posee colchones y almohadas inífugas</td>
				<td width=15% align="center">'.$ck_celda_inifuga_p.'</div>							
			</tr>			
			<tr>
				<td width=90%>10.3- Posee iluminación artificial</td>
				<td width=15% align="center">'.$ck_celda_ilum_p.'</div>				
			</tr>
			<tr>
				<td width=90%>10.4- Posee instalaciones sanitarias</td>
				<td width=15% align="center">'.$ck_celda_sani_p.'</div>							
			</tr>
			<tr>
				<td width=90%>10.5- Posee servicio de agua potable</td>
				<td width=15% align="center">'.$ck_celda_agua_p.'</div>				
			</tr>
			<tr>
				<td width=90%>10.6- Estado general de las celdas</td>
				<td width=15% align="center">'.$ck_celda_gral_p.'</div>							
			</tr>
		</table><br>
		
		<table border=1 width=100%>
			<tr>
				<td width=100% colspan=5 align="center"> TABLA DE VALORACIÓN </td>
			<tr>
			<tr>
				<td align="center" bgcolor= "#797D7F">MUY MAL ESTADO</td>  
				<td align="center" bgcolor= "#BDC3C7">MAL ESTADO</td>
				<td align="center" bgcolor= "#CACFD2">ESTADO REGULAR</td>
				<td align="center" bgcolor= "#E5E7E9">BUEN ESTADO</td>
				<td align="center" bgcolor= "#F8F9F9">MUY BUEN ESTADO</td>							
			</tr>
			<tr>
				<td align="center" bgcolor= "#797D7F"> 0 < 20 </td>
				<td align="center" bgcolor= "#BDC3C7"> 20 < 40 </td>
				<td align="center" bgcolor= "#CACFD2"> 40 < 60 </td>
				<td align="center" bgcolor= "#E5E7E9"> 60 < 80 </td>
				<td align="center" bgcolor= "#F8F9F9"> 80 < 100 </td>	
			</tr>
		</table>
		<p class="head2" style="font-size:12px">RESULTADO PARCIAL</p>
		
		<table border=1 width="100%" style="font-size:14px">
			<tr>
				<td width=45% align="center" rowspan=3> PROMEDIO PARCIAL </td>
				<td height=100% align="center" style="font-size:18px">'.$row_tercero['ck_puntajefinal'].'</td>				
			<tr>
			
			<tr>
			
				<td align="center" bgcolor= "#F8F9F9">'.$row_tercero['ck_valoracion'].'</td>	
			</tr>
		</table>
	</div>
</body>
</html>	
';


$mpdf = new mPDF('c', 'A4','', '',20,15,10,5 );
$mpdf->setAutoBottomMargin = 'stretch';

$mpdf -> writeHTML($html);

$mpdf -> Output ('Certrab'.$_REQUEST['RRHH_DatosPers_Legajo'].'.pdf', 'I');
?>
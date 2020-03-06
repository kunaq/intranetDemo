<?php
require_once "conexion.php";
class ModeloContacto{
	/*=============================================
	MOSTRAR CONTACTO
	=============================================*/
	static public function mdlMostrarContacto($item1,$valor1,$entrada,$tabla1,$tabla2){
		$db = new Conexion();
		if($entrada == 'vtnCntoAgrupCte'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_cliente,$tabla2.dsc_razon_social FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.cod_cliente=$tabla2.cod_cliente GROUP BY $tabla1.cod_cliente,$tabla2.dsc_razon_social");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'vntCntoXCte'){
			$sql = $db->consulta("SELECT $tabla1.cod_contacto,$tabla1.fch_atencion,vtama_cliente.dsc_razon_social,vtama_canal_contacto.dsc_canal_contacto,vtama_tipo_contacto.dsc_tipo_contacto,vtama_estado_contacto.dsc_estado_contacto,$tabla1.fch_registro_contacto,vtama_estado_contacto.flg_atendido FROM $tabla1 INNER JOIN vtama_cliente ON vtama_cliente.cod_cliente = $tabla1.cod_cliente INNER JOIN vtama_canal_contacto ON vtama_canal_contacto.cod_canal_contacto = $tabla1.cod_canal INNER JOIN vtama_tipo_contacto ON vtama_tipo_contacto.cod_tipo_contacto = $tabla1.cod_tipo INNER JOIN vtama_estado_contacto ON vtama_estado_contacto.cod_estado_contacto = $tabla1.cod_estado WHERE $tabla1.$item1='$valor1' ORDER BY fch_atencion ASC");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }	
		}else if($entrada == 'datosFormulario'){
			$sql = $db->consulta("SELECT $tabla1.cod_contacto,$tabla1.cod_cliente,$tabla1.cod_canal,$tabla1.cod_tipo,$tabla1.cod_estado,$tabla1.fch_atencion,$tabla1.cod_trabajador_atencion,$tabla1.dsc_detalle_atencion,vtama_tipo_contacto.flg_informe,$tabla1.fch_registro_contacto,$tabla1.dsc_detalle_contacto,rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,$tabla1.dsc_nombre_contacto,$tabla1.dsc_correo_contacto,$tabla1.dsc_telefono_contacto FROM $tabla1 INNER JOIN vtama_tipo_contacto ON vtama_tipo_contacto.cod_tipo_contacto = $tabla1.cod_tipo INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = $tabla1.cod_usr_registro WHERE $item1 = '$valor1'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}
	    return $datos;
	}// function mdlMostrarContacto
	/*=============================================
	CREAR CONTACTO
	=============================================*/
	static public function mdlIngresarContacto($tabla1,$tabla2,$codigo,$datos,$datos2,$flgInforme){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$db->beginTransaction();
		$sql1 = $db->consulta("INSERT INTO $tabla1(cod_contacto,cod_cliente,cod_canal,cod_tipo,cod_estado,dsc_nombre_contacto,dsc_correo_contacto,dsc_telefono_contacto,dsc_detalle_contacto,fch_registro_contacto,cod_trabajador_atencion,dsc_detalle_atencion,fch_atencion,cod_usr_registro,fch_registro) VALUES ('".$datos["cod_contacto"]."','".$datos["cod_cliente"]."','".$datos["cod_canal"]."','".$datos["cod_tipo"]."','".$datos["cod_estado"]."','".$datos["dsc_nombre_contacto"]."','".$datos["dsc_correo_contacto"]."','".$datos["dsc_telefono_contacto"]."','".$datos["dsc_detalle_contacto"]."','".$datos["fch_registro_contacto"]."','".$datos["cod_trabajador_atencion"]."','".$datos["dsc_detalle_atencion"]."','".$datos["fch_atencion"]."','".$datos["cod_usr_registro"]."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if(count($datos2) > 0 && $flgInforme =="SI"){
			foreach ($datos2 as $key => $value) {
				$sql2 = $db->consulta("INSERT INTO $tabla2(cod_contacto,num_linea,dsc_actividad,dsc_lugar,dsc_participantes_cliente,dsc_participantes_indelat,dsc_acuerdo,dsc_objetivo,cod_area,cod_status,cod_responsable_indelat,dsc_ruta_archivo_adjunto,dsc_archivo_adjunto,fch_informe,fch_programada,cod_usr_registro,fch_registro) VALUES('".$codigo."',".$value["num_linea"].",'".$value["dsc_actividad"]."','".$value["dsc_lugar"]."','".$value["dsc_participantes_cliente"]."','".$value["dsc_participantes_indelat"]."','".$value["dsc_acuerdo"]."','".$value["dsc_objetivo"]."','".$value["cod_area"]."','".$value["cod_status"]."','".$value["cod_responsable_indelat"]."','".$codigo.'-'.$value["num_linea"].'-'.$value["dsc_archivo_adjunto"]."','".$value["dsc_archivo_adjunto"]."','".$value["fch_informe"]."','".$value["fch_programada"]."','".$datos["cod_usr_registro"]."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
			}//foreach
		}//if		
		if($flgInforme == "SI" && count($datos2) > 0){
			if($sql1 && $sql2){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql1);
			$db->liberar($sql2);
		}else{
			if($sql1){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql1);
		}
        $db->cerrar();
	}//function mdlIngresarContacto
	/*=============================================
	EDITAR CONTACTO
	=============================================*/
	static public function mdlEditarContacto($tabla1,$tabla2,$codigo,$datos,$datos2,$flgInforme,$rutaGlobal){
		$contDetalleContacto = 0;
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$db->beginTransaction();
		$sql1 = $db->consulta("UPDATE $tabla1 SET cod_cliente = '".$datos["cod_cliente"]."',cod_canal = '".$datos["cod_canal"]."',cod_tipo = '".$datos["cod_tipo"]."',cod_estado = '".$datos["cod_estado"]."',fch_registro_contacto = CONVERT(datetime,'".$datos["fch_registro_contacto"]."',21),dsc_nombre_contacto = '".$datos["dsc_nombre_contacto"]."',dsc_correo_contacto = '".$datos["dsc_correo_contacto"]."',dsc_telefono_contacto = '".$datos["dsc_telefono_contacto"]."',dsc_detalle_contacto = '".$datos["dsc_detalle_contacto"]."',fch_atencion = '".$datos["fch_atencion"]."',cod_trabajador_atencion = '".$datos["cod_trabajador_atencion"]."',dsc_detalle_atencion = '".$datos["dsc_detalle_atencion"]."',cod_usr_modifica ='".$datos["cod_usr_modifica"]."',fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_contacto = '".$datos["cod_contacto"]."'");
		if(count($datos2) > 0 && $flgInforme == "SI"){
			$sqlElimImg = $db->consulta("SELECT dsc_ruta_archivo_adjunto FROM $tabla2 WHERE cod_contacto = '$codigo' AND flg_eliminar_temp = 'SI'");
			$datosImgElim = '';
			while($key = $db->recorrer($sqlElimImg)){
				$datosImgElim .= $key["dsc_ruta_archivo_adjunto"].'||';
		    }
			$sql2 = $db->consulta("DELETE FROM $tabla2 WHERE cod_contacto = '$codigo' AND flg_eliminar_temp = 'SI'");
		    foreach ($datos2 as $key2 => $value) {
		    	$sql3 = $db->consulta("SELECT num_linea FROM $tabla2 WHERE cod_contacto = '$codigo' AND num_linea = ".$value["num_linea_orig"]);
		    	if($db->recorrer($sql3)["num_linea"] == ''){		    	    		
		    		$sql4 = $db->consulta("INSERT INTO $tabla2(cod_contacto,num_linea,dsc_actividad,dsc_lugar,dsc_participantes_cliente,dsc_participantes_indelat,dsc_acuerdo,dsc_objetivo,cod_area,cod_status,cod_responsable_indelat,dsc_ruta_archivo_adjunto,dsc_archivo_adjunto,fch_informe,fch_programada,cod_usr_registro,fch_registro) VALUES('".$codigo."',".$value["num_linea_orig"].",'".$value["dsc_actividad"]."','".$value["dsc_lugar"]."','".$value["dsc_participantes_cliente"]."','".$value["dsc_participantes_indelat"]."','".$value["dsc_acuerdo"]."','".$value["dsc_objetivo"]."','".$value["cod_area"]."','".$value["cod_status"]."','".$value["cod_responsable_indelat"]."','".$codigo.'-'.$value["num_linea_orig"].'-'.$value["dsc_archivo_adjunto"]."','".$value["dsc_archivo_adjunto"]."','".$value["fch_informe"]."','".$value["fch_programada"]."','".$datos["cod_usr_modifica"]."',CONVERT(datetime,'".$datos["fch_modifica"]."',21))");
		    		$contDetalleContacto++;
		    	}//if
		    }//foreach		
		}//if
		if($flgInforme == "SI" && count($datos2) > 0){
			if($contDetalleContacto > 0){
				if($sql1 && $sql2 && $sql3 && $sql4){
					$db->commit();
					$arrayDatosImgElim = explode("||",trim($datosImgElim,'||'));
					if($datosImgElim != ''){
						for ($i=0; $i < count($arrayDatosImgElim); $i++) {
							$rutaEliminarArchivo = $rutaGlobal."/archivos/contacto/informe/".trim(utf8_decode($arrayDatosImgElim[$i]));
							unlink($rutaEliminarArchivo);
						}//for
					}//if			
					return "ok";
				}else{
					$db->rollback();
					return "error";
				}
				$db->liberar($sql1);
				$db->liberar($sql2);
				$db->liberar($sql3);
				$db->liberar($sql4);
			}else{
				if($sql1 && $sql2 && $sql3){
					$db->commit();
					$arrayDatosImgElim = explode("||",trim($datosImgElim,'||'));
					for ($i=0; $i < count($arrayDatosImgElim); $i++) {
						$rutaEliminarArchivo = $rutaGlobal."/archivos/contacto/informe/".trim(utf8_decode($arrayDatosImgElim[$i]));
						unlink($rutaEliminarArchivo);
					}
					return "ok";
				}else{
					$db->rollback();
					return "error";
				}
				$db->liberar($sql1);
				$db->liberar($sql2);
				$db->liberar($sql3);
			}
		}else{
			if($sql1){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql1);
		}
        $db->cerrar();
	}//function mdlEditarContacto
	/*=============================================
	ELIMINAR CONTACTO
	=============================================*/
	static public function mdlEliminarContacto($tabla1,$tabla2,$datos,$rutaGlobal){
		$db = new Conexion();
		$db->beginTransaction();
		$sqldatosInforme = $db->consulta("SELECT COUNT(num_linea) as cont FROM $tabla2 WHERE cod_contacto = '$datos'");
		$datosImgElim = '';
		if($db->recorrer($sqldatosInforme)['cont'] > 0){
			$sqlElimImg = $db->consulta("SELECT dsc_ruta_archivo_adjunto FROM $tabla2 WHERE cod_contacto = '$datos'");
			while($key = $db->recorrer($sqlElimImg)){
				$datosImgElim .= $key["dsc_ruta_archivo_adjunto"].'||';
		    }
		}
		$sql1 = $db->consulta("DELETE FROM $tabla1 WHERE cod_contacto = '$datos'");
		$sql2 = $db->consulta("DELETE FROM $tabla2 WHERE cod_contacto = '$datos'");
		$arrayDatosImgElim = explode("||",trim($datosImgElim,'||'));
		if($sqldatosInforme && $sql1 && $sql2){
			$db->commit();
			$arrayDatosImgElim = explode("||",trim($datosImgElim,'||'));
			if($datosImgElim != ''){
				for ($i=0; $i < count($arrayDatosImgElim); $i++) {
					$rutaEliminarArchivo = $rutaGlobal."/archivos/contacto/informe/".trim(utf8_decode($arrayDatosImgElim[$i]));
					unlink($rutaEliminarArchivo);
				}//for
			}//if			
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarContacto
	/*=============================================
	MOSTRAR CONTACTO INFORME
	=============================================*/
	static public function mdlMostrarInformeContacto($tabla,$item,$valor,$item2,$valor2){
		$db = new Conexion();
		if($valor2 != null){
			$sql = $db->consulta("SELECT fch_informe,num_linea,dsc_actividad,dsc_lugar,dsc_participantes_cliente,dsc_participantes_indelat,dsc_acuerdo,dsc_objetivo,fch_programada,cod_status,cod_area,cod_responsable_indelat FROM $tabla WHERE $item = '$valor' AND $item2 = $valor2");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT $tabla.num_linea,$tabla.dsc_archivo_adjunto,$tabla.dsc_ruta_archivo_adjunto,$tabla.num_linea,$tabla.fch_informe,$tabla.dsc_actividad,$tabla.fch_programada,rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_apellido_paterno,vtama_area_informe_contacto.dsc_area,vtama_status_informe_contacto.dsc_status,$tabla.dsc_lugar,$tabla.dsc_participantes_cliente,$tabla.dsc_participantes_indelat,$tabla.dsc_acuerdo,$tabla.dsc_objetivo,$tabla.cod_responsable_indelat,$tabla.cod_area,$tabla.cod_status FROM $tabla INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = $tabla.cod_responsable_indelat INNER JOIN vtama_area_informe_contacto ON vtama_area_informe_contacto.cod_area = $tabla.cod_area INNER JOIN vtama_status_informe_contacto ON vtama_status_informe_contacto.cod_status = $tabla.cod_status WHERE $item = '$valor'");	
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}		
	    $db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarContactoInforme
	/*=============================================
	ELIMINAR CONTACTO INFORME
	=============================================*/
	static public function mdlEliminarInformeContacto($tabla,$codigo,$numLinea){
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET flg_eliminar_temp = 'SI' WHERE cod_contacto = '$codigo' AND num_linea = $numLinea");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarInformeContacto
	/*=============================================
	CANCELAR CONTACTO INFORME
	=============================================*/
	static public function mdlCancelarInformeContacto($tabla,$codigo){
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET flg_eliminar_temp = 'NO' WHERE cod_contacto = '$codigo'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarInformeContacto
}//class ModeloProducto
<?php
require_once "conexion.php";
class ModeloPoliticaProcedimiento{
	/*=============================================
	MOSTRAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function mdlMostrarPoliticaProcedimiento($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "detallePoliticaProcedimiento"){
				$sql = $db->consulta("SELECT cod_politica,dsc_politica FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));				
			}else if($entrada == "validarNombreRepetido"){
				$sql = $db->consulta("SELECT COUNT(dsc_politica) as contador FROM $tabla WHERE $item = '$valor'");
				$datos = $db->recorrer($sql);
			}else if($entrada == "capturarNombrePolitica"){
				$sql = $db->consulta("SELECT dsc_politica FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}
		}else{
			$sql = $db->consulta("SELECT cod_politica,dsc_politica FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}		
	    return $datos;
	    $db->liberar($sql);
        $db->cerrar();
	}//function mdlMostrarPoliticaProcedimiento
	/*=============================================
	MOSTRAR POLITICA/PROCEDIMIENTO DETALLE
	=============================================*/
	static public function mdlMostrarPoliticaProcedimientoDetalle($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "listaDetalle"){
				$sql = $db->consulta("SELECT cod_politica,num_linea,dsc_archivo,dsc_ruta_archivo FROM $tabla WHERE $item = '$valor'");
				$datos = array();
			    while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}else if($entrada == "maximoNumLineaXPoliticaProcedimiento"){
				$sql = $db->consulta("SELECT MAX(num_linea) as maximo FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "archivosPoliticaProcedimiento"){
				$sql = $db->consulta("SELECT dsc_ruta_archivo FROM $tabla WHERE $item = '$valor'");
				$datos = array();
			    while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}
		}//if
	    return $datos;
	    $db->liberar($sql);
        $db->cerrar();
	}//function mdlMostrarPoliticaProcedimientoDetalle
	/*=============================================
	CREAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function mdlIngresarPoliticaProcedimiento($tabla1,$tabla2,$datos,$numLinea,$rutaArchivo,$nombreArchivo,$usrRegistro,$fchRegistro,$codPoliticaProcedimiento){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$db->beginTransaction();
		$sql1 = $db->consulta("INSERT INTO $tabla1(cod_politica,dsc_politica,cod_usr_registro,fch_registro) VALUES('".$datos['cod_politica']."','".$datos['dsc_politica']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		foreach ($nombreArchivo as $key => $value) {
			$sql2 = $db->consulta("INSERT INTO $tabla2(cod_politica,num_linea,dsc_archivo,dsc_ruta_archivo,cod_usr_registro,fch_registro) VALUES('".$codPoliticaProcedimiento."',".$numLinea[$key].",'".Utf8Decode($value)."','".Utf8Decode($rutaArchivo[$key])."','".$usrRegistro[$key]."',CONVERT(datetime,'".$fchRegistro[$key]."',21))");
		}
		if(count($numLinea) > 0){
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
	}//function mdlIngresarPoliticaProcedimiento
	/*=============================================
	EDITAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function mdlEditarPoliticaProcedimiento($tabla1,$tabla2,$datos,$numLinea,$rutaArchivo,$nombreArchivo,$usrRegistro,$fchRegistro,$codPoliticaProcedimiento){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$db->beginTransaction();
		$sql1 = $db->consulta("UPDATE $tabla1 SET dsc_politica = '".$datos["dsc_politica"]."',cod_usr_modifica ='".$datos["cod_usr_modifica"]."',fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_politica = '".$datos["cod_politica"]."'");
		foreach ($nombreArchivo as $key => $value) {
			$sql2 = $db->consulta("INSERT INTO $tabla2(cod_politica,num_linea,dsc_archivo,dsc_ruta_archivo,cod_usr_registro,fch_registro) VALUES('".$codPoliticaProcedimiento."',".$numLinea[$key].",'".Utf8Decode($value)."','".Utf8Decode($rutaArchivo[$key])."','".$usrRegistro[$key]."',CONVERT(datetime,'".$fchRegistro[$key]."',21))");
		}
		if(count($numLinea) > 0){
			if($sql1 && $sql2){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
		}else{
			if($sql1){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarPoliticaProcedimiento
	/*=============================================
	ELIMINAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function mdlEliminarPoliticaProcedimiento($tabla1,$tabla2,$codigo){
		$db = new Conexion();
		$db->beginTransaction();
		$sql1 = $db->consulta("DELETE FROM $tabla1 WHERE cod_politica = '".$codigo."'");
		$sql2 = $db->consulta("DELETE FROM $tabla2 WHERE cod_politica = '".$codigo."'");
		if($sql1 && $sql2){
			$db->commit();
			return "ok";
		}else{
			$db->rollback();
			return "error";
		}
		$db->liberar($sql1);
		$db->liberar($sql2);
        $db->cerrar();
	}//function mdlEliminarPoliticaProcedimiento
	/*=============================================
	ELIMINAR POLITICA/PROCEDIMIENTO DETALLE
	=============================================*/
	static public function mdlEliminarPoliticaProcedimientoDetalle($tabla,$codigo,$numLinea){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_politica = '".$codigo."' AND num_linea = $numLinea");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarPoliticaProcedimientoDetalle
}//class ModeloPoliticaProcedimiento
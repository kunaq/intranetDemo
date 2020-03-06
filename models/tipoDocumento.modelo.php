<?php
require_once "conexion.php";
class ModeloTipoDocumento{
	/*=============================================
	MOSTRAR TIPO DOCUMENTO
	=============================================*/
	static public function mdlMostrarTipoDocumento($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_tipo_documento,dsc_tipo_documento FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_tipo_documento,dsc_tipo_documento FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarTipoDocumento
	/*=============================================
	CREAR TIPO DOCUMENTO
	=============================================*/
	static public function mdlIngresarTipoDocumento($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_tipo_documento,dsc_tipo_documento,cod_usr_registro,fch_registro) VALUES('".$datos['cod_tipo_documento']."','".$datos['dsc_tipo_documento']."','".$datos["cod_usr_registro"]."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarTipoDocumento
	/*=============================================
	EDITAR TIPO DOCUMENTO
	=============================================*/
	static public function mdlEditarTipoDocumento($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_tipo_documento = '".$datos["dsc_tipo_documento"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_tipo_documento = '".$datos["cod_tipo_documento"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarTipoDocumento
	/*=============================================
	ELIMINAR TIPO DOCUMENTO
	=============================================*/
	static public function mdlEliminarTipoDocumento($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_tipo_documento = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarTipoDocumento
}//class ModeloTipoDocumento
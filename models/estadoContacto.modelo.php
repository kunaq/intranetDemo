<?php
require_once "conexion.php";
class ModeloEstadoContacto{
	/*=============================================
	MOSTRAR ESTADO CONTACTO
	=============================================*/
	static public function mdlMostrarEstadoContacto($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_estado_contacto,dsc_estado_contacto FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_estado_contacto,dsc_estado_contacto FROM $tabla ORDER BY flg_pendiente DESC");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarEstadoContacto
	/*=============================================
	CREAR ESTADO CONTACTO
	=============================================*/
	static public function mdlIngresarEstadoContacto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_estado_contacto,dsc_estado_contacto, cod_usr_registro,fch_registro) VALUES('".$datos['cod_estado_contacto']."','".$datos['dsc_estado_contacto']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarEstadoContacto	
	/*=============================================
	EDITAR ESTADO CONTACTO
	=============================================*/
	static public function mdlEditarEstadoContacto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_estado_contacto = '".$datos["dsc_estado_contacto"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_estado_contacto = '".$datos["cod_estado_contacto"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarEstadoContacto
	/*=============================================
	ELIMINAR ESTADO CONTACTO
	=============================================*/
	static public function mdlEliminarEstadoContacto($tabla, $datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_estado_contacto = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarEstadoContacto
}//class ModeloEstadoContacto
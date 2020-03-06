<?php
require_once "conexion.php";
class ModeloTipoContacto{
	/*=============================================
	MOSTRAR TIPO CONTACTO
	=============================================*/
	static public function mdlMostrarTipoContacto($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_tipo_contacto,dsc_tipo_contacto FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_tipo_contacto,dsc_tipo_contacto,flg_informe FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarTipoContacto
	/*=============================================
	CREAR TIPO CONTACTO
	=============================================*/
	static public function mdlIngresarTipoContacto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_tipo_contacto,dsc_tipo_contacto, cod_usr_registro,fch_registro) VALUES('".$datos['cod_tipo_contacto']."','".$datos['dsc_tipo_contacto']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarTipoContacto
	/*=============================================
	EDITAR TIPO CONTACTO
	=============================================*/
	static public function mdlEditarTipoContacto($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_tipo_contacto = '".$datos["dsc_tipo_contacto"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_tipo_contacto = '".$datos["cod_tipo_contacto"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarTipoContacto
	/*=============================================
	ELIMINAR TIPO CONTACTO
	=============================================*/
	static public function mdlEliminarTipoContacto($tabla, $datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_tipo_contacto = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarTipoContacto
}//class ModeloTipoContacto
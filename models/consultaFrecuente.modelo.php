<?php
require_once "conexion.php";
class ModeloConsultaFrecuente{
	/*=============================================
	MOSTRAR CONSULTA FRECUENTE
	=============================================*/
	static public function mdlMostrarConsultaFrecuente($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "modalConsultaFrecuente"){
				$sql = $db->consulta("SELECT cod_consulta,dsc_consulta,dsc_respuesta,dsc_ruta_archivo FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "validarNombreRepetido"){
				$sql = $db->consulta("SELECT COUNT(dsc_consulta) as contador FROM $tabla WHERE $item = '$valor'");
				$datos = $db->recorrer($sql);
			}else if($entrada == "capturarTituloConsulta"){
				$sql = $db->consulta("SELECT dsc_consulta FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}
		}else{
			$sql = $db->consulta("SELECT cod_consulta,dsc_consulta,dsc_respuesta,dsc_ruta_archivo FROM $tabla");
			$datos = array();
			while($key = $db->recorrer($sql)){
				$datos[] = arrayMapUtf8Encode($key);
			}
		}
		return $datos;
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlMostrarConsultaFrecuente
	/*=============================================
	CREAR CONSULTA FRECUENTE
	=============================================*/
	static public function mdlCrearConsultaFrecuente($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_consulta,dsc_consulta,dsc_respuesta,dsc_ruta_archivo,cod_usr_registro,fch_registro) VALUES ('".$datos["cod_consulta"]."','".$datos["dsc_consulta"]."','".$datos["dsc_respuesta"]."','".$datos["dsc_ruta_archivo"]."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlCrearConsultaFrecuente
	/*=============================================
	EDITAR CONSULTA FRECUENTE
	=============================================*/
	static public function mdlEditarConsultaFrecuente($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_consulta='".$datos["dsc_consulta"]."',dsc_respuesta='".$datos["dsc_respuesta"]."',dsc_ruta_archivo='".$datos["dsc_ruta_archivo"]."',cod_usr_modifica = '".$datos["cod_usr_modifica"]."',fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_consulta = '".$datos["cod_consulta"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarConsultaFrecuente
	/*=============================================
	ELIMINAR CONSULTA FRECUENTE
	=============================================*/
	static public function mdlEliminarConsultaFrecuente($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_consulta = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarConsultaFrecuente
}//class ModeloConsultaFrecuente
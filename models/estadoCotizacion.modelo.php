<?php
require_once "conexion.php";
class ModeloEstadoCotizacion{
	/*=============================================
	MOSTRAR ESTADO COTIZACION
	=============================================*/
	static public function mdlMostrarEstadoCotizacion($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_estado_cotizacion,dsc_estado_cotizacion,dsc_color,dsc_detalle FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			if($entrada == 'estadoReporteCtz'){
				$sql = $db->consulta("SELECT dsc_estado_cotizacion,flg_pendiente,flg_aprobado FROM $tabla WHERE $tabla.flg_pendiente = 'SI' OR $tabla.flg_aprobado = 'SI'");
				$datos = array();
			    while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}else{
				$sql = $db->consulta("SELECT cod_estado_cotizacion,dsc_estado_cotizacion FROM $tabla");
				$datos = array();
			    while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}
			
		}
	    return $datos;
	}// function mdlMostrarEstadoCotizacion
	/*=============================================
	EDITAR ESTADO COTIZACION
	=============================================*/
	static public function mdlEditarEstadoCotizacion($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_estado_cotizacion = '".$datos["dsc_estado_cotizacion"]."',dsc_detalle = '".$datos["dsc_detalle"]."',dsc_color = '".$datos["dsc_color"]."',cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_estado_cotizacion = '".$datos["cod_estado_cotizacion"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarEstadoCotizacion
}//class ModeloEstadoCotizacion
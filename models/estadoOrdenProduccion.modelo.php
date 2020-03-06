<?php
require_once "conexion.php";
class ModeloEstadoOrdenProduccion{
	/*=============================================
	MOSTRAR ESTADO ORDEN DE PRODUCCION
	=============================================*/
	static public function mdlMostrarEstadoOrdenProduccion($item1,$valor1,$item2,$valor2,$entrada,$tabla1){
		$db = new Conexion();
		if($entrada == 'flgPendiente'){
			$sql1 = $db->consulta("SELECT cod_estado,dsc_estado FROM $tabla1 WHERE $item1='$valor1' AND $item2='$valor2'");
			$datos = $db->recorrer($sql1);
			$db->liberar($sql1);
		}else if($entrada == 'inputSelect'){
			$sql1 = $db->consulta("SELECT cod_estado,dsc_estado FROM $tabla1 WHERE $item1='$valor1'");
			while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}
		return $datos;		
        $db->cerrar();
	}//function mdlMostrarEstadoOrdenProduccion
}//class ModeloEstadoOrdenProduccion
<?php
require_once "conexion.php";
class ModeloDocumento{
	/*=============================================
	MOSTRAR DOCUMENTO
	=============================================*/
	static public function mdlMostrarDocumento($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada,$tabla1,$tabla2){
		$db = new Conexion();
		if($entrada == 'vtnOrdenProduccion'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_documento,$tabla1.dsc_documento,CASE WHEN $tabla2.$item2='$valor2' AND $tabla2.$item3 = '$valor3' THEN 'SI' ELSE 'NO' END AS flgDocumentoNumOrdProd,$tabla2.cod_localidad,$tabla2.num_orden_produccion,$tabla2.num_linea FROM $tabla1 LEFT JOIN $tabla2 ON $tabla1.cod_documento = $tabla2.cod_documento AND $tabla2.$item2='$valor2' AND $tabla2.$item3 = '$valor3' WHERE $tabla1.$item1='$valor1'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'listaDocumentoOrdProd'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_documento FROM $tabla1 WHERE $tabla1.$item1 = '$valor1'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}
		return $datos;		
        $db->cerrar();
	}//function mdlMostrarDocumento
}//class ModeloDocumento
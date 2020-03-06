<?php
require_once "conexion.php";
class ModeloArea{
	/*=============================================
	MOSTRAR AREA
	=============================================*/
	static public function mdlMostrarArea($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$item5,$valor5,$entrada,$tabla1,$tabla2,$tabla3){
		$db = new Conexion();
		if($entrada == 'vtnOrdenProduccion'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_area,$tabla1.dsc_area,CASE WHEN $tabla2.$item2='$valor2' AND $tabla2.$item3='$valor3' THEN 'SI' ELSE 'NO' END AS flgAreaNumOrdProd,ISNULL($tabla2.cod_estado,(SELECT cod_estado FROM $tabla3 WHERE flg_pendiente = 'SI' AND flg_activo='SI')) as cod_estado FROM $tabla1 LEFT JOIN $tabla2 ON $tabla1.cod_area = $tabla2.cod_area AND $tabla2.$item2='$valor2' AND $tabla2.$item3='$valor3' WHERE $tabla1.$item1='$valor1'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'dtbleVinculoOrdPrd'){
			$condicion = '';
			if($valor5 != 'todos'){
				$condicion = "AND vtama_estado_area_ordenProd.$item5='$valor5'";
			}
			$sql1 = $db->consulta("SELECT rhuma_area.cod_area,feica_orden_produccion_area.cod_localidad,feica_orden_produccion_area.num_orden_produccion,vtama_estado_area_ordenProd.dsc_color,rhuma_area.flg_facturacion,feica_orden_produccion_area.num_linea_orden_detalle,feica_orden_produccion_area.cod_area,rhuma_area.flg_pedido,rhuma_area.flg_compras,feica_orden_produccion_area.cod_estado,vtama_estado_area_ordenProd.flg_terminado,rhuma_area.flg_diseño,rhuma_area.flg_fabricacion,rhuma_area.flg_rev_mold,rhuma_area.flg_pintura,rhuma_area.flg_control_calidad,rhuma_area.flg_despacho FROM rhuma_area INNER JOIN feica_orden_produccion_area ON feica_orden_produccion_area.cod_area = rhuma_area.cod_area LEFT JOIN vtama_estado_area_ordenProd ON feica_orden_produccion_area.cod_estado = vtama_estado_area_ordenProd.cod_estado WHERE feica_orden_produccion_area.$item1 = '$valor1' AND feica_orden_produccion_area.$item2 = '$valor2' AND feica_orden_produccion_area.$item3 = '$valor3' AND feica_orden_produccion_area.$item4 = '$valor4' $condicion");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'dtbleVinculoOrdPrdExcel'){
			//$sql1 = $db->consulta("SELECT rhuma_area.cod_area,vtama_estado_area_ordenProd.dsc_estado,feide_orden_produccion_area.num_cantidad,feide_orden_produccion_area.fch_inicial,rhuma_area.flg_facturacion FROM rhuma_area INNER JOIN feica_orden_produccion_area ON feica_orden_produccion_area.cod_area = rhuma_area.cod_area LEFT JOIN feide_orden_produccion_area ON feide_orden_produccion_area.cod_localidad = feica_orden_produccion_area.cod_localidad AND feide_orden_produccion_area.num_orden_produccion = feica_orden_produccion_area.num_orden_produccion AND feide_orden_produccion_area.num_linea_orden_detalle = feica_orden_produccion_area.num_linea_orden_detalle AND feide_orden_produccion_area.cod_area = feica_orden_produccion_area.cod_area LEFT JOIN vtama_estado_area_ordenProd ON feica_orden_produccion_area.cod_estado = vtama_estado_area_ordenProd.cod_estado WHERE feica_orden_produccion_area.$item1 = '$valor1' AND feica_orden_produccion_area.$item2 = '$valor2' AND feica_orden_produccion_area.$item3 = '$valor3'");
			$sql1 = $db->consulta("SELECT feica_orden_produccion_area.cod_localidad,feica_orden_produccion_area.num_orden_produccion,rhuma_area.cod_area,vtama_estado_area_ordenProd.dsc_estado,feica_orden_produccion_area.num_linea_orden_detalle,feica_orden_produccion_area.cod_producto,rhuma_area.flg_facturacion FROM rhuma_area INNER JOIN feica_orden_produccion_area ON feica_orden_produccion_area.cod_area = rhuma_area.cod_area LEFT JOIN vtama_estado_area_ordenProd ON feica_orden_produccion_area.cod_estado = vtama_estado_area_ordenProd.cod_estado WHERE feica_orden_produccion_area.$item1 = '$valor1' AND feica_orden_produccion_area.$item2 = '$valor2' AND feica_orden_produccion_area.$item3 = '$valor3' AND feica_orden_produccion_area.$item4 = '$valor4'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'dtbleVinculoOrdPrdExcelDet'){
			$sql1 = $db->consulta("SELECT num_cantidad,fch_inicial FROM feide_orden_produccion_area WHERE $item1='$valor1' AND $item2='$valor2' AND $item3=$valor3 AND $item4='$valor4' AND $item5='$valor5'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'dtbleVinculoOrdPrdExcelDetFact'){
			$sql1 = $db->consulta("SELECT 'NO' as flg_guia_remision,num_facturacion AS num_serie,fch_emision FROM feide_orden_produccion_areaFacturacion_Fact WHERE $item1='$valor1' AND $item2='$valor2' AND $item3=$valor3 AND $item4='$valor4' AND $item5='$valor5' UNION SELECT 'SI' as flg_guia_remision,num_guia_remision AS num_serie,fch_emision FROM feide_orden_produccion_areaFacturacion_GuiaR WHERE $item1='$valor1' AND $item2='$valor2' AND $item3=$valor3 AND $item4='$valor4' AND $item5='$valor5'");			
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'dtbleOrdPrd'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_area,$tabla1.dsc_area,$tabla1.flg_pedido,$tabla1.flg_compras,$tabla1.flg_facturacion FROM $tabla1 WHERE $item1='$valor1'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'dtbleVinculoResOrdPrdExcel'){
			//$sql1 = $db->consulta("SELECT rhuma_area.cod_area,vtama_estado_area_ordenProd.dsc_estado,feide_orden_produccion_area.num_cantidad,feide_orden_produccion_area.fch_inicial,rhuma_area.flg_facturacion FROM rhuma_area INNER JOIN feica_orden_produccion_area ON feica_orden_produccion_area.cod_area = rhuma_area.cod_area LEFT JOIN feide_orden_produccion_area ON feide_orden_produccion_area.cod_localidad = feica_orden_produccion_area.cod_localidad AND feide_orden_produccion_area.num_orden_produccion = feica_orden_produccion_area.num_orden_produccion AND feide_orden_produccion_area.num_linea_orden_detalle = feica_orden_produccion_area.num_linea_orden_detalle AND feide_orden_produccion_area.cod_area = feica_orden_produccion_area.cod_area LEFT JOIN vtama_estado_area_ordenProd ON feica_orden_produccion_area.cod_estado = vtama_estado_area_ordenProd.cod_estado WHERE feica_orden_produccion_area.$item1 = '$valor1' AND feica_orden_produccion_area.$item2 = '$valor2' AND feica_orden_produccion_area.$item3 = '$valor3'");
			$sql1 = $db->consulta("SELECT rhuma_area.cod_area,feica_orden_produccion_area.cod_localidad,feica_orden_produccion_area.num_orden_produccion,vtama_estado_area_ordenProd.dsc_color,feica_orden_produccion_area.cod_area,feica_orden_produccion_area.cod_estado,rhuma_area.flg_facturacion,vtama_estado_area_ordenProd.flg_terminado, COUNT(*) AS num_veces FROM rhuma_area INNER JOIN feica_orden_produccion_area ON feica_orden_produccion_area.cod_area = rhuma_area.cod_area LEFT JOIN vtama_estado_area_ordenProd ON feica_orden_produccion_area.cod_estado = vtama_estado_area_ordenProd.cod_estado WHERE feica_orden_produccion_area.$item1 = '$valor1' AND feica_orden_produccion_area.$item2 = '$valor2' GROUP BY rhuma_area.cod_area,feica_orden_produccion_area.cod_localidad,feica_orden_produccion_area.num_orden_produccion,vtama_estado_area_ordenProd.dsc_color,feica_orden_produccion_area.cod_area,feica_orden_produccion_area.cod_estado,rhuma_area.flg_facturacion,vtama_estado_area_ordenProd.flg_terminado");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}
		return $datos;		
        $db->cerrar();
	}//function mdlMostrarArea
}//class ModeloArea
<?php
require_once "conexion.php";
class ModeloOrdenProduccion{
	/*=============================================
	MOSTRAR ORDEN DE PRODUCCION
	=============================================*/
	static public function mdlMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6,$tabla7,$tabla8,$tabla9,$tabla10){
		$db = new Conexion();
		if($entrada == 'datatableListado'){
			$condicion = '';
			if($valor1 != ''){
				if($condicion != ''){ $condicion .= " AND $tabla2.fch_validada BETWEEN '$valor1' AND '$valor2'"; }
				else{ $condicion = "WHERE $tabla2.fch_validada BETWEEN '$valor1' AND '$valor2'"; }
			}
			if($valor3 != 'todos'){
				if($condicion != ''){ $condicion .= " AND ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }
				else{ $condicion = "WHERE ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }	
			}
			if($valor4 != 'todos'){
				if($condicion != ''){ $condicion .= " AND $tabla2.$item4 = '$valor4'"; }
				else{ $condicion = "WHERE $tabla2.$item4 = '$valor4'"; }	
			}
			$sql1 = $db->consulta("SELECT DISTINCT $tabla1.cod_localidad,$tabla1.num_orden_produccion,$tabla2.num_linea,$tabla3.cod_producto,$tabla3.dsc_producto,$tabla2.ctd_orden,$tabla4.dsc_simbolo,$tabla2.fch_entrega,$tabla5.dsc_estado,$tabla9.dsc_razon_social,$tabla5.dsc_color,$tabla2.fch_validada,$tabla2.flg_fch_validada,DATEDIFF(DAY,CONVERT(date, GETDATE()),$tabla2.fch_validada) AS difFechaValidada,$tabla2.flg_fch_validada_modificado FROM $tabla1 LEFT JOIN $tabla2 ON $tabla2.cod_localidad = $tabla1.cod_localidad AND $tabla2.num_orden_produccion = $tabla1.num_orden_produccion LEFT JOIN $tabla3 ON $tabla3.cod_producto = $tabla2.cod_producto LEFT JOIN $tabla4 ON $tabla4.cod_unidad = $tabla2.cod_unidad LEFT JOIN $tabla5 ON $tabla5.cod_estado = $tabla1.cod_estado INNER JOIN $tabla9 ON $tabla1.cod_cliente = $tabla9.cod_cliente LEFT JOIN feica_orden_produccion_area ON feide_orden_produccion.cod_localidad = feica_orden_produccion_area.cod_localidad AND feide_orden_produccion.num_orden_produccion = feica_orden_produccion_area.num_orden_produccion AND feide_orden_produccion.num_linea = feica_orden_produccion_area.num_linea_orden_detalle $condicion ORDER BY $tabla1.num_orden_produccion,$tabla2.fch_entrega ASC");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'vtnOrdenProduccionExcel'){
			$condicion = '';
			if($valor1 != ''){
				if($condicion != ''){ $condicion .= " AND feide_orden_produccion.$item1 BETWEEN '$valor1' AND '$valor2'"; }
				else{ $condicion = "WHERE feide_orden_produccion.$item1 BETWEEN '$valor1' AND '$valor2'"; }
			}
			if($valor3 != 'todos'){
				if($condicion != ''){ $condicion .= " AND ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }
				else{ $condicion = "WHERE ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }	
			}
			if($valor4 != 'todos'){
				if($condicion != ''){ $condicion .= " AND feide_orden_produccion.$item4 = '$valor4'"; }
				else{ $condicion = "WHERE feide_orden_produccion.$item4 = '$valor4'"; }	
			}
			$sql1 = $db->consulta("SELECT DISTINCT $tabla1.cod_localidad,$tabla1.num_orden_produccion,$tabla1.dsc_orden,$tabla1.fch_compromiso,$tabla1.dsc_orden_compra,$tabla1.fch_validada AS fch_validada_cab,feide_orden_produccion.num_linea,vtama_producto.dsc_producto,feide_orden_produccion.ctd_orden,vtama_unidad_medida.dsc_simbolo,feide_orden_produccion.fch_entrega,vtama_estado_orden_produccion.dsc_estado,vtama_cliente.dsc_razon_social,feide_orden_produccion.cod_producto,feide_orden_produccion.fch_validada,feide_orden_produccion.cod_cotizacion,feide_orden_produccion.flg_fch_validada,feide_orden_produccion.imp_area,feide_orden_produccion.imp_peso,(rhuma_trabajador.dsc_apellido_paterno + rhuma_trabajador.dsc_apellido_materno+', '+rhuma_trabajador.dsc_nombres) as dsc_trabajador,$tabla1.fch_registro,vtama_sede.dsc_sede,feide_orden_produccion.flg_fch_validada_modificado FROM $tabla1 LEFT JOIN feide_orden_produccion ON feide_orden_produccion.cod_localidad = $tabla1.cod_localidad AND feide_orden_produccion.num_orden_produccion = $tabla1.num_orden_produccion LEFT JOIN vtama_producto ON vtama_producto.cod_producto = feide_orden_produccion.cod_producto LEFT JOIN vtama_unidad_medida ON vtama_unidad_medida.cod_unidad = feide_orden_produccion.cod_unidad LEFT JOIN feica_orden_produccion_area ON feide_orden_produccion.cod_localidad = feica_orden_produccion_area.cod_localidad AND feide_orden_produccion.num_orden_produccion = feica_orden_produccion_area.num_orden_produccion AND feide_orden_produccion.num_linea = feica_orden_produccion_area.num_linea_orden_detalle LEFT JOIN vtama_estado_orden_produccion ON vtama_estado_orden_produccion.cod_estado = $tabla1.cod_estado INNER JOIN vtama_cliente ON $tabla1.cod_cliente = vtama_cliente.cod_cliente INNER JOIN rhuma_trabajador ON $tabla1.cod_usuario_registro = rhuma_trabajador.cod_trabajador LEFT JOIN vtama_sede ON vtama_sede.cod_sede = $tabla1.cod_sede $condicion ORDER BY $tabla1.num_orden_produccion,feide_orden_produccion.fch_validada ASC");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'vtnOrdenProduccionExcelDetalle'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_localidad,$tabla1.num_orden_produccion,feide_orden_produccion.num_linea,feide_orden_produccion.ctd_orden,vtama_producto.dsc_producto,vtama_unidad_medida.dsc_simbolo,feide_orden_produccion.imp_area,feide_orden_produccion.imp_peso,feide_orden_produccion.fch_validada FROM $tabla1 LEFT JOIN vtama_producto ON vtama_producto.cod_producto = feide_orden_produccion.cod_producto LEFT JOIN vtama_unidad_medida ON vtama_unidad_medida.cod_unidad = feide_orden_produccion.cod_unidad WHERE $tabla1.$item1 = '$valor1' AND $tabla1.$item2 = '$valor2'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'areaRelacOrdProd'){
			$sql1 = $db->consulta("SELECT $tabla6.cod_localidad,$tabla6.num_orden_produccion,$tabla6.num_linea,$tabla6.cod_estado,$tabla6.imp_porcentaje,$tabla6.fecha,$tabla10.dsc_area FROM $tabla6 INNER JOIN $tabla10 ON $tabla6.cod_area = $tabla10.cod_area WHERE $tabla6.$item1='$valor1' AND $tabla6.$item2='$valor2' AND $tabla6.$item3=$valor3");
			$datos = $db->recorrer($sql1);
			$db->liberar($sql1);
		}else if($entrada == 'datosFormulario'){
			$sql1 = $db->consulta("SELECT ($tabla7.dsc_apellido_paterno+' '+$tabla7.dsc_apellido_materno+', '+$tabla7.dsc_nombres) AS full_nombre,$tabla7.cod_trabajador,$tabla1.fch_registro,$tabla1.num_orden_produccion,$tabla1.cod_estado,$tabla1.dsc_orden,$tabla1.fch_compromiso,$tabla1.cod_cliente,$tabla1.dsc_orden_compra,$tabla1.fch_validada,$tabla1.flg_fch_validada,$tabla1.cod_sede,$tabla5.flg_anulado,$tabla5.dsc_estado,$tabla9.dsc_razon_social,vtama_sede.dsc_sede FROM $tabla1 INNER JOIN $tabla7 ON $tabla1.cod_usuario_registro = $tabla7.cod_trabajador INNER JOIN $tabla5 ON $tabla5.cod_estado = $tabla1.cod_estado INNER JOIN $tabla9 ON $tabla1.cod_cliente = $tabla9.cod_cliente INNER JOIN vtama_sede ON vtama_sede.cod_sede = $tabla1.cod_sede WHERE $tabla1.$item1='$valor1' AND $tabla1.$item2='$valor2'");
			$datos = $db->recorrer($sql1);
			$db->liberar($sql1);
		}else if($entrada == 'productoRelacOrdProd'){
			$sql1 = $db->consulta("SELECT $tabla2.num_linea,$tabla2.cod_cotizacion,$tabla2.fch_entrega,$tabla2.imp_area,$tabla2.imp_peso,$tabla3.dsc_producto,$tabla2.ctd_orden,$tabla4.dsc_simbolo,$tabla3.cod_producto,$tabla2.cod_unidad,$tabla2.fch_validada,$tabla2.flg_fch_validada,$tabla2.flg_fch_validada_modificado FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.cod_localidad = $tabla2.cod_localidad AND $tabla1.num_orden_produccion = $tabla2.num_orden_produccion INNER JOIN $tabla3 ON $tabla2.cod_producto = $tabla3.cod_producto LEFT JOIN $tabla4 ON $tabla4.cod_unidad = $tabla2.cod_unidad WHERE $tabla2.$item1='$valor1' AND $tabla2.$item2='$valor2'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'usuarioDocRelacOrdProd'){
			$sql1 = $db->consulta("SELECT $tabla8.cod_usuario FROM $tabla8 WHERE $tabla8.$item1='$valor1' AND $tabla8.$item2='$valor2' AND $tabla8.$item3=$valor3");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'modalObservacion'){
			$sql1 = $db->consulta("SELECT dsc_observacion FROM feide_orden_produccion_observacion WHERE $item1='$valor1' AND $item2='$valor2' AND $item3=$valor3");
			$datos = $db->recorrer($sql1);
			$db->liberar($sql1);
		}
        $db->cerrar();
		return $datos;
	}//function mdlMostrarOrdenProduccion
	/*=============================================
	CREAR ORDEN DE PRODUCCION
	=============================================*/
	static public function mdlCrearOrdenProduccion($datos1,$datos2,$datos3,$datos4,$entrada,$tabla1,$tabla2,$tabla3,$tabla4){
		$db = new Conexion();
		$db->beginTransaction();
		if($entrada == 'formularioPrincipal'){
			$sql1 = $db->consulta("INSERT INTO $tabla1(cod_localidad,num_orden_produccion,cod_estado,fch_registro,fch_compromiso,dsc_orden,cod_usuario_registro,cod_cliente,dsc_orden_compra,fch_validada,flg_fch_validada,cod_sede) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."','".$datos1["cod_estado"]."',CONVERT(datetime,'".$datos1["fch_registro"]."',21),".$datos1["fch_compromiso"].",'".$datos1["dsc_orden"]."','".$datos1["cod_usuario_registro"]."','".$datos1["cod_cliente"]."','".$datos1["dsc_orden_compra"]."',".$datos1["fch_validada"].",'".$datos1["flg_fch_validada"]."','".$datos1["cod_sede"]."')");
			$codCotizacion = '';
			if(count($datos2) > 0){
				foreach ($datos2 as $key => $value) {
					$value["cod_cotizacion"] = ($value["cod_cotizacion"] == '---') ? '' : $value["cod_cotizacion"];	
					$sql2 =  $db->consulta("INSERT INTO $tabla2(cod_localidad,num_orden_produccion,num_linea,cod_producto,cod_unidad,ctd_orden,cod_cotizacion,fch_entrega,imp_area,imp_peso,fch_validada,flg_fch_validada,flg_fch_validada_modificado) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$value["num_linea"].",'".$value["cod_producto"]."','".$value["cod_unidad"]."',".valorVacioEntero(replaceComas($value["ctd_orden"])).",'".$value["cod_cotizacion"]."',".ordenarFechaDate($value["fch_entrega"]).",".valorVacioEntero(replaceComas($value["imp_area"])).",".valorVacioEntero(replaceComas($value["imp_peso"])).",".ordenarFechaDate($value["fch_validada"]).",'".$value["flg_fch_validada"]."','NO')");
					if($value["cod_cotizacion"] != '' && $value["cod_cotizacion"] != $codCotizacion){
						$sql2a = $db->consulta("UPDATE vtaca_cotizacion SET flg_uso_orden_produccion='SI' WHERE cod_cotizacion = '".$value["cod_cotizacion"]."'");
					}else{
						$sql2a = true;
					}
					$codCotizacion = $value["cod_cotizacion"];
				}//foreach
			}else{
				$sql2 = $sql2a = true;
			}
			if(count($datos3) > 0){
				$contArea = 1;
				foreach ($datos3 as $key => $value) {
					if($value["flg_area"] == 'SI'){
						$sql3 =  $db->consulta("INSERT INTO $tabla3(cod_localidad,num_orden_produccion,cod_area) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."','".$value["cod_area"]."')");
					}else{
						$sql3 = true;
					}
				}//foreach
			}else{
				$sql3 = true;
			}
			if(count($datos2) > 0){
				foreach ($datos2 as $key => $value) {
					if(count($datos3) > 0){
						$contArea = 1;
						foreach ($datos3 as $key => $value2) {
							if($value2["flg_area"] == 'SI'){
								$sql4 = $db->consulta("INSERT INTO feica_orden_produccion_area(cod_localidad,num_orden_produccion,num_linea_orden_detalle,cod_producto,cod_area,cod_estado) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$value["num_linea"].",'".$value["cod_producto"]."','".$value2["cod_area"]."','".$value2["cod_estado"]."')");
								$contArea++;
							}else{
								$sql4 = true;
							}
						}
					}else{
						$sql4 = true;
					}
				}//foreach
			}else{
				$sql4 = true;
			}
			if(count($datos4) > 0){
				$contDocumento = 1;
				foreach ($datos4 as $key => $value) {
					if($value["flg_documento"] == 'SI'){
						$sql5 =  $db->consulta("INSERT INTO $tabla4(cod_localidad,num_orden_produccion,num_linea,cod_documento) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$contDocumento.",'".$value["cod_documento"]."')");
						$contDocumento++;
					}else{
						$sql5 = true;
					}
				}//foreach
			}else{
				$sql5 = true;
			}
			if($sql1 && $sql2 && $sql2a && $sql3 && $sql4 && $sql5){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql1);
			$db->liberar($sql2);$db->liberar($sql2a);
			$db->liberar($sql3);
			$db->liberar($sql4);
			$db->liberar($sql5);
		}else if($entrada == 'usuarioDocVinc'){
			$sql1 = $db->consulta("DELETE FROM $tabla1 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea=".$datos1["num_linea"]);
			if(count($datos2) > 0){
				foreach ($datos2 as $key => $value) {
					$sql2 =  $db->consulta("INSERT INTO $tabla1(cod_localidad,num_orden_produccion,num_linea,num_linea_det,cod_usuario) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$datos1["num_linea"].",".($key+1).",'".$value["cod_usuario"]."')");
				}//foreach
			}else{
				$sql2 = true;
			}
			if($sql1 && $sql2){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql1);
			$db->liberar($sql2);
		}
		$db->cerrar();
	}//function mdlCrearOrdenProduccion
	/*=============================================
	EDITAR ORDEN DE PRODUCCION
	=============================================*/
	static public function mdlEditarOrdenProduccion($datos1,$datos2,$datos3a,$datos4,$datos5,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$datos3b){
		$db = new Conexion();		
		if($entrada == 'formularioPrincipal'){
			$db->beginTransaction();
			$sql1 = $db->consulta("UPDATE $tabla1 SET num_orden_produccion='".$datos1["num_orden_produccion"]."',cod_estado='".$datos1["cod_estado"]."',cod_cliente='".$datos1["cod_cliente"]."',dsc_orden='".$datos1["dsc_orden"]."',fch_compromiso=".$datos1["fch_compromiso"].",dsc_orden_compra='".$datos1["dsc_orden_compra"]."',fch_validada=".$datos1["fch_validada"].",flg_fch_validada='".$datos1['flg_fch_validada']."',cod_sede='".$datos1["cod_sede"]."' WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion_orig"]."'");
			$sql1a = $db->consulta("SELECT flg_anulado FROM vtama_estado_orden_produccion WHERE cod_estado='".$datos1["cod_estado"]."'");
			$flgAnulado = $db->recorrer($sql1a)["flg_anulado"];
			$sql2 = $db->consulta("DELETE FROM $tabla2 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion_orig"]."'");
			$textoObservacion = $dscProducto = '';
			if(count($datos2) > 0){
				$arrayValorCtz = array();
				$codCotizacion = '';
				foreach ($datos2 as $key => $value) {
					$difTexto = 'NO';
					if(($value["fch_entrega"] != $value["fch_entrega_original"]) || ($value["fch_validada"] != $value["fch_validada_original"]) || ($value["imp_area"] != $value["imp_area_original"]) || ($value["imp_peso"] != $value["imp_peso_original"]) || ($value["flg_fch_validada"] != $value["flg_fch_validada_original"])){
						$sql3 = $db->consulta("SELECT dsc_producto FROM vtama_producto WHERE cod_producto='".$value["cod_producto"]."'");
						$dscProducto = $db->recorrer($sql3)["dsc_producto"];
						if(($value["fch_entrega"] != $value["fch_entrega_original"]) && ($value["fch_entrega_original"] != 'nuevo')){
							$textoObservacion .= "Se ha cambiado la fecha de entrega ".$value["fch_entrega_original"]." por la fecha ".$value["fch_entrega"];
							$difTexto = 'SI';
						}
						if(($value["fch_validada"] != $value["fch_validada_original"]) && ($value["fch_validada_original"] != 'nuevo')){
							$textoObservacion .= ($difTexto == 'SI') ? ", la " : " Se ha cambiado la ";
							$textoObservacion .= "fecha validada ".$value["fch_validada_original"]." por la fecha ".$value["fch_validada"];
							$difTexto = 'SI';
						}
						if(($value["flg_fch_validada"] != $value["flg_fch_validada_original"]) && ($value["flg_fch_validada_original"] != 'nuevo')){
							$textoObservacion .= ($difTexto == 'SI') ? ", " : " Se ha cambiado ";
							$textoObservacion .= "el check de la fecha validada";
							$difTexto = 'SI';
						}
						if(($value["imp_area"] != $value["imp_area_original"]) && ($value["imp_area_original"] != 'nuevo')){
							$textoObservacion .= ($difTexto == 'SI') ? ", el " : " Se ha cambiado el ";
							$textoObservacion .= "área ".$value["imp_area_original"]." por el área ".$value["imp_area"];
							$difTexto = 'SI';
						}
						if(($value["imp_peso"] != $value["imp_peso_original"]) && ($value["imp_peso_original"] != 'nuevo')){
							$textoObservacion .= ($difTexto == 'SI') ? ", el " : " Se ha cambiado el ";
							$textoObservacion .= "peso ".$value["imp_peso_original"]." por el peso ".$value["imp_peso"];
							$difTexto = 'SI';
						}
						if($value["fch_validada_original"] != 'nuevo' || $value["fch_entrega_original"] != 'nuevo' || $value["imp_area_original"] != 'nuevo' || $value["imp_peso_original"] != 'nuevo'){
							$textoObservacion .= " del producto $dscProducto. ";
						}
					}else{
						$sql3 = true;
					}
					$value["cod_cotizacion"] = ($value["cod_cotizacion"] == '---') ? '' : $value["cod_cotizacion"];
					array_push($arrayValorCtz,$value["cod_cotizacion"]);					
					$sql4 = $db->consulta("INSERT INTO $tabla2(cod_localidad,num_orden_produccion,num_linea,cod_producto,cod_unidad,ctd_orden,cod_cotizacion,fch_entrega,imp_area,imp_peso,fch_validada,flg_fch_validada,flg_fch_validada_modificado) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$value["num_linea"].",'".$value["cod_producto"]."','".$value["cod_unidad"]."',".valorVacioEntero(replaceComas($value["ctd_orden"])).",'".$value["cod_cotizacion"]."',".ordenarFechaDate($value["fch_entrega"]).",".valorVacioEntero(replaceComas($value["imp_area"])).",".valorVacioEntero(replaceComas($value["imp_peso"])).",".ordenarFechaDate($value["fch_validada"]).",'".$value["flg_fch_validada"]."','".$value["flg_fch_validada_modificado"]."')");
					if(($value["fch_validada"] != $value["fch_validada_original"]) && $value["flg_fch_validada_original"] == 'SI'){
						$sql4a = $db->consulta("UPDATE $tabla2 SET flg_fch_validada_modificado='SI' WHERE cod_localidad = '".$datos1["cod_localidad"]."' AND num_orden_produccion = '".$datos1["num_orden_produccion"]."' AND num_linea = ".$value["num_linea"]);
					}else{
						$sql4a = true;
					}
					if($value["flg_fch_validada"] == 'NO'){
						$sql4b = $db->consulta("UPDATE $tabla2 SET flg_fch_validada_modificado='NO' WHERE cod_localidad = '".$datos1["cod_localidad"]."' AND num_orden_produccion = '".$datos1["num_orden_produccion"]."' AND num_linea = ".$value["num_linea"]);
					}else{
						$sql4b = true;
					}
					if($flgAnulado == 'SI'){
						if($value["cod_cotizacion"] != '' && $value["cod_cotizacion"] != $codCotizacion){
							$sql4c = $db->consulta("UPDATE vtaca_cotizacion SET flg_uso_orden_produccion='NO' WHERE cod_cotizacion = '".$value["cod_cotizacion"]."'");
						}else{
							$sql4c = true;
						}
					}else{
						$sql4c = true;
					}					
					$codCotizacion = $value["cod_cotizacion"];
				}//foreach
				$sql5a = true;
				/*if(count($arrayValorCtz) > 0){
					$arrayValorCtz = array_values(array_unique($arrayValorCtz));
					for ($i=0; $i < count($arrayValorCtz); $i++) { 
						if($arrayValorCtz[$i] != ''){
							$sql5a = $db->consulta("UPDATE vtaca_cotizacion SET flg_uso_orden_produccion='SI' WHERE cod_cotizacion='".$arrayValorCtz[$i]."'");
						}
					}//for	
				}else{
					$sql5a = true;
				}*/				
			}else{
				$sql3 = $sql4 = $sql4a = $sql4b = $sql4c = $sql5a = true;
			}
			if($textoObservacion != ''){
				$maxNumLinea = 1;
				$sql5 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM feide_orden_produccion_observacion WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."'");
				while($key = $db->recorrer($sql5)){
					$maxNumLinea = $key["max_num_linea"];
				}
				$sql6 = $db->consulta("INSERT INTO feide_orden_produccion_observacion(cod_localidad,num_orden_produccion,num_linea,cod_usuario,fch_registro,dsc_observacion,flg_automatico) VALUES('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',$maxNumLinea,'".$datos1["cod_usuario_registro"]."',CONVERT(datetime,'".$datos1["fch_registro"]."',21),'".trim($textoObservacion)."','SI')");
			}else{
				$sql5 = $sql6 = true;
			}
			//echo count($datos3).'||';
			//AREAS A ELIMINAR
			if(count($datos3a) > 0){
				foreach ($datos3a as $key => $value) {
					$sql7 = $db->consulta("DELETE FROM $tabla3 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion_orig"]."' AND cod_area='".$value["cod_area"]."'");
					$sql8 = $db->consulta("DELETE FROM feica_orden_produccion_area WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion_orig"]."' AND cod_area='".$value["cod_area"]."'");
					if($value["flg_facturacion"] == 'SI'){
						$sql9 = $db->consulta("DELETE FROM feide_orden_produccion_areaFacturacion_Fact WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion_orig"]."' AND cod_area='".$value["cod_area"]."'");
						$sql10 = $db->consulta("DELETE FROM feide_orden_produccion_areaFacturacion_GuiaR WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion_orig"]."' AND cod_area='".$value["cod_area"]."'");
					}else{
						$sql9 = $db->consulta("DELETE FROM feide_orden_produccion_area WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion_orig"]."' AND cod_area='".$value["cod_area"]."'");
						$sql10 = true;
					}					
				}
			}else{
				$sql7 = $sql8 = $sql9 = $sql10 = true;
			}
			//AREAS A INSERTAR
			if(count($datos3b) > 0){
				foreach ($datos3b as $key => $value) {
					$sql11 = $db->consulta("INSERT INTO $tabla3(cod_localidad,num_orden_produccion,cod_area) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."','".$value["cod_area"]."')");
				}
			}else{
				$sql11 = true;
			}
			if(count($datos2) > 0){
				foreach ($datos2 as $key => $value) {					
					if(count($datos3b) > 0){
						foreach ($datos3b as $key2 => $value2) {
							$sql12 = $db->consulta("INSERT INTO feica_orden_produccion_area(cod_localidad,num_orden_produccion,num_linea_orden_detalle,cod_producto,cod_area,cod_estado) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."','".$value["num_linea"]."','".$value["cod_producto"]."','".$value2["cod_area"]."','00001')");
						}
					}else{
						$sql12 = true;
					}
				}//foreach
			}else{
				$sql12 = true;
			}			
			$codActualizar = $datos1["num_orden_produccion_orig"];
			if($datos1["num_orden_produccion"] != $datos1["num_orden_produccion_orig"]){
				$codActualizar = $datos1["num_orden_produccion"];
				$sql13 = $db->consulta("UPDATE $tabla4 SET num_orden_produccion = '".$datos1["num_orden_produccion"]."' WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion = '".$datos1["num_orden_produccion_orig"]."'");
				$sql14 = $db->consulta("UPDATE $tabla5 SET num_orden_produccion = '".$datos1["num_orden_produccion"]."' WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion = '".$datos1["num_orden_produccion_orig"]."'");
			}else{
				$sql13 = $sql14 = true;
			}
			//if($datos4 != $datos5){
				if(count($datos4 > 0)){
					foreach ($datos4 as $key => $value) {
						//if($value["flg_documento"] != $datos5[$key]["flg_documento"]){
						if($value["flg_documento"] != $value["flg_documento_orginal"]){
							if($value["flg_documento"] == 'NO'){
								$sql15 = $db->consulta("DELETE FROM $tabla4 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$codActualizar."' AND num_linea='".$value["num_linea"]."'");
								$sql16 = $db->consulta("DELETE FROM $tabla5 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$codActualizar."' AND num_linea='".$value["num_linea"]."'");
							}else{
								$sql15 = $sql16 = true;
							}
						}else{
							$sql15 = $sql16 = true;	
						}
					}//foreach
					$sql17 = $db->consulta("SELECT MAX(num_linea) as maxNumLinea FROM $tabla4 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$codActualizar."'");
					$maxNumLna = $db->recorrer($sql17)["maxNumLinea"];
					$maxNumLna = ($maxNumLna == '') ? 1 : $maxNumLna+1;
					foreach ($datos4 as $key => $value) {
						if($value["flg_documento"] != $value["flg_documento_orginal"]){
							if($value["flg_documento"] 	!= 'NO'){
								$sql18 = $db->consulta("INSERT INTO $tabla4(cod_localidad,num_orden_produccion,num_linea,cod_documento) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$maxNumLna.",'".$value["cod_documento"]."')");
								$maxNumLna++;
							}else{
								$sql18 = true;
							}
						}else{
							$sql18 = true;
						}
					}//foreach
				}else{
					$sql15 = $sql16 = $sql17 = $sql18 = true;
				}
			/*}else{
				$sql12 = $sql13 = true;
			}*/
			//INSERTAR UNA OBSERVACION SI EL ESTADO CAMBIA A ANULADA
			if($flgAnulado == 'SI'){
				$maxNumLinea = 1;
				$sql19 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM feide_orden_produccion_observacion WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."'");
				while($key = $db->recorrer($sql19)){
					$maxNumLinea = $key["max_num_linea"];
				}
				$textoObservacion = 'La orden de produccion se ha cambiado a estado Anulado';
				$sql20 = $db->consulta("INSERT INTO feide_orden_produccion_observacion(cod_localidad,num_orden_produccion,num_linea,cod_usuario,fch_registro,dsc_observacion,flg_automatico) VALUES('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',$maxNumLinea,'".$datos1["cod_usuario_registro"]."','".$datos1["fch_registro"]."','".$textoObservacion."','SI')");
			}else{
				$sql19 = $sql20 = true;
			}
			//INSERTAR OBSERVACION SI ES QUE LA EL CHECK DE FECHA VALIDADA CAMBIA
			/*if($datos1["flg_fch_validada"] != $datos1["flg_fch_validada_orig"]){
				$maxNumLinea = 1;
				$sql19 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM feide_orden_produccion_observacion WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."'");
				while($key = $db->recorrer($sql19)){
					$maxNumLinea = $key["max_num_linea"];
				}
				$textoObservacion = 'Se ha cambiado el check de validado';
				$sql20 = $db->consulta("INSERT INTO feide_orden_produccion_observacion(cod_localidad,num_orden_produccion,num_linea,cod_usuario,fch_registro,dsc_observacion,flg_automatico) VALUES('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',$maxNumLinea,'".$datos1["cod_usuario_registro"]."','".$datos1["fch_registro"]."','".$textoObservacion."','SI')");
			}else{
				$sql19 = $sql20 = true;
			}*/
			if($sql1 && $sql1a && $sql2 && $sql3 && $sql4 && $sql4a && $sql4b && $sql4c && $sql5 && $sql5a && $sql6 && $sql7 && $sql8 && $sql9 && $sql10 && $sql11 && $sql12 && $sql13 && $sql14 && $sql15 && $sql16 && $sql17 && $sql18 && $sql19 && $sql20){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
		}else if($entrada == 'areaRelacOrdProd'){
			$sumNumCantidad = $cantidadProducto = 0;
			$maxNumLinea = 1;
			$flgPendiente = 'NO';
			$codEstadoProceso = '';
			$sql1 = $db->consulta("SELECT flg_pendiente,flg_terminado FROM vtama_estado_area_ordenProd WHERE cod_estado='".$datos1["cod_estado"]."'");
			while($key = $db->recorrer($sql1)){
				$flgPendiente = $key["flg_pendiente"];
			}
			if($flgPendiente == 'SI'){
				$sql2 = $db->consulta("SELECT cod_estado FROM vtama_estado_area_ordenProd WHERE flg_proceso='SI'");
				while($key = $db->recorrer($sql2)){
					$codEstadoProceso = $key["cod_estado"];
				}
				$sumNumCantidad = 0;
			}else{
				$codEstadoProceso = $datos1["cod_estado"];
				$sql2 = $db->consulta("SELECT ISNULL(SUM(num_cantidad),0) as sum_num_cantidad FROM feide_orden_produccion_area WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea_orden_detalle=".$datos1["num_linea_orden_detalle"]." AND cod_producto='".$datos1["cod_producto"]."' AND cod_area='".$datos1["cod_area"]."'");
				while($key = $db->recorrer($sql2)){
					$sumNumCantidad = $key["sum_num_cantidad"];
				}
			}
			$sql3 = $db->consulta("SELECT ctd_orden FROM feide_orden_produccion WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea=".$datos1["num_linea_orden_detalle"]." AND cod_producto='".$datos1["cod_producto"]."'");
			while($key = $db->recorrer($sql3)){
				$cantidadProducto = $key["ctd_orden"];
			}					
			if(($datos1["flg_pedido"] == 'NO' && $datos1["flg_compras"] == 'NO') && ((floatval($sumNumCantidad) + floatval($datos1["num_cantidad_atendida"])) > floatval($cantidadProducto))){
				$respuesta = 'mayor';
				if($sql1 && $sql2 && $sql3){
					return "mayor";
				}else{
					return "error";
				}
			}else{
				if(($datos1["flg_pedido"] == 'NO' && $datos1["flg_compras"] == 'NO') && (floatval($sumNumCantidad) + floatval($datos1["num_cantidad_atendida"])) == floatval($cantidadProducto)){
					$sql4 = $db->consulta("SELECT cod_estado FROM vtama_estado_area_ordenProd WHERE flg_terminado='SI'");
					while($key = $db->recorrer($sql4)){
						$codEstadoProceso = $key["cod_estado"];
					}
				}else{					
					$sql4 = true;
				}
				$sql5 = $db->consulta("UPDATE $tabla1 SET cod_estado='$codEstadoProceso' WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea_orden_detalle=".$datos1["num_linea_orden_detalle"]." AND cod_producto='".$datos1["cod_producto"]."' AND cod_area='".$datos1["cod_area"]."'");
				$sql6 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM feide_orden_produccion_area WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea_orden_detalle=".$datos1["num_linea_orden_detalle"]." AND cod_producto='".$datos1["cod_producto"]."' AND cod_area='".$datos1["cod_area"]."'");
				while($key = $db->recorrer($sql6)){
					$maxNumLinea = $key["max_num_linea"];
				}
				$sql7 = $db->consulta("INSERT INTO feide_orden_produccion_area(cod_localidad,num_orden_produccion,num_linea_orden_detalle,cod_producto,cod_area,num_linea,num_cantidad,fch_inicial,cod_usuario) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$datos1["num_linea_orden_detalle"].",'".$datos1["cod_producto"]."','".$datos1["cod_area"]."',$maxNumLinea,".$datos1["num_cantidad_atendida"].",".$datos1["fch_inicial"].",'".$datos1["cod_usuario"]."')");
				if($sql1 && $sql2 && $sql3 && $sql4 && $sql5 && $sql6 && $sql7){
					return "ok";
				}else{
					return "error";
				}
			}		
			$db->liberar($sql1);
			/*$db->liberar($sql2);
			$db->liberar($sql3);
			$db->liberar($sql4);*/

			/*$sql1= $db->consulta("UPDATE $tabla1 SET cod_estado='".$datos1["cod_estado"]."' WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND cod_area='".$datos1["cod_area"]."' AND cod_producto='".$datos1["cod_producto"]."'");
			$sql2 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM feide_orden_produccion_area WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND cod_area='".$datos1["cod_area"]."' AND cod_producto='".$datos1["cod_producto"]."'");
			while($key = $db->recorrer($sql2)){
				$maxNumLinea = $key["max_num_linea"];
			}
			$sql2 = $db->consulta("INSERT INTO feide_orden_produccion_area(cod_localidad,num_orden_produccion,cod_area,cod_producto,num_linea,num_cantidad,fch_inicial,cod_usuario) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."','".$datos1["cod_area"]."','".$datos1["cod_producto"]."',$maxNumLinea,".$datos1["num_cantidad"].",".$datos1["fch_inicial"].",'".$datos1["cod_usuario"]."')");
			if($sql1 && $sql2){
				return "ok";
			}else{
				return "error";
			}			
			$db->liberar($sql1);*/
		}else if($entrada == 'areaFacturacionRelacOrdProd'){
			$sql1 = $db->consulta("UPDATE $tabla1 SET cod_estado='".$datos1["cod_estado"]."' WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea_orden_detalle=".$datos1["num_linea_orden_detalle"]." AND cod_producto='".$datos1["cod_producto"]."' AND cod_area='".$datos1["cod_area"]."'");
			$maxNumLinea = 1;
			if($datos1["num_guia_remision"] != ''){
				$tabla = 'feide_orden_produccion_areaFacturacion_GuiaR';
				$sql2 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM $tabla WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea_orden_detalle=".$datos1["num_linea_orden_detalle"]." AND cod_producto='".$datos1["cod_producto"]."' AND cod_area='".$datos1["cod_area"]."'");
				while($key = $db->recorrer($sql2)){
					$maxNumLinea = $key["max_num_linea"];
				}
				$sql3 = $db->consulta("INSERT INTO $tabla(cod_localidad,num_orden_produccion,num_linea_orden_detalle,cod_producto,cod_area,num_linea,num_guia_remision,fch_emision,fch_registro) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$datos1["num_linea_orden_detalle"].",'".$datos1["cod_producto"]."','".$datos1["cod_area"]."',$maxNumLinea,'".$datos1["num_guia_remision"]."',".$datos1["fch_emision_guiaR"].",'".$datos1["fch_registro"]."')");
			}else{
				$sql2 = $sql3 = true;
			}
			if($datos1["num_facturacion"] != ''){
				$tabla = 'feide_orden_produccion_areaFacturacion_Fact';
				$sql4 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM $tabla WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea_orden_detalle=".$datos1["num_linea_orden_detalle"]." AND cod_producto='".$datos1["cod_producto"]."' AND cod_area='".$datos1["cod_area"]."'");
				while($key = $db->recorrer($sql2)){
					$maxNumLinea = $key["max_num_linea"];
				}
				$sql5 = $db->consulta("INSERT INTO $tabla(cod_localidad,num_orden_produccion,num_linea_orden_detalle,cod_producto,cod_area,num_linea,num_facturacion,fch_emision,fch_registro) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',".$datos1["num_linea_orden_detalle"].",'".$datos1["cod_producto"]."','".$datos1["cod_area"]."',$maxNumLinea,'".$datos1["num_facturacion"]."',".$datos1["fch_emision_fact"].",'".$datos1["fch_registro"]."')");
			}else{
				$sql4 = $sql5 = true;
			}
			if($sql1 && $sql2 && $sql3 && $sql4 && $sql5){
				return "ok";
			}else{
				return "error";
			}			
			$db->liberar($sql1);
			$db->liberar($sql2);
			$db->liberar($sql3);
			$db->liberar($sql4);
			$db->liberar($sql5);
		}
        $db->cerrar();
	}//function mdlEditarOrdenProduccion
	/*=============================================
	MOSTRAR COTIZACION RELACIODA A LA ORDEN DE COMPRA Y CLIENTE
	=============================================*/
	static public function mdlMostrarRelCotizacion($tabla1,$valor1,$valor2){
		$db = new Conexion();
		$fchEmisionOrdenCompra = '';
		$sql1 = $db->consulta("SELECT MIN(fchEmision_orden_compra) as fchEmision_orden_compra FROM $tabla1 WHERE $tabla1.cod_cliente='$valor1' AND $tabla1.dsc_orden_compra = '$valor2'");
		while($key = $db->recorrer($sql1)){
    		$fchEmisionOrdenCompra = ($key["fchEmision_orden_compra"] != '') ? dateFormat($key["fchEmision_orden_compra"]) : '';
		}
		$sql2 = $db->consulta("SELECT $tabla1.cod_cotizacion,vtama_producto.dsc_producto,vtade_cotizacion.num_ctd,vtama_unidad_medida.dsc_simbolo,vtade_cotizacion.cod_producto,vtade_cotizacion.cod_unidad_medida,'$fchEmisionOrdenCompra' as fchEmision_orden_compra FROM $tabla1 INNER JOIN vtade_cotizacion ON $tabla1.cod_cotizacion = vtade_cotizacion.cod_cotizacion INNER JOIN vtama_producto ON vtade_cotizacion.cod_producto = vtama_producto.cod_producto INNER JOIN vtama_unidad_medida ON vtade_cotizacion.cod_unidad_medida = vtama_unidad_medida.cod_unidad WHERE $tabla1.cod_cliente='$valor1' AND $tabla1.dsc_orden_compra = '$valor2'");
		$datos = array();
	    while($key2 = $db->recorrer($sql2)){	
	    	$datos[] = arrayMapUtf8Encode($key2);
	    }
	    $db->liberar($sql1);
	    $db->liberar($sql2);
	    $db->cerrar();
		return $datos;
	}//function mdlMostrarRelCotizacion
	/*=============================================
	CREAR ORDEN DE PRODUCCION OBSERVACION
	=============================================*/
	static public function mdlCrearOrdenProduccionObservacion($tabla1,$datos1){
		$db = new Conexion();
		$db->beginTransaction();
		$maxNumLinea = 1;
		$sql1 = $db->consulta("SELECT ISNULL(MAX(num_linea)+1,1) as max_num_linea FROM $tabla1 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."'");
		while($key = $db->recorrer($sql1)){
			$maxNumLinea = $key["max_num_linea"];
		}
		$sql2 = $db->consulta("INSERT INTO $tabla1(cod_localidad,num_orden_produccion,num_linea,cod_usuario,fch_registro,dsc_observacion,flg_automatico) VALUES ('".$datos1["cod_localidad"]."','".$datos1["num_orden_produccion"]."',$maxNumLinea,'".$datos1["cod_usuario"]."',CONVERT(datetime,'".$datos1["fch_registro"]."',21),'".$datos1["dsc_observacion"]."','".$datos1["flg_automatico"]."')");
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
	}//function mdlCrearOrdenProduccionObservacion
	/*=============================================
	MOSTRAR OBSERVACIONES
	=============================================*/
	static public function mdlMostrarTablaObservacionOrdPrd($tabla1,$localidad,$ordenProduccion){
		$db = new Conexion();
		$sql1 = $db->consulta("SELECT $tabla1.cod_localidad,$tabla1.num_orden_produccion,$tabla1.num_linea,(rhuma_trabajador.dsc_apellido_paterno+' '+rhuma_trabajador.dsc_apellido_materno+', '+rhuma_trabajador.dsc_nombres) as dsc_trabajador,$tabla1.fch_registro,$tabla1.dsc_observacion,$tabla1.flg_automatico FROM $tabla1 INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = $tabla1.cod_usuario WHERE $tabla1.cod_localidad='$localidad' AND $tabla1.num_orden_produccion='$ordenProduccion'");
		$datos = array();
		while($key = $db->recorrer($sql1)){	
			$datos[] = arrayMapUtf8Encode($key);
		}
		$db->liberar($sql1);
	    $db->cerrar();
		return $datos;
	}//function mdlMostrarTablaObservacionOrdPrd
	/*=============================================
	EDITAR ORDEN DE PRODUCCION OBSERVACION
	=============================================*/
	static public function mdlEditarOrdenProduccionObservacion($tabla1,$datos1){
		$db = new Conexion();
		$sql1 = $db->consulta("UPDATE $tabla1 SET dsc_observacion='".$datos1["dsc_observacion"]."' WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea=".$datos1["num_linea"]);
		if($sql1){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql1);
		$db->cerrar();
	}//function  mdlEditarOrdenProduccionObservacion
	/*=============================================
	ELIMINAR ORDEN DE PRODUCCION OBSERVACION
	=============================================*/
	static public function mdlEliminarOrdenProduccionObservacion($tabla1,$datos1){
		$db = new Conexion();
		$sql1 = $db->consulta("DELETE FROM $tabla1 WHERE cod_localidad='".$datos1["cod_localidad"]."' AND num_orden_produccion='".$datos1["num_orden_produccion"]."' AND num_linea=".$datos1["num_linea"]);
		if($sql1){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql1);
		$db->cerrar();
	}//function mdlEliminarOrdenProduccionObservacion
	/*=============================================
	MOSTRAR AREA X PRODUCTO
	=============================================*/
	static public function mdlMostrarAreaXProducto($tabla1,$localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$entrada){
		$db = new Conexion();
		if($entrada == 'areaFacturacion'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_localidad,$tabla1.num_orden_produccion,$tabla1.num_linea_orden_detalle,$tabla1.cod_producto,$tabla1.cod_area,rhuma_area.dsc_area,$tabla1.cod_estado FROM $tabla1 INNER JOIN rhuma_area ON rhuma_area.cod_area =$tabla1.cod_area WHERE $tabla1.cod_localidad='$localidad' AND $tabla1.num_orden_produccion='$ordenProduccion' AND $tabla1.num_linea_orden_detalle=$lineaOrdenDetalle AND cod_producto='$producto' AND $tabla1.cod_area='$area'");
		}else if($entrada == 'areaTodas'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_localidad,$tabla1.num_orden_produccion,$tabla1.cod_area,$tabla1.cod_producto,$tabla1.cod_estado,rhuma_area.dsc_area,(SELECT COUNT(num_orden_produccion) FROM feide_orden_produccion_area WHERE cod_localidad='$localidad' AND num_orden_produccion='$ordenProduccion' AND num_linea_orden_detalle=$lineaOrdenDetalle AND cod_producto='$producto' AND cod_area='$area' ) as contDetalle,vtama_estado_area_ordenProd.dsc_estado,vtama_estado_area_ordenProd.flg_pendiente,$tabla1.num_linea_orden_detalle,vtama_estado_area_ordenProd.flg_proceso,vtama_estado_area_ordenProd.flg_terminado FROM $tabla1 INNER JOIN rhuma_area ON rhuma_area.cod_area = $tabla1.cod_area LEFT JOIN vtama_estado_area_ordenProd ON feica_orden_produccion_area.cod_estado = vtama_estado_area_ordenProd.cod_estado WHERE $tabla1.cod_localidad='$localidad' AND $tabla1.num_orden_produccion='$ordenProduccion' AND $tabla1.num_linea_orden_detalle=$lineaOrdenDetalle AND cod_producto='$producto' AND $tabla1.cod_area='$area'");
		}
		$datos = $db->recorrer($sql1);
		$db->liberar($sql1);
		$db->cerrar();
		return $datos;
	}//function mdlMostrarAreaXProducto
	/*=============================================
	MOSTRAR AREA X PRODUCTO DETALLE
	=============================================*/
	static public function mdlMostrarAreaXProductoDetalle($tabla1,$localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area){
		$db = new Conexion();
		$sql1 = $db->consulta("SELECT $tabla1.num_cantidad,$tabla1.fch_inicial,(rhuma_trabajador.dsc_apellido_paterno+' '+rhuma_trabajador.dsc_apellido_materno+', '+rhuma_trabajador.dsc_nombres) as dsc_trabajador FROM $tabla1 INNER JOIN rhuma_area ON rhuma_area.cod_area =$tabla1.cod_area INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = $tabla1.cod_usuario WHERE $tabla1.cod_localidad='$localidad' AND $tabla1.num_orden_produccion='$ordenProduccion' AND $tabla1.num_linea_orden_detalle='$lineaOrdenDetalle' AND cod_producto='$producto' AND $tabla1.cod_area='$area' ORDER BY $tabla1.fch_inicial ASC");
		$datos = array();
	    while($key = $db->recorrer($sql1)){	
	    	$datos[] = arrayMapUtf8Encode($key);
	    }
		$db->liberar($sql1);
		$db->cerrar();
		return $datos;
	}//function mdlMostrarAreaXProducto
	/*=============================================
	MOSTRAR ESTADO AREA
	=============================================*/
	static public function mdlMostrarEstadoArea($tabla1,$flgPendiente,$entrada){
		$db = new Conexion();
		if($entrada == 'estadoNoPnd'){
			$sql1 = $db->consulta("SELECT cod_estado,dsc_estado FROM $tabla1 WHERE flg_pendiente='$flgPendiente'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
			$db->liberar($sql1);
		}
		$db->cerrar();
		return $datos;
	}//function mdlMostrarEstadoArea
	/*=============================================
	MOSTRAR EL HISTORICO DE REMISION DE LA AREA FACTURACION
	=============================================*/
	static public function mdlMostrarHistoricoAreaFacturacion($localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$flgGuiaRemision,$entrada){
		$db = new Conexion();
		if($flgGuiaRemision == 'SI'){
			$tabla = 'feide_orden_produccion_areaFacturacion_GuiaR';
			$sql1 = $db->consulta("SELECT num_guia_remision,fch_emision,fch_registro FROM $tabla INNER JOIN rhuma_area ON rhuma_area.cod_area =$tabla.cod_area WHERE $tabla.cod_localidad='$localidad' AND $tabla.num_orden_produccion='$ordenProduccion' AND $tabla.num_linea_orden_detalle='$lineaOrdenDetalle' AND cod_producto='$producto' AND $tabla.cod_area='$area'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else{
			$tabla = 'feide_orden_produccion_areaFacturacion_Fact';
			$sql1 = $db->consulta("SELECT num_facturacion,fch_emision,fch_registro FROM $tabla INNER JOIN rhuma_area ON rhuma_area.cod_area =$tabla.cod_area WHERE $tabla.cod_localidad='$localidad' AND $tabla.num_orden_produccion='$ordenProduccion' AND $tabla.num_linea_orden_detalle='$lineaOrdenDetalle' AND cod_producto='$producto' AND $tabla.cod_area='$area'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}
		$db->cerrar();
		return $datos;
	}//function mdlMostrarHistoricoAreaFacturacion
	static public function mdlConsultarOrdenProudccion($datos,$entrada){
		$db = new Conexion();
		if($entrada == 'listadoAreas'){
			$sql1 = $db->consulta("SELECT feivi_orden_produccion_area.cod_area,'SI' as flg_area,rhuma_area.flg_facturacion FROM feivi_orden_produccion_area INNER JOIN rhuma_area ON feivi_orden_produccion_area.cod_area = rhuma_area.cod_area WHERE cod_localidad='".$datos["cod_localidad"]."' AND num_orden_produccion='".$datos["num_orden_produccion"]."'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}//if
		$db->cerrar();
		return $datos;
	}//function mdlConsultarOrdenProudccion
	static public function mdlMostrarSede($tabla,$item1,$valor1){
		$db = new Conexion();
		$sql1 = $db->consulta("SELECT cod_sede,dsc_sede FROM $tabla WHERE $item1 = '$valor1' ORDER BY flg_principal DESC");
		$datos = array();
		while($key = $db->recorrer($sql1)){	
	    	$datos[] = arrayMapUtf8Encode($key);
	    }
	    $db->liberar($sql1);
	    $db->cerrar();
		return $datos;
	}//function mdlMostrarSede
	static public function mdlConsultarEstadoOrdProd($tabla,$codEstado,$localidad,$ordenProduccion,$entrada){
		$db = new Conexion();
		if($entrada == 'flgEstados'){
			$flgAnulado = $flgCulminado = 'NO';
			$estadoTerminado = 'SI';
			$sql1 = $db->consulta("SELECT flg_anulado,flg_culminado FROM $tabla WHERE cod_estado='".$codEstado."'");
			//$datos = $db->recorrer($sql1);
			while($key = $db->recorrer($sql1)){
				$flgAnulado = $key["flg_anulado"];
				$flgCulminado = $key["flg_culminado"];
			}
			if($flgCulminado == 'SI'){
				$sql2 = $db->consulta("SELECT vtama_estado_area_ordenProd.flg_terminado FROM feica_orden_produccion_area INNER JOIN vtama_estado_area_ordenProd ON vtama_estado_area_ordenProd.cod_estado = feica_orden_produccion_area.cod_estado INNER JOIN rhuma_area ON rhuma_area.cod_area = feica_orden_produccion_area.cod_area WHERE cod_localidad = '$localidad' AND num_orden_produccion = '$ordenProduccion' AND flg_facturacion = 'NO'");
				while($key = $db->recorrer($sql2)){
					if($key["flg_terminado"] == 'NO'){
						$estadoTerminado = 'NO';	
					}
				}
			}
			$datos = $flgAnulado.'|'.$flgCulminado.'|'.$estadoTerminado;
			$db->liberar($sql1);
		}
		$db->cerrar();
		return $datos;
	}//function mdlConsultarEstadoOrdProd

	/*=============================================
	MOSTRAR RESUMEN DE ORDEN DE PRODUCCION

		$tabla1 = 'feica_orden_produccion';
		$tabla2 = 'feide_orden_produccion';
		$tabla3 = 'vtama_producto';
		$tabla4 = 'vtama_unidad_medida';
		$tabla5 = 'vtama_estado_orden_produccion';
		$tabla6 = 'feivi_orden_produccion_area';
		$tabla7 = 'rhuma_trabajador';
		$tabla8 = 'feivi_orden_produccion_documento_usuario';
		$tabla9 = 'vtama_cliente';
		$tabla10 = 'rhuma_area';
	=============================================*/
	static public function mdlMostrarResumenOP($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6,$tabla7,$tabla8,$tabla9,$tabla10){
		$db = new Conexion();
		if($entrada == 'datatableListado'){
			$condicion = '';
			if($valor1 != ''){
				if($condicion != ''){ $condicion .= " AND feide_orden_produccion.fch_validada BETWEEN '$valor1' AND '$valor2'"; }
				else{ $condicion = "AND feide_orden_produccion.fch_validada BETWEEN '$valor1' AND '$valor2'"; }
			}
			if($valor3 != 'todos'){
				if($condicion != ''){ $condicion .= " AND ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }
				else{ $condicion = "AND ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }	
			}
			if($valor4 != 'todos'){
				if($condicion != ''){ $condicion .= " AND feide_orden_produccion.$item4 = '$valor4'"; }
				else{ $condicion = "AND feide_orden_produccion.$item4 = '$valor4'"; }	
			}
			$sql1 = $db->consulta("SELECT DISTINCT feica_orden_produccion.cod_localidad,feica_orden_produccion.num_orden_produccion,feide_orden_produccion.num_linea,vtama_producto.cod_producto,vtama_producto.dsc_producto,feide_orden_produccion.ctd_orden,vtama_unidad_medida.dsc_simbolo,feide_orden_produccion.fch_entrega,vtama_estado_orden_produccion.dsc_estado,vtama_cliente.dsc_razon_social,vtama_estado_orden_produccion.dsc_color,feide_orden_produccion.fch_validada,feide_orden_produccion.flg_fch_validada,DATEDIFF(DAY,CONVERT(date, GETDATE()),feide_orden_produccion.fch_validada) AS difFechaValidada,feide_orden_produccion.flg_fch_validada_modificado FROM feica_orden_produccion LEFT JOIN feide_orden_produccion ON feide_orden_produccion.cod_localidad = feica_orden_produccion.cod_localidad AND feide_orden_produccion.num_orden_produccion = feica_orden_produccion.num_orden_produccion LEFT JOIN vtama_producto ON vtama_producto.cod_producto = feide_orden_produccion.cod_producto LEFT JOIN vtama_unidad_medida ON vtama_unidad_medida.cod_unidad = feide_orden_produccion.cod_unidad LEFT JOIN vtama_estado_orden_produccion ON vtama_estado_orden_produccion.cod_estado = feica_orden_produccion.cod_estado INNER JOIN vtama_cliente ON feica_orden_produccion.cod_cliente = vtama_cliente.cod_cliente LEFT JOIN feica_orden_produccion_area ON feide_orden_produccion.cod_localidad = feica_orden_produccion_area.cod_localidad AND feide_orden_produccion.num_orden_produccion = feica_orden_produccion_area.num_orden_produccion AND feide_orden_produccion.num_linea = feica_orden_produccion_area.num_linea_orden_detalle WHERE feide_orden_produccion.fch_validada = (SELECT MIN(fch_validada) FROM feide_orden_produccion WHERE feide_orden_produccion.cod_localidad = feica_orden_produccion.cod_localidad AND feide_orden_produccion.num_orden_produccion = feica_orden_produccion.num_orden_produccion) $condicion ORDER BY feica_orden_produccion.num_orden_produccion,feide_orden_produccion.fch_entrega ASC");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'vtnOrdenProduccionExcel'){
			$condicion = '';
			if($valor1 != ''){
				if($condicion != ''){ $condicion .= " AND feide_orden_produccion.$item1 BETWEEN '$valor1' AND '$valor2'"; }
				else{ $condicion = "WHERE feide_orden_produccion.$item1 BETWEEN '$valor1' AND '$valor2'"; }
			}
			if($valor3 != 'todos'){
				if($condicion != ''){ $condicion .= " AND ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }
				else{ $condicion = "WHERE ISNULL(feica_orden_produccion_area.$item3,'%') = '$valor3'"; }	
			}
			if($valor4 != 'todos'){
				if($condicion != ''){ $condicion .= " AND feide_orden_produccion.$item4 = '$valor4'"; }
				else{ $condicion = "WHERE feide_orden_produccion.$item4 = '$valor4'"; }	
			}
			$sql1 = $db->consulta("SELECT DISTINCT $tabla1.cod_localidad,$tabla1.num_orden_produccion,$tabla1.dsc_orden,$tabla1.fch_compromiso,$tabla1.dsc_orden_compra,$tabla1.fch_validada AS fch_validada_cab,feide_orden_produccion.num_linea,vtama_producto.dsc_producto,feide_orden_produccion.ctd_orden,vtama_unidad_medida.dsc_simbolo,feide_orden_produccion.fch_entrega,vtama_estado_orden_produccion.dsc_estado,vtama_cliente.dsc_razon_social,feide_orden_produccion.cod_producto,feide_orden_produccion.fch_validada,feide_orden_produccion.cod_cotizacion,feide_orden_produccion.flg_fch_validada,feide_orden_produccion.imp_area,feide_orden_produccion.imp_peso,(rhuma_trabajador.dsc_apellido_paterno + rhuma_trabajador.dsc_apellido_materno+', '+rhuma_trabajador.dsc_nombres) as dsc_trabajador,$tabla1.fch_registro,vtama_sede.dsc_sede,feide_orden_produccion.flg_fch_validada_modificado FROM $tabla1 LEFT JOIN feide_orden_produccion ON feide_orden_produccion.cod_localidad = $tabla1.cod_localidad AND feide_orden_produccion.num_orden_produccion = $tabla1.num_orden_produccion LEFT JOIN vtama_producto ON vtama_producto.cod_producto = feide_orden_produccion.cod_producto LEFT JOIN vtama_unidad_medida ON vtama_unidad_medida.cod_unidad = feide_orden_produccion.cod_unidad LEFT JOIN feica_orden_produccion_area ON feide_orden_produccion.cod_localidad = feica_orden_produccion_area.cod_localidad AND feide_orden_produccion.num_orden_produccion = feica_orden_produccion_area.num_orden_produccion AND feide_orden_produccion.num_linea = feica_orden_produccion_area.num_linea_orden_detalle LEFT JOIN vtama_estado_orden_produccion ON vtama_estado_orden_produccion.cod_estado = $tabla1.cod_estado INNER JOIN vtama_cliente ON $tabla1.cod_cliente = vtama_cliente.cod_cliente INNER JOIN rhuma_trabajador ON $tabla1.cod_usuario_registro = rhuma_trabajador.cod_trabajador LEFT JOIN vtama_sede ON vtama_sede.cod_sede = $tabla1.cod_sede $condicion ORDER BY $tabla1.num_orden_produccion,feide_orden_produccion.fch_validada ASC");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'vtnOrdenProduccionExcelDetalle'){
			$sql1 = $db->consulta("SELECT $tabla1.cod_localidad,$tabla1.num_orden_produccion,feide_orden_produccion.num_linea,feide_orden_produccion.ctd_orden,vtama_producto.dsc_producto,vtama_unidad_medida.dsc_simbolo,feide_orden_produccion.imp_area,feide_orden_produccion.imp_peso,feide_orden_produccion.fch_validada FROM $tabla1 LEFT JOIN vtama_producto ON vtama_producto.cod_producto = feide_orden_produccion.cod_producto LEFT JOIN vtama_unidad_medida ON vtama_unidad_medida.cod_unidad = feide_orden_produccion.cod_unidad WHERE $tabla1.$item1 = '$valor1' AND $tabla1.$item2 = '$valor2'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'areaRelacOrdProd'){
			$sql1 = $db->consulta("SELECT $tabla6.cod_localidad,$tabla6.num_orden_produccion,$tabla6.num_linea,$tabla6.cod_estado,$tabla6.imp_porcentaje,$tabla6.fecha,$tabla10.dsc_area FROM $tabla6 INNER JOIN $tabla10 ON $tabla6.cod_area = $tabla10.cod_area WHERE $tabla6.$item1='$valor1' AND $tabla6.$item2='$valor2' AND $tabla6.$item3=$valor3");
			$datos = $db->recorrer($sql1);
			$db->liberar($sql1);
		}else if($entrada == 'datosFormulario'){
			$sql1 = $db->consulta("SELECT ($tabla7.dsc_apellido_paterno+' '+$tabla7.dsc_apellido_materno+', '+$tabla7.dsc_nombres) AS full_nombre,$tabla7.cod_trabajador,$tabla1.fch_registro,$tabla1.num_orden_produccion,$tabla1.cod_estado,$tabla1.dsc_orden,$tabla1.fch_compromiso,$tabla1.cod_cliente,$tabla1.dsc_orden_compra,$tabla1.fch_validada,$tabla1.flg_fch_validada,$tabla1.cod_sede,$tabla5.flg_anulado,$tabla5.dsc_estado,$tabla9.dsc_razon_social,vtama_sede.dsc_sede FROM $tabla1 INNER JOIN $tabla7 ON $tabla1.cod_usuario_registro = $tabla7.cod_trabajador INNER JOIN $tabla5 ON $tabla5.cod_estado = $tabla1.cod_estado INNER JOIN $tabla9 ON $tabla1.cod_cliente = $tabla9.cod_cliente INNER JOIN vtama_sede ON vtama_sede.cod_sede = $tabla1.cod_sede WHERE $tabla1.$item1='$valor1' AND $tabla1.$item2='$valor2'");
			$datos = $db->recorrer($sql1);
			$db->liberar($sql1);
		}else if($entrada == 'productoRelacOrdProd'){
			$sql1 = $db->consulta("SELECT $tabla2.num_linea,$tabla2.cod_cotizacion,$tabla2.fch_entrega,$tabla2.imp_area,$tabla2.imp_peso,$tabla3.dsc_producto,$tabla2.ctd_orden,$tabla4.dsc_simbolo,$tabla3.cod_producto,$tabla2.cod_unidad,$tabla2.fch_validada,$tabla2.flg_fch_validada,$tabla2.flg_fch_validada_modificado FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.cod_localidad = $tabla2.cod_localidad AND $tabla1.num_orden_produccion = $tabla2.num_orden_produccion INNER JOIN $tabla3 ON $tabla2.cod_producto = $tabla3.cod_producto LEFT JOIN $tabla4 ON $tabla4.cod_unidad = $tabla2.cod_unidad WHERE $tabla2.$item1='$valor1' AND $tabla2.$item2='$valor2'");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'usuarioDocRelacOrdProd'){
			$sql1 = $db->consulta("SELECT $tabla8.cod_usuario FROM $tabla8 WHERE $tabla8.$item1='$valor1' AND $tabla8.$item2='$valor2' AND $tabla8.$item3=$valor3");
			$datos = array();
		    while($key = $db->recorrer($sql1)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		    $db->liberar($sql1);
		}else if($entrada == 'modalObservacion'){
			$sql1 = $db->consulta("SELECT dsc_observacion FROM feide_orden_produccion_observacion WHERE $item1='$valor1' AND $item2='$valor2' AND $item3=$valor3");
			$datos = $db->recorrer($sql1);
			$db->liberar($sql1);
		}
        $db->cerrar();
		return $datos;
	}//function mdlMostrarOrdenProduccion
}//class ModeloOrdenProduccion
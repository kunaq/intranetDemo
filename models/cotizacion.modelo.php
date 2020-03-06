<?php
require_once "conexion.php";
class ModeloCotizacion{
	/*=============================================
	CREAR COTIZACION
	=============================================*/
	static public function mdlIngresarCotizacion($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$db->beginTransaction();
		$sql1 = $db->consulta("INSERT INTO $tabla(cod_cotizacion,cod_estado_cotizacion,cod_cliente,cod_moneda,cod_forma_pago,dsc_contacto,dsc_correo,dsc_cargo,dsc_telefono,dsc_orden_compra,dsc_referencia,dsc_lugar_entrega,dsc_tiempo_entrega,dsc_validez_oferta,dsc_garantia,fch_emision,cod_usr_registro,fch_registro,imp_subtotal,imp_igv,imp_total,dsc_observacion,cod_tipo_descuento,imp_descuento,flg_descuento,cod_cotizacion_principal,num_orden_produccion,fchEmision_orden_compra) VALUES ('".$datos["cod_cotizacion"]."','".$datos["cod_estado_cotizacion"]."','".$datos["cod_cliente"]."','".$datos["cod_moneda"]."','".$datos["cod_forma_pago"]."','".$datos["dsc_contacto"]."','".$datos["dsc_correo"]."','".$datos["dsc_cargo"]."','".$datos["dsc_telefono"]."','".$datos["dsc_orden_compra"]."','".$datos["dsc_referencia"]."','".$datos["dsc_lugar_entrega"]."','".$datos["dsc_tiempo_entrega"]."','".$datos["dsc_validez_oferta"]."','".$datos["dsc_garantia"]."','".$datos["fch_emision"]."','".$datos["cod_usr_registro"]."',CONVERT(datetime,'".$datos["fch_registro"]."',21),".$datos["imp_subtotal"].",".$datos["imp_igv"].",".$datos["imp_total"].",'".$datos["dsc_observacion"]."','".$datos["cod_tipo_descuento"]."',".$datos["imp_descuento"].",'".$datos["flg_descuento"]."','".$datos["cod_cotizacion_principal"]."','".$datos["num_orden_produccion"]."',".$datos["fchEmision_orden_compra"].")");
		$sql2 = $db->consulta("SELECT cod_estado_cotizacion FROM vtama_estado_cotizacion WHERE flg_aprobado = 'SI'");
		$estadoCot = $db->recorrer($sql2)["cod_estado_cotizacion"];
		if($datos["dsc_orden_compra"] != ''){
			$sql3 = $db->consulta("UPDATE $tabla SET cod_estado_cotizacion = '$estadoCot' WHERE cod_cotizacion = '".$datos["cod_cotizacion"]."'");
		}
		if($datos["dsc_orden_compra"] != ''){
			if($sql1 && $sql2 && $sql3){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql1);
			$db->liberar($sql2);
			$db->liberar($sql3);
		}else{
			if($sql1){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql);
		}
        $db->cerrar();
	}//function mdlIngresarCotizacion
	/*=============================================
	EDITAR COTIZACION
	=============================================*/
	static public function mdlEditarCotizacion($tabla,$datos,$entrada){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$db->beginTransaction();
		if($entrada == 'estadoAprobado'){
			$sql1 = $db->consulta("UPDATE $tabla SET num_orden_produccion = '".$datos["num_orden_produccion"]."' WHERE cod_cotizacion = '".$datos["cod_cotizacion"]."'");
			if($sql1){
				$db->commit();
				return "ok";
			}else{
				$db->rollback();
				return "error";
			}
			$db->liberar($sql1);
		}else{
			$sql1 = $db->consulta("UPDATE $tabla SET cod_estado_cotizacion ='".$datos["cod_estado_cotizacion"]."',cod_cliente ='".$datos["cod_cliente"]."',cod_moneda ='".$datos["cod_moneda"]."',cod_forma_pago ='".$datos["cod_forma_pago"]."',dsc_contacto ='".$datos["dsc_contacto"]."',dsc_correo ='".$datos["dsc_correo"]."',dsc_cargo ='".$datos["dsc_cargo"]."',dsc_telefono ='".$datos["dsc_telefono"]."',dsc_orden_compra ='".$datos["dsc_orden_compra"]."',dsc_referencia ='".$datos["dsc_referencia"]."',dsc_lugar_entrega ='".$datos["dsc_lugar_entrega"]."',dsc_tiempo_entrega ='".$datos["dsc_tiempo_entrega"]."',dsc_validez_oferta ='".$datos["dsc_validez_oferta"]."',dsc_garantia ='".$datos["dsc_garantia"]."',fch_emision = '".$datos["fch_emision"]."',cod_usr_modifica ='".$datos["cod_usr_modifica"]."',fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21),imp_subtotal =".$datos["imp_subtotal"].",imp_igv =".$datos["imp_igv"].",imp_total =".$datos["imp_total"].",dsc_observacion ='".$datos["dsc_observacion"]."',cod_tipo_descuento='".$datos["cod_tipo_descuento"]."',imp_descuento='".$datos["imp_descuento"]."',flg_descuento='".$datos["flg_descuento"]."',cod_cotizacion='".$datos["cod_cotizacion_nuevo"]."',num_orden_produccion='".$datos["num_orden_produccion"]."',fchEmision_orden_compra=".$datos["fchEmision_orden_compra"]." WHERE cod_cotizacion = '".$datos["cod_cotizacion"]."'");
			$sql1_2 = $db->consulta("UPDATE vtade_cotizacion SET cod_cotizacion='".$datos["cod_cotizacion_nuevo"]."' WHERE cod_cotizacion = '".$datos["cod_cotizacion"]."'");
			$sql1_3 = $db->consulta("UPDATE vtade_cotizacion_adjunto SET cod_cotizacion='".$datos["cod_cotizacion_nuevo"]."' WHERE cod_cotizacion = '".$datos["cod_cotizacion"]."'");
			$sql2 = $db->consulta("SELECT cod_estado_cotizacion FROM vtama_estado_cotizacion WHERE flg_aprobado = 'SI'");
			$estadoCot = $db->recorrer($sql2)["cod_estado_cotizacion"];
			if($datos["dsc_orden_compra"] != ''){
				$sql3 = $db->consulta("UPDATE $tabla SET cod_estado_cotizacion = '$estadoCot' WHERE cod_cotizacion = '".$datos["cod_cotizacion"]."'");
			}
			if($datos["dsc_orden_compra"] != ''){
				if($sql1 && $sql1_2 && $sql1_3 && $sql2 && $sql3){
					$db->commit();
					return "ok";
				}else{
					$db->rollback();
					return "error";
				}
				$db->liberar($sql1);
				$db->liberar($sql2);
				$db->liberar($sql3);
			}else{
				if($sql1 && $sql1_2 && $sql1_3){
					$db->commit();
					return "ok";
				}else{
					$db->rollback();
					return "error";
				}
				$db->liberar($sql);
			}
		}
        $db->cerrar();
	}//function mdlEditarCotizacion
	static public function mdlIngresarCotizacionDetalle($tabla, $codigo, $listaProductos){
		$db = new Conexion();
		foreach ($listaProductos as $key => $value) {
			$sql =  $db->consulta("INSERT INTO $tabla(cod_cotizacion,num_linea,cod_producto,cod_unidad_medida,num_ctd,imp_subtotal,flg_porcentaje,num_dscto,total_dscto,imp_total,dsc_observacion) VALUES ('".$codigo."',".$value["num_linea"].",'".$value["cod_producto"]."','".$value["cod_unidad_medida"]."',".$value["num_ctd"].",".$value["imp_subtotal"].",'".$value["flg_porcentaje"]."',".$value["num_dscto"].",".$value["total_dscto"].",".$value["imp_total"].",'".$value["dsc_observacion"]."')");
		}
		return "ok";
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarCotizacionDetalle
	/*=============================================
	INGRESAR DATOS ADJUNTOS A LA COTIZACION
	=============================================*/
	static public function mdlIngresarCotizacionAdjunto($tabla, $datos, $datos2, $datos3, $codigo){
		$db = new Conexion();
		foreach ($datos as $key => $value) {
			$sql = $db->consulta("INSERT INTO $tabla(cod_cotizacion,num_linea,dsc_ruta_archivo,dsc_archivo) VALUES('".$codigo."',".$datos2[$key].",'".Utf8Decode($value)."','".Utf8Decode($datos3[$key])."')");
		}
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarCotizacionAdjunto
	/*=============================================
	MOSTRAR COTIZACION
	=============================================*/
	//static public function mdlMostrarCotizacion($tabla,$item,$valor,$entrada,$cliente,$producto,$fechaInicial,$fechaFinal){
	static public function mdlMostrarCotizacion($tabla1,$valor1,$valor2,$valor3,$valor4,$valor5,$entrada){
		$db = new Conexion();
		if($entrada == 'pdf'){
			$sql = $db->consulta("SELECT $tabla1.cod_cotizacion,$tabla1.fch_emision,$tabla1.cod_estado_cotizacion,$tabla1.dsc_contacto,$tabla1.dsc_correo,$tabla1.dsc_cargo,$tabla1.dsc_telefono,$tabla1.dsc_referencia,$tabla1.cod_cliente,$tabla1.imp_subtotal,$tabla1.imp_igv,$tabla1.imp_total,$tabla1.cod_moneda,$tabla1.cod_forma_pago,$tabla1.dsc_lugar_entrega,$tabla1.dsc_tiempo_entrega,$tabla1.dsc_validez_oferta,$tabla1.dsc_garantia,vtama_cliente.dsc_razon_social,vtama_cliente.dsc_direccion,vtama_pais.dsc_pais,vtama_departamento.dsc_departamento,vtama_provincia.dsc_provincia,vtama_distrito.dsc_distrito,vtama_forma_pago.dsc_forma_pago,vtama_moneda.dsc_simbolo,$tabla1.dsc_observacion,$tabla1.dsc_orden_compra,$tabla1.num_orden_produccion FROM $tabla1 INNER JOIN vtama_cliente ON vtama_cliente.cod_cliente = $tabla1.cod_cliente INNER JOIN vtama_pais ON vtama_pais.cod_pais = vtama_cliente.cod_pais LEFT JOIN vtama_departamento ON vtama_departamento.cod_departamento = vtama_cliente.cod_departamento LEFT JOIN vtama_provincia ON vtama_provincia.cod_provincia = vtama_cliente.cod_provincia LEFT JOIN vtama_distrito ON vtama_distrito.cod_distrito = vtama_cliente.cod_distrito INNER JOIN vtama_forma_pago ON vtama_forma_pago.cod_forma_pago = $tabla1.cod_forma_pago INNER JOIN vtama_moneda ON vtama_moneda.cod_moneda = $tabla1.cod_moneda WHERE $tabla1.cod_cotizacion = '$valor1'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else if($entrada == 'enviarCorreo'){
			$sql = $db->consulta("SELECT dsc_correo FROM $tabla1 WHERE $tabla1.cod_cotizacion = '$valor1'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else if($entrada == 'formularioPrincipal'){
			$sql = $db->consulta("SELECT $tabla1.cod_cotizacion,$tabla1.fch_emision,$tabla1.cod_estado_cotizacion,$tabla1.dsc_contacto,$tabla1.dsc_correo,$tabla1.dsc_cargo,$tabla1.dsc_telefono,$tabla1.dsc_orden_compra,$tabla1.dsc_referencia,$tabla1.cod_cliente,$tabla1.imp_subtotal,$tabla1.imp_igv,$tabla1.imp_total,$tabla1.cod_moneda,$tabla1.cod_forma_pago,$tabla1.dsc_lugar_entrega,$tabla1.dsc_tiempo_entrega,$tabla1.dsc_validez_oferta,$tabla1.dsc_garantia,$tabla1.dsc_observacion,$tabla1.cod_tipo_descuento,$tabla1.flg_descuento,$tabla1.imp_descuento,vtama_cliente.dsc_documento,vtama_cliente.dsc_direccion,vtama_distrito.dsc_distrito,vtama_provincia.dsc_provincia,vtama_departamento.dsc_departamento,vtama_pais.dsc_pais,$tabla1.num_orden_produccion,vtama_estado_cotizacion.flg_aprobado,vtama_pais.flg_peru,$tabla1.fchEmision_orden_compra FROM $tabla1 INNER JOIN vtama_cliente ON vtama_cliente.cod_cliente = $tabla1.cod_cliente LEFT JOIN vtama_pais ON vtama_pais.cod_pais = vtama_cliente.cod_pais LEFT JOIN vtama_departamento ON vtama_departamento.cod_departamento = vtama_cliente.cod_departamento LEFT JOIN vtama_provincia ON vtama_provincia.cod_provincia = vtama_cliente.cod_provincia LEFT JOIN vtama_distrito ON vtama_distrito.cod_distrito = vtama_cliente.cod_distrito INNER JOIN vtama_estado_cotizacion ON $tabla1.cod_estado_cotizacion = vtama_estado_cotizacion.cod_estado_cotizacion WHERE $tabla1.cod_cotizacion = '$valor1'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else if($entrada == 'estadoReporteCtz'){
			$condicion = '';
			//Fecha Inicio, Fecha Fin
			if($valor4 != '' && $valor5 == ''){
				$condicion = " AND CONVERT(date,$tabla1.fch_emision,105) >= CONVERT(date,'$valor4',105)";
			}
			if($valor4 == '' && $valor5 != ''){
				$condicion = " AND CONVERT(date,$tabla1.fch_emision,105) >= CONVERT(date,'$valor5',105)";
			}
			if($valor4 != '' && $valor5 != ''){
				$condicion = " AND CONVERT(date,$tabla1.fch_emision,105) BETWEEN CONVERT(date,'$valor4',105) AND CONVERT(date,'$valor5',105)";
			}
			$sql = $db->consulta("SELECT COUNT($tabla1.cod_estado_cotizacion) as contEstado, vtama_estado_cotizacion.dsc_estado_cotizacion,vtama_estado_cotizacion.flg_pendiente,vtama_estado_cotizacion.flg_aprobado FROM $tabla1 RIGHT JOIN vtama_estado_cotizacion ON $tabla1.cod_estado_cotizacion = vtama_estado_cotizacion.cod_estado_cotizacion WHERE (vtama_estado_cotizacion.flg_pendiente = 'SI' OR vtama_estado_cotizacion.flg_aprobado = 'SI') $condicion GROUP BY $tabla1.cod_estado_cotizacion,vtama_estado_cotizacion.dsc_estado_cotizacion,vtama_estado_cotizacion.flg_pendiente,vtama_estado_cotizacion.flg_aprobado");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}else if($entrada == 'estadoReporteCtz2'){
			$condicion = '';
			//Fecha Inicio, Fecha Fin
			if($valor4 != '' && $valor5 == ''){
				$condicion = " AND CONVERT(date,$tabla1.fch_emision,105) >= CONVERT(date,'$valor4',105)";
			}
			if($valor4 == '' && $valor5 != ''){
				$condicion = " AND CONVERT(date,$tabla1.fch_emision,105) >= CONVERT(date,'$valor5',105)";
			}
			if($valor4 != '' && $valor5 != ''){
				$condicion = " AND CONVERT(date,$tabla1.fch_emision,105) BETWEEN CONVERT(date,'$valor4',105) AND CONVERT(date,'$valor5',105)";
			}
			$sql = $db->consulta("SELECT datepart(month, fch_emision) as numMes,SUM( CASE WHEN vtama_estado_cotizacion.flg_pendiente = 'SI' THEN 1 ELSE 0 END ) AS num_pendiente,SUM( CASE WHEN vtama_estado_cotizacion.flg_aprobado = 'SI' THEN 1 ELSE 0 END ) AS num_aprobado,COUNT(1) AS num_total FROM $tabla1 RIGHT JOIN vtama_estado_cotizacion ON $tabla1.cod_estado_cotizacion = vtama_estado_cotizacion.cod_estado_cotizacion WHERE (vtama_estado_cotizacion.flg_pendiente = 'SI' OR vtama_estado_cotizacion.flg_aprobado = 'SI') $condicion GROUP BY datepart(month,fch_emision)");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}else if($entrada == 'datatablePrincipal'){
			if($valor1 != null || $valor2 != null || $valor3 != null){
				$condicion = '';
				//CLIENTE
				if($valor1 != ''){
					if($condicion != ''){ $condicion .= " AND vtama_cliente.dsc_razon_social LIKE '%$valor1%'"; }
					else{ $condicion = "AND vtama_cliente.dsc_razon_social LIKE '%$cliente%'"; }
				}
				//PRODUCTO
				if($valor2 != ''){
					if($condicion != ''){ $condicion .= " AND vtama_producto.dsc_producto LIKE '%$valor2%'"; }
					else{ $condicion = "AND vtama_producto.dsc_producto LIKE '%$valor2%'"; } 
				}
				//FECHA INICIAL, FECHA FINAL
				if($valor3 != ''){
					if($condicion != ''){ $condicion .= " AND $tabla1.fch_emision BETWEEN '$valor3' AND '$valor4'"; }
					else{ $condicion = "AND $tabla1.fch_emision BETWEEN '$valor3' AND '$valor4'"; }
				}
				$sql = $db->consulta("SELECT $tabla1.cod_cotizacion,vtama_cliente.dsc_razon_social,$tabla1.dsc_referencia,$tabla1.imp_total,$tabla1.fch_emision,$tabla1.cod_estado_cotizacion,vtama_estado_cotizacion.dsc_estado_cotizacion,vtama_estado_cotizacion.dsc_color,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,rhuma_trabajador.dsc_nombres,vtama_moneda.dsc_simbolo FROM $tabla1 INNER JOIN vtama_cliente ON vtama_cliente.cod_cliente = $tabla1.cod_cliente INNER JOIN vtama_estado_cotizacion ON vtama_estado_cotizacion.cod_estado_cotizacion = $tabla1.cod_estado_cotizacion INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = $tabla1.cod_usr_registro INNER JOIN vtama_moneda ON vtama_moneda.cod_moneda = $tabla1.cod_moneda LEFT JOIN vtade_cotizacion ON $tabla1.cod_cotizacion = vtade_cotizacion.cod_cotizacion LEFT JOIN vtama_producto ON vtade_cotizacion.cod_producto = vtama_producto.cod_producto WHERE $tabla1.cod_cotizacion != 'R961/2019' $condicion GROUP BY $tabla1.cod_cotizacion,vtama_cliente.dsc_razon_social,$tabla1.dsc_referencia,$tabla1.imp_total,$tabla1.fch_emision,$tabla1.cod_estado_cotizacion,vtama_estado_cotizacion.dsc_estado_cotizacion,vtama_estado_cotizacion.dsc_color,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,rhuma_trabajador.dsc_nombres,vtama_moneda.dsc_simbolo ORDER BY $tabla1.fch_emision DESC");
			}else{
				$sql = $db->consulta("SELECT $tabla1.cod_cotizacion,vtama_cliente.dsc_razon_social,$tabla1.dsc_referencia,$tabla1.imp_total,$tabla1.fch_emision,$tabla1.cod_estado_cotizacion,vtama_estado_cotizacion.dsc_estado_cotizacion,vtama_estado_cotizacion.dsc_color,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,rhuma_trabajador.dsc_nombres,vtama_moneda.dsc_simbolo FROM $tabla1 INNER JOIN vtama_cliente ON vtama_cliente.cod_cliente = $tabla1.cod_cliente INNER JOIN vtama_estado_cotizacion ON vtama_estado_cotizacion.cod_estado_cotizacion = $tabla1.cod_estado_cotizacion INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = $tabla1.cod_usr_registro INNER JOIN vtama_moneda ON vtama_moneda.cod_moneda = $tabla1.cod_moneda ORDER BY $tabla1.fch_emision DESC");
			}
			$datos = array();
		    while($key = $db->recorrer($sql)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}else if($entrada == 'vtnOrdenProduccion'){
			$sql = $db->consulta("SELECT $tabla1.cod_cotizacion,vtama_moneda.dsc_simbolo,$tabla1.imp_total,$tabla1.fch_emision,vtama_estado_cotizacion.dsc_estado_cotizacion,$tabla1.dsc_orden_compra FROM $tabla1 INNER JOIN vtama_estado_cotizacion ON vtama_estado_cotizacion.cod_estado_cotizacion = $tabla1.cod_estado_cotizacion INNER JOIN vtama_moneda ON vtama_moneda.cod_moneda = $tabla1.cod_moneda WHERE $tabla1.cod_cliente='$valor1' AND $tabla1.dsc_orden_compra != '' AND $tabla1.flg_uso_orden_produccion='$valor2' ORDER BY $tabla1.fch_emision ASC");
			$datos = array();
		    while($key = $db->recorrer($sql)){	
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}else if($entrada == 'vtnOrdenProduccionCtzPrd'){
			$fchEmisionOrdenCompra = '';
			$sql = $db->consulta("SELECT MIN(fchEmision_orden_compra) as fchEmision_orden_compra FROM $tabla1 WHERE $tabla1.cod_cliente='$valor1' AND $tabla1.dsc_orden_compra = '$valor2'");
			while($key = $db->recorrer($sql)){
	    		$fchEmisionOrdenCompra = ($key["fchEmision_orden_compra"] != '') ? dateFormat($key["fchEmision_orden_compra"]) : '';
			}
			$sql2 = $db->consulta("SELECT $tabla1.cod_cotizacion,vtama_producto.dsc_producto,vtade_cotizacion.num_ctd,vtama_unidad_medida.dsc_simbolo,vtade_cotizacion.cod_producto,vtade_cotizacion.cod_unidad_medida,'$fchEmisionOrdenCompra' as fchEmision_orden_compra FROM $tabla1 INNER JOIN vtade_cotizacion ON $tabla1.cod_cotizacion = vtade_cotizacion.cod_cotizacion INNER JOIN vtama_producto ON vtade_cotizacion.cod_producto = vtama_producto.cod_producto INNER JOIN vtama_unidad_medida ON vtade_cotizacion.cod_unidad_medida = vtama_unidad_medida.cod_unidad WHERE $tabla1.cod_cliente='$valor1' AND $tabla1.dsc_orden_compra = '$valor2' AND $tabla1.flg_uso_orden_produccion='$valor3'");
			$datos = array();
		    while($key2 = $db->recorrer($sql2)){	
		    	$datos[] = arrayMapUtf8Encode($key2);
		    }
		}
	    $db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarCotizacion
	/*=============================================
	MOSTRAR COTIZACION DETALLE
	=============================================*/
	static public function mdlMostrarCotizacionDetalle($tabla, $item, $valor, $entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "filtroCotizacion"){
				$sql = $db->consulta("SELECT vtama_producto.dsc_producto FROM $tabla INNER JOIN vtama_producto ON vtama_producto.cod_producto = vtade_cotizacion.cod_producto WHERE $item = '$valor'");
			}else{
				$sql = $db->consulta("SELECT vtade_cotizacion.num_linea,vtade_cotizacion.cod_producto,vtade_cotizacion.cod_unidad_medida,vtade_cotizacion.num_ctd,vtade_cotizacion.imp_subtotal,vtade_cotizacion.flg_porcentaje,vtade_cotizacion.num_dscto,vtade_cotizacion.total_dscto,vtade_cotizacion.imp_total,vtade_cotizacion.dsc_observacion,vtama_producto.dsc_producto,vtama_unidad_medida.dsc_simbolo FROM vtade_cotizacion INNER JOIN vtama_producto ON vtama_producto.cod_producto = vtade_cotizacion.cod_producto INNER JOIN vtama_unidad_medida ON vtama_unidad_medida.cod_unidad = vtade_cotizacion.cod_unidad_medida  WHERE $item = '$valor'");
			}
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarCotizacionDetalle
	/*=============================================
	MOSTRAR COTIZACION DATOS ADJUNTOS
	=============================================*/
	static public function mdlMostrarCotizacionDatosAdjuntos($tabla, $item, $valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT * FROM $tabla WHERE $item = '$valor'");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarCotizacionDatosAdjuntos
	/*=============================================
	ELIMINAR COTIZACION
	=============================================*/
	static public function mdlEliminarCotizacion($tabla, $datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_cotizacion = '".$datos."'");
		$sql = $db->consulta("DELETE FROM vtade_cotizacion WHERE cod_cotizacion = '".$datos."'");
		$sql = $db->consulta("DELETE FROM vtade_cotizacion_adjunto WHERE cod_cotizacion = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarCotizacion
	/*=============================================
	ELIMINAR COTIZACIÓN DETALLE
	=============================================*/
	static public function mdlEliminarCotizacionDetalle($tabla, $datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_cotizacion = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarCotizacionDetalle
	/*=============================================
	ELIMINAR COTIZACIÓN DATOS ADJUNTOS
	=============================================*/
	static public function mdlEliminarCotizacionDatosAdjuntos($tabla, $datos, $codigo){
		$db = new Conexion();
		foreach ($datos as $key => $value) {			
			$sql = $db->consulta("DELETE FROM $tabla WHERE cod_cotizacion = '$codigo' AND num_linea = ".$value["num_linea"]);
		}
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarCotizacionDatosAdjuntos
	/*=============================================
	CAPTURAR MAXIMO VALOR DATOS ADJUNTOS
	=============================================*/
	static public function mdlMaxValorDatosAdjuntosCotizacion($tabla, $codigo){
		$db = new Conexion();
		$sql = $db->consulta("SELECT MAX(num_linea) as max_num_linea FROM vtade_cotizacion_adjunto WHERE  cod_cotizacion = '".$codigo."'");
		$datos = $db->recorrer($sql);
		$db->liberar($sql);
        $db->cerrar();
		return $datos;		
	}//mdlMaxValorDatosAdjuntosCotizacion
	/*=============================================
	CAPTURAR MAXIMO VALOR DATOS ADJUNTOS
	=============================================*/
	static public function mdlVerificarExisteCotizacion($tabla,$codigo){
		$db = new Conexion();
		$sql = $db->consulta("SELECT COUNT(cod_cotizacion) as contadorCod FROM $tabla WHERE  cod_cotizacion = '".$codigo."'");
		$datos = $db->recorrer($sql);
		$db->liberar($sql);
        $db->cerrar();
		return $datos;		
	}//mdlVerificarExisteCotizacion
	/*=============================================
	VERIFICAR SI EXISTEN VERSIONES DE LA COTIZACION
	=============================================*/
	static public function mdlVerificarVersionCot($item,$valor){
		$db = new Conexion();
		$sql = $db->consulta("SELECT COUNT(cod_cotizacion) as contadorVrs FROM vtaca_cotizacion WHERE  $item = '$valor'");
		$datos = $db->recorrer($sql);
		$db->liberar($sql);
        $db->cerrar();
		return $datos;		
	}//mdlVerificarVersionCot
}//class ModeloCotizacion

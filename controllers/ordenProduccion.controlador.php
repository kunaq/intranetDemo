<?php
class ControladorOrdenProduccion{
	/*=============================================
	MOSTRAR ORDEN DE PRODUCCION
	=============================================*/
	static public function ctrMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada){
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
		$respuesta = ModeloOrdenProduccion::mdlMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6,$tabla7,$tabla8,$tabla9,$tabla10);
		return $respuesta;
	}//function ctrMostrarOrdenProduccion
	/*=============================================
	CREAR ORDEN DE PRODUCCION
	=============================================*/
	static public function ctrCrearOrdenProduccion(){
		if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == "crear"){
			$entrada = $_POST["entrada"];
			if($entrada == 'formularioPrincipal'){
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha.' '.$hora;
				$tabla1 = 'feica_orden_produccion';
				$tabla2 = 'feide_orden_produccion';
				$tabla3 = 'feivi_orden_produccion_area';
				$tabla4 = 'feivi_orden_produccion_documento';
				if(isset($_POST['chkValidadoOrdProd']) && $_POST['chkValidadoOrdProd'] == true){
					$flg_fch_validada = 'SI';
				}else{
					$flg_fch_validada = 'NO';
				}
				$datos1 = array("cod_localidad" => 'LC001',
								"num_orden_produccion" => $_POST["numOrdPrd"],
	    						"cod_estado" => $_POST["codEstadoOrdPrd"],
	    						"fch_registro" => $fechaActual,
	    						"fch_compromiso" => ordenarFechaDate($_POST["fchCompromisoOrdPrd"]),
	    						"dsc_orden" => ms_escape_string(trim($_POST["descripcionOrdPrd"])),
	    						"cod_usuario_registro" => $_SESSION["cod_trabajador"],
	    						"cod_cliente" => $_POST["clienteOrdProd"],
	    						"dsc_orden_compra" => $_POST["ordenCompraOrdPrd"],
	    						"fch_validada" => ordenarFechaDate($_POST["fchValidadaOrdPrd"]),
	    						"flg_fch_validada" => $flg_fch_validada,
	    						"cod_sede" => $_POST["codSedeOrdPrd"]
	    					);
	    		$datos2 = json_decode($_POST["listaProductosOrdPrd"],true);
	    		$datos3 = json_decode($_POST["listaAreasOrdPrd"],true);
	    		$datos4 = json_decode($_POST["listaDocumentosOrdPrd"],true);
	    		$respuesta = ModeloOrdenProduccion::mdlCrearOrdenProduccion($datos1,$datos2,$datos3,$datos4,$entrada,$tabla1,$tabla2,$tabla3,$tabla4);
			}else if($entrada == 'usuarioDocVinc'){
				$tabla1 = 'feivi_orden_produccion_documento_usuario';
				$datos1 = array("cod_localidad" => $_POST["localidadUsrDocOrdProd"],
								"num_orden_produccion" => $_POST["numOrdUsrDocOrdProd"],
								"num_linea" => $_POST["numLnOrdUsrDocOrdProd"]);
				$datos2 = json_decode($_POST["listaUsuariosDocOrdPrd"],true);
				$datos3 = $datos4 = null;
				$tabla2 = $tabla3 = $tabla4 = null;
				$respuesta = ModeloOrdenProduccion::mdlCrearOrdenProduccion($datos1,$datos2,$datos3,$datos4,$entrada,$tabla1,$tabla2,$tabla3,$tabla4);
			}else if($entrada == 'modalObservacionOrdenProduccion'){
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha.' '.$hora;
				$tabla1 = 'feide_orden_produccion_observacion';
				$datos1 = array("cod_localidad" => $_POST["localidadObsOrdProd"],
								"num_orden_produccion" => $_POST["numOrdObsOrdProd"],
								"cod_usuario" => $_SESSION["cod_trabajador"],
								"fch_registro" => $fechaActual,
								"dsc_observacion" => ms_escape_string(trim($_POST["descripcionObsOrdPrd"])),
								"flg_automatico" => 'NO'
							);
				$respuesta = ModeloOrdenProduccion::mdlCrearOrdenProduccionObservacion($tabla1,$datos1);
			}
			return $respuesta;
		}//if
	}//function ctrCrearOrdenProduccion
	/*=============================================
	EDITAR ORDEN DE PRODUCCION
	=============================================*/
	static public function ctrEditarOrdenProduccion(){
		if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == "editar"){
			$entrada = $_POST["entrada"];
			if($entrada == 'formularioPrincipal'){
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha.' '.$hora;
				$tabla1 = 'feica_orden_produccion';
				$tabla2 = 'feide_orden_produccion';
				$tabla3 = 'feivi_orden_produccion_area';
				$tabla4 = 'feivi_orden_produccion_documento';
				$tabla5 = 'feivi_orden_produccion_documento_usuario';
				if(isset($_POST['chkValidadoOrdProd']) && $_POST['chkValidadoOrdProd'] == true){
					$flg_fch_validada = 'SI';
				}else{
					$flg_fch_validada = 'NO';
				}
				$datos1 = array("cod_localidad" => $_POST["codLocalidadOrdPrd"],
								"num_orden_produccion" => $_POST["numOrdPrd"],
								"num_orden_produccion_orig" => $_POST["numOrdPrdOrig"],
	    						"cod_estado" => $_POST["codEstadoOrdPrd"],
	    						"fch_registro" => $fechaActual,
	    						"fch_compromiso" => ordenarFechaDate($_POST["fchCompromisoOrdPrd"]),
	    						"dsc_orden" => $_POST["descripcionOrdPrd"],
	    						"cod_usuario_registro" => $_SESSION["cod_trabajador"],
	    						"cod_cliente" => $_POST["clienteOrdProd"],
	    						"lista_documento" => $_POST["listaMaestraDocOrdProd"],
	    						"dsc_orden_compra" => $_POST["ordenCompraOrdPrd"],
	    						"fch_validada" => ordenarFechaDate($_POST["fchValidadaOrdPrd"]),
	    						"flg_fch_validada" => $flg_fch_validada,
	    						"cod_sede" => $_POST["codSedeOrdPrd"],
	    						"flg_fch_validada_orig" => $_POST["chkValidadoOriginOrdPrd"]
	    					);
	    		$datos2 = json_decode($_POST["listaProductosOrdPrd"],true);
	    		$datos3a = json_decode($_POST["listaAreasEliminarOrdPrd"],true);
	    		//$datos3 = json_decode($_POST["listaAreasEliminarOrdPrd"],true);
	    		$datos3b = json_decode($_POST["listaAreasInsertarOrdPrd"],true);
	    		$datos4 = json_decode($_POST["listaDocumentosOrdPrd"],true);
	    		$datos5 = json_decode($_POST["listaDocumentosOrginOrdPrd"],true);
	    		$respuesta = ModeloOrdenProduccion::mdlEditarOrdenProduccion($datos1,$datos2,$datos3a,$datos4,$datos5,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$datos3b);
			}else if($entrada == 'areaRelacOrdProd'){
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha.' '.$hora;
				$tabla1 = 'feica_orden_produccion_area';
				$numCantidad = ($_POST["flgPedidoAreaOrdProd"] == 'SI' || $_POST["flgComprasAreaOrdProd"] == 'SI') ? $_POST["cantidadPorcAreaOrdProd"] : $_POST["cantidadAreaOrdProd"];
				$datos1 = array("cod_localidad" => $_POST["codLocalAreaOrdProd"],
								"num_orden_produccion" => $_POST["numOrdAreaOrdProd"],
								"num_linea_orden_detalle" => $_POST["numLnaDtlAreaOrdProd"],
								"cod_producto" => $_POST["codPrdAreaOrdProd"],
								"cod_area" => $_POST["codArAreaOrdProd"],
								"cod_estado" => $_POST["estadoAreaOrdProd"],
								"num_cantidad_atendida" => valorVacioEntero($numCantidad),
								"fch_inicial" => ordenarFechaDate($_POST["fechaIncialAreaFctOrdPrd"]),
								"cod_usuario" => $_SESSION["cod_trabajador"],
								"flg_pedido" => $_POST["flgPedidoAreaOrdProd"],
								"flg_compras" => $_POST["flgComprasAreaOrdProd"]);
				$datos2 = $datos3 = $datos4 = $datos5 = $tabla2 = $tabla3 = $tabla4 = $tabla5 = null;
				$respuesta = ModeloOrdenProduccion::mdlEditarOrdenProduccion($datos1,$datos2,$datos3,$datos4,$datos5,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,'');
			}else if($entrada == 'areaFacturacionRelacOrdProd'){
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha.' '.$hora;
				$tabla1 = 'feica_orden_produccion_area';
				$datos1 = array("cod_localidad" => $_POST["codLocalFctAreaFctOrdPrd"],
								"num_orden_produccion" => $_POST["numOrdFctAreaFctOrdPrd"],
								"num_linea_orden_detalle" => $_POST["numLnaFctAreaFctOrdPrd"],
								"cod_producto" => $_POST["codPrdFctAreaFctOrdPrd"],
								"cod_area" => $_POST["codAreaFctOrdPrd"],
								"cod_estado" => $_POST["estadoFctAreaFctOrdPrd"],
								"num_guia_remision" => ms_escape_string(trim($_POST["numGuiaRmsAreaFctOrdPrd"])),
								"fch_emision_guiaR" => ordenarFechaDate($_POST["fchEmsGuiRmAreaFctOrdPrd"]),
								"num_facturacion" => ms_escape_string(trim($_POST["numFctAreaFctOrdPrd"])),
								"fch_emision_fact" => ordenarFechaDate($_POST["fchEmsFactAreaFctOrdPrd"]),
								"fch_registro" => $fechaActual
								);
				$datos2 = $datos3 = $datos4 = $datos5 = $tabla2 = $tabla3 = $tabla4 = $tabla5 = null;
				$respuesta = ModeloOrdenProduccion::mdlEditarOrdenProduccion($datos1,$datos2,$datos3,$datos4,$datos5,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,'');
			}else if($entrada == 'modalObservacionOrdenProduccion'){
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha.' '.$hora;
				$tabla1 = 'feide_orden_produccion_observacion';
				$datos1 = array("cod_localidad" => $_POST["localidadObsOrdProd"],
								"num_orden_produccion" => $_POST["numOrdObsOrdProd"],
								"num_linea" => $_POST["numLnObsOrdProd"],
								"cod_usuario" => $_SESSION["cod_trabajador"],
								"dsc_observacion" => ms_escape_string(trim($_POST["descripcionObsOrdPrd"]))
							);
				$respuesta = ModeloOrdenProduccion::mdlEditarOrdenProduccionObservacion($tabla1,$datos1,'');
			}
    		return $respuesta;
		}//if
	}//function ctrEditarOrdenProduccion
	/*=============================================
	ELIMINAR ORDEN DE PRODUCCION
	=============================================*/
	static public function ctrEliminarOrdenProduccion(){
		if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == "eliminar"){
			$entrada = $_POST["entrada"];
			if($entrada == 'observacion'){				
				$tabla1 = 'feide_orden_produccion_observacion';
				$datos1 = array("cod_localidad" => $_POST["localidad"],
								"num_orden_produccion" => $_POST["ordenProduccion"],
								"num_linea" => $_POST["numLinea"]);
				$respuesta = ModeloOrdenProduccion::mdlEliminarOrdenProduccionObservacion($tabla1,$datos1);
			}
			return $respuesta;
		}
	}//function ctrEliminarOrdenProduccion
	/*=============================================
	MOSTRAR COTIZACION RELACIODA A LA ORDEN DE COMPRA Y CLIENTE
	=============================================*/
	static public function ctrMostrarRelCotizacion($valor1,$valor2){
		$tabla1 = 'vtaca_cotizacion';		
		$respuesta = ModeloOrdenProduccion::mdlMostrarRelCotizacion($tabla1,$valor1,$valor2);
		return $respuesta;
	}//function ctrMostrarRelCotizacion
	/*=============================================
	MOSTRAR OBSERVACIONES
	=============================================*/
	static public function ctrMostrarTablaObservacionOrdPrd($localidad,$ordenProduccion){
		$tabla1 = 'feide_orden_produccion_observacion';
		$respuesta = ModeloOrdenProduccion::mdlMostrarTablaObservacionOrdPrd($tabla1,$localidad,$ordenProduccion);
		return $respuesta;
	}//function mostrarTablaObservacionOrdPrd
	/*=============================================
	CONSULTAR ESTADO
	=============================================*/
	static public function ctrConsultarEstadoOrdProd($codEstado,$localidad,$ordenProduccion,$entrada){
		$tabla = 'vtama_estado_orden_produccion';
		$respuesta = ModeloOrdenProduccion::mdlConsultarEstadoOrdProd($tabla,$codEstado,$localidad,$ordenProduccion,$entrada);
		return $respuesta;
	}//function ctrConsultarEstadoOrdProd
	static public function ctrDescargarReporte(){
		$entrada = (isset($_GET["entrada"])) ? $_GET["entrada"] : null;
		if($entrada == 'vtnOrdenProduccionExcel'){
			$item1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? "fch_validada" : null;
			$valor1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? $_GET["fechaInicial"] : null;
			$item2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? "fch_validada" : null;
			$valor2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? $_GET["fechaFinal"] : null;			
			$item3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? "cod_estado" : null;
			$valor3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? $_GET["estado"] : null;
			if(isset($_GET["fechaValidada"]) && $_GET["fechaValidada"] != ""){
				if($_GET["fechaValidada"] == 'MDF'){
					$item4 = 'flg_fch_validada_modificado';
					$valor4 = 'SI';
				}else{
					$item4 = 'flg_fch_validada';
					$valor4 = $_GET["fechaValidada"];
				}
			}else{
				$item4 = $valor4 = null;
			}
			$tabla1 = 'feica_orden_produccion';
			$ordenes = ModeloOrdenProduccion::mdlMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,null,null,null,null,null,null,null,null,null);
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$name = $_GET["reporte"].'.xlsx';
			ob_start();
			$objPHPExcel = new PHPExcel();
			$hoja = $objPHPExcel->setActiveSheetIndex(0);
		    $fecha_reporte = date('d-m-Y H:i:s');
		    $hoja->setTitle('Reporte de orden de produccion');
		    $hoja->setCellValue('A1', 'REPORTE DE ORDEN DE PRODUCCION');
		    $hoja->getStyle('A1')->getFont()->setSize(15);
		    $hoja->getStyle('A1')->getFont()->setBold(true);
		    $hoja->mergeCells('A1:H1');
		    $hoja->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$listaArea = ControladorArea::ctrMostrarArea('flg_activo','SI',null,null,null,null,null,null,null,null,'dtbleOrdPrd');
			$cabecera_columna = array(
				'USUARIO',
				'FECHA REGISTRO',
		        'CLIENTE',
		        'DESCRIPCION',
		        'ORDEN DE COMPRA',
		        'SEDE',
		        'FECHA ENTREGA CABECERA',
		        'FECHA VALIDADA CABECERA',
		        'ESTADO',
		        'ORDEN PRODUCCION',		        
		        'ITEM',
		        'Nº COTIZACION',
		        'FECHA DE ENTREGA',
		        'FECHA VALIDADA',
		        'AREA',
		        'PESO',
		        'PRODUCTO',
		        'CANTIDAD',
		        'UNIDAD'
		    );
		    $listaAreaCod = array();
		    $arrayLetras = array('T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT');
		    $arraySubArea = array('Estado','Cantidad','Fecha');
		    $arraySubArea2 = array('Estado','Facturacion','Guía de Remisión');
		    $arraySubArea3 = array('Estado','Porcentaje','Fecha');
		    foreach ($listaArea as $key => $value) {
		    	if($value["flg_facturacion"] == 'SI'){
		    		for ($i=0; $i < count($arraySubArea) ; $i++) {		    		
		    			array_push($cabecera_columna, $value["dsc_area"].' - '.$arraySubArea2[$i]);
		    		}	
		    	}else if($value["flg_pedido"] == 'SI' || $value["flg_compras"] == 'SI'){
		    		for ($i=0; $i < count($arraySubArea) ; $i++) {		    		
		    			array_push($cabecera_columna, $value["dsc_area"].' - '.$arraySubArea3[$i]);
		    		}
		    	}else{
		    		for ($i=0; $i < count($arraySubArea) ; $i++) {		    		
		    			array_push($cabecera_columna, $value["dsc_area"].' - '.$arraySubArea[$i]);
		    		}
		    	}
		    	array_push($listaAreaCod, $value["cod_area"]);
		    }
		    $hoja->fromArray($cabecera_columna, NULL, 'A2');
			$hoja->setAutoFilter('A2:AT2');
			$hoja->getStyle('A2:AT2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDD7EE');
			$letrasColumCab = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S');
   			foreach ($letrasColumCab as $key => $value) {
				$hoja->getColumnDimension($value)->setAutoSize(true);
   			}
		   	for ($i=0; $i < count($arrayLetras) ; $i++) { 
		   		$hoja->getColumnDimension($arrayLetras[$i])->setAutoSize(true);
		   	}
		    $contTot = 3;
		    $maxFila = array();
		    foreach ($ordenes as $row => $item) {
		    	$fchRegistro = ($item["fch_registro"] != '') ? dateFormat($item["fch_registro"]) : '';
		    	$fchEntregaCab = ($item["fch_compromiso"] != '') ? dateFormat($item["fch_compromiso"]) : '';
		    	$fchValidadaCab = ($item["fch_validada_cab"] != '') ? dateFormat($item["fch_validada_cab"]) : '';
		    	$fchEntrega = ($item["fch_entrega"] != '') ? dateFormat($item["fch_entrega"]) : '';
		    	$fchValidadaDet = ($item["fch_validada"] != '') ? dateFormat($item["fch_validada"]) : '';
		    	if($item["flg_fch_validada_modificado"] == 'SI'){
		    		$colorFchValidada = '12bd12';
		    	}else if($item["flg_fch_validada"] == 'SI'){
		    		$colorFchValidada = '0000ff';
		    	}else{
		    		$colorFchValidada = 'ff0000';
		    	}
		    	$area = ControladorArea::ctrMostrarArea("cod_localidad",$item["cod_localidad"],"num_orden_produccion",$item["num_orden_produccion"],'num_linea_orden_detalle',$item["num_linea"],"cod_producto",$item["cod_producto"],null,null,"dtbleVinculoOrdPrdExcel");
				$inicialI = 0;				
				$a = 0;
				if(count($area) > 0){
					for ($i=0; $i < count($listaAreaCod) ; $i++) {
						$cont = $contTot;
						$mensaje = "";
						$contDet = 1; 
						foreach ($area as $row2 => $item2) {
							$mensajeEstado = $texto = "";						
							if($item2["cod_area"] == $listaAreaCod[$i] && $item2["flg_facturacion"] == 'NO'){
								//echo $cont.'||';
								$areaDet = ControladorArea::ctrMostrarArea("cod_localidad",$item2["cod_localidad"],"num_orden_produccion",$item2["num_orden_produccion"],'num_linea_orden_detalle',$item2["num_linea_orden_detalle"],"cod_producto",$item2["cod_producto"],"cod_area",$item2["cod_area"],"dtbleVinculoOrdPrdExcelDet");
								if(count($areaDet) > 0){
									foreach ($areaDet as $key3 => $value3) {
										$hoja->setCellValue('A'.$cont,html_entity_decode($item["dsc_trabajador"]));
								    	$hoja->setCellValue('B'.$cont,$fchRegistro);
										$hoja->setCellValue('C'.$cont,html_entity_decode($item["dsc_razon_social"]));
										$hoja->setCellValue('D'.$cont,html_entity_decode($item["dsc_orden"]));
										$hoja->setCellValue('E'.$cont,$item["dsc_orden_compra"]);
										$hoja->setCellValue('F'.$cont,$item["dsc_sede"]);
										$hoja->setCellValue('G'.$cont,$fchEntregaCab);
										$hoja->setCellValue('H'.$cont,$fchValidadaCab);
										$hoja->setCellValue('I'.$cont,$item["dsc_estado"]);
										$hoja->setCellValue('J'.$cont,$item["num_orden_produccion"]);
										$hoja->setCellValue('K'.$cont,$item["num_linea"]);
										$hoja->setCellValue('L'.$cont,$item["cod_cotizacion"]);
										$hoja->setCellValue('M'.$cont,$fchEntrega);
										$hoja->setCellValue('N'.$cont,$fchValidadaDet);
										$hoja->setCellValue('O'.$cont,$item["imp_area"]);
										$hoja->setCellValue('P'.$cont,$item["imp_peso"]);
										$hoja->setCellValue('Q'.$cont,$item["dsc_producto"]);
										$hoja->setCellValue('R'.$cont,number_format($item["ctd_orden"]),2);
										$hoja->setCellValue('S'.$cont,$item["dsc_simbolo"]);
										$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('H'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('I'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('J'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('K'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('L'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('M'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getFont()->getColor()->setRGB($colorFchValidada);
										$objPHPExcel->getActiveSheet() ->getStyle('O'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										$objPHPExcel->getActiveSheet() ->getStyle('P'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										$objPHPExcel->getActiveSheet() ->getStyle('Q'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('R'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										$objPHPExcel->getActiveSheet() ->getStyle('S'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$fchInicialArea = ($value3["fch_inicial"] != '') ? dateFormat($value3["fch_inicial"]) : '';
										$arrayDatosSubArea = array($item2["dsc_estado"],$value3["num_cantidad"],$fchInicialArea);
										for ($j=0; $j < count($arrayDatosSubArea) ; $j++) {
											//echo $i+$j+$a.'--';
											//echo $arrayLetras[(int)$i+$j+$a].'---';

											$hoja->setCellValue($arrayLetras[(int)$i+$j+$a].$cont,$arrayDatosSubArea[$j]);
											//$objPHPExcel->getActiveSheet() ->getStyle($arrayLetras[(int)($i)+$i].$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										}
										array_push($maxFila,$cont);
										$cont++;
									}//foreach	
								}else{
									$hoja->setCellValue('A'.$cont,html_entity_decode($item["dsc_trabajador"]));
							    	$hoja->setCellValue('B'.$cont,$fchRegistro);
									$hoja->setCellValue('C'.$cont,html_entity_decode($item["dsc_razon_social"]));
									$hoja->setCellValue('D'.$cont,html_entity_decode($item["dsc_orden"]));
									$hoja->setCellValue('E'.$cont,$item["dsc_orden_compra"]);
									$hoja->setCellValue('F'.$cont,$item["dsc_sede"]);
									$hoja->setCellValue('G'.$cont,$fchEntregaCab);
									$hoja->setCellValue('H'.$cont,$fchValidadaCab);
									$hoja->setCellValue('I'.$cont,$item["dsc_estado"]);
									$hoja->setCellValue('J'.$cont,$item["num_orden_produccion"]);
									$hoja->setCellValue('K'.$cont,$item["num_linea"]);
									$hoja->setCellValue('L'.$cont,$item["cod_cotizacion"]);
									$hoja->setCellValue('M'.$cont,$fchEntrega);
									$hoja->setCellValue('N'.$cont,$fchValidadaDet);
									$hoja->setCellValue('O'.$cont,$item["imp_area"]);
									$hoja->setCellValue('P'.$cont,$item["imp_peso"]);
									$hoja->setCellValue('Q'.$cont,$item["dsc_producto"]);
									$hoja->setCellValue('R'.$cont,number_format($item["ctd_orden"]),2);
									$hoja->setCellValue('S'.$cont,$item["dsc_simbolo"]);
									$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('H'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('I'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('J'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('K'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('L'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('M'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getFont()->getColor()->setRGB($colorFchValidada);
									$objPHPExcel->getActiveSheet() ->getStyle('O'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									$objPHPExcel->getActiveSheet() ->getStyle('P'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									$objPHPExcel->getActiveSheet() ->getStyle('Q'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('R'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									$objPHPExcel->getActiveSheet() ->getStyle('S'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$arrayDatosSubArea = array($item2["dsc_estado"],'','');
									for ($j=0; $j < count($arrayDatosSubArea) ; $j++) {
										//echo $i+$j+$a.'--';
										//echo $arrayLetras[(int)$i+$j+$a].'---';

										$hoja->setCellValue($arrayLetras[(int)$i+$j+$a].$cont,$arrayDatosSubArea[$j]);
										//$objPHPExcel->getActiveSheet() ->getStyle($arrayLetras[(int)($i)+$i].$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									}
									array_push($maxFila,$cont);
									$cont++;
								}								
							}else if($item2["cod_area"] == $listaAreaCod[$i] && $item2["flg_facturacion"] == 'SI'){
								$cont = max($maxFila)+1;			
								$areaDetFac = ControladorArea::ctrMostrarArea("cod_localidad",$item2["cod_localidad"],"num_orden_produccion",$item2["num_orden_produccion"],'num_linea_orden_detalle',$item2["num_linea_orden_detalle"],"cod_producto",$item2["cod_producto"],"cod_area",$item2["cod_area"],"dtbleVinculoOrdPrdExcelDetFact");
								if(count($areaDetFac) > 0){
									foreach ($areaDetFac as $key3 => $value3) {
										$hoja->setCellValue('A'.$cont,html_entity_decode($item["dsc_trabajador"]));
								    	$hoja->setCellValue('B'.$cont,$fchRegistro);
										$hoja->setCellValue('C'.$cont,html_entity_decode($item["dsc_razon_social"]));
										$hoja->setCellValue('D'.$cont,html_entity_decode($item["dsc_orden"]));
										$hoja->setCellValue('E'.$cont,$item["dsc_orden_compra"]);
										$hoja->setCellValue('F'.$cont,$item["dsc_sede"]);
										$hoja->setCellValue('G'.$cont,$fchEntregaCab);
										$hoja->setCellValue('H'.$cont,$fchValidadaCab);
										$hoja->setCellValue('I'.$cont,$item["dsc_estado"]);
										$hoja->setCellValue('J'.$cont,$item["num_orden_produccion"]);
										$hoja->setCellValue('K'.$cont,$item["num_linea"]);
										$hoja->setCellValue('L'.$cont,$item["cod_cotizacion"]);
										$hoja->setCellValue('M'.$cont,$fchEntrega);
										$hoja->setCellValue('N'.$cont,$fchValidadaDet);
										$hoja->setCellValue('O'.$cont,$item["imp_area"]);
										$hoja->setCellValue('P'.$cont,$item["imp_peso"]);
										$hoja->setCellValue('Q'.$cont,$item["dsc_producto"]);
										$hoja->setCellValue('R'.$cont,number_format($item["ctd_orden"]),2);
										$hoja->setCellValue('S'.$cont,$item["dsc_simbolo"]);
										$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('H'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('I'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('J'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('K'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('L'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('M'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getFont()->getColor()->setRGB($colorFchValidada);
										$objPHPExcel->getActiveSheet() ->getStyle('O'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										$objPHPExcel->getActiveSheet() ->getStyle('P'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										$objPHPExcel->getActiveSheet() ->getStyle('Q'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
										$objPHPExcel->getActiveSheet() ->getStyle('R'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										$objPHPExcel->getActiveSheet() ->getStyle('S'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$hoja->setCellValue($arrayLetras[24].$cont,$item2["dsc_estado"]);
										//$fchInicialArea = ($value3["fch_inicial"] != '') ? dateFormat($value3["fch_inicial"]) : '';
										if($value3["flg_guia_remision"] == 'SI'){	
											$hoja->setCellValue($arrayLetras[25].$cont,"Nº: ".$value3["num_serie"].' , Fecha Emision: '.dateFormat($value3["fch_emision"]));
										}else{
											$hoja->setCellValue($arrayLetras[26].$cont,"Nº: ".$value3["num_serie"].' , Fecha Emision: '.dateFormat($value3["fch_emision"]));
										}
										array_push($maxFila,$cont);
										$cont++;
									}//foreach
								}else{
									$hoja->setCellValue('A'.$cont,html_entity_decode($item["dsc_trabajador"]));
							    	$hoja->setCellValue('B'.$cont,$fchRegistro);
									$hoja->setCellValue('C'.$cont,html_entity_decode($item["dsc_razon_social"]));
									$hoja->setCellValue('D'.$cont,html_entity_decode($item["dsc_orden"]));
									$hoja->setCellValue('E'.$cont,$item["dsc_orden_compra"]);
									$hoja->setCellValue('F'.$cont,$item["dsc_sede"]);
									$hoja->setCellValue('G'.$cont,$fchEntregaCab);
									$hoja->setCellValue('H'.$cont,$fchValidadaCab);
									$hoja->setCellValue('I'.$cont,$item["dsc_estado"]);
									$hoja->setCellValue('J'.$cont,$item["num_orden_produccion"]);
									$hoja->setCellValue('K'.$cont,$item["num_linea"]);
									$hoja->setCellValue('L'.$cont,$item["cod_cotizacion"]);
									$hoja->setCellValue('M'.$cont,$fchEntrega);
									$hoja->setCellValue('N'.$cont,$fchValidadaDet);
									$hoja->setCellValue('O'.$cont,$item["imp_area"]);
									$hoja->setCellValue('P'.$cont,$item["imp_peso"]);
									$hoja->setCellValue('Q'.$cont,$item["dsc_producto"]);
									$hoja->setCellValue('R'.$cont,number_format($item["ctd_orden"]),2);
									$hoja->setCellValue('S'.$cont,$item["dsc_simbolo"]);
									$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('H'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('I'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('J'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('K'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('L'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('M'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getFont()->getColor()->setRGB($colorFchValidada);
									$objPHPExcel->getActiveSheet() ->getStyle('O'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									$objPHPExcel->getActiveSheet() ->getStyle('P'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									$objPHPExcel->getActiveSheet() ->getStyle('Q'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									$objPHPExcel->getActiveSheet() ->getStyle('R'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									$objPHPExcel->getActiveSheet() ->getStyle('S'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
									$hoja->setCellValue($arrayLetras[24].$cont,$item2["dsc_estado"]);
									array_push($maxFila,$cont);
									$cont++;
								}
							}							
						}//foreach
						$a = (int)$a + 2;
					}//for
				}else{
					$cont = $contTot;
					//echo $cont.'##';
					$hoja->setCellValue('A'.$cont,html_entity_decode($item["dsc_trabajador"]));
			    	$hoja->setCellValue('B'.$cont,$fchRegistro);
					$hoja->setCellValue('C'.$cont,html_entity_decode($item["dsc_razon_social"]));
					$hoja->setCellValue('D'.$cont,html_entity_decode($item["dsc_orden"]));
					$hoja->setCellValue('E'.$cont,$item["dsc_orden_compra"]);
					$hoja->setCellValue('F'.$cont,$item["dsc_sede"]);
					$hoja->setCellValue('G'.$cont,$fchEntregaCab);
					$hoja->setCellValue('H'.$cont,$fchValidadaCab);
					$hoja->setCellValue('I'.$cont,$item["dsc_estado"]);
					$hoja->setCellValue('J'.$cont,$item["num_orden_produccion"]);
					$hoja->setCellValue('K'.$cont,$item["num_linea"]);
					$hoja->setCellValue('L'.$cont,$item["cod_cotizacion"]);
					$hoja->setCellValue('M'.$cont,$fchEntrega);
					$hoja->setCellValue('N'.$cont,$fchValidadaDet);
					$hoja->setCellValue('O'.$cont,$item["imp_area"]);
					$hoja->setCellValue('P'.$cont,$item["imp_peso"]);
					$hoja->setCellValue('Q'.$cont,$item["dsc_producto"]);
					$hoja->setCellValue('R'.$cont,number_format($item["ctd_orden"]),2);
					$hoja->setCellValue('S'.$cont,$item["dsc_simbolo"]);
					$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet() ->getStyle('H'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet() ->getStyle('I'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('J'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet() ->getStyle('K'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet() ->getStyle('L'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('M'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getFont()->getColor()->setRGB($colorFchValidada);
					$objPHPExcel->getActiveSheet() ->getStyle('O'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet() ->getStyle('P'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet() ->getStyle('Q'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet() ->getStyle('R'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet() ->getStyle('S'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					array_push($maxFila,$cont);
					$cont++;
				}
				//echo 'cambio2||';
				$contTot = (max($maxFila) != '') ? (int)max($maxFila)+1 : $contTot;
				
			}//foreach
		}else if($entrada == 'vtnOrdenProduccionExcelDetalle'){
			$item1 = (isset($_GET["localidad"]) && $_GET["localidad"] != "") ? "cod_localidad" : null;
			$valor1 = (isset($_GET["localidad"]) && $_GET["localidad"] != "") ? $_GET["localidad"] : null;
			$item2 = (isset($_GET["ordenProduccion"]) && $_GET["ordenProduccion"] != "") ? "num_orden_produccion" : null;
			$valor2 = (isset($_GET["ordenProduccion"]) && $_GET["ordenProduccion"] != "") ? $_GET["ordenProduccion"] : null;
			$item3 = $valor3 = $item4 = $valor4 = null;
			/*$item1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? "fch_validada" : null;
			$valor1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? $_GET["fechaInicial"] : null;
			$item2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? "fch_validada" : null;
			$valor2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? $_GET["fechaFinal"] : null;			
			$item3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? "cod_estado" : null;
			$valor3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? $_GET["estado"] : null;
			$item4 = (isset($_GET["fechaValidada"]) && $_GET["fechaValidada"] != "") ? "flg_fch_validada" : null;
			$valor4 = (isset($_GET["fechaValidada"]) && $_GET["fechaValidada"] != "") ? $_GET["fechaValidada"] : null;*/
			$tabla1 = 'feide_orden_produccion';
			$ordenes = ModeloOrdenProduccion::mdlMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,null,null,null,null,null,null,null,null,null);
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$name = $_GET["reporte"].'.xlsx';
			ob_start();
			$objPHPExcel = new PHPExcel();
			$hoja = $objPHPExcel->setActiveSheetIndex(0);
		    $fecha_reporte = date('d-m-Y H:i:s');
		    $hoja->setTitle('Reporte de orden de produccion');
		    $hoja->setCellValue('A1', 'REPORTE DE ORDEN DE PRODUCCION DETALLE');
		    $hoja->getStyle('A1')->getFont()->setSize(15);
		    $hoja->getStyle('A1')->getFont()->setBold(true);
		    $hoja->mergeCells('A1:G1');
		    $hoja->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$listaArea = ControladorArea::ctrMostrarArea('flg_activo','SI',null,null,null,null,null,null,null,null,'dtbleOrdPrd');
			$cabecera_columna = array(
		        'ORDEN PRODUCCION',
		        'ITEM',		        
		        'CANTIDAD',
		        'PRODUCTO',
		        'UNIDAD',
		        'AREA',
		        'PESO'
		    );
		    $hoja->fromArray($cabecera_columna, NULL, 'A2');
			$hoja->setAutoFilter('A2:G2');
   			$hoja->getStyle('A2:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDD7EE');
   			$letrasColum = array('A','B','C','D','E','F','G');
   			foreach ($letrasColum as $key => $value) {
				$hoja->getColumnDimension($value)->setAutoSize(true);
   			}
			$cont = 3;
   			foreach ($ordenes as $row => $item) {
				$hoja->setCellValue('A'.$cont,$item["num_orden_produccion"]);
				$hoja->setCellValue('B'.$cont,$item["num_linea"]);
				$hoja->setCellValue('C'.$cont,$item["ctd_orden"]);
				$hoja->setCellValue('D'.$cont,$item["dsc_producto"]);
				$hoja->setCellValue('E'.$cont,$item["dsc_simbolo"]);
				$hoja->setCellValue('F'.$cont,$item["imp_area"]);
				$hoja->setCellValue('G'.$cont,$item["imp_peso"]);
				$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$cont++;
   			}//foreach			
		}
		//exit;
		// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$name.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		exit;
	}//function ctrDescargarReporte
	/*=============================================
	DESCARGAR REPORTE EN EXCEL
	=============================================*/
	static public function ctrDescargarReporte2(){
		$entrada = (isset($_GET["entrada"])) ? $_GET["entrada"] : null;
		if($entrada == 'vtnOrdenProduccionExcel'){
			$item1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? "fch_validada" : null;
			$valor1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? $_GET["fechaInicial"] : null;
			$item2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? "fch_validada" : null;
			$valor2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? $_GET["fechaFinal"] : null;			
			$item3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? "cod_estado" : null;
			$valor3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? $_GET["estado"] : null;
			if(isset($_GET["fechaValidada"]) && $_GET["fechaValidada"] != ""){
				if($_GET["fechaValidada"] == 'MDF'){
					$item4 = 'flg_fch_validada_modificado';
					$valor4 = 'SI';
				}else{
					$item4 = 'flg_fch_validada';
					$valor4 = $_GET["fechaValidada"];
				}
			}else{
				$item4 = $valor4 = null;
			}
			$tabla1 = 'feica_orden_produccion';
			$ordenes = ModeloOrdenProduccion::mdlMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,null,null,null,null,null,null,null,null,null);
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$name = $_GET["reporte"].'.xlsx';
			ob_start();
			$objPHPExcel = new PHPExcel();
			$hoja = $objPHPExcel->setActiveSheetIndex(0);
		    $fecha_reporte = date('d-m-Y H:i:s');
		    $hoja->setTitle('Reporte de orden de produccion');
		    $hoja->setCellValue('A1', 'REPORTE DE ORDEN DE PRODUCCION');
		    $hoja->getStyle('A1')->getFont()->setSize(15);
		    $hoja->getStyle('A1')->getFont()->setBold(true);
		    $hoja->mergeCells('A1:H1');
		    $hoja->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$listaArea = ControladorArea::ctrMostrarArea('flg_activo','SI',null,null,null,null,null,null,null,null,'dtbleOrdPrd');
			$cabecera_columna = array(
				'USUARIO',
				'FECHA REGISTRO',
		        'CLIENTE',
		        'DESCRIPCION',
		        'ORDEN DE COMPRA',
		        'SEDE',
		        'FECHA ENTREGA CABECERA',
		        'FECHA VALIDADA CABECERA',
		        'ESTADO',
		        'ORDEN PRODUCCION',		        
		        'ITEM',
		        'Nº COTIZACION',
		        'FECHA DE ENTREGA',
		        'FECHA VALIDADA',
		        'AREA',
		        'PESO',
		        'PRODUCTO',
		        'CANTIDAD',
		        'UNIDAD'
		    );
		    $listaAreaCod = array();
		    //$arrayLetras = array('P','Q','R','S','T','U','V','W','X','Y','Z');
		    $arrayLetras = array('T','U','V','W','X','Y','Z','AA','AB');
		    foreach ($listaArea as $key => $value) {
		    	array_push($cabecera_columna, $value["dsc_area"]);
		    	array_push($listaAreaCod, $value["cod_area"]);
		    }
		    $hoja->fromArray($cabecera_columna, NULL, 'A2');
			$hoja->setAutoFilter('A2:AB2');
			$hoja->getStyle('A2:AB2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDD7EE');
			$letrasColumCab = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S');
   			foreach ($letrasColumCab as $key => $value) {
				$hoja->getColumnDimension($value)->setAutoSize(true);
   			}
		   	for ($i=0; $i < count($arrayLetras) ; $i++) { 
		   		$hoja->getColumnDimension($arrayLetras[$i])->setAutoSize(true);
		   	}
		    $cont = 3;
		    foreach ($ordenes as $row => $item) {
		    	$fchRegistro = ($item["fch_registro"] != '') ? dateFormat($item["fch_registro"]) : '';
		    	$fchEntregaCab = ($item["fch_compromiso"] != '') ? dateFormat($item["fch_compromiso"]) : '';
		    	$fchValidadaCab = ($item["fch_validada_cab"] != '') ? dateFormat($item["fch_validada_cab"]) : '';
		    	$fchEntrega = ($item["fch_entrega"] != '') ? dateFormat($item["fch_entrega"]) : '';
		    	$fchValidadaDet = ($item["fch_validada"] != '') ? dateFormat($item["fch_validada"]) : '';
		    	if($item["flg_fch_validada_modificado"] == 'SI'){
		    		$colorFchValidada = '12bd12';
		    	}else if($item["flg_fch_validada"] == 'SI'){
		    		$colorFchValidada = '0000ff';
		    	}else{
		    		$colorFchValidada = 'ff0000';
		    	}
		    	$hoja->setCellValue('A'.$cont,html_entity_decode($item["dsc_trabajador"]));
		    	$hoja->setCellValue('B'.$cont,$fchRegistro);
				$hoja->setCellValue('C'.$cont,html_entity_decode($item["dsc_razon_social"]));
				$hoja->setCellValue('D'.$cont,html_entity_decode($item["dsc_orden"]));
				$hoja->setCellValue('E'.$cont,$item["dsc_orden_compra"]);
				$hoja->setCellValue('F'.$cont,$item["dsc_sede"]);
				$hoja->setCellValue('G'.$cont,$fchEntregaCab);
				$hoja->setCellValue('H'.$cont,$fchValidadaCab);
				$hoja->setCellValue('I'.$cont,$item["dsc_estado"]);
				$hoja->setCellValue('J'.$cont,$item["num_orden_produccion"]);				
				$hoja->setCellValue('K'.$cont,$item["num_linea"]);
				$hoja->setCellValue('L'.$cont,$item["cod_cotizacion"]);
				$hoja->setCellValue('M'.$cont,$fchEntrega);
				$hoja->setCellValue('N'.$cont,$fchValidadaDet);
				$hoja->setCellValue('O'.$cont,$item["imp_area"]);
				$hoja->setCellValue('P'.$cont,$item["imp_peso"]);
				$hoja->setCellValue('Q'.$cont,$item["dsc_producto"]);
				$hoja->setCellValue('R'.$cont,number_format($item["ctd_orden"]),2);
				$hoja->setCellValue('S'.$cont,$item["dsc_simbolo"]);
				$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('H'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('I'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('J'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('K'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('L'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('M'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('N'.$cont) ->getFont()->getColor()->setRGB($colorFchValidada);
				$objPHPExcel->getActiveSheet() ->getStyle('O'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet() ->getStyle('P'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet() ->getStyle('Q'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('R'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet() ->getStyle('S'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$area = ControladorArea::ctrMostrarArea("cod_localidad",$item["cod_localidad"],"num_orden_produccion",$item["num_orden_produccion"],"cod_producto",$item["cod_producto"],null,null,null,null,"dtbleVinculoOrdPrdExcel");
				//$areaFacturacion = 'NO';
				for ($i=0; $i < count($listaAreaCod) ; $i++) {
					$mensaje = "";
					$contDet = 1;
					foreach ($area as $row2 => $item2) {
						$mensajeEstado = "";
						if($item2["cod_area"] == $listaAreaCod[$i]){
							$mensajeEstado = "Estado: ".$item2["dsc_estado"].", Detalle:" ;
							if($item2["flg_facturacion"] == 'SI'){
								$mensaje = '';
								//$mensaje = "Guia de remision: ".$item2["num_serie_guiaRemison"]."-".$item2["num_correlativo_guiaRemison"].", Facturacion: ".$item2["num_serie_facturacion"]."-".$item2["num_correlativo_facturacion"].", Fecha: ".dateFormat($item2["fecha"]);
							}else{
								//$mensaje = "Estado: ".$item2["dsc_estado"].", Porcentaje: ".number_format($item2["imp_porcentaje"]).", Fecha: ".dateFormat($item2["fecha"]);
								$mensaje .= " ".$contDet .") Porcentaje: ".number_format($item2["num_cantidad"]).", Fecha: ".dateFormat($item2["fch_inicial"]) . ',';
							}
							$contDet++;
							$hoja->setCellValue($arrayLetras[$i].$cont,$mensajeEstado.trim($mensaje,','));
							$objPHPExcel->getActiveSheet() ->getStyle($arrayLetras[$i].$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						}//if
					}//foreach
				}//for
				$areaFact = ControladorArea::ctrMostrarArea("cod_localidad",$item["cod_localidad"],"num_orden_produccion",$item["num_orden_produccion"],"cod_producto",$item["cod_producto"],null,null,null,null,"dtbleVinculoOrdPrdExcelFact");
				for ($i=0; $i < count($listaAreaCod) ; $i++) {
					//$mensaje = "";
					//$contDet = 1;
					$mensajeEstadoFact = $mensajeFactGr = $mensajeFactF = $mensajeFactTitGr = $mensajeFactTitFactF = '';
					$contDetF = $contDetGr = 1;
					foreach ($areaFact as $row3 => $item3) {
						
						$mensajeEstadoFact = "Estado: ".$item3["dsc_estado"].', ';
						if($item3["cod_area"] == $listaAreaCod[$i]){							
							if($item3["flg_guia_remision"] == 'SI'){
								$mensajeFactTitGr = 'Guia de remision: '; 	
								$mensajeFactGr.= ' '.$contDetGr.') Serie-Correlativo: '.$item3["num_correlativo"].', Fecha Emision: '.dateFormat($item3["fch_emision"]);
								$contDetGr++;
							}else{
								$mensajeFactTitFactF = 'Facturacion: ';
								$mensajeFactF.= $contDetF.') Serie-Correlativo: '.$item3["num_correlativo"].', Fecha Emision: '.dateFormat($item3["fch_emision"]);
								$contDetF++;
							}							
							$hoja->setCellValue('AB'.$cont,$mensajeEstadoFact.$mensajeFactTitGr.$mensajeFactGr.' -- '.$mensajeFactTitFactF.$mensajeFactF);
							$objPHPExcel->getActiveSheet() ->getStyle($arrayLetras[$i].$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						}
					}//foreach
				}//for
				$cont++;
			}//foreach
		}else if($entrada == 'vtnOrdenProduccionExcelDetalle'){
			$item1 = (isset($_GET["localidad"]) && $_GET["localidad"] != "") ? "cod_localidad" : null;
			$valor1 = (isset($_GET["localidad"]) && $_GET["localidad"] != "") ? $_GET["localidad"] : null;
			$item2 = (isset($_GET["ordenProduccion"]) && $_GET["ordenProduccion"] != "") ? "num_orden_produccion" : null;
			$valor2 = (isset($_GET["ordenProduccion"]) && $_GET["ordenProduccion"] != "") ? $_GET["ordenProduccion"] : null;
			$item3 = $valor3 = $item4 = $valor4 = null;
			/*$item1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? "fch_validada" : null;
			$valor1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? $_GET["fechaInicial"] : null;
			$item2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? "fch_validada" : null;
			$valor2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? $_GET["fechaFinal"] : null;			
			$item3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? "cod_estado" : null;
			$valor3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? $_GET["estado"] : null;
			$item4 = (isset($_GET["fechaValidada"]) && $_GET["fechaValidada"] != "") ? "flg_fch_validada" : null;
			$valor4 = (isset($_GET["fechaValidada"]) && $_GET["fechaValidada"] != "") ? $_GET["fechaValidada"] : null;*/
			$tabla1 = 'feide_orden_produccion';
			$ordenes = ModeloOrdenProduccion::mdlMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,null,null,null,null,null,null,null,null,null);
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$name = $_GET["reporte"].'.xlsx';
			ob_start();
			$objPHPExcel = new PHPExcel();
			$hoja = $objPHPExcel->setActiveSheetIndex(0);
		    $fecha_reporte = date('d-m-Y H:i:s');
		    $hoja->setTitle('Reporte de orden de produccion');
		    $hoja->setCellValue('A1', 'REPORTE DE ORDEN DE PRODUCCION DETALLE');
		    $hoja->getStyle('A1')->getFont()->setSize(15);
		    $hoja->getStyle('A1')->getFont()->setBold(true);
		    $hoja->mergeCells('A1:G1');
		    $hoja->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$listaArea = ControladorArea::ctrMostrarArea('flg_activo','SI',null,null,null,null,null,null,null,null,'dtbleOrdPrd');
			$cabecera_columna = array(
		        'ORDEN PRODUCCION',
		        'ITEM',		        
		        'CANTIDAD',
		        'PRODUCTO',
		        'UNIDAD',
		        'AREA',
		        'PESO'
		    );
		    $hoja->fromArray($cabecera_columna, NULL, 'A2');
			$hoja->setAutoFilter('A2:G2');
   			$hoja->getStyle('A2:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDD7EE');
   			$letrasColum = array('A','B','C','D','E','F','G');
   			foreach ($letrasColum as $key => $value) {
				$hoja->getColumnDimension($value)->setAutoSize(true);
   			}
			$cont = 3;
   			foreach ($ordenes as $row => $item) {
				$hoja->setCellValue('A'.$cont,$item["num_orden_produccion"]);
				$hoja->setCellValue('B'.$cont,$item["num_linea"]);
				$hoja->setCellValue('C'.$cont,$item["ctd_orden"]);
				$hoja->setCellValue('D'.$cont,$item["dsc_producto"]);
				$hoja->setCellValue('E'.$cont,$item["dsc_simbolo"]);
				$hoja->setCellValue('F'.$cont,$item["imp_area"]);
				$hoja->setCellValue('G'.$cont,$item["imp_peso"]);
				$objPHPExcel->getActiveSheet() ->getStyle('A'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('B'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('C'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('D'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet() ->getStyle('E'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet() ->getStyle('F'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet() ->getStyle('G'.$cont) ->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$cont++;
   			}//foreach			
		}
		//exit;
		// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$name.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		exit;
	}//function ctrDescargarReporte
	// /*=============================================
	// MOSTRAR AREAS X PRODUCTO
	// =============================================*/
	// static public function ctrMostrarAreaXProducto($localidad,$ordenProduccion,$area,$producto){
	// 	$tabla1 = 'feica_orden_produccion_area';
	// 	$respuesta = ModeloOrdenProduccion::mdlMostrarAreaXProducto($tabla1,$localidad,$ordenProduccion,$area,$producto);
	// 	return $respuesta;
	// }//function ctrMostrarAreaXProducto($localidad,$ordenProduccion,$area,$producto)
	/*=============================================
	MOSTRAR AREAS X PRODUCTO
	=============================================*/
	static public function ctrMostrarAreaXProducto($localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$entrada){
		$tabla1 = 'feica_orden_produccion_area';
		$respuesta = ModeloOrdenProduccion::mdlMostrarAreaXProducto($tabla1,$localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$entrada);
		return $respuesta;
	}//function ctrMostrarAreaXProducto
	/*=============================================
	MOSTRAR AREAS X PRODUCTO DETALLE
	=============================================*/
	static public function ctrMostrarAreaXProductoDetalle($localidad,$ordenProduccion,$lineaOrdenDetalle,$codProducto,$codArea){
		$tabla1 = 'feide_orden_produccion_area';
		$respuesta = ModeloOrdenProduccion::mdlMostrarAreaXProductoDetalle($tabla1,$localidad,$ordenProduccion,$lineaOrdenDetalle,$codProducto,$codArea);
		return $respuesta;
	}//function ctrMostrarAreaXProductoDetalle
	/*=============================================
	MOSTRAR ESTADO AREA
	=============================================*/
	static public function ctrMostrarEstadoArea($flgPendiente,$entrada){
		$tabla1 = 'vtama_estado_area_ordenProd';
		$respuesta = ModeloOrdenProduccion::mdlMostrarEstadoArea($tabla1,$flgPendiente,$entrada);
		return $respuesta;
	}//function ctrMostrarEstadoArea
	/*=============================================
	MOSTRAR EL HISTORICO DE REMISION DE LA AREA FACTURACION
	=============================================*/
	static public function ctrMostrarHistoricoAreaFacturacion($localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$flgGuiaRemision,$entrada){
		$respuesta = ModeloOrdenProduccion::mdlMostrarHistoricoAreaFacturacion($localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$flgGuiaRemision,$entrada);
		return $respuesta;
	}//function ctrMostrarEstadoArea
	static public function ctrConsultarOrdenProudccion($datos,$entrada){
		$respuesta = ModeloOrdenProduccion::mdlConsultarOrdenProudccion($datos,$entrada);
		return $respuesta;
	}//function ctrConsultarOrdenProudccion
	static public function ctrMostrarSede($item1,$valor1){
		$tabla = 'vtama_sede';
		$respuesta = ModeloOrdenProduccion::mdlMostrarSede($tabla,$item1,$valor1);
		return $respuesta;
	}
	/*=============================================
	MOSTRAR RESUMEN OP
	=============================================*/
	static public function ctrMostrarResumenOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada){
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
		$respuesta = ModeloOrdenProduccion::mdlMostrarResumenOP($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6,$tabla7,$tabla8,$tabla9,$tabla10);
		return $respuesta;
	}
}//class ctrMostrarEstadoArea
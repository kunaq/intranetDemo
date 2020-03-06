<?php
ini_set('display_errors', 0);
require_once "../../../core.php";
require_once "../../../funciones.php";
require_once "../../../controllers/cotizacion.controlador.php";
require_once "../../../models/cotizacion.modelo.php";
class ImprimirCotizacion{
public $codigo;
public function traerImpresionCotizacion(){
// TRAEMOS LA INFORMACIÓN DE LA COTIZACION
$itemCotizacion = "cod_cotizacion";
$valor1Ctz = $this->codigo;
$entrada = 'pdf';
$entradaDetalle = $valor2Ctz = $valor3Ctz = $valor4Ctz = $valor5Ctz = null;
$respuesta = ControladorCotizacion::ctrMostrarCotizacion($valor1Ctz,$valor2Ctz,$valor3Ctz,$valor4Ctz,$valor5Ctz,$entrada);
$subTotalCab = number_format($respuesta["imp_subtotal"],2);
$igvCab = number_format($respuesta["imp_igv"],2);
$totalCab = number_format($respuesta["imp_total"],2);
$respuestaCotDet = ControladorCotizacion::ctrMostrarCotizacionDetalle($itemCotizacion,$valor1Ctz,$entradaDetalle);
$fechaEmision = dateFormat($respuesta["fch_emision"]);
require_once('tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->startPageGroup();
$pdf->AddPage();
$bloque1 = <<<EOF
	<table>
		<tr>
			<td style="width:150px"><img src="images/logo-indelat-v2.png" ></td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
$bloque2 = <<<EOF
	<table>
		<tr>			
			<td style="width:540px"><img src="images/backFact2.jpg"></td>		
		</tr>
	</table>
	<table style="font-size:10px; padding:4px 0px;">
		<tr>
			<td style="background-color:white; width:370px;">Señores</td>
			<td style="background-color:white; width:70px;">Fecha:</td>
			<td style="background-color:white; width:100px;">$fechaEmision</td>
		</tr>
		<tr>
			<td style="background-color:white; width:370px;">$respuesta[dsc_razon_social]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:370px;">$respuesta[dsc_direccion] $respuesta[dsc_distrito] $respuesta[dsc_provincia] $respuesta[dsc_departamento] $respuesta[dsc_pais]</td>
			<td style="background-color:white; width:70px;">Cotización:</td>
			<td style="background-color:white; width:100px;">$respuesta[cod_cotizacion]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:90px;">Contacto:</td>
			<td style="background-color:white; width:280px;">$respuesta[dsc_contacto]</td>
			<td style="background-color:white; width:70px;">Teléfono:</td>
			<td style="background-color:white; width:100px;">$respuesta[dsc_telefono]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:90px;"></td>
			<td style="background-color:white; width:280px;">$respuesta[dsc_cargo]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:90px;">Referencia:</td>
			<td style="background-color:white; width:280px;">$respuesta[dsc_referencia]</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
// ---------------------------------------------------------
$bloque3 = <<<EOF
	<table>
		<tr>			
			<td style="width:540px"><img src="images/backFact2.jpg"></td>		
		</tr>
	</table>
	<table style="font-size:10px; padding:4px 0px;">
		<tr>
			<td style="background-color:white; width:540px;">Estimados señores:</td>
		</tr>
		<tr>
			<td style="background-color:white; width:540px;">Por medio de la presente nos es grato hacerles llegar nuestra mejor oferta por lo siguiente:</td>
		</tr>
	</table>
	<table style="font-size:10px; padding:4px 0px;">
		<tr style="background-color:#d1d1d1;">		
			<td style="border: 1px solid #666; width:30px; text-align:center; font-weight:bold;">ITEM</td>
			<td style="border: 1px solid #666; width:38px; text-align:center; font-weight:bold;">CANT</td>
			<td style="border: 1px solid #666; width:35px; text-align:center; font-weight:bold;">UNID</td>
			<td style="border: 1px solid #666; width:254px; text-align:center; font-weight:bold;">DESCRIPCIÓN</td>
			<td style="border: 1px solid #666; width:64px; text-align:center; font-weight:bold;">P.UNITARIO</td>
			<td style="border: 1px solid #666; width:57px; text-align:center; font-weight:bold;">DSCTO.</td>
			<td style="border: 1px solid #666; width:64px; text-align:center; font-weight:bold;">P.TOTAL</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
foreach ($respuestaCotDet as $key => $value) {
	$subTotal = number_format($value["imp_subtotal"],2);
	$total = number_format($value["imp_total"],2);
	$monto = number_format($value["num_ctd"]*$subTotal,2);
	$dscto = number_format($value["total_dscto"],2);
	//$simbPorc = ($value["flg_porcentaje"] == 'SI') ? '%' : '';
	if($value["dsc_observacion"] == ''){
		$observacion = '';
	}else{
		//$observacion = '<br><br><b>Observación:</b> '.$value["dsc_observacion"];
		$observacion = '<br><br>'.nl2br($value["dsc_observacion"]);
	}
	$bloque3a= <<<EOF
	<table style="font-size:10px; padding:4px 3px;">
		<tr>		
			<td style="border-left: 1px solid #666; border-right: 1px solid #666; background-color:white; width:30px; text-align:center;border-bottom: 1px solid #666;">$value[num_linea]</td>
			<td style="border-right: 1px solid #666; background-color:white; width:38px; text-align:center;border-bottom: 1px solid #666;">$value[num_ctd]</td>
			<td style="border-right: 1px solid #666; background-color:white; width:35px; text-align:center;border-bottom: 1px solid #666;">$value[dsc_simbolo]</td>
			<td style="border-right: 1px solid #666; background-color:white; width:254px;border-bottom: 1px solid #666;">$value[dsc_producto]$observacion</td>
			<td style="border-right: 1px solid #666; background-color:white; width:64px; text-align:right;border-bottom: 1px solid #666;">$subTotal</td>
			<td style="border-right: 1px solid #666; background-color:white; width:57px; text-align:right;border-bottom: 1px solid #666;">$dscto</td>
			<td style="border-right: 1px solid #666; background-color:white; width:64px; text-align:right;border-bottom: 1px solid #666;">$total</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3a, false, false, false, false, '');
}
// ---------------------------------------------------------
if($respuesta["dsc_observacion"] != ''){
	$observacionGeneral = '<tr><td style="border-right: 1px solid #666; border-left: 1px solid #666; background-color:white; width:540px; border-bottom: 1px solid #666;"><b>Observación general:</b> '.nl2br($respuesta["dsc_observacion"]).' </td></tr>';
}else{
	$observacionGeneral = '';
} 
$bloque3b = <<<EOF
	<table style="font-size:10px; padding:4px 3px;">
		$observacionGeneral
		<tr>
			<td style="background-color:white; width:30px; text-align:center"></td>
			<td style="background-color:white; width:38px; text-align:center"></td>
			<td style="background-color:white; width:35px; text-align:center"></td>
			<td style="background-color:white; width:190px; text-align:center"></td>
			<td style="background-color:white; width:64px; text-align:center;border-right: 1px solid #666;"></td>
			<td style="border-right: 1px solid #666; background-color:white; width:121px; text-align:right; font-weight: bold; border-bottom: 1px solid #666;">SUBTOTAL</td>
			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666;border-left: 1px solid #666; background-color:white; width:64px; text-align:right;font-weight: bold;">$subTotalCab</td>
		</tr>
		<tr>
			<td style="background-color:white; width:30px; text-align:center"></td>
			<td style="background-color:white; width:38px; text-align:center"></td>
			<td style="background-color:white; width:35px; text-align:center"></td>
			<td style="background-color:white; width:190px; text-align:center"></td>
			<td style="background-color:white; width:64px; text-align:center;border-right: 1px solid #666;"></td>
			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:121px; text-align:right; font-weight: bold;">IGV</td>
			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666;border-left: 1px solid #666; background-color:white; width:64px; text-align:right;font-weight: bold;">$igvCab</td>
		</tr>
		<tr>
			<td style="background-color:white; width:30px; text-align:center"></td>
			<td style="background-color:white; width:38px; text-align:center"></td>
			<td style="background-color:white; width:35px; text-align:center"></td>
			<td style="background-color:white; width:190px; text-align:center"></td>
			<td style="background-color:white; width:64px; text-align:center;border-right: 1px solid #666;"></td>
			<td style="border-right: 1px solid #666; border-bottom: 2px solid #666; background-color:white; width:121px; text-align:right; font-weight: bold;">TOTAL $respuesta[dsc_simbolo]</td>
			<td style="border-right: 1px solid #666; border-bottom: 2px solid #666; background-color:white; width:64px; text-align:right;font-weight: bold;">$totalCab</td>
		</tr>	
	</table>
EOF;
$pdf->writeHTML($bloque3b, false, false, false, false, '');
// ---------------------------------------------------------
$bloque4 = <<<EOF
	<table>
		<tr>			
			<td style="width:540px"><img src="images/backFact2.jpg"></td>		
		</tr>
	</table>	
	<table style="font-size:10px; padding:4px 0px;">		
		<tr>
			<td style="font-weight: bold;">CONDICIONES COMERCIALES</td>
		</tr>
		<tr>
			<td style="background-color:white; width:160px;">FORMA DE PAGO</td>
			<td style="background-color:white; width:380px;">$respuesta[dsc_forma_pago]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:160px;">PRECIOS</td>
			<td style="background-color:white; width:380px;">NO INCLUYEN IGV</td>
		</tr>
		<tr>
			<td style="background-color:white; width:160px;">TIEMPO DE ENTREGA</td>
			<td style="background-color:white; width:380px;">$respuesta[dsc_tiempo_entrega]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:160px;">LUGAR DE ENTREGA</td>
			<td style="background-color:white; width:380px;">$respuesta[dsc_lugar_entrega]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:160px;">GARANTÍA</td>
			<td style="background-color:white; width:380px;">$respuesta[dsc_garantia]</td>
		</tr>
		<tr>
			<td style="background-color:white; width:160px;">VALIDEZ DE OFERTA</td>
			<td style="background-color:white; width:380px;">$respuesta[dsc_validez_oferta]</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
// ---------------------------------------------------------
$bloque5 = <<<EOF
	<table>
		<tr>			
			<td style="width:540px"><img src="images/backFact2.jpg"></td>		
		</tr>
	</table>
	<table style="font-size:10px; padding:4px 0px;">
		<tr>
			<td>Sin otro particular</td>
		</tr>
		<tr>
			<td>Atentamente,</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque5, false, false, false, false, '');
// ---------------------------------------------------------
$bloque6 = <<<EOF
	<table>
		<tr>			
			<td style="width:540px"><img src="images/backFact2.jpg"></td>		
		</tr>
	</table>
	<table style="font-size:10px; padding:4px 0px;">
		<tr>	
			<td style="width:360px; font-weight:bold;">ING. CESAR MOSCOSO S.</td>
			<td style="width:180px; font-weight:bold;">Andrés de Cárdenas Pretel</td>
		</tr>
		<tr>	
			<td style="width:360px; font-weight:bold;">DIVISION MINERIA</td>
			<td style="width:180px; font-weight:bold;">DIVISION MINERIA - INDELAT</td>
		</tr>
		<tr>	
			<td style="width:360px;"></td>
			<td style="width:180px; font-weight:bold;">Móvil: (511) 99890-2929</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque6, false, false, false, false, '');
ob_end_clean();
$pdf->Output($respuesta["cod_cotizacion"].'-'.$respuesta["dsc_referencia"].".pdf","I");
}//function traerImpresionFactura
}//class ImprimirCotizacion
$cotizacion = new ImprimirCotizacion();
$cotizacion -> codigo = $_GET["codigo"];
$cotizacion -> traerImpresionCotizacion();
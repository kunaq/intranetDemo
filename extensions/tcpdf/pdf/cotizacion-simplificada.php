<?php
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
			<td style="background-color:white; width:90px;">Orden de compra:</td>
			<td style="background-color:white; width:280px;">$respuesta[dsc_orden_compra]</td>
			<td style="background-color:white; width:70px;">Orden de producción:</td>
			<td style="background-color:white; width:100px;">$respuesta[num_orden_produccion]</td>
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
			<td style="border: 1px solid #666; width:50px; text-align:center; font-weight:bold;">ITEM</td>
			<td style="border: 1px solid #666; width:50px; text-align:center; font-weight:bold;">CANT</td>
			<td style="border: 1px solid #666; width:60px; text-align:center; font-weight:bold;">UNID</td>
			<td style="border: 1px solid #666; width:380px; text-align:center; font-weight:bold;">DESCRIPCIÓN</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
foreach ($respuestaCotDet as $key => $value) {
	$subTotal = number_format($value["imp_subtotal"],2);
	$total = number_format($value["imp_total"],2);
	if($value["dsc_observacion"] == ''){
		$observacion = '';
	}else{
		$observacion = '<br><br><b>Observación:</b> '.$value["dsc_observacion"];
	}
	$bloque3a= <<<EOF
	<table style="font-size:10px; padding:4px 3px;">
		<tr>		
			<td style="border-left: 1px solid #666; border-right: 1px solid #666; background-color:white; width:50px; text-align:center;border-bottom: 1px solid #666;">$value[num_linea]</td>
			<td style="border-right: 1px solid #666; background-color:white; width:50px; text-align:center;border-bottom: 1px solid #666;">$value[num_ctd]</td>
			<td style="border-right: 1px solid #666; background-color:white; width:60px; text-align:center;border-bottom: 1px solid #666;">$value[dsc_simbolo]</td>
			<td style="border-right: 1px solid #666; background-color:white; width:380px;border-bottom: 1px solid #666;">$value[dsc_producto]$observacion</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3a, false, false, false, false, '');
}
// ---------------------------------------------------------
if($respuesta["dsc_observacion"] != ''){
	$bloque3b = <<<EOF
	<table style="font-size:10px; padding:4px 3px;">		
		<tr>			
			<td style="border-right: 1px solid #666; border-left: 1px solid #666; background-color:white; width:540px; border-bottom: 1px solid #666;"><b>Observación general:</b> $respuesta[dsc_observacion] </td>
		</tr>	
	</table>
EOF;
$pdf->writeHTML($bloque3b, false, false, false, false, '');
}
ob_end_clean();
$pdf->Output($respuesta["cod_cotizacion"].'-'.$respuesta["dsc_referencia"].".pdf","I");
}//function traerImpresionFactura
}//class ImprimirCotizacion
$cotizacion = new ImprimirCotizacion();
$cotizacion -> codigo = $_GET["codigo"];
$cotizacion -> traerImpresionCotizacion();
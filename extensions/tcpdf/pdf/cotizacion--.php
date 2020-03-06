<?php

require_once "../../../controllers/cotizacion.controlador.php";
require_once "../../../models/cotizacion.modelo.php";

class ImprimirCotizacion{

public $codigo;

public function traerImpresionCotizacion(){

// TRAEMOS LA INFORMACIÓN DE LA COTIZACION

$itemCotizacion = "cod_cotizacion";
$valorCotizacion = $this->codigo;

$respuesta = ControladorCotizacion::ctrMostrarCotizacion($itemCotizacion,$valorCotizacion);

$fechaEmision = $respuesta["fch_emision"]->format('d-m-Y');

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

			<td style="background-color:white; width:100px;">R1157A/18</td>

		</tr>

		<tr>

			<td style="background-color:white; width:90px;">CONTACTO:</td>

			<td style="background-color:white; width:280px;">$respuesta[dsc_contacto]</td>

			<td style="background-color:white; width:70px;">Teléfono:</td>

			<td style="background-color:white; width:100px;">$respuesta[dsc_telefono]</td>

		</tr>

		<tr>

			<td style="background-color:white; width:90px;"></td>

			<td style="background-color:white; width:280px;">$respuesta[dsc_cargo]</td>

		</tr>

		<tr>

			<td style="background-color:white; width:90px;">REFERENCIA:</td>

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
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloque3a = <<<EOF

	<table style="font-size:10px; padding:4px 0px;">

		<tr style="background-color:#d1d1d1;">
		
			<td style="border: 1px solid #666; width:50px; text-align:center; font-weight:bold;">ITEM</td>

			<td style="border: 1px solid #666; width:50px; text-align:center; font-weight:bold;">CANT</td>

			<td style="border: 1px solid #666; width:60px; text-align:center; font-weight:bold;">UNID</td>

			<td style="border: 1px solid #666; width:200px; text-align:center; font-weight:bold;">DESCRIPCIÓN</td>

			<td style="border: 1px solid #666; width:90px; text-align:center; font-weight:bold;">P.UNITARIO</td>

			<td style="border: 1px solid #666; width:90px; text-align:center; font-weight:bold;">P.TOTAL</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3a, false, false, false, false, '');

$bloque3b = <<<EOF
	
	<table style="font-size:10px; padding:4px 3px;">

		<tr>
		
			<td style="border-left: 1px solid #666; border-right: 1px solid #666; background-color:white; width:50px; text-align:center">1</td>

			<td style="border-right: 1px solid #666; background-color:white; width:50px; text-align:center">46</td>

			<td style="border-right: 1px solid #666; background-color:white; width:60px; text-align:center">und.</td>

			<td style="border-right: 1px solid #666; background-color:white; width:200px;">Liner para chute de Descarga 25 x 296 x 569 P-32</td>

			<td style="border-right: 1px solid #666; background-color:white; width:90px; text-align:right">152.00</td>

			<td style="border-right: 1px solid #666; background-color:white; width:90px; text-align:right">6,992.00</td>

		</tr>

		<tr>
		
			<td style="border-left: 1px solid #666; border-right: 1px solid #666; background-color:white; width:50px; text-align:center">1</td>

			<td style="border-right: 1px solid #666; background-color:white; width:50px; text-align:center">46</td>

			<td style="border-right: 1px solid #666; background-color:white; width:60px; text-align:center">und.</td>

			<td style="border-right: 1px solid #666; background-color:white; width:200px;">Liner para chute de Descarga 25 x 296 x 569 P-32</td>

			<td style="border-right: 1px solid #666; background-color:white; width:90px; text-align:right">152.00</td>

			<td style="border-right: 1px solid #666; background-color:white; width:90px; text-align:right">6,992.00</td>

		</tr>
		
		<tr>

			<td style="border-left: 1px solid #666; border-right: 1px solid #666; background-color:white; width:50px; text-align:center"></td>

			<td style="border-right: 1px solid #666; background-color:white; width:50px; text-align:center"></td>

			<td style="border-right: 1px solid #666; background-color:white; width:60px; text-align:center"></td>

			<td style="border-right: 1px solid #666; background-color:white; width:200px;">Material:</td>

			<td style="border-right: 1px solid #666; background-color:white; width:90px; text-align:right"></td>

			<td style="border-right: 1px solid #666; background-color:white; width:90px; text-align:right"></td>

		</tr>

		<tr>

			<td style="border-left: 1px solid #666; border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:50px; text-align:center"></td>

			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:50px; text-align:center"></td>

			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:60px; text-align:center"></td>

			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:200px;">Cerámico alumina al 92%</td>

			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:90px; text-align:right"></td>

			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:90px; text-align:right"></td>

		</tr>

		<tr>

			<td style="background-color:white; width:50px; text-align:center"></td>

			<td style="background-color:white; width:50px; text-align:center"></td>

			<td style="background-color:white; width:60px; text-align:center"></td>

			<td style="background-color:white; width:200px;"></td>

			<td style="border-right: 1px solid #666; background-color:white; width:90px; text-align:right; font-weight: bold;">TOTAL US$</td>

			<td style="border-right: 1px solid #666; border-bottom: 1px solid #666;border-left: 1px solid #666; background-color:white; width:90px; text-align:right;font-weight: bold;">7,148.00</td>

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

$pdf->Output('cotizacion.pdf');

}//function traerImpresionFactura


}//class ImprimirCotizacion

$cotizacion = new ImprimirCotizacion();
$cotizacion -> codigo = $_GET["codigo"];
$cotizacion -> traerImpresionCotizacion();
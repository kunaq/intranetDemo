<?php
function recortar_texto($texto,$limite){	
    //Verifficar, nose porque lo puse antes
    //$texto = trim($texto);
    //$texto = strip_tags($texto);
    $tamano = strlen($texto);
    $resultado = '';
    if($tamano <= $limite){
        return $texto;
    }else{
        //Ocurre problemas con tilde
		//$texto = substr($texto, 0, $limite);
        $texto = mb_strcut($texto, 0, $limite,"UTF-8");
		$palabras = explode(' ', $texto);
		$resultado = implode(' ', $palabras);
		$resultado .= '..';
	}	
	return $resultado;
}//function recortar_texto
function maximoCodigoTabla($nomTabla,$nomCampo,$abreviatura,$codigoCotizacion=''){
	$db = new Conexion();
	$condicion = ($nomTabla == 'vtama_producto') ? "WHERE LEN(LTRIM(cod_producto)) = 10" : "";
	if($nomTabla == 'vtaca_cotizacion'){
		$sql = $db->consulta("SELECT vtaca_cotizacion.cod_cotizacion FROM vtaca_cotizacion WHERE CONVERT(numeric(18,0),substring(left(cod_cotizacion,CHARINDEX('/',cod_cotizacion)-1),2, len(left(cod_cotizacion,CHARINDEX('/',cod_cotizacion)-1)))) = (SELECT MAX(CONVERT(numeric(18,0),substring(left(cod_cotizacion,CHARINDEX('/',cod_cotizacion)-1),2,len(left(cod_cotizacion,CHARINDEX('/',cod_cotizacion)-1))))) FROM vtaca_cotizacion WHERE cod_cotizacion_principal = '' AND cod_cotizacion LIKE '%/".date("Y")."%') AND cod_cotizacion_principal = ''");
		$maximoValor = $db->recorrer($sql)["cod_cotizacion"];
	}else{
		$sql = $db->consulta("SELECT MAX($nomCampo) as '$nomCampo' FROM $nomTabla $condicion");	
		$maximoValor = $db->recorrer($sql)[$nomCampo];
	}
	if($maximoValor != ''){		
		//TABLA COTIZACION
		if($nomTabla == 'vtaca_cotizacion'){
			if($codigoCotizacion != ''){
				$letras = ["A","B","C","D","E","F","G","H","I","J","K","M","N","O","P","Q","R","S","T","U","V","W","Y","X","Z"];
				$sinAbreviatura = substr($codigoCotizacion, strlen($abreviatura));
				$posicionLetras = strpos($sinAbreviatura, "/");
				$letraModificar = substr($sinAbreviatura,$posicionLetras-1,1);				
				$letraABuscar = '';
				for ($i=0; $i < count($letras)-1 ; $i++) {
					if($letraModificar == $letras[$i]){
						$letraABuscar = $letras[$i];
					}					
				}
				$valorEntero = explode('/', $codigoCotizacion);
				if($letraABuscar == ''){
					//$codigoNuevo = $valorEntero[0].$letras[0]."/".$valorEntero[1];
					$sql2 =  $db->consulta("SELECT TOP(1) $nomCampo FROM $nomTabla WHERE cod_cotizacion LIKE '%".$valorEntero[0]."%' ORDER BY $nomCampo DESC");
					$maximoValorDuplicado = $db->recorrer($sql2)[$nomCampo];
					$posicionLetrasModificar = strpos($maximoValorDuplicado, "/");
					$valorLetraModifcar = substr($maximoValorDuplicado,$posicionLetrasModificar-1,1);
					$letraNueva = '';
					for ($i=0; $i < count($letras)-1 ; $i++) {
						if($valorLetraModifcar == $letras[$i]){
							$letraNueva = $letras[$i+1];
						}						
					}
					$letraNueva = ($letraNueva == '') ? $letras[0] : $letraNueva;
					$codigoNuevo = $valorEntero[0].$letraNueva."/".$valorEntero[1];
				}else{
					$valorEntero[0] = str_replace($letraModificar, '', $valorEntero[0]);
					$sql2 =  $db->consulta("SELECT TOP(1) $nomCampo FROM $nomTabla WHERE cod_cotizacion LIKE '%".$valorEntero[0]."%' ORDER BY $nomCampo DESC");
					$maximoValorDuplicado = $db->recorrer($sql2)[$nomCampo];
					$posicionLetrasModificar = strpos($maximoValorDuplicado, "/");
					$valorLetraModifcar = substr($maximoValorDuplicado,$posicionLetrasModificar-1,1);
					$letraNueva = '';
					for ($i=0; $i < count($letras)-1 ; $i++) {
						if($valorLetraModifcar == $letras[$i]){
							$letraNueva = $letras[$i+1];
						}						
					}
					$letraTotalNuevo = str_replace($valorLetraModifcar, $letraNueva, $maximoValorDuplicado);
					$codigoNuevo = $letraTotalNuevo;
				}
			}else{
				$maximoValorParteEntera = substr($maximoValor, strlen($abreviatura));
				$codigos = explode('/',$maximoValorParteEntera);
				$valorEntero = intval($codigos[0])+1;
				if(date("Y") == $codigos[1]){
					$valorEntero2 = $codigos[1];
					$valorEntero = $valorEntero;
				}else{
					$valorEntero2 = date("Y");
					$valorEntero = 100;
				}
				$codigoNuevo = $abreviatura.$valorEntero.'/'.$valorEntero2;
			}
		}else{
			#Obtengo el tamaño(la longitud) del maximo codigo
			$longitudMaximoValor = strlen($maximoValor);
			$abreviatura = ($abreviatura == 'PAIS') ? '' : $abreviatura;
			$valorTexto = substr($maximoValor, 0, strlen($abreviatura));
			if($abreviatura == $valorTexto){
				#Obtengo los valores enteros de la cadena
				$maximoValorParteEntera = substr($maximoValor, strlen($abreviatura));
				#Lo convierto toda la cadena(numerica) a entero y lo sumo 1
				$maximoValorEntero = intval($maximoValorParteEntera)+1;
				#Obtengo la longitud de la variable q pase a entero
				$longitudMaximoValorEntero = strlen($maximoValorEntero);
				//Operacion para saber cuantas veces debo de poner los 0
				$contadorCeros = $longitudMaximoValor - $longitudMaximoValorEntero;
				$maximoValorParteTexto = substr($maximoValor, 0, $contadorCeros);
				$codigoNuevo = $maximoValorParteTexto.$maximoValorEntero;
			}
			else{
				$codigoNuevo = $abreviatura.'0001';
			}
		}
	}else{
		switch ($abreviatura) {
			case 'CL':			
				$codigoNuevo = 'CL000001';
				break;
			case 'TP':			
				$codigoNuevo = 'TP001';
				break;
			case 'DI':			
				$codigoNuevo = 'DI001';
				break;
			case 'CT':			
				$codigoNuevo = 'CT001';
				break;
			case 'R':			
				$codigoNuevo = 'R100/'.date("Y");
				break;
			case 'CON':
				$codigoNuevo = 'CON0001';
				break;
			case '':
				$codigoNuevo = '0001';
				break;
			case 'PAIS':
				$codigoNuevo = '00001';
				break;
			default:
				//Productos
				$codigoNuevo = date("Y").date("m").'0001';
				break;
		}
	}
	$db->liberar($sql);
    $db->cerrar();
	return $codigoNuevo;
}//function maximoCodigoTabla
function ms_escape_string($data) {
    if ( !isset($data) or empty($data) ) return '';
    if ( is_numeric($data) ) return $data;
    $non_displayables = array(
        '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
        '/%1[0-9a-f]/',             // url encoded 16-31
        '/[\x00-\x08]/',            // 00-08
        '/\x0b/',                   // 11
        '/\x0c/',                   // 12
        '/[\x0e-\x1f]/'             // 14-31
    );
    foreach ( $non_displayables as $regex )
        $data = preg_replace( $regex, '', $data );
    $data = str_replace("'", "''", $data );
    return $data;
}//function ms_escape_string
function escapeComillasJson($data){
	$data = str_replace('"', '\\"', $data);
	return $data;
}//function escapeComillasJson
function escapeComillasJson2($data){
	$data = str_replace("'", "&#039", $data);
	return $data;
}//function escapeComillasJson
function arrayMapUtf8Decode($data){
    if($data != ''){
        return array_map('utf8_decode', $data);
    }else{
        return $data;
    }
}//function arrayMapUtf8
function arrayMapUtf8Encode($data){
    if($data != ''){
        return array_map('utf8_encode', $data);
    }else{
        return $data;
    }
}//function arrayMapUtf8
function Utf8Decode($data){
	return utf8_decode($data);
}//function Utf8Decode
function Utf8Encode($data){
	return utf8_encode($data);
}//function Utf8Encode
function rutaGlobal($data){
	return str_replace("\controllers", "", $data);
}//function rutaGlobal
function dateFormat($data){
	return date_format(new DateTime($data), 'd/m/Y');
}//function dateFormat
function dateTimeFormat($data){
    return date_format(new DateTime($data), 'd-m-Y H:i:s');
}//function dateTimeFormat
function dateTimeFormat2($data){
	return date_format(new DateTime($data), 'Y-m-d H:i:s');
}//function dateTimeFormat
function dateFormatCumpleanios($data){
	return date_format(new DateTime($data), 'm-d');
}//function dateFormatCumpleanios
function dateFormatCumpleanios2($data){
	return date_format(new DateTime($data), 'd-m');
}//function dateFormatCumpleanios
function trimForeach($respuesta){
    if($respuesta != ''){
        foreach ($respuesta as $key => $value) {		
    		if(is_string($respuesta[$key])){
    			$respuesta[$key] = trim($value);
    		}
    	}//foreach
    }
	return $respuesta;
}//function trimForeach
function valoresNull($respuesta){
    if($respuesta != ''){
        foreach ($respuesta as $key => $value){
    		if($value == null){
    			$value = ''; 
    		}
    		$respuesta[$key] = $value;
    	}//foreach
    }
	return $respuesta;
}//function valoresNull
function valorVacioEntero($valor){
	if($valor == ''){
		$nuevoValor = 'NULL';
	}else{
		$nuevoValor = $valor;
	}
	return $nuevoValor;
}//function valorVacioEntero
function replaceComas($valor){
	$valor = str_replace(",", "", $valor);
	return $valor;
}//function replaceComas
function ordenarFechaDate($valor=''){
	if($valor != ''){
		$fecha = explode("-", $valor);
		$valor = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
		$valor = "'".$valor."'";
	}else{
		$valor = 'NULL';
	}
	return $valor;
}
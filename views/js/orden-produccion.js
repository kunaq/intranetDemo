$('#parentHorizontalTab').easyResponsiveTabs({
 	type: 'default', //Types: default, vertical, accordion
    width: 'auto', //auto or any width like 600px
    fit: true, // 100% fit in a container
    tabidentify: 'hor_1' // The tab groups identifier
});
$(".inputFecha").datepicker({
  format: 'dd-mm-yyyy',
  autoclose: true
});//datepicker
/*=============================================
CREACION DE VARIABLES
=============================================*/
var codLocalidad = $("#codLocalidadOrdPrd").val();
var numOrdenProd = $("#numOrdPrdOrig").val();
var contAgrPrd = 1,contNumLnaPrd = 1;
var tdProducto = '', tdCantidad = '', tdUnidad = '',txtCotizacion = '', tdButtonEliminar = '', tdHideCantidad = '', fchEntregaCtz = '', tdBotones = '';
var actualizaNumLinea = flgEstadoAnu = flgEstadoCulminado = areaEstadoTerminado = 'NO';
var flgEstadoOrigAnul = $("#flgAnuladoEstOrdPrd").val();
var datatableObservacion = '';
/*=============================================
SELECCIONAR UN ESTADO
=============================================*/
$("#codEstadoOrdPrd").change(function(){
	//Pace.track(function(){
		//cargaGifDivForm("formOrdenProduccion","sinOcultar");
		$.ajax({
			url:"ajax/ordenProduccion.ajax.php",
		  	method: "POST",
		  	data: {'codEstado':$(this).val(),'accionOrdenProduccion':'consultarEstado','entrada':'flgEstados','localidad':codLocalidad,'ordenProduccion':numOrdenProd},
		  	success: function(respuesta){
		  		console.log("respuesta", respuesta);
		  		respuesta = respuesta.split('|');
		  		flgEstadoAnu = respuesta[0];
		  		flgEstadoCulminado = respuesta[1];
		  		areaEstadoTerminado = respuesta[2];
		  		if(flgEstadoCulminado == 'SI' && areaEstadoTerminado == 'NO'){
		  			swal({
				  		type: "warning",
				  		title: "¡Alerta!",
				  		text: "Para pasar a estado culminado todas las áreas deben estar en estado terminado",
				  		showConfirmButton: true,
						confirmButtonText: "Cerrar",
						onAfterClose: () => $("#codEstadoOrdPrd").val($("#codEstadoOriginOrdPrd").val())
					});
		  		}
		  	}
		});
	//});//Pace.track
});//change codEstadoOrdPrd
/*=============================================
SELECCIONAR UN CLIENTE
=============================================*/
$("#clienteOrdProd").change(function(){
	if($(this).val() == ''){
		$("#btnBuscarOrdenCompra").removeAttr("data-toggle data-target data-dismiss");
		$("#btnBuscarOrdenCompra").attr("disabled",true);
		$("#btnBuscarOrdenCompra").attr("title","Debes seleccionar un cliente");
	}else{
		$("#btnBuscarOrdenCompra").attr({"data-toggle":"modal","data-target":"#modalCotizacion","data-dismiss":"modal"});
		$("#btnBuscarOrdenCompra").attr("disabled",false);
		$("#btnBuscarOrdenCompra").attr("title","Buscar");
	}
	$("#ordenCompraOrdPrd").val('');
});//click clienteOrdProd
/*=============================================
LIMPIAR ORDEN DE COMPRA
=============================================*/
$("#btnLimpiarOrdenCompra").click(function(){
	$("#clienteOrdProd").val('').trigger('change');
	$("#ordenCompraOrdPrd").val('');
	var filaLimpiar = $(".inputCodCtzPrdOrdPrd");
	for (var i = 0; i < filaLimpiar.length; i++) {
		if($(filaLimpiar[i]).html() != '---'){
			$(filaLimpiar[i]).parent().remove();
			actualizaNumLinea = 'SI';
		}
	}
	if(actualizaNumLinea == 'SI'){
		var numLinea = $(".inputNumLnaPrdOrdPrd");
		for (var i = 0; i < numLinea.length; i++) {
			$(numLinea[i]).html(parseInt(i)+1);
			contNumLnaPrd = parseInt(i)+2;
		}
		if(numLinea.length == 0){
			contNumLnaPrd = 1;
		}
	}
	listarProductos();
});//click btnLimpiarOrdenCompra
/*=============================================
CAMBIAR FECHA VALIDADA, ACTUALIZAR A TODO EL DETALLE
=============================================*/
$("#fchValidadaOrdPrd").change(function(){
	//$(".inputFchVldPrdOrdPrd").val($(this).val());
	//listarProductos();
});//change fchValidadaOrdPrd
/*=============================================
BUSCAR POR DE COMPRA
=============================================*/
$("#btnBuscarOrdenCompra").click(function(){
	/*=============================================
	GENERO EL DATATABLE DE COTIZACION
	=============================================*/
	$("#tblCotizacionModal").DataTable().destroy();
	$("#tblCotizacionModal").DataTable({
		"ajax": "ajax/datatable-cotizacion.ajax.php?entrada=vtnOrdenProduccion&codCliente="+$("#clienteOrdProd").val()+"&enUso=NO",
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
	  	'columnDefs': [
			{
				targets: [0],
				className: "text-center crsPointer tblCtzOrdProdWidthOrdCmp selecionaCtzOrdPrd ordenCompra"
			},
			{
				targets: [1],
				className: "text-center crsPointer tblCtzOrdProdWidthCtz selecionaCtzOrdPrd"
			},
			{
				targets: [2],
				className: "text-center crsPointer tblCtzOrdProdWidthFch selecionaCtzOrdPrd"
			},
			{
				targets: [3],
				className: "text-right crsPointer tblCtzOrdProdWidthImp selecionaCtzOrdPrd"
			}
		]
	});//DataTable tablaAreaOrdProd
});//click btnBuscarOrdenCompra
/*=============================================
RECUPERAR DATO AL SELECCIONAR UNA COTIZACION
=============================================*/
$("#tblCotizacionModal").on("click", "td.selecionaCtzOrdPrd", function(){
	var numOrdCmp = $(this).parent().children('td.ordenCompra').html();
	$("#ordenCompraOrdPrd").val(numOrdCmp);
	//mostrarProductosXOrdCmp($("#clienteOrdProd").val(),numOrdCmp);
	$("#modalCotizacion").modal('hide');
	$("#modalProductosCotizacion").modal('show');
	mostrarProductosCotizacion($("#clienteOrdProd").val(),numOrdCmp);
});//click tblCotizacionModal
/*=============================================
MOSTRAR PRODUCTOS EN EL MODAL DE LISTADO
=============================================*/
function mostrarProductosCotizacion(codCliente,ordenCompra){
	console.log('entro');
	/*=============================================
	GENERO EL DATATABLE DE PRODUCTOS COTIZACION
	=============================================*/
	$("#tblProductosCotizacionModal").DataTable().destroy();
	$("#tblProductosCotizacionModal").DataTable({
		"ajax": "ajax/datatable-cotizacion.ajax.php?entrada=vtnOrdenProduccionCtzPrd&codCliente="+codCliente+"&ordenCompra="+ordenCompra+'&enUso=NO',
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
	  	'columnDefs': [
	  		{
				targets: [0],
				className: "text-center tdCheckFila"
			},
			{
				targets: [1],
				className: "text-center tdCotizacion"
			},
			{
				targets: [2],
				className: "text-center tdProducto"
			},
			{
				targets: [3],
				className: "text-center tdCantidad"
			},
			{
				targets: [4],
				className: "text-center tdUnidad"
			},			
			{
				targets: [5],
				className: "hidden tdFchEmisionOrdCmp"
			},
			{
				targets: [6],
				className: "hidden tdCodProductoOrdCmp"
			},
			{
				targets: [7],
				className: "hidden tdCodUnidadOrdCmp"
			}
		]
	});
}//function mostrarProductosCotizacion
/*=============================================
SELECCIONE UN PRODUCTO
=============================================*/
$("#btnGuardarProdCtzOrdPrd").click(function(){
	var filaLimpiar = $(".inputCodCtzPrdOrdPrd");
	for (var i = 0; i < filaLimpiar.length; i++) {
		if($(filaLimpiar[i]).html() != '---'){
			$(filaLimpiar[i]).parent().remove();
			actualizaNumLinea = 'SI';
		}
	}
	if(actualizaNumLinea == 'SI'){
		var numLinea = $(".inputNumLnaPrdOrdPrd");
		for (var i = 0; i < numLinea.length; i++) {
			$(numLinea[i]).html(parseInt(i)+1);
			contNumLnaPrd = parseInt(i)+2;
		}
	}
	var cotizacion = $("#tblProductosCotizacionModal tbody .tdCotizacion");
	var producto = $("#tblProductosCotizacionModal tbody .tdProducto");
	var cantidad = $("#tblProductosCotizacionModal tbody .tdCantidad");
	var unidad = $("#tblProductosCotizacionModal tbody .tdUnidad");
	var fchEmisionOrdCmp = $("#tblProductosCotizacionModal tbody .tdFchEmisionOrdCmp");
	var checked = $("#tblProductosCotizacionModal tbody input.checkCtzPrdOrdPrd");
	var codProducto  = $("#tblProductosCotizacionModal tbody .tdCodProductoOrdCmp");
	var codUnidad = $("#tblProductosCotizacionModal tbody .tdCodUnidadOrdCmp");
	for (var i = 0; i < cotizacion.length; i++) {
		var valor = $(cantidad[i]).find('input[type="number"]').val();
		if($(checked[i]).is(':checked')) {
			$("#tablaPrdOrdProd tbody").append(
  			'<tr>'+
  				'<td class="text-center inputNumLnaPrdOrdPrd tblPrdOrdProdWidthCorl">'+contNumLnaPrd+'</td>'+
				'<td class="text-center tblPrdOrdProdWidthCtz inputCodCtzPrdOrdPrd">'+$(cotizacion[i]).html()+'</td>'+
		        '<td class="text-center tblPrdOrdProdWidthFchEtg">'+
		        	'<div class="input-group date">'+
              			'<div class="input-group-addon">'+
                			'<i class="fa fa-calendar"></i>'+
              			'</div>'+
		        		'<input type="text" class="form-control inputFchEtgPrdOrdPrd" value="'+$(fchEmisionOrdCmp[i]).html()+'" />'+
		        	'</div>'+
		        '</td>'+
		        '<td class="text-center tblPrdOrdProdWidthFchVld">'+
		        	'<div class="input-group date" style="width:85%;float:left;">'+
              			'<div class="input-group-addon">'+
                			'<i class="fa fa-calendar"></i>'+
              			'</div>'+
		        		'<input type="text" class="form-control inputFchVldPrdOrdPrd" value="'+$("#fchValidadaOrdPrd").val()+'" style="color:#ff0000" />'+
		        	'</div>'+
		        	'<input type="checkbox" class="inputChkFchValidadaPrdOrdPrd" style="width:15%;margin-top:10px;" value="NO" />'+
		        '</td>'+
		        '<td class="tblPrdOrdProdWidthArea"><input type="text" class="form-control text-right inputAreaPrdOrdPrd"></td>'+
		        '<td class="tblPrdOrdProdWidthPeso"><input type="text" class="form-control text-right inputPesoPrdOrdPrd"></td>'+
		        '<td class="tblPrdOrdProdWidthDscPrd">'+$(producto[i]).html()+'</td>'+
		        '<td class="text-right tblPrdOrdProdWidthCnt inputCtdPrdOrdPrd">'+valor+'</td>'+
		        '<td class="tblPrdOrdProdWidthUnd">'+$(unidad[i]).html()+'</td>'+
		        '<td class="text-center tblPrdOrdProdWidthBtnIpr">'+
	            	'<div class="btn-group">'+
		            	'<button type="button" class="btn btn-sm btnImprimirCotizacionSpl" style="background-color: #a09c9c; border-color:#9a8e8e; color:#fff; margin-right:4px;" title="Impresión simplificada" codCotizacion="'+$(cotizacion[i]).html()+'">'+
		                	'<i class="glyphicon glyphicon-print"></i>'+
		              	'</button>'+
		              	'<button type="button" class="btn btn-sm bg-olive btnDatosAdjuntosCtz" title="Ver datos adjuntos" data-toggle="modal" data-target="#modalDatosAdjuntosCtz" data-dismiss="modal" codCotizacion="'+$(cotizacion[i]).html()+'">'+
		                	'<i class="fa fa-binoculars"></i>'+
		              	'</button>'+
		            '</div>'+
	            '</td>'+
		        '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-times"></i></button></td>'+
		        '<input type="hidden" class="inputCodPrdOrdPrd" value="'+$(codProducto[i]).html()+'" />'+
		        '<input type="hidden" class="inputCodUndMdaPrdOrdPrd" value="'+$(codUnidad[i]).html()+'" />'+
		        '<input type="hidden" class="inputFchEtgPrdOrdPrdOriginal" value="nuevo" />'+
				'<input type="hidden" class="inputFchVldPrdOrdPrdOriginal" value="nuevo" />'+
				'<input type="hidden" class="inputChkValidPrdOrdPrdOriginal" value="nuevo" />'+
				'<input type="hidden" class="inputAreaPrdOrdPrdOriginal" value="nuevo" />'+
				'<input type="hidden" class="inputPesoPrdOrdPrdOriginal" value="nuevo" />'+
				'<input type="hidden" class="inputFlgChkVldModfPrdOrdPrd" value="NO" />'+
			'</tr>');
			fchEntregaCtz = $(fchEmisionOrdCmp[i]).html();
	  		$(".inputFchEtgPrdOrdPrd,.inputFchVldPrdOrdPrd").datepicker({
			  	format: 'dd-mm-yyyy',
			  	autoclose: true
			});//datepicker
			$('[data-toggle="tooltip"]').tooltip();
			$(".inputAreaPrdOrdPrd,.inputPesoPrdOrdPrd").number(true,2);
			contNumLnaPrd++;
			contAgrPrd++;
			listarProductos();
		}//if
	}//for
	$("#fchCompromisoOrdPrd").datepicker("setDate",fchEntregaCtz);
	$("#modalProductosCotizacion").modal('hide');
});//click btnGuardarProdCtzOrdPrd
/*=============================================
RECUPERAR LA COTIZACION RELACIONADOS A LA
ORDEN DE COMPRA SELECCIONADA
=============================================*/
function mostrarProductosXOrdCmp(codCliente,ordenCompra){
	var filaLimpiar = $(".inputCodCtzPrdOrdPrd");
	for (var i = 0; i < filaLimpiar.length; i++) {
		if($(filaLimpiar[i]).html() != '---'){
			$(filaLimpiar[i]).parent().remove();
			actualizaNumLinea = 'SI';
		}
	}
	if(actualizaNumLinea == 'SI'){
		var numLinea = $(".inputNumLnaPrdOrdPrd");
		for (var i = 0; i < numLinea.length; i++) {
			$(numLinea[i]).html(parseInt(i)+1);
			contNumLnaPrd = parseInt(i)+2;
		}
	}
	$.ajax({
		url:"ajax/ordenProduccion.ajax.php",
	  	method: "POST",
	  	dataType: 'json',
	  	data: {'codCliente':codCliente,'ordenCompra':ordenCompra,'accionOrdenProduccion':'relacionCtzOrdCmp'},
	  	success: function(respuesta){
	  		$.each(respuesta,function(index,value){
		  		$("#tablaPrdOrdProd tbody").append(
		  			'<tr>'+
		  				'<td class="text-center inputNumLnaPrdOrdPrd tblPrdOrdProdWidthCorl">'+contNumLnaPrd+'</td>'+
						'<td class="text-center tblPrdOrdProdWidthCtz inputCodCtzPrdOrdPrd">'+value["cod_cotizacion"]+'</td>'+
				        '<td class="text-center tblPrdOrdProdWidthFchEtg">'+
				        	'<div class="input-group date">'+
	                  			'<div class="input-group-addon">'+
	                    			'<i class="fa fa-calendar"></i>'+
	                  			'</div>'+
				        		'<input type="text" class="form-control inputFchEtgPrdOrdPrd" value="'+value["fchEmision_orden_compra"]+'" />'+
				        	'</div>'+
				        '</td>'+
				        '<td class="text-center tblPrdOrdProdWidthFchVld">'+
				        	'<div class="input-group date" style="width:85%;float:left;">'+
	                  			'<div class="input-group-addon">'+
	                    			'<i class="fa fa-calendar"></i>'+
	                  			'</div>'+
				        		'<input type="text" class="form-control inputFchVldPrdOrdPrd" value="'+$("#fchValidadaOrdPrd").val()+'" style="color:#ff0000;" />'+
				        	'</div>'+
				        	'<input type="checkbox" class="inputChkFchValidadaPrdOrdPrd" style="width:15%;margin-top:10px;" value="NO" />'+
				        '</td>'+
				        '<td class="tblPrdOrdProdWidthArea"><input type="text" class="form-control text-right inputAreaPrdOrdPrd"></td>'+
				        '<td class="tblPrdOrdProdWidthPeso"><input type="text" class="form-control text-right inputPesoPrdOrdPrd"></td>'+
				        '<td class="tblPrdOrdProdWidthDscPrd">'+value["dsc_producto"]+'</td>'+
				        '<td class="text-right tblPrdOrdProdWidthCnt inputCtdPrdOrdPrd">'+value["num_ctd"]+'</td>'+
				        '<td class="tblPrdOrdProdWidthUnd">'+value["dsc_simbolo"]+'</td>'+
				        '<td class="text-center tblPrdOrdProdWidthBtnIpr">'+
			            	'<div class="btn-group">'+
				            	'<button type="button" class="btn btn-sm btnImprimirCotizacionSpl" style="background-color: #a09c9c; border-color:#9a8e8e; color:#fff; margin-right:4px;" title="Impresión simplificada" codCotizacion="'+value["cod_cotizacion"]+'">'+
				                	'<i class="glyphicon glyphicon-print"></i>'+
				              	'</button>'+
				              	'<button type="button" class="btn btn-sm bg-olive btnDatosAdjuntosCtz" title="Ver datos adjuntos" data-toggle="modal" data-target="#modalDatosAdjuntosCtz" data-dismiss="modal" codCotizacion="'+value["cod_cotizacion"]+'">'+
				                	'<i class="fa fa-binoculars"></i>'+
				              	'</button>'+
				            '</div>'+
			            '</td>'+
				        '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-times"></i></button></td>'+
				        '<input type="hidden" class="inputCodPrdOrdPrd" value="'+value["cod_producto"]+'" />'+
				        '<input type="hidden" class="inputCodUndMdaPrdOrdPrd" value="'+value["cod_unidad_medida"]+'" />'+
				        '<input type="hidden" class="inputFchEtgPrdOrdPrdOriginal" value="nuevo" />'+
						'<input type="hidden" class="inputFchVldPrdOrdPrdOriginal" value="nuevo" />'+
						'<input type="hidden" class="inputChkValidPrdOrdPrdOriginal" value="nuevo" />'+
						'<input type="hidden" class="inputAreaPrdOrdPrdOriginal" value="nuevo" />'+
						'<input type="hidden" class="inputPesoPrdOrdPrdOriginal" value="nuevo" />'+
						'<input type="hidden" class="inputFlgChkVldModfPrdOrdPrd" value="NO" />'+
				    '</tr>'
		  		);
		  		fchEntregaCtz = value["fchEmision_orden_compra"];
		  		$(".inputFchEtgPrdOrdPrd,.inputFchVldPrdOrdPrd").datepicker({
				  	format: 'dd-mm-yyyy',
				  	autoclose: true
				});//datepicker
				$('[data-toggle="tooltip"]').tooltip();
				$(".inputAreaPrdOrdPrd,.inputPesoPrdOrdPrd").number(true,2);
				contNumLnaPrd++;
				contAgrPrd++;
				listarProductos();
		  	});//each
		  	$("#fchCompromisoOrdPrd").datepicker("setDate",fchEntregaCtz);
	  	}//success
	});
}//function mostrarProductosXOrdCmp
/*=============================================
REPLICAR FECHA DE ENTREGA
=============================================*/
$("#btnReplicarFchEntrega").click(function(){
	if($("#fchCompromisoOrdPrd").val() == ''){
		swal({
	  		type: "warning",
	  		title: "¡Alerta!",
	  		text: "Debes ingresar una fecha de entrega",
	  		showConfirmButton: true,
			confirmButtonText: "Cerrar",
			onAfterClose: () => $("#fchCompromisoOrdPrd").focus()
		});
	}else{
		var fchEntrega = $(".inputFchEtgPrdOrdPrd");
		for (var i = 0; i < fchEntrega.length; i++) {
			$(fchEntrega[i]).val($("#fchCompromisoOrdPrd").val());
		}//for
		listarProductos();
	}
});//click btnReplicarFchEntrega
/*=============================================
REPLICAR FECHA VALIDADA POR EL CLIENTE
=============================================*/
$("#btnReplicarFchValidada").click(function(){
	if($("#fchValidadaOrdPrd").val() == ''){
		swal({
	  		type: "warning",
	  		title: "¡Alerta!",
	  		text: "Debes ingresar una fecha validada por cliente",
	  		showConfirmButton: true,
			confirmButtonText: "Cerrar",
			onAfterClose: () => $("#fchValidadaOrdPrd").focus()
		});
	}else{
		var fchValidada = $(".inputFchVldPrdOrdPrd");
		for (var i = 0; i < fchValidada.length; i++) {
			$(fchValidada[i]).val($("#fchValidadaOrdPrd").val());
		}//for
		listarProductos();
	}
});//click btnReplicarFchEntrega
/*=============================================
REPLICAR FECHA VALIDADA POR EL CLIENTE
=============================================*/
$("#chkValidadoOrdProd").change(function(){
	var chkFchValidada = $(".inputChkFchValidadaPrdOrdPrd");
	var fchValidada = $(".inputFchVldPrdOrdPrd");
	if($(this).is(':checked')) {		
		for (var i = 0; i < chkFchValidada.length; i++) {
			$(chkFchValidada[i]).prop("checked",true);
			$(chkFchValidada[i]).val("SI");
			$(fchValidada[i]).css("color","#0000ff");
		}//for
	}else{
		for (var i = 0; i < chkFchValidada.length; i++) {
			$(chkFchValidada[i]).prop("checked",false);
			$(chkFchValidada[i]).val("NO");
			$(fchValidada[i]).css("color","#ff0000");
		}//for
	}
});
/*=============================================
INICIO TAB PRODUCTOS O SERVICIOS
=============================================*/
/*=============================================
MOSTRAR FILAS A LA TABLA PRODUCTO
=============================================*/
function mostrarTablaProductos(){
	$("#tablaPrdOrdProd tbody").html("");
	var disabledProdChk = '';
	$.ajax({
		url:"ajax/ordenProduccion.ajax.php",
	  	method: "POST",
	  	dataType: 'json',
	  	data: {'codLocalidad':codLocalidad,'numOrdProd':numOrdenProd,'entrada':'productoRelacOrdProd','accionOrdenProduccion':'mostrar'},
	  	success: function(respuesta){
	  		$.each(respuesta,function(index,value){
	  			var colorChkValidada = (value["flg_fch_validada"] == 'SI') ? '#0000ff' : '#ff0000';
	  			var chkValidada = (value["flg_fch_validada"] == 'SI') ? 'checked' : '#ff0000';
	  			disabledProdChk = (flgEstadoOrigAnul == 'NO') ? '' : 'disabled';
				if(value["cod_cotizacion"] == ''){
					/*tdProducto = '<td class="tblPrdOrdProdWidthDscPrd" id="filaPrdOrdPrd_'+contAgrPrd+'">'+
						'<select class="full-width select2 selectPrdOrdPrd" style="width:100%;"></select>'+
					'</td>';*/
					tdProducto = '<td class="tblPrdOrdProdWidthDscPrd">'+value["dsc_producto"]+'</td>';
					tdCantidad = '<td class="tblPrdOrdProdWidthCnt">'+
						'<input type="text" class="form-control inputCtd2PrdOrdPrd text-right" value="'+value["ctd_orden"]+'" '+disabledProdChk+' />'+
					'</td>';
		            tdUnidad = '<td class="tblPrdOrdProdWidthUnd" id="filaUndMdaOrdPrd_'+contAgrPrd+'">'+
		              	'<select class="full-width select2 selectUndMdaOrdPrd" style="width:100%;" '+disabledProdChk+'></select>'+
		            '</td>';
		            txtCotizacion = '---';
		            tdButtonEliminar = '<td class="text-center"><button type="button" class="btn btn-sm btn-danger removerFilaPrdOrdPrd"><i class="fa fa-times"></i></button></td>';
		            tdHideCantidad = '<td class="hidden inputCtdPrdOrdPrd">'+value["ctd_orden"]+'</td>';
		            tdBotones = '<td class="text-center tblPrdOrdProdWidthBtnIpr">'+
					            	'<div class="btn-group">'+
						            	'<button type="button" class="btn btn-sm" style="background-color: #a09c9c; border-color:#9a8e8e; color:#fff; margin-right:4px;" title="Impresión simplificada" disabled>'+
						                	'<i class="glyphicon glyphicon-print"></i>'+
						              	'</button>'+
						              	'<button type="button" class="btn btn-sm bg-olive" data-toggle="tooltip" title="Ver datos adjuntos" disabled>'+
						                	'<i class="fa fa-binoculars"></i>'+
						              	'</button>'+
						            '</div>'+
					            '</td>';
		            mostrarProductos(contAgrPrd,value["cod_producto"]);
					mostrarUnidadMedida(contAgrPrd,value["cod_unidad"]);
				}else{
					tdProducto = '<td class="tblPrdOrdProdWidthDscPrd">'+value["dsc_producto"]+'</td>';
					tdCantidad = '<td class="text-right tblPrdOrdProdWidthCnt inputCtdPrdOrdPrd">'+value["ctd_orden"]+'</td>';
					tdUnidad = '<td class="tblPrdOrdProdWidthUnd">'+value["dsc_simbolo"]+'</td>';
					txtCotizacion = value["cod_cotizacion"];
					tdHideCantidad = '';
					tdButtonEliminar = '<td class="text-center"><button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-times"></i></button></td>';
					tdBotones = '<td class="text-center tblPrdOrdProdWidthBtnIpr">'+
					            	'<div class="btn-group">'+
						            	'<button type="button" class="btn btn-sm btnImprimirCotizacionSpl" style="background-color: #a09c9c; border-color:#9a8e8e; color:#fff; margin-right:4px;" title="Impresión simplificada" codCotizacion="'+value["cod_cotizacion"]+'">'+
						                	'<i class="glyphicon glyphicon-print"></i>'+
						              	'</button>'+
						              	'<button type="button" class="btn btn-sm bg-olive btnDatosAdjuntosCtz" title="Ver datos adjuntos" data-toggle="modal" data-target="#modalDatosAdjuntosCtz" data-dismiss="modal" codCotizacion="'+value["cod_cotizacion"]+'">'+
						                	'<i class="fa fa-binoculars"></i>'+
						              	'</button>'+
						            '</div>'+
					            '</td>';
				}
				tdButtonEliminar = (flgEstadoOrigAnul == 'NO') ? tdButtonEliminar : '';				
				$("#tablaPrdOrdProd tbody").append(
		  			'<tr>'+
		  				'<td class="text-center inputNumLnaPrdOrdPrd tblPrdOrdProdWidthCorl">'+contNumLnaPrd+'</td>'+
						'<td class="text-center tblPrdOrdProdWidthCtz inputCodCtzPrdOrdPrd">'+txtCotizacion+'</td>'+
				        '<td class="text-center tblPrdOrdProdWidthFchEtg">'+
				        	'<div class="input-group date">'+
	                  			'<div class="input-group-addon">'+
	                    			'<i class="fa fa-calendar"></i>'+
	                  			'</div>'+
				        		'<input type="text" class="form-control inputFchEtgPrdOrdPrd" value="'+value["fch_entrega"]+'" '+disabledProdChk+' />'+
				        	'</div>'+
				        '</td>'+
				        '<td class="text-center tblPrdOrdProdWidthFchVld">'+
				        	'<div class="input-group date" style="width:85%;float:left;">'+
	                  			'<div class="input-group-addon">'+
	                    			'<i class="fa fa-calendar"></i>'+
	                  			'</div>'+
				        		'<input type="text" class="form-control inputFchVldPrdOrdPrd" value="'+value["fch_validada"]+'" style="color:'+colorChkValidada+';" '+disabledProdChk+' />'+
				        	'</div>'+
				        	'<input type="checkbox" class="inputChkFchValidadaPrdOrdPrd" style="width:15%;margin-top:10px;" value="'+value["flg_fch_validada"]+'" '+chkValidada+' '+disabledProdChk+' />'+
				        '</td>'+
				        '<td class="tblPrdOrdProdWidthArea"><input type="text" class="form-control text-right inputAreaPrdOrdPrd" value="'+value["imp_area"]+'" '+disabledProdChk+'></td>'+
				        '<td class="tblPrdOrdProdWidthPeso"><input type="text" class="form-control text-right inputPesoPrdOrdPrd" value="'+value["imp_peso"]+'" '+disabledProdChk+'></td>'+
				        tdProducto+
				        tdCantidad+
				        tdUnidad+
				        tdBotones+
				       	tdButtonEliminar+
				        '<input type="hidden" class="inputCodPrdOrdPrd" value="'+value["cod_producto"]+'" />'+
				        '<input type="hidden" class="inputCodUndMdaPrdOrdPrd" value="'+value["cod_unidad"]+'" />'+
				        '<input type="hidden" class="inputFchEtgPrdOrdPrdOriginal" value="'+value["fch_entrega"]+'" />'+
				        '<input type="hidden" class="inputFchVldPrdOrdPrdOriginal" value="'+value["fch_validada"]+'" />'+
				        '<input type="hidden" class="inputChkValidPrdOrdPrdOriginal" value="'+value["flg_fch_validada"]+'" />'+
				        '<input type="hidden" class="inputAreaPrdOrdPrdOriginal" value="'+value["imp_area"]+'" />'+
						'<input type="hidden" class="inputPesoPrdOrdPrdOriginal" value="'+value["imp_peso"]+'" />'+
						'<input type="hidden" class="inputFlgChkVldModfPrdOrdPrd" value="'+value["flg_fch_validada_modificado"]+'" />'+
				        tdHideCantidad+
				    '</tr>'
		  		);
				$(".inputFchEtgPrdOrdPrd,.inputFchVldPrdOrdPrd").datepicker({
				  	format: 'dd-mm-yyyy',
				  	autoclose: true
				});//datepicker
				$(".inputAreaPrdOrdPrd,.inputPesoPrdOrdPrd,.inputCtd2PrdOrdPrd").number(true,2);
				/*mostrarProductos(contAgrPrd,value["cod_producto"]);
				mostrarUnidadMedida(contAgrPrd,value["cod_unidad_medidaa"]);*/
				listarProductos();
				contNumLnaPrd++;
				contAgrPrd++;
	  		});//each
	  	}//success
	});//ajax
}//function mostrarTablaProductos
/*=============================================
AGREGAR FILAS A LA TABLA PRODUCTO
=============================================*/
$("#btnAgregarPrdOrdProd").click(function(){
	$("#tablaPrdOrdProd tbody").append(
		'<tr>'+
			'<td class="text-center inputNumLnaPrdOrdPrd tblPrdOrdProdWidthCorl">'+contNumLnaPrd+'</td>'+
			'<td class="text-center tblPrdOrdProdWidthCtz inputCodCtzPrdOrdPrd">---</td>'+
			 '<td class="text-center tblPrdOrdProdWidthFchEtg">'+
	        	'<div class="input-group date">'+
          			'<div class="input-group-addon">'+
            			'<i class="fa fa-calendar"></i>'+
          			'</div>'+
	        		'<input type="text" class="form-control inputFchEtgPrdOrdPrd" value="'+$("#fchCompromisoOrdPrd").val()+'" />'+
	        	'</div>'+
	        '</td>'+
	        '<td class="text-center tblPrdOrdProdWidthFchVld">'+
	        	'<div class="input-group date" style="width:85%;float:left;">'+
          			'<div class="input-group-addon">'+
            			'<i class="fa fa-calendar"></i>'+
          			'</div>'+
	        		'<input type="text" class="form-control inputFchVldPrdOrdPrd" value="'+$("#fchValidadaOrdPrd").val()+'" style="color:#ff0000;" />'+
	        	'</div>'+
	        	'<input type="checkbox" class="inputChkFchValidadaPrdOrdPrd" style="width:15%;margin-top:10px;" value="NO" />'+
	        '</td>'+
	        '<td class="tblPrdOrdProdWidthArea"><input type="text" class="form-control text-right inputAreaPrdOrdPrd"></td>'+
		        '<td class="tblPrdOrdProdWidthPeso"><input type="text" class="form-control text-right inputPesoPrdOrdPrd"></td>'+
			'<td class="tblPrdOrdProdWidthDscPrd" id="filaPrdOrdPrd_'+contAgrPrd+'">'+
				'<select class="full-width select2 selectPrdOrdPrd" style="width:100%;" required></select>'+
			'</td>'+
			'<td class="tblPrdOrdProdWidthCnt">'+
				'<input type="text" class="form-control inputCtd2PrdOrdPrd text-right" />'+
			'</td>'+
			'<td class="tblPrdOrdProdWidthUnd" id="filaUndMdaOrdPrd_'+contAgrPrd+'">'+
              '<select class="full-width select2 selectUndMdaOrdPrd" style="width:100%;"></select>'+
            '</td>'+
            '<td class="text-center tblPrdOrdProdWidthBtnIpr">'+
            	'<div class="btn-group">'+
	            	'<button type="button" class="btn btn-sm" style="background-color: #a09c9c; border-color:#9a8e8e; color:#fff; margin-right:4px;" title="Impresión simplificada" disabled>'+
	                	'<i class="glyphicon glyphicon-print"></i>'+
	              	'</button>'+
	              	'<button type="button" class="btn btn-sm bg-olive" data-toggle="tooltip" title="Ver datos adjuntos" disabled>'+
	                	'<i class="fa fa-binoculars"></i>'+
	              	'</button>'+
	            '</div>'+
            '</td>'+
            '<td class="tblPrdOrdProdWidthBtnElm text-center">'+
            	'<button type="button" class="btn btn-sm btn-danger removerFilaPrdOrdPrd">'+
                	'<i class="fa fa-times"></i>'+
              	'</button>'+
            '</td>'+
            '<input type="hidden" class="inputCodPrdOrdPrd" />'+
            '<input type="hidden" class="inputCodUndMdaPrdOrdPrd" />'+
            '<input type="hidden" class="inputFchEtgPrdOrdPrdOriginal" value="nuevo" />'+
			'<input type="hidden" class="inputFchVldPrdOrdPrdOriginal" value="nuevo" />'+
			'<input type="hidden" class="inputChkValidPrdOrdPrdOriginal" value="nuevo" />'+
			'<input type="hidden" class="inputAreaPrdOrdPrdOriginal" value="nuevo" />'+
			'<input type="hidden" class="inputPesoPrdOrdPrdOriginal" value="nuevo" />'+
			'<input type="hidden" class="inputFlgChkVldModfPrdOrdPrd" value="NO" />'+
            '<td class="hidden inputCtdPrdOrdPrd"></td>'+
		'</tr>'
	);
	$(".inputFchEtgPrdOrdPrd,.inputFchVldPrdOrdPrd").datepicker({
	  	format: 'dd-mm-yyyy',
	  	autoclose: true
	});//datepicker
	$('[data-toggle="tooltip"]').tooltip();
	$(".inputAreaPrdOrdPrd,.inputPesoPrdOrdPrd").number(true,2);
	mostrarProductos(contAgrPrd,'');
	mostrarUnidadMedida(contAgrPrd,'');
	listarProductos();
	contNumLnaPrd++;
	contAgrPrd++;
});//click btnAgregarPrdOrdProd
/*=============================================
MOSTRAR PRODUCTOS
=============================================*/
function mostrarProductos(contAgrPrd,codProducto){
	$.ajax({
	    url: "ajax/productos.ajax.php",
	    method: "POST",
	    data: "accionProducto="+"listar"+"&entrada="+"inputSelect",
	    dataType: "json",
	    success: function(respuesta){
	    	var selectProducto = $("#filaPrdOrdPrd_"+contAgrPrd).children("select.selectPrdOrdPrd");
	    	selectProducto.children().remove();

	    	if(respuesta.length > 0){
	    		selectProducto.append('<option value="" selected>Seleccione un producto</option>');
	    		var selected = '';
	    		$.each(respuesta, function(key,value){
	    			selected = (value["cod_producto"] == codProducto) ? 'selected' : '';
	        		selectProducto.append(
	          			'<option value="'+value.cod_producto+'" '+selected+'>'+value.dsc_producto+'</option>'
	        		);
	        	});//each
	        	selectProducto.select2();
	        	listarProductos();
	    	}//if
	    }//success
	});//ajax
}//function mostrarProductos
/*=============================================
MOSTRAR UNIDAD DE MEDIDAS
=============================================*/
function mostrarUnidadMedida(contAgrPrd,codUndMedida){
	$.ajax({
	    url: "ajax/unidadMedida.ajax.php",
	    method: "POST",
	    data: "accionUnidadMedida="+"mostrar"+"&entrada="+"inputSelect",
	    dataType: "json",
	    success: function(respuesta){
	    	var selectUnidadMedida = $("#filaUndMdaOrdPrd_"+contAgrPrd).children("select.selectUndMdaOrdPrd");
	    	selectUnidadMedida.children().remove();
	    	if(respuesta.length > 0){
	    		var selected = '';
	    		selectUnidadMedida.append('<option value="" selected>Seleccione</option>');
	    		$.each(respuesta, function(key,value){
	    			selected = (value["cod_unidad"] == codUndMedida) ? 'selected' : '';
	        		selectUnidadMedida.append(
	          			'<option value="'+value.cod_unidad+'" '+selected+'>'+value.dsc_simbolo+'</option>'
	        		);
	        	});//each
	        	selectUnidadMedida.select2();
	        	listarProductos();
	    	}
	    }//success
	});//ajax
}//function mostrarUnidadMedida
/*=============================================
SELECCIONAR UN PRODUCTO
=============================================*/
$("#formOrdenProduccion").on("change","select.selectPrdOrdPrd",function(){
	$(this).parent().parent().children("input.inputCodPrdOrdPrd").val($(this).val());
	listarProductos();
});//change selectPrdOrdPrd
/*=============================================
SELECCIONAR UNA FECHA DE ENTREGA
=============================================*/
$("#tablaPrdOrdProd").on("change","input.inputFchEtgPrdOrdPrd",function(){
	listarProductos();
});//change tablaPrdOrdProd
/*=============================================
SELECCIONAR UNA FECHA VALIDADA
=============================================*/
$("#tablaPrdOrdProd").on("change","input.inputFchVldPrdOrdPrd",function(){
	listarProductos();
});//change tablaPrdOrdProd
/*=============================================
MARCAR CHECK FECHA VALIDADA
=============================================*/
$("#tablaPrdOrdProd").on("change","input.inputChkFchValidadaPrdOrdPrd",function(){
	var inputFchValidada = $(this).parent().children('div').children('.inputFchVldPrdOrdPrd');
	console.log("inputFchValidada", inputFchValidada);
	if($(this).is(':checked')) {
		$(this).val('SI');
		$(inputFchValidada).css("color","#0000ff");
	}else{
		$(this).val('NO');
		$(inputFchValidada).css("color","#ff0000");
	}
	listarProductos();
});//change tablaPrdOrdProd
/*=============================================
DIGITAR UN AREA
=============================================*/
$("#tablaPrdOrdProd").on("change","input.inputAreaPrdOrdPrd",function(){
	listarProductos();
});//change inputAreaPrdOrdPrd
/*=============================================
DIGITAR UN PESO
=============================================*/
$("#tablaPrdOrdProd").on("change","input.inputPesoPrdOrdPrd",function(){
	listarProductos();
});//change inputPesoPrdOrdPrd
/*=============================================
DIGITAR UNA CANTIDAD
=============================================*/
$("#tablaPrdOrdProd").on("change","input.inputCtd2PrdOrdPrd",function(){
	$(this).parent().parent().children("td.inputCtdPrdOrdPrd").append($(this).val());
	listarProductos();
});//change inputCtdPrdOrdPrd
/*=============================================
SELECCIONAR UNA UNIDAD DE MEDIDA
=============================================*/
$("#formOrdenProduccion").on("change","select.selectUndMdaOrdPrd",function(){
	$(this).parent().parent().children("input.inputCodUndMdaPrdOrdPrd").val($(this).val());
	listarProductos();
});//change selectUndMdaOrdPrd
/*=============================================
IMPRESION SIMPLIFICADA
=============================================*/
$("#tablaPrdOrdProd").on("click", ".btnImprimirCotizacionSpl", function(){
  var codigoCotizacion = $(this).attr("codCotizacion");
  //Solicito a windows que me abra una nueva ventana haciendo la ruta donde esta tcpdf
  window.open("extensions/tcpdf/pdf/cotizacion-simplificada.php?codigo="+codigoCotizacion, "_blank");
});//Click btnImprimirCotizacionSpl
/*=============================================
VER DATOS ADJUNTOS
=============================================*/
$("#tablaPrdOrdProd").on("click","button.btnDatosAdjuntosCtz", function(){
	$("#listaDatosAdjuntosCtz").html('')
	$.ajax({
		url:"ajax/cotizacion.ajax.php",
	  	method: "POST",
	  	dataType: 'json',
	  	data: {'codigoCotizacion':$(this).attr("codCotizacion"),'accionCotizacion':'mostrarDatosAdjuntos'},
	  	success: function(respuesta){
	  		if(respuesta.length > 0){
	  			$.each(respuesta,function(index,value){
		  			$("#listaDatosAdjuntosCtz").append(
		  				'<a class="btn btn-primary btn-sm btn-agregar-kq" href="archivos/cotizacion/'+escapeHtml(value["dsc_ruta_archivo"])+'" target="_blank" style="margin-bottom:4px;">'+value["dsc_archivo"]+'</a>&nbsp;&nbsp;&nbsp;'
		  			);
		  		});//each
	  		}else{
	  			$("#listaDatosAdjuntosCtz").append('<span>No tiene archivos adjuntos</span>');
	  		}
	  	}//success
	});	//ajax
});//click btnDatosAdjuntosCtz
/*=============================================
REMOVER FILA DE PRODUCTOS
=============================================*/
$("#tablaPrdOrdProd").on("click","button.removerFilaPrdOrdPrd", function(){
	$(this).parent().parent().remove();
	var numLinea = $(".inputNumLnaPrdOrdPrd");
	for (var i = 0; i < numLinea.length; i++) {
		$(numLinea[i]).html(parseInt(i)+1);
		contNumLnaPrd = parseInt(i)+2;
	}
	if(numLinea.length == 0){
		contNumLnaPrd = 1;	
	}
	listarProductos();
});//click removerFilaPrdOrdPrd
/*=============================================
LISTAR PRODUCTOS
=============================================*/
function listarProductos(){
	var listaProductos = [];
	var numLinea = $(".inputNumLnaPrdOrdPrd");
	var cotizacion = $(".inputCodCtzPrdOrdPrd");
	var fchEntrega = $(".inputFchEtgPrdOrdPrd");
	var area = $(".inputAreaPrdOrdPrd");
	var peso = $(".inputPesoPrdOrdPrd");
	var producto = $(".inputCodPrdOrdPrd");
	var cantidad = $(".inputCtdPrdOrdPrd");
	var unidadMedida = $(".inputCodUndMdaPrdOrdPrd");
	var fchValidada = $(".inputFchVldPrdOrdPrd");
	var fchEntregaOriginal = $(".inputFchEtgPrdOrdPrdOriginal");
	var fchValidadaOriginal = $(".inputFchVldPrdOrdPrdOriginal");
	var chkFchValidada = $(".inputChkFchValidadaPrdOrdPrd");
	var chkFchValidadaOriginal = $(".inputChkValidPrdOrdPrdOriginal");
	var areaOriginal = $(".inputAreaPrdOrdPrdOriginal");
	var pesoOriginal = $(".inputPesoPrdOrdPrdOriginal");
	var flgFchVldMdf = $(".inputFlgChkVldModfPrdOrdPrd");
	for (var i = 0; i < numLinea.length; i++) {
		listaProductos.push({"num_linea" : $(numLinea[i]).html(),
							 "cod_cotizacion" : $(cotizacion[i]).html(),
							 "fch_entrega" : $(fchEntrega[i]).val(),
							 "imp_area" : $(area[i]).val(),
							 "imp_peso" : $(peso[i]).val(),
							 "cod_producto" : $(producto[i]).val(),
							 "cod_unidad" : $(unidadMedida[i]).val(),
							 "ctd_orden" : $(cantidad[i]).html(),
							 "fch_validada" : $(fchValidada[i]).val(),
							 "fch_entrega_original" : $(fchEntregaOriginal[i]).val(),
							 "fch_validada_original" : $(fchValidadaOriginal[i]).val(),
							 "imp_area_original" : $(areaOriginal[i]).val(),
							 "imp_peso_original" : $(pesoOriginal[i]).val(),
							 "flg_fch_validada" : $(chkFchValidada[i]).val(),
							 "flg_fch_validada_original" : $(chkFchValidadaOriginal[i]).val(),
							 "flg_fch_validada_modificado" : $(flgFchVldMdf[i]).val()
		});
    }//for
    $("#listaProductosOrdPrd").val(JSON.stringify(listaProductos));
}//function listarProductos
/*=============================================
ACTUALIZAR FECHA VALIDADA TODO EL DETALLE DE PRODUCTOS
=============================================*/
$("#fchValidadaOrdPrd").change(function(){
	//console.log('fecha',$(this).val());
});
/*=============================================
FIN TAB PRODUCTOS O SERVICIOS
=============================================*/
/*=============================================
INICIO TAB AREAS
=============================================*/
//CARGAR AREAS
var listaAreasOrig = [];
$.ajax({
	url:"ajax/ordenProduccion.ajax.php",
  	method: "POST",
  	dataType: 'json',
  	data: {'localidad':codLocalidad,'ordenProduccion':numOrdenProd,'entrada':'listadoAreas','accionOrdenProduccion':'consultar'},
  	success: function(respuesta){
  		console.log("respuesta", respuesta);
  		$.each(respuesta,function(index,value){
  			listaAreasOrig.push({"cod_area" : value["cod_area"],
							 	 "flg_area" : value["flg_area"],
							 	 "flg_facturacion" : value["flg_facturacion"]
			});
  		});//each
  		$("#listaAreasOrigOrdPrd").val(JSON.stringify(listaAreasOrig));
  	}//success
});//ajax
function mostrarTablaAreas(){
	$("#tablaAreaOrdProd").DataTable().destroy();
	/*=============================================
	GENERO EL DATATABLE DE LA TABLA AREAS
	=============================================*/
	$("#tablaAreaOrdProd").DataTable({
		"ajax": "ajax/datatable-area.ajax.php?entrada=vtnOrdenProduccion&localidad="+codLocalidad+'&numOrdenProd='+numOrdenProd+'&flgAnulado='+flgEstadoOrigAnul,
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
	  	'columnDefs': [
			{
				targets: [0],
				className: "text-center tblAreaOrdProdWidthCorl"
			},
			{
				targets: [1],
				className: "tblAreaOrdProdWidthDsc"
			},
			{
				targets: [2],
				className: "text-center tblAreaOrdProdWidthChk"
			}
		]
	});//DataTable tablaAreaOrdProd
};//function mostrarTablaAreas
$("#tablaAreaOrdProd").on("click","input.checkAreaOrdPrd",function(){
	if($(this).is(':checked')) {
		$(this).val('SI');
	}else{
		$(this).val('NO');
	}
	listarAreas();
});//click tablaAreaOrdProd
//CHECK TOTAL AREA, SELECCIONAR TODAS LAS FILAS
var listaAreas = [];
function listarAreas(){	
	listaAreas = [];
	var checkArea = $(".checkAreaOrdPrd");
	for (var i = 0; i < checkArea.length; i++) {
		listaAreas.push({"cod_area" : $(checkArea[i]).attr("codArea"),
						 "cod_estado" : $(checkArea[i]).attr("codEstado"),
						 "flg_area" : $(checkArea[i]).val()
		});
	}//for
	$("#listaAreasOrdPrd").val(JSON.stringify(listaAreas));
}//function listarAreas
//CHECK TOTAL AREA, SELECCIONAR TODAS LAS FILAS
$("#chkTotalAreaOrdProd").click(function(){
	if($(this).is(':checked')){
		$(".checkAreaOrdPrd").prop("checked",true);
		$(".checkAreaOrdPrd").val("SI");
	}else{
		$(".checkAreaOrdPrd").prop("checked",false);
		$(".checkAreaOrdPrd").val("NO");
	}
	listarAreas();
});//click chkTotalAreaOrdProd
/*=============================================
FIN TAB AREAS
=============================================*/
/*=============================================
INICIO TAB DOCUMENTOS
=============================================*/
function mostrarTablaDocumentos(){
	console.log('Tab Documentos');
	$("#tablaDocumentoOrdProd").DataTable().destroy();
	/*=============================================
	GENERO EL DATATABLE DE LA TABLA AREAS
	=============================================*/
	$("#tablaDocumentoOrdProd").DataTable({
		"ajax": "ajax/datatable-documento.ajax.php?entrada=vtnOrdenProduccion&localidad="+codLocalidad+'&numOrdenProd='+numOrdenProd+'&flgAnulado='+flgEstadoOrigAnul,
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
	  	'columnDefs': [
			{
				targets: [0],
				className: "text-center tblDctoOrdProdWidthCorl"
			},
			{
				targets: [1],
				className: "tblDctoOrdProdWidthDsc"
			},
			{
				targets: [2],
				className: "text-center tblDctoOrdProdWidthChk"
			},
			{
				targets: [3],
				className: "text-center tblDocOrdProdWidtBtn"
			},
			{
				targets: [4],
				className: "hidden"
			}	
		]
	});//DataTable tablaAreaOrdProd
	setTimeout(function(){ 
		console.log('a2');
		if(codLocalidad == ''){
			$(".tblDocOrdProdWidtBtn").addClass("hidden");
		}else{
			$(".tblDocOrdProdWidtBtn").removeClass("hidden");
		}
		listarDocumentos();
	}, 1000);
}//function mostrarTablaDocumentos
//CHECK TOTAL AREA, SELECCIONAR TODAS LAS FILAS
$("#chkTotalDocumentoOrdProd").click(function(){
	if($(this).is(':checked')){
		$(".checkDocumentoOrdPrd").prop("checked",true);
		$(".checkDocumentoOrdPrd").val("SI");
	}else{
		$(".checkDocumentoOrdPrd").prop("checked",false);
		$(".checkDocumentoOrdPrd").val("NO");
	}
	listarDocumentos();
});//click chkTotalAreaOrdProd
$("#tablaDocumentoOrdProd").on("click","input.checkDocumentoOrdPrd",function(){
	if($(this).is(':checked')) {
		$(this).val('SI');
		$(this).parent().parent().children().children().children(".btnVerUsrDocOrdProd").prop("disabled",false);
	}else{
		$(this).val('NO');
		$(this).parent().parent().children("td.tblDocOrdProdWidtBtn").children().children("button.btnVerUsrDocOrdProd").prop("disabled",true);
	}
	listarDocumentos();
});//click tablaAreaOrdProd
var contListDoc = 1;
function listarDocumentos(){
	console.log('Listar Documentos');
	console.log("contListDoc", contListDoc);
	var listaDocumentos = [];
	var checkDocumento = $(".checkDocumentoOrdPrd");
	var checkDocumentoOrg = $(".checkDocumentoOrgOrdPrd");
	console.log('length',checkDocumento.length);
	for (var i = 0; i < checkDocumento.length; i++) {
		listaDocumentos.push({"cod_documento" : $(checkDocumento[i]).attr("codDocumento"),
							  "num_linea" : $(checkDocumento[i]).attr("numLinea"),
						 	  "flg_documento" : $(checkDocumento[i]).val(),
						 	  "flg_documento_orginal" : $(checkDocumentoOrg[i]).val(),
		});
	}//for
	$("#listaDocumentosOrdPrd").val(JSON.stringify(listaDocumentos));
	if(contListDoc == 1){
		$("#listaDocumentosOrginOrdPrd").val(JSON.stringify(listaDocumentos));
	}
	contListDoc++;
}//function listarDocumentos
/*=============================================
MOSTRAR LAS TABLAS DE LOS 3 TABS
=============================================*/
mostrarTablaProductos();
mostrarTablaAreas();
mostrarTablaDocumentos();
mostrarTablaObservaciones();
var listaUsuarioDoc = [];
/*=============================================
RECUPERAR DATOS AL ABRIR EL POPUP DE USUARIOS
=============================================*/
$("#tablaDocumentoOrdProd").on("click", ".btnVerUsrDocOrdProd", function(){
	listaUsuarioDoc = [];
	var numLineaDoc = $(this).attr("numLinea") || 0;
	$("#localidadUsrDocOrdProd").val($(this).attr("codLocalidad"));
	$("#numOrdUsrDocOrdProd").val($(this).attr("numOrdenProduccion"));
	$("#numLnOrdUsrDocOrdProd").val($(this).attr("numLinea"));
		//mostrarTablaUsuarioDoc($(this).attr("codLocalidad"),$(this).attr("numOrdenProduccion"),$(this).attr("numLinea"));
		mostrarTablaUsuarioDoc(codLocalidad,numOrdenProd,numLineaDoc);
		//mostrarUsuarioRelDoc($(this).attr("codLocalidad"),$(this).attr("numOrdenProduccion"),$(this).attr("numLinea"));
		mostrarUsuarioRelDoc(codLocalidad,numOrdenProd,numLineaDoc);
});//click btnVerUsrDocOrdProd
/*=============================================
GENERO EL DATATABLE DE USUARIOS
=============================================*/
function mostrarTablaUsuarioDoc(codLocalidad,numOrdenProduccion,numLineaDocumento){
	$("#tablaUsuarioDocOrdProd").DataTable().destroy();
	$("#tablaUsuarioDocOrdProd").DataTable({
		"ajax": "ajax/datatable-directorio.ajax.php?entrada=vtnOrdenProduccion&localidad="+codLocalidad+"&numOrdenProd="+numOrdenProduccion+"&numLineaDoc="+numLineaDocumento+'&flgAnulado='+flgEstadoOrigAnul,			
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
	  	'columnDefs': [
			{
				targets: [0],
				className: "tblUsrDctoOrdProdWidthNmb"
			},
			{
				targets: [1],
				className: "text-center tblUsrDctoOrdProdWidthChk"
			}
		]
	});//DataTable
}//function mostrarTablaUsuarioDoc
function mostrarUsuarioRelDoc(codLocalidad,numOrdenProduccion,numLineaDocumento){
	$.ajax({
		url:"ajax/ordenProduccion.ajax.php",
	  	method: "POST",
	  	dataType: 'json',
	  	data: {'codLocalidad':codLocalidad,'numOrdProd':numOrdenProd,'numLinea':numLineaDocumento,'entrada':'usuarioDocRelacOrdProd','accionOrdenProduccion':'mostrar'},
	  	success: function(respuesta){
	  		$.each(respuesta,function(index,value){
	  			listaUsuarioDoc.push({"cod_usuario":value["cod_usuario"]});
	  		});//each
	  		$("#listaUsuariosDocOrdPrd").val(JSON.stringify(listaUsuarioDoc));
	  	}//success
	});	//ajax
}//function mostrarUsuarioRelDoc

/*=============================================
SELECCIONAR CADA USUARIO
=============================================*/
$("#tablaUsuarioDocOrdProd").on("click","input.checkUsrDocOrdPrd",function(){
	var codTrabajador = $(this).attr("codTrabajador");
	if($(this).is(':checked')) {
		$(this).val('SI');
		listarUsuarios(codTrabajador,'SI');
	}else{
		$(this).val('NO');
		listarUsuarios(codTrabajador,'NO');
	}	
});//click tablaAreaOrdProd
/*=============================================
LISTAR USUARIOS
=============================================*/
function listarUsuarios(codTrabajador,valorCheck){
	if(valorCheck == "NO"){		
		var index = listaUsuarioDoc.findIndex(function(item, i){
		  	return item.cod_usuario === codTrabajador;
		});
		listaUsuarioDoc.splice(index,1);
	}else{
		listaUsuarioDoc.push({"cod_usuario":codTrabajador});
	}
	$("#listaUsuariosDocOrdPrd").val(JSON.stringify(listaUsuarioDoc));
}//function listarUsuarios
/*=============================================
ENVIAR FORMULARIO USUARIO DOCUMENTOS
=============================================*/
$("#formUsuarioDocOrdProd").submit(function(e){
	e.preventDefault();
	swal({
	    title: '¿Está seguro de vincular estos usuarios?',
	    text: "¡Si no lo está puede cancelar la acción!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, guardar!'
    }).then(function(result){
    	if(result.value){
    		$.ajax({
				url:"ajax/ordenProduccion.ajax.php",
		      	method: "POST",
		      	data: $("#formUsuarioDocOrdProd").serialize(),
		      	success:function(respuesta){
		      		if(respuesta == "ok"){
		      			swal({
					  		type: "success",
					  		title: "El usuario ha sido guardado correctamente",
					  		showConfirmButton: true,
							confirmButtonText: "Cerrar",
							onAfterClose: () => $("#modalUsuarioDocOrdProd [data-dismiss=modal]").trigger("click")
						});
		      		}else{
		      			swal({
		                    type: "error",
		                    title: "Ha ocurrido un problema al guardar el usuario, por favor vuelva a intentarlo.",
		                    showConfirmButton: true,
		                	confirmButtonText: "Cerrar",
							onAfterClose: () => $("#modalUsuarioDocOrdProd [data-dismiss=modal]").trigger("click")
		                });
		      		}
		      	}//success
		    });//ajax
    	}//if
    });//then
});//submit formUsuarioDocOrdProd
/*=============================================
ENVIAR FORMULARIO
=============================================*/
var listaAreaEliminar = listaAreaInsertar = [];
$("#formOrdenProduccion").submit(function(e){
	listarProductos();
	listaAreas = [];
	listarAreas();	
	contListDoc = 1;
	listarDocumentos();
	e.preventDefault();	
	var areasDiferentes = areasNuevas = 'NO';
	var areasEliminar = areasInsertar = '';
	//OBTENER LAS AREAS QUE SE VAN A ELIMINAR
	$.each(listaAreasOrig,function(index,value){
		areasDiferentes = 'NO';
		$.each(listaAreas,function(index2,value2){
			if(value["cod_area"] == value2["cod_area"] && value["flg_area"] == value2["flg_area"]){
				areasDiferentes = 'SI';
			}
		});
		if(areasDiferentes == 'NO'){
			//areasEliminar += value["cod_area"]+',';
  			listaAreaEliminar.push({"cod_area" : value["cod_area"],
							 	 	"flg_facturacion" : value["flg_facturacion"]
			});
  			$("#listaAreasEliminarOrdPrd").val(JSON.stringify(listaAreaEliminar));
		}
	});
	//OBTENER LAS AREAS QUE SE VAN A INSERTAR
	$.each(listaAreas,function(index,value){
		areasNuevas = 'NO';
		$.each(listaAreasOrig,function(index2,value2){
			if(value["cod_area"] == value2["cod_area"] && value["flg_area"] == value2["flg_area"]){
				areasNuevas = 'SI';
			}
		});//each
		if(areasNuevas == 'NO' && value["flg_area"] == 'SI'){
			listaAreaInsertar.push({"cod_area" : value["cod_area"],
							 	 	"cod_estado" : value["cod_estado"]
			});
  			$("#listaAreasInsertarOrdPrd").val(JSON.stringify(listaAreaInsertar));
		}
	});//each
	console.log("flgEstadoAnu", flgEstadoAnu);
	var mensajeForm = (flgEstadoAnu == 'SI') ? '¿Está seguro que sedea anular la OP? Recuerde que este proceso no tinene retorno, es definitivo' : '¿Está seguro de guardar?';;
	swal({
	    title: mensajeForm,
	    text: "¡Si no lo está puede cancelar la acción!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, guardar!'
    }).then(function(result){
    	if(result.value){
    		$("#formOrdenProduccion .inputDisabled").prop("disabled",false);
    		Pace.track(function(){
		      	cargaGifDivForm("formOrdenProduccion","");
	    		$.ajax({
					url:"ajax/ordenProduccion.ajax.php",
			      	method: "POST",
			      	data: $("#formOrdenProduccion").serialize(),
			      	success:function(respuesta){
			      		console.log("respuesta", respuesta);
			      		if(respuesta == 'ok'){
				        	swal({
						  		type: "success",
						  		title: "Los datos han sido guardado correctamente",
						  		showConfirmButton: true,
								confirmButtonText: "Cerrar"
						  	}).then(function(result){
						  		window.location = "ordenes-produccion";			  		
						  	});
				        }else{
			      			swal({
			                    type: "error",
			                    title: "Ha ocurrido un problema al guardar los datos, por favor vuelva a intentarlo.",
			                    showConfirmButton: true,
			                	confirmButtonText: "Cerrar"
			                }).then(function(result){
						  		window.location = "ordenes-produccion";
						  	});
						}
			      	}//success
			    });//ajax
			});//Pace.track
    	}//if
    });//then
});//submit formOrdenProduccion
$("#cancelarOrdPrd").click(function(){
	window.location = "ordenes-produccion";
});
/*=============================================
INICIO TAB OBSERVACIONES
=============================================*/
function mostrarTablaObservaciones(){
	$("#tablaObservacionOrdProd").DataTable().destroy();
	var listaColumObservaciones = [ 
	  	{"targets": 0,"className": "text-center tblObsOrdProdWidthCorl"},
	  	{"targets": 1,"className": "text-left tblObsOrdProdWidthObs"},
	  	{"targets": 2,"className": "text-left tblObsOrdProdWidthUsr"},
	  	{"targets": 3,"className": "text-center tblObsOrdProdWidthFchRgs"},
	  	{"targets": 4,"className": "text-center tblObsOrdProdWidthAtm"}
	];
	if(flgEstadoOrigAnul == 'NO'){
		listaColumObservaciones.push({ "targets": 5, "className": "text-center tblObsOrdProdWidthAcn" });
	}
	/*=============================================
	GENERO EL DATATABLE DE LA TABLA OBSERVACIONES
	=============================================*/
	datatableObservacion = $("#tablaObservacionOrdProd").DataTable({
		"ajax": "ajax/datatable-ordenProduccion.ajax.php?entrada=tabObservaciones&localidad="+codLocalidad+'&numOrdenProd='+numOrdenProd+'&flgAnulado='+flgEstadoOrigAnul,
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
	  	'columnDefs': listaColumObservaciones
	});
}//function mostrarTablaObservaciones
$("#btnAgregarObsOrdProd").click(function(){
	$("#localidadObsOrdProd").val(codLocalidad);
	$("#numOrdObsOrdProd").val(numOrdenProd);
	$("#numLnObsOrdProd,#descripcionObsOrdPrd").val('');
	$("#accionOrdenProduccion").val('crear');
});//click btnAgregarObsOrdProd
/*=============================================
EDITAR OBSERVACION
=============================================*/
$("#tablaObservacionOrdProd").on("click", ".btnEditarObservacion", function(){
  $("#accionOrdenProduccion").val("editar");
  $("#localidadObsOrdProd").val($(this).attr("localidad"));
  $("#numOrdObsOrdProd").val($(this).attr("ordenProduccion"));
  $("#numLnObsOrdProd").val($(this).attr("numLinea"));
  var codTrabajador = $(this).attr("codTrabajador");
  var datos = new FormData();
  datos.append("codLocalidad",$(this).attr("localidad"));
  datos.append("numOrdProd",$(this).attr("ordenProduccion"));
  datos.append("numLinea",$(this).attr("numLinea"));
  datos.append("accionOrdenProduccion","mostrar");
  datos.append("entrada","modalObservacion");
  $.ajax({
    url:"ajax/ordenProduccion.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){
      $("#descripcionObsOrdPrd").val(respuesta["dsc_observacion"]);
    }//success
  });//ajax
});//click btnEditarObservacion
/*=============================================
ELIMINAR OBSERVACION
=============================================*/
$("#tablaObservacionOrdProd").on("click", ".btnEliminarObservacion", function(){
	var codLocalidad = $(this).attr("localidad");
	var ordenProduccion = $(this).attr("ordenProduccion");
	var numLinea = $(this).attr("numLinea");
  	swal({
	    title: '¿Está seguro de borrar?',
	    text: "¡Si no lo está puede cancelar la acción!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, borrar el contacto!'
  	}).then(function(result){
	    if (result.value) {
	    	$.ajax({
		        url:"ajax/ordenProduccion.ajax.php",
		        method: "POST",
		        data: "accionOrdenProduccion=eliminar&entrada=observacion&localidad="+codLocalidad+"&ordenProduccion="+ordenProduccion+"&numLinea="+numLinea,
		        success:function(respuesta){
		        	if(respuesta == "ok"){
		      			swal({
					  		type: "success",
					  		title: "La observación ha sido eliminada correctamente",
					  		showConfirmButton: true,
							confirmButtonText: "Cerrar"
					  	}).then(function(result){
					  		$("#modalObservacionOrdPrd [data-dismiss=modal]").trigger("click");
					  		datatableObservacion.ajax.url('ajax/datatable-ordenProduccion.ajax.php?entrada=tabObservaciones&localidad='+codLocalidad+'&numOrdenProd='+numOrdenProd).load();
					  	});
		      		}else{
		      			swal({
					  		type: "warning",
					  		title: "Ha ocurrido un problema al eliminar, por favor vuelva a intentralo",
					  		showConfirmButton: true,
							confirmButtonText: "Cerrar"
					  	}).then(function(result){
					  		$("#modalObservacionOrdPrd [data-dismiss=modal]").trigger("click");
					  		datatableObservacion.ajax.url('ajax/datatable-ordenProduccion.ajax.php?entrada=tabObservaciones&localidad='+codLocalidad+'&numOrdenProd='+numOrdenProd).load();
					  	});
		      		}
		        }//success
		    });//ajax
		}//if
	});//then
});//click btnEliminarObservacion
/*=============================================
GUARDAR OBSERVACION
=============================================*/
$("#formObservacionOrdPrd").submit(function(e){
	e.preventDefault();
	swal({
	    title: '¿Está seguro de guardar?',
	    text: "¡Si no lo está puede cancelar la acción!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, guardar!'
    }).then(function(result){
    	if(result.value){
    		$.ajax({
				url:"ajax/ordenProduccion.ajax.php",
		      	method: "POST",
		      	data: $("#formObservacionOrdPrd").serialize(),
		      	success:function(respuesta){
		      		if(respuesta == "ok"){
		      			swal({
					  		type: "success",
					  		title: "La observación ha sido guardada correctamente",
					  		showConfirmButton: true,
							confirmButtonText: "Cerrar"
					  	}).then(function(result){
					  		$("#modalObservacionOrdPrd [data-dismiss=modal]").trigger("click");
					  		datatableObservacion.ajax.url('ajax/datatable-ordenProduccion.ajax.php?entrada=tabObservaciones&localidad='+codLocalidad+'&numOrdenProd='+numOrdenProd).load();
					  	});
		      		}
		      	}
		    });//ajax
		}
    });
});//submit formObservacionOrdPrd
/*=============================================
BOTON DESCARGAR EXCEL DETALLE PRODUCTOS
=============================================*/
$("#btnDescargarExcelDetOrdPrd").click(function(){
	window.open("views/modules/descargar-reporte.php?reporte=reporteOrdenProduccionDetalle&entrada=vtnOrdenProduccionExcelDetalle&localidad="+codLocalidad+"&ordenProduccion="+numOrdenProd,"_blank");
});//click btnDescargarExcelDetOrdPrd
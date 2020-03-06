$("#totalDescuentoCotizacion").number(true,2);
//$('<tr style="background-color:#fff; color:#444;"><th></th><th></th><th class="filtroCotizacion">Cliente</th><th></th><th></th><th style="width: 51px;"></th><th></th><th></th><th style="width: 130px;"></th><th></th><th class="hidden"></th></tr>').appendTo( '#tablaListaCotizacion thead');
/*$('#tablaListaCotizacion thead tr:eq(1) .filtroCotizacion').each( function (i) {   
    var title = $(this).text();
    var cont = 0;
    if(title == 'Cliente'){
      cont = 2;
    }
    $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    $( 'input', this ).on( 'keyup change', function () {
        if ( table.column(cont).search() !== this.value ) {
            table
                .column(cont)
                .search( this.value )
                .draw();
        }
    });
});*///tablaListaCotizacion each
if($("#accionCotizacion").val() == "listar"){
  $("#emailCopia").email_multiple();
  $("#tablaListaCotizacion").one("preInit.dt", function () {
    $button = $("<label style=\"margin-left: 10px;\">Buscar Producto: <input type='search' class='form-control input-sm' placeholder='' aria-controls='tablaListaCotizacion' id='filtroProductoCotizacion'></label>");
    $("#tablaListaCotizacion_filter").append($button);
  });
  var start = moment().startOf('month');
  var end = moment().endOf('month');
  $("#filtroFInicialCotizacion").val(start.format('YYYY-MM-D'));
  $("#filtroFFinalCotizacion").val(end.format('YYYY-MM-D'));
  var table = $('#tablaListaCotizacion').DataTable( {
    "ajax": 'ajax/datatable-cotizacion.ajax.php?fechaInicial='+$("#filtroFInicialCotizacion").val()+'&fechaFinal='+$("#filtroFFinalCotizacion").val()+'&entrada=datatablePrincipal',
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
      "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": [0,1,2,3,4,5,6,7],
        "className":"vertical-middle-kq"
      },
      {
        "targets": 4,
        "className":"vertical-middle-kq text-right"
      },
      {
        "targets": 8,
        "className":"vertical-middle-kq text-center columnaAcciones"
      },
      {
        "targets": 9,
        "className":"details-control"
      },
      {
        "targets": [10,11],
        "className":"hidden"
      }
    ],
    rowCallback: function(row, data, index){
      $('td',row).css('color', data[11]);
    }    
  });//DataTable 
  var datosFiltroProducto = new FormData();
  datosFiltroProducto.append("accionProducto","listar");
  datosFiltroProducto.append("entrada","filtroCotizacion");
  var arrayFiltroProducto = [];
  $.ajax({
    url: 'ajax/productos.ajax.php',
    method: "POST",
    data: datosFiltroProducto,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      $.each(respuesta,function(index,value){
        arrayFiltroProducto.push(value["dsc_producto"]);
      });    
    }
  });
  setTimeout(function(){
    $("#filtroProductoCotizacion").autocomplete({
      source: arrayFiltroProducto 
    }).change(function (event, ui){
      table.ajax.url('ajax/datatable-cotizacion.ajax.php?&producto='+this.value+'&fechaInicial='+$("#filtroFInicialCotizacion").val()+'&fechaFinal='+$("#filtroFFinalCotizacion").val()+'&entrada=datatablePrincipal').load(); 
    });
  },1000)  
  /*=============================================
  RANGO DE FECHAS
  =============================================*/
  function cb(start, end) {
    $('#daterange-btn-cotizacion span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }
  $('#daterange-btn-cotizacion').daterangepicker(
    {
      ranges   : {
        'Hoy'       : [moment(), moment()],
        'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
        'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment(),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn-cotizacion span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      //Captura el inicio de la fecha y lo cambio de formato por el formato de la BD
      var fechaInicial = start.format('YYYY-MM-D');
      var fechaFinal = end.format('YYYY-MM-D');
      $("#filtroFInicialCotizacion").val(fechaInicial);
      $("#filtroFFinalCotizacion").val(fechaFinal);
      table.ajax.url('ajax/datatable-cotizacion.ajax.php?producto='+$("#filtroProductoCotizacion").val()+'&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal+'&entrada=datatablePrincipal').load();
    }
  )//daterangepicker
  cb(start, end);
  /*=============================================
  CANCELAR RANGO DE FECHAS
  =============================================*/
  $(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){
    $('#daterange-btn-cotizacion span').html('<i class="fa fa-calendar"></i>  <span class="textRango">Rango de fecha</span>');
    $("#filtroFInicialCotizacion").val('');
    $("#filtroFFinalCotizacion").val('');
    table.ajax.url('ajax/datatable-cotizacion.ajax.php?producto='+$("#filtroProductoCotizacion").val()+'&entrada=datatablePrincipal').load();
  });//click .cancelBtn
  /*=============================================
  CAPTURAR HOY
  =============================================*/
  $(".daterangepicker.opensleft .ranges li").on("click", function(){
    var textoHoy = $(this).attr("data-range-key");
    var textoHoy2 = $(".textRango").html();
    if(textoHoy == "Hoy"){
      if(textoHoy2 == 'Rango de fecha'){
        var d = new Date();          
        var dia = d.getDate();
        var mes = d.getMonth()+1;
        var año = d.getFullYear();
        if(mes < 10){
          var fechaInicial = año+"-0"+mes+"-"+dia;
          var fechaFinal = año+"-0"+mes+"-"+dia;
        }else if(dia < 10){
          var fechaInicial = año+"-"+mes+"-0"+dia;
          var fechaFinal = año+"-"+mes+"-0"+dia;
        }else if(mes < 10 && dia < 10){
          var fechaInicial = año+"-0"+mes+"-0"+dia;
          var fechaFinal = año+"-0"+mes+"-0"+dia;
        }else{
          var fechaInicial = año+"-"+mes+"-"+dia;
          var fechaFinal = año+"-"+mes+"-"+dia;
        }
        $("#filtroFInicialCotizacion").val(fechaInicial);
        $("#filtroFFinalCotizacion").val(fechaFinal);
        table.ajax.url('ajax/datatable-cotizacion.ajax.php?producto='+$("#filtroProductoCotizacion").val()+'&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal+'&entrada=datatablePrincipal').load();
      }//if
    }//if
  })//click daterangepicker
  function format (d) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>'+d[10]+'</td>'+
        '</tr>'+
    '</table>';
  }//function format
  $('#tablaListaCotizacion tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }else {
      // Open this row
      row.child( format(row.data()) ).show();
      tr.addClass('shown');
    }
  });//click details-control
}//if listar
var contDet = 0;
var contFinal = 0;
var disabledGen = ($("#flgApbEstCtz").val() == 'SI') ? 'disabled' : '';
if($("#codClienteCotizacion").length && $("#codClienteCotizacion").val()){
  var datosCotDet = new FormData();
  datosCotDet.append("codCotizacion",$("#codigoCotizacionOriginal").val());
  var listaProductosOriginal = [];
  var checked = "";
  $.ajax({
    url: "ajax/cotizacion.ajax.php",
    method: "POST",
    data: datosCotDet,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      $.each(respuesta,function(index,value){
        contFinal++;
        listaProductosOriginal.push({"num_linea" : (index+1),
                                     "cod_producto" : value["cod_producto"],
                                     "cod_unidad_medida" : value["cod_unidad_medida"],
                                     "num_ctd" : value["num_ctd"],
                                     "imp_subtotal" : value["imp_subtotal"],
                                     "flg_porcentaje" : value["flg_porcentaje"],
                                     "num_dscto" : value["num_dscto"],
                                     "total_dscto" : value["total_dscto"],
                                     "imp_total" : value["imp_total"],
                                     "dsc_observacion" : value["dsc_observacion"],
                                    });
        checked = (value["flg_porcentaje"] == "SI") ? "checked" : "";
        var backColor = (value["dsc_observacion"] != '') ? 'buttonObservacionDatos' : '';
        $(".tablaCotizacion tbody").append(
          '<tr class="trCotizacion">'+
            '<td style="width: 3%;" class="text-center vertical-middle-kq"><input type="checkbox" class="checkProductoCotizacion" value='+index+' title="Nuevo producto" '+disabledGen+'></td>'+
            '</td>'+
            '<td style="width: 26.5%;" id="filaSelectProductos_'+index+'" class="tdSelectProductosCotizacion">'+
              '<select class="form-control select2 codProductoCotizacion" style="width: 100%;" required '+disabledGen+'></select>'+
            '</td>'+
            '<input class="codProductoDisabled" type="hidden">'+ 
            '<td style="width: 7.5%;" class="tdCantidadCotizacion"><input class="form-control text-right cantidadProductoCotizacion" type="number" min="1" value="'+value["num_ctd"]+'" '+disabledGen+'></td>'+
            '<td style="width: 10%;" id="filaSelectUnidadMedida_'+index+'" class="tdSelectUnidadMedidaCotizacion">'+
              '<select class="form-control codUnidadMedidaCotizacion" style="width: 100%;" required '+disabledGen+'></select>'+
            '</td>'+
             '<td style="width: 9.5%;" class="tdPrecioUnitarioCotizacion"><input class="form-control text-right precioUnitarioCotizacion" type="text" pattern="(?!(0.00)$)\\S+"  oninvalid="setCustomValidity(\'El precio debe ser mayor a 0\')" oninput="setCustomValidity(\'\')" value="'+value["imp_subtotal"]+'" placeholder="0.00" required '+ disabledGen+' /></td>'+
            '<td style="width: 6%;" class="text-center vertical-middle-kq tdCheckPorcentajeCotizacion"><input type="checkbox" class="checkPorcentajeCotizacion" '+checked+' value="'+value["flg_porcentaje"]+'" '+disabledGen+' /></td>'+
            '</td>'+
            '<td style="width: 8.5%;" class="tdValorDescuentoCotizacion"><input class="form-control text-right valorDescuentoCotizacion" type="text" value="'+value["num_dscto"]+'" placeholder="0.00" '+disabledGen+' /></td>'+
            '<td style="width: 8.5%;" class="tdDescuentoCotizacion"><input class="form-control text-right descuentoCotizacion" type="text" value="'+value["total_dscto"]+'" placeholder="0.00" readonly '+disabledGen+' /></td>'+
            '<td style="width: 9.5%;" class="tdPrecioTotalCotizacion"><input class="form-control text-right precioTotalCotizacion" type="text" value="'+value["imp_total"]+'" readonly '+disabledGen+' /></td>'+
            '<td style="width: 5%;" class="text-center" title="Insertar Observación">'+
              '<button type="button" class="btn btn-sm btn-primary btnAgregarObservacion '+backColor+'" '+disabledGen+'>'+
                '<i class="fa fa-eye"></i>'+
              '</button>'+
              '<input type="hidden" class="observacionCotizacion" value="'+escapeHtml(value["dsc_observacion"])+'"/>'+
            '</td>'+
            '<td style="width: 4.4%;" class="text-center" title="Eliminar">'+
              '<button type="button" class="btn btn-sm btn-danger quitarProductoCotizacion" '+disabledGen+'>'+
                '<i class="fa fa-times"></i>'+
              '</button>'+
            '</td>'+
            '<input class="contadorFin" type="hidden" id="contadorFinal" value="'+contFinal+'">'+
          '</tr>'
        )//append
        /*if(mostrarProductos(value["cod_producto"],index,1)){
          mostrarUnidadMedida(value["cod_unidad_medida"],index)        
        }*/
        mostrarUnidadMedida(value["cod_unidad_medida"],index);
        mostrarProductos(value["cod_producto"],index,1);        
        listarDatosAdjuntos();
        contDet++;
      });//each
      $("#listaOrginalProductoCotizacion").val(JSON.stringify(listaProductosOriginal));
      $(".precioUnitarioCotizacion").number(true,2);
      $(".valorDescuentoCotizacion").number(true,2);
      $(".descuentoCotizacion").number(true,2);
      $(".precioTotalCotizacion").number(true,2);
      if($("#valorCheckTotalDescuentoCotizacion").val() == "SI"){
        $(".checkPorcentajeCotizacion").prop("disabled",true);
        $(".valorDescuentoCotizacion").prop("readonly",true);
      }
      if($(".trCotizacion").length == 1){
        $(".quitarProductoCotizacion").prop("disabled",true);
      }      
      $(".overlay").addClass('hidden');
    }//succes
  });//ajax
}else{
  $(".overlay").addClass('hidden');
}
var flgPeru = 'NO';
/*=============================================
SELECCIONAR CLIENTE
=============================================*/
$("#clienteCotizacion").change(function(){
  var codCliente = $(this).val();
  $("#clienteCotizacion-error").trigger("click");
  var datos = new FormData();
  datos.append("codCliente",codCliente);
  datos.append("entrada","creaCotizacion");
  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      $("#rucClienteCotizacion").val(response["dsc_documento"]);
      response["dsc_distrito"] = (response["dsc_distrito"] == '') ? response["dsc_distrito"] : ' - '+response["dsc_distrito"];
      response["dsc_provincia"] = (response["dsc_provincia"] == '') ? response["dsc_provincia"] : ' - '+response["dsc_provincia"];
      response["dsc_departamento"] = (response["dsc_departamento"] == '') ? response["dsc_departamento"] : ' - '+response["dsc_departamento"];
      $("#direccionClienteCotizacion").val(response["dsc_direccion"]+response["dsc_distrito"]+response["dsc_provincia"]+response["dsc_departamento"]+' - '+response["dsc_pais"]);
      $("#formaPagoCotizacion").val(response["cod_forma_pago"]);      
      flgPeru = response["flg_peru"];
      $("#flgCtePeruCtz").val(flgPeru);
      if(flgPeru == 'NO'){
        $("#divFormaPafoCtz label").html("Forma de pago");
        $("#divFormaPafoCtz #formaPagoCotizacion").prop("required",false);
      }else{
        $("#divFormaPafoCtz label").html("*Forma de pago");
        $("#divFormaPafoCtz #formaPagoCotizacion").prop("required",true);
      }
      sumarTotalPrecios()
    }//success
  });//ajax
});//change clienteCotizacion
if($("#codClienteCotizacion").val() != ''){
  $('#clienteCotizacion').select2('destroy');
  $("#clienteCotizacion").val($("#codClienteCotizacion").val());
  $("#clienteCotizacion").select2();
  $("#monedaCotizacion").val($("#codMonedaCotizacion").val());
  $("#formaPagoCotizacion").val($("#codFormaPagoCotizacion").val());
  $("#tituloCotizacion,#liCotizacion").html("Editar cotización");
  $("#estadoCotizacion").val($("#codEstadoCotizacion").val());
  if($("#codTipoDescuentoCotizacion").val() != ''){
    $("#selectDescuentoCotizacion").val($("#codTipoDescuentoCotizacion").val());  
  }
  if($("#valorCheckTotalDescuentoCotizacion").val() == "SI"){
    $("#checkTotalDescuentoCotizacion").prop("disabled",false);
    $("#checkTotalDescuentoCotizacion").prop("checked",true);    
  }
  $("#totalDescuentoCotizacion").val($("#impDescuentoCotizacion").val());
}
if($("#accionCotizacion").val() == 'clonar'){
  $("#liCotizacion").html("Clonar cotización");
  $("#tituloCotizacion").html("Clonar cotizacion: "+$("#codigoCotizacionOriginal").val())
}
/*=============================================
AGREGANDO FILAS A LA COTIZACION
=============================================*/
var cont = 0;
var contFinal2 = 1;
$(".boxDetalleCotizacion").on("click", ".agregarFilaCotizacion", function(){
  $(".overlay-kq-2").removeClass("hidden");
  $(".quitarProductoCotizacion").prop("disabled",false);
  cont = cont + contDet;
  contFinal2 = contFinal2 + contFinal;
  contDet = 0;
  contFinal = 0;
  $(".tablaCotizacion tbody").append(
    '<tr class="trCotizacion">'+
      '<td style="width: 3%;" class="text-center vertical-middle-kq"><input type="checkbox" class="checkProductoCotizacion" value='+cont+' title="Nuevo producto"></td>'+
      '</td>'+
      '<td style="width: 26.5%;" id="filaSelectProductos_'+cont+'" class="tdSelectProductosCotizacion ">'+
        '<select class="form-control select2 codProductoCotizacion" style="width: 100%;" required></select>'+            
      '</td>'+
      '<input class="codProductoDisabled" type="hidden">'+ 
      '<td style="width: 7.5%;" class="tdCantidadCotizacion"><input class="form-control text-right cantidadProductoCotizacion" type="number" value="1" min="1" required></td>'+
      '<td style="width: 10%;" id="filaSelectUnidadMedida_'+cont+'" class="tdSelectUnidadMedidaCotizacion" style="width:110px;">'+
        '<select class="form-control codUnidadMedidaCotizacion" style="width: 100%;" required></select>'+
      '</td>'+
      '<td style="width: 9.5%;" class="tdPrecioUnitarioCotizacion"><input class="form-control text-right precioUnitarioCotizacion" type="text" pattern="(?!(0.00)$)\\S+"  oninvalid="setCustomValidity(\'El precio debe ser mayor a 0\')" oninput="setCustomValidity(\'\')" placeholder="0.00" required></td>'+
      '<td style="width: 6%;" class="text-center vertical-middle-kq tdCheckPorcentajeCotizacion"><input type="checkbox" class="checkPorcentajeCotizacion" value="NO"></td>'+
      '<td style="width: 8.5%;" class="tdValorDescuentoCotizacion"><input class="form-control text-right valorDescuentoCotizacion" type="text" placeholder="0.00"></td>'+
      '<td style="width: 8.5%;" class="tdDescuentoCotizacion"><input class="form-control text-right descuentoCotizacion" type="text" placeholder="0.00"readonly></td>'+
      '<td style="width: 9.5%;" class="tdPrecioTotalCotizacion"><input class="form-control text-right precioTotalCotizacion" type="text" placeholder="0.00" readonly></td>'+
      '<td style="width: 5%;" class="text-center" title="Insertar Observación">'+
        '<button type="button" class="btn btn-sm btn-primary btnAgregarObservacion">'+
          '<i class="fa fa-eye"></i>'+
        '</button>'+
        '<input type="hidden" class="observacionCotizacion"/>'+
      '</td>'+
      '<td style="width: 4.4%;" class="text-center" title="Eliminar">'+
        '<button type="button" class="btn btn-sm btn-danger quitarProductoCotizacion">'+                 
          '<i class="fa fa-times"></i>'+
        '</button>'+
      '</td>'+
      '<input class="contadorFin" type="hidden" id="contadorFinal" value="'+contFinal2+'">'
  );//append
  if($("#checkTotalDescuentoCotizacion").is(':checked')){    
    if($("#selectDescuentoCotizacion").val() == "TD001"){//Porcentaje %
      $(".checkPorcentajeCotizacion").prop('checked',true);
      $(".valorDescuentoCotizacion").val($("#totalDescuentoCotizacion").val());  
    }else{//Monto
      $(".checkPorcentajeCotizacion").prop('checked',false);  
    }
    $(".checkPorcentajeCotizacion").prop("disabled",true);
    $(".valorDescuentoCotizacion").prop("readonly",true);
  }
  $(".precioUnitarioCotizacion").number(true,2);
  $(".descuentoCotizacion").number(true,2);
  $(".valorDescuentoCotizacion").number(true,2);
  $(".precioTotalCotizacion").number(true,2);
  mostrarProductos(1,cont);
  mostrarUnidadMedida('',cont);
  cont++;
  contFinal2++;
});//Click agregarFilaCotizacion

if($("#codClienteCotizacion").val() == ''){
  $(".agregarFilaCotizacion").trigger("click");
  $("#subTotalCotizacion").val(0);
  $("#igvCotizacion").val(0);
  $("#totalCottizacion").val(0);
}
$(".quitarProductoCotizacion").prop("disabled",true);
/*=============================================
MOSTRAR PRODUCTOS
=============================================*/
function mostrarProductos(a,cont,dif=2){
  //la condicional dif, es para que al momento de editar me guarde todo el detalle en el input listaproductooriginal
  $.ajax({
    url: "ajax/productos.ajax.php",
    method: "POST",
    data: "accionProducto="+"listar"+"&entrada="+"detalleCotizacion",
    dataType: "json",
    success: function(respuesta){
      var selectProductos = $("#filaSelectProductos_"+cont).children();
      selectProductos.append('<option value="" disabled selected>Seleccione un producto</option>');
      var totalCodProductoDisabled = $(".codProductoDisabled");
      var disabledProducto = "";
      $.each(respuesta, function(key,value){
        selectProductos.append(
          '<option value="'+value.cod_producto+'" '+disabledProducto+'>'+value.dsc_producto+'</option>'
        );
        //CONDICION PARA QUE NO VUELVA A ELEGIR LOS MISMOS PRODUCTOS
        for (var i = 0; i < totalCodProductoDisabled.length; i++) {
          if($(totalCodProductoDisabled[i]).val() != ''){
            if($(totalCodProductoDisabled[i]).val() == value.cod_producto){
              $(selectProductos).children('option[value="'+value.cod_producto+'"]').prop("disabled",true).attr("title","Este producto ya ha sido seleccionado");
            }
          }
        }
      });//each
      if(a == 1){ cont++; }
      selectProductos.select2();
      if(a != 1 && a != 2){
        $(selectProductos).val(a).trigger('change');
        if(dif==1){
          $("#listaOrginalProductoCotizacion").val($("#listaProductosCotizacion").val());
        }
      }
      $(".overlay-kq-2").addClass("hidden");
    }//success
  });//ajax
  return true;
}//function mostrarProductos
/*=============================================
MOSTRAR UNIDAD DE MEDIDA
=============================================*/
function mostrarUnidadMedida(codigo,cont,a=2){
  $.ajax({
    url: "ajax/unidadMedida.ajax.php",
    method: "POST",
    data: "accionUnidadMedida="+"cotizacion"+"&entrada="+"detalleCotizacion",
    dataType: "json",
    success: function(respuesta){
      var selectUnidadMedida = $("#filaSelectUnidadMedida_"+cont).children();
      selectUnidadMedida.append('<option value="" disabled selected>Seleccione una unidad de medida</option>');
      $.each(respuesta, function(key,value){
        selectUnidadMedida.append(
          '<option value="'+value.cod_unidad+'">'+value.dsc_simbolo+'</option>'
        );
      });//each
      if(codigo != ''){ $(selectUnidadMedida).val(codigo);}
      $(".overlay-kq-2").addClass("hidden");
    }//success
  });//ajax
  return true;
}//function mostrarUnidadMedida
/*=============================================
MOSTRAR TIPO PRODUCTOS
=============================================*/
function mostrarTipoProductos(cont){
  $.ajax({
    url: "ajax/tipoProducto.ajax.php",
    method: "POST",
    data: "accionTipoProducto="+"cotizacion"+"&entrada="+"detalleCotizacion",
    dataType: "json",
    success: function(respuesta){
      var selectTipoProductos = $("#filaSelectProductos_"+cont).children('.selectTipoProductoCotizacion');
      selectTipoProductos.append('<option value="" selected>Seleccione tipo producto</option>');
      $.each(respuesta, function(key,value){
        selectTipoProductos.append(
          '<option value="'+value.cod_tipo_producto+'">'+value.dsc_tipo_producto+'</option>'
        );
      });//each
    }//success
  });//ajax
}//function mostrarProductos
/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioCotizacion").on("keypress","input.cantidadProductoCotizacion",function(){
  var kCode = (window.event) ? event.keyCode : event.which;
  if(kCode == 13){
    modificaCantidadProducto($(this));
    sumarTotalPrecios();
    listarProductos();
  }
});//keypress cantidadProductoCotizacion
$(".formularioCotizacion").on("change","input.cantidadProductoCotizacion",function(){
  if($(this).val() <= 0){
    $(this).val(1);
  }
  modificaCantidadProducto($(this));
  sumarTotalPrecios();
  listarProductos();
});//change cantidadProductoCotizacion
function modificaCantidadProducto(pos){
  var cantidad = pos.val();
  var precioUnitario = pos.parent().parent().children('.tdPrecioUnitarioCotizacion').children();
  var checkDescuento = pos.parent().parent().children(".tdCheckPorcentajeCotizacion").children();
  var valorDescuento = pos.parent().parent().children(".tdValorDescuentoCotizacion").children();
  var descuento = pos.parent().parent().children(".tdDescuentoCotizacion").children();
  var precioTotal = pos.parent().parent().children('.tdPrecioTotalCotizacion').children();
  if( checkDescuento.is(':checked') ) {
    //PORCENTAJE
    descuento.val(cantidad * precioUnitario.val() * (valorDescuento.val()/100));
    $(checkDescuento).val('SI');
  }else{
    //MONTO
    $(checkDescuento).val('NO');
    if($("#checkTotalDescuentoCotizacion").is(':checked')){
      obtenerDescuentoMontoTotal();
    }else{
      descuento.val(valorDescuento.val());
    }
  }
  var precioFinal = (cantidad * precioUnitario.val()) - descuento.val();
  precioTotal.val(precioFinal);
}//function modificaCantidadProducto
/*=============================================
MODIFICAR EL PRECIO UNITARIO
=============================================*/
$(".formularioCotizacion").on("keypress","input.precioUnitarioCotizacion",function(){
  var kCode = (window.event) ? event.keyCode : event.which;
  if(kCode == 13){
    modificaPrecioUnitario($(this));
    sumarTotalPrecios();
    listarProductos();
  }
});//keypress precioUnitarioCotizacion
$(".formularioCotizacion").on("change","input.precioUnitarioCotizacion",function(){
  modificaPrecioUnitario($(this));
  sumarTotalPrecios();
  listarProductos();
});//change precioUnitarioCotizacion
function modificaPrecioUnitario(pos){
  var cantidad = pos.parent().parent().children('.tdCantidadCotizacion').children();  
  var precioUnitario = pos.val()
  var checkDescuento = pos.parent().parent().children(".tdCheckPorcentajeCotizacion").children();
  var valorDescuento = pos.parent().parent().children(".tdValorDescuentoCotizacion").children();
  var descuento = pos.parent().parent().children(".tdDescuentoCotizacion").children();
  var precioTotal = pos.parent().parent().children('.tdPrecioTotalCotizacion').children();
  if( checkDescuento.is(':checked') ) {
    //PORCENTAJE
    $(checkDescuento).val('SI');
    descuento.val(cantidad.val() * precioUnitario * (valorDescuento.val()/100));    
  }else{    
    //MONTO
    $(checkDescuento).val('NO');
    if($("#checkTotalDescuentoCotizacion").is(':checked')){
      obtenerDescuentoMontoTotal();
    }else{
      descuento.val(valorDescuento.val());
    }
  }
  var precioFinal = (cantidad.val() * precioUnitario) - descuento.val();
  precioTotal.val(precioFinal);
}//function calculaPrecioUnitario
/*=============================================
CHECK TIPO DE DESCUENTO
=============================================*/
$(".tablaCotizacion tbody").on("change","input.checkPorcentajeCotizacion", function(){
  var cantidad = $(this).parent().parent().children('.tdCantidadCotizacion').children();
  var precioUnitario = $(this).parent().parent().children('.tdPrecioUnitarioCotizacion').children();
  var valorDescuento = $(this).parent().parent().children(".tdValorDescuentoCotizacion").children();
  var descuento = $(this).parent().parent().children(".tdDescuentoCotizacion").children();
  var precioTotal = $(this).parent().parent().children('.tdPrecioTotalCotizacion').children();

  if( $(this).is(':checked') ) {
    //PORCENTAJE
    $(this).val('SI');
    $(this).prop("checked",true);
    descuento.val(cantidad.val() * precioUnitario.val() * (valorDescuento.val()/100));
  }else{    
    //MONTO
    $(this).val('NO');
    $(this).prop("checked",false);
    descuento.val(valorDescuento.val());
  }
  var precioFinal = (cantidad.val() * precioUnitario.val()) - descuento.val();
  precioTotal.val(precioFinal);
  sumarTotalPrecios();
  listarProductos();
});//change checkPorcentajeCotizacion
/*=============================================
MODIFICAR EL VALOR A DESCONTAR
=============================================*/
$(".formularioCotizacion").on("keypress","input.valorDescuentoCotizacion",function(){
  var kCode = (window.event) ? event.keyCode : event.which;
  if(kCode == 13){
    modificaValorDescuento($(this));
    sumarTotalPrecios();
    listarProductos();
  }
});//keypress precioUnitarioCotizacion
$(".formularioCotizacion").on("change","input.valorDescuentoCotizacion",function(){  
  modificaValorDescuento($(this));
  sumarTotalPrecios();
  listarProductos();
});//change valorDescuentoCotizacion
function modificaValorDescuento(pos){
  var cantidad = pos.parent().parent().children('.tdCantidadCotizacion').children();
  var precioUnitario = pos.parent().parent().children('.tdPrecioUnitarioCotizacion').children();
  var checkDescuento = pos.parent().parent().children(".tdCheckPorcentajeCotizacion").children();
  var valorDescuento = pos.val();
  var descuento = pos.parent().parent().children(".tdDescuentoCotizacion").children();
  var precioTotal = pos.parent().parent().children('.tdPrecioTotalCotizacion').children();
  if( checkDescuento.is(':checked') ) {
    //PORCENTAJE
    $(checkDescuento).val('SI');
    descuento.val(cantidad.val() * precioUnitario.val() * (valorDescuento/100));    
  }else{    
    //MONTO
    $(checkDescuento).val('NO');
    descuento.val(valorDescuento);
  }
  var precioFinal = (cantidad.val() * precioUnitario.val()) - descuento.val();
  precioTotal.val(precioFinal);
}//function modificaValorDescuento
/*=============================================
MODIFICAR EL DESCUENTO
=============================================*/
/*$(".formularioCotizacion").on("change","input.descuentoCotizacion",function(){
  var cantidad = $(this).parent().parent().children('.tdCantidadCotizacion').children();
  var precioUnitario = $(this).parent().parent().children('.tdPrecioUnitarioCotizacion').children();
  var checkDescuento = $(this).parent().parent().children(".tdCheckPorcentajeCotizacion").children();
  var valorDescuento = $(this).parent().parent().children(".tdValorDescuentoCotizacion").children();
  var descuento = $(this).val();
  var precioTotal = $(this).parent().parent().children('.tdPrecioTotalCotizacion').children();
   if( checkDescuento.is(':checked') ) {
    //PORCENTAJE
    $(checkDescuento).val('SI');
    descuento.val(cantidad.val() * precioUnitario.val() * (valorDescuento.val()/100));    
  }else{    
    //MONTO
    $(checkDescuento).val('NO');
    descuento.val(valorDescuento);
  }
  var precioFinal = (cantidad.val() * precioUnitario.val()) - descuento;
  precioTotal.val(precioFinal);
  // SUMAR TOTAL DE PRECIOS
  sumarTotalPrecios();
  listarProductos();
  //$(".precioTotalCotizacion").number(true,2);
});//change descuentoCotizacion*/
$(".formularioCotizacion").on("change","select.codUnidadMedidaCotizacion",function(){
  listarProductos();
});//change codUnidadMedidaCotizacion
function disabledProductoRepetido(){
  $(".codProductoCotizacion").children().prop("disabled",false).removeAttr("title");
  var codProductoCotizacion = $(".codProductoCotizacion");
  var codProductoDisabled = $(".codProductoDisabled");
  for (var i = 0; i < codProductoCotizacion.length; i++) {
    if($(codProductoCotizacion[i]).children().length > 0){
      for (var i2 = 0; i2 < codProductoDisabled.length; i2++) {
        if($(codProductoCotizacion[i]).val() != $(codProductoDisabled[i2]).val()){
          $(codProductoCotizacion[i]).children('option[value="'+$(codProductoDisabled[i2]).val()+'"]').prop("disabled",true).attr("title","Este producto ya ha sido seleccionado");
        }
        /*$(codProductoCotizacion[i]).select2("destroy").select2();*/
      }//for
    }//iff
  }//for
}//function disabledProductoRepetido
$(".formularioCotizacion").on("change","select.codProductoCotizacion",function(){
  $(this).parent().parent().children(".codProductoDisabled").val($(this).val());
  disabledProductoRepetido();
  listarProductos();
});//change codProductoCotizacion
$(".formularioCotizacion").on("click","button.quitarProductoCotizacion", function(){
  contFinal--;
  var totalNumLinea = $(".contadorFin");
  var numLineaELim = $(this).parent().parent().children(".contadorFin").val();
  for (var i = 0; i < totalNumLinea.length; i++) {
    if(i > (numLineaELim-1)){
      $(totalNumLinea[i]).val(Number($(totalNumLinea[i]).val())-1);
    }
  }
  var num2m = $(".numLineaTipoProductoCotizacion");
  for (var i = 0; i < num2m.length; i++) {
    if(numLineaELim < $(num2m[i]).val()){
      $(num2m[i]).val(Number($(num2m[i]).val())-1);
    }
  }
  $(this).parent().parent().remove();
  disabledProductoRepetido();
  if($(".trCotizacion").length == 1){
    $(".quitarProductoCotizacion").prop("disabled",true);
  }else{
    if($("#selectDescuentoCotizacion").val() == 'TD002'){
      obtenerDescuentoMontoTotal();
    }
  }
  sumarTotalPrecios();
  listarProductos();
  listarNuevosProductos();
});//click quitarProductoCotizacion
$(".formularioCotizacion").on("click","button.btnAgregarObservacion", function(e){
  var observacion = $(this).parent().children(".observacionCotizacion");  
  swal({
    title: 'Observación',
    width: 400,
    input: 'textarea',
    inputPlaceholder: 'Ingresar observación...',
    inputValue: observacion.val(),
    showCancelButton: true,
    confirmButtonText: 'Guardar',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    }).then(function(result){
      if(result.value == undefined && observacion.val() != ''){
        $(observacion.parent().children(".btnAgregarObservacion")).removeClass("btn-primary").addClass("buttonObservacionDatos");
      }else if(result.value != '' && result.value != undefined){
        $(observacion.parent().children(".btnAgregarObservacion")).removeClass("btn-primary").addClass("buttonObservacionDatos");
      }else{
        $(observacion.parent().children(".btnAgregarObservacion")).removeClass("buttonObservacionDatos").addClass("btn-primary");
      }
      if(result.value || result.value == ''){
        $(observacion).val(result.value);
        listarProductos();        
      }       
    });
});//click btnAgregarObservacion
var listaDatosAdjuntos = [];
$(".formularioCotizacion").on("click","button.quitarDatoAdjuntoCotizacion", function(e){
  e.preventDefault();
  $(this).parent().remove();
  var rutaDatoAdjunto = $(this).parent().children('.rutaDatosAdjuntosCotizacion').val();
  var numLineaDatoAdjunto = $(this).parent().children('.numLineaAdjuntosCotizacion').val();
  listaDatosAdjuntos.push({"dsc_ruta_archivo" : rutaDatoAdjunto,
                           "num_linea" : numLineaDatoAdjunto});
  $("#listaDatosAdjuntosCotizacion").val(JSON.stringify(listaDatosAdjuntos));
  listarDatosAdjuntos();
});//click quitarProductoCotizacion
$(".formularioCotizacion").on("change","input.nuevoProductoCotizacion",function(){
  listarNuevosProductos();
});//change nuevoProductoCotizacion
$(".formularioCotizacion").on("change","select.selectTipoProductoCotizacion",function(){
  listarNuevosProductos();
});//change selectTipoProductoCotizacion
/*=============================================
OBTENER EL DESCUENTO DE CADA PRODUCTO, AL DARA CLICK EN DESCUENTO A TODOS
=============================================*/
function obtenerDescuentoMontoTotal(){
  var cantidad = $(".cantidadProductoCotizacion");
  var precioUnitario = $(".precioUnitarioCotizacion");
  var valorDescuento = $(".valorDescuentoCotizacion");
  var descuento = $(".descuentoCotizacion");
  var precioTotal = $(".precioTotalCotizacion");
  var subTotal = 0;
  var totalMonto = 0;
  for (var i = 0; i < cantidad.length; i++) {
    subTotal += $(cantidad[i]).val() * $(precioUnitario[i]).val();
  }
  for (var i = 0; i < cantidad.length; i++) {
    totalMonto =  ($(cantidad[i]).val() * $(precioUnitario[i]).val() / subTotal).toFixed(2);
    $(valorDescuento[i]).val(totalMonto * $("#totalDescuentoCotizacion").val());
    $(descuento[i]).val(totalMonto * $("#totalDescuentoCotizacion").val());
    $(precioTotal[i]).val(($(cantidad[i]).val() * $(precioUnitario[i]).val()) - $(descuento[i]).val());
  }
}//function obtenerDescuentoMontoTotal
/*=============================================
SUMAR UNO X UNO DETALLE
=============================================*/
function sumarTotalUnoXUnoPrecios(){
  var cantidadDetalle = $(".cantidadProductoCotizacion");
  var precioUnitarioDetalle = $(".precioUnitarioCotizacion");
  var checkPorcentajeDetalle = $(".checkPorcentajeCotizacion");
  var valorDescuentoDetalle = $(".valorDescuentoCotizacion");
  var descuentoDetalle = $(".descuentoCotizacion");
  var precioTotalDetalle = $(".precioTotalCotizacion");
  var descuento = 0;
  for (var i = 0; i < descuentoDetalle.length; i++) {
    if( $(checkPorcentajeDetalle[i]).is(':checked') ) {
      //PORCENTAJE
      $(descuentoDetalle[i]).val($(cantidadDetalle[i]).val() * $(precioUnitarioDetalle[i]).val() * ($(valorDescuentoDetalle[i]).val()/100));    
    }else{    
      //MONTO
      $(descuentoDetalle[i]).val($(valorDescuentoDetalle[i]).val());
    }
    var precioFinal = ($(cantidadDetalle[i]).val() * $(precioUnitarioDetalle[i]).val()) - $(descuentoDetalle[i]).val();
    $(precioTotalDetalle[i]).val(precioFinal);
  }
}//function sumarTotalUnoXUnoPrecios
/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
function sumarTotalPrecios(){
  var precioItem = $(".precioTotalCotizacion");
  var arraySumaPrecio = [];
  for (var i = 0; i < precioItem.length; i++) {    
    arraySumaPrecio.push(Number($(precioItem[i]).val()));
  }
  function sumaArrayPrecios(total, numero){
    return total + numero;
  }
  var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
  console.log("sumaTotalPrecio",sumaTotalPrecio);
  //var igvTotalCotizacion = sumaTotalPrecio * 0.18;
  var igvTotalCotizacion = ($("#flgCtePeruCtz").val() == 'NO') ? 0 : sumaTotalPrecio * 0.18;
  $("#subTotalCotizacion").val(sumaTotalPrecio);
  $("#igvCotizacion").val(igvTotalCotizacion); 
  $("#totalCottizacion").val(sumaTotalPrecio+igvTotalCotizacion);
}//function sumarTotalPrecios
/*=============================================
LISTAR TODOS LOS DATOS ADJUNTOS
=============================================*/
function listarDatosAdjuntos(){
  var listaDatosAdjuntosClonar = [];
  var dscArchivoDatoAdjuntoClonar = $('.dscArchivoAdjuntosCotizacion');
  var rutaDatoAdjuntoClonar = $('.rutaDatosAdjuntosCotizacion');
  for (var i = 0; i < dscArchivoDatoAdjuntoClonar.length; i++) {
    listaDatosAdjuntosClonar.push({ "dsc_archivo" : $(dscArchivoDatoAdjuntoClonar[i]).val(),
                                    "dsc_ruta_archivo" : $(rutaDatoAdjuntoClonar[i]).val()
                                  });
  }//for
  $("#listaDatosAdjuntosClonarCotizacion").val(JSON.stringify(listaDatosAdjuntosClonar));
}//function listarDatosAdjuntos
/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarProductos(){
  var listaProductos = [];
  //Almacena todos los input o select que tenga esta clase
  var producto = $(".codProductoCotizacion");
  var cantidad = $(".cantidadProductoCotizacion")
  var unidMedida = $(".codUnidadMedidaCotizacion");
  var precioUnitarioDetalle = $(".precioUnitarioCotizacion");
  var checkPorcentaje = $(".checkPorcentajeCotizacion");
  var valorDescuento = $(".valorDescuentoCotizacion");
  var descuentoDetalle = $(".descuentoCotizacion");
  var precioTotalDetalle = $(".precioTotalCotizacion");
  var observacionDetalle = $(".observacionCotizacion");
  for (var i = 0; i < producto.length; i++) {      
    listaProductos.push({"num_linea" : (i+1),
                         "cod_producto" : $(producto[i]).val(),
                         "cod_unidad_medida" : $(unidMedida[i]).val(),
                         "num_ctd" : $(cantidad[i]).val(),
                         "imp_subtotal" : $(precioUnitarioDetalle[i]).val(),
                         "flg_porcentaje" : $(checkPorcentaje[i]).val(),
                         "num_dscto" : $(valorDescuento[i]).val(),
                         "total_dscto" : $(descuentoDetalle[i]).val(),
                         "imp_total" : $(precioTotalDetalle[i]).val(),
                         "dsc_observacion" : $(observacionDetalle[i]).val()
                        });
  }//for
  //Lo convierto de datos Json a una cadena String, utilizando JsonStringfy
  $("#listaProductosCotizacion").val(JSON.stringify(listaProductos));
  return true;
}//function listarProductos
/*=============================================
LISTAR NUEVOS PRODUCTOS
=============================================*/
function listarNuevosProductos(){
  var listaNuevoProducto = [];
  var descripcionProducto = $(".nuevoProductoCotizacion");
  var codTipoProducto = $(".selectTipoProductoCotizacion");
  var numLineaTipoProducto = $(".numLineaTipoProductoCotizacion");
  for (var i = 0; i < descripcionProducto.length; i++) {
    listaNuevoProducto.push({"dsc_producto" : $(descripcionProducto[i]).val(),
                             "cod_tipo_producto" : $(codTipoProducto[i]).val(),
                             //"num_linea" : ($(numLineaTipoProducto[i]).val()) - restar
                             "num_linea" : $(numLineaTipoProducto[i]).val()
                           });
  }
  $("#listaNuevoProductoCotizacion").val(JSON.stringify(listaNuevoProducto));
}//function listarNuevosProductos
/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/
$("#subTotalCotizacion").number(true,2);
$("#igvCotizacion").number(true,2);
$("#totalCottizacion").number(true,2);
/*=============================================
AGREGAR PRODUCTO POR COTIZACION
=============================================*/
$(".tablaCotizacion tbody").on("change","input.checkProductoCotizacion", function(){
  var filaProducto = $(this).parent().parent().children(".tdSelectProductosCotizacion");
  var numLineaNuevoProducto = $(this).parent().parent().children(".contadorFin").val();
  var cont = $(this).val();
  if( $(this).is(':checked') ) {
    filaProducto.parent().children(".codProductoDisabled").val('');
    disabledProductoRepetido();
    filaProducto.children().addClass('hide');
    filaProducto.children().prop('required',false);
    filaProducto.children().children().remove();
    filaProducto.append(
      '<input type="text" class="form-control nuevoProductoCotizacion" style="display:inline; width:53%;" required />'+
      '<input type="hidden" class="numLineaTipoProductoCotizacion" value="'+numLineaNuevoProducto+'">'+
      '<select style="display:inline; width:47%; background-color: #f7f3f3;" class="form-control selectTipoProductoCotizacion" style="width: 100%;"></select>');
    mostrarTipoProductos(cont);
    listarProductos();
  }else{
    $(".overlay-kq-2").removeClass("hidden");
    filaProducto.children(".nuevoProductoCotizacion").remove();
    filaProducto.children(".selectTipoProductoCotizacion").remove();
    filaProducto.children(".numLineaTipoProductoCotizacion").remove();
    filaProducto.children(".codProductoCotizacion").removeClass("hide");
    filaProducto.children(".codProductoCotizacion").prop('required',true);
    mostrarProductos(2,cont);
    listarNuevosProductos();  
  }
});//change checkProductoCotizacion
$("#estadoCotizacion").change(function(){
  var codEstado = $(this).val();
  var datos = new FormData();
  datos.append("codEstado",codEstado);
  $.ajax({
    url: "ajax/estadoCotizacion.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){      
      $("#span-title-estado").attr("title",response["dsc_detalle"]);
    }//success
  });//ajax
});//change estadoCotizacion
$("#estadoCotizacion").trigger('change');
/*=============================================
CHECK TOTAL DESCUENTO
=============================================*/
$("#checkTotalDescuentoCotizacion").change(function(){
  if( $(this).is(':checked') ) {
    $("#valorCheckTotalDescuentoCotizacion").val('SI');
    if($("#selectDescuentoCotizacion").val() == 'TD001'){//Porcentaje %
      $(".checkPorcentajeCotizacion").val("SI");
      $(".checkPorcentajeCotizacion").prop("checked",true);
      $(".valorDescuentoCotizacion").val($("#totalDescuentoCotizacion").val());      
    }else if($("#selectDescuentoCotizacion").val() == 'TD002'){//Monto
      $(".checkPorcentajeCotizacion").val("NO");
      $(".checkPorcentajeCotizacion").prop("checked",false);
      obtenerDescuentoMontoTotal();
    }
    $(".checkPorcentajeCotizacion").prop("disabled",true);
    $(".valorDescuentoCotizacion").prop("readonly",true);
    sumarTotalUnoXUnoPrecios(); 
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios();
    listarProductos();
  }else{
    $("#valorCheckTotalDescuentoCotizacion").val('NO');
    $(".checkPorcentajeCotizacion").prop("disabled",false);
    $(".valorDescuentoCotizacion").prop("readonly",false);
    $("#totalDescuentoCotizacion").val(0);
  }
});//change checkTotalDescuentoCotizacion
$("#totalDescuentoCotizacion").change(function(){
  if( $("#checkTotalDescuentoCotizacion").is(':checked') ) {
    if($("#selectDescuentoCotizacion").val() == 'TD001'){//Porcentaje %
      $(".checkPorcentajeCotizacion").prop("checked",true);
      $(".checkPorcentajeCotizacion").val("SI");
      $(".valorDescuentoCotizacion").val($(this).val());
    }else if($("#selectDescuentoCotizacion").val() == 'TD002'){//Monto
      $(".checkPorcentajeCotizacion").prop("checked",false);
      $(".checkPorcentajeCotizacion").val("NO");
      obtenerDescuentoMontoTotal();
    }    
    $(".checkPorcentajeCotizacion").prop("disabled",true);
    $(".valorDescuentoCotizacion").prop("readonly",true);
    sumarTotalUnoXUnoPrecios();
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios();
    listarProductos();
  }
});//change totalDescuentoCotizacion
$("#selectDescuentoCotizacion").change(function(){
  $("#checkTotalDescuentoCotizacion").prop("disabled",false);
  $("#checkTotalDescuentoCotizacion").attr("title","Descuentos a todos los productos");
  if( $("#checkTotalDescuentoCotizacion").is(':checked') ) {
    if($("#selectDescuentoCotizacion").val() == 'TD001'){//Porcentaje %
      $(".checkPorcentajeCotizacion").prop("checked",true);
      $(".checkPorcentajeCotizacion").val("SI");
      $(".valorDescuentoCotizacion").val($("#totalDescuentoCotizacion").val());
    }else if($("#selectDescuentoCotizacion").val() == 'TD002'){//Monto
      $(".checkPorcentajeCotizacion").prop("checked",false);
      $(".checkPorcentajeCotizacion").val("NO");
      obtenerDescuentoMontoTotal();
    }    
    $(".checkPorcentajeCotizacion").prop("disabled",true);
    $(".valorDescuentoCotizacion").prop("readonly",true);
    sumarTotalUnoXUnoPrecios();
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios();
    listarProductos();
  }//if
});//change selectDescuentoCotizacion
/*=============================================
IMPRIMIR FACTURA
=============================================*/
$("#tablaListaCotizacion").on("click", ".btnImprimirCotizacion_1", function(){
  var codigoCotizacion = $(this).attr("codCotizacion");
  //Solicito a windows que me abra una nueva ventana haciendo la ruta donde esta tcpdf
  window.open("extensions/tcpdf/pdf/cotizacion.php?codigo="+codigoCotizacion, "_blank");
});//Click btnImprimirCotizacion_1
/*=============================================
IMPRIMIR FACTURA
=============================================*/
$("#tablaListaCotizacion").on("click", ".btnImprimirCotizacion_2", function(){
  var codigoCotizacion = $(this).attr("codCotizacion");
  //Solicito a windows que me abra una nueva ventana haciendo la ruta donde esta tcpdf
  window.open("extensions/tcpdf/pdf/cotizacion-simplificada.php?codigo="+codigoCotizacion, "_blank");
});//Click btnImprimirCotizacion_2
/*=============================================
OBTENER DATOS EDITAR COTIZACION
=============================================*/
$("#tablaListaCotizacion").on("click", ".btnEditarCotizacion", function(){
  var codCotizacion = $(this).attr("codCotizacion");
  window.location = "index.php?ruta=cotizacion&codigo="+codCotizacion;
});//Click btnEditarCotizacion
/*=============================================
CLONAR COTIZACION
=============================================*/
$("#tablaListaCotizacion").on("click", ".btnClonarCotizacion", function(){
  var codigoCotizacion = $(this).attr("codCotizacion");
  var accionCotizacion = "clonar";
  window.location = "index.php?ruta=cotizacion&codigo="+codigoCotizacion+"&accion="+accionCotizacion;
});//Click btnClonarCotizacion
/*=============================================
ELIMINAR COTIZACION
=============================================*/
$("#tablaListaCotizacion").on("click", ".btnEliminarCotizacion", function(){
  var codigoCotizacion = $(this).attr("codCotizacion");
  var accionCotizacion = "eliminar";
  swal({
    title: '¿Está seguro de borrar la cotización?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar la cotización!'
  }).then(function(result){
    if (result.value) {
      $.ajax({
        url:"ajax/cotizacion.ajax.php",
        method: "POST",
        data: "accionCotizacion="+accionCotizacion+"&codigoCotizacion="+codigoCotizacion,
        success:function(respuesta){
          if(respuesta == 'ok'){
            table.ajax.url('ajax/datatable-cotizacion.ajax.php'+'&entrada=datatablePrincipal').load();
          }
        }//success
      });//ajax
    }//if
  });//then
});//Click btnEliminarCotizacion
/*=============================================
ENVIAR CORREO COTIZACION
=============================================*/
$("#tablaListaCotizacion").on("click", ".btnEnviarCorreoCotizacion", function(){
  $("#formEnviarCorreoCotizacion overlay-kq").removeClass('hidden');
  $('#formEnviarCorreoCotizacion').trigger("reset");
  $("#emailCopia").val('');
  var codigoCotizacion = $(this).attr("codCotizacion");
  var accionCotizacion = "enviarCorreo";
  var datos = new FormData();
  datos.append("codigoCotizacion",codigoCotizacion);
  datos.append("accionCotizacion",accionCotizacion);
  datos.append("entrada",'enviarCorreo');
  $.ajax({
    url: "ajax/cotizacion.ajax.php",
    type: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      $("#receptorCorreoCotizacion").val(response["dsc_correo"]);
      $("#formEnviarCorreoCotizacion overlay-kq").addClass('hidden');
    }//success
  });//ajax
});//Click btnEnviarCorreoCotizacion
/*=============================================
ENVIAR CORREO
=============================================*/
$("#enviarCorreo").click(function(e){
  e.preventDefault();
  $("#formEnviarCorreoCotizacion .overlay-kq").removeClass('hidden');
  $.ajax({
    url:"ajax/cotizacion.ajax.php",
    type: "POST",
    data: $("#formEnviarCorreoCotizacion").serialize(),
    success:function(respuesta){
      if(respuesta == 'ok'){
        swal({
          type: "success",
          title: "El correo fue enviado",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {            
            $("#modalEnviarCorreo").modal('hide');
          }
        });
      }else{
        swal({
          type: "warning",
          title: "El correo no fue enviado",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
            $("#modalEnviarCorreo").modal('hide');
          }
        });
      }//else
      $("#formEnviarCorreoCotizacion .overlay-kq").addClass('hidden');
    }//success
  });//ajax
});//click enviarCorreo
/*$.validator.addClassRules("selectValid", {
     required: true
});*/
/*=============================================
CREAR,EDITAR COTIZACION
=============================================*/
function editarCotizacion(){
  swal({
    title: '¿Está seguro de guardar la cotización?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, guardar la cotización!'
  }).then(function(result){
    if (result.value) {      
      $.ajax({
        url:"ajax/cotizacion.ajax.php",
        type: "POST",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(respuesta){
          if(respuesta == "ok"){
            swal({
              type: "success",
              title: "La cotizacion ha sido guardada correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {
                  window.location = "cotizaciones";
                }
            });//swall
          }else{
            swal({
              type: "error",
              title: "Ha ocurrio un problema al guardar, por favor vuelva a intentarlo.",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
            }).then(function(result){
              window.location = "cotizaciones";           
            });
          }
        }//success
      });//ajax
      $(".overlay").addClass('hidden');
    }else{
      $(".overlay").addClass('hidden');
    }
  });//swall
}//function editarCotizacion
var contSubmit = 1;
$("#formCotizacion").submit(function(e) {
  if(contSubmit == 1){
    e.preventDefault();
    //$(".overlay").removeClass('hidden');
    var accionCotizacion  = $("#accionCotizacion").val();
    var formData = new FormData($("#formCotizacion")[0]);  
    if(accionCotizacion == 'clonar'){
      swal({
        title: '¿Está seguro de clonar la cotización?, se generará una cotización nueva',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, clonar la cotización!'
      }).then(function(result){
        if (result.value) {        
          $.ajax({
            url:"ajax/cotizacion.ajax.php",
            type: "POST",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(respuesta){
              if(respuesta == "ok"){
                swal({
                  type: "success",
                  title: "La cotizacion ha sido clonada correctamente",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  onAfterClose: () => window.location = "cotizaciones"
                });//swal
              }else{
                swal({
                  type: "error",
                  title: "Ha ocurrio un problema al guardar, por favor vuelva a intentarlo.",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  onAfterClose: () => window.location = "cotizaciones"
                });//swal
              }
              $(".overlay").addClass('hidden');
            }//success
          });//ajax
        }else{
          $(".overlay").addClass('hidden');
          contSubmit = 1;
        }
      })//swall
    }else if(accionCotizacion == 'editar'){
      var titleBtnGnrNuevVers = ($("#codigoCotizacionOriginal").val() != $("#codigoCotizacion").val()) ? 'No puedes utilizar este botón' : '';
        if($("#listaProductosCotizacion").val() == $("#listaOrginalProductoCotizacion").val()){
          swal({
            title: '¿Está seguro de guardar la cotización?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, guardar la cotización!'
          }).then(function(result){
            if (result.value) {
              formData.append("accionEditar","cambiarCabecera");          
              $.ajax({
                url:"ajax/cotizacion.ajax.php",
                type: "POST",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                  if(respuesta == "ok"){
                    swal({
                      type: "success",
                      title: "La cotizacion ha sido guardada correctamente",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar",
                      onAfterClose: () => window.location = "cotizaciones"
                    });//swal
                  }else if(respuesta == "codigoRepetido"){
                    swal({
                      type: "error",
                      title: "El código que está ingresando ya está en uso.",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar",
                      onAfterClose: () => { $("#codigoCotizacion").focus();contSubmit = 1; }
                    });
                  }else{
                    swal({
                      type: "error",
                      title: "Ha ocurrido un problema al guardar, por favor vuelva a intentarlo.",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar",
                      onAfterClose: () => window.location = "cotizaciones"
                    });//swal
                  }
                }//success
              });//ajax          
            }else{
              $(".overlay").addClass('hidden');
              contSubmit = 1;
            }
          });//swall
        }else{
          var contBotones = 1;
          swal({
            customClass: 'swal-versionarCotizacion',
            title: '¿Está seguro de guardar la cotización?',
            type: 'warning',
            html: "¡Si no lo está puede cancelar la acción!" +
                "<br>" +
                '<button type="button" role="button" tabindex="0" id="buttonCot1" class="SwalBtn1 customSwalBtn" style="background: #3085d6;">' + 'Guardar' + '</button>' +
                '<button type="button" role="button" tabindex="0" id="buttonCot2" class="SwalBtn2 customSwalBtn" style="background: #9e995b;" title="'+titleBtnGnrNuevVers+'">' + 'Generar una nueva versión' + '</button>'+
                '<button type="button" role="button" tabindex="0" id="buttonCot3" class="SwalBtn3 customSwalBtn" style="background: rgb(221, 51, 51);">' + 'Cancelar' + '</button>',
            showCancelButton: false,
            showConfirmButton: false
          });
          $(document).on('click', '#buttonCot1', function() {
              if(contBotones == 1){
                formData.append("accionEditar","cambiarDetalle");
                $.ajax({
                  url:"ajax/cotizacion.ajax.php",
                  type: "POST",
                  data: formData,
                  cache:false,
                  contentType: false,
                  processData: false,
                  success:function(respuesta){
                    if(respuesta == "ok"){
                      swal({
                        type: "success",
                        title: "La cotizacion ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        onAfterClose: () => window.location = "cotizaciones"
                      });//swall
                    }else if(respuesta == "codigoRepetido"){
                      swal({
                        type: "error",
                        title: "El código que está ingresando ya está en uso.",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        onAfterClose: () => { $("#codigoCotizacion").focus();contSubmit = 1; }
                      });
                    }else{
                      swal({
                        type: "error",
                        title: "Ha ocurrio un problema al guardar, por favor vuelva a intentarlo.",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        onAfterClose: () => window.location = "cotizaciones"
                      });//swal
                    }//else
                  }//success
                });//ajax
              }
          });
          $(document).on('click', '#buttonCot2', function() {
            if(contBotones == 1){
              formData.append("accionEditar","nuevaVersionDetalle");
              if($("#codigoCotizacionOriginal").val() == $("#codigoCotizacion").val()){
                $.ajax({
                  url:"ajax/cotizacion.ajax.php",
                  type: "POST",
                  data: formData,
                  cache:false,
                  contentType: false,
                  processData: false,
                  success:function(respuesta){
                    if(respuesta == "ok"){
                      swal({
                        type: "success",
                        title: "La cotizacion ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        onAfterClose: () => window.location = "cotizaciones"
                      });//swal
                    }else if(respuesta == "codigoRepetido"){
                      swal({
                        type: "error",
                        title: "El código que está ingresando ya está en uso.",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        onAfterClose: () => { $("#codigoCotizacion").focus();contSubmit = 1; }
                      });
                    }else{
                      swal({
                        type: "error",
                        title: "Ha ocurrio un problema al guardar, por favor vuelva a intentarlo.",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        onAfterClose: () => window.location = "cotizaciones"
                      });//swal
                    }
                  }//success
                });//ajax
                swal.clickConfirm();                
              }else{
                swal({
                  type: "warning",
                  title: "No puedes utilizar este botón",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  onAfterClose: () => contSubmit = 1
                });//swall
              }
            }
          });
          $(document).on('click', '#buttonCot3', function() {
            if(contBotones == 1){
              $(".overlay").addClass('hidden');
              contSubmit = 1;              
              swal.clickCancel();
            }
            contBotones++;
          });
        }//else
    }else{
      $.ajax({
        url:"ajax/cotizacion.ajax.php",
        type: "POST",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(respuesta){
          if(respuesta == "ok"){
            swal({
              type: "success",
              title: "La cotizacion ha sido guardada correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              onAfterClose: () => window.location = "cotizaciones"
            });//swal
          }else if(respuesta == "codigoRepetido"){
            swal({
              type: "error",
              title: "El código que está ingresando ya está en uso.",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              onAfterClose: () => { $("#codigoCotizacion").focus();contSubmit = 1; }
            });//swall
          }else{
            swal({
              type: "error",
              title: "Ha ocurrio un problema al guardar, por favor vuelva a intentarlo.",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              onAfterClose: () => window.location = "cotizaciones"
            });
          }
          $(".overlay").addClass('hidden');
        }//success
      });//ajax
    }//else  
  }//if
  contSubmit++;
});//submit formCotizacion
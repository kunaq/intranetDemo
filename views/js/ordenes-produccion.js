//$(".inputPorcentaje").change(function(){
//    $(".inputPorcentaje").on("change", function(){
//   console.log('porcentaje');
//   if($(this).val() > 100){
//     $(this).val('');
//     $(this).focus();
//     swal({
//       type: "warning",
//       title: "La cantidad no puede exceder el 100%",
//       showConfirmButton: true,
//       confirmButtonText: "Cerrar"
//     })
//   }
// });
/*=============================================
GENERO EL DATATABLE DE LA TABLA ORDENES
DE PRODUCCION
=============================================*/
var start = moment().startOf('month');
var end = moment().endOf('month');
// CREO UNA LISTA PARA ARMAR LAS COLUMNAS
var listaColumTblOrdProd = [ 
  {"targets": 1,"className": "tblOrdProdWidthCte"},
  {"targets": 2,"className": "tblOrdProdWidthOrdPrd text-center"},
  {"targets": 3,"className": "tblOrdProdWidthEst text-center"},
  {"targets": 4,"className": "tblOrdProdWidthNitm text-center"},
  {"targets": 5,"className": "tblOrdProddWidthDsc"},
  {"targets": 6,"className": "tblOrdProdWidthCtd text-right"},
  {"targets": 7,"className": "tblOrdProdWidthUnd text-center"},
  {"targets": 8,"className": "tblOrdProdWidthFchEtg text-center"},
];
// AUMENTO LAS COLUMNAS DE ACUERDO DE AREAS
var numColumTblOrdProd = 7;
numColumTblOrdProd = parseInt(numColumTblOrdProd);
var numAreas = $("#numAreasOrdProd").val();
numAreas = parseInt(numAreas);
for(var i=1; i<=numAreas; i++){
  numColumTblOrdProd = numColumTblOrdProd+1;
  listaColumTblOrdProd.push({ "targets": numColumTblOrdProd, "className": "area"+i+"OrdProd text-center" });
}//for
listaColumTblOrdProd.push({ "targets": numColumTblOrdProd+1, "className": "tblOrdProdWidthAcn text-center" });
var start = moment().startOf('month');
var end = moment().endOf('month');
$("#filtroFInicialOrdProd").val(start.format('YYYY-MM-D'));
$("#filtroFFinalOrdProd").val(end.format('YYYY-MM-D')); 
var table = $("#tablaListaOrdProd").DataTable({
  "ajax": 'ajax/datatable-ordenProduccion.ajax.php?fechaInicial='+$("#filtroFInicialOrdProd").val()+'&fechaFinal='+$("#filtroFFinalOrdProd").val()+'&listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal',
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "language" : {
      "url": "spanish.json"
  },
  'columnDefs': listaColumTblOrdProd
});//tablaListaOrdProd DataTable
/*=============================================
FILTRO POR ESTADOS
=============================================*/
$("#filtroEstadoOrdProd").change(function(){
  table.ajax.url('ajax/datatable-ordenProduccion.ajax.php?fechaInicial='+$("#filtroFInicialOrdProd").val()+'&fechaFinal='+$("#filtroFFinalOrdProd").val()+'&listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal').load();
});
/*=============================================
FILTRO POR ESTADOS
=============================================*/
$("#filtroFchValidadaOrdProd").change(function(){
  table.ajax.url('ajax/datatable-ordenProduccion.ajax.php?fechaInicial='+$("#filtroFInicialOrdProd").val()+'&fechaFinal='+$("#filtroFFinalOrdProd").val()+'&listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal').load();
});//change filtroFchValidadaOrdProd

/*=============================================
FILTRO POR RANGO DE FECHAS
=============================================*/
function cb(start, end) {
  $('#daterange-btn-ordProd span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}//function cb
$('#daterange-btn-ordProd').daterangepicker(
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
    $('#daterange-btn-ordProd span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    //Captura el inicio de la fecha y lo cambio de formato por el formato de la BD
    var fechaInicial = start.format('YYYY-MM-D');
    var fechaFinal = end.format('YYYY-MM-D');
    $("#filtroFInicialOrdProd").val(fechaInicial);
    $("#filtroFFinalOrdProd").val(fechaFinal);
    table.ajax.url('ajax/datatable-ordenProduccion.ajax.php?fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal+'&listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal').load();
  }
)//daterangepicker
cb(start,end);
/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/
$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){
  $('#daterange-btn-ordProd span').html('<i class="fa fa-calendar"></i>  <span class="textRango">Rango de fecha</span>');
  $("#filtroFInicialOrdProd,#filtroFFinalOrdProd").val('');
  table.ajax.url('ajax/datatable-ordenProduccion.ajax.php?listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal').load();
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
      $("#filtroFInicialOrdProd").val(fechaInicial);
      $("#filtroFFinalOrdProd").val(fechaFinal);
      table.ajax.url('ajax/datatable-ordenProduccion.ajax.php?fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal+'&listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal').load();
    }//if
  }//if
})//click daterangepicker hoy
/*=============================================
OBTENER DATOS EDITAR AREA
=============================================*/
var flgPedido = flgCompras = flgDiseño = flgFabricacion = flgRevMold = flgPintura = flgControlCalidad = flgDespacho = flgFacturacion = 'NO';
$("#tablaListaOrdProd").on("click", ".btnEditarAreaOrdProd", function(){
  console.log('hola')
  var codLocalidad = $(this).attr("codLocalidad");
  var numOrdProd = $(this).attr("numOrdenProd");
  var numLineaOrdenDetalle = $(this).attr("numLineaOrdenDetalle");
  var codProducto = $(this).attr("codProducto");
  var codArea = $(this).attr("codArea");
  flgPedido = $(this).attr("flgPedido");
  flgCompras = $(this).attr("flgCompras");
  flgDiseño = $(this).attr("flgDiseño");
  flgFabricacion = $(this).attr("flgFabricacion");
  flgRevMold = $(this).attr("flgRevMold");
  flgPintura = $(this).attr("flgPintura");
  flgControlCalidad = $(this).attr("flgControlCalidad");
  flgDespacho = $(this).attr("flgDespacho");
  $("#flgPedidoAreaOrdProd").val(flgPedido);
  $("#flgComprasAreaOrdProd").val(flgCompras);
  if(flgPedido == 'SI' || flgCompras == 'SI'){
    $("#cantidadAreaOrdProd").prop("required",false);
    $("#cantidadPorcAreaOrdProd").prop("required",true);
    $(".cajaCantidadAreaOrdProd").addClass('hidden');
    $(".cajaCantidadPorcAreaOrdProd").removeClass('hidden');
    $(".tdWidthCtdAtdArOrdProd").html('Porcentaje Avance');    
  }else{
    $("#cantidadAreaOrdProd").prop("required",true);
    $("#cantidadPorcAreaOrdProd").prop("required",false);
    $(".cajaCantidadAreaOrdProd").removeClass('hidden');
    $(".cajaCantidadPorcAreaOrdProd").addClass('hidden');
    $(".tdWidthCtdAtdArOrdProd").html('Cantidad Atendida');
  }
  $("#formAreaOrdProd").trigger("reset");
  Pace.track(function(){
    cargaGifDivForm("formAreaOrdProd","");
    $.ajax({
      url:"ajax/ordenProduccion.ajax.php",
      method: "POST",
      dataType: 'json',
      data: {'localidad':codLocalidad,'ordenProduccion':numOrdProd,'lineaOrdenDetalle':numLineaOrdenDetalle,'producto':codProducto,'area':codArea,'entrada':'areaTodas','accionOrdenProduccion':'mostrarAreaXProducto'},
      success:function(respuesta){
        console.log("respuesta", respuesta);
        $("#cantidadAreaOrdProd").focus();
        $("#codLocalAreaOrdProd").val(respuesta["cod_localidad"]);
        $("#numOrdAreaOrdProd").val(respuesta["num_orden_produccion"]);
        $("#numLnaDtlAreaOrdProd").val(respuesta["num_linea_orden_detalle"]);
        $("#codPrdAreaOrdProd").val(respuesta["cod_producto"]);
        $("#codArAreaOrdProd").val(respuesta["cod_area"]);
        $("#modalTituloAreaEstOrd").html(respuesta["dsc_area"]);
        $("#tblAreaOrdProdModal").DataTable().destroy();
        if(parseInt(respuesta["contDetalle"]) > 0){
          mostrarDetalleAreaOrdPrd(respuesta["cod_localidad"],respuesta["num_orden_produccion"],respuesta["num_linea_orden_detalle"],respuesta["cod_producto"],respuesta["cod_area"]);
          $(".divNoPendiente").removeClass('hidden');
        }else{
          $("#tblAreaOrdProdModal").DataTable().destroy();
          $(".divNoPendiente").addClass('hidden');
        }
        var textAreaOrdPrd = '';
        if(flgPedido == 'SI'){
          textAreaOrdPrd = 'Pedido';
        }else if(flgCompras == 'SI'){
          textAreaOrdPrd = 'Compras';
        }else if(flgDiseño == 'SI'){
          textAreaOrdPrd = 'Diseño';
        }else if(flgFabricacion == 'SI'){
          textAreaOrdPrd = 'Fabricacion';
        }else if(flgRevMold == 'SI'){
          textAreaOrdPrd = 'RevMold';
        }else if(flgPintura == 'SI'){
          textAreaOrdPrd = 'Pintura';
        }else if(flgControlCalidad == 'SI'){
          textAreaOrdPrd = 'CtrCalidad';
        }else if(flgDespacho == 'SI'){
          textAreaOrdPrd = 'Despacho';
        }

        console.log("textAreaOrdPrd", textAreaOrdPrd);
        if($("#sessionArea"+textAreaOrdPrd+"OrdProd").val() == 'SI' && $("#sessionArea"+textAreaOrdPrd+"OrdProdEditar").val() == 'SI'){
          if(respuesta["flg_pendiente"] == 'SI' || respuesta["flg_terminado"] == 'SI'){
            $(".divEstadoAreaOrdProd").html('');
            $(".divEstadoAreaOrdProd").append(
              '<input type="text" class="form-control" id="dscEstadoAreaOrdProd" name="dscEstadoAreaOrdProd" readonly><input type="hidden" class="divSiPendiente" id="estadoAreaOrdProd" name="estadoAreaOrdProd" />');
            $("#dscEstadoAreaOrdProd").val(respuesta["dsc_estado"]);
            $("#estadoAreaOrdProd").val(respuesta["cod_estado"]);  
          }else if(respuesta["flg_proceso"] == 'SI'){
            mostrarEstadoArea(respuesta["cod_estado"]);
          }
          if(respuesta["flg_terminado"] == 'SI' ){
            $(".divSiTerminado").addClass('hidden');
          }else{
            $(".divSiTerminado").removeClass('hidden');
          }
        }else{
          $(".divEstadoAreaOrdProd").html('');
          $(".divEstadoAreaOrdProd").append(
            '<input type="text" class="form-control" id="dscEstadoAreaOrdProd" name="dscEstadoAreaOrdProd" readonly><input type="hidden" class="divSiPendiente" id="estadoAreaOrdProd" name="estadoAreaOrdProd" />');
          $("#dscEstadoAreaOrdProd").val(respuesta["dsc_estado"]);
          $("#estadoAreaOrdProd").val(respuesta["cod_estado"]);
          $(".divSiTerminado").addClass('hidden');
        }
        /*if($("#sessionAreaPedidoOrdProd").val() == 'SI' && $("#sessionAreaPedidoOrdProdEditar").val() == 'SI'){
          console.log('a1');
          $("#btnGuardarAreaMdOrdProd").removeClass("hidden")
        }else{
          console.log('a2');
          $("#btnGuardarAreaMdOrdProd").addClass("hidden")
        }*/

        if(flgPedido == 'SI'){
          if($("#sessionAreaPedidoOrdProd").val() == 'SI' && $("#sessionAreaPedidoOrdProdEditar").val() == 'SI'){
            
          }else{
            $(".divSiTerminado").addClass('hidden');
          }
        }

        /*if(respuesta["flg_terminado"] == 'SI' ){
          $(".divSiTerminado").addClass('hidden');
        }else{
          $(".divSiTerminado").removeClass('hidden');
        }*/
        if(respuesta["flg_proceso"] == 'SI'){
          //mostrarEstadoArea(respuesta["cod_estado"]);
        }
      }//success
    });//ajax
  });//Pace.track
});//click click
function mostrarEstadoArea(codEstado){
  $(".divEstadoAreaOrdProd").html('');
  var selected = '';
  $.ajax({
    url:"ajax/ordenProduccion.ajax.php",
    method: "POST",
    dataType: 'json',
    data: {'flgPendiente':'NO','entrada':'estadoNoPnd','accionOrdenProduccion':'mostrarEstadoArea'},
    success:function(respuesta){
      $(".divEstadoAreaOrdProd").append('<select class="form-control input-md divNoPendiente" id="estadoAreaOrdProd" name="estadoAreaOrdProd" style="width: 100%">')
      $.each(respuesta,function(index,value){
        selected = (value["cod_estado"] == codEstado) ? 'selected' : '';
        $("#estadoAreaOrdProd").append('<option value="'+value["cod_estado"]+'" '+selected+'>'+value["dsc_estado"]+'</option>');
      });//each
      $(".divEstadoAreaOrdProd").append('</select>');
    }//success
  });//ajax
}//function mostrarEstadoArea
//$("#tblAreaOrdProdModal").addClass('hidden');
var pageTotal = 0;
function mostrarDetalleAreaOrdPrd(localidad,ordenProduccion,lineaOrdenDeatlle,producto,area){
  console.log('Funcion detalle');
  $("#tblAreaOrdProdModal").DataTable().destroy();
  $("#tblAreaOrdProdModal").DataTable({
    "ajax": 'ajax/datatable-ordenProduccion.ajax.php?localidad='+localidad+'&numOrdenProd='+ordenProduccion+'&lineaOrdenDetalle='+lineaOrdenDeatlle+'&productoAreaOrdProd='+producto+'&areaOrdProd='+area+'&entrada=datatableDetalleOrdProdArea',
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "scrollY": "200px",
    "scrollCollapse": true,
    "paging": false,
    "language" : {
        "url": "spanish.json"
    },
    'columnDefs': [
      {
        targets: [0],
        className: "tdWidthFchRgstArOrdProd text-center"
      },
      {
        targets: [1],
        className: "tdWidthCtdAtdArOrdProd text-right"
      },
      {
        targets: [2],
        className: "tdWidthUsrArOrdProd"
      }
    ],
    footerCallback: function ( row, data, start, end, display ){
      var api = this.api(), data;

      // Remove the formatting to get integer data for summation
      var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };

      // Total over all pages
      total = api
          .column( 1 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

      // Total over this page
      pageTotal = api
          .column( 1, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

      // Update footer
      $( api.column( 1 ).footer() ).html(
          parseFloat(pageTotal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')          
      );
    }
  });//tablaListaOrdProd DataTable
  //tableArea.columns.adjust().draw();
setTimeout(function () {    
    $("#tblAreaOrdProdModal").DataTable().columns.adjust().draw()
    //$("#tblAreaOrdProdModal,.dataTables_scrollHeadInner table").removeClass('hidden');
  },1000);
}//function mostrarDetalleAreaOrdPrd

// $('#tblAreaOrdProdModal').on('shown.bs.collapse', function () {
//   console.log('a22')
//    $($.fn.dataTable.tables(true)).DataTable()
//       .columns.adjust();
// });
//table.columns.adjust().draw();
// $('#tblAreaOrdProdModal a[data-toggle="tab"]').on('shown.bs.tab', function(e){
//    $($.fn.dataTable.tables(true)).DataTable()
//       .columns.adjust();
// });
/*=============================================
CREAR,EDITAR AREA
=============================================*/
$("#formAreaOrdProd").submit(function(e){
  console.log("pageTotal", pageTotal);
  console.log("flgPedido", flgPedido);
  console.log('Cantidad',$("#cantidadPorcAreaOrdProd").val());  
  e.preventDefault();
  if(flgPedido == 'SI' || flgCompras == 'SI'){
    if(parseFloat($("#cantidadPorcAreaOrdProd").val()) > 100){
      swal({
        type: "warning",
        title: "Alerta",
        text: "La cantidad no puede exceder el 100%",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        onAfterClose: () => $("#cantidadPorcAreaOrdProd").focus()
      });//swal
    }else if((parseFloat(pageTotal)+parseFloat($("#cantidadPorcAreaOrdProd").val())) > 100){
      swal({
        type: "warning",
        title: "Alerta",
        text: "La suma de cantidades no puede exceder el 100%",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        onAfterClose: () => $("#cantidadPorcAreaOrdProd").focus()
      });//swal
    }else{
      guardarAreaOrdenProduccion();
    }
  }else{
    if(parseFloat($("#cantidadAreaOrdProd").val()) <= 0){
      swal({
        type: "warning",
        title: "La cantidad tiene que ser mayor a 0",
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        onAfterClose: () => $("#cantidadAreaOrdProd").focus()
      });//swal
    }else{
      guardarAreaOrdenProduccion()
    }  
  }  
});//submit formAreaOrdProd
function guardarAreaOrdenProduccion(){
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
      Pace.track(function(){
        cargaGifDivForm("formAreaOrdProd","");
        $.ajax({
          url:"ajax/ordenProduccion.ajax.php",
          method: "POST",
          data: $("#formAreaOrdProd").serialize(),
          success:function(respuesta){
            console.log("respuesta", respuesta);
            if(respuesta == 'mayor'){
              swal({
                type: "warning",
                title: "La cantidad antendida no puede superar la cantidad solicitado por el cliente",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                onAfterClose: () => $("#cantidadAreaOrdProd").focus()
              });//swal
            }else if(respuesta == 'ok'){
              swal({
                type: "success",
                title: "Los datos han sido guardado correctamente",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
              }).then(function(result){
                table.ajax.url('ajax/datatable-ordenProduccion.ajax.php?fechaInicial='+$("#filtroFInicialOrdProd").val()+'&fechaFinal='+$("#filtroFFinalOrdProd").val()+'&listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal').load(); $("#formAreaOrdProd [data-dismiss=modal]").trigger("click");
              });
            }//if
          }//success
        });//ajax
      });//Pace.track
    }//if
  });//then
}//function guardarAreaOrdenProduccion
/*=============================================
OBTENER DATOS EDITAR AREA FACTURACION
=============================================*/
$("#tablaListaOrdProd").on("click", ".btnEditarFacturacionAreaOrdProd", function(){
  $("#formAreaFacturacionOrdProd").trigger("reset");
  $("#formAreaFacturacionOrdProd .inputHidden").val('');
  var codLocalidad = $(this).attr("codLocalidad");
  var numOrdProd = $(this).attr("numOrdenProd");
  var numLineaOrdenDetalle = $(this).attr("numLineaOrdenDetalle");
  var codProducto = $(this).attr("codProducto");
  var codArea = $(this).attr("codArea");
  Pace.track(function(){
    cargaGifDivForm("formAreaFacturacionOrdProd","");
    $.ajax({
      url:"ajax/ordenProduccion.ajax.php",
      method: "POST",
      dataType: 'json',
      data: {'localidad':codLocalidad,'ordenProduccion':numOrdProd,'lineaOrdenDetalle':numLineaOrdenDetalle,'producto':codProducto,'area':codArea,'entrada':'areaFacturacion','accionOrdenProduccion':'mostrarAreaXProducto'},
      success:function(respuesta){
        console.log("respuesta", respuesta);
        $("#codLocalFctAreaFctOrdPrd").val(respuesta["cod_localidad"]);
        $("#numOrdFctAreaFctOrdPrd").val(respuesta["num_orden_produccion"]);
        $("#numLnaFctAreaFctOrdPrd").val(respuesta["num_linea_orden_detalle"]);
        $("#codPrdFctAreaFctOrdPrd").val(respuesta["cod_producto"]);
        $("#codAreaFctOrdPrd").val(respuesta["cod_area"]);
        $("#modalTituloAreaFacturacionEstOrd").html(respuesta["dsc_area"]);
        $("#estadoFctAreaFctOrdPrd").val(respuesta["cod_estado"]);
        if($("#sessionAreaFacturacionOrdProd").val() == 'SI' && $("#sessionAreaFacturacionOrdProdEditar").val() == 'SI'){
          $("#estadoFctAreaFctOrdPrd").prop("disabled",false);
          $(".divSiTerminadoFct").removeClass("hidden");
        }else{
          $(".divSiTerminadoFct").addClass("hidden");
          $("#estadoFctAreaFctOrdPrd").prop("disabled",true);
        }
        mostrarTablaRemision(respuesta["cod_localidad"],respuesta["num_orden_produccion"],respuesta["num_linea_orden_detalle"],respuesta["cod_producto"],respuesta["cod_area"],'SI');
        mostrarTablaRemision(respuesta["cod_localidad"],respuesta["num_orden_produccion"],respuesta["num_linea_orden_detalle"],respuesta["cod_producto"],respuesta["cod_area"],'NO');
      }//success
    });//ajax
  });//
})//click click
/*=============================================
MOSTRAR EL HISTORICO DE REMISION DE LA AREA FACTURACION
=============================================*/
function mostrarTablaRemision(localidad,ordenProduccion,lineaOrdenDetalle,producto,area,flgGuiaRemision){
  console.log('tablaRemin')
  $("#tblGuiaRemisionOrdProdModal tbody").html('');
  $("#tblFacturacionOrdProdModal tbody").html('');
   Pace.track(function(){
    cargaGifDivForm("formAreaFacturacionOrdProd","");
    $.ajax({
      url:"ajax/ordenProduccion.ajax.php",
      method: "POST",
      dataType: 'json',
      data: {'localidad':localidad,'ordenProduccion':ordenProduccion,'lineaOrdenDetalle':lineaOrdenDetalle,'producto':producto,'area':area,'entrada':'historicoDetalleGuiaRemision','accionOrdenProduccion':'mostrarHistoricoAreaFacturacion','flgGuiaRemision':flgGuiaRemision},
      success:function(respuesta){
        console.log("respuesta", respuesta);
        if(flgGuiaRemision == 'SI'){
          $.each(respuesta,function(index,value){
            $("#tblGuiaRemisionOrdProdModal tbody").append(
              '<tr>'+
                '<td class="tdWidthFchRgstArFctRmOrdProd text-center">'+value["fch_registro"]+'</td>'+
                '<td class="tdWidthGuiaRAtdArFctRmOrdProd">'+value["num_guia_remision"]+'</td>'+
                '<td class="tdWidthFchEArFctRmOrdProd text-center">'+value["fch_emision"]+'</td>'+
              '</tr>'
            );
          });//each
        }else{
          $.each(respuesta,function(index,value){
            $("#tblFacturacionOrdProdModal tbody").append(
              '<tr>'+
                '<td class="tdWidthFchRgstArFctFctOrdProd text-center">'+value["fch_registro"]+'</td>'+
                '<td class="tdWidthNumFAtdArFctFctOrdProd">'+value["num_facturacion"]+'</td>'+
                '<td class="tdWidthFchEArFctFctOrdProd text-center">'+value["fch_emision"]+'</td>'+
              '</tr>'
            );
          });//each          
        }
      }//success
    });//ajax
  });//Pace.track
}//function mostrarTablaRemision
/*=============================================
EDITAR AREA FACTURACION
=============================================*/
$("#formAreaFacturacionOrdProd").submit(function(e){
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
      Pace.track(function(){
        cargaGifDivForm("formAreaFacturacionOrdProd","");
        $.ajax({
          url:"ajax/ordenProduccion.ajax.php",
          method: "POST",
          data: $("#formAreaFacturacionOrdProd").serialize(),
          success:function(respuesta){
            console.log("respuesta", respuesta);
            if(respuesta == 'ok'){
              swal({
                type: "success",
                title: "Los datos han sido guardado correctamente",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
              }).then(function(result){
                table.ajax.url('ajax/datatable-ordenProduccion.ajax.php?fechaInicial='+$("#filtroFInicialOrdProd").val()+'&fechaFinal='+$("#filtroFFinalOrdProd").val()+'&listAreas='+$("#codigoAreasOrdProd").val()+'&estado='+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val()+'&entrada=listadoPrincipal').load();
                $("[data-dismiss=modal]").trigger("click");      
              });
            }//if
          }//success
        });//ajax
      });//Pace.track
    }//if
  });//then
});//submit formAreaFacturacionOrdProd
/*=============================================
OBTENER DATOS ORDEN DE PRODUCCION
=============================================*/
$("#tablaListaOrdProd").on("click", ".btnEditarOrdProd", function(){
  var codLocalidad = $(this).attr("codLocalidad");
  var numOrdenProduccion = $(this).attr("numOrdenProduccion");
  window.location = "index.php?ruta=orden-produccion&localidad="+codLocalidad+"&ordenProduccion="+numOrdenProduccion;
});//click btnEditarOrdProd
/*=============================================
BOTON DESCARGAR EXCEL
=============================================*/
$("#btnDescargarExcelOrdPrd").click(function(){
  window.open("views/modules/descargar-reporte.php?reporte=reporteOrdenProduccion&entrada=vtnOrdenProduccionExcel&fechaInicial="+$("#filtroFInicialOrdProd").val()+"&fechaFinal="+$("#filtroFFinalOrdProd").val()+"&listAreas="+$("#codigoAreasOrdProd").val()+"&estado="+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val(),"_blank");
});//click btnDescargarExcelOrdPrd
/*=============================================
BOTON DESCARGAR EXCEL DETALLE PRODUCTOS
=============================================*/
$("#btnDescargarExcelDetOrdPrd").click(function(){
  window.open("views/modules/descargar-reporte.php?reporte=reporteOrdenProduccionDetalle&entrada=vtnOrdenProduccionExcelDetalle&fechaInicial="+$("#filtroFInicialOrdProd").val()+"&fechaFinal="+$("#filtroFFinalOrdProd").val()+"&listAreas="+$("#codigoAreasOrdProd").val()+"&estado="+$("#filtroEstadoOrdProd").val()+'&fechaValidada='+$("#filtroFchValidadaOrdProd").val(),"_blank");
});//click btnDescargarExcelDetOrdPrd
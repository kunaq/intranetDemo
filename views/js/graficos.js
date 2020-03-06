var start = moment().startOf('month');
var end = moment().endOf('month');
var fchInicio = $("#fchInicioEstca").val();
var fchFin = $("#fchFinEstca").val();
cargarEstados();
cargarReportes2(fchInicio,fchFin);
/*=============================================
FILTRO POR RANGO DE FECHAS
=============================================*/
//cb(start, end);
/*=============================================
FILTRO POR RANGO DE FECHAS
=============================================*/
$("#fchInicioEstca").change(function(){
  fchInicio = $("#fchInicioEstca").val();
  fchFin = $("#fchFinEstca").val();
  cargarReportes1(fchInicio,fchFin);
  cargarReportes2(fchInicio,fchFin);
});//change fchInicioEstca
$("#fchFinEstca").change(function(){
  fchInicio = $("#fchInicioEstca").val();
  fchFin = $("#fchFinEstca").val();
  cargarReportes1(fchInicio,fchFin);
  cargarReportes2(fchInicio,fchFin);
});//change fchInicioEstca
//cargarEstados();
var listaEstado = [];
function cargarEstados(){
  console.log('Carga Estados');
  $.ajax({
    url:"ajax/estadoCotizacion.ajax.php",
    method: "POST",
    dataType: 'json',
    data: {'entrada':'estadoReporteCtz','accionEstadoCotizacion':'mostrar'},
    success: function(respuesta){
      console.log('respuesta',respuesta);
      $.each(respuesta,function(index,value){
        $("#tblRptEstado tbody").append(
          '<tr>'+
            '<td>'+value["dsc_estado_cotizacion"]+'</td>'+
            '<td class="totalEstado">0</td>'+
            '<td class="hidden flgPendiente">'+value["flg_pendiente"]+'</td>'+
            '<td class="hidden flgAprobado">'+value["flg_aprobado"]+'</td>'+
          '</tr>'
        );//append
        //listaEstado.push({ "y":value["dsc_estado_cotizacion"] });
      });//each
      cargarReportes1(fchInicio,fchFin)
      //cargarGraficos(listaEstado);
    }//success
  });//ajax
}
function cargarReportes1(fechaInicial,fechaFinal){
  console.log('Carga Reporte1');
  listaEstado = [];
  $.ajax({
    url:"ajax/cotizacion.ajax.php",
    method: "POST",
    dataType: 'json',
    data: {'fechaInicial':fechaInicial,'fechaFinal':fechaFinal,'entrada':'estadoReporteCtz','accionCotizacion':'mostrar'},
    success: function(respuesta){
      var flgPendienteTbl = $(".flgPendiente");
      var flgAprobadoTbl = $(".flgAprobado");
      var totalEstado = $(".totalEstado");
      for (var i = 0; i < flgPendienteTbl.length; i++){
        $(totalEstado[i]).html(0);
        $.each(respuesta,function(index,value){
          if($(flgPendienteTbl[i]).html() == value["flg_pendiente"]){
            $(totalEstado[i]).html(value["contEstado"]);
            listaEstado.push({"y":value["dsc_estado_cotizacion"],"a":value["contEstado"] });
          }else if($(flgAprobadoTbl[i]).html() == value["flg_aprobado"]){
            $(totalEstado[i]).html(value["contEstado"]);
            listaEstado.push({"y":value["dsc_estado_cotizacion"],"a":value["contEstado"] });
          }
        });//each
      }//for
      cargarGraficos1(listaEstado);
    }//success
  });//ajax
}//function cargarReportes
//cargarReportes2(start.format('YYYY-MM-D'),end.format('YYYY-MM-D'))
var listaEstado2 = [];
function cargarReportes2(fechaInicial,fechaFinal){
  console.log('Carga Reporte2');
  listaEstado2 = [];
  $.ajax({
    url:"ajax/cotizacion.ajax.php",
    method: "POST",
    dataType: 'json',
    data: {'fechaInicial':fechaInicial,'fechaFinal':fechaFinal,'entrada':'estadoReporteCtz2','accionCotizacion':'mostrar'},
    success: function(respuesta){
      console.log('respuesta',respuesta);
      var mes='';
      $.each(respuesta,function(index,value){
        switch(value["numMes"]){
          case 1:
            mes = 'Enero';
            break;
          case 2:
            mes = 'Febrero';
            break;
          case 3:
            mes = 'Marzo';
            break;
          case 4:
            mes = 'Abril';
            break;
          case 5:
            mes = 'Mayo';
            break;
          case 6:
            mes = 'Junio';
            break;
          case 7:
            mes = 'Julio';
            break;
          case 8:
            mes = 'Agosto';
            break;
          case 9:
            mes = 'Setiembre';
            break;
          case 10:
            mes = 'Octubre';
            break;
          case 11:
            mes = 'Noviembre';
            break;
          case 12:
            mes = 'Diciembre';
            break;
          default:
            mes = '';
            break;
        }//switch
        listaEstado2.push({ "y":mes,'a':value["num_pendiente"],'b':value["num_aprobado"],'c':value["num_total"] });
      });//each
      cargarGraficos2(listaEstado2);
    }//success
  });//ajax
}//function cargarReportes
function cargarGraficos1(listaEstado){
  $("#bar-chart").empty();
  console.log('ListaEstado',listaEstado);
  if(listaEstado.length > 0){
    config = {
      data: listaEstado,
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Cantidad'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
    };
    config.element = 'bar-chart';
    Morris.Bar(config);
  }
}//function cargarGraficos1
function cargarGraficos2(listaEstado2){
  console.log('ListEstado',listaEstado2);
  console.log(listaEstado2.length);
  $("#bar-chart2").empty();
  $('#visitors_bar_chart').html('');
  if(listaEstado2.length > 0){
    var datas = [
      { y: 'sas', a: 12, b: 12},
      { y: 'css', a: 10,  b: 21}
    ],
    config = {
      data: listaEstado2,
      xkey: 'y',
      ykeys: ['a', 'b','c'],
      labels: ['Pendientes', 'Aprobados','Total'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      parseTime: false,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red','blue']
    };
    config.element = 'bar-chart2';
    Morris.Line(config);
    // rey.options.labels.forEach(function(label, i){
    // var legendItem = $('<span class="legend-item"></span>').text( label).prepend('<span class="legend-color">&nbsp;</span>');
    //   legendItem.find('span')
    //     .css('backgroundColor', rey.options.barColors[i]);
    //   $('#visitors_bar_chart').append(legendItem)
    // })
  }  
}//function cargarGraficos2
function cargarGraficos3(listaEstado2){
  $("#bar-chart2").empty();
  var data = listaEstado2
    config = {
      data: data,
      xkey: 'y',
      ykeys: ['a', 'b','c'],
      labels: ['Pendientes', 'Aprobados','Total'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red','blue']
  };
  config.element = 'bar-chart2';
  Morris.Line(config);
}

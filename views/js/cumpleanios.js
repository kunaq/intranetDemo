//Date for the calendar events (dummy data)
var date = new Date()
var d    = date.getDate(),
m  = date.getMonth(),
y  = date.getFullYear()
$('#calendarioCumpleaños').fullCalendar({
  header : {
    left: 'prev,next today',
    center: 'title',
    right: ''
  },
  locale: 'es',
  defaultView: 'month',  
  viewRender: function (view, element)
    {
        intervalStart = view.intervalStart;
        intervalEnd = view.intervalEnd;
    },
  /*visibleRange: {
    start: '2019-01-01',
    end: '2019-12-31'
  },*/
  /*events : [
    {
        title : 'Juan Soto',
        start : '2019-04-14',
        eventClick: function(calEvent, jsEvent, view) {
          alert('Event: ' + calEvent.title);
          alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
          alert('View: ' + view.name);
          // change the border color just for fun
          $(this).css('border-color', 'red');
        }
    },
    {
      title : 'Juan Carlos',
      start : '2019-02-10',
      eventClick: function(calEvent, jsEvent, view){
        alert('Event: ' + calEvent.title);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);        
        $(this).css('border-color', 'red');
      }
    },
    {
      title : 'Karen Lozano',
      start : '2019-02-17',
      eventClick: function(calEvent, jsEvent, view){
        alert('Event: ' + calEvent.title);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);        
        $(this).css('border-color', 'red');
      }
    },
    {
      title : 'Milet Dávalos',
      start : '2019-01-10',
      eventClick: function(calEvent, jsEvent, view){
        alert('Event: ' + calEvent.title);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);
        // change the border color just for fun
        $(this).css('border-color', 'red');
      }//eventClick
    }
  ]*/
  events: function(start, end, timezone, callback) {
    $.ajax({
      url: "ajax/calendarioCumpleanios.ajax.php",
      method: "POST",
      data: {
        start: start.format('M'),
        end: end.format('M')
      },
      dataType: 'json',
      success:function(respuesta){
        console.log('respuesta',respuesta);
        var events = [];
        $.each(respuesta,function(key,value){
          //console.log(intervalStart.format("YYYY"))
          events.push({
            id : value.imagen+'|'+value.cargo,
            title : value.nombre,
            start : intervalStart.format("YYYY")+'-'+value.fecha,
          });
        });//each
        callback(events);
      }//success
    })//ajax
  },//events
  eventClick: function(calEvent, jsEvent, view) {
    calEventDat = calEvent.id.split('|');
    swal({
      customClass: 'swal-cumpleanios',
      title: calEvent.title,
      html: '<img src="views/img/users/'+calEventDat[0]+'" style="border:4px solid #b2cef4 !important;"><br><br><p style= "font-size: 18px;"><span style="color: #bc77a9; font-weight:bold;">Cargo : </span><span style="color: #6a7ead; font-weight: bold;">'+calEventDat[1]+'<span><br><p style= "font-size: 18px;"><span style="color: #8bc52b; font-weight: bold;">Fecha de cumpleaños : </span><span style= "color: #a98659; font-weight: bold;">'+calEvent.start.format('DD-MM-YYYY')+'</span></p>',
      confirmButtonText: "Cerrar"
    })//swal
  },
})//fullCalendar
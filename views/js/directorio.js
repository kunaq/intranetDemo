if($("#permisoDirectorio").val() == 'SI'){
    var table = $('.tablaDirectorio').DataTable( {
        "ajax": "ajax/datatable-directorio.ajax.php?entrada=vtnDirectorio",
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "language" : {
            "url": "spanish.json"
        },
        'columnDefs': [
            {
              "targets": [0,1,2,3,4,5,6],
              "className":"vertical-middle-kq"
            },
            {
              "targets": [7,8,10],
              "className":"vertical-middle-kq text-center"
            },
            {
              "targets": 9,
              "className":"details-control vertical-middle-kq"
            },
            {
              "targets": 11,
              "className":"hidden"
            }    
        ]
    });//DataTable tablaDirectorio   
}else{
    var table = $('.tablaDirectorio').DataTable( {
        "ajax": "ajax/datatable-directorio.ajax.php?entrada=vtnDirectorio",
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "language" : {
            "url": "spanish.json"
        },
        'columnDefs': [
            {
              "targets": [0,1,2,3,4,5,6],
              "className":"vertical-middle-kq"
            },
            {
              "targets": [7,8],
              "className":"vertical-middle-kq text-center"
            },
            {
              "targets": [10],
              "className":"vertical-middle-kq text-center hidden"
            },
            {
              "targets": 9,
              "className":"details-control vertical-middle-kq"
            },
            {
              "targets": 11,
              "className":"hidden"
            }    
        ]
    });//DataTable tablaDirectorio
}
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>'+d[11]+'</td>'+
        '</tr>'+
    '</table>';
}//function format
$('.tablaDirectorio tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    if(row.child.isShown()){
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }else{
        // Open this row
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }//else
});//click details-control
/*=============================================
EDITAR TRABAJADOR
=============================================*/
$(".tablaDirectorio").on("click", ".btnEditarDirectorio", function(){
    $(".overlay").removeClass('hidden');
    $("#accionTrabajador").val("editar");
    var codTrabajador = $(this).attr("codTrabajador");
    var datos = new FormData();
    datos.append("codTrabajador",codTrabajador);
    datos.append("accionTrabajador","mostrar");
    $.ajax({
        url:"ajax/trabajador.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success:function(respuesta){            
            $("#codigoTrabajador").val(respuesta["cod_trabajador"]);
            $("#nombreTrabajador").val(respuesta["dsc_apellido_paterno"]+' '+respuesta["dsc_apellido_materno"]+', '+respuesta["dsc_nombres"]);
            $("#anexoTrabajador").val(respuesta["dsc_anexo"]);            
            $("#grupoSanguineoTrabajador").val(respuesta["dsc_grupo_sanguineo"]);
            $("#nombreContactoTrabajador").val(respuesta["dsc_contacto"]);
            $("#telefonoContactoTrabajador").val(respuesta["dsc_telefono_contacto_1"]);
            $(".overlay").addClass('hidden');
        }//success
    });//ajax
});//click btnEditarDirectorio
/*=============================================
EDITAR DIRECTORIO
=============================================*/
$("#guardarDirectorio").click(function(e){
    $(".overlay").removeClass('hidden');
    $.ajax({
        url:"ajax/trabajador.ajax.php",
        method: "POST",
        data: $("#formTrabajador").serialize(),
        success:function(respuesta){
            if(respuesta == "ok"){
                swal({
                    type: "success",
                    title: "El trabajador ha sido editado correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if (result.value) {
                        $("[data-dismiss=modal]").trigger("click");
                        table.ajax.url('ajax/datatable-directorio.ajax.php?entrada=vtnDirectorio').load();
                        $('#formTrabajador').trigger("reset");
                    }
                });
            }else{
                swal({
                    type: "error",
                    title: "Ha ocurrido un problema al editar este trabajador, por favor intente de nuevo.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if (result.value) {
                        $("[data-dismiss=modal]").trigger("click");
                        table.ajax.url('ajax/datatable-directorio.ajax.php?entrada=vtnDirectorio').load();
                        $('#formTrabajador').trigger("reset");
                    }
                });
            }
            $(".overlay").addClass('hidden');
        }//success
    });//ajax
});//click guardarDirectorio
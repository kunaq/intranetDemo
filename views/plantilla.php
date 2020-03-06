<?php
$numRamdom = rand ();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Indelat</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--=====================================
    PLUGINS DE CSS
    ======================================-->
    <link rel="stylesheet" href="views/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">  <!-- Ionicons -->
    <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
    <!-- AdminLTE Skins-->
    <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">
    <!-- Google Font -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
    <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome2.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="views/plugins/iCheck/all.css">
    <!-- UniteGallery -->
    <link rel="stylesheet" href="views/plugins/unitegallery/css/unite-gallery.css">
    <!-- BootStrap-DataTable -->
    <link rel="stylesheet" href="views/bower_components/bootstrap-datatable/bootstrap-table.css">
    <!--<link rel="stylesheet" href="views/bower_components/bootstrap-datatable/bootstrap-editable.css">-->
    <!-- fullCalendar -->
    <link rel="stylesheet" href="views/bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="views/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- EasyReponsive -->
    <link rel="stylesheet" href="views/plugins/easy-responsive-tabs/css/easy-responsive-tabs.css">
    <?php
    if(isset($_GET["ruta"])){
      if($_GET["ruta"] == "nosotros"){
        echo '<link rel="stylesheet" href="views/bower_components/bootstrap-editable/css/bootstrap-editable.css">';
      }
    }
    ?>
    <!-- Bootstrap Editable -->
    <!-- <link rel="stylesheet" href="views/bower_components/bootstrap-editable/css/bootstrap-editable.css"> -->
    <!-- Daterange picker -->
    <link rel="stylesheet" href="views/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- Jquery Datepicker -->
    <link rel="stylesheet" href="views/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"></link>
    <!-- Morris chart -->
    <link rel="stylesheet" href="views/bower_components/morris.js/morris.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="views/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="views/bower_components/select2/dist/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="views/dist/css/AdminLTE.css?<?php echo $numRamdom;?>">
    <!-- Email Multiples -->
    <link rel="stylesheet" href="views/plugins/email-multiple/email.multiple.css">
    <!-- JS TREE -->
    <link rel="stylesheet" href="views/plugins/jstree/themes/default/style.min.css">
    <!-- JQUERY UI -->
    <link rel="stylesheet" href="views/bower_components/jquery-ui/jquery-ui.css">

    <!-- GIF CARGA -->
    <!-- <link rel="stylesheet" href="views/dist/css/loading.css"> -->
    <!--=====================================
    PLUGINS DE JAVASCRIPT
    ======================================-->
    <script src="views/plugins/pace/pace.min.js" type="text/javascript"></script>
    <!-- jQuery 3 -->
    <script src="views/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="views/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="views/dist/js/adminlte.min.js"></script>
    <!-- DataTables -->
    <script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
    <script src="views/bower_components/datatables.net-bs/js/dataTables.fixedHeader.min.js"></script>
    <!-- SweetAlert 2 -->
    <script src="views/plugins/sweetalert2/sweetalert2.all.js"></script>
    <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
    <script src="views/plugins/sweetalert2/core.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="views/plugins/iCheck/icheck.min.js"></script>
    <!-- InputMask -->
    <script src="views/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="views/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- jquery Number -->
    <script src="views/plugins/jqueryNumber/jquery.number.js"></script>
    <!-- UniteGallery -->
    <script src="views/plugins/unitegallery/js/unitegallery.min.js"></script>
    <!-- <script src='views/plugins/unitegallery/themes/tiles/ug-theme-tiles.js'></script> -->
    <script src='views/plugins/unitegallery/themes/tilesgrid/ug-theme-tilesgrid.js'></script>
    <!-- BootStrap-DataTable -->
    <!--<script src="views/bower_components/bootstrap-datatable/bootstrap-table.js"></script>
    <script src="views/bower_components/bootstrap-datatable/bootstrap-table-editable.min.js"></script>
    <script src="views/bower_components/bootstrap-datatable/bootstrap-table-editable-2.min.js"></script>
    <script src="views/bower_components/bootstrap-datatable/locale/bootstrap-table-es-Es.js"></script>-->
    <!-- fullCalendar -->
    <script src="views/bower_components/moment/min/moment.min.js"></script>
   <!-- <script src="views/bower_components/moment/min/moment-with-locales.min.js"></script> -->
    <script src="views/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src='views/bower_components/fullcalendar/dist/locale/es.js'></script>
   
    <?php
    if(isset($_GET["ruta"])){
      if($_GET["ruta"] == "nosotros"){
        echo '<script src="views/bower_components/bootstrap-editable/js/bootstrap-editable.min.js"></script>';
      }
    }
    ?>
    <!-- Bootstrap Editable -->
    <!-- <script src="views/bower_components/bootstrap-editable/js/bootstrap-editable.min.js"></script> -->
    <!-- daterangepicker http://www.daterangepicker.com/-->
    <!-- <script src="views/bower_components/moment/min/moment.min.js"></script> -->
    <!-- <script src="views/bower_components/moment/min/moment-with-locales.min.js"></script> -->
    <script src="views/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Jquery Datepicker -->
    <script src="views/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- bootstrap color picker -->
    <script src="views/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- Select2 -->
    <script src="views/bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- Email Multiples -->
    <script src="views/plugins/email-multiple/jquery.email.multiple.js"></script>
    <!-- JS TREE -->
    <script src="views/plugins/jstree/jstree.min.js"></script>
    <!-- Jquery Validate -->
    <script src="views/plugins/jquery-validate/jqBootstrapValidation.js"></script>
    <!-- Jquery UI -->
    <script src="views/bower_components/jquery-ui/jquery-ui.js"></script>
    <script src="views/plugins/easyPaginate/jquery.easyPaginate.js"></script>
    <!-- EasyReponsive -->
    <script src="views/plugins/easy-responsive-tabs/js/easyResponsiveTabs.js"></script>
    <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
    <script src="views/bower_components/raphael/raphael.min.js"></script>
    <script src="views/bower_components/morris.js/morris.min.js"></script>
    <!-- ChartJS -->
    <script src="views/bower_components/chart.js/Chart.js"></script>
  </head>
  <!--=====================================
  CUERPO DOCUMENTO
  ======================================-->
  <!-- Al poner el sidebar collapse, me inicia con el sidebar oculto , utilia la clase login page, para poder utilizar el login-->
  <body class="hold-transition skin-blue sidebar-mini" style="background: 0px 0px repeat scroll rgb(0, 0, 0);">
    <?php
      if(isset($_SESSION["iniciarSesionIntranet"]) && $_SESSION["iniciarSesionIntranet"] == "ok"){
        echo '<input type="hidden" id="sessionAreaPedidoOrdProd" value="'.$_SESSION["flgAreaPedidoOrdProd"].'" />
        <input type="hidden" id="sessionAreaPedidoOrdProdEditar" value="'.$_SESSION["flgAreaPedidoOrdProdEditar"].'" />
        <input type="hidden" id="sessionAreaComprasOrdProd" value="'.$_SESSION["flgAreaCompraOrdProd"].'" />
        <input type="hidden" id="sessionAreaComprasOrdProdEditar" value="'.$_SESSION["flgAreaCompraOrdProdEditar"].'" />
        <input type="hidden" id="sessionAreaDiseñoOrdProd" value="'.$_SESSION["flgAreaDiseñoOrdProd"].'" />
        <input type="hidden" id="sessionAreaDiseñoOrdProdEditar" value="'.$_SESSION["flgAreaDiseñoOrdProdEditar"].'" />
        <input type="hidden" id="sessionAreaFabricacionOrdProd" value="'.$_SESSION["flgAreaFabricacionOrdProd"].'" />
        <input type="hidden" id="sessionAreaFabricacionOrdProdEditar" value="'.$_SESSION["flgAreaFabricacionOrdProdEditar"].'" />

        <input type="hidden" id="sessionAreaRevMoldOrdProd" value="'.$_SESSION["flgAreaRevMoldOrdProd"].'" />
        <input type="hidden" id="sessionAreaRevMoldOrdProdEditar" value="'.$_SESSION["flgAreaRevMoldOrdProdEditar"].'" />

        <input type="hidden" id="sessionAreaPinturaOrdProd" value="'.$_SESSION["flgAreaPinturaOrdProd"].'" />
        <input type="hidden" id="sessionAreaPinturaOrdProdEditar" value="'.$_SESSION["flgAreaPinturaOrdProdEditar"].'" />

        <input type="hidden" id="sessionAreaCtrCalidadOrdProd" value="'.$_SESSION["flgAreaCtrCalidadOrdProd"].'" />
        <input type="hidden" id="sessionAreaCtrCalidadOrdProdEditar" value="'.$_SESSION["flgAreaCtrCalidadOrdProdEditar"].'" />

        <input type="hidden" id="sessionAreaDespachoOrdProd" value="'.$_SESSION["flgAreaDespachoOrdProd"].'" />
        <input type="hidden" id="sessionAreaDespachoOrdProdEditar" value="'.$_SESSION["flgAreaDespachoOrdProdEditar"].'" />

        <input type="hidden" id="sessionAreaFacturacionOrdProd" value="'.$_SESSION["flgAreaFacturacionOrdProd"].'" />
        <input type="hidden" id="sessionAreaFacturacionOrdProdEditar" value="'.$_SESSION["flgAreaFacturacionOrdProdEditar"].'" />        

        ';
      }
     /*=============================================
      CABEZOTE
      =============================================*/
      include "modules/cabezote.php";
      /*=============================================
      MENU
      =============================================*/
      include "modules/menu.php";
      /*=============================================
      CONTENIDO
      =============================================*/
      if(isset($_GET["ruta"])){
        if($_GET["ruta"] == "inicio" ||
           $_GET["ruta"] == "nosotros" ||
           $_GET["ruta"] == "directorio" ||
           $_GET["ruta"] == "galeria" ||
           $_GET["ruta"] == "tipoGaleria" ||
           $_GET["ruta"] == "consultas-frecuentes" ||
           $_GET["ruta"] == "noticia" ||
           $_GET["ruta"] == "ver-noticia" ||
           $_GET["ruta"] == "politica-procedimiento" ||
           $_GET["ruta"] == "aniversario" ||
           $_GET["ruta"] == "padre" ||
           $_GET["ruta"] == "trabajo" ||
           $_GET["ruta"] == "semana-santa" ||
           //$_GET["ruta"] == "seguridad" ||
           //$_GET["ruta"] == "tabla-control" ||
           $_GET["ruta"] == "cumpleanios" ||
           $_GET["ruta"] == "cotizaciones" ||
           $_GET["ruta"] == "cotizacion" ||
           $_GET["ruta"] == "productos" ||
           $_GET["ruta"] == "clientes" ||
           $_GET["ruta"] == "tablas-maestras" ||
           $_GET["ruta"] == "contactos" ||
           $_GET["ruta"] == "contacto" ||
           $_GET["ruta"] == "ordenes-produccion" ||
           $_GET["ruta"] == "orden-produccion" ||
           $_GET["ruta"] == "graficos" ||
           $_GET["ruta"] == "resumen-ordenes-produccion" ||
           $_GET["ruta"] == "salir"){
            include "modules/".$_GET["ruta"].".php";
        }else{
          include "modules/404.php";
        }
      }else{
        include "modules/inicio.php";
      }
      if(isset($_GET["ruta"])){
        if($_GET["ruta"] == "cotizaciones" ||
           $_GET["ruta"] == "clientes" ||
           $_GET["ruta"] == "productos" ||
           $_GET["ruta"] == "cotizacion" ||
           $_GET["ruta"] == "tablas-maestras" ){
        }
      }
      /*=============================================
      FOOTER
      =============================================*/
      include "modules/footer.php";
      if(isset($_GET["ruta"])){
        echo '<script type="text/javascript" src="views/js/plantilla.js?'.$numRamdom.'"></script>';
        if($_GET["ruta"] == "nosotros" ||
           $_GET["ruta"] == "directorio" ||
           $_GET["ruta"] == "noticia" ||
           $_GET["ruta"] == "galeria" ||
           $_GET["ruta"] == "cumpleanios" ||
           $_GET["ruta"] == "productos" ||
           $_GET["ruta"] == "clientes" ||
           $_GET["ruta"] == "consultas-frecuentes" ||
           $_GET["ruta"] == "tablas-maestras" ||
           $_GET["ruta"] == "cotizaciones" ||
           $_GET["ruta"] == "contactos" || 
           $_GET["ruta"] == "politica-procedimiento" || 
           $_GET["ruta"] == "ordenes-produccion" ||
           $_GET["ruta"] == "graficos" ||
           $_GET["ruta"] == "inicio"){
          echo '<script type="text/javascript" src="views/js/'.$_GET["ruta"].'.js?'.$numRamdom.'"></script>';
        }else if($_GET["ruta"] == "cotizacion"){
          echo '<script type="text/javascript" src="views/js/cotizaciones.js?'.$numRamdom.'"></script>';
          echo '<script type="text/javascript" src="views/js/clientes.js?'.$numRamdom.'"></script>';
        }else if($_GET["ruta"] == "contacto"){
          echo '<script type="text/javascript" src="views/js/contactos.js?'.$numRamdom.'"></script>';
          echo '<script type="text/javascript" src="views/js/clientes.js?'.$numRamdom.'"></script>';
        }else if($_GET["ruta"] == "tipoGaleria"){
          echo '<script type="text/javascript" src="views/js/galeria.js?'.$numRamdom.'"></script>';
        }else if($_GET["ruta"] == "orden-produccion"){
          echo '<script type="text/javascript" src="views/js/orden-produccion.js?'.$numRamdom.'"></script>';
          echo '<script type="text/javascript" src="views/js/clientes.js?'.$numRamdom.'"></script>';
        }else if($_GET["ruta"] == "resumen-ordenes-produccion"){
          echo '<script type="text/javascript" src="views/js/resumen-ordenes-produccion.js?'.$numRamdom.'"></script>';
        }

      }else{
        echo '<script type="text/javascript" src="views/js/inicio.js?"'.$numRamdom.'></script>';
      }
    ?>
  </body>
</html>
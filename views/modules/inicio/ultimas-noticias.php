<div class="box box-default" style="border-top-color: #013976;">
  <div class="box-header with-border border-left-kq" style="background: #013976 repeat scroll 0 0 !important; color: #fff;">
    <h3 class="box-title">Últimas Noticias</h3>
    <div class="box-tools pull-right" style="padding: 2px;">
      <?php
      if(isset($_SESSION["iniciarSesionIntranet"]) && $_SESSION["iniciarSesionIntranet"] == "ok"){
        echo '<a href="noticia" style="color: #fff; font-size: 12px; padding: 5px;">Ver todas <i class="fa fa-random"></i></a>';
      }
      ?>              
    </div>
  </div>
  <div class="box-body">
    <ul class="products-list product-list-in-box">
      <?php
      $item = null;
      $valor = null;
      $entrada = "inicioNoticia";
      $noticia = ControladorNoticia::ctrMostrarNoticia($item,$valor,$entrada);
      if(count($noticia) > 0){
        foreach ($noticia as $key => $value) {
           echo '<li class="item">
                  <div class="product-img" style="width: 173px; height: 80px;">
                    <img src="archivos/noticia/'.$value["imagen"].'" alt="Product Image" style="width: 85%; height: 100%;">
                  </div>
                  <div class="product-info" style="margin-left: 167px; height: 80px;">
                    <a href="index.php?ruta=ver-noticia&codigo='.$value["cod_noticia"].'" class="product-title">
                     '.$value["dsc_titulo"].'
                    </a>
                    <span class="label label-danger pull-right">'.dateTimeFormat($value["fch_publicacion"]).'</span>
                    <span class="product-description" style="white-space: normal;" title="'.$value["dsc_resumen"].'">
                     '.recortar_texto($value["dsc_resumen"],150);
                      if(isset($_SESSION["iniciarSesionIntranet"]) && $_SESSION["iniciarSesionIntranet"] == "ok"){
                        if(strlen($value["dsc_resumen"]) > 150){
                          echo '<a href="index.php?ruta=ver-noticia&codigo='.$value["cod_noticia"].'">Ver más</a>';
                        }
                      }
                    echo '</span>
                  </div>
                </li>';
        }//foreach
      }else{
        echo '<span>No hay noticias</span>';
      }
      ?>
    </ul>
  </div>
</div>
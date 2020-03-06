<div class="content-wrapper" style="background: #FBBA00 repeat scroll 0 0;">
  <div class="overlay overlay-inicio-kq hidden">
    <i class="fa fa-refresh fa-spin fa-spin-inicio-kq"></i>
  </div>
  <section class="content-header">
    <h2 class="page-header color-h2-kq">Bienvenido a la Intranet</h2>
  </section>    
  <section class="content" style="padding-top: 0;">    
    <div class="row">
      <div class="col-md-12">
        <?php
        include "inicio/carousel.php";
        ?>        
      </div>
    </div>
    <div class="row">
      <!-- PRIMERA COLUMNA -->
      <div class="col-md-7">
        <?php
        include "inicio/ultimas-noticias.php";
        ?>  
      </div>
      <!-- SEGUNDA COLUMNA -->      
      <div class="col-md-5">
        <?php
        include "inicio/cumpleanios.php";
        include "inicio/ultimos-ingresos.php";
        ?>
      </div>
    </div>
  </section>
</div>
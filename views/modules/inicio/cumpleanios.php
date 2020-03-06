<div class="box box-success" style="border-top-color: #013976">
  <div class="box-header with-border border-left-kq" style="background: #013976 repeat scroll 0 0 !important;color: #fff;">
    <h3 class="box-title">Cumpleaños</h3>
    <div class="box-tools pull-right" style="padding: 2px;">
      <?php
      if(isset($_SESSION["iniciarSesionIntranet"]) && $_SESSION["iniciarSesionIntranet"] == "ok"){
        echo '<a href="cumpleanios" style="color: #fff; font-size: 12px; padding: 5px;">Ver todas <i class="fa fa-random"></i></a>';
      }
      ?>
    </div>
  </div>
  <div class="box box-widget widget-user-2">              
      <?php
      $item1= "fch_nacimiento";
      $valor1 = date("m-d");
      $item2 = $valor2 = $item3 = $valor3 = null;
      $entrada = "cumpleaños";
      $cumpleaños = ControladorTrabajador::ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
      if(count($cumpleaños) > 0){
        foreach ($cumpleaños as $key => $value) {
          echo "<div class='widget-user-header'>";
          if($value["imagen"] != ''){            
            $imagen = '<img class="img-circle" src="archivos/trabajador/'.$value["imagen"].'">';
          }else{
            $imagen = '<img class="img-circle" src="archivos/trabajador/anonymous.png">';
          }
          echo '<div class="widget-user-image">
                  '.$imagen.'
                </div>
                <h3 class="widget-user-username" title="'.$value["dsc_nombres"].$value["dsc_apellido_paterno"].$value["dsc_apellido_materno"].'">'.$value["dsc_nombres"].'</h3>
                <h5 class="widget-user-desc">'.$value["dsc_cargo"].'</h5>
          </div>';
        }
      }else{
        echo '<div class="widget-user-header"><span>No hay cumpleaños</span></div>';
      }
      ?>
  </div>
</div>
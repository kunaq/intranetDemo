<div class="box box-danger" style="border-top-color: #013976">
  <div class="box-header with-border border-left-kq" style="background: #013976 repeat scroll 0 0 !important; color: #fff;">
    <h3 class="box-title">Últimos Ingresos</h3>
  </div>
  <div class="box-body no-padding">
    <ul class="users-list clearfix">
      <?php
      $item1 = $valor1 = $item2 = $valor2 = $item3 = $valor3 = null;
      $entrada = "ultimosIngresos";
      $trabajador = ControladorTrabajador::ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
      foreach ($trabajador as $key => $value){
        if($value["imagen"] != ''){
          $imagen = '<img class="img-circle" src="archivos/trabajador/'.$value["imagen"].'">';
        }else{
          $imagen = '<img class="img-circle" src="archivos/trabajador/anonymous.png">';
        }
        $fechaIngreso = dateFormat($value["fch_ingreso"]);
        echo '<li>
                '.$imagen.'
                <span class="users-list-name" title="'.$value["dsc_nombres"].' '.$value["dsc_apellido_paterno"].' '.$value["dsc_apellido_materno"].'">'.$value["dsc_nombres"].'</span>
                <span class="users-list-date" title="'.$fechaIngreso.'">'.$fechaIngreso.'</span>
              </li>';
      }//foreach
      ?>
    </ul>
  </div>
</div>
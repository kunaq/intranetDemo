<!--=====================================
MODAL AGREGAR CONTACTO INFORME
======================================-->
<div id="modalInformeContacto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialogContacto">
        <div class="modal-content">
                <!-- <form id="formInformeContacto" method="post"> -->
            <div id="formInformeContacto">
                <!-- <div class="overlay overlay-kq hidden">
                    <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
                </div> -->
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header modal-headerContacto-kq">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                    <h4 class="modal-title" style="font-weight: bold;" id="modalTituloInformeContacto">Agregar informe</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <!-- ENTRADA PARA LA FECHA DE INFORME-->
                            <div class="form-group col-md-6">
                                <label class="col-md-2 control-label" style="padding-left: 0;">Fecha informe:</label>
                                <div class="col-md-10" style="padding-right: 0;">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="fechaInformeContacto" value="<?php echo date('d-m-Y'); ?>">                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA LA ACTIVIDAD -->
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label" style="padding-left: 0;width: 7.9%;">Actividad:</label>
                                <div class="col-md-10" style="padding-right: 0;width: 92.1%;">
                                    <input type="text" class="form-control inputFormInforme" id="actividadInformeContacto" value="" placeholder="Ingrese la actividad">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA EL LUGAR -->
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label" style="padding-left: 0;width: 7.9%;">Lugar:</label>
                                <div class="col-md-10" style="padding-right: 0;width: 92.1%;">
                                    <input type="text" class="form-control inputFormInforme" id="lugarInformeContacto" placeholder="Ingrese el lugar">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA LOS PARTICIPANTES CLIENTE -->
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label" style="padding-left: 0;width: 7.9%;">Partic. Cliente:</label>
                                <div class="col-md-10" style="padding-right: 0; width: 92.1%;">
                                    <textarea id="participantesClienteInformeContacto" class="form-control inputFormInforme" placeholder="Ingrese los participantes del cliente"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA LOS PARTICIPANTES INDELAT -->
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label" style="padding-left: 0;width: 7.9%;">Partic. Indelat:</label>
                                <div class="col-md-10" style="padding-right: 0;width: 92.1%;">
                                    <textarea id="participantesIndelatInformeContacto" class="form-control inputFormInforme" placeholder="Ingrese los participantes de Indelat"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA EL ACUERDO -->
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label" style="padding-left: 0;width: 7.9%;">Acuerdo:</label>
                                <div class="col-md-10" style="padding-right: 0; width: 92.1%;">
                                    <textarea id="acuerdoInformeContacto" class="form-control inputFormInforme" placeholder="Ingrese el acuerdo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA EL OBJETIVO -->
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label" style="padding-left: 0;width: 7.9%;">Objetivo:</label>
                                <div class="col-md-10" style="padding-right: 0; width: 92.1%;">
                                    <textarea id="objetivoInformeContacto" class="form-control inputFormInforme" placeholder="Ingrese el objetivo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA LA FECHA PROGRAMADA-->
                            <div class="form-group col-md-6">
                                <label class="col-md-2 control-label" style="padding-left: 0;">Fecha programada:</label>
                                <div class="col-md-10" style="padding-right: 0;">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="fechaProgramadaInformeContacto" value="<?php echo date('d-m-Y'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA SELECCIONAR UN STATUS -->
                            <div class="form-group col-md-6">
                                <label class="col-md-2 control-label" style="padding-left: 0;">Status:</label>
                                <div class="col-md-10" style="padding-right: 0;">
                                    <select class="form-control selectFormInforme" id="statusInformeContacto" style="width: 100%;">
                                        <option value="" selected disabled>Seleccionar un status</option>
                                        <?php
                                        $item = null;
                                        $valor = null;
                                        $status = ControladorStatusInformeContacto::ctrMostrarStatusInformeContacto($item,$valor);
                                        foreach ($status as $key => $value) {
                                            echo '<option value="'.$value["cod_status"].'">'.$value["dsc_status"]." ".'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- ENTRADA PARA SELECCIONAR EL ÁREA DEL ACUERDO -->
                            <div class="form-group col-md-6">
                                <label class="col-md-2 control-label" style="padding-left: 0;">Área de acuerdo:</label>
                                <div class="col-md-10" style="padding-right: 0;">
                                    <select class="form-control selectFormInforme" id="areaInformeContacto" style="width: 100%;">
                                        <option value="" selected disabled>Seleccionar un área</option>
                                        <?php
                                        $item = null;
                                        $valor = null;
                                        $areaAcuerdo = ControladorAreaInformeContacto::ctrMostrarAreaInformeContacto($item,$valor);
                                        foreach ($areaAcuerdo as $key => $value) {
                                            echo '<option value="'.$value["cod_area"].'">'.$value["dsc_area"]." ".'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <!-- ENTRADA PARA SELECCIONAR UN RESPONSABLE -->
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label" style="padding-left: 0;width: 7.9%;">Responsable Indelat:</label>
                                <div class="col-md-10" style="padding-right: 0;width: 92.1%;">
                                    <select class="form-control select2 selectFormInforme" id="responsableIndelatInformeContacto" style="width: 100%;">
                                        <option selected disabled value="">Selecciona un trabajador</option>
                                        <?php
                                        $item1 = $valor1 = $item2 = $valor2 = $item3 = $valor3 = null;
                                        $entrada = "modalContacto";
                                        $trabajador = ControladorTrabajador::ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
                                        foreach ($trabajador as $key => $value) {
                                            echo '<option value="'.$value["cod_trabajador"].'">'.$value["dsc_nombres"]." ".$value["dsc_apellido_paterno"]." ".$value["dsc_apellido_materno"].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>                  
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA SELECCIONAR SUBIR FOTO -->
                            <div class="form-group col-md-12">
                            <div class="panel">SUBIR ARCHIVO</div>                         
                                <!-- <input type="file" name="archivoInformeContacto" id="archivoInformeContacto">
                                <input type="hidden" id="nombreArchivoInformeContacto"> -->
                                <button class="btn" id="botonArchivoInformeContacto">Elegir Archivo</button>
                                <span id="nombreArchivoInformeContacto"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <!-- <button type="submit" class="btn btn-primary btn-agregar2-kq">Guardar</button> -->
                    <button type="button" id="botonGuardarContacto" class="btn btn-primary btn-agregar2-kq">Guardar</button>
                </div>
                <input type="hidden" id="accionInformeContacto" name="accionInformeContacto" />
                <input type="hidden" id="fechaHoyInformeContacto" value="<?php echo date('d-m-Y'); ?>" />
                <input type="hidden" id="numLineaInformeModal">
            <!-- </form> -->
            </div>
        </div>
    </div>
</div>
<!-- </form> -->
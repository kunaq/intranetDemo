<!--=====================================
MODAL AGREGAR CONTACTO INFORME
======================================-->
<div id="modalAgregarInformeContacto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialogContacto">
        <div class="modal-content">
            <form id="formInformeContacto" method="post">
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
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Fecha del informe"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control input-lg" id="fechaInformeContacto" placeholder="Ingrese fecha de informe" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required value="<?php echo date('d-m-Y'); ?>">
                                </div>
                            </div>    
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA LA ACTIVIDAD -->
                            <div class="form-group col-md-6">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Actividad"><i class="fa fa-feed"></i></span>
                                    <textarea class="form-control input-lg" id="actividadInformeContacto" name="actividadInformeContacto" placeholder="Ingrese la actividad"></textarea>
                                </div>
                            </div>
                            <!-- ENTRADA PARA EL LUGAR -->
                            <div class="form-group col-md-6">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Lugar"><i class="fa fa-map-marker"></i></span>
                                    <textarea class="form-control input-lg" id="lugarInformeContacto" name="lugarInformeContacto" placeholder="Ingrese el lugar"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA LOS PARTICIPANTES CLIENTE -->
                            <div class="form-group col-md-6">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Participantes cliente"><i class="fa fa-users"></i></span>
                                    <textarea class="form-control input-lg" id="participantesClienteInformeContacto" name="participantesClienteInformeContacto" placeholder="Ingrese los participantes del cliente"></textarea>
                                </div>
                            </div>
                            <!-- ENTRADA PARA LOS PARTICIPANTES INDELAT -->
                            <div class="form-group col-md-6">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Participantes Indelat"><i class="fa fa-users"></i></span>
                                    <textarea class="form-control input-lg" id="participantesIndelatInformeContacto" name="participantesIndelatInformeContacto" placeholder="Ingrese los participantes de Indelat"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA EL ACUERDO -->
                            <div class="form-group col-md-6">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Acuerdo"><i class="fa fa-book"></i></span>
                                    <textarea class="form-control input-lg" id="acuerdoInformeContacto" placeholder="Ingrese el acuerdo"></textarea>
                                </div>
                            </div>
                            <!-- ENTRADA PARA EL OBJETIVO -->
                            <div class="form-group col-md-6">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Objetivo"><i class="fa fa-book"></i></span>
                                    <textarea class="form-control input-lg" id="objetivoInformeContacto" placeholder="Ingrese el objetivo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA LA FECHA PROGRAMADA -->
                            <div class="form-group col-md-6">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Fecha programada"><i class="glyphicon glyphicon-time"></i></span>
                                    <input type="text" class="form-control input-lg" id="fechaProgramadaInformeContacto" name="fechaProgramadaInformeContacto" placeholder="Ingrese fecha programada" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                </div>
                            </div>
                            <!-- ENTRADA PARA SELECCIONAR UN STATUS -->
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon" title="Status"><i class="fa fa-recycle"></i></span>
                                    <!-- <select class="form-control input-lg" id="statusInformeContacto" name="statusInformeContacto" style="width: 100%">
                                           <option value="" selected disabled>Seleccionar un status</option>
                                           <option>Estado 1</option>
                                           <option>Estado 2</option>
                                           <option>Estado 3</option>
                                    </select> -->
                                    <input type="text" class="form-control input-lg" id="statusInformeContacto" name="statusInformeContacto" placeholder="Ingrese un status">
                                </div>                                
                            </div>
                        </div>                    
                        <div class="row">
                            <!-- ENTRADA PARA SELECCIONAR UN RESPONSABLE -->
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon" title="Responsable indelat"><i class="fa fa-user"></i></span>
                                    <!-- <select class="form-control input-lg" id="responsableIndelatInformeContacto" name="responsableIndelatInformeContacto" style="width: 100%">
                                           <option value="" selected disabled>Seleccionar un responsable</option>
                                           <option>Usuario 1</option>
                                           <option>Usuario 2</option>
                                           <option>Usuario 3</option>
                                    </select> -->
                                    <input type="text" class="form-control input-lg" id="responsableIndelatInformeContacto" name="responsableIndelatInformeContacto" placeholder="Ingrese un responsable Indelat">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA EL ÁREA DEL ACUERDO -->
                            <div class="form-group col-md-12">
                                <div class="input-group">              
                                    <span class="input-group-addon" title="Acuerdo"><i class="fa fa-book"></i></span>
                                    <textarea class="form-control input-lg" id="acuerdoInformeContacto" name="acuerdoInformeContacto" placeholder="Ingrese el área del informe"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ENTRADA PARA SELECCIONAR SUBIR FOTO -->
                            <div class="form-group col-md-12">
                            <div class="panel">SUBIR ARCHIVO</div>                         
                                <input type="file" name="archivoInformeContacto" id="archivoInformeContacto">
                            </div>
                        </div>
                    </div>
                </div>
                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary btn-agregar2-kq">Guardar</button>
                </div>
                <input type="hidden" id="accionInformeContacto" name="accionInformeContacto">
                <input type="hidden" id="listaInformeContacto">
            </form>
        </div>
    </div>
</div>
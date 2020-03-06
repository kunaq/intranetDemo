<div class="content-wrapper fondo-content-wrapper-kq">

	<section class="content-header">
    
	    <h1 class="page-header color-h2-kq">
	      
	      Tabla Control
	    
	    </h1>

	    <ol class="breadcrumb">
	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      
	      <li class="active">Tabla Control</li>
	    
	    </ol>

	</section>

	<section class="content">
		<div class="box" style="border-top: 3px solid #98e07b;">
			<div class="box-body">
				<div class="table-responsive">
					<!-- <table class="table table-bordered table-striped tablas" width="100%""> -->
					<!-- <a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username" class="editable editable-click editable-open" data-original-title="" title="">superuser</a> -->
					<table class="table table-bordered table-striped tablas" width="100%"">
  						<thead>
    						<tr>
								<th></th>
								<th>Foto</th>
								<th>Nombre</th>
								<th>Cargo</th>
								<th>Correo</th>
								<th>Teléfono</th>
								<th>Anexo</th>
								<th>Fecha de Ingreso</th>
								<th>Fecha de Cumpleaños</th>
							</tr>
  						</thead>
  						<tbody>
  							<tr>
								<td>1</td>
								<td><img src="views/img/users/820.png" class="img-thumbnail" width="40px"></td>
								<td><a href="javascript:void(0)" class="myeditable editable editable-click editable-empty" data-type="text" data-name="firstname" data-original-title="Enter firstname">Jaime Fernandez</a></td>
								<td>Gerente TI</td>
								<td>jfernandez@kunaq.com.pe</td>
								<td>978985962</td>
								<td>2482745</td>
								<td>19-05-2017</td>
								<td>19-07-1980</td>	
							</tr>
							<tr>
								<td>2</td>
								<td><img src="views/img/users/avatar2.png" class="img-thumbnail" width="40px"></td>
								<td>Lissette Arias</td>
								<td>Gerente TI</td>
								<td>larias@kunaq.com.pe</td>
								<td>978985962</td>
								<td>2482745</td>
								<td>19-05-2017</td>
								<td>19-07-1980</td>	
							</tr>
							<tr>
								<td>3</td>
								<td><img src="views/img/users/avatar5.png" class="img-thumbnail" width="40px"></td>
								<td>Luis Fernandez</td>
								<td>Gerente TI</td>
								<td>lfernandez@kunaq.com.pe</td>
								<td>978985962</td>
								<td>2482745</td>
								<td>19-05-2017</td>
								<td>19-07-1980</td>	
							</tr>
  						</tbody>

					</table>
  					<br><br>

					<table id="table2" 
  						   data-search="true"
  						   data-show-columns="true"
  						   data-minimum-count-columns="2"
  						   data-pagination="true"
  						   data-url="json/data1.json"
  					>
  						<!-- <thead>
    						<tr>
								<th></th>
								<th>Foto</th>
								<th class="editable editable-click">Nombre</th>
								<th>Cargo</th>
								<th>Correo</th>
								<th>Teléfono</th>
								<th>Anexo</th>
								<th>Fecha de Ingreso</th>
								<th>Fecha de Cumpleaños</th>
							</tr>
  						</thead>
  						<tbody>
  							<tr>
								<td>1</td>
								<td><img src="views/img/users/820.png" class="img-thumbnail" width="40px"></td>
								<td><a href="#" id="username2" class="editable editable-click editable-empty" data-type="text" data-name="firstname" data-original-title="Enter firstname">Empty</a></td>
								<td>Gerente TI</td>
								<td>jfernandez@kunaq.com.pe</td>
								<td>978985962</td>
								<td>2482745</td>
								<td>19-05-2017</td>
								<td>19-07-1980</td>	
							</tr>
							<tr>
								<td>2</td>
								<td><img src="views/img/users/avatar2.png" class="img-thumbnail" width="40px"></td>
								<td>Lissette Arias</td>
								<td>Gerente TI</td>
								<td>larias@kunaq.com.pe</td>
								<td>978985962</td>
								<td>2482745</td>
								<td>19-05-2017</td>
								<td>19-07-1980</td>	
							</tr>
							<tr>
								<td>3</td>
								<td><img src="views/img/users/avatar5.png" class="img-thumbnail" width="40px"></td>
								<td>Luis Fernandez</td>
								<td>Gerente TI</td>
								<td>lfernandez@kunaq.com.pe</td>
								<td>978985962</td>
								<td>2482745</td>
								<td>19-05-2017</td>
								<td>19-07-1980</td>	
							</tr>
  						</tbody> -->

					</table>
						
				</div>
			</div>
		</div>

	</section>

</div>

<script>
	$(".myeditable").editable();

	var $table = $('#table2')

	/* */

	function initTable() {
	    $table.bootstrapTable({
	    	columns: [
	    	/*[
	    		{
	    			title: '',
	    			field: 'id',
	    			align: 'center'

	    		},
	    		{
	    			title: 'Foto',
	    			field: 'id',
	    			align: 'center',
	    			sortable: true

	    		},
	    		{
	    			title: 'Nombre',
	    			field: 'id',
	    			align: 'center',
	    			sortable: true,
	    			editable: true

	    		},
	    		{
	    			title: 'Cargo',
	    			field: 'id',
	    			align: 'center',
	    			sortable: true

	    		},
	    		{
	    			title: 'Correo',
	    			field: 'id',
	    			align: 'center',
	    			sortable: true

	    		},
	    		{
	    			title: 'Teléfono',
	    			field: 'id',
	    			align: 'center',
	    			sortable: true

	    		},
	    		{
	    			title: 'Fecha de Ingreso',
	    			field: 'id',
	    			align: 'center',
	    			sortable: true

	    		},
	    		{
	    			title: 'Fecha de cumpleaños',
	    			field: 'id',
	    			align: 'center',
	    			sortable: true

	    		}
	    	]*/
	    	[
	    		{
	    			field: 'id',
	    			title: 'Item Id',
	    			align: 'center'

	    		},
	    		{
	    			field: 'name',
	    			title: 'Item Name',
	    			align: 'center'

	    		},
	    		{
	    			field: 'price',
	    			title: 'Item Price',
	    			align: 'center'

	    		}
	    	]
	    	]
	    });

	}
	/*function ajaxRequest(params) {
    // data you need
     console.log(params.data)
    // just use setTimeout
    setTimeout(function () {
      params.success({
        total: 100,
        rows: [{
          'id': 0,
          'name': 'Item 0',
          'price': '$0'
        }]
      })
    }, 1000);
	}*/

	initTable();
	
</script>
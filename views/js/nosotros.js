$("#texto-historia").editable({
	validate: function(value) {
              if($.trim(value) == '') return 'Este campo es requerido.';
            },
  type: 'textarea',
  mode: 'inline',
  pk:  1,
 	name: 'historia',
 	url: 'ajax/nosotros.ajax.php'
});
$("#texto-vision").editable({
	validate: function(value) {
              if($.trim(value) == '') return 'Este campo es requerido.';
            },
  type: 'textarea',
  mode: 'inline',
  pk:  1,
 	name: 'vision',
 	url: 'ajax/nosotros.ajax.php'
});
$("#texto-mision").editable({
	validate: function(value) {
              if($.trim(value) == '') return 'Este campo es requerido.';
            },
  type: 'textarea',
  mode: 'inline',
  pk:  1,
 	name: 'mision',
 	url: 'ajax/nosotros.ajax.php'
});
$(".btnEditarVision").click(function(){	
	setTimeout(function(){
		$('#texto-vision').trigger("click");
	},1000)
});//click btnEditarVision
$(".btnEditarMision").click(function(){	
	setTimeout(function(){
		$('#texto-mision').trigger("click");
	},1000)
});//click btnEditarMision
$(".btnEditarHistoria").click(function(){	
	setTimeout(function(){
		$('#texto-historia').trigger("click");
	},1000)
});//click btnEditarHistoria
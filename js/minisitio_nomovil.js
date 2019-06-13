// DEPENDENCIAS
var puerto_host = $('#puerto_host').val();
/*
$('#pais').on('change', function(){
	var id_pais = $(this).val(); 
	if (id_pais != "" && id_pais == 39) {
	        $.ajax({
	            type: "GET",
	            url: puerto_host+"/index.php?mostrar=RegTest&opcion=buscaProvincia&id_pais="+id_pais,
	            dataType:'json',
	            success:function(data){
	                $('#provincia').html('<option value="">Selecciona una provincia</option>');
	                // console.log(data);
	                $.each(data, function(index, value) {
	                    $('#provincia').append("<option value='"+index+"'>"+value+"</option>");

	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#provincia_content').css('display', '');
		//$('#cantonnac').attr('disabled', '');
		//$('#cantonnac_content').css('display', '');
	}
	else{
		$('#provincia').html('<option value="">Selecciona una provincia</option>');
		//$('#cantonnac').html('<option value="">Selecciona un cantón</option>');
		$('#provincia_content').css('display', 'none');
		//$('#cantonnac_content').css('display', 'none');
		eliminarMensajeError($('#provincia'), '');
		//eliminarMensajeError($('#cantonnac'), '');
	}
});*/

/*$('#provincia').on('change', function(){
	var id_provincia = $(this).val();
	if(id_provincia != ""){
		$.ajax({
	            type: "GET",
	            url: puerto_host+"?mostrar=regtest&opcion=buscaCiudad&id_provincia="+id_provincia,
	            dataType:'json',
	            success:function(data){
	                $('#cantonnac').html('<option value="">Selecciona un cantón</option>');
	                // console.log(data);
	                $.each(data, function(index, value) {
	                    $('#cantonnac').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#cantonnac').removeAttr('disabled');
	}
});*/

/*$('#provincia_res').on('change', function(){
	var id_provincia = $(this).val();
	if(id_provincia != ""){
		$.ajax({
	            type: "GET",
	            url: puerto_host+"?mostrar=regtest&opcion=buscaCiudad&id_provincia="+id_provincia,
	            dataType:'json',
	            success:function(data){
	                $('#canton_res').html('<option value="">Selecciona un cantón</option>');
	                console.log(data);
	                $.each(data, function(index, value) {
	                    $('#canton_res').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#canton_res').removeAttr('disabled');
	}
});*/

/*$('#canton_res').on('change', function(){
	var id_canton = $(this).val();
	if(id_canton != ""){
		$.ajax({
	            type: "GET",
	            url: puerto_host+"?mostrar=regtest&opcion=buscaParroquia&id_canton="+id_canton,
	            dataType:'json',
	            success:function(data){
	                $('#parroquia_res').html('<option value="">Selecciona una parroquia</option>');
	                console.log(data);
	                $.each(data, function(index, value) {
	                    $('#parroquia_res').append("<option value='"+value.id_parroquia+"'>"+value.descripcion+"</option>");
	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#parroquia_res').removeAttr('disabled');
	}
});*/
// DEPENDENCIAS
//Validaciones
var mensaje_error = "";


$('#nombres').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#apellidos').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#fecha_nacimiento').on('blur', function(){
	// console.log($(this).val());
	emptyField(this);
	validarCaracteresPermitidos('fecha', $(this));
});

$('#genero').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#pais').on('change', function(){
	emptyField(this);
	buscaProvincia($('#pais').val(),$('#provincia').val());
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#provincia').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#documentacion').on('change', function(){
  borrarDatos(2);
	emptyField(this);
	$('#dni').removeAttr('disabled');
	if($('#documentacion').val() == 3){
  	$('#nombre_dni').html('Pasaporte');  	
  }else if($('#documentacion').val() == 2){
 	  $('#nombre_dni').html('C&eacute;dula'); 	  
  }
	if ($.trim($('#dni').val()) != ''){
	  validarDocumento($('#dni').val(),$('#documentacion').val(),$('#dni'));
	  existeDni($('#dni').val());
	}	
});

$('#dni').on('keyup', function(){

	if(document.getElementById('documentacion').value==2 && document.getElementById('dni').value.length >= 10){
		emptyField(this);
		validarDocumento($('#dni').val(),$('#documentacion').val(),this);
		existeDni($('#dni').val());
	}if(document.getElementById('documentacion').value==2 && document.getElementById('dni').value.length < 10){
		crearMensajeError(this,"El numero de cédula debe tener mínimo 10 dígitos");
	}
	else if(document.getElementById('documentacion').value==3 && document.getElementById('dni').value.length >= 6){
		validarDocumento($('#dni').val(),$('#documentacion').val(),this);
		existeDni($('#dni').val());
	}
});

$('#dni').on('click', function(){

	if(document.getElementById('documentacion').value==2 && document.getElementById('dni').value.length >= 10){
		emptyField(this);
		validarDocumento($('#dni').val(),$('#documentacion').val(),this);
		existeDni($('#dni').val());
	}if(document.getElementById('documentacion').value==2 && document.getElementById('dni').value.length < 10){
		crearMensajeError(this,"El numero de cédula debe tener mínimo 10 dígitos");
	}
	else if(document.getElementById('documentacion').value==3 && document.getElementById('dni').value.length >= 6){
		validarDocumento($('#dni').val(),$('#documentacion').val(),this);
		existeDni($('#dni').val());
	}
});

$('#estado_civil').on('change', function(){
	emptyField(this);
});

$('#nivel_instruccion').on('change', function(){
	emptyField(this);
});

$('#profesion').on('change', function(){	
	emptyField(this);	
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#ocupacion').on('change', function(){	
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#provincia_res').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

//$('#canton_res').on('change', function(){
//	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
//});

//$('#parroquia_res').on('change', function(){
//	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
//});

$('#correo').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('correo', $(this));
});

//$('#aspiracion_salarial').on('blur', function(){
//	emptyField(this);
//	validarCaracteresPermitidos('dinero', $(this));
//});

$('#terminos_condiciones').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

// inicializar campos del formulario
function camposFormulario(){
	var camposForm = [];

	if($('#empresa').length){
		var empresa_field = $('#empresa');
		camposForm.push(empresa_field);
	}

	if($('#documentacion').length){
		var documentacion_field = $('#documentacion');
		camposForm.push(documentacion_field);
	}

	if($('#dni').length){
		var dni_field = $('#dni');
		camposForm.push(dni_field);
	}

	if($('#nombres').length){
		var nombres_field = $('#nombres');
		camposForm.push(nombres_field);
	}
	if($('#apellidos').length){
		var apellidos_field = $('#apellidos');
		camposForm.push(apellidos_field);
	}
	if($('#fecha_nacimiento').length){
		var fecha_nacimiento_field = $('#fecha_nacimiento');
		camposForm.push(fecha_nacimiento_field);
	}
	if($('#genero').length){
		var genero_field = $('#genero');
		camposForm.push(genero_field);
	}
	if($('#pais').length){
		var pais_field = $('#pais');
		camposForm.push(pais_field);
	}
	// dependencias start
	if($('#provincia_content:visible').length == 1){
		if($('#provincia').length){
			var provincia_field = $('#provincia');
			camposForm.push(provincia_field);
		}
	}
	/*if($('#cantonnac_content:visible').length == 1){
		if($('#cantonnac').length){
			var cantonnac_field = $('#cantonnac');
			camposForm.push(cantonnac_field);
		}
	}*/
	// dependencias end
	if($('#estado_civil').length){
		var estado_civil_field = $('#estado_civil');
		camposForm.push(estado_civil_field);
	}
	if($('#nivel_instruccion').length){
		var nivel_instruccion_field = $('#nivel_instruccion');
		camposForm.push(nivel_instruccion_field);
	}
	if($('#profesion').length){
		var profesion_field = $('#profesion');
		camposForm.push(profesion_field);
	}
	if($('#ocupacion').length){
		var ocupacion_field = $('#ocupacion');
		camposForm.push(ocupacion_field);
	}
	if($('#provincia_res').length){
		var provincia_res_field = $('#provincia_res');
		camposForm.push(provincia_res_field);
	}
	/*if($('#canton_res').length){
		var canton_res_field = $('#canton_res');
		camposForm.push(canton_res_field);
	}
	if($('#parroquia_res').length){
		var parroquia_res_field = $('#parroquia_res');
		camposForm.push(parroquia_res_field);
	}*/
	if($('#correo').length){
		var correo_field = $('#correo');
		camposForm.push(correo_field);
	}
	/*if($('#aspiracion_salarial').length){
		var aspiracion_salarial_field = $('#aspiracion_salarial');
		camposForm.push(aspiracion_salarial_field);
	}*/
	if($('#terminos_condiciones').length){
		var terminos_condiciones_field = $('#terminos_condiciones');
		camposForm.push(terminos_condiciones_field);
	}
	return camposForm;
}

function ValidarCamposVacios(campos){
	for (var i = 0; i < campos.length; i++) {
		emptyField(campos[i]);
	}
}

function errorCountMessage(){
	var number = $('.error_field').length;
	 //console.log('errores: '+number);
	return number;
}
 // || $(obj)[0].checked != 1
function emptyField(obj){

	if($(obj).prop('type') != 'checkbox'){

		if($(obj).val() == "" || $(obj).val() == null){
			if($(obj).prop('tagName') == 'SELECT'){
				mensaje_error = "Seleccione una opción";
			}
			else{
				mensaje_error = "Rellene este campo";
			}					
			crearMensajeError(obj, mensaje_error);
		}
		else{
			mensaje_error = "";			
			eliminarMensajeError(obj, mensaje_error);
		}
	}
	else{
		if($(obj).prop('type') == 'checkbox'){
			if(!$(obj).is(':checked')){
				mensaje_error = "Debe aceptar términos y condiciones";
				crearMensajeError(obj, mensaje_error);
			}
			else{
				mensaje_error = "";
					eliminarMensajeError(obj, mensaje_error);
			}
		}
	}
}

function crearMensajeError(obj, mensaje){	
	if((obj[0] && obj[0].id == 'fecha_nacimiento') || obj.id == 'fecha_nacimiento'){
		$('#fecha_error').html("<p style='position: relative; bottom: 52px;'>"+mensaje+"</p>");
    	$('#fecha_error').addClass('error_field');
	}else
	if ((obj[0] && obj[0].id == 'profesion') || obj.id == 'profesion'){
    $('#err_profesion').html("<p style='position: relative; bottom: 52px;'>"+mensaje+"</p>");
    $('#err_profesion').addClass('error_field');
	}
	else if ((obj[0] && obj[0].id == 'ocupacion') || obj.id == 'ocupacion'){
    $('#err_ocupacion').html("<p style='position: relative; bottom: 52px;'>"+mensaje+"</p>");
    $('#err_ocupacion').addClass('error_field');
	}
	else if((obj[0] && obj[0].id == 'terminos_condiciones') || obj.id == 'terminos_condiciones'){
		$('#terminos_condiciones').siblings('div').html("<p style='position: relative; bottom: 52px;'>"+mensaje+"</p>");
    	$('#terminos_condiciones').siblings('div').addClass('error_field');
    	$('#terminos_condiciones').siblings('div').css('top', '38px');
    	// $('#terminos_condiciones').siblings('div').css('left', '35%');

    	// top:36px; left:50%;
	}
	else{
		$(obj).siblings('div').html("<p style='position: relative; bottom: 52px;'>"+mensaje+"</p>");
	  $(obj).siblings('div').addClass('error_field');
	}	
}

function eliminarMensajeError(obj, mensaje){
	if ((obj[0] && obj[0].id == 'fecha_nacimiento') || obj.id == 'fecha_nacimiento'){
		$('#fecha_error').html(mensaje);
    	$('#fecha_error').removeClass('error_field');
	}else 
  if ((obj[0] && obj[0].id == 'profesion') || obj.id == 'profesion'){
    $('#err_profesion').html(mensaje);
    $('#err_profesion').removeClass('error_field');
	}
	else if ((obj[0] && obj[0].id == 'ocupacion') || obj.id == 'ocupacion'){
    $('#err_ocupacion').html(mensaje);
    $('#err_ocupacion').removeClass('error_field');
	}
	else{
	  $(obj).siblings('div').html(mensaje);
	  $(obj).siblings('div').removeClass('error_field');
	}
}

//Validaciones
$('#form_registrotest').on('submit', function(event){
	ValidarCamposVacios(camposFormulario());
	permitidos();
	//console.log(errorCountMessage());
	if(errorCountMessage() > 0){
		event.preventDefault();
	}
	// errorCountMessage();
	
	// event.preventDefault();
});

function validarCaracteresPermitidos(tipo, contenido){	
	var tipo_validacion = [];
	tipo_validacion.push(["nombre_apellido", ['El ' +contenido.siblings('label').text()+ ' ingresado no es válido', validarNombreApellido(contenido[0].value)]]);
	tipo_validacion.push(["correo", ['El ' +contenido.siblings('label').text()+ ' ingresado no es válido', validarCorreo(contenido[0].value)]]);
	tipo_validacion.push(["fecha_nacimiento", ['Formato no válido o debe ser mayor de edad', validarFecha(contenido[0].value)]]);
	tipo_validacion.push(["dinero", ['El formato ingresado no es válido', validarFormatoDinero(contenido[0].value)]]);
	tipo_validacion.push(["numero", ['Solo numeros entre 1 y 5', validarNumero(contenido[0].value)]]);
	//tipo_validacion.push(["fecha_nacimiento", ['Debe ser mayor de edad', calcularEdad()]]);
	// console.log(tipo_validacion);
	if (tipo == tipo_validacion[0][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[0][1][1])){
			crearMensajeError(contenido, tipo_validacion[0][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[1][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[1][1][1])){
			crearMensajeError(contenido, tipo_validacion[1][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[2][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[2][1][1])){
			crearMensajeError(contenido, tipo_validacion[2][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[3][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[3][1][1])){
			crearMensajeError(contenido, tipo_validacion[3][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[4][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[4][1][1])){
			crearMensajeError(contenido, tipo_validacion[4][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	/*if (tipo == tipo_validacion[5][0] && (contenido[0].value != null && contenido[0].value != "")) {		
		if(!(tipo_validacion[5][1][1])){
			crearMensajeError(contenido, tipo_validacion[5][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}*/
};

function permitidos(){
	validarCaracteresPermitidos('nombre_apellido', $('#nombres'));
	validarCaracteresPermitidos('nombre_apellido', $('#apellidos'));
	validarCaracteresPermitidos('correo', $('#correo'));
	validarCaracteresPermitidos('fecha_nacimiento', $('#fecha_nacimiento'));
	validarCaracteresPermitidos('fecha', $('#fecha_nacimiento'));
}

function validarCorreo(correo) { 
  return /^\w+([\.\+\-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(correo);
}

function validarNombreApellido(nombre){
	return /^[A-Za-zÁÉÍÓÚñáéíóúÑ ]+?$/.test(nombre);
}
 
function existeFecha(fecha) {
    var fechaf = fecha.split("-");
    var d = fechaf[2];
    var m = fechaf[1];
    var y = fechaf[0];

    var fecha_actual = new Date(); 
    var ano_actual = fecha_actual.getFullYear()-100;
    return m > 0 && m < 13 && y > ano_actual && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}

function validarFecha(fecha){
 
	var RegExPattern = /^\d{2,4}\-\d{1,2}\-\d{1,2}$/;
	if ((fecha.match(RegExPattern)) && (fecha!='')) {
		//console.log('entro0');
		if(existeFecha(fecha)){
			//console.log('entro1');
			if(calcularEdad()){
				//console.log('entro2');
				return true;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	} else {
	  return false;
	}
}
/*
function validarFecha(fecha){
	// console.log(fecha);
	return /^(19[5-9][0-9]|20[0-4][0-9]|2050)[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$/.test(fecha);
}*/

function validarNumero(numero){
	return /^[1-5]{1,1}$/.test(numero);
}

$("#ocupaciones").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#listaOcupaciones li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#profesiones").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#listaProfesiones li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#nacionalidades").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#menu1 li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#residencia").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#menu2 li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#competencias").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#menu3 li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

function enviarPclave(ruta){

	window.location = ruta;
}

function validarFormatoDinero(salario){
	return /^[0-9]*\.[0-9][0-9]$/.test(salario);
}

// *******************************RESPUESTAS************************************
if($('.list-group1').length){
	$('.list-group1').draggable({
	    revert: 'invalid',
	    stop: function(){
	        $(this).draggable('option','revert','invalid');
	    }
	  });
}

if($('.caja_origen').length){
	$('.caja_origen').droppable(
    {
      drop: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
          if(droppable.find('ul').length > 0){
            draggable.css({top: '0px', left: '0px'});
          }
          else{
            droppable.removeAttr('class');
            droppable.attr('class', 'caja_origen');
            draggable.appendTo(droppable);
            draggable.css({top: '0px', left: '0px'});
          }
      },
      out: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
        droppable.removeAttr('class');
        droppable.attr('class', 'caja_origen');
      }
    }
  );
}

if($('.caja_destino').length){
	$('.caja_destino').droppable(
    {
      drop: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
          if(droppable.find('ul').length > 0){
            draggable.css({top: '0px', left: '0px'});
          }
          else{
            droppable.find('P').html('');
            droppable.removeAttr('class');
            droppable.attr('class', 'caja_destino');
            draggable.appendTo(droppable);
            draggable.css({top: '0px', left: '0px'});
            crearinputRespuestas();
          }
      },
      out: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
        // console.log('eder'+$(this).find('ul').length);
        if(droppable.find('ul').length <= 0){
          droppable.find('P').html('Arrastre aqui');
          droppable.attr('class', 'caja_destino');
        }
      },
    }
  );
}  
  
// DRAG AND DROP
  function crearinputRespuestas(){
    var contenedor_resp = $('#contenedor_resp');
    var opcion_value = 0;
    var order = 0;
    contenedor_resp.html("");
    var find_destiny = $('.caja_destino');
    for (var i = 0; i < find_destiny.length; i++) {
      order = 0;
      order = $(find_destiny[i]).find('input[name="orden"]');
      if($(find_destiny[i]).find('input[name="opcion"]').length){
        opcion_value = $(find_destiny[i]).find('input[name="opcion"]').val();
      }
      else{
        opcion_value = 0;
      }
        // console.log("orden: "+order.val());
        // console.log("opcion: "+opcion_value);
        var input_opcion = $('<input></input>');
        var input_orden = $('<input></input>');
        input_orden.attr('name', 'respuestas_orden[]');
        input_orden.attr('value', order.val());
        input_orden.css('background-color', 'red');
        input_opcion.attr('name', 'respuestas_opcion[]');
        input_opcion.attr('value', opcion_value)
        contenedor_resp.append(input_orden);
        contenedor_resp.append(input_opcion);
    }
  };

 $('#respuestas_form').on('submit', function(event){
 	if(validarRespuestas() == false){
 		mostrarerror();
 		event.preventDefault();
 	}
 });


function validarRespuestas(){
	var respuestas_insertadas = $('.caja_destino');
	var contador_respuestas = 0;
	for (var i = respuestas_insertadas.length - 1; i >= 0; i--) {
		var respuestas = $(respuestas_insertadas[i]).find('ul');
		if(respuestas.length){
			contador_respuestas++;
		}
	}
	console.log(contador_respuestas+"-----"+respuestas_insertadas.length);
	$return = false;
	if(contador_respuestas == respuestas_insertadas.length){
		$return  = true;
	}
	return $return;
};

function mostrarerror(mensaje_text){
	if (mensaje_text == ''){
		mensaje_text = 'Por favor arrastre todas las opciones del lado izquierdo en los cuadros que se muestran en el lado derecho de acuerdo a su prioridad.';
	}	
	var mensaje = ('<div class="alert alert-danger text-center" role="alert"><h5><b>'+mensaje_text+'</b></h5></div>');
	$('#error_msg').html(mensaje);
}

// $(document).ready(function(){
//   var n = 0;
//   var l = document.getElementById("tiempo");
//   window.setInterval(function(){
//     l.setAttribute('value', n);
//     n++;
//   },1000);
// });
if($('#pre').length){
	if($('#pre').val() <= 1){
		$('#texto_modal').html('Por favor ordene  de 1 a 5  las siguientes oraciones en cada pregunta. <br>(uno es la oración con la que mas se identifica  y 5 es con la que menos se identifica)');
		$('#exampleModal').modal('show');
	}
};

// seleccion de método
// CASILLAS
	$('input[type=radio][name="seleccion"]').change(function() {
		var seleccion_value = this.value;
		var radios = $('input[type=radio][name="seleccion"]');
		for (var i = radios.length - 1; i >= 0; i--) {
			$('#gif_'+(i+1)).removeAttr('class');
		}
		$('#gif_'+seleccion_value).attr('class', 'bounce');
	});


	function crearInputRespuestasSeleccion(){
		var contenedor_resp = $('#contenedor_resp');
		contenedor_resp.html("");
		var opcion;
		var orden;
		var respuestas = $('.respuesta');
		for (var i = 0; i < respuestas.length ; i++) {
			if($(respuestas[i]).find('input[name="opcion[]"]').length){
				opcion = $(respuestas[i]).find('input[name="opcion[]"]').val();
			}

			if($(respuestas[i]).find('input[name="orden[]"]').length){
				orden = $(respuestas[i]).find('input[name="orden[]"]').val();
			}

			var input_opcion = $('<input></input>');
	        var input_orden = $('<input></input>');
	        input_orden.attr('name', 'respuestas_orden[]');
	        input_orden.attr('value', orden);
	        input_orden.css('background-color', 'red');
	        input_opcion.attr('name', 'respuestas_opcion[]');
	        input_opcion.attr('value', opcion);
	        contenedor_resp.append(input_orden);
	        contenedor_resp.append(input_opcion);
		}
	}

	$('input[name="orden[]"]').on('change', function(){
		// validarUnicoChange(this);
		emptyField(this);
		validarCaracteresPermitidos('numero', $(this));
		crearInputRespuestasSeleccion();
	});

	function validarUnicoChange(obj){
		// console.log($(obj).val());
		var valor_change = $(obj).val();
		var inputs = $('input[name="orden[]"]');
		var found = 0;
		for (var i = inputs.length - 1; i >= 0; i--) {
			if(inputs[i] != obj){
				if($(inputs[i]).val() == $(obj).val()){
					found = inputs[i];
					crearMensajeError($(obj), "Valor repetido, por favor revise y vuelva a ingresar un número");
					// console.log($(obj).val());
					break;
					// for (var j = inputs.length - 1; j >= 0; j--) {
					// 	if(inputs[j] != obj){
					// 		if($(inputs[j]).val() == $(obj).val()){
					// 			crearMensajeError(obj, "Valor repetido, por favor revise y vuelva a ingresar un número");
					// 		}
					// 	}
					// }
				}
				else{
					console.log("eder"+found);
					eliminarMensajeError(obj, "");
					eliminarMensajeError(found, "");
				}
			}
		}
	}

	function validarUnico(){
		var inputs = $('input[name="orden[]"]');
		var count = 0;
		for (var i = inputs.length - 1; i >= 0; i--) {
			for (var j = inputs.length - 1; j >= 0; j--) {
				if(inputs[j] != inputs[i] && inputs[j] != ""){
					if($(inputs[j]).val() == $(inputs[i]).val()){
						mostrarerror("Por favor, verifique que no existan valores repetidos.");
						count++;
						break;
					}
				}
			}
		}
		return count;
	}

	if($('#forma_2').length){
		$('#forma_2').on('submit', function(event){
			var input_opcion = $('input[name="orden[]"]');
			ValidarCamposVacios(input_opcion);
			for (var i = input_opcion.length - 1; i >= 0; i--) {
				validarCaracteresPermitidos('numero', $(input_opcion[i]));
			}
			if(errorCountMessage() > 0 || validarUnico() >= 1){
				event.preventDefault();
			}
			// event.preventDefault();
		});
	}

	// $('.label_double_opcion').dblclick(function(){
	// 	alert();
	// });

	$('.text_origen').on('dblclick', function(){
		var destino = $('.text_destino');
		var input = $(this).find('input[name="opcion_double[]"]');
		for (var i = 0; i < destino.length; i++) {
			var ubicar = $(destino[i]).find('label[class="label_double_opcion"]');
				if(ubicar.length <= 0){
					var div = $('<div></div>');
					div.attr('class', 'div_destino');	
					$(destino[i])[0].innerHTML = 
						"<i class='fa fa-times delete_icon' onclick='eliminar_nodo(this)'></i>"+$(this).html();
					break;
				}		
		}
		$(this)[0].innerHTML = "";
		crearInputRespuestasDobleClick();
	});


	function eliminar_nodo(obj){
		var padre = $(obj).parent();
		var label_test = padre.find('label').text();
		var input_value = padre.find('input[name="opcion_double[]"]').val();
		var origen = $('.text_origen');
		var destino = $('.text_destino');
		for (var i = 0; i < origen.length; i++) {
			var ubicar = $(origen[i]).find('label[class="label_double_opcion"]');
				if(ubicar.length <= 0){
					$(origen[i]).html("<label class='label_double_opcion'>"+label_test+"</label><input type='hidden' name='opcion_double[]' value='"+input_value+"'>");
					break;
				}
		}
		for (var i = 0; i < destino.length; i++) {
			console.log("eder");
			console.log($(obj).parent()[0]);
			// if($(obj).parent()[0].length){
				$(obj).parent()[0].innerHTML = "";
			// }
			crearInputRespuestasDobleClick();
		}
	}


	function crearInputRespuestasDobleClick(){
		var contenedor_resp = $('#contenedor_resp');
		contenedor_resp.html("");
		var opcion;
		var orden;
		var respuestas = $('.respuesta');
		for (var i = 0; i < respuestas.length ; i++) {
			opcion = 0;
			orden = 0;
			if($(respuestas[i]).find('input[name="opcion_double[]"]').length){
				opcion = $(respuestas[i]).find('input[name="opcion_double[]"]').val();
				console.log(opcion);
			}

			if($(respuestas[i]).find('input[name="orden_double[]"]').length){
				orden = $(respuestas[i]).find('input[name="orden_double[]"]').val();
			}

			var input_opcion = $('<input></input>');
	        var input_orden = $('<input></input>');
	        input_orden.attr('name', 'respuestas_orden[]');
	        input_orden.attr('value', orden);
	        input_orden.css('background-color', 'red');
	        input_opcion.attr('name', 'respuestas_opcion[]');
	        input_opcion.attr('value', opcion);
	        contenedor_resp.append(input_orden);
	        contenedor_resp.append(input_opcion);
	        contenedor_resp.append("<br>");
		}
	}

	if($('#forma_1').length){
		$('#forma_1').on('submit', function(event){
			if(!validarllenado()){
				event.preventDefault();
				mostrarerror();
			}
		})
	};

	function validarllenado(){
		var respuestas = $('.respuesta').find(('input[name="opcion_double[]"]'));
		if(respuestas.length >= 5){
			for (var i =  0; i < respuestas.length; i++) {
				if($(respuestas[i]).val() != 0){
					return true;
				}
			}
			return false;
		}
	}

// CASILLAS

function validarDocumento(numero,tipo,obj){  
   
  var suma = 0;      
  var residuo = 0;      
  var pri = false;      
  var pub = false;            
  var nat = false;      
  var numeroProvincias = 22;                  
  var modulo = 11;
  var error = 0;
 
  if (numero.length == 0){
    crearMensajeError(obj,"El campo no puede ser vacío");
    //return error = 1;
  } 
  
  

  var expregLN = /[a-zA-Z0-9]{7,}$/i;
  if ((!expregLN.test(numero) && tipo == 3) ){

    crearMensajeError(obj,"Pasaporte inválido");                 
  }
  else if (tipo == 2 && numero.length > 10){ 

    crearMensajeError(obj,"Cédula inválida");             

  }

  /* Verifico que el campo no contenga letras */                    
  if (tipo == 2){
    var expreg = /^[0-9]+$/i;
    provincia = numero.substr(0,2); 
    if(!expreg.test(numero) || (provincia < 1 || provincia > numeroProvincias)){
      crearMensajeError(obj,"Formato inválido");  
      borrarDatos(1);
    }
  }

  if(tipo == 2)
  {
  	var error = false;
  	if (typeof(numero) == 'string' && numero.length == 10 && /^\d+$/.test(numero)) {

		var digitos = numero.split('').map(Number);
		var codigo_provincia = digitos[0] * 10 + digitos[1];

		if (codigo_provincia >= 1 && (codigo_provincia <= 24 || codigo_provincia == 30)) {
		  var digito_verificador = digitos.pop();

		  var digito_calculado = digitos.reduce(
		    function (valorPrevio, valorActual, indice) {
		      return valorPrevio - (valorActual * (2 - indice % 2)) % 9 - (valorActual == 9) * 9;
		    }, 1000) % 10;
		  if(digito_calculado === digito_verificador){
		  	error = true;
		  }
		}

		if(error == false){
			crearMensajeError(obj,"Formato inválido"); 
			borrarDatos(1);  
		}else{
			eliminarMensajeError(obj,"");
		}
	}else{
		crearMensajeError(obj,"La cédula es inválida"); 
		borrarDatos(1);  
	}

	
    ///* Aqui almacenamos los digitos de la cedula en variables. */
    //d1  = numero.substr(0,1);         
    //d2  = numero.substr(1,1);         
    //d3  = numero.substr(2,1);         
    //d4  = numero.substr(3,1);         
    //d5  = numero.substr(4,1);         
    //d6  = numero.substr(5,1);         
    //d7  = numero.substr(6,1);         
    //d8  = numero.substr(7,1);         
    //d9  = numero.substr(8,1);         
    //d10 = numero.substr(9,1);                
    //       
    ///* El tercer digito es: */                           
    ///* 9 para sociedades privadas y extranjeros   */         
    ///* 6 para sociedades publicas */         
    ///* menor que 6 (0,1,2,3,4,5) para personas naturales */ 
    //if (d3==7 || d3==8){    
    //  crearMensajeError(obj,"Formato inválido"); 
    //  borrarDatos();        
    //}       
    //       
    ///* Solo para personas naturales (modulo 10) */         
    //if (d3 < 6){           
    //  nat = true;            
    //  p1 = d1 * 2;  if (p1 >= 10) p1 -= 9;
    //  p2 = d2 * 1;  if (p2 >= 10) p2 -= 9;
    //  p3 = d3 * 2;  if (p3 >= 10) p3 -= 9;
    //  p4 = d4 * 1;  if (p4 >= 10) p4 -= 9;
    //  p5 = d5 * 2;  if (p5 >= 10) p5 -= 9;
    //  p6 = d6 * 1;  if (p6 >= 10) p6 -= 9; 
    //  p7 = d7 * 2;  if (p7 >= 10) p7 -= 9;
    //  p8 = d8 * 1;  if (p8 >= 10) p8 -= 9;
    //  p9 = d9 * 2;  if (p9 >= 10) p9 -= 9;             
    //  modulo = 10;
    //}         
    ///* Solo para sociedades publicas (modulo 11) */                  
    ///* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
    //else if(d3 == 6){           
    //  pub = true;             
    //  p1 = d1 * 3;
    //  p2 = d2 * 2;
    //  p3 = d3 * 7;
    //  p4 = d4 * 6;
    //  p5 = d5 * 5;
    //  p6 = d6 * 4;
    //  p7 = d7 * 3;
    //  p8 = d8 * 2;            
    //  p9 = 0;            
    //}         
    //       
    // Solo para entidades privadas (modulo 11)          
    //else if(d3 == 9) {           
    //  pri = true;                                   
    //  p1 = d1 * 4;
    //  p2 = d2 * 3;
    //  p3 = d3 * 2;
    //  p4 = d4 * 7;
    //  p5 = d5 * 6;
    //  p6 = d6 * 5;
    //  p7 = d7 * 4;
    //  p8 = d8 * 3;
    //  p9 = d9 * 2;            
    //}
    //              
    //suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;                
    //residuo = suma % modulo;                                         
    ///* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
    //digitoVerificador = residuo==0 ? 0: modulo - residuo;                
    ///* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/                         
    //if (pub==true){           
    //  if (digitoVerificador != d9){
    //    crearMensajeError(obj,"Formato inválido"); 
    //    borrarDatos();                               
    //  }                  
    //  /* El ruc de las empresas del sector publico terminan con 0001*/         
    //  if ( numero.substr(9,4) != '0001' ){
    //    crearMensajeError(obj,"Formato inválido"); 
    //    borrarDatos();                         
    //  }
    //}        
    //else if(pri == true){         
    //  if (digitoVerificador != d10){ 
    //    crearMensajeError(obj,"Formato inválido"); 
    //    borrarDatos();                               
    //  }         
    //  if (numero.substr(10,3) != '001' ){ 
    //    crearMensajeError(obj,"Formato inválido");
    //    borrarDatos();                          
    //  }
    //}      
    //else if(nat == true){         
    //  if (digitoVerificador != d10){ 
    //    crearMensajeError(obj,"Formato inválido"); 
    //    borrarDatos();                                
    //  }         
    //  if (numero.length >10 && numero.substr(10,3) != '001' ){
    //    crearMensajeError(obj,"Formato inválido"); 
    //    borrarDatos();                          
    //  }
    //}
  }else if(tipo == 3){
  	eliminarMensajeError(obj,"");
  }

} 

function existeDni(dni){
	var valores = "";
	var puerto_host = $('#puerto_host').val();
	if (dni != "") {		
		$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=RegTest&opcion=buscaDni&dni="+dni,
    		dataType: 'json',
    		async: false,
            success:function(data){
            	valores = data.result;
            	//desbloquearDatos();
            	if(valores != ''){            		
	            	//$('#nombres').val(valores.nombres);
	            	document.getElementById('nombres').value = reemplazar(valores.nombres);
	            	//$('#apellidos').val(valores.apellidos);
	            	document.getElementById('apellidos').value = reemplazar(valores.apellidos);
	            	$('#metodo_resp').val(valores.metodo_resp);
	            	//console.log(reemplazar(valores.apellidos)+'FERNANDA');
	            	$('#correo').val(valores.correo);
	            	$('#fecha_nacimiento').val(valores.fecha_nacimiento.replace(" 00:00:00", ""));
	            	document.getElementById("terminos_condiciones").checked = true;
	            	seleccionado("genero",valores.genero);
	            	seleccionado("estado_civil",valores.estado_civil);
	            	seleccionado("nivel_instruccion",valores.id_escolaridad);
	            	seleccionado("pais",valores.id_nacionalidad);
	            	$('#registro').val('Editar');	            	
								if(valores.id_provincia != ''){
									buscaProvincia(valores.id_nacionalidad,valores.id_provincia);
								}else{
									$('#provincia').html('<option value="">Seleccione una provincia</option>');
									$('#provincia_content').css('display', 'none');
								}
                
	            	$('#profesion').selectpicker('val',valores.id_profesion);
	            	$('#ocupacion').selectpicker('val',valores.id_ocupacion);
	            	seleccionado("provincia_res",valores.id_provincia_res);
	            	ValidarCamposVacios(camposFormulario());
            	}else{            
            		$('#registro').val('Guardar');            		
            		borrarDatos(1);
            	}
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }                  
        })
	}
}

function buscaProvincia(id_nacionalidad,id_provincia){

	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=RegTest&opcion=buscaProvincia&id_pais="+id_nacionalidad,
        dataType:'json',
        success:function(data){
     
            if (data.length == 0){   
            	$('provincia').val('');    	
	            if($('#provincia_content')[0]){
	            	$('#provincia_content')[0].outerHTML = '';
	            }
	            $('#nuevo_div').html('');
            }
            else{
            	
            	if($('#provincia')[0]){
					$('#provincia')[0].outerHTML = '';
				}
            	var html = '<div class="col-md-12" id="provincia_content"><div class="form-group"><label>Provincia de Nacimiento</label><i class="asterisk_red">*</i><select autocomplete="on" class="form-control" name="provincia" id="provincia" onchange="emptyField(this);"></select><div></div></div></div>';
            	$('#nuevo_div').html(html);
            	//console.log('html: '+html);
            	$('#provincia').html('<option value="">Selecciona una provincia</option>');
	            $.each(data, function(index, value) {
	            	var selected = '';
	            	if(index == id_provincia){
	            		selected = 'selected';
	            	}
	                $('#provincia').append("<option "+selected+" value='"+index+"'>"+value+"</option>");
	            });
	            //$('#provincia_content').css('display', '');
            }
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });
    
}

function seleccionado(campo,valor){

	sel = document.getElementById(campo); 
	for (var i = 0; i < sel.length; i++) {
	    var opt = sel[i];
	    if(opt.value == valor){
	    	opt.selected = true;
	    }
	}
}

function borrarDatos(tipo){
	$('#nombres').val('');
	$('#apellidos').val('');
	$('#correo').val('');

	if(tipo==2){
		$('#dni').val('');
	}
	$('#fecha_nacimiento').val('');
	document.getElementById("terminos_condiciones").checked = false;
	seleccionado("genero",1);
	seleccionado("estado_civil",0);
	seleccionado("nivel_instruccion",0);
	seleccionado("pais",0);
	seleccionado("empresa",0);
	$('#provincia').html('<option value="">Selecciona una provincia</option>');
	$('#provincia_content').css('display', 'none');
	seleccionado("profesion",0);
	$('#profesion').selectpicker('refresh');	
  seleccionado("ocupacion",0);
  $('#ocupacion').selectpicker('refresh');	
	seleccionado("provincia_res",0);
}
/*
function desbloquearDatos(){

	$('#dni').removeAttr('disabled');
	$('#nombres').removeAttr('disabled');
	$('#apellidos').removeAttr('disabled');
	$('#correo').removeAttr('disabled');
	$('#fecha_nacimiento').removeAttr('disabled');
	$("#terminos_condiciones").removeAttr('disabled');
	$("#genero").removeAttr('disabled');
	$("#estado_civil").removeAttr('disabled');
	$("#nivel_instruccion").removeAttr('disabled');
	$("#pais").removeAttr('disabled');	
	if(document.getElementById("provincia") && document.getElementById("provincia").value != '0'){
		buscaProvincia($('#pais').val(),$('#provincia').val());
	}else{
		$('#provincia').html('<option value="">Selecciona una provincia</option>');
		$('#provincia_content').css('display', 'none');
	} 
	$("#provincia_res").removeAttr('disabled');
	$("#empresa").removeAttr('disabled');	
	$("#profesion").removeAttr('disabled');
	$("#profesion").selectpicker('refresh');
	$("#ocupacion").removeAttr('disabled');
	$("#ocupacion").selectpicker('refresh');
}*/
/*
$(document).ready(function(){
	if(document.getElementById("documentacion") && document.getElementById("documentacion").value != ''){
		//desbloquearDatos();

	}
});*/

function calcularEdad(){
  var fecha=document.getElementById("fecha_nacimiento").value;
  // Si la fecha es correcta, calculamos la edad
  var values=fecha.split("-");
  var dia = values[2];
  var mes = values[1];
  var ano = values[0];

  // cogemos los valores actuales
  var fecha_hoy = new Date();
  var ahora_ano = fecha_hoy.getYear();
  var ahora_mes = fecha_hoy.getMonth()+1;
  var ahora_dia = fecha_hoy.getDate();

  // realizamos el calculo
  var edad = (ahora_ano + 1900) - ano;
  if ( ahora_mes < mes ){
    edad--;
  }
  if ((mes == ahora_mes) && (ahora_dia < dia)){
    edad--;
  }
  if (edad > 1900){
    edad -= 1900;
  }
  if(edad >= 18){       
    return true;
  }else{
    return false;
  }
}

function reemplazar(texto){
	return texto.replace(/&ntilde;/g, 'ñ').
					replace(/&Ntilde;/g, 'Ñ').
					replace(/&aacute;/g, 'á').
					replace(/&eacute;/g, 'é').
					replace(/&iacute;/g, 'í').
					replace(/&oacute;/g, 'ó').
					replace(/&uacute;/g, 'ú').
					replace(/&Aacute;/g, 'Á').
					replace(/&Eacute;/g, 'É').
					replace(/&Iacute;/g, 'Í').
					replace(/&Oacute;/g, 'Ó').
					replace(/&Uacute;/g, 'Ú').
					replace(/ntilde;/g, 'ñ').
					replace(/Ntilde;/g, 'Ñ').
					replace(/aacute;/g, 'á').
					replace(/eacute;/g, 'é').
					replace(/iacute;/g, 'í').
					replace(/oacute;/g, 'ó').
					replace(/uacute;/g, 'ú').
					replace(/Aacute;/g, 'Á').
					replace(/Eacute;/g, 'É').
					replace(/Iacute;/g, 'Í').
					replace(/Oacute;/g, 'Ó').
					replace(/Uacute;/g, 'Ú')
}
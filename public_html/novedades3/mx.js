/**
* Autor: Notas Delibertad
* Url: http://delibertad.com
* Fuente del proyecto: http://www.delibertad.com/entradas/sistema-de-comentarios-con-ajax.html
* Tipo de licensia: dristibuida, no comercia 
* Año: 2012
* correo: blog@delibertad.com
*/



$(document).ready(function(){

	$('#boton-enviar').click(function(event){

		event.preventDefault();

		
		var id_not =$('#id_not').val();
		var nombre = $('#nombre').val();
		 		  var now = new Date();
                var date_show = now.getDate() + '-' + now.getMonth() + '-' + now.getFullYear() + ' ' + now.getHours() + ':' + + now.getMinutes() + ':' + + now.getSeconds();

		var comentario = $('.editor').val();

		

		if (nombre != '' && comentario != ''){

			$("#mensaje").fadeOut(1000, function(){

				$.post(

						"data.php", 

						{ nombre: nombre, comentario: comentario, now: date_show, id_not: id_not }, 

						function(data) {

							$("#comentarios").append(data);  

				        }, 

				        "html");

				$('#mensaje').text('Comentario agregado!');

			});

			

			

			$('.editor').val('');

			$('#nombre').focus();	

		}

		else{

			alert('Escriba un comentario, por favor');

		}

		

	});

	

});
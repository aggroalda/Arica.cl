// JavaScript Document


$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
		$("#recordarform").validate({
				rules: {
					
					usuario_Txt: "email required",
					password_Txt:"required"
					
				},
				messages: {
					
					usuario_Txt: "*",
					password_Txt:"*"
					
					}
			});
	});

$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
		$("#correo_form").validate({
				rules: {
					
					correo_Txt: "email required"
				},
				messages: {
					correo_Txt:"*"
				}
			});
	});



$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					
					usuario2_Txt:"required",
					nombres_Txt: "required",
					paterno_Txt: "required",
					materno_Txt: "required",
					fecnacimiento_text:"required",
					sexo_text:"required",
					tipodoc_Txt: "required",
					numerodoc_Txt: "required",
					ciudad_Txt: "required",
					direccion_Txt: "required",
					
				},
				messages: {
					
					usuario2_Txt:"Requerido",
					nombres_Txt: "Requerido",
					paterno_Txt: "Requerido",
					materno_Txt: "Requerido",
					fecnacimiento_text: "Requerido",
					sexo_text:"Requerido",
					tipodoc_Txt: "Requerido",
					numerodoc_Txt: "Requerido",
					ciudad_Txt: "Requerido",
					direccion_Txt: "Requerido",
					
					}
			});
	});

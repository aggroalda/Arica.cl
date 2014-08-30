// JavaScript Document// JavaScript Document
$(document).ready(function()
{
	$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$("#correo_form").validate({
				rules: {
					correo_Txt: "required"
				},
				messages: {
					correo_Txt: "*"
	
				}
			});
			
	$("#correo_form").submit(function()
	{
			
		//remove all the class add the messagebox classes and start fading
		$("#msgbox1").removeClass().addClass('messagebox').text('Enviando ...').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("contrasena.php",{ correo_Txt:$('#correo_Txt').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		  	$("#msgbox1").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Exito.. Revise su correo e Ingrese la nueva contraseña ...').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='login.php';
			  });
			  
			});
		  }
		  if (data == 'no') 
		  {
		  	$("#msgbox1").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Correo no Registrado ...').addClass('messageboxerror').fadeTo(900,1);
			});		
          }
		  
		  
			  //add message and change the class of the box and start fading
				  if (data == 'cero') 
		  {
		  	$("#msgbox1").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Ingrese un Correo ...').addClass('messageboxerror').fadeTo(900,1);
			});		
          }  
				
          	
        });
 		return false; //not to post the  form physically
	});
	//now call the ajax also focus move from 
	$("#correo_Txt").blur(function()
	{
		$("#correo_form").trigger('enviar2');
	});
});
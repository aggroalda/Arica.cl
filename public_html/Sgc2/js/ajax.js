function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


function cambiar(){
	//donde se mostrará los registros
	divContenido = document.getElementById('tdR');
	actual=document.getElementById('actual_Txt').value;
	nueva=document.getElementById('nueva_Txt').value;
	repetir=document.getElementById('repetir_Txt').value;
	usuario=document.getElementById('usuario').value;
	
	ajax=objetoAjax();
	
	ajax.open("GET", "cambiar.php?actual="+actual+"&nueva="+nueva+"&repetir="+repetir+"&usuario="+usuario);
	
	divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
	
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			document.getElementById('actual_Txt').value="";
			document.getElementById('nueva_Txt').value="";
			document.getElementById('repetir_Txt').value="";
			divContenido.innerHTML = ajax.responseText;
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax.send(null)
	
}

function cambiarMensaje(){
	//donde se mostrará los registros
	divContenido = document.getElementById('tdR');
	titulo_Txt=document.getElementById('titulo_Txt').value;
	descrip_Txt=document.getElementById('descrip_Txt').value;
	
	ajax=objetoAjax();
	
	ajax.open("GET", "cambiar.php?titulo_Txt="+titulo_Txt+"&descrip_Txt="+descrip_Txt);
	
	divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
	
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			document.getElementById('titulo_Txt').value="";
			document.getElementById('descrip_Txt').value="";
			divContenido.innerHTML = ajax.responseText;
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax.send(null)
	
}

function cambiarMensaje_m(){
	//donde se mostrará los registros
	divContenido = document.getElementById('tdR');
	titulo_Txt=document.getElementById('titulo_Txt').value;
	descrip_Txt=document.getElementById('descrip_Txt').value;
	
	ajax=objetoAjax();
	
	ajax.open("GET", "cambiar_mensaje.php?titulo_Txt="+titulo_Txt+"&descrip_Txt="+descrip_Txt);
	
	divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
	
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			document.getElementById('titulo_Txt').value="";
			document.getElementById('descrip_Txt').value="";
			divContenido.innerHTML = ajax.responseText;
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax.send(null)
	
}

function mostrar(campo) {
	document.getElementById(campo).style.display="table-row-group";
}


function cargar(pagina, division) {
		
				divContenido = document.getElementById(division);
		ajax=objetoAjax();
		ajax.open("GET", pagina);
		// divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divContenido.innerHTML = ajax.responseText
				
			//	window.addEvent('domready', function(){
      // SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
   //  });
			}
		}
		ajax.send(null)
	}

function cargar2(pagina, division) {
		
		divContenido = document.getElementById(division);
		ajax=objetoAjax();
		ajax.open("GET", pagina);
		divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divContenido.innerHTML = ajax.responseText
				window.location.reload();
			}
		}
		ajax.send(null)
	}
function mostrar(campo) {
	document.getElementById(campo).style.display="table-row-group";
}
function ocultar(campo) {
	document.getElementById(campo).style.display="none";
}


function verifyuser(tipo) {

	divContenido = document.getElementById('dvResultado');
	username=document.getElementById('usuario_Txt').value;
	if (tipo>0) idusu=document.getElementById('id_usu').value;
	
	if (username=='') {
		divContenido.innerHTML = "<div class='boxrojo curved'>Ingrese un usuario.</div>";
		document.getElementById('usuario_Txt').focus();
	} else {
			
		ajax=objetoAjax();
		
		if (tipo==0) {
			//alert(numero);
			ajax.open("GET","verificar.php?Username=" + username,true);
		} else {
			//alert(idusu);
			ajax.open("GET","verificar.php?Username=" + username + "&id_usu="+idusu,true);
		}
		
		divContenido.style.display="inline";
		divContenido.innerHTML='<img src="../img/ajax-loader.gif"> Por favor espere ...';
	
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText=="SI") {
					divContenido.style.display="inline";
					divContenido.innerHTML = "<div class='boxrojo curved'>El nombre de usuario ya está en uso.</div>";
					document.getElementById('usuario_Txt').focus();
					document.getElementById('SendForm').disabled = true;
					document.getElementById('trRepetir').style.display="none";
				}
				
				if (ajax.responseText=="IGUAL") {
					document.getElementById('SendForm').disabled = false;
					document.getElementById('dvResultado').style.display="none";
					document.getElementById('trRepetir').style.display="none";
				}
				
				if (ajax.responseText=="NO") {
					divContenido.style.display="inline";
					divContenido.innerHTML = "<div class='boxverde curved'>El nombre de usuario está disponible.</div>";
					document.getElementById('SendForm').disabled = false;			
					document.getElementById('trRepetir').style.display="table-row-group";	
				}
				//mostrar resultados en esta capa
				//divContenido.innerHTML = ajax.responseText;
			}
		}
	ajax.send(null);
	}
}


function cambiarpass() {

confirmar=confirm("\xBFEst\xe1 seguro de cambiar la contrase\xF1a\x3F"); 

	if (confirmar) {	

		divContenido = document.getElementById('dvResultado');
		iduser=document.getElementById('id_usu').value;

		ajax=objetoAjax();
	
		ajax.open("GET","modificar.php?id_user=" + iduser,true);

		divContenido.innerHTML='<img src="../img/ajax-loader.gif"> Por favor espere ...';
		
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//mostrar resultados en esta capa
				divContenido.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)	
		
	}
}
function verifydni(tipo) {
	divContenido = document.getElementById('divDNI');
	numero=document.getElementById('numerodoc_Txt').value;
	if (tipo>0) idusu=document.getElementById('id_usu').value;
	
	if (numero=='') {
		divContenido.innerHTML = "<div class='boxrojo curved'>Ingrese un Número de Documento.</div>";
		document.getElementById('numerodoc_Txt').focus();
	} else {
			
		ajax=objetoAjax();
		
		if (tipo==0) {
			//alert(numero);
			ajax.open("GET","dni.php?DNI=" + numero,true);
		} else {
			//alert(idusu);
			ajax.open("GET","dni.php?DNI=" + numero + "&id_usu="+idusu,true);
		}
		divContenido.style.display="inline";
		divContenido.innerHTML='<img src="../img/ajax-loader.gif"> Por favor espere ...';
	
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText=="SI") {
					divContenido.style.display="inline";
					divContenido.innerHTML = "<div class='boxrojo curved'>Número de Documento usado.</div>";
					document.getElementById('numerodoc_Txt').focus();
					document.getElementById('SendForm').disabled = true;
				} 
				if (ajax.responseText=="IGUAL") {
					document.getElementById('SendForm').disabled = false;
					document.getElementById('divDNI').style.display="none";
				}

				if (ajax.responseText=="NO") {
					divContenido.style.display="inline";
					divContenido.innerHTML = "<div class='boxverde curved'>Número de Documento disponible.</div>";
					document.getElementById('SendForm').disabled = false;
				}
				//mostrar resultados en esta capa
				//divContenido.innerHTML = ajax.responseText;
			}
		}
	
	}
	ajax.send(null);
}



function enviar2(){
	ajax=objetoAjax();
	ajax.open("POST", url, target);
	//ajax.send(null);
}


function stopUpload1(success, zona,pag){

		cargar("listado.php","tabla");
		/*return true();*/
}







function agregar_categoria() {
	
	
	if (document.getElementById('nombre_Txt').value!=""){
	nombre=document.getElementById('nombre_Txt').value;
	orden=document.getElementById('orden').value;
	ajax=objetoAjax();
		
	ajax.open("GET","agregar_proceso.php?nombre=" + nombre+ "&orden="+orden,true);
		
	ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText!="") {
					
					cargar('listado.php','tabla');
				} 
				
				//mostrar resultados en esta capa
				//divContenido.innerHTML = ajax.responseText;
			}
		}
	

	ajax.send(null);
	
	}
	else {
		document.getElementById('nombre_Txt').className="error";
		}
}



function preguntar(id,name,orden) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {
//Aquí pones lo que quieras si da a Aceptar 
cargar('eliminar.php?id_del='+id+'&orden='+orden,'tabla')
 //document.location=('eliminar.php?id_del='+id+'&orden='+orden);
}
} 


function eliminar_rubro() {
	
	confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 
	

	nombre=document.getElementById('nombre_Txt').value;
	orden=document.getElementById('orden').value;
	ajax=objetoAjax();
		
	ajax.open("GET",'eliminar.php?id_del='+id+'&orden='+orden,true);
		
	ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText!="") {
					
					cargar('listado.php','tabla');
				} 
				
				//mostrar resultados en esta capa
				//divContenido.innerHTML = ajax.responseText;
			}
		}
	

	ajax.send(null);
	

	
}








function agregar_categoriaclasificado() {
	
	
	if (document.getElementById('nombre_Txt').value!=""){
	nombre=document.getElementById('nombre_Txt').value;
	orden=document.getElementById('orden').value;
	ajax=objetoAjax();
		
	ajax.open("GET","agregar_proceso.php?nombre=" + nombre+ "&orden="+orden,true);
		
	ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText!="") {
					
					cargar('listado.php','tabla');
				} 
			//mostrar resultados en esta capa
				//divContenido.innerHTML = ajax.responseText;
			}
		}
	

	ajax.send(null);
	
	}
	else {
		document.getElementById('nombre_Txt').className="error";
		}
}


function editar_categoria() {
	
	nombre=document.getElementById('nombre_Txt').value;
	estado=document.getElementById('estado_Txt').value;
	ajax=objetoAjax();
		
	ajax.open("GET","editar_proceso.php?nombre=" + nombre+ "&estado="+estado,true);
		
	ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText!="") {
					
					cargar('listado.php','tabla');
				} 
				
				//mostrar resultados en esta capa
				//divContenido.innerHTML = ajax.responseText;
			}
		}
	

	ajax.send(null);
}



function imagenval(campo){
		
	var val = $("#"+campo).val();

if (!val.match(/(?:gif|jpg|png|JPG|PGN|GIF|swf|SWF)$/) ) {
      
alert("El archivo subido no es una imagen en los formatos aceptados!");
$("#"+campo).attr('value', '');
	
}else {

}
	}
	
	
	
	
	
	
	
	function stopUpload(success, zona){
    //  var result = '';
      //if (success==1){
        // result = "<h2>La transaccion fue realizada satisfactoriamente.</h2>";
      //} else {
        // result = '<h2>Hubo un error!</h2>';
      // }
		//ocultar('form1');
		//mostrar('upload_process');
		//setTimeout('ocultar("upload_process")',1);
     	//document.getElementById('respuesta').innerHTML = result;
		// setTimeout('mostrar("respuesta")',1);
		cargar("listado.php","tabla");
		/*return true();*/
}
	
	
	
	
	function cargar_agregar_categoria(pagina, division) {
		
				divContenido = document.getElementById(division);
		ajax=objetoAjax();
		ajax.open("GET", pagina);
		// divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divContenido.innerHTML = ajax.responseText
				$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					nombre_Txt: "required",
					
				},
				messages: {
					nombre_Txt: "Requerido",
					
					
					}
			});
	});
		
			}
		}
		ajax.send(null)
	}
	


function cargar_noticias(pagina, division) {
		
		divContenido = document.getElementById(division);
		ajax=objetoAjax();
		ajax.open("GET", pagina);
		// divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divContenido.innerHTML = ajax.responseText

 			$.validator.methods.equal = function(value, element, param) {
		return value == param;
	};
	$(document).ready(function(){
				
		$("#form1").validate({
				rules: {
					titulo_Txt: "required",
					fecha_Txt: "required",
					tiposub_Txt:"required",
					nombre_Txt: "required",
					tipo_Txt: "required",
					descripcion_Txt:"required",
				},
				messages: {
					titulo_Txt: "Requerido",
					fecha_Txt: "Requerido",
					tiposub_Txt:"Requerido",
					nombre_Txt: "Requerido",
					tipo_Txt: "Requerido",
					descripcion_Txt: "Requerido",
					
					}
			});
	});

		
			}
		}
		ajax.send(null)
	}
	
	
	function cargar_fotos(pagina, division) {
		
		divContenido = document.getElementById(division);
		ajax=objetoAjax();
		ajax.open("GET", pagina);
		// divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divContenido.innerHTML = ajax.responseText

 

		
			}
		}
		ajax.send(null)
	}
	
	
	

function validaragregarnot()
{ var error= "";
	
		
	if (document.getElementById('titulo_Txt').value==""){
		titulo=document.getElementById('titulo_Txt');
		titulo.className="error";
		error+="Título es requerido.\n";}  else{titulo.className="fuente"}
	if (document.getElementById('desarrollo_Txt').value==""){
		desarrollo= document.getElementById('desarrollo_Txt');
		desarrollo.className="error";
		error+="Desarrollo es requerido.\n";} else{desarrollo.className="fuente"}
	if (document.getElementById('fecha_Txt').value==""){
		fecha= document.getElementById('fecha_Txt');
		fecha.className="error";
		error+="Fecha es requerido.\n";} else{fecha.className="fuente"}
	

if (error!="") 
 { alert('Ocurrieron los siguientes errores:.\n'+error);
return false;}
return true;

} /*fin function validar agregar producto */


function preguntar(id,name,orden) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 
cargar('eliminar.php?id_del='+id+'&orden='+orden,'tabla')

 //document.location=('eliminar.php?id_del='+id+'&orden='+orden);

}





} 




function preguntarempresa(id,name,id_tip) {

confirmar=confirm("Esta seguro de eliminar este empresa: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 
document.location=('eliminar.php?id_del='+id+'&id_tip='+id_tip);

}





} 

function preguntarclasificado(id,name) {

confirmar=confirm("Esta seguro de eliminar este empresa: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 
document.location=('eliminar.php?id_del='+id);

}





} 

function preguntarbanner(id,name) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar.php?id_del='+id);


}




} 








function eliminar_categoria(id,name,orden) {
confirmar=confirm("¿Está seguro de eliminar esta categoría "+ name +"?. Eliminará las noticias relacionadas ."); 
if (confirmar) {
//Aquí pones lo que quieras si da a Aceptar 

return true
// cargar('eliminar_all.php?id_del='+id+'&orden='+orden,'tabla')
// document.location=('eliminar_all.php?id_del='+id+'&orden='+orden);

}
else {return false}
} 


function eliminar_categoria_clasificado(id,name,orden) {
confirmar=confirm("¿Está seguro de eliminar esta categoría "+ name +"?. Eliminará los clasificados relacionados ."); 
if (confirmar) {
//Aquí pones lo que quieras si da a Aceptar 

return true
// cargar('eliminar_all.php?id_del='+id+'&orden='+orden,'tabla')
// document.location=('eliminar_all.php?id_del='+id+'&orden='+orden);

}
else {return false}
} 













function preguntarnovedad(id,name) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar.php?id_del='+id);


}




} 


function preguntarNoticias(id,name) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar.php?id_del='+id);


}




}


function preguntarNoticias_Get(id,name,id_cat_cat) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar_get_categoria.php?id_del='+id +'&id_cat_cat='+ id_cat_cat);


}




}


function preguntarArticulos(id,name) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar.php?id_del='+id);


}




}

function preguntarArticulos2(id,name,id_sub_tip) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar_get_cat.php?id_del='+id +'&id_sub_tip='+id_sub_tip);


}
}


function preguntarproducto(id,name,orden) {

confirmar=confirm("Esta seguro de eliminar este producto: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('../productos/eliminar.php?id_del='+id+'&orden='+orden);


}


} 




function preguntarsub(id,name) {

confirmar=confirm("Esta seguro de eliminar esta subcategoria: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=("eliminar_sub.php?id_del="+id)

}




} 


function preguntarfoto(id,foto,not) {

confirmar=confirm("Esta seguro de eliminar la foto "+foto+"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=("eliminarfoto.php?id_del="+id+"&id_not="+not)

}

} 

function preguntarfoto_get_categoria(id,foto,not) {

confirmar=confirm("Esta seguro de eliminar la foto "+foto+"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=("eliminarfoto_get_categoria.php?id_del="+id+"&id_not="+not)

}

} 



function preguntarcolor(id,color,pro) {

confirmar=confirm("Esta seguro de eliminar el color "+color+"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=("eliminarcolor.php?id_delpro="+id+"&id_procol="+pro)

}

} 



function dni(num,div) {
		
		division = document.getElementById(div);
		numero = document.getElementById(num);
		
		if (numero.value=='') {
			division.style.display='none'; 
		} else {
			ajax=objetoAjax();
			
				ajax.open("GET","../includes/cedula.php?cedula=" + numero.value);
			
			division.style.display='';
			division.innerHTML='<img src="../img/ajax-loader.gif">';
		
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					
					if (ajax.responseText=="SI") {
						division.innerHTML = '<div class="errorbox">Número de Documento usado</div>';
						setTimeout('numero.focus()',75);
					} 
					if (ajax.responseText=="IGUAL") {
						division.style.display='none';
					}
	
					if (ajax.responseText=="NO") {
						division.style.display='';
						division.innerHTML = "<div class='verdebox'>Número de Documento disponible.</div>";
						setTimeout('division.style.display="none"',1750);
					}
				}
		
			}
			ajax.send(null);
		}
}
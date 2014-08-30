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
	
	ajax=objetoAjax();
	
	ajax.open("GET", "cambiar.php?actual="+actual+"&nueva="+nueva+"&repetir="+repetir);
	
	//divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
	
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

function mostrar(campo) {
	document.getElementById(campo).style.display="table-row-group";
}


function cargar(pagina, division) {
		
		divContenido = document.getElementById(division);
		ajax=objetoAjax();
		ajax.open("GET", pagina);
		
		//divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divContenido.innerHTML = ajax.responseText
						
	/*		 window.addEvent('domready', function(){
      SexyLightbox = new SexyLightBox({color:'black', dir: '../img/'});
    });		*/
	$("#form1").validate({
				rules: {
					
					usuario2_Txt: "email required",
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
					
					usuario2_Txt: "Requerido",
					nombres_Txt: "Requerido",
					paterno_Txt: "Requerido",
					materno_Txt: "Requerido",
					fecnacimiento_text:"Requerido",
					sexo_text:"Requerido",
					tipodoc_Txt: "Requerido",
					numerodoc_Txt: "Requerido",
					ciudad_Txt: "Requerido",
					direccion_Txt: "Requerido",
					
					}
			});
				
			}
		}
		ajax.send(null)
	}

function cargar2(pagina, division) {
		
		divContenido = document.getElementById(division);
		ajax=objetoAjax();
		ajax.open("GET", pagina);
		//divContenido.innerHTML='<img src="../img/ajax-loader.gif">';
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
	username=document.getElementById('usuario2_Txt').value;
	
	
	if (tipo>0) idusu=document.getElementById('id_usu').value;
	
	if (username=='') {
		divContenido.innerHTML = "<div class='boxrojo curved'>Ingrese un usuario.</div>";
		document.getElementById('usuario2_Txt').focus();
	} else {
			
		ajax=objetoAjax();
		
		if (tipo==0) {
			//alert(numero);
			ajax.open("GET","../usuarios/verificar.php?Username=" + username,true);
		} else {
			//alert(idusu);
			ajax.open("GET","../usuarios/verificar.php?Username=" + username + "&id_usu="+idusu,true);
		}
		
		divContenido.style.display="inline";
		divContenido.innerHTML='<img src="../img/ajax-loader.gif"> Por favor espere ...';
	
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText=="SI") {
					divContenido.style.display="inline";
					divContenido.innerHTML = "<div class='boxrojo curved'>El nombre de usuario ya est&aacute; en uso.</div>";
					document.getElementById('usuario2_Txt').focus();
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
					divContenido.innerHTML = "<div class='boxverde curved'>El nombre de usuario est&aacute; disponible.</div>";
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


function verifydni(tipo) {
	divContenido = document.getElementById('divDNI');
	numero=document.getElementById('numerodoc_Txt').value;
	if (tipo>0) idusu=document.getElementById('id_usu').value;
	
	if (numero=='') {
		divContenido.innerHTML = "<div class='boxrojo curved'>Ingrese un N&uacute;mero de Documento.</div>";
		document.getElementById('numerodoc_Txt').focus();
	} else {
			
		ajax=objetoAjax();
		
		if (tipo==0) {
			//alert(numero);
			ajax.open("GET","../usuarios/dni.php?DNI=" + numero,true);
		} else {
			//alert(idusu);
			ajax.open("GET","../usuarios/dni.php?DNI=" + numero + "&id_usu="+idusu,true);
		}
		divContenido.style.display="inline";
		//divContenido.innerHTML='<img src="../img/ajax-loader.gif"> Por favor espere ...';
	
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				if (ajax.responseText=="SI") {
					divContenido.style.display="inline";
					divContenido.innerHTML = "<div class='boxrojo curved'>N&uacute;mero de Documento usado.</div>";
					document.getElementById('numerodoc_Txt').focus();
					document.getElementById('SendForm').disabled = true;
				} 
				if (ajax.responseText=="IGUAL") {
					document.getElementById('SendForm').disabled = false;
					document.getElementById('divDNI').style.display="none";
				}

				if (ajax.responseText=="NO") {
					divContenido.style.display="inline";
					divContenido.innerHTML = "<div class='boxverde curved'>N&uacute;mero de Documento disponible.</div>";
					document.getElementById('SendForm').disabled = false;
				}
				//mostrar resultados en esta capa
				//divContenido.innerHTML = ajax.responseText;
			}
		}
	
	}
	ajax.send(null);
}


function seleccionado(element) {
    document.getElementById("menu").getElementsByClassName("selec")[0].className = "";
    element.className = "selec";
}
function seleccionadoclasificado(element) {
    document.getElementById("clasificados").getElementsByClassName("selec")[0].className = "";
    element.className = "selec";
}




function mostrarclasificado(element) {
	
    document.getElementById("divclasificados").getElementsByClassName("visible")[0].className = "oculto";
    //element.ClassName="visible";
	document.getElementById(element).className="visible";
// mostrar(element);

}


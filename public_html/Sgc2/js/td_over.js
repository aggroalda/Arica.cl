function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");

}



function addLoadEvent(func) {

  var oldonload = window.onload;

  if (typeof window.onload != 'function') {

    window.onload = func;

  } else {

    window.onload = function() {

      oldonload();

      func();

    }

  }

}



function addClass(element,value) {

  if (!element.className) {

    element.className = value;

  } else {

    newClassName = element.className;

    newClassName+= " ";

    newClassName+= value;

    element.className = newClassName;

  }

}





function stripeTables() {

	var tbodies = document.getElementsByTagName("tbody");

	for (var i=0; i<tbodies.length; i++) {

		var odd = true;

		var rows = tbodies[i].getElementsByTagName("tr");

		for (var j=0; j<rows.length; j++) {

			if (odd == false) {

				odd = true;

			} else {

				addClass(rows[j],"odd");

				odd = false;

			}

		}

	}

}



function highlightRows() {

  if(!document.getElementsByTagName) return false;

  var tbodies = document.getElementsByTagName("tbody");

  for (var j=0; j<tbodies.length; j++) {

      var rows = tbodies[j].getElementsByTagName("tr");

      for (var i=0; i<rows.length; i++) {

		rows[i].oldClassName = rows[i].className

				rows[i].onmouseover = function() {

				  addClass(this,"highlight");

				}

				rows[i].onmouseout = function() {

				  this.className = this.oldClassName

				}

      }

   }

}

function lockRow() {

	var tbodies = document.getElementsByTagName("tbody");

	for (var j=0; j<tbodies.length; j++) {

		var rows = tbodies[j].getElementsByTagName("tr");

		for (var i=0; i<rows.length; i++) {

			rows[i].oldClassName = rows[i].className

			rows[i].onclick = function() {

				if (this.className.indexOf("selected") != -1) {

					this.className = this.oldClassName;

				} else {

					addClass(this,"selected");

				}

			}

		}

	}

}



addLoadEvent(stripeTables);

addLoadEvent(highlightRows);

addLoadEvent(lockRow);

//-->



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


/*function preguntar(id,name,orden) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar.php?id_del='+id+'&orden='+orden);


}




} 
*/









function preguntarbanner(id,name) {

confirmar=confirm("Esta seguro de eliminar este item: "+ name +"?"); 

if (confirmar) {

//Aquí pones lo que quieras si da a Aceptar 

document.location=('eliminar.php?id_del='+id);


}




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
			division.innerHTML='<img src="../../0_SOURCE/SGC_INTERNET/img/ajax-loader.gif">';
		
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




/***********************************************
* Cool DHTML tooltip script II- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetfromcursorX=12 //Customize x offset of tooltip
var offsetfromcursorY=10 //Customize y offset of tooltip

var offsetdivfrompointerX=10 //Customize x offset of tooltip DIV relative to pointer image
var offsetdivfrompointerY=14 //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

document.write('<div id="dhtmltooltip"></div>') //write out tooltip DIV
document.write('<img id="dhtmlpointer" src="../../0_SOURCE/SGC_INTERNET/img/arrow2.gif">') //write out pointer image

var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

var pointerobj=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thewidth, thecolor){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var nondefaultpos=false
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20

var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY

var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth){
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=curX-tipobj.offsetWidth+"px"
nondefaultpos=true
}
else if (curX<leftedge)
tipobj.style.left="5px"
else{
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetfromcursorX-offsetdivfrompointerX+"px"
pointerobj.style.left=curX+offsetfromcursorX+"px"
}

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px"
nondefaultpos=true
}
else{
tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
pointerobj.style.top=curY+offsetfromcursorY+"px"
}
tipobj.style.visibility="visible"
if (!nondefaultpos)
pointerobj.style.visibility="visible"
else
pointerobj.style.visibility="hidden"
}
}

//function sendNotify(){
// 				 $("#span").append("<div class='notify'><p><a href='#' class='closeNotify'>X</a><a 			 				href='#' id='p_noti'>Nueva alerta creada</a><p></div>");
//				}
//
//				$("#sendNotify").click(function () { 
//				  sendNotify();
//				  return false;
//				});
//
//
//				$(".closeNotify").live("click", function(){
//					$(this).parent().parent().hide("slow");
//					return false;
//				});


function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
pointerobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

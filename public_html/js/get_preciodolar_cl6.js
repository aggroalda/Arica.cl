feed=document.getElementById('preciodolar-cl6');
if (feed)
	{
	var valfeed = 'no';
	if (!feed.links)
		{
		feed.links = feed.getElementsByTagName('a');
		}
	for (var t=0; t<feed.links.length; t++)
		{
		var valProv = feed.links[t]; if (valProv.href.search('http://www.preciodolar.com/') != -1)
			{
			if(valProv.getAttribute('rel') == 'nofollow')
				{
				} else {
				valfeed='si'; break;
				} 
			} 
		}
	}
	
	

if(feed&&valfeed=='si')
{
while(feed.firstChild){feed.removeChild(feed.firstChild)};
feed.style.cssText='background:transparent;background-color:transparent;overflow:hidden;';
marko=document.write('<IFRAME SRC="http://www.preciodolar.com/preciodolar_cl.php?get=6" TITLE="Dolar"  WIDTH=50  ALIGN=bottom FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no NAME=COP-USD1 ALLOWTRANSPARENCY="true"></IFRAME>');
marko=document.createElement('font');
marko.id='check';
feed.appendChild(marko);
}
else {alert("ERROR: PRECIO DEL DOLAR\n------------------------------------------------------------------------------------------------------------\nEl código introducido no es correcto\nVerifica tu código en: http://www.preciodolar.com\n\n* Recuerda que no se permite editar el codigo.\n\n- Asegúrate de copiarlo tal cual como aparece en nuestro sitio web.\n- Actualiza tu código por el mas reciente.");}
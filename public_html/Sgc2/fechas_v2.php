<!-- Code by Omar Galaviz
		---Javascript/Jquery
-->
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<select id="searchby" name="searchby">
	<option value="%" selected>%</option>
	<option value="dia" >Dia</option>
	<option value="mes" >Mes</option>
	<option value="ano" >Año</option>					
</select>


			<div id="x_list_input_3_bf">	
					<span class='dia' style='display:none'>Dia</span>
					<select style='display:none' class="dia" id='dia'name="dia">
					<option value="%" selected>%</option>
					</select>
					
					<span class='mes' style='display:none'>Mes</span>
					<select style='display:none' class="mes" id='mes'name="mes">
					<option value="%" selected>%</option>
					</select>

					<span class='ano' style='display:none'>Año</span>
					<select style='display:none' class="ano" id='ano' name="ano">
					<option value="%" selected>%</option>
					</select>								
					
				</div>
			<form>

<script type="text/javascript">

$(document).ready(function () {
var i,j; //contadores
		var array_month_nb = new Array(12); // array para meses no bisiesto
									array_month_nb["Ene"] =31; 
									array_month_nb["Feb"] =29; 
									array_month_nb["Mar"] =31; 
									array_month_nb["Abr"] =30; 
									array_month_nb["May"] =31; 
									array_month_nb["Jun"] =30; 
									array_month_nb["Jul"] =31; 
									array_month_nb["Ago"] =31; 
									array_month_nb["Sep"] =30; 
									array_month_nb["Oct"] =31; 
									array_month_nb["Nov"] =30; 
									array_month_nb["Dic"] =31; 
												
		var array_month_b = new Array(12); //array para meses  bisiesto
									array_month_b["Ene"] =31; 
									array_month_b["Feb"] =28; 
									array_month_b["Mar"] =31; 
									array_month_b["Abr"] =30; 
									array_month_b["May"] =31; 
									array_month_b["Jun"] =30; 
									array_month_b["Jul"] =31; 
									array_month_b["Ago"] =31; 
									array_month_b["Sep"] =30; 
									array_month_b["Oct"] =31; 
									array_month_b["Nov"] =30; 
									array_month_b["Dic"] =31; 

		var fecha = new Date(); 
		var ano = fecha.getFullYear(); 
		var mes = fecha.getMonth(); 		
		var dia = fecha.getDate();
		
$('#searchby').change (function () {
	var select = $('#searchby').val();

	if (select == 'dia') {
		fill_month(ano);
		$(".dia").show();
		$(".mes").hide();
		$(".ano").hide();

	
	}	if (select == 'mes') {
		obj = 1;
		fill_month(ano,obj);
		$(".dia").show();
		$(".mes").show();
		$(".ano").hide();

	
	}	if (select == 'ano') {
		fill_year();	
		$(".dia").show();
		$(".mes").show();
		$(".ano").show();
		
	
	}if (select == '%') {	
		$(".dia").hide();
		$(".mes").hide();
		$(".ano").hide();
		
	
	}
}); 


var fill_year = function () {
			$('#ano').empty();
							$('<option value="%">%</option>').appendTo('#ano');
			for ( i = ano; i >= 1980; i--) {
							$('<option value='+i+'>'+i+'</option>').appendTo('#ano');
					}
$('#ano').change(function () {
		var ano = $('#ano').val();
			obj=1;
			fill_month(ano, obj);	
		});
}	

		
			

var fill_month = function (ano, obj) {
	$('#mes').empty();
	$('#dia').empty();
	if ((ano % 4 == 0) && ((ano % 100 != 0) || (ano % 400 == 0))) //comprobación de biciesto
				{
					var array_meses = array_month_b;
				}
			else 
				{
					var array_meses = array_month_nb;
				}
				
				if ((typeof ano != 'undefined') && (obj==1)) {
						$('<option value="%">%</option>').appendTo('#mes');
						$('<option value="%">%</option>').appendTo('#dia');

							for(var clave in array_meses) {
																			
								$('<option value='+array_meses[clave]+' >'+clave+'</option>').appendTo('#mes');
								
																
							}
							$('#mes').change(function () {
												var dia = $('#mes').val();
													
													obj=1;
													fill_days(dia);	
												});		
				} else {
				$('<option value="%">%</option>').appendTo('#dia');
							j=0;
							
							for(var clave in array_meses) {
									if (j == mes) {
									
											var count_days = array_meses[clave];
											for ( i = 1; i <= count_days; i++){
												$('<option value='+i+' >'+i+'</option>').appendTo('#dia');
											}
									}										
								j++;				
							}


							
				}
				
}


var fill_days = function (dia) {
	$('#dia').empty();
						for(i = 1; i <= Number(dia); i++){
																		
							$('<option value='+i+' >'+i+'</option>').appendTo('#dia');
											
						}				
				}				
}); 


</script>

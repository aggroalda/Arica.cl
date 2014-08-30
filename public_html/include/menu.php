<? include('../Connections/cnx_arica.php');?>
<style type="text/css">
* { margin:0;
    padding:0;
}

div#menu {
 
    left:0px;
    width:100%;
}
</style>

<div id="menu">
    <ul class="menu">
    
         <? 	mysql_select_db($database_cnx_arica, $cnx_arica);
		 		$query_rsNoticias = "SELECT *  FROM categoria";
				$rsNoticias = mysql_query($query_rsNoticias, $cnx_arica) or die(mysql_error());
				$row_rsNoticias = mysql_fetch_assoc($rsNoticias);
				$totalRows_rsNoticias = mysql_num_rows($rsNoticias); 
		?>           
        
        <li><a href="../novedades/index.php?ver=noticias" class="parent"><span>Noticia</span></a>
            <div><ul>          
            	  <? do{  ?>
    	<li><a  href="../novedades/index.php?id_tip=<? echo $row_rsNoticias['Id_Categoria'];?>"><span><?php echo utf8_encode($row_rsNoticias['Nombre_Cat']); ?></span></a></li>
        <? } while($row_rsNoticias=mysql_fetch_assoc($rsNoticias))?>
               
            </ul></div>
        </li>
           
           <!-- Empieza Botones Rubros-->
		   <? 	
		  		$query_rsRubro = "SELECT * FROM empresa_rubro WHERE Estado_Rubro = 1 ORDER BY Nombre_Rubro";
				$rsRubro = mysql_query($query_rsRubro, $cnx_arica) or die(mysql_error());
				$row_rsRubro = mysql_fetch_assoc($rsRubro);
				$totalRows_rsRubro = mysql_num_rows($rsRubro); 						    
		?>	
        
          <? do{  
		 	    $id_rubro = $row_rsRubro['Id_Rubro'];	
			    if($id_rubro!=''){	  		
				$query_rsSubRubro = "SELECT * FROM empresa_rubro_sub WHERE Rubro_Sub_Estado = 1 AND Rubro_Id = ".$id_rubro." ORDER BY Rubro_Sub_Nombre" ;
				$rsSubRubro = mysql_query($query_rsSubRubro, $cnx_arica) or die(mysql_error());
				$row_rsSubRubro = mysql_fetch_assoc($rsSubRubro);
				$totalRows_rsSubRubro = mysql_num_rows($rsSubRubro); 		
				?>
        <li><a href="#"><span><?php echo utf8_encode($row_rsRubro['Nombre_Rubro']); ?></span></a>
        
            <div><ul>
          
            	<? do{ 
				$id_sub_rubro = $row_rsSubRubro['Rubro_Sub_Id'];			
				if($id_sub_rubro!=''){
				$query_rsEmpresa = "SELECT *  FROM empresa WHERE Estado_Emp = 1 AND Rubro_Sub_Id = ".$id_sub_rubro;
				$rsEmpresa = mysql_query($query_rsEmpresa, $cnx_arica) or die(mysql_error());
				$row_rsEmpresa = mysql_fetch_assoc($rsEmpresa);
				$totalRows_rrsEmpresa = mysql_num_rows($rsEmpresa); 
				
				$query_rsCompara = "SELECT *  FROM empresa_rubro_sub, empresa_rubro WHERE empresa_rubro_sub.Rubro_Id = empresa_rubro.Id_Rubro AND empresa_rubro.Id_Rubro = ".$id_rubro;
				$rsCompara = mysql_query($query_rsCompara, $cnx_arica) or die(mysql_error());
				$row_rsCompara = mysql_fetch_assoc($rsCompara);
				$totalRows_rsCompara = mysql_num_rows($rsCompara); 						
				
				 ?>
                 <?php if($totalRows_rsCompara>0){?>
                <li><a href="#" class="parent"><span><?php echo utf8_encode($row_rsSubRubro['Rubro_Sub_Nombre']); ?></span></a>
                    <div><ul>
                     	 <? do{  ?>
                        <li><a href="../empresas/detalle.php?id_emp=<? echo $row_rsEmpresa{'Id_Empresa'}; ?>&id_rub=<? echo $id_rubro; ?>&id_usu=<? echo $_SESSION['MM_IdUser']; ?>"><span><?php echo utf8_encode($row_rsEmpresa['Nombre_Emp']); ?></span></a></li>
                        <? } while($row_rsEmpresa=mysql_fetch_assoc($rsEmpresa))?>
                        
                    </ul></div>
                </li>   
                <?php } ?>
                <? }?>             
             	 <? } while($row_rsSubRubro=mysql_fetch_assoc($rsSubRubro))?>
                
            </ul></div>
            
        </li>
        <? } ?>
         <? } while($row_rsRubro=mysql_fetch_assoc($rsRubro))?>
      
     
       <!-- Termina Botones Rubros-->      
             
    </ul>
</div>
<div id="copyright" style="display:none">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/td_over.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
 <? for ($i=1;$i<=$_GET['cantidad'];$i++) { ?> 
                <tr>
                  <td width="38%" align="right" valign="top" class="fuente" ><strong>Foto <? echo $i; ?></strong></td>
                  <td width="62%" align="left" class="fuente" ><label>
                    <input name="archivo_fot[<?=$i?>]" type="file" class="fuente" id="archivo_fot[<?=$i?>]" onChange="return imagenval(this.id)"   >
                  </label></td>
                </tr>
                <tr>
                  <td width="38%" align="right" valign="top" class="fuente" ><strong>Descripci&oacute;n Foto<? echo $i; ?></strong></td>
                  <td width="62%" align="left" class="fuente" ><label for="descripcion_Txt"></label>
                    <input type="text" name="descripcion_Txt[<?=$i?>]"  title="Decripción de la Imagen <?=$i?>"id="descripcion_Txt[<?=$i?>]"></td>
                </tr>
                <? } ?>
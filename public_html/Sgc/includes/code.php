<?
  $password="";
    $ptrn1=$ptrn2=$ptrn3="0123456789";
    $length=strlen($ptrn3);
    $contador=0;
    $lenght_p3 = strlen($ptrn3);
    while($contador<$lenght_p3){
        $largo = strlen($ptrn1);
        $matriz[$contador]=substr($ptrn1,0,1);
        $ptrn1=substr($ptrn1,1,$largo-1);
        $contador++;
    }
    $lenght_p3 = strlen($ptrn3);
    $i=0;
    while($i<5){
        $largo=strlen($ptrn2);
        $contador=0;
        $value= substr($ptrn2,rand(0,$largo-1),1);
        while($contador<$lenght_p3){
            if($value == $matriz[$contador])
                $nro=$contador;
            $contador++;
        }
        $valor=$largo-($nro);
        $ptrn2=substr($ptrn2,0,$nro).substr($ptrn2,$nro+1,$valor);
        $ptrn4=$ptrn2;
        $codigo.=$value;
        $c=0;
        while($c<$largo){
            $matriz[$c]=substr($ptrn4,0,1);
            $ptrn4=substr($ptrn4,1,$largo-1);
            $c++;
        }
        $i++;
    }
?>
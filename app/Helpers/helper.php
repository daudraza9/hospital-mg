<?php

function Substring($string)
{
        $length = strlen($string);
        $array = [];
        $count=0;
        for($i=0;$i<$length;$i++){

            for ($j=$i;$j<$length;$j++){

                if($array[$string[$j]]){
                    break;
                }else{
                    $count = max($count,$j-$i+1);
                    $array[$string[$j]];
                }
            }
            $array[$string[$i]];
        }
        return $count;
}

function subArray($array){

        $length = count($array);
        $extra=[];
        $max = 0;
        $min=0;

        for ($i=0;$i<$length;$i++){
            $min=$min+$array[$i];

            if($min < 0){
                $min=0;
            }
            elseif ($max<$min){
                $max=$min;
                echo $extra[$i] = $max;
            }
        }
return $max;
}

function profit($array,$k){
    $size = count($array);
    if($size == 0 || $size == 1){
        return 0;
    }
    $min = $array[0];
    $maxProfit =0;

    for ($i=0;$i<$k;$i++){  //7

        for ($j=0;$j<$size;$j++){ //2

            if($array[$j] > $min){
                $maxProfit = $maxProfit + $min;
            }else{
                $array[$j] = $min;
            }
        }

    }
    return $maxProfit;
}

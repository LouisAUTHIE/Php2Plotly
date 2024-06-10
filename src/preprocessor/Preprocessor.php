<?php
namespace Php2plotly\preprocessor;

class Preprocessor{
    public static function countNumberByInterval(array $data, int $intervalCount):array{
        $values = [];
        $intervalLabels = [];

        $min = min($data);
        $max = max($data);


        $interval = ($max - $min) / $intervalCount;

        
        for($i = 0; $i < $intervalCount; $i++){
            if($i == 0){
            $intervalLabels[] = "[".$min.", ".($min + $interval)."]";
            }
            else if($i == $intervalCount - 1){
                $intervalLabels[] = "]".($min + $interval * ($i)).", ".$max."]";
            }
            else{
                $intervalLabels[] = "]".($min + $interval * $i).", ".($min + $interval * ($i + 1))."[";
            }

            $count = 0;
            if($i==0){
                $count++;
            }
            foreach($data as $d){
                if($d > $min + $interval * $i && $d <= $min + $interval * ($i + 1)){
                    $count++;
                }
            }
            
            $values[] = $count;
        }
        
        return ["x"=>$intervalLabels, "y"=>$values];
    }
}
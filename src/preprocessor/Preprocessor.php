<?php
namespace Php2plotly\preprocessor;

class Preprocessor{
    public static function pearsonCorrelation(array $x, array $y):float{
        $n = count($x);
        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumX2 = 0;
        $sumY2 = 0;
        $sumXY = 0;
        for($i = 0; $i < $n; $i++){
            $sumX2 += $x[$i] * $x[$i];
            $sumY2 += $y[$i] * $y[$i];
            $sumXY += $x[$i] * $y[$i];
        }
        return ($n * $sumXY - $sumX * $sumY) / sqrt(($n * $sumX2 - $sumX * $sumX) * ($n * $sumY2 - $sumY * $sumY));
    }

    public static function buildArrayForPearsonCorrelationMatrix(array $data):array{
        $n = count($data);
        $matrix = [];
        for($i = 0; $i < $n; $i++){
            $matrix[] = [];
            for($j = 0; $j < $n; $j++){
                $matrix[$i][] = self::pearsonCorrelation($data[$i], $data[$j]);
            }
        }
        return $matrix;
    }

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

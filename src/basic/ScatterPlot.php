<?php

namespace Php2Plotly\basic;

class ScatterPlot{
    private string $plot;
    private array $traces= [];
    
    const TYPE = 'scatter';

    public function __construct(private string $divId, private array $data = []){
        $this->plot = '';
    }

    public function setData(array $data):self{
        $this->data = $data;
        return $this;
    }

    private function generateTrace(array $x, array $y, string $mode):void{
        $traceName = 'trace'.uniqid();
        $strTrace = "
        var ".$traceName." = {"
        ."\n x: [".implode(',', $x)."],"
        ."\n y: [".implode(',', $y)."],"
        ."\n mode: '$mode',"
        ."\n type: '".$this::TYPE."'"
        ."\n};";

        $this->traces[] = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function plot():string{
        foreach($this->data as $d){
            $this->generateTrace($d['x'], $d['y'], $d['mode']);
        }
        $this->plot .= implode('', array_map(fn($t) => $t['string'], $this->traces));
        $this->plot .= "var data = [".implode(',', array_map(fn($t) => $t['name'], $this->traces))."];";
        $this->plot .= "Plotly.newPlot('".$this->divId."', data);";
        return $this->plot;
    }
}


?>

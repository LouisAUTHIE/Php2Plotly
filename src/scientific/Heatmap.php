<?php

namespace Php2plotly\scientific;

class Heatmap{
    private string $plot;
    private array $traces;
    
    const TYPE = 'heatmap';

    public function __construct(private string $divId, private array $data = []){
        $this->plot = '';
    }

    public function setData(array $data):self{
        $this->data = $data;
        return $this;
    }

    private function generateTrace(array $x, array $y, array $z):void{
        $traceName = 'trace'.uniqid();
        $zStr = "";
        foreach($z as $zArr){
            //If not first element, add a comma
            if($zStr != "") $zStr .= ", ";
            $zStr .= "[".implode(', ', $zArr)."]";
        }
        $strTrace = "
        var ".$traceName." = [{"
        ."\n z: [".$zStr."],"
        ."\n x: ['".implode('\',\'', $x)."'],"
        ."\n y: ['".implode('\',\'', $y)."'],"
        
        ."\n type: '".$this::TYPE."',"
        ."\n hoverongaps: false"
        ."\n}];";

        $this->traces = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function render():string{
        $this->generateTrace($this->data['x'], $this->data['y'], $this->data['z']);
        $this->plot .= $this->traces['string'];
        $this->plot .= "Plotly.newPlot('".$this->divId."', ".$this->traces['name'].");";
        return $this->plot;
    }
}
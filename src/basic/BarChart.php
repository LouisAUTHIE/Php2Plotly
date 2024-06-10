<?php

namespace Php2plotly\basic;

class BarChart{
    private string $plot;
    private array $traces;
    
    const TYPE = 'bar';

    public function __construct(private string $divId, private array $data = []){
        $this->plot = '';
    }

    public function setData(array $data):self{
        $this->data = $data;
        return $this;
    }

    private function generateTrace(array $x, array $y):void{
        $traceName = 'trace'.uniqid();
        $strTrace = "
        var ".$traceName." = [{"
        ."\n x: ['".implode('\',\'', $x)."'],"
        ."\n y: [".implode(',', $y)."],"
        ."\n type: '".$this::TYPE."'"
        ."\n}];";

        $this->traces = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function render():string{
        $this->generateTrace($this->data['x'], $this->data['y']);
        $this->plot .= $this->traces['string'];
        $this->plot .= "Plotly.newPlot('".$this->divId."', ".$this->traces['name'].");";
        return $this->plot;
    }
}


?>

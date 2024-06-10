<?php

namespace Php2plotly\stats;

class Histogram{
    private string $plot;
    private array $traces;
    
    const TYPE = 'histogram';

    public function __construct(private string $divId, private array $data = []){
        $this->plot = '';
    }

    public function setData(array $data):self{
        $this->data = $data;
        return $this;
    }

    private function generateTrace(array $x):void{
        $traceName = 'trace'.uniqid();
        $strTrace = "
        var ".$traceName." = [{"
        ."\n x: ['".implode('\',\'', $x)."'],"
        ."\n type: '".$this::TYPE."'"
        ."\n}];";

        $this->traces = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function render():string{
        $this->generateTrace($this->data['x']);
        $this->plot .= $this->traces['string'];
        $this->plot .= "Plotly.newPlot('".$this->divId."', ".$this->traces['name'].");";
        return $this->plot;
    }
}


?>

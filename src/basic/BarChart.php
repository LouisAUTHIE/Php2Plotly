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

    private function generateTrace(array $x, array $y, ?array $text = null, ?string $textposition = null):void{
        $traceName = 'trace'.uniqid();
        $strTrace = "
        var ".$traceName." = [{"
        ."\n x: ['".implode('\',\'', $x)."'],"
        ."\n y: [".implode(',', $y)."],";
        
        if ($text !== null) {
            $strTrace .= "\n text: ['".implode('\',\'', $text)."'],";
        }
        if ($textposition !== null) {
            $strTrace .= "\n textposition: '".$textposition."',";
        }
        
        $strTrace .= "\n type: '".$this::TYPE."'"
        ."\n}];";

        $this->traces = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function render():string{
        $text = $this->data['text'] ?? null;
        $textposition = $this->data['textposition'] ?? null;
        $this->generateTrace($this->data['x'], $this->data['y'], $text, $textposition);
        $this->plot .= $this->traces['string'];
        $this->plot .= "Plotly.newPlot('".$this->divId."', ".$this->traces['name'].");";
        return $this->plot;
    }
}


?>

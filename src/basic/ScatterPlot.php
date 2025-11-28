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

    private function generateTrace(array $x, array $y, string $mode, $name, ?array $text = null, ?string $textposition = null):void{
        $traceName = 'trace'.uniqid();
        $strTrace = "
        var ".$traceName." = {"
        ."\n x: [".implode(',', $x)."],"
        ."\n y: [".implode(',', $y)."],"
        ."\n mode: '$mode',"
        ."\n name: '$name',";
        
        if ($text !== null) {
            $strTrace .= "\n text: ['".implode('\',\'', $text)."'],";
        }
        if ($textposition !== null) {
            $strTrace .= "\n textposition: '".$textposition."',";
        }
        
        $strTrace .= "\n type: '".$this::TYPE."'"
        ."\n};";

        $this->traces[] = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function render():string{
        foreach($this->data as $d){
            $text = $d['text'] ?? null;
            $textposition = $d['textposition'] ?? null;
            $this->generateTrace($d['x'], $d['y'], $d['mode'], $d['name'], $text, $textposition);
        }
        $this->plot .= implode('', array_map(fn($t) => $t['string'], $this->traces));
        $this->plot .= "var data = [".implode(',', array_map(fn($t) => $t['name'], $this->traces))."];";
        $this->plot .= "Plotly.newPlot('".$this->divId."', data);";
        return $this->plot;
    }
}


?>

<?php

namespace Php2plotly\stats;

class BoxPlot{
    private string $plot;
    private array $traces= [];
    
    const TYPE = 'box';

    public function __construct(private string $divId, private array $data = []){
        $this->plot = '';
    }

    public function setData(array $data):self{
        $this->data = $data;
        return $this;
    }

    private function generateTrace(array $y, ?array $text = null):void{
        $traceName = 'trace'.uniqid();
        $strTrace = "
        var ".$traceName." = {"
        ."\n y: [".implode(',', $y)."],";
        
        if ($text !== null) {
            $strTrace .= "\n text: ['".implode('\',\'', $text)."'],";
        }
        
        $strTrace .= "\n type: '".$this::TYPE."'"
        ."\n};";

        $this->traces[] = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function render():string{
        foreach($this->data as $d){
            $text = $d['text'] ?? null;
            $this->generateTrace($d['y'], $text);
        }
        $this->plot .= implode('', array_map(fn($t) => $t['string'], $this->traces));
        $this->plot .= "var data = [".implode(',', array_map(fn($t) => $t['name'], $this->traces))."];";
        $this->plot .= "Plotly.newPlot('".$this->divId."', data);";
        return $this->plot;
    }
}


?>

<?php

namespace Php2plotly\basic;

class PieChart{
    private string $plot;
    private array $traces;
    private array $layoutInfo;
    
    const TYPE = 'pie';

    public function __construct(private string $divId, private array $data = [], private array $layout = []){
        $this->plot = '';
    }

    public function setData(array $data):self{
        $this->data = $data;
        return $this;
    }

    public function setLayout(array $layout):self{
        $this->layout = $layout;
        return $this;
    }

    private function generateLayout(array $layout):void{
        $layoutName = 'layout'.uniqid();
        $strLayout = "
        var ".$layoutName." = {"
        ."\n height: ".$layout['height'].","
        ."\n width: ".$layout['width'].","
        ."\n};";

        $this->layoutInfo = ["name"=>$layoutName, "string"=>$strLayout];
    }

    private function generateTrace(array $values, array $labels, ?string $textinfo = null, ?string $insidetextorientation = null):void{
        $traceName = 'trace'.uniqid();
        $strTrace = "
        var ".$traceName." = [{"
        ."\n labels: ['".implode('\',\'', $labels)."'],"
        ."\n values: [".implode(',', $values)."],";
        
        if ($textinfo !== null) {
            $strTrace .= "\n textinfo: '".$textinfo."',";
        }
        if ($insidetextorientation !== null) {
            $strTrace .= "\n insidetextorientation: '".$insidetextorientation."',";
        }
        
        $strTrace .= "\n type: '".$this::TYPE."'"
        ."\n}];";

        $this->traces = ["name"=>$traceName, "string"=>$strTrace];
    }

    public function render():string{
        $textinfo = $this->data['textinfo'] ?? null;
        $insidetextorientation = $this->data['insidetextorientation'] ?? null;
        $this->generateTrace($this->data['values'], $this->data['labels'], $textinfo, $insidetextorientation);
        $this->generateLayout($this->layout);
        $this->plot .= $this->traces['string'];
        $this->plot .= $this->layoutInfo['string'];
        $this->plot .= "Plotly.newPlot('".$this->divId."', ".$this->traces['name'].", ".$this->layoutInfo["name"].");";
        return $this->plot;
    }
}


?>

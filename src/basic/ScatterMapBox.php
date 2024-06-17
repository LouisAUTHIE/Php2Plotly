<?php
namespace Php2plotly\basic;

class ScatterMapBox
{
    private string $plot;
    private array $dataArray= [];
    
    const TYPE = 'scattermapbox';

    public function __construct(private string $divId, private array $data = [], private array $layout = []){
        $this->plot = '';
    }

    public function setData(array $data):self{
        $this->data = $data;
        return $this;
    }

    private function generateData(array $lon, array $lat, array $text, array $marker):void{
        $dataName = 'data'.uniqid();
        $strData = "
        var ".$dataName." = {"
        ."\n lon: [".implode(',', $lon)."],"
        ."\n lat: [".implode(',', $lat)."],"
        ."\n text: ['".implode('\',\'', $text)."'],"
        ."\n marker: { color: '".$marker['color']."', size: ".$marker['size']." },"
        ."\n type: '".$this::TYPE."'"
        ."\n};";

        $this->dataArray[] = ["name"=>$dataName, "string"=>$strData];
    }

    public function render():string{
        foreach($this->data as $d)
            $this->generateData($d['lon'], $d['lat'], $d['text'], $d['marker']);
        $this->plot .= implode('', array_map(fn($d) => $d['string'], $this->dataArray));
        $this->plot .= "var data = [".implode(',', array_map(fn($d) => $d['name'], $this->dataArray))."];";

       $this->plot .= "var layout = {"
        ."\n dragmode: 'zoom',"
        ."\n mapbox: { style: 'open-street-map', center: { lat: ".$this->layout["centerlat"].", lon: ".$this->layout["centerlon"]." }, zoom: ". $this->layout['zoom'] ." },"
        ."\n margin: { r: 0, t: 0, b: 0, l: 0 }"
        ."\n};";
        $this->plot .= "Plotly.newPlot('".$this->divId."', data, layout);";
        return $this->plot;
    }
}

?>
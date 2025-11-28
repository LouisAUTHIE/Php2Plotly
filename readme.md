# php2plotly

php2plotly is a PHP library that allows you to easily create interactive plots and charts using the Plotly.js library. With php2plotly, you can generate beautiful and dynamic visualizations for your web applications.

## Features

- Support for various chart types, including bar charts, line charts, scatter plots, and more.
- Seamless integration with Plotly.js for advanced functionality.

## Installation

To install php2plotly, simply require the library using Composer:

```bash
composer require louisauthie/php2plotly
```

## Usage

Using php2plotly is straightforward. Here's a basic example to get you started:

```php

<?php
namespace App;
require_once __DIR__ . '/../vendor/autoload.php';
use Php2plotly\basic\BarChart;
use Php2plotly\basic\PieChart;
use Php2plotly\basic\ScatterPlot;
use Php2plotly\preprocessor\Preprocessor;
use Php2plotly\stats\BoxPlot;
use Php2plotly\stats\Histogram;
use Php2plotly\scientific\Heatmap;
?>

<html>
    <head>
        <script src="../assets/js/plotly-2.32.0.min.js" charset="utf-8"></script>
    </head>

    <body style="display:flex; flex-wrap:wrap; max-with:100vw;">

    <div id="scatter" style="width:600px;height:400px;"></div>
    <?php
        $scatter = new ScatterPlot('scatter', [
            ['x' => [1, 2, 3, 4], 'y' => [10, 15, 13, 17], 'mode' => 'markers'],
            ['x' => [2, 3, 4, 5], 'y' => [16, 5, 11, 9], 'mode' => 'lines']
        ]);
        echo '<script>'.$scatter->render().'</script>';

    ?>

    <div id="bar" style="width:600px;height:400px;"></div>

    <?php
        $bar = new BarChart('bar', ['x' => ["Cat1", "Cat2", "Cat3", "Cat4"], 'y' => [10, 15, 13, 17]]);
        echo '<script>'.$bar->render().'</script>';
    ?>

    <div id="pie" style="width:600px;height:400px;"></div>
    <?php
        $pie = new PieChart('pie', ['values' => [10, 15, 13, 17], 'labels' => ["Cat1", "Cat2", "Cat3", "Cat4"],'textinfo'=>'label+percent','insidetextorientation'=>'radial'], ['height' => 400, 'width' => 600]);
        echo '<script>'.$pie->render().'</script>';
    ?>

    <div id="histogram" style="width:600px;height:400px;"></div>
    <?php
        $histogram = new Histogram('histogram', ['x' => [1, 2, 3, 4]]);
        echo '<script>'.$histogram->render().'</script>';
    ?>

    <div id="bplot" style="width:600px;height:400px;"></div>
    <?php
        $listsBoxPlot  = [
            ['y' => [1, 2, 3, 4, 5, 8, 10, 40, 0, -8]],
            ['y' => [1, 2, 3, 4, 5, 8, 10, 40, 0, -8]],
            ['y' => [1, 2, 3, 4, 5, 8, 10, 40, 0, -8]],
            ['y' => [1, 2, 3, 4, 5, 8, 10, 10, 0, -7]],
            ['y' => [1, 2, 3, 4, 5, 8, 10, 10, 0, -7]],
        ];
        $boxplot = new BoxPlot('bplot', $listsBoxPlot);
        echo '<script>'.$boxplot->render().'</script>';
    ?>

    <div id="heatmap" style="width:600px;height:400px;"></div>
    <?php
        $heatmap = new Heatmap('heatmap', 
            ['x' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], 'y' => ['Morning', 'Afternoon', 'Evening'], 'z' => [[1, 0, 30, 50, 1], [20, 1, 60, 80, 30], [30, 60, 1, -10, 20]]]
        );
        echo '<script>'.$heatmap->render().'</script>';
    ?>

    <div id="countHistog" style="width:600px;height:400px;"></div>
    <?php
        $values= [1.2,1.4, 2, 3, 7, 4, 4, 4, 4, 4.5, 4, 4];
        $histogram = new BarChart('countHistog', Preprocessor::countNumberByInterval($values, 3));
        echo '<script>'.$histogram->render().'</script>';
    ?>
    </body>
</html>
```


## Contributing

Contributions are welcome! If you have any bug reports, feature requests, or pull requests, please open an issue on the [GitHub repository](https://github.com/louisauthie/php2plotly).

## License

php2plotly is licensed under the MIT License. See [LICENSE](https://github.com/louisauthie/php2plotly/blob/main/LICENSE) for more information.

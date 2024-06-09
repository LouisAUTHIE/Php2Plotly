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
namespace Chap3;
require_once __DIR__ . '/../vendor/autoload.php';
use Php2plotly\basic\ScatterPlot;
?>

<html>
    <head>
        <script src="../assets/js/plotly-2.32.0.min.js" charset="utf-8"></script>
    </head>

    <body>

    <div id="tester" style="width:600px;height:250px;"></div>
    <?php
        $scatter = new ScatterPlot('tester', [
            ['x' => [1, 2, 3, 4], 'y' => [10, 15, 13, 17], 'mode' => 'markers'],
            ['x' => [2, 3, 4, 5], 'y' => [16, 5, 11, 9], 'mode' => 'lines']
        ]);
        echo '<script>'.$scatter->render().'</script>';

    ?>

    </script>
    </body>
</html>
```


## Contributing

Contributions are welcome! If you have any bug reports, feature requests, or pull requests, please open an issue on the [GitHub repository](https://github.com/louisauthie/php2plotly).

## License

php2plotly is licensed under the MIT License. See [LICENSE](https://github.com/louisauthie/php2plotly/blob/main/LICENSE) for more information.

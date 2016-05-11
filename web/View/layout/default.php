<html>
<head>
    <title>
        <?= isset($title)?$title:'' ?>
    </title>
    <?= isset($scripts)?$scripts:'' ?>
    <?= isset($css)?$css:'' ?>
    <?= $this->renderCss('bootstrap.min')?>
    <?= $this->renderCss('default')?>
    <?= $this->renderJs('jquery.min')?>
    <?= $this->renderJs('angular.min')?>
    <?= $this->renderJs('tools')?>
</head>
<body>
<div id="wrapper">
    <div class="container">
        <header>
            <?= isset($header)?$header:'' ?>
        </header>
        <h1>Layout</h1>
        <div id="content">
            <?= isset($content)?$content:'' ?>
        </div>
        <footer>
            <?= isset($footer)?$footer:'' ?>
        </footer>
    </div>
</div>
</body>
</html>

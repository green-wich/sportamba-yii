<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <?php Yii::app()->bootstrap->register(); ?>
    <title><?php echo $this->pageTitle;?></title>
    <link rel="shortcut icon" href="<?php echo $this->getModule()->assets;?>/favicon.ico"/>
</head>
<body>
<?php echo $content?>
</body>
</html>

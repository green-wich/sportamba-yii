<?php
/**
 * @var AdminController $this
 * @var string $content
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta charset="utf-8">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script src="<?php echo $this->getModule()->assets; ?>/js/html5.js"></script>
    <![endif]-->

    <title><?php echo $this->pageTitle;?></title>
    <link rel="shortcut icon" href="<?php echo $this->getModule()->assets;?>/favicon.ico"/>

</head>
<body>
<?php echo $content?>
</body>
</html>

<?php
/**
 * @var CController $this
 * @var string $content
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $this->getPageTitle()?></title>
</head>
<body>
<div class="page-error-wrapper">
    <div class="page-error">
        <?php echo $content ?>
    </div>
</div>
</body>
</html>

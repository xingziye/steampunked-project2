<?php
require 'lib/site.inc.php';
$view = new Steampunked\View($site, $user);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
    <script src="push.js"></script>
    <script>
        pushInit(<?php $key = 'Lill' . $user->getId(); echo "\"$key\""; ?>);
    </script>
</head>
<body>
    <?php echo $view->header(); ?>
    <?php echo $view->createGrid(); ?>
    <?php echo $view->presentTurn(); ?>
    <?php echo $view->createRadioButtons(); ?>
    <?php echo $view->createOptionButtons(); ?>
</body>
</html>
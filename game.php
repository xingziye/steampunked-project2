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
<?php
    if ($view->isInGame()) {
        echo $view->header();
        echo $view->createGrid();
        echo $view->presentTurn();
        echo $view->createRadioButtons();
        echo $view->createOptionButtons();
    } else {
        echo $view->header();
        echo '<p>You are not in a game, please go to lobby to create or join one.</p>';
    }
?>
</body>
</html>
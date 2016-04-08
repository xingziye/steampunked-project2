<?php
require 'lib/game.inc.php';
$view = new Steampunked\View($steampunked);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $view->createStartPage(); ?>

</body>
</html>
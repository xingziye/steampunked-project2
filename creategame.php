<?php
require 'lib/site.inc.php';
$view = new Steampunked\CreateGameView($site);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $view->present(); ?>

</body>
</html>
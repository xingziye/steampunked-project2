<?php
require 'lib/site.inc.php';
$view = new Steampunked\GamesView($site);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
</head>
<body>
<a href="post/logout.php">Log out</a>
<?php echo $view->present(); ?>


</body>
</html>
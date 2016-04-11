<?php
$open = true;
require 'lib/site.inc.php';
$view = new Steampunked\PassordValidationView($site, $_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
</head>
<body>

<div class="login">
    <?php echo $view->present(); ?>
</div>
</body>
</html>
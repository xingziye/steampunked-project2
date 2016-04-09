<?php
require 'lib/site.inc.php';
$view = new Steampunked\SignUpView();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="lib/css/steampunked.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php //echo $view->createStartPage(); ?>

<div class="login">
    <?php echo $view->present(); ?>

</div>
</body>
</html>
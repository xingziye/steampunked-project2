<?php
require 'lib/site.inc.php';
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
<p>Waiting for another player to join your game</p>

</body>
</html>
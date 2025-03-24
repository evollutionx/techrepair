<?php
require_once "classes/login.php";

include "header.php";

$login = new Login();

if (!$login->isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair</title>
</head>
<body>
    
</body>
</html>
<?php include "footer.php"; ?>
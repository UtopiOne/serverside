<?php 
$finalTitle = $title ?? 'Мой блог';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($finalTitle); ?></title>
    <link rel="stylesheet" href="/lab7/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($finalTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
</body>
</html>
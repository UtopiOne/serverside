<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <img src="media/logo.png" style="filter: invert();" alt="logo">
    </header>

    <main>
        <?php
        $url = 'https://www.google.com';
        $headers = get_headers($url);

        foreach ($headers as $header) {
            echo $header . "<br>";
        }

        ?>
    </main>
</body>

</html>
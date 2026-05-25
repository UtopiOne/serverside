<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <header>
        <img src="../media/logo.png" style="filter: invert();" alt="logo">
    </header>

    <main>
        <?php
        $strings = ["Hello World", "Greetings", "Testing!", "PHP is fun!", "Have a nice day!"];

        echo $strings[array_rand($strings)] . "<br>";
        ?>
    </main>

    <footer>
        <p>задание для самостоятельной работы</p>
    </footer>

</body>

</html>
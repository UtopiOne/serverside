<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <img src="/media/logo.png" style="filter: invert();" alt="logo">

        <h1>Feedback Form</h1>
    </header>

    <main>
        <form action="https://httpbin.org/post" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="feedback-type">Feedback Type:</label>
            <select id="feedback-type" name="feedback-type" required>
                <option value="general">Complaint</option>
                <option value="bug">Suggestion</option>
                <option value="feature">Gratitude</option>
            </select><br><br>

            <label for="feedback">Feedback:</label><br>
            <textarea id="feedback" name="feedback" rows="4" cols="50" required></textarea><br><br>

            <label for="response-type">Response Type</label>
            <input type="checkbox" name="response-type" id="response-type" value="email"> Email
            <input type="checkbox" name="response-type" id="response-type" value="SMS"> SMS <br><br>

            <button type="submit" value="Submit">Submit</button>
        </form>

        <a href="/lab2/page2.php">Page 2</a>
    </main>

    <footer>
        <p>Собрать сайт из двух страниц.</p>
    </footer>


</body>

</html>
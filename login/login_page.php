<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./../style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <header>
        <img src="./../images/cat_logo.png" id="logo" alt="Logo">
        <h1 id="name">Cofee Cat</h1>
    </header>
    <div id="content">
        <section id="form" class="container">
            <h2>Form</h2>
            <form action="./index.php" method="POST">
                <label>Login:
                    <input name="field-login" placeholder="Your login" type="text">
                </label>
                <label>Password:
                    <input name="field-password" placeholder="Your password" type="password">
                </label>
                <label class="submit-button"><input type="submit"></label>
            </form>
        </section>
    </div>
</body>

</html>
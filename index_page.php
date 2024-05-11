<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="./script.js" defer></script>
</head>

<body>
    <header>
        <img src="./images/cat_logo.png" id="logo" alt="Logo">
        <h1 id="name">Cofee Cat</h1>
    </header>
    <div id="content">
        <section id="login-status-container" class="container" <?php echo !empty($_COOKIE[session_name()])? '' : 'style="display: none"'; ?>>
            <p>
                You have been signed in as <?php echo !empty($_SESSION['login'])? $_SESSION['login'] : ''; ?>
            </p>
            <button type="button" value="<?php echo session_name(); ?>" id="logout-button">Log out</button>
        </section>
        <section id="login-data-container" class="container" <?php echo !empty($_COOKIE['password'])? '': 'style="display: none"' ?>>
            <p class="text-light">
                You can <a href="./login">login</a> with login: <?php echo empty($_COOKIE['login'])? '': sanitize($_COOKIE['login']); ?> and password: <?php echo empty($_COOKIE['password'])? '': sanitize($_COOKIE['password']);?>.
            </p>
        </section>
        <section id="form" class="container">
            <h2>Form</h2>
            <form action="./index.php" method="POST">
                <?php
                    print isset($_SESSION['csrf_token']) ? '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">' : '';
                ?>
                <label>Name:
                    <input name="field-name" placeholder="Your name" type="text" <?php print empty($_COOKIE["field-name-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print $values["name"] ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-name-error"]) ? 'style="display:none;"' : '' ?>>Please fill name field correctly</span>
                </label>

                <label>Phone:
                    <input name="field-phone" placeholder="Your phone number" type="tel" <?php print empty($_COOKIE["field-phone-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print $values["phone"]; ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-phone-error"]) ? 'style="display:none;"' : '' ?>>Please fill phone field correctly</span>
                </label>

                <label>Email:
                    <input name="field-email" placeholder="Your email adress" type="email" <?php print empty($_COOKIE["field-email-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print $values['email']; ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-email-error"]) ? 'style="display:none;"' : '' ?>>Please fill email field correctly</span>
                </label>

                <label>Date of birth:
                    <input name="field-date" type="date" <?php print empty($_COOKIE["field-date-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print $values["date"]; ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-date-error"]) ? 'style="display:none;"' : '' ?>>Please fill birthday date field correctly</span>
                </label>

                <p>Gender:</p>
                <label class="radio-gender">
                    <input name="field-gender" type="radio" value="male" <?php print $values["gender"] == '1' ? 'checked' : ''; ?>>Male
                </label>
                <label class="radio-gender">
                    <input name="field-gender" type="radio" value="female" <?php print $values["gender"] == '0' ? 'checked' : ''; ?>>Female
                </label>
                <span class="err_desc" <?php print empty($_COOKIE["field-gender-error"]) ? 'style="display:none;"' : '' ?>>Please fill gender field correctly</span>

                <label>Favorite PL:
                    <select name="field-pl[]" multiple="multiple" <?php print empty($_COOKIE["field-pl-error"]) ? '' : 'class="err_input"'; ?>>
                        <option value="pascal" <?php print str_contains($values["fpls"], '@pascal@') ? 'selected' : ''; ?>>Pascal</option>
                        <option value="c" <?php print str_contains($values["fpls"], '@c@') ? 'selected' : ''; ?>>C</option>
                        <option value="cpp" <?php print str_contains($values["fpls"], '@cpp@') ? 'selected' : ''; ?>>C++</option>
                        <option value="js" <?php print str_contains($values["fpls"], '@js@') ? 'selected' : ''; ?>>JavaScript</option>
                        <option value="php" <?php print str_contains($values["fpls"], '@php@') ? 'selected' : ''; ?>>PHP</option>
                        <option value="python" <?php print str_contains($values["fpls"], '@python@') ? 'selected' : ''; ?>>Python</option>
                        <option value="java" <?php print str_contains($values["fpls"], '@java@') ? 'selected' : ''; ?>>Java</option>
                        <option value="haskel" <?php print str_contains($values["fpls"], '@haskel@') ? 'selected' : ''; ?>>Haskel</option>
                        <option value="clojure" <?php print str_contains($values["fpls"], '@clojure@') ? 'selected' : ''; ?>>Clojure</option>
                        <option value="prolog" <?php print str_contains($values["fpls"], '@prolog@') ? 'selected' : ''; ?>>Prolog</option>
                        <option value="scala" <?php print str_contains($values["fpls"], '@scala@') ? 'selected' : ''; ?>>Scala</option>
                    </select>
                    <span class="err_desc" <?php print empty($_COOKIE["field-pl-error"]) ? 'style="display:none;"' : '' ?>>Please fill fpl field correctly</span>
                </label>

                <label>BIO:
                    <textarea name="field-bio" <?php print empty($_COOKIE["field-bio-error"]) ? '' : 'class="err_input"'; ?>><?php print $values["bio"]; ?></textarea>
                    <span class="err_desc" <?php print empty($_COOKIE["field-bio-error"]) ? 'style="display:none;"' : '' ?>>Please fill bio field correctly</span>
                </label>

                <label id="chkbox-label">
                    <input type="checkbox" name="check-accept" value="accepted">
                    Accept
                    <span class="err_desc" <?php print empty($_COOKIE["field-accept-error"]) ? 'style="display:none;"' : '' ?>>Please accept Privacy Politics.</span>
                </label>

                <label class="submit-button"><input type="submit"></label>
            </form>
        </section>
    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <header>
        <img src="./images/cat_logo.png" id="logo" alt="Logo">
        <h1 id="name">Cofee Cat</h1>
    </header>
    <div id="content">
        <section id="login-data-container" class="container" <?php echo !empty($_COOKIE['pass'])? '': 'style="display: none"' ?>
            <p class="text-light">
                You can <a href="./login.php">login</a> with login: <?php echo empty($_COOKIE['login'])? '': strip_tags($_COOKIE['login']); ?> and password: <?php echo empty($_COOKIE['password'])? '': strip_tags($_COOKIE['password']);?>.
            </p>
        </section>
        <section id="form" class="container">
            <h2>Form</h2>
            <form action="./index.php" method="POST">
                <label>Name:
                    <input name="field-name" placeholder="Your name" type="text" <?php print empty($_COOKIE["field-name-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print empty($_COOKIE['field-name']) ? '' : $_COOKIE['field-name']; ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-name-error"]) ? 'style="display:none;"' : '' ?>>Please fill name field correctly</span>
                </label>

                <label>Phone:
                    <input name="field-phone" placeholder="Your phone number" type="tel" <?php print empty($_COOKIE["field-phone-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print empty($_COOKIE['field-phone']) ? '' : $_COOKIE['field-phone']; ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-phone-error"]) ? 'style="display:none;"' : '' ?>>Please fill phone field correctly</span>
                </label>

                <label>Email:
                    <input name="field-email" placeholder="Your email adress" type="email" <?php print empty($_COOKIE["field-email-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print empty($_COOKIE['field-email']) ? '' : $_COOKIE['field-email']; ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-email-error"]) ? 'style="display:none;"' : '' ?>>Please fill email field correctly</span>
                </label>

                <label>Date of birth:
                    <input name="field-date" type="date" <?php print empty($_COOKIE["field-date-error"]) ? '' : 'class="err_input"'; ?>
                        value="<?php print empty($_COOKIE['field-date']) ? '' : $_COOKIE['field-date']; ?>">
                    <span class="err_desc" <?php print empty($_COOKIE["field-date-error"]) ? 'style="display:none;"' : '' ?>>Please fill birthday date field correctly</span>
                </label>

                <p>Gender:</p>
                <label class="radio-gender">
                    <input name="field-gender" type="radio" value="male" <?php print empty($_COOKIE['field-gender']) ? '' : ($_COOKIE['field-gender'] == 'male' ? 'checked' : ''); ?>>Male
                </label>
                <label class="radio-gender">
                    <input name="field-gender" type="radio" value="female" <?php print empty($_COOKIE['field-gender']) ? '' : ($_COOKIE['field-gender'] == 'female' ? 'checked' : ''); ?>>Female
                </label>
                <span class="err_desc" <?php print empty($_COOKIE["field-gender-error"]) ? 'style="display:none;"' : '' ?>>Please fill gender field correctly</span>

                <label>Favorite PL:
                    <select name="field-pl[]" multiple="multiple" <?php print empty($_COOKIE["field-pl-error"]) ? '' : 'class="err_input"'; ?>>
                        <option value="pascal" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@pascal@') ? 'selected' : ''); ?>>Pascal</option>
                        <option value="c" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@c@') ? 'selected' : ''); ?>>C</option>
                        <option value="cpp" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@cpp@') ? 'selected' : ''); ?>>C++</option>
                        <option value="js" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@js@') ? 'selected' : ''); ?>>JavaScript</option>
                        <option value="php" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@php@') ? 'selected' : ''); ?>>PHP</option>
                        <option value="python" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@python@') ? 'selected' : ''); ?>>Python</option>
                        <option value="java" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@java@') ? 'selected' : ''); ?>>Java</option>
                        <option value="haskel" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@haskel@') ? 'selected' : ''); ?>>Haskel</option>
                        <option value="clojure" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@clojure@') ? 'selected' : ''); ?>>Clojure</option>
                        <option value="prolog" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@prolog@') ? 'selected' : ''); ?>>Prolog</option>
                        <option value="scala" <?php print empty($_COOKIE['field-pl']) ? "" : (str_contains($_COOKIE['field-pl'], '@scala@') ? 'selected' : ''); ?>>Scala</option>
                    </select>
                    <span class="err_desc" <?php print empty($_COOKIE["field-pl-error"]) ? 'style="display:none;"' : '' ?>>Please fill fpl field correctly</span>
                </label>

                <label>BIO:
                    <textarea name="field-bio" <?php print empty($_COOKIE["field-bio-error"]) ? '' : 'class="err_input"'; ?>><?php print empty($_COOKIE['field-bio']) ? '' : $_COOKIE['field-bio']; ?></textarea>
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
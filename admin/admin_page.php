<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../style.css">
    <title>Admin Page</title>
</head>

<body>
    <main class="screen-container">
        <header>
            <img src="./../images/cat_logo.png" id="logo" alt="Logo">
            <h1 id="name">Cofee Cat</h1>
        </header>
        <div class="content">
            <div class="admin-status tile">
                <h3>
                    Administrator
                    <hr>
                </h3>
                <p>
                    Login: 
                    <br>
                    <span>
                        <?php echo $_SERVER['PHP_AUTH_USER'];?>
                    </span>
                </p>
                <button disabled>
                    Exit
                </button>
            </div>
            <div class="submissions-stats tile">
                <h3>
                    Statistics
                    <hr>
                </h3>
                <div class="total-submissions-count-outter">
                    <p>Total submissions: <span><?php echo count($submissions);?></span></p>
                </div>
                <div class="selected-pl-count-outter">
                    <h4>Selected PLs count</h4>
                    <ul>
                        <?php 
                            foreach ($fpls_count as $fpl => $fpl_count) {
                                echo "<li><p>" . $fpl . ":  <span>" . $fpl_count . "</span></p></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="user-submissions tile">
                <h3>
                    Submissions
                    <hr>
                </h3>
                <div class="submissions-list-outter">
                    <?php
                        foreach ($submissions as $submission) {
                            echo '
                                <div class="submission-item">
                                    <form action="./index.php" method="POST">
                                        <input type="text" name="user-id" value="'. $submission['user_id'] .'" hidden>
                                        <input type="checkbox" name="check-accept" value="accepted" checked hidden>
                                        <div class="text-field-outter form-field">
                                            <label for="field-name">Name: </label>
                                            <input type="text" name="field-name" placeholder="Your name" value="'. $submission['name'] .'">
                                        </div>
                                        <div class="text-field-outter form-field">
                                            <label for="field-phone">Phone: </label>
                                            <input type="tel" name="field-phone" placeholder="Your phone" value="'. $submission['phone'] .'">
                                        </div>
                                        <div class="text-field-outter form-field">
                                            <label for="field-email">Email: </label>
                                            <input type="email" name="field-email" placeholder="Your email" value="'. $submission['email'] .'">
                                        </div>
                                        <div class="text-field-outter form-field">
                                            <label for="field-date">Date of Birth: </label>
                                            <input type="date" name="field-date" value="'. $submission['bdate'] .'">
                                        </div>
                                        <div class="radio-field-outter form-field">
                                            <label for="field-gender">Gender: </label>
                                            <div class="radio-field-button">
                                                <input name="field-gender" type="radio" value="male"';
                            echo $submission['gender'] == '1'? 'checked' : '';
                            echo '>
                                                <span>Male</span>
                                            </div>
                                            <div class="radio-field-button">
                                                <input name="field-gender" type="radio" value="female"';
                            echo $submission['gender'] == '0'? 'checked' : '';
                            echo '>
                                                <span>Female</span>
                                            </div>
                                        </div>
                                        <div class="select-field-outter form-field">
                                            <label for="field-pl[]">Favorite PL: </label>
                                            <select name="field-pl[]" multiple="multiple">
                                                <option value="pascal"';
                            echo in_array('pascal', $submission['fpls'])? 'selected' : '';
                            echo '>Pascal</option>
                                                <option value="c"';
                            echo in_array('c', $submission['fpls'])? 'selected' : '';
                            echo '>C</option>
                                                <option value="cpp"';
                            echo in_array('cpp', $submission['fpls'])? 'selected' : '';
                            echo '>C++</option>
                                                <option value="js"';
                            echo in_array('js', $submission['fpls'])? 'selected' : '';
                            echo '>JavaScript</option>
                                                <option value="php"';
                            echo in_array('php', $submission['fpls'])? 'selected' : '';
                            echo '>PHP</option>
                                                <option value="python"';
                            echo in_array('python', $submission['fpls'])? 'selected' : '';
                            echo '>Python</option>
                                                <option value="java"';
                            echo in_array('java', $submission['fpls'])? 'selected' : '';
                            echo '>Java</option>
                                                <option value="haskel"';
                            echo in_array('haskel', $submission['fpls'])? 'selected' : '';
                            echo '>Haskel</option>
                                                <option value="clojure"';
                            echo in_array('clojure', $submission['fpls'])? 'selected' : '';
                            echo '>Clojure</option>
                                                <option value="prolog"';
                            echo in_array('prolog', $submission['fpls'])? 'selected' : '';
                            echo '>Prolog</option>
                                                <option value="scala"';
                            echo in_array('scala', $submission['fpls'])? 'selected' : '';
                            echo '>Scala</option>
                                            </select>
                                        </div>
                                        <div class="textarea-field-outter form-field">
                                            <label for="field-bio">Bio: </label>
                                            <textarea name="field-bio">'. $submission['bio'] .'</textarea>
                                        </div>
                                        <div class="submission-controls">
                                            <button name="button-action" class="edit-button" type="submit" value="EDIT">Edit</button>
                                            <button name="button-action" class="delete-button" type="submit" value="DELETE">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            ';
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
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
                        Some_login
                    </span>
                </p>
                <button>
                    Exit
                </button>
            </div>
            <div class="submissions-stats tile">
                <h3>
                    Statistics
                    <hr>
                </h3>
                <div class="total-submissions-count-outter">
                    <p>Total submissions: <span>10</span></p>
                </div>
                <div class="selected-pl-count-outter">
                    <h4>Selected PLs count</h4>
                    <ul>
                        <li><p>Key: <span>Value</span></p></li>
                    </ul>
                </div>
            </div>
            <div class="user-submissions tile">
                <h3>
                    Submissions
                    <hr>
                </h3>
                <div class="submissions-list-outter">
                    <div class="submission-item">
                        <form action="./index.php" method="POST">
                            <div class="text-field-outter form-field">
                                <label for="field-name">Name: </label>
                                <input type="text" name="field-name" placeholder="Your name" value="Some name">
                            </div>
                            <div class="text-field-outter form-field">
                                <label for="field-phone">Phone: </label>
                                <input type="tel" name="field-phone" placeholder="Your phone" value="Some phone">
                            </div>
                            <div class="text-field-outter form-field">
                                <label for="field-email">Email: </label>
                                <input type="email" name="field-email" placeholder="Your email" value="Some email">
                            </div>
                            <div class="text-field-outter form-field">
                                <label for="field-date">Date of Birth: </label>
                                <input type="date" name="field-date" value="">
                            </div>
                            <div class="radio-field-outter form-field">
                                <label for="field-gender">Gender: </label>
                                <div class="radio-field-button">
                                    <input name="field-gender" type="radio" value="male">
                                    <span>Male</span>
                                </div>
                                <div class="radio-field-button">
                                    <input name="field-gender" type="radio" value="female">
                                    <span>Female</span>
                                </div>
                            </div>
                            <div class="select-field-outter form-field">
                                <label for="field-pl[]">Favorite PL: </label>
                                <select name="field-pl[]" multiple="multiple">
                                    <option value="pascal">Pascal</option>
                                    <option value="c">C</option>
                                    <option value="cpp">C++</option>
                                    <option value="js">JavaScript</option>
                                    <option value="php">PHP</option>
                                    <option value="python">Python</option>
                                    <option value="java">Java</option>
                                    <option value="haskel">Haskel</option>
                                    <option value="clojure">Clojure</option>
                                    <option value="prolog">Prolog</option>
                                    <option value="scala">Scala</option>
                                </select>
                            </div>
                            <div class="textarea-field-outter form-field">
                                <label for="field-bio">Bio: </label>
                                <textarea name="field-bio"></textarea>
                            </div>
                            <div class="submission-controls">
                                <button class="edit-button" type="submit">Edit</button>
                                <button class="delete-button" type="submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
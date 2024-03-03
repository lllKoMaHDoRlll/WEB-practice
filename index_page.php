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
        <section id="form">
            <h2>Form</h2>
            <form action="/web-2-task-4/index.php" method="POST">          
                <label>Name:
                    <input name="field-name" placeholder="Your name" type="text">
                    <span class="err_desk">Please fill name field correctly</span>
                </label>
                   
                <label>Phone:
                    <input name="field-phone" placeholder="Your phone number" type="tel">
                    <span class="err_desk">Please fill phone field correctly</span>
                </label>
                
                <label>Email:
                    <input name="field-email" placeholder="Your email adress" type="email">
                    <span class="err_desk">Please fill email field correctly</span>
                </label>
    
                <label>Date of birth:
                    <input name="field-date" type="date">
                    <span class="err_desk">Please fill birthday date field correctly</span>
                </label>
    
                <p>Gender:</p>
                    <label class="radio-gender">
                        <input name="field-gender" type="radio" value="male">Male
                    </label>
                    <label class="radio-gender">
                    <input name="field-gender" type="radio" value="female">Female
                    </label>
                    <span class="err_desk">Please fill gender field correctly</span>
    
                <label>Favorite PL:
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
                    <span class="err_desk">Please fill fpl field correctly</span>
                </label>
    
                <label>BIO:
                    <textarea name="field-bio"></textarea>
                    <span class="err_desk">Please fill bio field correctly</span>
                </label>
    
                <label id="chkbox-label">
                    <input type="checkbox" name="check-accept" value="accepted"> 
                    Accept
                    <span class="err_desk">Please accept Privacy Politics.</span>
                </label>
    
                <label class="submit-button"><input type="submit"></label>
            </form>
        </section>
    </div>
    
</body>
</html>

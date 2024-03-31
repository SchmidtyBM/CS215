<?php
    session_start();
    require_once("db.php");

    if (!isset($_SESSION["user_id"])){
        header("Location: index.php");
        exit();
    } 
    if (isset($_POST["submit"]) && $_POST["submit"]){

        $user_id = $_SESSION["user_id"];

        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);
        } 
        catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        $question = $_POST["question"];

        if (strlen($question) > 0 && strlen($question) <= 1500){
            $query = "INSERT INTO Questions (user_id, question, created_dt) VALUES ('$user_id', '$question', NOW())";
            $result = $db->exec($query);

            $db = null;
            header("Location: questionManagement.php");
            exit();
        }
        else{
            $error = ("Question must be non-empty and less than 1500 characters");
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Question Creation</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>
                Question Creation Page
            </h1>
        </header>

        <main id="main-left">
        </main>

        <main id="main-center">
            <form id="creation-form" class="auth-form" method="post">
                <p>
                    <label for="text-area">Ask Your Question:</label>
                    <textarea id="text-area" name="question" rows="10" cols="5" placeholder="Enter Your Question"></textarea>
                    <p id="charcount" class="charcount">0/1500</p>
                </p>
                <p>
                    <input type="submit" value="Post Question" name="submit"/>
                </p>
            </form>
        </main>

        <main id="main-right">
            <a class="logout" href="index.php">Logout</a>
            <div class="username">username</div>
            <img src="images/avatar.jpg" alt="Avatar" class="image" />
        </main>
    
        <footer id="footer-auth">
            <p class="footer-text"></p>
        </footer>
    </div>
    <script src="js/eventRegisterCreation.js"></script>
</body>

</html>

<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

try {
    $db = new PDO($attr, $db_user, $db_pwd, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
$query = "SELECT
                Users.avatar,
                Users.screenname,
                Questions.question, 
                Questions.created_dt,
                COUNT(Answers.question_id) as total_responses
            FROM Questions
            LEFT JOIN Users
            ON Questions.user_id = Users.user_id
            LEFT JOIN Answers
            ON Answers.question_id = Questions.question_id
            GROUP BY Questions.question_id
            ORDER BY Questions.created_dt desc
            LIMIT 5";

$result = $db->query($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $errors = array();
    $dataOK = TRUE;
    
    $username = test_input($_POST["username"]);
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid Username";
        $dataOK = FALSE;
    }

    $password = test_input($_POST["password"]);
    $passwordRegex = "/^(?=.*[^a-zA-Z]).{6,}$/";
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
        $dataOK = FALSE;
    }

    if ($dataOK) {

        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        $query = "SELECT
            Users.user_id,
            Users.avatar,
            Users.screenname,
            Users.password
            FROM Users
            WHERE (Users.screenname = '$username') AND (Users.password = '$password')";
        $result = $db->query($query);

        if (!$result) {
            $errors["Database Error"] = "Could not retrieve user information";
        } elseif ($row = $result->fetch()){
            
            session_start();

            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["avatar"] = $row["avatar"];
            $_SESSION["screenname"] = $row["screenname"];
            $_SESSION["password"] = $row["password"];
            
            $db = null;
            header("Location: mainAfterLogin.php");
            exit();

        } else {
            // login unsuccessful
            $errors["Login Failed"] = "That username/password combination does not exist.";
        }

    } else {
        $errors['Login Failed'] = "You entered invalid data while logging in.";
    }

    if(!empty($errors)){
        foreach($errors as $type => $message) {
            echo "$type: $message <br />\n";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Social Questions/Answer - Home</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>Social Questions/Answers</h1>
        </header>
        <main id="main-left"></main>
        <main id="main-center">

            <article class="main-question-container">
                
            <?php
                while($row = $result->fetch()){
            ?>
                <div class="main-question-content">
                    <div class="user-info">
                            <img src="<?=$row["avatar"]?>" alt="User Avatar" class="user-avatar" />
                            <span class="user"> <strong><?= $row["screenname"]?></strong></span>
                            <span class="separate">&#x2022;</span>
                            <span class="date-time">Posted on <?= $row["created_dt"]?></span>
                    </div>

                    <h2>
                        <a class="question-detail-link" href="questionDetail.php"><?= $row["question"]?>?</a>
                    </h2> 
                    <div class="response">
                        <p> <?= $row["total_responses"]?> Responses</p>
                    </div>                    
                </div>
            <?php
                }
                $db = null;
            ?>
 
        </main>
        <main id="main-right">
                <form id="login-form" action="" method="post">
                    
                    <div class="main-login">
                        <p>
                            <button type="submit" id="main-login">Login</button>
                            <div>
                                <input type="text" name="username" id="username" placeholder="Username" />
                            </div>
                            <div>
                                <input type="password" name="password" id="password" placeholder="Password" />
                            </div>
                            
                            
                        </p>
                        
                    </div>     
                </form> 
                <a id="signup" href="signup.php">Sign Up</a>
        </main>
        <footer id="footer-auth">
        </footer>
    </div>
    <script src="js/eventRegisterLogin.js"></script>
</body>

</html>

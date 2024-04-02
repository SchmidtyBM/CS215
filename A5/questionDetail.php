<?php
    session_start();
    require_once("db.php");
    if (!isset($_SESSION["user_id"])) {
        header("Location: index.php");
        exit();
    } else {
        $username = $_SESSION["screenname"];
        $password = $_SESSION["password"];
        $user_id = $_SESSION["user_id"];
        $avatar_url = $_SESSION["avatar"];
        $question_id = $_GET["question_id"];
        $question = $_GET["question"];
        $question_dt = $_GET["question_dt"];
        $profile = $_GET["profile"];
        $uname = $_GET["uname"];
    }
    // Connect to the database and verify the connection
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    $query = "SELECT
            Users.avatar,
            Users.screenname,
            Answers.answer,
            Answers.created_dt, 
            SUM(up_vote) AS upvotes, 
            SUM(down_vote) AS downvotes 
        FROM Votes 
        RIGHT JOIN Answers 
        ON Votes.answer_id = Answers.answer_id
        RIGHT JOIN Users
        ON Answers.user_id = Users.user_id
        RIGHT JOIN Questions
        ON Questions.question_id = Answers.question_id
        WHERE (Questions.question_id = '$question_id')
        GROUP BY Answers.answer_id, Questions.question_id, Users.user_id
        ORDER BY Questions.question_id, upvotes - downvotes desc";

    $result = $db->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Question Detail</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>
                Question Detail Page     
            </h1>
        </header>

        <main id="main-left">
        </main>

        <main id="main-center">
            <h2>Question Responses</h2>
            <br />
            <div id="questionSection"> 
                    <div class="user-info">
                        <img src="<?=$profile?>" alt="Avatar" class="image" />
                        <span class="user"><strong><?=$uname?></strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on <?=$question_dt?></span>
                    </div>  
                <h2><?=$question?></h2>
            </div>

            <?php
                while($row = $result->fetch()){
                    if($row["answer"] != null){
            ?>
            <div class="answer">
                    <div class="user-info">
                        <img src="<?=$row["avatar"]?>" alt="Avatar" class="image" />
                        <span class="user"><strong><?=$row["screenname"]?></strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on <?=$row["created_dt"]?></span>
                    </div> 
                <p><?=$row["answer"]?></p>
                <div class="upvote-downvote">
                    <button class="up-arrow">&#x21e7; <?=$row["upvotes"]?></button>
                    <button class="down-arrow">&#x21e9; <?=$row["downvotes"]?></button>
                </div>
            </div>
            <?php
                    }
                    else{
            ?> 
            <div class="answer">
                <p>No Answers Have Been Submitted Yet...</p>
            </div>          
            <?php    
                    }
                }
            ?>

            <div class="auth-form">
                <form id="response-form" action="questionDetail.php" method="post">
                    <p>
                        <label for="text-area" >Post Your Answer:</label>
                        <textarea id="text-area" name="userAns" rows="10" cols="5" placeholder="Enter Your Answer"></textarea>
                        <p id="charcount" class="charcount">0/1500</p>
                        <input type="submit" value="Submit"/>
                    </p>
                </form>
            </div>
        </main>

        <main id="main-right">
            <a class="logout" href="index.php">Logout</a>
            <div class="username"><?=$username?></div>
            <img src="<?=$avatar_url?>" alt="Avatar" class="image" />
        </main>
    
        <footer id="footer-auth">
        </footer>
    </div>
    <script src="js/eventRegisterDetail.js"></script>
</body>

</html>

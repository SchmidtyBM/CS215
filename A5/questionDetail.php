<?php
    session_start();
    require_once("db.php");

    if (!isset($_SESSION["user_id"])){
        header("Location: index.php");
        exit();
    } 
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    $avatar = $_SESSION["avatar"];
    $username = $_SESSION["screen_name"];
    $created_dt = $_SESSION["created_dt"];
    $question_id = $_SESSION["question_id"];

    $query = "SELECT
            Questions.question_id,
            Questions.question,
            Questions.created_dt,
            Users.avatar,
            Users.screen_name,
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

    if (isset($_POST["submit"]) && $_POST["submit"]){

        $user_id = $_SESSION["user_id"];
        $question_id = $_SESSION["question_id"];

        $answer = $_POST["userAns"]; 

        if (strlen($answer) > 0 && strlen($answer) <= 1500){
            $query = "INSERT INTO Answers (question_id, user_id, answer, created_dt) VALUES ('$question_id', '$user_id', '$answer', NOW())";
            $result = $db->exec($query);

            $db = null;
            header("Location: questionDetail.php");
            exit();
        }
        else{
            $error = ("Responses must be non-empty and less than 1500 characters");
        }
    }

    else if(isset($_GET['up_vote'])&& $_GET['up_vote']!=""){
        $upvote= $_GET['up_vote'];
            
    }
    else if(isset($_GET['down_vote'])&& $_GET['down_vote']!=""){
   
        $downvote=$_GET['down_vote'];

    }
    
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
                        <img src="<?=$avatar?>" alt="Avatar" class="image" />
                        <span class="user"><strong><?=$username?></strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on <?=$created_dt?></span>
                    </div>  
                <h2><?=$question_id?></h2>
            </div>

            <?php
            while($row = $result->fetch()){
            ?>
            <div class="answer">
                    <div class="user-info">
                        <img src="<?=$row["avatar"]?>" alt="Avatar" class="image" />
                        <span class="user"><strong><?=$row["screen_name"]?></strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on <?=$row["created_dt"]?></span>
                    </div> 
                <p><?=$row["answer"]?></p>
                <div class="upvote-downvote">
                    <button class="up-arrow" name="upvote">&#x21e7; <?=$row["upvotes"]?></button>
                    <button class="down-arrow" name="downvote">&#x21e9; <?=$row["downvotes"]?></button>
                </div>
            </div>
            <?php
            }
            ?>

            <div class="auth-form">
                <form id="response-form" action="questionDetail.php" method="post">
                    <p>
                        <label for="text-area" >Post Your Answer:</label>
                        <textarea id="text-area" name="userAns" rows="10" cols="5" placeholder="Enter your Answer"></textarea>
                        <p id="charcount" class="charcount">0/1500</p>
                        <input type="submit" name="submit" value="Submit" />
                    </p>
                </form>
            </div>
        </main>

        <main id="main-right">
            <a class="logout" href="logout.php">Logout</a>
            <div class="username"> <?=$username?> </div>
            <img src="<?=$avatar?>" alt="Avatar" class="image" />
        </main>
    
        <footer id="footer-auth">
        </footer>
    </div>
    <script src="js/eventRegisterDetail.js"></script>
</body>

</html>

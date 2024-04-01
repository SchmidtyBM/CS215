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
    }
    // Connect to the database and verify the connection
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }


    $query = "SELECT
                Questions.question_id,
                Questions.question,
                Questions.created_dt as question_dt,
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
            WHERE (Questions.user_id = '$user_id')
            GROUP BY Answers.answer_id, Questions.question_id, Users.user_id
            ORDER BY Questions.question_id, upvotes - downvotes desc";

    $result = $db->query($query);
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Question Management</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>
                Manage Questions       
            </h1>
            
        </header>
        <main id="main-left"></main>
        <main id="main-center">
            <h2>
                <a class="button" href="questionCreation.php">Ask a Question</a>
            </h2>
            <?php
                $prev = null;
                while($row = $result->fetch()){
                    // if theres a new question, close the previous thread
                    if($row["question_id"] != $prev){
                        if ($prev !== null) {
                            echo '</article>';
                        }
                        // open a new question thread
                        echo '<article class="qa-content">';
            ?>
                <div class="question-content">
                    <div class="user-info">
                        <img src="<?=$avatar_url?>" alt="Avatar" class="image" />
                        <span class="user"><strong><?=$username?></strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on <?=$row["question_dt"]?></span>
                    </div>
                    <p class="question">
                        <a class="question-detail-link" href="questionDetail.php?question_id=<?=$row["question_id"]?>&question=<?=htmlspecialchars($row["question"])?>&question_dt=<?=$row["question_dt"]?>"><?=$row["question"]?></a>
                    </p>
                </div>
                <?php
                    }
                    if($row["answer"] != null){
                ?>
                <div class="answer-content">
                    <div class="user-info">
                        <img src="<?=$row["avatar"]?>" alt="Avatar" class="image" />
                        <span class="user"><strong><?=$row["screenname"]?></strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on <?=$row["created_dt"]?></span>
                    </div>
                    <p>
                        <?=$row["answer"]?>
                    </p>
                    
                    <div class="upvote-downvote">
                        <span class="up-arrow">&#x21e7; <?=$row["upvotes"]?></span>
                        <span class="down-arrow">&#x21e9; <?=$row["downvotes"]?></span>
                    </div>
                </div>
                <?php
                    }
                    $prev = $row['question_id'];
                }
                echo '</article>';
                $db = null;
                ?>
        </main>
        <main id="main-right">
            <a class="logout" href="index.php">Logout</a>
            <div class="username"><?=$username?></div>
            <img src="<?=$avatar_url?>" alt="Avatar" class="image" />
        </main>
        <footer id="footer-auth">

        </footer>
    </div>
</body>

</html>

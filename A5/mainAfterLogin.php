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
                Users.avatar,
                Users.screenname,
                Questions.question_id,
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Social Questions/Answer - Home</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>Social Questions/Answers</h1>
        </header>
        <main id="main-left"></main>
        <main id="main-center">
            <h2>
                <a class="ask-button" href="questionCreation.php">Ask a Question</a>
                <a class="manage-button" href="questionManagement.php">Manage Questions</a>
            </h2>
            <!-- This section can be populated dynamically when integrated with a backend -->
            <article class="question-container">
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
                    <a class="question-detail-link" href="questionDetail.php?question_id=<?=$row["question_id"]?>&question=<?=htmlspecialchars($row["question"])?>&question_dt=<?=$row["created_dt"]?>&profile=<?=$row["avatar"]?>&uname=<?=$row["screenname"]?>"><?=$row["question"]?></a>
                    </h2> 
                    <div class="response">
                        <p> <?= $row["total_responses"]?> Responses</p>
                    </div>                    
                </div>
                <?php
                    }
                    $db = null;
                ?>
            </article>
            <!-- Repeat for other questions -->

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

<?php
    require_once("db.php");

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    $query = "SELECT
                    Users.avatar,
                    Users.screen_name,
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
                LIMIT 20";

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
                        <span class="user"> <strong><?= $row["screen_name"]?></strong></span>
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
            </article>
            <!-- Repeat for other questions -->

        </main>
        <main id="main-right">
            <a class="logout" href="index.php">Logout</a>
            <div class="username">Username</div>
            <img src="images/avatar.jpg" alt="Avatar" class="image" />

            
            
        </main>
        <footer id="footer-auth">
        </footer>
    </div>
</body>

</html>

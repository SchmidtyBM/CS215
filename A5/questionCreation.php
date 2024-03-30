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
            <form id="creation-form" class="auth-form" action="questionDetail.php" method="post">
                <p>
                    <label for="text-area">Ask Your Question:</label>
                    <textarea id="text-area" name="question" rows="10" cols="5" placeholder="Enter Your Question"></textarea>
                    <p id="charcount" class="charcount">0/1500</p>
                </p>
                <p>
                    <input type="submit" value="Post Question"/>
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
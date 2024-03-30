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
                        <img src="images/avatar.jpg" alt="Avatar" class="image" />
                        <span class="user"><strong>&lt;user&gt;</strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on &lt;Date/Time&gt;</span>
                    </div>  
                <h2>How do I pass CS215?</h2>
            </div>

            <div class="answer">
                    <div class="user-info">
                        <img src="images/avatar.jpg" alt="Avatar" class="image" />
                        <span class="user"><strong>&lt;user&gt;</strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on &lt;Date/Time&gt;</span>
                    </div> 
                <p>Do the asynchronous material and the labs. Also attend the drop-in sessions!</p>
                <div class="upvote-downvote">
                    <button class="up-arrow">&#x21e7; 5</button>
                    <button class="down-arrow">&#x21e9; 1</button>
                </div>
            </div>

            <div class="answer">
                    <div class="user-info">
                        <img src="images/avatar.jpg" alt="Avatar" class="image" />
                        <span class="user"><strong>&lt;user&gt;</strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on &lt;Date/Time&gt;</span>
                    </div>
                <p>Take time every week to study hard.</p>
                <div class="upvote-downvote">
                    <button class="up-arrow">&#x21e7; 4</button>
                    <button class="down-arrow">&#x21e9; 1</button>
                </div>
            </div>

            <div class="answer">
                    <div class="user-info">
                        <img src="images/avatar.jpg" alt="Avatar" class="image" />
                        <span class="user"><strong>&lt;user&gt;</strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on &lt;Date/Time&gt;</span>
                    </div>
                <p>Listen to the prof and the instructors during the meetings.</p>
                <div class="upvote-downvote">
                    <button class="up-arrow">&#x21e7; 4</button>
                    <button class="down-arrow">&#x21e9; 2</button>
                </div>
            </div>

            <div class="answer">
                    <div class="user-info">
                        <img src="images/avatar.jpg" alt="Avatar" class="image" />
                        <span class="user"><strong>&lt;user&gt;</strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on &lt;Date/Time&gt;</span>
                    </div>
                <p>Idk bro, good luck tho</p>
                <div class="upvote-downvote">
                    <button class="up-arrow">&#x21e7; 2</button>
                    <button class="down-arrow">&#x21e9; 4</button>
                </div>
            </div>

            <div class="answer">
                    <div class="user-info">
                        <img src="images/avatar.jpg" alt="Avatar" class="image" />
                        <span class="user"><strong>&lt;user&gt;</strong></span>
                        <span class="separate">&#x2022;</span>
                        <span class="date-time">Posted on &lt;Date/Time&gt;</span>
                    </div>
                <p>You don't.</p>
                <div class="upvote-downvote">
                    <button class="up-arrow">&#x21e7; 1</button>
                    <button class="down-arrow">&#x21e9; 3</button>
                </div>
            </div>

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
            <div class="username">Username</div>
            <img src="images/avatar.jpg" alt="Avatar" class="image" />
        </main>
    
        <footer id="footer-auth">
        </footer>
    </div>
    <script src="js/eventRegisterDetail.js"></script>
</body>

</html>
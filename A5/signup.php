<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}

$errors = array();
$firstName = "";
$lastName = "";
$email = "";
$username = "";
$password = "";
$dob = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = test_input($_POST["firstName"]);
    $lastName = test_input($_POST["lastName"]);
    $email = test_input($_POST["email"]);
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $dob = test_input($_POST["dateOfBirth"]);;
    
    $nameRegex = "/^[a-zA-Z]+$/";
    $emailRegex = "/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^(?=.*[^a-zA-Z]).{6,}$/";
    $dobRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";
    
    // Validate the form inputs against their Regexes 
    if (!preg_match($nameRegex, $firstName)) {
        $errors["firstName"] = "Invalid First Name";
    }
    if (!preg_match($nameRegex, $lastName)) {
        $errors["lastName"] = "Invalid Last Name";
    }
    if (!preg_match($emailRegex, $email)) {
        $errors["email"] = "Invalid Email";
    }
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid Username";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
    }
    if (!preg_match($dobRegex, $dob)) {
        $errors["dateOfBirth"] = "Invalid DOB";
    }

    $target_file = "";
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);

        $db-> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("PDO Error >> " . $e->getMessage() . "\n<br />");
    }

    $query = "SELECT screenname FROM Users WHERE screenname='$username'";
    $result = $db->query($query);

    $match = $result->fetch();

    if ($match) {
        $errors["Account Taken"] = "A user with that username already exists.";
    }
    
    if (empty($errors)) {

        $query = "INSERT INTO Users (email, screenname, birthdate, avatar, password) VALUES ('$email', '$username', '$dob', 'avatar_stub', '$password')";
        $result = $db->exec($query);

        if (!$result) {
            $errors["Database Error:"] = "Failed to insert user";
        } else {
            $target_dir = "uploads/";
            $uploadOk = TRUE;
        
            $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION));

            $uid = $db->lastInsertId();
            
            $target_file = "uploads/" . $uid . "." . $imageFileType;

            if (file_exists($target_file)) {
                $errors["avatar"] = "Sorry, file already exists. ";
                $uploadOk = FALSE;
            }
                
            if ($_FILES["avatar"]["size"] > 1000000) {
                $errors["avatar"] = "File is too large. Maximum 1MB. ";
                $uploadOk = FALSE;
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors["avatar"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                $uploadOk = FALSE;
            }
                            
            if ($uploadOk) {
                $fileStatus = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
                if (!$fileStatus) {
                    $errors["Server Error"] = "There was an error uploading your image";
                    $uploadOK = FALSE;
                }
            }
            
            if (!$uploadOk)
            {
                $query = "DELETE FROM Users WHERE avatar='$avatar_stub'";
                $result = $db->exec($query);
                if (!$result) {
                    $errors["Database Error"] = "Could not delete user when avatar upload failed";
                }
                $db = null;
            } else {
                $query = "UPDATE Users SET avatar='$target_file' WHERE user_id='$uid'";
                $result = $db->exec($query);
                if (!$result) {
                    $errors["Database Error:"] = "Could not update avatar_url";
                } else {
                    $db = null;
                    header("Location: index.php");
                    exit();
                }
            } 
        } 
    } 
    

    if (!empty($errors)) {
        foreach($errors as $type => $message) {
            print("$type: $message \n<br />");
        }
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>
                Social Questions/Answers
            </h1>
        </header>
        <main id="main-left"></main>
        <main id="main-center">
            <h2 id="create-account">Create an Account</h2>
            <form id="signup-form" class="form" method="post" enctype="multipart/form-data">
                <div class="left-container">
                    <div class="form-input">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="firstName" />
                    </div>

                    <div class="form-input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" />
                    </div>

                    <div class="form-input">
                        <label for="dateOfBirth">Date of Birth</label>
                        <input type="date" name="dateOfBirth" id="dateOfBirth" />
                    </div>

                    <div class="form-input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                    </div>
                </div>
                <div class="right-container">
                    <div class="form-input">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="lastName" />
                    </div>

                    <div class="form-input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" />
                    </div>

                    <div class="form-input">
                        <label for="avatar">Avatar</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" />
                    </div>
                    
                    <div class="form-input">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" />
                    </div>
                </div>
                <div id="submit-button">
                    <button class="button" type="submit">Create Account</button>
                </div>
            </form>
        </main>
        <main id="main-right">
            <p id="login">
                Already a user?
                <a href="index.php">Login</a>
            </p>
        </main>
        <footer id="footer-auth">

        </footer>
    </div>
    <script src="js/eventRegisterSignup.js"></script>
</body>

</html>

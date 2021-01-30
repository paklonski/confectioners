<?php
    /** 
     * signin.php
     * @author Pavel Paklonski
     * 
     */

    /**
     * Showing errors.
     */
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    /**
     * Database connection.
     */
    require "db.php";

    $data = $_POST;

    /**
     * Signing in.
     */
    if (isset($data['do'])) { 
        $errors = array();
        $user = R::findOne('users', 'email = ?', array($data['email']));
        if ($user) {
            if (password_verify($data['password'], $user->password)){
                $_SESSION['logged_user'] = $user;
                header('Location: index.php');
            } else {
                $errors[] = "Wrong password.";
            }
        } else {
            $errors[] =  "User not found.";
        }
    }

    /**
     * Switching styles and setting cookies.
     */
    $style_1 = '<link rel="stylesheet" href="style_1.css">';
    $style_2 = '<link rel="stylesheet" href="style_2.css">';
    $style = isset($_COOKIE['style']) ? $_COOKIE['style'] : 1;
    if (isset($_POST['select']) && isset($_POST['style'])) {
        $style = $_POST['style'];
        setcookie('style', $style, time() + 60 * 60 * 24, '~paklopav');
    }
    $selected = $style == 1 ? $style_1 : $style_2;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <title>Sign In</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" 
            crossorigin="anonymous">
        <?php
            echo $selected;
        ?>
        <link rel="stylesheet" href="print.css" type="text/css" media="print">
        <script defer src="js_validation/signin.js"></script>
    </head>
    <body id="signin_page">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img alt="logo" src="resources/Logo_115x@2x.png"></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="cakes.php">Cakes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="brownies.php">Brownies</a>
                        </li>
                    </ul>
                        <form style="display: inline" action="index.php" method="GET">
                            <button class="ghost py-2 px-5 mx-auto">Back</button>
                        </form>
                </div>
            </div>
        </nav>
        <!-- Sign In Form -->
        <div class="container" id="container">
            <div class="container_signin">
                <form id="form_signin" action="signin.php" method="POST">
                    <h1>Sign In</h1>
                    <!-- E-mail -->
                    <label for='email_signin'></label>
                    <input id="email_signin" class="p-2 my-2 mx-auto" type="email" placeholder="Email (required)" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo @htmlspecialchars($data['email']);?>"/>
                    <!-- Password -->
                    <label for='password_signin'></label>
                    <input id="password_signin" class="p-2 my-2 mx-auto" type="password" placeholder="Password (required)" name="password" required pattern=".{0,30}"/>

                    <span class='text-danger' id='error_signin'></span>
                    <?php if(!empty($errors)) { ?>
                        <span id="span"><?php echo array_shift($errors) ?><br></span>
                    <?php } ?>
                    <!-- Sign In Button -->
                    <button class="py-2 px-4 my-2 mx-auto" name="do">Sign In</button>
                </form>
            </div>
            <div class="right-overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-right p-5">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <form style="display: inline" action="signup.php" method="GET">
                            <button class="ghost py-2 px-4 my-2 mx-auto" id="signUp">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
    /** 
     * signup.php
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
     * Signing up.
     */
    if (isset($data['do'])) {
 
        $errors = array();

        if(trim($data['name']) == '') {
            $errors[] = 'Type your name.';
        }
        if(trim($data['email']) == '') {
            $errors[] = 'Type your email.';
        }
        if(trim($data['password']) == '') {
            $errors[] = 'Type your password.';
        }
        if(R::count('users',"email = ?", array($data['email'])) > 0) {
            $errors[] = "User with this email is already registered.";    
        }
        if(trim($data['password']) != trim($data['password2'])) {
            $errors[] = "Passwords do not match.";
        }
        if (strlen(trim($data['password'])) < 8 || strlen(trim($data['password'])) > 30) {
            $errors[] = "Password must be 8-30 characters.";
        }  

        if (empty($errors)) {

          /**
           * Writing to database.
           * Using htmlspecialchars() function to avoid XSS attacks.
           * Using function trim to trim spaces.
           * Using password_hash() to protect password, password will be hashed and salted.
           */
          $user = R::dispense('users');
          $user->name = htmlspecialchars(trim($data['name']));
          $user->email = htmlspecialchars(trim($data['email']));
          $user->password = password_hash(trim($data['password']), PASSWORD_DEFAULT);
          R::store($user);

          header('Location: index.php');
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
        <title>Sign Up</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" 
            crossorigin="anonymous">
        <?php
            echo $selected;
        ?>
        <link rel="stylesheet" href="print.css" type="text/css" media="print">
        <script defer src="js_validation/signup.js"></script>
    </head>
    <body id="signup_page">
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
        <!-- Sign Up Form -->
        <div class="container" id="container">
            <div class="container_signup">
                <form id="form_signup" action="signup.php" method="POST">
                    <h1>Create Account</h1>
                    <!-- Name -->
                    <label for='name_signup'></label>
                    <input id="name_signup" class="p-2 my-2 mx-auto" type="text" placeholder="Name (required)" name="name" required pattern=".{2,30}[A-Za-z]" value="<?php echo @htmlspecialchars($data['name']);?>"/>
                    <!-- E-mail -->
                    <label for='email_signup'></label>
                    <input id="email_signup" class="p-2 my-2 mx-auto" type="email" placeholder="Email (required)" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo @htmlspecialchars($data['email']);?>"/>
                    <!-- Password -->
                    <label for='password_signup'></label>
                    <input id="password_signup" class="p-2 my-2 mx-auto" type="password" placeholder="Password (must be 8-30 characters)" name="password" required pattern=".{8,30}"/>
                    <!-- Confirm password -->
                    <label for='password2_signup'></label>
                    <input id="password2_signup" class="p-2 my-2 mx-auto" type="password" placeholder="Confirm Password" name="password2" required pattern=".{8,30}"/>
                    
                    <span id='error_signup' class='text-danger'></span>
                    <?php if(!empty($errors)) { ?> 
                        <span id="span"><?php echo array_shift($errors) ?><br></span>
                    <?php } ?>
                    <!-- Sign Up Button -->
                    <button class="py-2 px-4 my-2 mx-auto" type="submit" name="do">Sign Up</button>
                </form>
            </div>
            <div class="left-overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left p-5">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <form style="display: inline" action="signin.php" method="GET">
                            <button class="ghost py-2 px-4 my-2 mx-auto" id="signIn">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
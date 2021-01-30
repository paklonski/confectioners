<?php
    /** 
     * index.php
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

    $servername = "localhost";
    $username = "paklopav";
    $password = "webove aplikace";
    $dbname = "paklopav";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <title>Appleton Sweets</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" 
            crossorigin="anonymous">
        <?php
            echo $selected;
        ?>
        <link rel="stylesheet" href="print.css" type="text/css" media="print">
        <link href="fontawesome/css/all.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#home"><img alt="logo" src="resources/Logo_115x@2x.png"></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="cakes.php">Cakes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="brownies.php">Brownies</a>
                            </li>
                        </ul>
                        <!-- If user logs in, the user's email and the button Logout will by shown, otherwise only the button Login/Sign up. -->
                        <?php if (isset($_SESSION['logged_user'])) : ?>
                            <span class="text-light px-2"><?php echo $_SESSION['logged_user']->email;?></span>
                            <form style="display: inline" action="logout.php" method="GET">
                                <button class="ghost py-2 px-4 mx-auto">Logout</button>
                            </form>
                        <?php else : ?>  
                            <form style="display: inline" action="signin.php" method="GET">
                                <button class="ghost py-2 px-3 mx-auto">Login / Sign up</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
            <!-- Video container -->
            <div id="home" class="mid">
                <video autoplay muted loop poster="resorces/background.png">
                    <source class="embed-responsive" src="resources/video-background.webm" type="video/webm">
                </video>
                <div class="about text-center">
                    <h2 class="text-light display-4 font-weight-bold">Fresh Confectionaries At Your Home</h2>
                    <p class="text-light mx-auto">With Love. In A Moment.</p>
                    <!-- If user logs in, the button Add new offer will by shown, otherwise - Service Phone Number. -->
                    <?php if (isset($_SESSION['logged_user'])) : ?>
                        <form style="display: inline" action="newoffer.php" method="GET">
                            <button class="py-2 px-4 my-2 mx-auto">Add offer</button>
                        </form>
                    <?php else : ?>  
                        <form style="display: inline" action="#" method="GET">
                            <button class="py-2 px-4 my-2 mx-auto"><i class="fas fa-phone-alt text-light mx-1"></i> 777 580 553</button>
                        </form>
                    <?php endif; ?>
                    <!-- Style selection container -->
                    <div id='styles'>
                        <div class='text-center text-light pt-3'>
                            <form action='#' method = 'POST'>
                                <label>
                                    <input type='radio' name='style' <?php echo $style == 1 ? 'checked' :'' ?> value="1"> Brown Style
                                </label>  
                                <br>
                                <label>
                                    <input type='radio' name='style' <?php echo $style == 2 ? 'checked' :'' ?> value="2"> Pink Style
                                </label>
                                <br>
                                <button class="py-1 px-4 my-2 mx-auto" name="select">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <footer id="footer" class="page-footer font-small">
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
                <a href="https://www.linkedin.com/in/paklonski/"> Pavel Paklonski</a>
            </div>
        </footer>   
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" 
                integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" 
                crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" 
                integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" 
                crossorigin="anonymous">
        </script>
    </body>
</html>
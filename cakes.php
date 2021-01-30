<?php
    /** 
     * cakes.php
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
     * Setting pagination.
     */
    $results_per_page = 3;
    $sql = "SELECT * FROM cakes";
    $result = mysqli_query($conn, $sql);
    $number_of_results = mysqli_num_rows($result);
    $number_of_pages = ceil($number_of_results/$results_per_page);
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $this_page_first_result = ($page - 1)*$results_per_page;

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
        <title>Cakes</title>
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
                        <!-- If user logs in, the user's email and the button Logout will by shown, otherwise - only the button Login/Sign up. -->
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
        </header>
        <section id="cakes" class="background cakes-background py-3">
            <div class="col mx-auto align-items-center my-4">
                <div class="heading text-center">
                    <h3 class="text-light font-weight-bold py-3">Select from our irresistible range of cakes, ready to be picked up in store, or be delivered fresh to your door!<br>
                        Available throughout Prague, you can be sure you'll always find the perfect cake for your special occasion.
                    </h3>
                </div>
                <div class="container row mx-auto text-center align-items-center justify-content-center mx-5">
                    <?php
                        // Retrieve selected results from database and display them in page.
                        $sql = "SELECT * FROM cakes LIMIT " . $this_page_first_result . ',' . $results_per_page;
                        $result = mysqli_query($conn, $sql);
                        // If a list of brownies isn't empty, offers will be printed.
                        if ($result) {
                            while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="item-background col-lg-3 col-12 p-5">
                            <img class="img-fluid" alt="logo" src="uploads/<?php echo $row['image'];?>">
                            <h5 class="font-weight-bold pt-4"> <?php echo $row['name'];?> </h5>
                            <p> <?php echo $row['description'];?> </p>
                            <h5> <?php echo $row['price'];?> CZK </h5>
                            <form style="display: inline" action="#">
                                <button class="py-2 px-4 my-2 mx-auto"><i class="fas fa-phone-alt text-light mx-1"></i> <?php echo $row['phonenumber'];?></button>
                            </form>
                        </div>
                    <?php 
                            }
                        } else {
                            // If a user logs in, the button Add offer will be shown.
                            if (isset($_SESSION['logged_user'])) {
                    ?>
                        <form style="display: inline" action="newoffer.php" method="GET">
                            <button class="py-2 px-4 my-5 mx-auto">Add offer</button>
                        </form> 
                    <?php 
                            } else {
                    ?>
                         <h5 class="text-light font-weight-bold py-5">There are currently no offers.<br> Come back later. </h5>
                    <?php
                            }
                        }
                    ?>
                    <!-- Pagination Bar -->
                    <nav id="nav">
                        <ul class="pagination pagination-sm">
                    <?php
                        // Display the links to the pages.
                        for ($page = 1; $page <= $number_of_pages; $page++) {
                    ?>
                            <li class="page-item"><a class="page-link" href="cakes.php?page=<?php echo $page?>"><?php echo $page?></a></li>
                    <?php 
                        } 
                    ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
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
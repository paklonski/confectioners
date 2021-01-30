<?php    
    /** 
     * newoffer.php
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
     * Giving $chef data from session with name 'logged_user'.
     */
    if(isset($_SESSION['logged_user'])){
        $chef = $_SESSION['logged_user'];
    }

    /**
     * Writing an offer to the database.
     */
    if (isset($data['do'])) {

        $errors = array();

        if(trim($data['name']) == '') {
            $errors[] = 'Type a name.';
        }
        if(trim($data['description']) == '') {
            $errors[] = 'Type a description.';
        }
        if(trim($data['price']) == '') {
            $errors[] = 'Type a price.';
        }

        if (empty($errors)) {

            /**
             * If a description of the offer is too long, the one will be cut to 100 symbols.
             * If a name of the offer is too long, the one will be cut to 50 symbols.
             * Using htmlspecialchars() function to avoid XSS attacks.
             * Using function trim to trim spaces.
             */
            if (strlen($data['description']) < 100) {
                $description = trim($data['description']);
                $description = htmlspecialchars($description);
            } else { 
                $description = $data['description'];
                $description = strip_tags($description);
                $description = substr($description,0, 99);
                $description = rtrim($description, "!,.-");
                $description = $description."...";
            }
            if (strlen($data['name'])< 50) {
                $name = $data['name'];
                $name = htmlspecialchars($name);
                $name = strip_tags($name);
            } else {
                $name = $data['name'];
                $name = strip_tags($name);
                $name = substr($name, 0, 49);
                $name = rtrim($name, "!,.-");
                $name = $name."...";
            }

            /**
             * Adding a file to the directory for uploads.
             */
            $uploads_dir = "uploads/";
            $image_name = $_FILES["image"]["name"];
            $target =  $uploads_dir . $image_name;

            /**
             * Writing to database.
             */
            if ($data['type'] == 'cakes') {
                $offer = R::dispense('cakes');
            } else if ($data['type'] == 'brownies') {
                $offer = R::dispense('brownies');
            } else {
                $offer = R::dispense('offers');
            }
            $offer->name =$name;
            $offer->description = $description;
            $offer->price = $data['price'];
            $offer->phonenumber = $data['phonenumber'];
            $offer->chef = $chef['name'];
            $offer->email = $chef['email'];
            $offer->image = $image_name;
            R::store($offer);
            header('Location: newoffer.php');
            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
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
        <title>New Offer</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" 
            crossorigin="anonymous">
        <?php
            echo $selected;
        ?>
        <link rel="stylesheet" href="print.css" type="text/css" media="print">
        <script defer src="js_validation/offer.js"></script>
    </head>
    <body id="offer_page">
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
                        <span class="text-light px-2"><?php echo $_SESSION['logged_user']->email;?></span>
                        <form style="display: inline" action="logout.php" method="GET">
                            <button class="ghost py-2 px-4 mx-auto">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <!-- New Offer Form -->
        <div class="container" id="container">
            <form id="form_offer" action="newoffer.php" method="POST" enctype="multipart/form-data">
                <h1 class="mx-auto">New Offer</h1>
                <!-- Type Selection -->
                <span>
                    <label for="type">Choose the confectionery:</label>
                    <select id="type" class="p-1 my-1 mx-auto" name="type">
                        <option value="cakes">Cakes</option>
                        <option value="brownies">Brownies</option>
                    </select>
                </span>
                <!-- Image -->
                <label for='image_offer'></label>
                <input id='image_offer' class="p-2 my-1 mx-auto" type="file" name="image" accept="image/*" required>
                <!-- Name -->
                <label for='name_offer'></label>
                <input id="name_offer" class="p-2 my-1 mx-auto" type="text" placeholder="Name (required)" name="name" required pattern=".{2,30}[a-zA-Z0-9]" value="<?php echo @htmlspecialchars($data['name']);?>"/>
                <!-- Description -->
                <label for='description_offer'></label>
                <textarea id="description_offer" class="p-2 my-1 mx-auto" rows="3" placeholder="Write your description (required)" name="description" required ></textarea>
                <!-- Price -->
                <label for='price_offer'></label>
                <input id="price_offer" class="p-2 my-1 mx-auto" type="text" placeholder="Price (required)" name="price" required pattern="[0-9]+" value="<?php echo @htmlspecialchars($data['price']);?>"/>
                <!-- Phone Number -->
                <label for='phonenumber_offer'></label>
                <input id="phonenumber_offer" class="p-2 my-1 mx-auto" type="text" placeholder="Phone number (9-digit required)" name="phonenumber" required pattern="^[0-9]{9}$" value="<?php echo @htmlspecialchars($data['phonenumber']);?>"/>
                
                <span class='text-danger' id='error_offer'></span>
                <?php if(empty($errors)) {} else { ?> 
                    <span id="span"><?php echo array_shift($errors) ?><br></span>
                <?php } ?> 
                <!-- Add Button -->
                <button class="py-2 px-4 my-2 mx-auto" name="do">Add</button>
            </form>
        </div>
    </body>
</html>
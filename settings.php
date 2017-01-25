<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="Vadym Borys">
        <!--<link rel="icon" href="../../favicon.ico">-->

        <title>Eventer - login</title>

        <!-- Bootstrap core CSS -->
        <link href="css/style.css" rel="stylesheet">
        <!-- Bootstrap theme -->

        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="theme.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="js/bootstrap.js"></script>
    </head>

    <body>


        <br><br><br><br>

        <?php
        include 'Bootstrap.php';
        include 'Login.php';
        $login = new Login();
        $nickname = $login->getLoggedUserNickname();

        $id = $login->getLoggedUserId();
        // $btstr = new Bootstrap();
        //Bootstrap::message(Bootstrap::ERROR, "pizdec!", "o kurwa");
        if ($id == NULL) {
            // $loc = "index.php";
            header("Location: index.php");
        }

        //on buttons click
        if (isset($_REQUEST['cancel'])) {
            header("Location: index.php");
        } elseif (isset($_REQUEST['save'])) {
            $blad = $login->checkUserData($_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['email']);

            if (!$blad) {
                $name = $_REQUEST['name'];
                $surname = $_REQUEST['surname'];
                $email = $_REQUEST['email'];
                $oldpass = $_REQUEST['oldpass'];
                $newpass = $_REQUEST['newpass'];
                $repass = $_REQUEST['repass'];

                $np = 0; //0 - no new, 1 - new ok, 2 - new error

                if ($login->checkPass($id, $oldpass)) {
                    if (($newpass != "" ) || ($repass != "")) {
                        if ($newpass == $oldpass) {
                            $np = 1;
                        } else {
                            $np = 2;
                        }
                    } else {
                        $np = 0;
                    }

                    switch ($np) {
                        case 0: $login->updateInfo($id, $name, $surname, $email, $oldpass);
                            $_REQUEST['updated'] = true;
                            header("Location: settings.php");
                            break;
                        case 1: $login->updateInfo($id, $name, $surname, $email, $newpass);
                            $_REQUEST['updated'] = true;
                            header("Location: settings.php");
                            break;
                        case 2: Bootstrap::message(Bootstrap::ERROR, "Error", "Passwords aren't same");                            
                            break;
                    }
                } else {
                    Bootstrap::message(Bootstrap::ERROR, "Error", "Wrong password");
                }
            } else {
                Bootstrap::message(Bootstrap::ERROR, "Error", "Enter correct data");
            }
        }
        ?>

        <div class="container theme-showcase" role="main">

        <?php
        if (isset($_REQUEST['updated']))
        {
            Bootstrap::message(Bootstrap::SUCCESS, "Well", "your data has been updated");
        }
        $arr = $login->getUserData($id);
        
        $nm = $arr[0][0];
        $sn = $arr[0][1];
        $em = $arr[0][2];
        echo '<form action="settings.php" method="post">
                <Br>
                <p>
                    <input type="text" placeholder="name"  name="name" required class="form-control input-lg" value="'.$nm.'">
                </p>
                <p>
                    <input type="text" placeholder="surname"  name="surname" required class="form-control input-lg" value="'.$sn.'">
                </p>
                <p>
                    <input type="email" placeholder="email"  name="email" required class="form-control input-lg" value="'.$em.'">
                </p>
                <p>
                    <input type="password" placeholder="old password"  name="oldpass" required class="form-control input-lg" value="">
                </p>
                <br>
                <p>
                    <input type="password" placeholder="new password"  name="newpass"  class="form-control input-lg" value="">
                </p>
                <p>
                    <input type="password" placeholder="repeat password"  name="repass"  class="form-control input-lg" value="">
                </p>
                
                <input type="submit" class="btn btn-lg btn-success" name="save" value="Save">
                <input type="submit" class="btn btn-lg btn-info" name="cancel" value="Cancel">
            </form>';
        ?>

        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
        <script src="js/bootstrap.min2.js"></script>
        <script src="js/bootstrap.min3"></script>







        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand " href="index.php">Eventer</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
<?php
if ($id != null) {
    Bootstrap::echoMyEvents();
}
?>
                        <li><a href="contact.php">Contact</a></li>
<?php
// echo "TEST: id = ".$id;
if ($id == NULL) {
    echo '<li><a href="login_form.php">Login</a></li>';
} else {
    Bootstrap::echoDropdown($nickname);
}
?>

                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
                        <?php ?>
    </body>
</html>

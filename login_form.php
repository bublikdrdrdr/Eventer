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
        if ($id != NULL) {
           // $loc = "index.php";
            header("Location: index.php");
        }

        //on buttons click
        if (isset($_REQUEST['submit_login'])) {
            $lg = $_REQUEST['Lemail'];
            $pass = $_REQUEST['Lpassword'];
            $login_uid = $login->login($lg, $pass);
            // echo "TEST: your ID: $login_uid ////<br>email:$lg, pass:$pass///";

            if ($login_uid == null) {
                Bootstrap::message(Bootstrap::ERROR, "Error ", "Wrong email or password");
            } else {
                header("Location: index.php");
            }
        } else if (isset($_REQUEST['submit_registration'])) {
            
            $err = false;
            if (isset($_REQUEST['Remail'])) {
                $Remail = $_REQUEST['Remail'];
            } else {
                $err = true;
                Bootstrap::message(Bootstrap::ERROR, "Error", "Enter email");
            } 
            
            if (isset($_REQUEST['Rname'])) {
                $Rname = $_REQUEST['Rname'];
            } else {
                $err = true;
                Bootstrap::message(Bootstrap::ERROR, "Error", "Enter name");
            }
            
            if (isset($_REQUEST['Rsurname'])) {
                $Rsurname = $_REQUEST['Rsurname'];
            } else {
                $err = true;
                Bootstrap::message(Bootstrap::ERROR, "Error", "Enter surname");
            }
            
            if (isset($_REQUEST['Rnickname'])) {
                $Rnickname = $_REQUEST['Rnickname'];
            } else {
                $err = true;
                Bootstrap::message(Bootstrap::ERROR, "Error", "Enter nickname");
            }
            
            if (isset($_REQUEST['Rpassword'])) {
                $Rpassword = $_REQUEST['Rpassword'];
            } else {
                $err = true;
                Bootstrap::message(Bootstrap::ERROR, "Error", "Enter password");
            }
            
            if(isset($_REQUEST['RRpassword']))
            {
                $RRpassword = $_REQUEST['RRpassword'];
                if ($RRpassword === $Rpassword)
                {
                    //емм... всьо
                } else
                {
                    $err = true;
                    Bootstrap::message(Bootstrap::ERROR, "Error", "Repeat password");
                }
            } else {
                $err = true;
                 Bootstrap::message(Bootstrap::ERROR, "Error", "Repeat password");
            }
            
            if ($err == true)
            {
        //    header("Location: login_form.php#registration"); //NIE DZIALA!
            } else
            {
                $res = $login->register($Rname, $Rsurname, $Rnickname, $Rpassword, $Remail);
                switch ($res) {
                    case Login::EMAIL_ALREADY_REGISTERED:
                        Bootstrap::message(Bootstrap::ERROR, "Error", "This email is already registered");
                       // header("Location: login_form.php#registration");
                        break;
                        case Login::NICKNAME_ALREADY_REGISTERED:
                        Bootstrap::message(Bootstrap::ERROR, "Error", "This nickname is already registered");
                       // header("Location: login_form.php#registration");
                        break;
                        case Login::REGISTRATION_IS_DONE:
                            Bootstrap::message(Bootstrap::SUCCESS, "Well", "You have been registrated. Now sign in with your email and password");
                  //          echo 'ZBS!!!';
                           // header("Location: index.php");
                    default:
                        break;
                }
                
            }
        } else if (isset($_REQUEST['submit_forgot'])){
            if (isset($_REQUEST['Femail']))
            {
                $Femail = $_REQUEST['Femail'];
                $free = $login->checkEmail($Femail);
                if ($free == true)
                {
                    Bootstrap::message(Bootstrap::ERROR, "Error", "This email is not registered");
                } else
                {
                    Bootstrap::message(Bootstrap::WARNING, "Info:", "Nie mam możliwośći wysłania email. Następny raz proszę pamiętać hasło");
                }
            } else
            {
                Bootstrap::message(Bootstrap::ERROR, "Error", "Enter email");
            }
        }
        ?>

        <div class="container theme-showcase" role="main">

            <!--For login-->        
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a data-toggle="tab" href="#login">Login</a></li>
                <li><a data-toggle="tab" href="#registration">Registration</a></li>
                <li><a data-toggle="tab" href="#forgot">Forot password</a></li>
            </ul>

            <div class="tab-content">
                <div id="login" class="tab-pane fade in active">
                    <form action="login_form.php" method="post">
                        <Br>
                        <p>
                            <input type="email" placeholder="email"  name="Lemail" required class="form-control input-lg">
                        </p><p>
                            <input type="password" placeholder="password" pattern="^(?=.*[a-zA-Z])(?=.*[0-9]).{6,30}$" name="Lpassword" required class="form-control input-lg">
                        </p>
                        <input type="submit" class="btn btn-lg btn-default" name="submit_login" value="Sign in">
                    </form>
                </div>
                <div id="registration" class="tab-pane fade">
                    <form action="login_form.php" method="post">
                        <Br>
                        <p><!--pattern="^(\S+)@([a-z0-9-]+)(\.)([a-z]{2,4})(\.?)([a-z]{0,4})+$"-->
                            <input type="email" placeholder="email"  name="Remail" required class="form-control input-lg">
                        </p>
                        <p>
                            <input type="text" placeholder="name"  name="Rname" required class="form-control input-lg">
                        </p>
                        <p>
                            <input type="text" placeholder="surname"  name="Rsurname" required class="form-control input-lg">
                        </p>
                        <p>
                        <div class="input-group">
                            <input type="text" placeholder="nikcname"  name="Rnickname" pattern="^[a-zA-Z][a-zA-Z0-9_.-]{3,}$" required class="form-control input-lg">
                            <span class="input-group-btn">
                                <button class="btn btn-lg btn-default" name="check" onclick="">Check</button>
                            </span>
                        </div>
                        </p>
                        <p>
                            <input type="password" placeholder="password" pattern="^(?=.*[a-zA-Z])(?=.*[0-9]).{6,30}$" name="Rpassword" required class="form-control input-lg">
                        </p>
                        <p>
                            <input type="password" placeholder="repeat password" pattern="^(?=.*[a-zA-Z])(?=.*[0-9]).{6,30}$" name="RRpassword" required class="form-control input-lg">
                        </p>
                        <input type="submit" class="btn btn-lg btn-success" name="submit_registration" value="Sign up">
                    </form>
                </div>
                <div id="forgot" class="tab-pane fade">
                    <form action="login_form.php" method="post">
                        <Br>
                        <p>
                            <input type="email" placeholder="email"  name="Femail" required class="form-control input-lg">
                        </p>
                        <input type="submit" class="btn btn-lg btn-primary" name="submit_forgot" value="Restore password">
                    </form>
                </div>
            </div>






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

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

        <title>Eventer</title>

        <!-- Bootstrap core CSS -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/mystyle.css" rel="stylesheet">
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
        // echo "TEST: $nickname";
        // $btstr = new Bootstrap();
        //Bootstrap::message(Bootstrap::ERROR, "pizdec!", "o kurwa");
        //    echo "ISSET: ".isset($_REQUEST['logout']);
        if (isset($_REQUEST['logout'])) {
            $login->logout();
            header("Location: index.php");
        }
        ?>

        <div class="container theme-showcase" role="main">

            <?php
            if ($id == null) {
                echo ' <div class="jumbotron">
                <h1>Witamy!</h1>
                <p>Żeby zobaczyć wszystkie eventy/imprezy z twojej okolicy - zaloguj się lub utwórz nowe konto</p>
            </div> ';
            } else {
                include 'event.php';
                //get list of events
                $a = $login->getAllEvents();
              //  print_r($a);
           //   echo 'interests: '.$_REQUEST['interests'];
            //  echo 'int_event_id: '.$_REQUEST['int_event_id'];
                if (isset($_REQUEST['interests']) && (isset($_REQUEST['int_event_id']))) {//znaczy, ze idziemy albo nie
                    $interest = $_REQUEST['interests'];
                    $int_event_id = $_REQUEST['int_event_id'];
                  /*  
                    for ($i = 0; $i < count($a); $i++)
                    {
                        array_push($aa, $a[$i][0]);
                    }
                    echo 'RATWD';   
                    if (in_array($int_event_id, $a))*/
                    
                        $event = new event($int_event_id, $id, $login);
                        $event->rate($interest);
                        
                        header("Location: index.php");
                    
                }
                $event;
                for ($i = 0; $i < count($a); $i++) {
                    $event = new event($a[$i][0], $id, $login);
                    echo $event->getEcho($login);
                }
            }
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
                        <?php
                        // put your code here
                        ?>
    </body>
</html>

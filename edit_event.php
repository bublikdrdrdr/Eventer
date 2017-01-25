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
        if ($_REQUEST['id']=='') {
           header("Location: index.php");
        }
        if (!is_numeric($_REQUEST['id']))
        {
            header("Location: index.php");
        }
        $event_id = $_REQUEST['id'];
        include 'event.php';
       // echo 'EVENTID:'.$event_id.", ID:".$id;
        $event = new event($event_id, $id, $login);
        if (($event->author!=$id)&&($_REQUEST['id']!=-1))
        {
            header("Location: index.php");
        }
       // print_r($event);
        // echo "TEST: $nickname";
        // $btstr = new Bootstrap();
        //Bootstrap::message(Bootstrap::ERROR, "pizdec!", "o kurwa");
        //    echo "ISSET: ".isset($_REQUEST['logout']);
        if (isset($_REQUEST['cancel'])) {
            header("Location: index.php");
        } elseif (isset($_REQUEST['remove'])) {
            $event->remove();
            header("Location: index.php");
        } elseif (isset($_REQUEST['save'])) {
            $blad = false;
            if (!isset($_REQUEST['name'])) {
                $blad = true;
                Bootstrap::message(Bootstrap::ERROR, "Error", "Wrong event name");
            }
            if (!isset($_REQUEST['description'])) {
                $blad = true;
                Bootstrap::message(Bootstrap::ERROR, "Error", "Wrong event description");
            }
            if (!$blad) {
                $event->name = $_REQUEST['name'];
                $event->description = $_REQUEST['description'];
                $event->image = $_REQUEST['image'];
                $event->save();
                header("Location: index.php");
            }
        }
        ?>

        <div class="container theme-showcase" role="main">

        <?php

        if ($id == null) {
            header("Location: index.php");
        } else {
            $er = false;
            if ($event->loaded == FALSE)
            {
                $er = true;
            }

            if ($event_id==-1)
            {
                $er = false;
            }
            
            if ($er) {
                Bootstrap::message(Bootstrap::ERROR, "Error", "Event not found");
            } else {
                if ($event_id==-1)
                {
                    $event->eventID = -1;
                    $event->name = "";
                    $event->description = "";
                    $event->image = "";
                }
                echo '<form action="edit_event.php?id='.$event_id.'" method="post">
                <Br>
                <p><!--pattern="^(\S+)@([a-z0-9-]+)(\.)([a-z]{2,4})(\.?)([a-z]{0,4})+$"-->
                    <input type="text" placeholder="event name"  name="name" required class="form-control input-lg" value="'.$event->name.'">
                </p>
                <p>
                    <textarea rows="10" placeholder="description"  name="description" required class="form-control input-lg">'.$event->description.'</textarea>
                </p>
                <p>
                    <input type="text" placeholder="image link(optional)"  name="image" class="form-control input-lg" value="'.$event->image.'">
                </p>
                <input type="submit" class="btn btn-lg btn-success" name="save" value="Save">
                <input type="submit" class="btn btn-lg btn-info" name="cancel" value="Cancel">
                <input type="submit" class="btn btn-lg btn-danger" name="remove" value="Remove event">
            </form>';
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

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
    <!-- Bootstrap theme -->
    
    <link href="css/bootstrap.css" rel="stylesheet">
  
    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/bootstrap.js"></script>
    <style>body {
    background-image: url("image/kebab.png");
}</style>
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
    ?>

    <div class="container theme-showcase" role="main">
        
        <div class="jumbotron" style="background-color: rgba(240, 240, 240, 0.8)">
        <h1>Created by Vadym Borys <span class="label label-primary">IIST5.1.2</span></h1>
        <p><a href="https://vk.com/bublik.drdrdr" target="_blank"><button type="button" class="btn btn-lg btn-default">VK</button></a>
        <a href="https://facebook.com/bublik.drdrdr" target="_blank"><button type="button" class="btn btn-lg btn-default">Facebook</button></a>
        <a href="mailto:bublik.drdrdr@gmail.com"><button type="button" class="btn btn-lg btn-default">bublik.drdrdr@gmail.com</button></a></p>
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
                if ($id!=null)
                {
                    Bootstrap::echoMyEvents();
                }
            ?>
            <li><a href="contact.php">Contact</a></li>
            <?php
                  
                     // echo "TEST: id = ".$id;
                    if ($id==NULL)
                    {
                        echo '<li><a href="login_form.php">Login</a></li>';
                    }
                    else
                    {
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

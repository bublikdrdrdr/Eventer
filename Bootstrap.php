<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author Bublik
 */
class Bootstrap {

    //put your code here
    const ERROR = 1;
    const SUCCESS = 2;
    const WARNING = 3;

    static function message($status, $caption, $message) {
        switch ($status) {
            case Bootstrap::ERROR: echo '<div class="alert alert-danger" role="alert">
        <strong>' . $caption . ' </strong>', $message . '</div>';
                break;
            case Bootstrap::SUCCESS: echo '<div class="alert alert-success" role="alert">
        <strong>' . $caption . ' </strong>', $message . '</div>';
                break;
            case Bootstrap::WARNING: echo '<div class="alert alert-warning" role="alert">
        <strong>' . $caption . ' </strong>', $message . '</div>';
                break;
            default :break;
        }
    }

    static function echoDropdown($nickname) {
        echo '<li class="dropdown">
                
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  ' . $nickname . '
                  
                  <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="edit_event.php?id=-1">Create event</a></li>
                <li><a href="settings.php">Account settings</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="index.php?logout=true" >Logout</a></li>
              </ul>
            </li>';
    }

    static function echoMyEvents() {
        echo '<li><a class="active" href="my_events.php">MyEvents</a></li>';
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of event
 *
 * @author Bublik
 */
class event {

    //put your code here
    public $name;
    public $description;
    public $image;
    public $author;
    public $my;
    public $eventID;
    public $goingstatus; //0 - none, 1 - going, 2 - maybe, 3 - not interesting
    public $dbs;
    public $loaded;

    function __construct($eventID, $myID, $login) {
        // include 'DB.php';
        //include 'Login.php';
        $this->loaded = true;
        $this->my = $myID;
        $this->eventID = $eventID;
        $this->dbs = new DB(SQLconnect::server, SQLconnect::user, SQLconnect::pass, SQLconnect::db);
        //  echo 'EVENTID:'.$eventID."   MYID:".$myID;
        $sql = "SELECT e.name, e.description, e.image, e.id_author, lower(es.name) FROM events e
left JOIN event_members em on em.id_event = e.id_event
left JOIN member_types es on es.id_type = em.id_type
WHERE e.id_event = '".$eventID."' and em.id_user = '".$myID."'";
        $data = $this->dbs->select($sql, array("name", "description", "image", "id_author", "lower(es.name)"));
        
        if (count($data) == 0) {
            $this->loaded = false;
        } else {
            $this->name = $data['0'][0];
            $this->description = $data['0'][1];
            $this->image = $data['0'][2];
            $this->author = $data['0'][3];
            $s = $data['0'][4];
            switch ($s) {
                case "going": $this->goingstatus = 1;
                    break;
                case "interested":$this->goingstatus = 2;
                    break;
                case "not interesting":$this->goingstatus = 3;
                    break;
                default :$this->goingstatus = 0;
                    break;
            }
            //echo "<b>$s</b>";
        }
    }

    public function remove() {
        $sql = "DELETE FROM event_members WHERE event_members.id_event = ". $this->eventID;
        $this->dbs->delete($sql);
        $sql = "DELETE FROM `events` WHERE `events`.`id_event` = " . $this->eventID;
        $this->dbs->delete($sql);
    }

    public function save() {
        $sql = "";
        if ($this->eventID == -1) {
            $sql = "INSERT INTO `events` (`id_event`, `name`, `description`, `image`, `id_author`) VALUES (NULL, '" . $this->name . "', '" . $this->description . "', '" . $this->image . "', '" . $this->my . "');";
        } else {
            $sql = "UPDATE `events` SET `name` = '" . $this->name . "', `description` = '" . $this->description . "', `image` = '" . $this->image . "', `id_author` = '" . $this->my . "' WHERE `events`.`id_event` = '" . $this->eventID . "'";
        }
        //   header("Location: index.php?".$sql);
        $this->dbs->insert($sql);
    }

    public function rate($interest) { //2-going; 1-interesting; 3-not interesting
        $sql = "DELETE FROM event_members WHERE `event_members`.`id_user` = " . $this->my . " and `event_members`.`id_event` = " . $this->eventID;
        $this->dbs->delete($sql);
        //  echo $sql."<Br>";
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `event_members` (`id_member`, `id_user`, `id_event`, `date`, `id_type`) VALUES (NULL, '" . $this->my . "', '" . $this->eventID . "', '$date', '" . $interest . "');";
        $this->dbs->insert($sql);
         // echo $sql;
    }

    public function getEcho($login) {   //viewprofile nie robilem
        $editbutton = "";

        if ($this->my == $this->author) {
            $editbutton = '<a href = "edit_event.php?id=' . $this->eventID . '"><button class="btn btn-default" >Edit</button></a>';
        }

        $going = "";
        switch ($this->goingstatus) {
            case 0: break;
            case 1: $going = '<span class="label label-success">you are going</span>';
                break;
            case 2: $going = '<span class="label label-warning">maybe you are going</span>';
                break;
            case 3: $going = '<span class="label label-danger">you aren\'t going</span>';
                break;
        }

        $desctype = "eventdescription";

        $img = "";
        // echo $this->image;
        if ($this->image != "") {
            $img = '<div class="eventimg">
                        <img src="' . $this->image . '" class="img-thumbnail" alt="Image">
                </div>';
            $desctype = "eventdescriptionimg";
        }



        $string = '<div class="well event">
                
                <div class="eventname">
                    <h2 >' . $this->name . ' ' . $going . '</h2>
                </div>
                <div class="eventbuttons">
                    <a href="viewprofile.php"><button class="btn btn-link">' . $login->getNickname($this->author) . '</button></a>
                        

                    <a href="index.php?interests=2&int_event_id=' . $this->eventID . '">
                    <button class="btn btn-success" name="going">Going</button>
                    </a>
                    
                    <a href="index.php?interests=1&int_event_id=' . $this->eventID . '">
                    <button class="btn btn-info" name="maybe">Maybe</button>
                    </a>
                    
                    <a href="index.php?interests=3&int_event_id='.$this->eventID.'">
                    <button class="btn btn-danger" name="notint">Not interesting</button>
                    </a>
                    ' . $editbutton . '
                </div>
                 
                <div class="' . $desctype . '">
                    ' . $this->description . '
                    </div>
                
                    ' . $img . '
               
        </div>';
        //TODO: dodac going/interesting...

        return $string;
    }

    public function getMyEcho($login) {   //viewprofile nie robilem
        $editbutton = "";

        if ($this->my == $this->author) {
            $editbutton = '<a href = "edit_event.php?id=' . $this->eventID . '"><button class="btn btn-default" >Edit</button></a>';
        }

        $going = "";
        switch ($this->goingstatus) {
            case 0: break;
            case 1: $going = '<span class="label label-success">you are going</span>';
                break;
            case 2: $going = '<span class="label label-warning">maybe you are going</span>';
                break;
            case 3: $going = '<span class="label label-danger">you aren\'t going</span>';
                break;
        }

        $desctype = "eventdescription";

        $img = "";
        // echo $this->image;
        if ($this->image != "") {
            $img = '<div class="eventimg">
                        <img src="' . $this->image . '" class="img-thumbnail" alt="Image">
                </div>';
            $desctype = "eventdescriptionimg";
        }



        $string = '<div class="well event">
                
                <div class="eventname">
                    <h2 >' . $this->name . ' ' . $going . '</h2>
                </div>
                <div class="eventbuttons">
                    <a href="viewprofile.php"><button class="btn btn-link">' . $login->getNickname($this->author) . '</button></a>
                    ' . $editbutton . '
                </div>
                 
                <div class="' . $desctype . '">
                    ' . $this->description . '
                    </div>
                
                    ' . $img . '
               
        </div>';

        return $string;
    }

}

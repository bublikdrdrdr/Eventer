<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author Bublik
 */
class DB {
    //put your code here
    private $mysqli;
    
    public function __construct($serwer, $user, $pass, $klienci) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $klienci);
        /* sprawdz połączenie */
        if ($this->mysqli->connect_errno) {
            $ms = "Nie udało sie połączenie z serwerem: ".$mysqli->connect_error."\n";
            Bootstrap::message(Bootstrap::ERROR, "SQL error", $ms);
            exit();
        }
        /* zmien kodowanie na utf8 */
        if ($this->mysqli->set_charset("utf8")) {
            //udało sie zmienić kodowanie
        }
    }
    
    function __destruct() {
        $this->mysqli->close();
    }

    public function select($sql, $cols) {
        $arr = [];
       // echo 'SELECTs<br>';
        if ($result = $this->mysqli->query($sql)) {
         //   print_r($result);
            $count = $result->num_rows;
            
            while ($row = $result->fetch_object()) {
                $arrjr = [];
                
                for ($i = 0; $i < count($cols); $i++) {
                    
                    $p = $cols[$i];
                    
                    $data = $row->$p;
               //     print_r($data);
                    
                    array_push($arrjr, $data);
                }
                array_push($arr, $arrjr);
            }
            $result->close();
        }
        return $arr;
    }
    
    public function selectOne($sql, $pole) {
        if ($result = $this->mysqli->query($sql)) {
            $length = $result->num_rows;
          //  echo "SQL!!  length = $length<br>"; //TODO: test
            if ($length !=1) return null;
            
            $row = $result->fetch_object();
            return ($row->$pole);
        }
        return null;
    }

    public function insert($sql) {
        if ($this->mysqli->query($sql)) {
            return true;
        }
        else{
            return false;
        }
    }

    public function delete($sql) {
        
        if ($this->mysqli->query($sql)) {
            
            return true;
        }
        else{
            return false;
        }
    }
    
    public function count($sql){
        if ($result = $this->mysqli->query($sql)){
            $ile = $result->num_rows;
        }
        return $ile;
    }
}

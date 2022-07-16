<?php
class DB{
    public static function conectarDatabase(){
        return mysqli_connect('localhost','root','3841','crud');
    }
}
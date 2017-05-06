<?php

class UserManager
{
    const OK = 0;
    const ERROR = 1;
    const MISSING_FIELD = 2;
    const UNMATCH = 3;
    const INVALID_EMAIL = 4;
    const INVALID_USERNAME = 5;
    const EMAIL_NOT_SENT = 6;

    function __construct()
    {
    $dbManager = new DBManager(); // da cambiare se usiamo SLIM
    
    }

    public function signIn($username, $password, $password2, $email){
        if (!$username || !$email || !$password || !$password2) {
          return self::MISSING_FIELD;
        }
        if ($password != $password2){
            return self:UNMATCH;
        }
        $usernameCheck = mysql_num_rows($dbmanager->select(array('username'), 'utente', "username = '$username'"));
        if ($usernameCheck !== 0) { return INVALID_USERNAME}
        $emailCheck = mysql_num_rows(array('email'), 'utente', "email = '$email'");
        if ($emailCheck !== 0) { return INVALID_EMAIL}
        
        
        $result = $dbmanager->insert('utente', array('username', 'email', 'password'), array($username, $email, $password));
        $oggetto = "Registrazione Popcorn"; 
        $corpo = "Benvenuto in Popcorn " . $username;
        if (mail("$email", $oggetto, $corpo)){
        return (!result) ? self::ERROR : self::OK;
        }
        else {
            return self::EMAIL_NOT_SENT;
        }
    }

    

}
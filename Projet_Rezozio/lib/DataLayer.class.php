<?php

Class DataLayer{
    private $connexion;

    // établit la connexion à la base en utilisant les infos de connexion des constantes DB_DSN, DB_USER, DB_PASSWORD
    // susceptible de déclencher une PDOException
    public function __construct(){
            $this->connexion = new PDO(
                       DB_DSN, DB_USER, DB_PASSWORD,
                       [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,     // déclencher une exception en cas d'erreur
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // chaque ligne du résultat sera une table associative
                       ]
                     );
    }
 /**
 * function to create user
 * @param string  $login 
 * @param string  $password
 * @param string  $pseudo
 * @param string  $description
 * @return int    the function return 1 if user is created and -1 if it already exists 
 */
    public function createUser($login, $password, $pseudo, $description=" "){
      $hashedpassword = password_hash($password,CRYPT_BLOWFISH);
      $sql = "INSERT INTO rezozio.users (login, pseudo, description, password) VALUES (:login, :pseudo, :description, :password)";
      try {
        $query = $this->connexion->prepare($sql);
        $query->bindParam(":login", $login);
        $query->bindParam(":pseudo", $pseudo);
        $query->bindParam(":password", $hashedpassword);
        $query->bindParam(":description", $description);
        $query->execute();
      } catch (PDOException $e) {
        return -1;
      }
      return $query->rowCount();
    }
    
/**
 * login function toward user account
 * @param string  $login 
 * @param string  $password
 * @return bool   false if parameters are incorrect
 * @return array  user identification if parameters are good
 */
    public function login($login, $password){

      $sql = " SELECT * FROM  rezozio.users WHERE login=:login";
      $query = $this->connexion->prepare($sql);
      $query->bindParam(":login", $login);
      $query->execute();

      $user = $query->fetch(PDO::FETCH_ASSOC);
      if($user){
        $exists = crypt($password, $user["password"]) == $user["password"];
        if($exists){
          return $user;
        }else{
          return false;
        }
      }
      return false;
    }
/**
 * function for getting user identification
 * @param string  $userId user identification
 * @return bool   false if user is not found
 * @return array  user identification
 */
   public function getUser($userId){
     $sql = "SELECT login, pseudo FROM  rezozio.users WHERE login=:userId";
     $query = $this->connexion->prepare($sql);
     $query->bindParam(":userId", $userId);
     $query->execute();

     $user = $query->fetch(PDO::FETCH_ASSOC);
     if($user){
       return $user;
     }
     return false;

   }

/**
 * function for getting users identification by subchain of their identification
 * @param string  $searched string
 * @return array  users by which their identification contains searched string as subchain
 */
   public function findUsers($subId){
     //input length verification
     $sql = "SELECT login, pseudo FROM  rezozio.users WHERE login LIKE '%$subId%' OR pseudo LIKE '%$subId%'";
     $query = $this->connexion->prepare($sql);
     //$query->bindParam(":subId", $subId);
     $query->execute();

     $users = $query->fetchAll(PDO::FETCH_ASSOC);
     return $users;

   }
/**
 * function for following one of the users
 * @param string  $login  user id
 * @param string  $target  the user id to be followed
 * @return int    return 1 if the target is found and not followed before;-1 if it has already followed;0 the user you want to follow doesn't exist
 */
   public function follow($login, $target){
     //input length verification
     $sql = "INSERT INTO rezozio.subscriptions (follower, target) VALUES (:follower, :target)";
     $query = $this->connexion->prepare($sql);
     $query->bindParam(":follower", $login);
     $query->bindParam(":target", $target);

     try {
       $query->execute();
       $subscribed = $query->rowCount();
       return $subscribed;

     } catch (PDOException $e) {
       if($e->getCode() == 23505){
         return -1;
       }elseif($e->getCode() == 23503){
         return 0;
       }else{
         return -2;
       }
     }
   }
/**
 * function for unfollowing one of the users
 * @param string  $login  user id
 * @param string  $target  the user id to be unfollowed
 * @return bool   true in case the target is followed and false otherwise
 */
   public function unfollow($login, $target){
     $sql = "DELETE FROM rezozio.subscriptions WHERE follower=:login AND target=:target";
     $query = $this->connexion->prepare($sql);
     $query->bindParam(":login", $login);
     $query->bindParam(":target", $target);

     $query->execute();
     $count = $query->rowCount();
     return $count == 1;
   }

/**
 * function for posting message
 * @param string  $login  user id
 * @param string  $source  message to be posted
 * @return bool   true in case the message is posted and false otherwise
 */
   public function postMessage($login,$source){
     if(strlen($source)<=280){
      $sql= "INSERT INTO rezozio.messages(author,content) VALUES (:author,:content)";
      $query = $this->connexion->prepare($sql);
      $query->bindParam(":author",$login);
      $query->bindParam(":content",$source);
      $query->execute();
      $count = $query->rowCount();
      return $count == 1;
      //return $id
     }
     return false;

   }
/**
 * function for getting message
 * @param string   $login  user id
 * @return string  $source  the message posted
 * @return bool    false in case message id doesn't exist 
 */
   public function getMessage($id){
     $sql = "SELECT * FROM rezozio.messages WHERE messages.id=:id";
     $query = $this->connexion->prepare($sql);
     $query->bindParam(":id", $id);
     $query->execute();
     $message = $query->fetch(PDO::FETCH_ASSOC);
     if($message){

          return $message;
     }
     return false;


   }
/**
 * function for getting followers of connected user
 * @param string   $target  user identification
 * @return array   $followers list of his/her followers
 */
   public function getFollowers($target){

     $sql=<<<EOD
     SELECT users.login,users.pseudo,t2.follower is not null as "mutual"
     FROM  rezozio.subscriptions as t1
     LEFT JOIN rezozio.subscriptions as t2 on t1.follower = t2.target and t2.follower = :target
     join rezozio.users on users.login = t1.follower
     where t1.target = :target
EOD;

     $query = $this->connexion->prepare($sql);
     $query->bindParam(":target",$target);
     $query->execute();

     $followers=$query->fetchAll(PDO::FETCH_ASSOC);
     return $followers;
   }

   /**
 * function for getting list of users followed by connected user
 * @param string   $follower userid 
 * @return array   $subscribers list of subscriptions
 */
   public function getSubscriptions($follower){

     $sql=<<<EOD
     SELECT users.login,users.pseudo,t2.target is not null as "mutual"
     FROM  rezozio.subscriptions as t1
     LEFT JOIN rezozio.subscriptions as t2 on t1.target = t2.follower and t2.target = :follower
     join rezozio.users on users.login = t1.target
     where t1.follower = :follower
EOD;

     $query = $this->connexion->prepare($sql);
     $query->bindParam(":follower",$follower);
     $query->execute();

     $subscribers=$query->fetchAll(PDO::FETCH_ASSOC);
     return $subscribers;
   }

   /**
 * function for setting profile
 */

   public function setProfile($login,$pseudo, $password, $description){
    $hashedpassword = password_hash($password,CRYPT_BLOWFISH);
     if (strlen($pseudo)>25){
        return 0;
     }
     elseif (strlen($description)>1024) {
        return -1;
     }

     $sql= "UPDATE rezozio.users SET pseudo =:pseudo,password=:pass,description=:description WHERE login=:login";
     $query = $this->connexion->prepare($sql);
     $query->bindParam(":login",$login);
     $query->bindParam(":pseudo",$pseudo);
     $query->bindParam(":pass",$hashedpassword);
     $query->bindParam(":description",$description);
     $query->execute();
     $count = $query->rowCount();

     if($count == 1){
       return array("userId" => $login, "pseudo" => $pseudo);
     }
     return false;

   }
   /**
 * function for getting profile
 */

   public function getProfile($userId, $login){
     if($login){
       $sql=<<<EOD
       SELECT users.login , users.pseudo,users.description,
       s1.target is not null as "followed",
       s2.target is not null as "isfollower"
       FROM rezozio.users
       LEFT JOIN rezozio.subscriptions as s1 on users.login = s1.target and s1.follower= :login
       LEFT JOIN rezozio.subscriptions as s2 on users.login = s2.follower and s2.target= :login
       WHERE users.login = :userId
EOD;
      $query = $this->connexion->prepare($sql);
      $query->bindParam(":userId",$userId);
      $query->bindParam(":login",$login);
      $query->execute();
      $profile=$query->fetch(PDO::FETCH_ASSOC);
    }else{
        $sql = <<<EOD
        SELECT login, pseudo, description
        FROM rezozio.users
        WHERE login=:userId
EOD;

        $query = $this->connexion->prepare($sql);
        $query->bindParam(":userId",$userId);
        $query->execute();
        $profile=$query->fetch(PDO::FETCH_ASSOC);
    }
    return $profile;
  }
   /**
 * function for finding messages
 */

  public function findMessages($author="", $before="", $count=15){
    $sql=<<<EOD
    SELECT messages.id, messages.author, messages.content, messages.datetime, users.pseudo
    FROM rezozio.messages
    LEFT JOIN rezozio.users ON messages.author = users.login
EOD;

    if($author != ""){
      $sql.=" WHERE messages.author = '$author'";
      if($before != "" ){
        $sql.= " AND messages.id < $before";
      }
    }else{
      if($before != "" ){
        $sql.= " WHERE messages.id < $before";
      }
    }

    $sql.= " ORDER BY messages.id DESC LIMIT ".$count;
    $query = $this->connexion->prepare($sql);

    $query->execute();

    return $query->rowCount() > 0 ? $query->fetchAll(PDO::FETCH_ASSOC) : [];
  }

   /**
 * function for finding  messages of subscribed account
 */

  public function findFollowedMessages($login, $before="", $count=15){
    /*   SELECT messages.id, messages.author, messages.content, messages.datetime, users.pseudo
      FROM  rezozio.subscriptions as t2
      LEFT JOIN rezozio.subscriptions as t1 ON t2.follower = t1.target and t2.follower = $login
      JOIN rezozio.messages ON messages.author = t2.follower
      WHERE t1.follower = $login
      */
  $sql=<<<EOD
  SELECT messages.id, messages.author, messages.content, messages.datetime, users.pseudo
  FROM rezozio.messages
  INNER JOIN rezozio.users ON users.login = messages.author
  INNER JOIN rezozio.subscriptions ON subscriptions.target = messages.author
EOD;

    if($before != ""){
      $sql.=" WHERE messages.id < $before AND subscriptions.follower = '$login'";
    }else{
      $sql.=" WHERE subscriptions.follower = '$login'";
    }

    $sql.= " ORDER BY messages.id DESC LIMIT ".$count;
    $query = $this->connexion->prepare($sql);

    //$query->bindParam(":login",$login);
    $query->execute();

    return $query->rowCount() > 0 ? $query->fetchAll(PDO::FETCH_ASSOC) : [];
  }

   /**
 * function for uploading user avatar
 */

  public function uploadAvatar($login, $small, $large, $mimetype){
    //header("Content-Type: image/jpeg");
    //echo stream_get_contents($small);

    $smallpic = stream_get_contents($small);
    $largepic = stream_get_contents($large);

    $sql = "UPDATE rezozio.users SET avatar_type=:mimetype, avatar_small=:small, avatar_large=:large WHERE users.login=:login";
    $query = $this->connexion->prepare($sql);
    $query->bindParam(":mimetype", $mimetype);
    $query->bindParam(":login", $login);
    $query->bindParam(":small", $smallpic, PDO::PARAM_LOB);
    $query->bindParam(":large", $largepic, PDO::PARAM_LOB);

    $query->execute();
    return $query->rowCount() == 1 ? true : false;

  }
   /**
 * function for getting the uploaded user avatar
 */
  public function getAvatar($login, $size){
    $sql = "";
    if($size == "small"){
      $sql = "SELECT avatar_type, avatar_small AS avatar FROM rezozio.users WHERE users.login=:login";
    }elseif ($size == "large") {
      $sql = "SELECT avatar_type, avatar_large AS avatar FROM rezozio.users WHERE users.login=:login";      
    }

    $query = $this->connexion->prepare($sql);
    $query->bindParam(":login", $login);
    $query->execute();

    $avatar = $query->fetch(PDO::FETCH_ASSOC);
    return $avatar;
  }
}
?>

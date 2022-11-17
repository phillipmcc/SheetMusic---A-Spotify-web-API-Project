<?php
session_start(); 

//checking if the session variables are set, if not we set them.
  
  
  //Holds the first name entered by user.
  if(isset($_POST['firstname'])){
    $_SESSION['firstname'] = $_REQUEST['firstname'];
  }
  if(isset($_POST['lastname'])){
  
    //Holds the last name entered by the user.
    $_SESSION['lastname'] = $_REQUEST['last'];
  }
  if(isset($_POST['email'])){
  
    //Holds the email entered by the user.
    $_SESSION['email'] = $_REQUEST['email'];
  }
  if(isset($_POST['loginpassword'])){
  
    //Holds the email entered by the user.
    $_SESSION['password'] = $_REQUEST['loginpassword'];
  }
  if(isset($_POST['NewUser'])){
  
    //Holds the email entered by the user.
    $_SESSION['NewUser'] = $_POST['NewUser'];
  }


?>
<!DOCTYPE html>
<html lang='en-GB'>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<title>SheetMusic</title>
<style>
  div {
    margin-bottom: 10px;
  }
  label {
    padding: 2px;
    display: inline-block;
    width: 150px;
    text-align: left;
  }
  /* width */
  ::-webkit-scrollbar {
    width: 1vw;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #555;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #888;
  }
  
  #email {
    width:200px;
    height:15px;
    overflow: hidden;
    border-radius:70px; 
    background-color:#555; 
  }
  #loginpassword {
    width:200px;
    height:15px;
    overflow: hidden;
    border-radius:70px; 
    background-color:#555; 
  }
  
  #login {
    text-align:center;
    width: 90px;
    //height: 20px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    font-size:75%;
  }
  
    #newUser {
    text-align:center;
    width: 90px;
    //height: 20px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    font-size:75%;
  }
  
</style>
</head>
<body style="background: linear-gradient(to bottom, #000000, #535353); color: white; font-family: 'Lato', sans-serif; background-repeat: no-repeat; background-color: #535353;">
<h1 style='font-size:400%'>SheetMusic</h1>
<h2 style='font-size:250%; margin:10px;'>Log in</h2>

<?php

//database details
$db_hostname = "studdb.csc.liv.ac.uk";
$db_database = "sgcrobi2";
$db_username = "sgcrobi2";
$db_password = "Swordpass999";
$db_charset = "utf8mb4";
$dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
$opt = array(
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false
);
try {
    $pdo = new PDO($dsn,$db_username,$db_password,$opt);
    $newUserButtonPressed= $_SESSION['NewUser'];
    $loginBtnPressed= $_POST['loginBTN'];
    
    if(isset($loginBtnPressed)){
      
      $passhash = md5($_SESSION['password']);
      $stmt = $pdo->prepare(
          "SELECT * FROM SheetMusic_users WHERE email=:email AND PasswordHash=:password");
          $stmt->execute(array("email" => $_SESSION['email'], "password" => $passhash));
          if($stmt->rowCount()>0){
            $_SESSION['userid'] = $stmt->fetchColumn(0);
            $_SESSION['spotid'] = $stmt->fetchColumn(5);
            
            header("Location: https://student.csc.liv.ac.uk/~sgcrobi2/SheetMusicHome.php");
            
          }
          else{
            echo $passhash;
            echo "Invalid Username and/or Password";
          }
    }
    
    
    echo "
        <form name='logIn' action='SheetMusicSplash.php' method='post' style='text-align: left; padding: 10px;'>
          <label for='email'>Email:</label><br>
          <input type='text' name='email' id='email' value=''><br>
          
          <label for='loginpassword'>Password:</label><br>
          <input type='text' name='loginpassword' id='loginpassword' value='' style='background-color:#555;'>
          
          <input type='submit' name='loginBTN' value='Log In' id='login'>
        </form>
    ";
    
    
    echo "
      <form name='NewGuy' action='SheetMusicCreateAccount.php' method='post' style='padding: 10px;'>
        <input type='submit' name='NewUser' value='New User' id='newUser'>
      </form>
    ";
    echo '<svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 490" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(14.699, 73.225, 35.553, 1)" offset="0%"></stop><stop stop-color="rgba(29, 185, 84, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,343L34.3,351.2C68.6,359,137,376,206,392C274.3,408,343,425,411,367.5C480,310,549,180,617,163.3C685.7,147,754,245,823,261.3C891.4,278,960,212,1029,171.5C1097.1,131,1166,114,1234,89.8C1302.9,65,1371,33,1440,32.7C1508.6,33,1577,65,1646,73.5C1714.3,82,1783,65,1851,81.7C1920,98,1989,147,2057,155.2C2125.7,163,2194,131,2263,163.3C2331.4,196,2400,294,2469,334.8C2537.1,376,2606,359,2674,310.3C2742.9,261,2811,180,2880,179.7C2948.6,180,3017,261,3086,261.3C3154.3,261,3223,180,3291,163.3C3360,147,3429,196,3497,204.2C3565.7,212,3634,180,3703,147C3771.4,114,3840,82,3909,130.7C3977.1,180,4046,310,4114,310.3C4182.9,310,4251,180,4320,179.7C4388.6,180,4457,310,4526,375.7C4594.3,441,4663,441,4731,400.2C4800,359,4869,278,4903,236.8L4937.1,196L4937.1,490L4902.9,490C4868.6,490,4800,490,4731,490C4662.9,490,4594,490,4526,490C4457.1,490,4389,490,4320,490C4251.4,490,4183,490,4114,490C4045.7,490,3977,490,3909,490C3840,490,3771,490,3703,490C3634.3,490,3566,490,3497,490C3428.6,490,3360,490,3291,490C3222.9,490,3154,490,3086,490C3017.1,490,2949,490,2880,490C2811.4,490,2743,490,2674,490C2605.7,490,2537,490,2469,490C2400,490,2331,490,2263,490C2194.3,490,2126,490,2057,490C1988.6,490,1920,490,1851,490C1782.9,490,1714,490,1646,490C1577.1,490,1509,490,1440,490C1371.4,490,1303,490,1234,490C1165.7,490,1097,490,1029,490C960,490,891,490,823,490C754.3,490,686,490,617,490C548.6,490,480,490,411,490C342.9,490,274,490,206,490C137.1,490,69,490,34,490L0,490Z"></path></svg>';
    
 
            
  
  $pdo = NULL;
} catch (PDOException $e) {
exit("PDO Error: ".$e->getMessage()."<br>");
}



?>
</body>
</html>
<?php
session_start(); 

//checking if the session variables are set, if not we set them.
  
  
  //Holds the first name entered by user.
  if(isset($_POST['firstname'])){
    $_SESSION['firstname'] = $_REQUEST['firstname'];
  }
  if(isset($_POST['lastname'])){
  
    //Holds the last name entered by the user.
    $_SESSION['lastname'] = $_REQUEST['lastname'];
  }
  if(isset($_POST['email'])){
  
    //Holds the email entered by the user.
    $_SESSION['email'] = $_REQUEST['email'];
  }
  if(isset($_POST['newpassword'])){
  
    //Holds the password entered by the user.
    $_SESSION['password'] = $_REQUEST['newpassword'];
  }
  if(isset($_POST['SpotID'])){
  
    //Holds the password entered by the user.
    $_SESSION['SpotID'] = $_REQUEST['SpotID'];
  }
  if(isset($_POST['NewUser'])){
  
    //Holds the email entered by the user.
    $_SESSION['NewUser'] = $_POST['NewUser'];
  }

    if(isset($_POST['CreateButton'])){
  
    //Holds the email entered by the user.
    $_SESSION['CreateButton'] = $_POST['CreateButton'];
  }

?>
<!DOCTYPE html>
<html lang='en-GB'>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<title>PHP07 A</title>
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
  
    #txtbox {
    width:200px;
    height:15px;
    overflow: hidden;
    border-radius:70px; 
    background-color:#555; 
  }
  
  #backBTN {
    text-align:center;
    width: 100px;
    //height: 20px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    font-size:75%;
  }
    #createBTN {
    text-align:center;
    width: 100px;
    //height: 20px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    font-size:75%;
  }
</style>
</head>
<body style="background: linear-gradient(to bottom, #000000, #535353); color: white; font-family: 'Lato', sans-serif; background-repeat: no-repeat; background-color: #535353;">
<h1>Create Your Account</h1>

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
    $createButtonPressed=$_POST['CreateButton'];

    //this function validates the user inputs from the text field
    function isName($word,$type) { //$word contains the string to be validated. $type tells us whether it is a name or phone number
      if($type=="name"){
        $pattern = "/^'?[A-Za-z]+(((-|')?[A-Z a-z])*[A-Z a-z]*'?)$/"; // regex for a valid name
      }elseif($type=="phone"){
        $pattern = "/^0[0-9 ]{8,9}$/"; // regex for a valid phone number
      }else{return(false);}
      $found = preg_match($pattern, $word);
      if($found===1){
        return(true);
      }
      else{
        return(false);
      }
    }

    
    if (isset($createButtonPressed)){
      if (isName($_SESSION['firstname'], "name") && isName($_SESSION['lastname'], "name")){
      $passhash = md5($_SESSION['password']);
        echo "Your account was Created<br>";
        $stmt = $pdo->prepare( // inserting the booking into our bookings table
            "insert into SheetMusic_users (last_name,first_name,email,PasswordHash, Spotify_id) values(:last,:first,:email,:password,:spotifyID)");
            $success = $stmt->execute(
            array("last" => $_SESSION['lastname'],"first" => $_SESSION['firstname'], "email" => $_SESSION['email'], "password" => $passhash, "spotifyID" => $_SESSION['SpotID']));
      }
    }
          echo "
            <form name='enterDetails' action='SheetMusicCreateAccount.php' method='post'>
            <label>First Name:</label><br><input type='text'name='firstname'size='25' value='' id='txtbox'><br>
            <label>Last Name:</label><br><input type='text'name='lastname'size='25' value='' id='txtbox'><br>
            <label>Email:</label><br><input type='text'name='email'size='25' value='' id='txtbox'><br><br>
            <label>Password:</label><br><input type='text'name='newpassword'size='25' value='' id='txtbox'><br>
            <label>Spotify User id:</label><br><input type='text'name='SpotID' size='25' value='' id='txtbox'><br><br>
            <input type='submit'name='CreateButton'value='Create Account' id='createBTN'>
            </form>";
            
          echo "
            <form name='backtoSplash' action='SheetMusicSplash.php' method='post'>
              <input type='submit' name='backBTN' value='Back' id='backBTN'>
            </form>    
          ";
   
           echo ' <svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 440" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(14.699, 73.225, 35.553, 1)" offset="0%"></stop><stop stop-color="rgba(29, 185, 84, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,308L18.5,315.3C36.9,323,74,337,111,352C147.7,367,185,381,222,330C258.5,279,295,161,332,146.7C369.2,132,406,220,443,234.7C480,249,517,191,554,154C590.8,117,628,103,665,80.7C701.5,59,738,29,775,29.3C812.3,29,849,59,886,66C923.1,73,960,59,997,73.3C1033.8,88,1071,132,1108,139.3C1144.6,147,1182,117,1218,146.7C1255.4,176,1292,264,1329,300.7C1366.2,337,1403,323,1440,278.7C1476.9,235,1514,161,1551,161.3C1587.7,161,1625,235,1662,234.7C1698.5,235,1735,161,1772,146.7C1809.2,132,1846,176,1883,183.3C1920,191,1957,161,1994,132C2030.8,103,2068,73,2105,117.3C2141.5,161,2178,279,2215,278.7C2252.3,279,2289,161,2326,161.3C2363.1,161,2400,279,2437,337.3C2473.8,396,2511,396,2548,359.3C2584.6,323,2622,249,2640,212.7L2658.5,176L2658.5,440L2640,440C2621.5,440,2585,440,2548,440C2510.8,440,2474,440,2437,440C2400,440,2363,440,2326,440C2289.2,440,2252,440,2215,440C2178.5,440,2142,440,2105,440C2067.7,440,2031,440,1994,440C1956.9,440,1920,440,1883,440C1846.2,440,1809,440,1772,440C1735.4,440,1698,440,1662,440C1624.6,440,1588,440,1551,440C1513.8,440,1477,440,1440,440C1403.1,440,1366,440,1329,440C1292.3,440,1255,440,1218,440C1181.5,440,1145,440,1108,440C1070.8,440,1034,440,997,440C960,440,923,440,886,440C849.2,440,812,440,775,440C738.5,440,702,440,665,440C627.7,440,591,440,554,440C516.9,440,480,440,443,440C406.2,440,369,440,332,440C295.4,440,258,440,222,440C184.6,440,148,440,111,440C73.8,440,37,440,18,440L0,440Z"></path></svg>';
            
            

            
  
  $pdo = NULL;
} catch (PDOException $e) {
exit("PDO Error: ".$e->getMessage()."<br>");
}



?>
</body>
</html>
<?php
session_start(); 

//checking if the session variables are set, if not we set them.
  


?>
<!DOCTYPE html>
<html lang='en-GB'>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<script src='musicApp.js'></script>
<body onload='onPageLoad()' style="background: linear-gradient(to bottom, #000000 0%, #535353 100%);color: white; font-family: 'Lato', sans-serif; background-repeat: no-repeat; background-color: #535353;">
<style>
  #txtbox {
    width:300px;
    height:40px;
    overflow: hidden;
    border-radius:70px; 
    background-color:#444; 
    font-family: 'Lato', sans-serif;
    font-size: 125%;
    text-align: left;
    text-indent: 10px;
    color: white;
    right: 12px;
  }
      ::placeholder{
      color: white;
      opacity: 0.8;
    }
  #backBTN {
    text-align:center;
    width: 100px;
    //height: 20px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    font-size:75%;
    }
    #addBTN {
    text-align:center;
    width: 100px;
    height: 30px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    color: white;
    background-color: #1db954;
    font-size:75%;
    right:10px;
    margin-left: 3vw;
    margin-right: auto;
    }
    #authBTN {
    text-align:center;
    width: 155px;
    height: 45px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    color: white;
    background-color: #1db954;
    font-size:90%;
    right:10px;
    margin-left: auto;
    margin-right: 80vw;
    margin-top: 10px;
    }
    #logoutBTN {
    text-align:center;
    width: 100px;
    height: 30px;
    border-radius: 30px;
    font-family: 'Lato', sans-serif;
    color: white;
    background-color: #1db954;
    font-size:75%;
    halign:left;
    margin-left: 80vw;
    margin-right: auto;
    margin-top: 10px;
    }
    .sidebar {
      height: 100%; /* Full-height: remove this if you want "auto" height */
      width: 50px; /* Set the width of the sidebar */
      position: fixed; /* Fixed Sidebar (stay in place on scroll) */
      z-index: 1; /* Stay on top */
      display: flex;
      //align-items: center;
      justify-content: center;
      top: 0; /* Stay at the top */
      left: 0;
      background-color: #111; /* Black */
      overflow-x: hidden; /* Disable horizontal scroll */
      padding-top: 20px;
      
    }
    .main {
      margin-left: 40px;
      padding-left: 5px;
    }
</style>
<title>PHP07 A</title>
</head>
<div class='container'>
<aside class='sidebar'>
  <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
    width="30" height="30"
    viewBox="0 0 30 30"
    style=" fill: white;"><path d="M 3 7 A 1.0001 1.0001 0 1 0 3 9 L 27 9 A 1.0001 1.0001 0 1 0 27 7 L 3 7 z M 3 14 A 1.0001 1.0001 0 1 0 3 16 L 27 16 A 1.0001 1.0001 0 1 0 27 14 L 3 14 z M 3 21 A 1.0001 1.0001 0 1 0 3 23 L 27 23 A 1.0001 1.0001 0 1 0 27 21 L 3 21 z"></path></svg>
</aside>
</div>
<div class='main'>
<?php
header('Access-Control-Allow-Origin: *');
if(isset($_SESSION['userid'])){
echo "<form name='logout' action='SheetMusicHome.php' method='post'>
      <input type='submit' name='logoutBTN' id='logoutBTN' value='Log Out'>
    </form>";
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
    
    $stmt = $pdo->prepare(
          "SELECT * FROM SheetMusic_users WHERE user_id=:userid");
          $stmt->execute(["userid" => $_SESSION['userid']]);
          $name = "test";
          $name = $stmt->fetchColumn(2);
    echo "<h1>Hey  ",$name,", welcome back...</h1>";
    echo "<input class='btn btn-primary btn-lg' type='button' onclick='requestAuthorization()' value='Authorize with Spotify' id='authBTN'><br>";
    echo '<div id="div1"class="mb-3" style="display: none;">
                    <label for="devices" class="form-label">Devices</label>
                    <select id="devices" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshDevices()" value="Refresh Devices">
                    <input type="button" class="btn btn-dark btn-sm  mt-3" onclick="transfer()" value="Transfer">
                </div>';
    
    function openPlaylist($playlistID){
      echo '<iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/',$playlistID,'?utm_source=generator&theme=0" width="100%" height="380" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>';
    }            
    
    $addedMessage = "";
    $logoutBTNPressed = $_POST['logoutBTN'];
    if (isset($logoutBTNPressed)) {
      unset($_SESSION['userid']);
      unset($_SESSION['spotid']);
      
      header("Location: https://student.csc.liv.ac.uk/~sgcrobi2/SheetMusicSplash.php");
    }
    //here we add the user selected books to their library.
    if(isset($_POST['addtolib'])){

    if(!empty($_POST['lang'])) {

        foreach($_POST['lang'] as $value){
            $stmt = $pdo->prepare( // inserting the booking into our bookings submit
            "insert into SheetMusic_userLib (user_id,book_id) values(:userid, :bookid)");
            $success = $stmt->execute(
            array("userid" => $_SESSION['userid'], "bookid" => $value));
            $addedMessage = "Your selections have been added to your library!";
        }

      }
    }

    echo "<form name='bookSearch' action='SheetMusicHome.php' method='post'>
      <input type='text' name='bookSearchBar' id='txtbox' placeholder='&#x1F50D; Search Our Library...'required>
    </form>";
    
    $searchWithWilds = "%".$_REQUEST['bookSearchBar']."%";
    $stmt = $pdo->prepare("select * from SheetMusic_books where author LIKE :authInput OR title LIKE :titlInput OR genre like :genInput OR sub_genre LIKE :subInput");
    $stmt->execute(array("authInput" => $searchWithWilds, "titlInput" => $searchWithWilds, "genInput" => $searchWithWilds, "subInput" => $searchWithWilds));

    echo "<br>";
    echo "<form name='searchtable' action='SheetMusicHome.php' method='post' style='display: inline-block;'>";
    echo "<table border='1'cellpadding='5'>\n";
    echo "<tr>";
      echo "<td></td>";
      echo "<td>Title</td>";
      echo "<td>Author</td>";
      echo "<td>Genre</td>";
      echo "<td>Sub-Genre</td>";
    echo "</tr>";
    echo "<input type='submit' name='addtolib' value='Add to Library' id='addBTN'><input id='addBTN' type='button' onclick='createPlaylist()' value='Create Playlist'><br>"; 
    echo "<p style='margin-left: 2vw; margin-right: auto;text-align: center;'>$addedMessage</p>";
    $i = 0;
    foreach ($stmt as $row){
      $stringi = (string) $i;
      echo "<tr>";
        echo "<td><input type='checkbox' name='lang[]' id='chk",$stringi,"' value='",$row['book_id'],"'></td>";
        echo "<td>",$row["title"],"</td>";
        echo "<td>",$row["author"],"</td>";
        echo "<td>",$row["genre"],"</td>";
        echo "<td>",$row["sub_genre"],"</td>";
      echo "</tr>";
  $i++;
}
echo "</table>\n";
echo "</form>";


openPlaylist("3ENA2sJgAR90TuUNB3wI5M");
            
  
  $pdo = NULL;
} catch (PDOException $e) {
exit("PDO Error: ".$e->getMessage()."<br>");
}


}else{
    echo "<h1>You aren't logged in...</h1><br><br>";
  
  echo "<form name='backtoSplash' action='SheetMusicSplash.php' method='post'>
    <input type='submit' name='backBTN' value='Log in' id='backBTN'>
  </form>";    
  
  echo'<svg id="wave" style="position: fixed;bottom: 0;right:10px;width:100%;transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 410" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(7.193, 68.671, 28.868, 1)" offset="0%"></stop><stop stop-color="rgba(29, 185, 84, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,369L15,307.5C30,246,60,123,90,82C120,41,150,82,180,95.7C210,109,240,96,270,136.7C300,178,330,273,360,273.3C390,273,420,178,450,129.8C480,82,510,82,540,82C570,82,600,82,630,123C660,164,690,246,720,266.5C750,287,780,246,810,211.8C840,178,870,150,900,129.8C930,109,960,96,990,109.3C1020,123,1050,164,1080,164C1110,164,1140,123,1170,88.8C1200,55,1230,27,1260,13.7C1290,0,1320,0,1350,27.3C1380,55,1410,109,1440,157.2C1470,205,1500,246,1530,218.7C1560,191,1590,96,1620,68.3C1650,41,1680,82,1710,116.2C1740,150,1770,178,1800,170.8C1830,164,1860,123,1890,102.5C1920,82,1950,82,1980,68.3C2010,55,2040,27,2070,47.8C2100,68,2130,137,2145,170.8L2160,205L2160,410L2145,410C2130,410,2100,410,2070,410C2040,410,2010,410,1980,410C1950,410,1920,410,1890,410C1860,410,1830,410,1800,410C1770,410,1740,410,1710,410C1680,410,1650,410,1620,410C1590,410,1560,410,1530,410C1500,410,1470,410,1440,410C1410,410,1380,410,1350,410C1320,410,1290,410,1260,410C1230,410,1200,410,1170,410C1140,410,1110,410,1080,410C1050,410,1020,410,990,410C960,410,930,410,900,410C870,410,840,410,810,410C780,410,750,410,720,410C690,410,660,410,630,410C600,410,570,410,540,410C510,410,480,410,450,410C420,410,390,410,360,410C330,410,300,410,270,410C240,410,210,410,180,410C150,410,120,410,90,410C60,410,30,410,15,410L0,410Z"></path></svg>';
}
?>
</div>
</body>
</html>
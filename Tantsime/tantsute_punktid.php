<?php
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: abLogin.php');
    exit();
}
require_once ('connect_tantsida.php');
require("tantsudeFunk.php");


$sorttulp = "tantsupaar";

/*
 * ei tööta
//sorterimine
if (isset($_REQUEST['sorttulp'])) {
    $sorttulp = $_REQUEST['sorttulp'];
}
$tants = kysiKaupadeAndmed($sorttulp);
*/
//if($_SESSION['onAdmin']){

//}
function isAdmin(){
    return isset($_SESSION['onAdmin'])&&$_SESSION['onAdmin'];
}

//uue paar lisamine
if(!empty($_REQUEST['paar'])&&isAdmin()){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO tantsud (tantsupaar, pilt, avaliku_paev) VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $_REQUEST['paar'],$_REQUEST['pilt']);
    $kask->execute();
    header("location: $_SERVER[PHP_SELF]");
}
//kommentaaride lisamine
if(isset($_REQUEST['uuskomment'])){
    if(!empty($_REQUEST['komment'])) {
        global $yhendus;
        $kask = $yhendus->prepare("UPDATE tantsud SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id=?");
        $kommentplus=$_REQUEST['komment']."\n";
        $kask->bind_param("si",$kommentplus,$_REQUEST['uuskomment']);
        $kask->execute();
        header("location: $_SERVER[PHP_SELF]");
    }
}
//punkt lisamine
if(isSet($_REQUEST['punkt'])){
    global $yhendus;
    $kaks=$yhendus->prepare('UPDATE tantsud SET punktid=punktid+1 WHERE id=?');
    $kaks->bind_param("s",$_REQUEST['punkt']);
    $kaks->execute();
    header("location: $_SERVER[PHP_SELF]");
}


?>
<!DOCTYPE html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="tantsStyle.css">
</head>
    <body>
    <h1>Tantsupaar</h1>
    <h2>Kasutaja leht</h2>
    <div class="nav">
        <input type="checkbox" id="nav-check">
        <div class="nav-header">
            <div class="nav-title">
            </div>
        </div>
        <div class="nav-btn">
            <label for="nav-check">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>

        <div class="nav-links">
            <a href="tantsute_punktid.php">Kasutaja</a>
            <a href="admin.php">Admin</a>
        </div>
    </div>
    <table>
        <tr>
            <th>
                <a href="tantsute_punktid.php?sorttulp=tantsupaar">Tantsupaar
            </th>
            <th>
                <a href="tantsute_punktid.php?sorttulp=punktid">Punktid
            </th>
            <th>
                Haldus
            </th>
            <th>
                <a href="tantsute_punktid.php?sorttulp=komentaarid">Kommentaarid
            </th>
            <th>
                Kommentaari lisa
            </th>
            <th>
                Pilt
            </th>
        </tr>
        <!--tabeli sisu näitamine-->
        <?php
        global $yhendus ;
        $kaks=$yhendus->prepare('SELECT id , tantsupaar , punktid, komentaarid, pilt FROM tantsud WHERE avalik=1');
        $kaks->bind_result( $id , $tantsupaar , $punktid, $kommentaarid, $pilt);
        $kaks->execute();
        while($kaks->fetch()){
            echo "<tr>";
            echo "<td>".$tantsupaar."</td>";
            echo "<td>".$punktid."</td>";
            echo "<td><a href='?punkt=$id'>Lisa 1 punktid</a></td>";
            $kommentaarid=nl2br(htmlspecialchars($kommentaarid));
            echo "<td>".$kommentaarid."</td>";
            echo "<td>
            <form action='?'>
            <input type='hidden' value='$id' name='uuskomment'>
            <input type='text' name='komment'>
            <input type='submit' name='OK'>
            </form>
            </td>";
            echo "<td><img src='$pilt' width='150' height='150'><br>
            </td>";
            echo "</tr>";
        }
        ?>
    </table>
<?php if(IsAdmin()) { ?>
<div>
    <h2>
        Uue tantsupaari lisamine
    </h2>
    <form action="?">
        <input type="text" placeholder="Tantsupaar nimed" name="paar">
        <input type="text" placeholder="Pilt Aadres" name="pilt">
        <input type="submit" value="OK">
    </form>
</div>
    <?php } ?>
</body>
</html>
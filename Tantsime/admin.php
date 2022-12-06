<?php
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: abLogin.php');
    exit();
}

require_once ('connect_tantsida.php');

/*
 * ei tööta
if (isset($_REQUEST['otsisona'])) {
    $otsisona = $_REQUEST['otsisona'];
    global $yhendus;
    $kaks=$yhendus->prepare("SELECT id , tantsupaar , punktid, komentaarid, avaliku_paev, avalik FROM tantsud WHERE tansupaar='$otsisona'");
    $kaks->bind_result( $id , $tantsupaar , $punktid, $komentaarid, $apaev, $avalik);
    $kaks->execute();

    while($kaks->fetch()){
        $tekst='Naita';
        $seisunud='naitamine';
        $kasutajatekst='Kasutaja ei näe';
        if($avalik==1) {
            $tekst = 'Peida';
            $seisunud = 'peitmine';
            $kasutajatekst = 'Kasutaja näeb';
        }
        echo "<tr>";
        echo "<td>"."<a href='?rkustuta=$id'>Kustuta</a></td>";
        echo "<td>".$tantsupaar."</td>";
        echo "<td>".$punktid. "<br><a href='?punkt0=$id'>Punktid nulliks</a></td>";
        echo "<td>".$komentaarid."<br><a href='?kkustuta=$id'>Kustuta</a> </td>";
        echo "<td>$kasutajatekst<br><a href='?$seisunud=$id'>$tekst</a><br></td>";
        echo "<td>".$apaev."</td>";
        echo "</tr>";
    }
}
*/





if(isSet($_REQUEST['punkt0'])){
    global $yhendus;
    $kaks=$yhendus->prepare('UPDATE tantsud SET punktid=0 WHERE id=?');
    $kaks->bind_param("s",$_REQUEST['punkt0']);
    $kaks->execute();
    header("location: $_SERVER[PHP_SELF]");
}

if(isSet($_REQUEST['kkustuta'])){
    global $yhendus;
    $kaks=$yhendus->prepare('UPDATE tantsud SET kommentaarid=" " WHERE id=?');
    $kaks->bind_param("s",$_REQUEST['kkustuta']);
    $kaks->execute();
    header("location: $_SERVER[PHP_SELF]");
}

if(isSet($_REQUEST['rkustuta'])){
    global $yhendus;
    $kaks=$yhendus->prepare('DELETE FROM tantsud WHERE id=?;');
    $kaks->bind_param("s",$_REQUEST['rkustuta']);
    $kaks->execute();
    header("location: $_SERVER[PHP_SELF]");
}

//peitmine
if(isSet($_REQUEST['peitmine'])){
    global $yhendus;
    $kaks=$yhendus->prepare('UPDATE tantsud SET avalik=0 WHERE id=?;');
    $kaks->bind_param("s",$_REQUEST['peitmine']);
    $kaks->execute();
}
//naitamine
if(isSet($_REQUEST['naitamine'])){
    global $yhendus;
    $kaks=$yhendus->prepare('UPDATE tantsud SET avalik=1 WHERE id=?;');
    $kaks->bind_param("s",$_REQUEST['naitamine']);
    $kaks->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="tantsStyle.css">
</head>
<body>
<h1>Tantsupaar</h1>
<?php
echo $_SESSION['kasutaja']
?> on sisse logitud
<form action="logout.php" method="post">
    <input type="submit" value="Logi välja" name="logout">
</form>
<h2>Admin leht</h2>
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
            Rida Kustutamine
        </th>
        <th>
            Tantsupaar
        </th>
        <th>
            Punktid
            <br> Punktide nulliks
        </th>
        <th>
            Kommentaarid
            <br>Kustuta Kommentaarid
        </th>
        <th>
            Naita/Peida
        </th>
        <th>
            Avalda paev
        </th>
    </tr>
    <?php
    global $yhendus ;
    $kaks=$yhendus->prepare('SELECT id , tantsupaar , punktid, komentaarid, avaliku_paev, avalik FROM tantsud');
    $kaks->bind_result( $id , $tantsupaar , $punktid, $komentaarid, $apaev, $avalik);
    $kaks->execute();
    while($kaks->fetch()){
        $tekst='Naita';
        $seisunud='naitamine';
        $kasutajatekst='Kasutaja ei näe';
        if($avalik==1) {
            $tekst = 'Peida';
            $seisunud = 'peitmine';
            $kasutajatekst = 'Kasutaja näeb';
        }
        echo "<tr>";
        echo "<td>"."<a href='?rkustuta=$id'>Kustuta</a></td>";
        echo "<td>".$tantsupaar."</td>";
        echo "<td>".$punktid. "<br><a href='?punkt0=$id'>Punktid nulliks</a></td>";
        echo "<td>".$komentaarid."<br><a href='?kkustuta=$id'>Kustuta</a> </td>";
        echo "<td>$kasutajatekst<br><a href='?$seisunud=$id'>$tekst</a><br></td>";
        echo "<td>".$apaev."</td>";
        echo "</tr>";
    }
    ?>
</table>
<form action="kaubahaldus.php">
    <input type="text" name="otsisona" placeholder="Otsi siin">
</form>
<br>
</body>
</html>

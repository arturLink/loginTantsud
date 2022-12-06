<?php
//andmete sorterimine
function kysiKaupadeAndmed($sorttulp="tantsupaar"){
    global $yhendus;
    $lubatudtulbad=array("tantsupaar", "punktid", "komentaarid");
    if(!in_array($sorttulp, $lubatudtulbad)){
        return "lubamatu tulp";
    }
    $kask=$yhendus->prepare("SELECT id, tantsupaar, punktid, komentaarid
       FROM tantsud
       ORDER BY $sorttulp");
    //echo $yhendus->error;
    $kask->bind_result($id, $tantsupaar, $punktid, $komentaarid);
    $kask->execute();
    $hoidla=array();
    while($kask->fetch()){
        $tants=new stdClass();
        $tants->id=$id;
        $tants->tantsupaar=htmlspecialchars($tantsupaar);
        $tants->punktid=$punktid;
        $tants->komentaarid=htmlspecialchars($komentaarid);
        array_push($hoidla, $tants);
    }
    return $hoidla;
}
?>

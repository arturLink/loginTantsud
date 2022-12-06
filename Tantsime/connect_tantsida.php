<?php
$kasutaja='artur21'; //d70420_merk21
$server='localhost'; //d70420.mysql.zonevs.eu
$andmebaas='linktarpv21';
$salasyna='12345'; //d70420_irinabaas
//teeme käsk mis ühendab andmebaasiga
$yhendus=new mysqli($server, $kasutaja, $salasyna, $andmebaas);
$yhendus->set_charset('UTF8');
/*
 * create table tantsud(
    id int primary key auto_increment,
    tantsupaar varchar(25) not null,
    punktid int default 0,
    kommentaarid varchar(250) default ' ',
    avalik int default 1,
    avaliku_paev datetime


CREATE TABLE kasutajad (
    id int PRIMARY KEY AUTO_INCREMENT,
    kasutaja varchar(10),
    parol varchar(250)
    );
);

$kasutaja='d113369_artur'; //d70420_merk21
$server='d113369.mysql.zonevs.eu'; //d70420.mysql.zonevs.eu
$andmebaas='d113369_admindb';
$salasyna='megazone2017'; //d70420_irinabaas
//teeme käsk mis ühendab andmebaasiga
$yhendus=new mysqli($server, $kasutaja, $salasyna, $andmebaas);
$yhendus->set_charset('UTF8');




 */
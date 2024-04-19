<?php
include '../view/includeviews/header2.php';

include 'classBog.php';
include 'classBoghylde.php';

$Bog1 = new Bog('H.C. Kartoffelsen', 'Den flotte ælling');

echo $Bog1->læsForfatter() . ' - ' . $Bog1->læsTitel();

$Bog1->opdaterForfatter('H.C. Andersen');
$Bog1->opdaterTitel('Den grimme ælling');

echo "<br>";
echo $Bog1->læsForfatter() . ' - ' . $Bog1->læsTitel();

echo "<br>";
var_dump($Bog1 instanceof Bog);
unset($Bog1);
$Bog1 = null;

echo "<br>";
var_dump($Bog1 instanceof Bog);

$hylde = new Boghylde();

$Bog1 = new Bog('H.C. Kartoffelsen', 'Den flotte ælling');
$Bog2 = new Bog('Karen Blixen', 'Terminator');
$Bog3 = new Bog('Karen Blixen', 'Skolelederens dagbog');
$Bog4 = new Bog('Karen Blixen', "Jakob og Mikkel's eventyr");
$Bog5 = new Bog("H.C. Andersen", "Jakob og Mikkel's eventyr");

echo "<br>";

$hylde->tilføjBogObjekt($Bog1);
$hylde->tilføjBogObjekt($Bog2);
$hylde->tilføjBogObjekt($Bog3);
$hylde->tilføjBogObjekt($Bog4);
$hylde->tilføjBogObjekt($Bog5);
echo "<br>";

$bogf = $hylde->findBogObjektForfatter('Karen Blixen');
foreach ($bogf as $bog) {
    echo $bog->læsForfatter() . ' - ' . $bog->læsTitel() . "<br>";
}

echo "<br>";

$bogf = $hylde->findBogObjektTitel('Mikkel');
foreach ($bogf as $bog) {
    echo $bog->læsForfatter() . ' - ' . $bog->læsTitel() . "<br>";
}


echo "<br>";

foreach ($hylde->findAlleBogObjekter() as $bog) {
    echo $bog->læsForfatter() . ' - ' . $bog->læsTitel() . "<br>";
}

echo "<br>";

$hylde->opdaterBogObjekt('H.C. Andersen', 'Den grimme ælling');

echo "<br>";

unset($bog2);
$bog2 = null;
foreach ($hylde->findAlleBogObjekter() as $bog) {
    echo $bog->læsForfatter() . ' - ' . $bog->læsTitel() . "<br>";
}

?>
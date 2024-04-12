<?php
include 'classBog.php';
include 'classBoghylde.php';

$Bog1 = new Bog('H.C. Andersen', 'Den grimme ælling');
echo $Bog1->læsForfatter() . ' - ' . $Bog1->læsTitel();

?>
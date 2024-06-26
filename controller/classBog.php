<?php
class Bog {
    private $forfatter;
    private $titel;

    function __construct($forfatter, $titel) {
        $this->forfatter = $forfatter;
        $this->titel = $titel;
    }

    function opretBog($forfatter, $titel) {
        $this->forfatter = $forfatter;
        $this->titel = $titel;
    }

    function læsForfatter() {
        return $this->forfatter;
    }

    function læsTitel() {
        return $this->titel;
    }

    function opdaterForfatter($forfatter) {
        $this->forfatter = $forfatter;
    }

    function opdaterTitel($titel) {
        $this->titel = $titel;
    }
}


?>
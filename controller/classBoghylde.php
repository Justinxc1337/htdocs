<?php
class Boghylde {
    private $boghyldeList = [];

    function tilføjBogObjekt($bog) {
        array_push($this->boghyldeList, $bog);
    }

    function findBogObjektForfatter($forfatter) {
        $bogf = [];
        foreach ($this->boghyldeList as $bog) {
            if ($bog->læsForfatter() == $forfatter) {
                $bogf[] = $bog;
            }
        }
        return $bogf;
    }

    function findBogObjektTitel($titel) {
    $bogf = [];
    foreach ($this->boghyldeList as $bog) {
        if (strpos($bog->læsTitel(), $titel) !== false) {
            $bogf[] = $bog;
        }
    }
    return $bogf;
}

    function findAlleBogObjekter() {
        return $this->boghyldeList;
    }

    function opdaterBogObjekt($forfatter, $titel) {
        $this->forfatter = $forfatter;
        $this->titel = $titel;
    }

    function sletBogObjekt($bogslet) {
        unset($this->boghyldeList[$bogslet]);
    }
}
?>
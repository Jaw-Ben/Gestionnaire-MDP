<?php


    
    function verifierSiPremier($num) {
        if ($num <= 1) {
            return false;
        }
        for ($i = 2; $i * $i <= $num; $i++) {
            if ($num % $i == 0) {
                return false;
            }
        }
        return true;
    }
        
    function premierAleatoire() {
        $prime = mt_rand(100, 500);
        while (!verifierSiPremier($prime)) {
            $prime = mt_rand(100, 500);
        }
        return $prime;
    }
        
    function inverseMod($val, $modulus) {
        $val = $val % $modulus;
        for ($x = 1; $x < $modulus; $x++) {
            if (($val * $x) % $modulus == 1) {
                return $x;
            }
        }
        return 1; // si non trouvé
    }
        
        function genererCles() {
            $p = premierAleatoire();
            $q = premierAleatoire();
            $n = $p * $q;
            $phi = ($p - 1) * ($q - 1);
        
            // Choix de e
            $e = mt_rand(2, $phi - 1);
            while (PGCD($e, $phi) != 1) {
                $e = mt_rand(2, $phi - 1);
            }
        
            // Calcul de d
            $d = inverseMod($e, $phi);
        
            return ['publique' => [$n, $e], 'privee' => [$n, $d]];
        }
        
        function PGCD($a, $b) {
            return $b == 0 ? $a : PGCD($b, $a % $b); //on le fait de facon récursif
        }
        
        function chiffrementRSA($texte, $cle) {
            [$n, $e] = $cle;
            $resultat = '';
            for ($i = 0; $i < strlen($texte); $i++) {
                $resultat .= strval(bcpowmod(ord($texte[$i]), $e, $n)) . ' ';
            }
            $resultat = substr($resultat, 0, -1);
        
            return str_replace(' ','-',$resultat);
        }
        
        function dechiffrementRSA($texteChiffre, $cle) {
            [$n, $d] = $cle;
            $resultat = '';
            $parts = explode('-', $texteChiffre);
            foreach ($parts as $part) {
                $resultat .= chr(bcpowmod($part, $d, $n));
            }
            return $resultat;
        }
        $masterkey = ["publique"=>[60833, 28831],"privee"=>[60833, 2887]];
        $mdpkey = ["publique"=>[18923, 10987],"privee"=>[18923, 499]];
?>
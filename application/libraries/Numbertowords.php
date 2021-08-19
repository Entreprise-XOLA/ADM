<?php

if (!defined('BASEPATH'))

  exit('No direct script access allowed');

class Numbertowords {

	function convert_number($number) {

		if (($number < 0) || ($number > 999999999)) {

			throw new Exception("Number is out of range");

		}

		$Gn = floor($number / 1000000);

		/* Millions (giga) */

		$number -= $Gn * 1000000;

		$kn = floor($number / 1000);

		/* Thousands (kilo) */

		$number -= $kn * 1000;

		$Hn = floor($number / 100);

		/* Hundreds (hecto) */

		$number -= $Hn * 100;
          
		$Dn = floor($number / 10);


		/* Tens (deca) */

		$n = $number % 10;

		/* Ones */

		$res = "";

		if ($Gn) {

			$res .= $this->convert_number($Gn) .  " Million";

		}

		if ($kn) {

			$res .= (empty($res) ? "" : " ") .$this->convert_number($kn) . " Mille";

		}

		if ($Hn) {
                if($Hn<2){
                    $res .= (empty($res) ? "" : " ") . " Cent";
                }else{
                    $res .= (empty($res) ? "" : " ") .$this->convert_number($Hn) . " Cent";
                }
			

		}

		$ones = array("", "Un", "Deux", "Trois", "Quatre", "Cinq", "Six", "Sept", "Huit", "Neuf", "Dix", "Onze", "Douze", "Treize", "Quatorze", "Quinze", "Seize", "Dix-sept", "Dix-huit", "Dix-neuf");

		$tens = array("", "", "Vingt", "Trente", "Quarante", "Cinquante", "Soixante", "Soixante-dix", "Quatre-vingts", "Quatre-vingt-dix");

		if ($Dn || $n) {

			if (!empty($res)) {

				$res .= "  ";

			}

			if ($Dn < 2) {

				$res .= $ones[$Dn * 10 + $n];

			}else if($Dn ==7 || $Dn == 9){
                //$res .= $ones[$Dn * 10 + $n];
                $res .= $tens[$Dn-1]. " ".$ones[10+ $n];
                
                //$Valeur = $Valeur + 10;
            } else {

				$res .= $tens[$Dn];

				if ($n) {

					$res .= "-" . $ones[$n];

				}

			}

		}

		if (empty($res)) {

			$res = "zero";

		}

		return $res;

	}

}

?>
<?php

function validateInput($input)
{
    if (!isset($input[1])) {
        throw new Exception("Error opgevangen: Verkeerd aantal argumenten. Roep de applicatie aan op de volgende manier: `wisselgeld.php <bedrag>`");
    }
    if ($input[1] < "0") {
        throw new Exception("Error opgevangen: Input moet een positief getal zijn.");
    }
    if (!is_numeric($input[1])) {
        throw new Exception("Error opgevangen: Input moet een valide getal zijn.");
    }
    return $input[1];
}

function calculateChange($amount)
{
    define("MONEY_UNITS", [50, 20, 10, 5, 2, 1, 0.5, 0.2, 0.1, 0.05]);

    if ($amount == 0) {
        exit("Geen wisselgeld");
    }

    foreach (MONEY_UNITS as $geldeenheid) {
        if ($amount >= $geldeenheid) {
            $aantalKeerGeldEenheidInRestBedrag = floor($amount / $geldeenheid);
            $amount = $amount - ($aantalKeerGeldEenheidInRestBedrag * $geldeenheid);


            if ($geldeenheid >= 1) {
                echo $aantalKeerGeldEenheidInRestBedrag . " x " . $geldeenheid . " euro" . PHP_EOL;
            } else {
                echo $aantalKeerGeldEenheidInRestBedrag . " x " . 100 * $geldeenheid . " cent" . PHP_EOL;
            }
        }
    }
}

function roundToPenny($input)
{
    return round(floatval($input / 0.05)) * 0.05;
}

try {
    calculateChange(roundToPenny(validateInput($argv)));
} catch (Exception $e) {
    echo $e->getmessage();
}

<?php

// app/helpers.php

use NumberToWords\NumberToWords;

function amount_in_words($number)
{
    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getNumberTransformer('en');

    return ucfirst($numberTransformer->toWords((int) $number)) . ' rupees only';
}
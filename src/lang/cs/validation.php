<?php

return [
    // Basic message, always used
    'basic'         => "Heslo musí obsahovat minimálně :min znaků",
    // Extra messages - depends on config
    'camel_case'    => "velké i malé písmeno",
    'numbers'       => "číslici",
    'special_chars' => "alespoň 1 speciální symbol z :chars",

    // Join phrase - messages above are put together into 1 string message
    // Between all mesages is inserted "join_comma"
    // last message is joined to the rest by "join_and"
    'join_comma'    => ", ",
    'join_and'      => " a ",
];
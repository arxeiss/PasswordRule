<?php

return [
    // Basic message, always used
    'basic'         => "Password must contains at least :min characters",
    // Extra messages - depends on config
    'camel_case'    => "lower and upper case character",
    'numbers'       => "number",
    'special_chars' => "at least 1 special symbol from :chars",

    // Join phrase - messages above are put together into 1 string message
    // Between all mesages is inserted "comma"
    // last message is joined to the rest by "join_and"
    'join_comma'    => ", ",
    'join_and'      => " and ",
];
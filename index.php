<?php

// Steg 1 - Ange lämpliga HTTP headers
// Läs mer här: https://stackoverflow.com/questions/10636611/how-does-access-control-allow-origin-header-work
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");

// Steg 2 - Skapa arrayer
$firstNamesMale = ["Kalle", "Mahmud", "Björn", "Jimmy", "Adam", "Bertil", "Cesar", "David", "Emil", "Dan"];
$firstNamesFemale = ["Åsa", "Sara", "Maria", "Lotta", "Amanda", "Sigrun", "Annika", "Yasmin", "Ulla", "Astrid"];
$lastNames = ["Öberg", "Al Hakim", "Ericson", "Björk", "Berglund", "Lundqvist", "Söderberg", "Hedlund", "Lundin", "Nyström"];

// Steg 3 - Skapa 10 namn och spara dessa i en ny array
$names = array();

for ($i = 0; $i < 10; $i++) {
    $gender = rand(0, 1);
    $firstName = $gender ? $firstNamesFemale[rand(0, 9)] : $firstNamesMale[rand(0, 9)];
    $lastName = $lastNames[rand(0, 9)];
    $name = array(
        "firstname" => $firstName,
        "lastname" => $lastName,
        "gender" => $gender ? "female" : "male",
        "age" => rand(1, 99),
        "email" => email($firstName, $lastName)
    );
    array_push($names, $name);
}

function email($firstName, $lastName)
{
    $firstName = mb_strtolower($firstName);
    $lastName = mb_strtolower($lastName);

    $search  = array('å', 'ä', 'ö', 'é', '-', ' ');
    $replace = array('a', 'a', 'o', 'e', '',  '');
    $firstName = str_replace($search, $replace, $firstName);
    $lastName = str_replace($search, $replace, $lastName);

    $firstName = mb_substr($firstName, 0, 2);
    $lastName = mb_substr($lastName, 0, 3);

    $email = "$firstName$lastName@example.com";

    return $email;
}
// print_r($names); die();

// Steg 4 – Konvertera PHP-arrayen ($names) till JSON
$json = json_encode($names, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// json_encode — Returns the JSON representation of a value // http://php.net/manual/en/function.json-encode.php

// Steg 5 – Skicka JSON till klienten
echo $json;

// OBS Viktigt!
// Ingen extra data får skickas till klienten,
// t.ex. HTML-kod
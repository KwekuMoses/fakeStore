<?php
//include_once "functions.php";
header('Content-Type: application/json');

class App
{



    public static function main()
    {
        try {
            $array        = self::getData();
            $errormessage = self::getErrorMessage();
            self::viewData($array, $errormessage);
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }




    public static function getData()
    {
        $json = file_get_contents("data.json");

        if (!$json)
            throw new Exception("Could not access URL");
        return json_decode($json, true);
    }

    public static function getErrorMessage()
    {
        $json = file_get_contents("error.json");

        if (!$json)
            throw new Exception("Could not access URL");
        return json_decode($json, true);
    }


    public static function viewData($array, $errormessage)
    {

        if ($_GET == null) {
            $json_string = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo $json_string;
        }

        $allowed_key_1 = isset($_GET['show']);
        $allowed_key_2 = isset($_GET['category']);
        if ($allowed_key_1 || $allowed_key_2) {
            if (isset($_GET['show'])) {
                $show = $_GET["show"];
                $array_count = count($array);



                if ($show > $array_count) {
                    print_array($errormessage[0]);
                }
            }


            if (isset($_GET['category'])) {
            }
        } else if ($_SERVER['QUERY_STRING'] !== '') {
            $json_string = json_encode($errormessage[2], JSON_PRETTY_PRINT);
            echo $json_string;
        }
    }
}

App::main();

/*
$json = json_encode($names,
JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
/*
$show = $_GET["show"];
if ($show < 18) {
echo "Too young";
} else {
echo "welcome old one";
}
*/
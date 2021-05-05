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
                if ($show < $array_count)

                    for ($i = 0; $i < $show; $i++) {
                        $random_number = (rand(0, 20));
                        $json_string = json_encode($array[$random_number], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                        echo $json_string;
                    }

                else if ($show > $array_count) {
                    print_array($errormessage[0]);
                }
            }


            if (isset($_GET['category'])) {
                $category = $_GET['category'];
                $print_these = array();


                foreach ($array as $product) {
                    if ($product['category'] == $category) {

                        array_push($print_these, $product);

                        if (count($print_these) > 0) {
                            //    print_r($product);
                            $json_string = json_encode($product, JSON_PRETTY_PRINT);
                            echo $json_string;
                        }
                    }
                }
                if (count($print_these) === 0) {
                    print_array($errormessage[1]);
                    echo count($print_these);
                }
            }
        } else if ($_SERVER['QUERY_STRING'] !== '') {
            print_array($errormessage[2]);
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
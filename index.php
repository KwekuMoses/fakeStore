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
                    $filteredArr = (array_filter($errormessage, function ($k) {
                        return $k == 0;
                    }, ARRAY_FILTER_USE_KEY));

                    $json_string = json_encode($filteredArr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;
                }

                if ($show <= $array_count) {

                    $x = [];
                    for ($i = 0; $i < $show; $i++) {
                        $k = array_rand($array);
                        $v = $array[$k];
                        array_push($x, $v);
                    }

                    $json_string = json_encode($x, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;
                }
            }


            if (isset($_GET['category'])) {
                $category = $_GET['category'];
                $new_array = [];


                foreach ($array as $product) {
                    if ($product['category'] == $category) {
                        array_push($new_array, $product);

                        /*  $print_these = [];
                        array_push($print_these, $product);

                        if (count($print_these) > 0) {
                            //    print_r($product);
                            $json_string = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                            echo $json_string;
                        }*/
                    }
                }
                $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo $json_string;

                /*      if (count($print_these) === 0) {
                    print_r($errormessage[1]);
                    echo count($print_these);
                }*/
            }
        } else if ($_SERVER['QUERY_STRING'] !== '') {
            $filteredArr = (array_filter($errormessage, function ($k) {
                return $k == 1;
            }, ARRAY_FILTER_USE_KEY));


            $json_string = json_encode($filteredArr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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
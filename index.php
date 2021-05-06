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
                    // print_r($errormessage);
                    $filteredArr = (array_filter($errormessage, function ($k) {
                        return $k == 0;
                    }, ARRAY_FILTER_USE_KEY));

                    $json_string = json_encode($filteredArr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;

                    //     print_r(array_filter($errormessage, "getMsg"));

                    /*
                    foreach ($errormessage as $key => $value) {
                        //    print_r($value);
                        foreach ($value as $msg) {
                            if ($msg === "Please enter a number between 1 and 20") {
                                print_r($msg);
                            }
                        }
                    }
                    */
                    /*$json_string = json_encode($errormessage, JSON_PRETTY_PRINT);
                    echo $json_string;
                    print_r($errormessage);*/
                }

                if ($show <= $array_count) {
                    //$k = (rand(0, 19));
                    // echo $k;
                    // echo "  ---  ";

                    //    print_r($array);
                    $x = [];
                    for ($i = 0; $i < $show; $i++) {
                        $k = array_rand($array);
                        $v = $array[$k];
                        array_push($x, $v);
                        /* array_push($x, $random_objects);
                    foreach ($x as $key => $value) {
                        // print_r($x);
                    }*/
                    }

                    $json_string = json_encode($x, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;


                    /*
                    $newArr = [];

                    for ($i = 0; $i < $show; $i++) {

                        $filteredArr = (array_filter($array, function ($k) {
                            return $k === 2;
                        }, ARRAY_FILTER_USE_KEY));
                        array_push($newArr, $filteredArr);
                    }

                    $json_string = json_encode($newArr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;
                    */
                }
            }


            if (isset($_GET['category'])) {
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
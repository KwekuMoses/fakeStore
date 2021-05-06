<?php
//* This document will display JSON
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

    //* Method for fetching data.json
    public static function getData()
    {
        $json = file_get_contents("data.json");

        if (!$json)
            throw new Exception("Could not access URL");
        return json_decode($json, true);
    }
    //* Method for fetching error.json
    public static function getErrorMessage()
    {
        $json = file_get_contents("error.json");

        if (!$json)
            throw new Exception("Could not access URL");
        return json_decode($json, true);
    }

    //* Method for sending data to browser
    public static function viewData($array, $errormessage)
    {
        //*If $_GET is null print entire $array object
        if ($_GET == null) {
            $json_string = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo $json_string;
        }

        //*If show or category is queried..
        $allowed_key_1 = isset($_GET['show']);
        $allowed_key_2 = isset($_GET['category']);
        if ($allowed_key_1 || $allowed_key_2) {

            if (isset($_GET['show'])) {
                $show = $_GET["show"];
                $array_count = count($array);


                //* If entered number is larger than number of items in $array
                if ($show > $array_count) {
                    $new_array = [];

                    array_push($new_array, $errormessage[0]);

                    $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;
                }

                //* If entered number is less than or equal to total number of objects
                if ($show <= $array_count) {

                    $x = [];
                    for ($i = 0; $i < $show; $i++) {
                        //* array_rand is a built in method for selecting random objects within $array
                        $key = array_rand($array);
                        $value = $array[$key];
                        array_push($x, $value);
                    }

                    $json_string = json_encode($x, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;
                }
            }


            if (isset($_GET['category'])) {
                $category = $_GET['category'];
                //* Array used for pushing desired values
                $new_array = [];


                //* Loop through the data.json array
                foreach ($array as $product) {
                    //* if $category matches category key, push the entire object into $new array
                    if ($product['category'] == $category) {
                        array_push($new_array, $product);
                    }
                }

                //* If no category is matched $new_array will be empty
                if (count($new_array) === 0) {
                    //* push the error message to $new_array    
                    array_push($new_array, $errormessage[1]);
                }
                //* print new array as JSON
                $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo $json_string;
            }
        }
        //* Handle what happens when a querystring is entered but this querystring is neither "show" or "category" was entered.
        else if ($_SERVER['QUERY_STRING'] !== '') {
            $new_array = [];

            array_push($new_array, $errormessage[2]);

            $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo $json_string;
        }
    }
}

//* Call the Main method in App
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
<?php
//* This document will display JSON
header('Content-Type: application/json');

class App
{
    public static function main()
    {
        try {
            $array        = self::getData();
            $errormessage = self::getErrorMessages();
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
    public static function getErrorMessages()
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

        //* if both category and show is being queried
        if (isset($_GET['category'], $_GET['show'])) {
            $category = $_GET['category'];
            $show = $_GET['show'];
            //* Array used for pushing desired values
            $new_array = [];
            $sliced_new_array = [];

            if ($show <= 20) {
                //* Loop through the data.json array
                foreach ($array as $product) {
                    //* if $category matches category key, push the entire object into $new array
                    if ($product['category'] == $category) {

                        array_push($new_array, $product);
                    }
                }

                //* if show is smaller than array length of new array display $show amount of products
                if ($show <= count($new_array)) {
                    $sliced_new_array = array_slice($new_array, 1, $show);
                    $json_string = json_encode($sliced_new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    //* print new array as JSON
                    $json_string = json_encode($sliced_new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;
                }

                //* if show is larger than array length of $new_array print the entire $new_array
                else {
                    //* echo the string only if new array is not empty
                    if (count($new_array) !== 0) {
                        $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                        echo $json_string;
                    }
                }
            }
            //* If a larger number is entered than number of products display an error message
            if ($show > count($array) && count($new_array) === 0) {
                array_push($new_array, $errormessage[0]);

                $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo $json_string;
            }


            //* If no category is matched $new_array will be empty
            if (count($new_array) === 0) {
                //* push the error message to $new_array    
                array_push($new_array, $errormessage[1]);
                //* print new array as JSON
                $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo $json_string;
            }
        }


        //*If only one of either show or category is queried.
        if (isset($_GET['category']) || isset($_GET['show']) and count($_GET) == 1) {

            //* Handle Show Request
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

                    $random_array = [];
                    for ($i = 0; $i < $show; $i++) {
                        //* array_rand is a built in method for selecting random objects within $array
                        $key = array_rand($array);
                        $value = $array[$key];
                        array_push($random_array, $value);
                    }

                    $json_string = json_encode($random_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    echo $json_string;
                }
            }

            //* Handle Category Request
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
        } else if (count($_GET) > 0 && !isset($_GET['show'], $_GET['category'])) {
            $new_array = [];
            array_push($new_array, $errormessage[3]);
            $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo $json_string;
        }



        //* Handle what happens when a query-string is entered but this query-string is neither "show" or "category" was entered.
        /* if ($_SERVER['QUERY_STRING'] !== '') { {
                $new_array = [];
                array_push($new_array, $errormessage[3]);
                $json_string = json_encode($new_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                echo $json_string;
            };
        }*/
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
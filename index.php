<?php
include_once "functions.php";


class App {




    public static function main()
    {
        try {
            $array = self::getData();
            self::viewData($array);
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }




public static function getData()
    {
        $json = file_get_contents("http://localhost/PHP/Inl%C3%A4mning-2/fakeStore/data.json");

        if (!$json)
            throw new Exception("Could not access URL");
        return json_decode($json, true);
    }


public static function viewData($array)
    {
   /*    if show = 18 visa 18
       if category = jewelry visa bara jewelry
       if show = 100 välj en mindre siffra
       if category = jew kategorin existerar inte */
       if (isset($_GET['show'])) { 
        $show = $_GET["show"];
            for ($i = 0; $i < $show; $i++) {
                print_array($array[$i]);
              }         
    }
    else {
        print_array($array);
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
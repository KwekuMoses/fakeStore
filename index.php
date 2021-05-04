<?php
include_once "functions.php";


class App
{
    
    
    
    public static function main()
    {
        try {
            $array        = self::getData();
            $errormessage = self::getErrorMessage();
            self::viewData($array, $errormessage);
        }
        catch (Exception $error) {
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
    
    public static function getErrorMessage()
    {
        $json = file_get_contents("http://localhost/PHP/Inl%C3%A4mning-2/fakeStore/error.json");
        
        if (!$json)
            throw new Exception("Could not access URL");
        return json_decode($json, true);
    }
    
    
    public static function viewData($array, $errormessage)
    {
        if (isset($_GET['show'])) {
            $show = $_GET["show"];
            if ($show < 20)
                for ($i = 0; $i < $show; $i++) {
                    print_array($array[$i]);
                } else if ($show > 20) {
                print_array($errormessage[0]);
            }
        }

        
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            foreach ($array as $product) {
                if ($product['category'] == $category) {
                    print_array($product);
                }
              
            }
            if ($category) {
                print_array($errormessage[1]);
                exit(0);
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
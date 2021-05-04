<?php
include_once "fakeStore.json";

/*
class App
{

    public static $endpoint = "fakeStore.json";


    public static function main()
    {
        try {
       //     $array = self::getData();

            //self::viewData($array);
            //echo $array;
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }



    /*****
     * En klassmetod som hämtar data
     */
  /*  public static function getData()
    {
        $json =  @file_get_contents(self::$endpoint);
        if (!$json)
            throw new Exception("Could not access " . self::$endpoint);

        return json_decode($json, true);
    }


    /*****
     * En klassmetod som renderar data
     */

//    public static function viewData($array)
    /*{

        foreach ($array as $user) {
            //   "<div style=width:200px>$user[name] . <br></div> ";
            echo "<div style='background-color:black;color:white;padding:20px; width:200px;'>";
            echo ($user['name']) . "<br>";
            echo ($user['address']['street']) . "<br>";
            echo ($user['address']['suite']) . "<br>";
            echo ($user['address']['city']) . "<br>";
            echo ($user['address']['zipcode']) . "<br> <br>";
            echo  "</div> " . " <br>";
        }
    }*/
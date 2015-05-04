<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require('apartment.php');
require('apartment_repository.php');
header('Content-Type: application/json');

//$data = NULL;
$data = json_decode(file_get_contents('php://input'));

if(isset($data->id))
{
    $id = $data->id;
    $apt = ApartmentRepository::getAptDetailsByID($id);
    $jsonAptArray = NULL;
    $jsonAptArray = array(
        "id" => $apt->getID(),
        "latitude" => $apt->getLatitude(),
        "longitude" => $apt->getLongitude(),
        "area" => $apt->getArea(),
        "price" => $apt->getPrice(),
        "city" => $apt->getCity(),
        "amenities" => utf8_encode($apt->getAmenities()),
        "description" => $apt->getDescription(),
        "date" => $apt->getDate(),
        "images" => $apt->getImages()
        );
    echo (json_encode($jsonAptArray));
}
else if(isset($data->word) || isset($data->minprice) || isset($data->maxprice) || isset($data->br))

{
    $word = $data->word;
    $minprice = $data->minprice;
    $maxprice = $data->maxprice;
    $bedroom = $data->br;
    $apt = ApartmentRepository::searchApts($word, $minprice, $maxprice, $bedroom);
    $jsonAptArray = array();
    for($i = 0; $i < count($apt); $i++)
    {
        $jsonAptArray[$i] = array(
            "id" => $apt[$i]->getID(),
            "latitude" => $apt[$i]->getLatitude(),
            "longitude" => $apt[$i]->getLongitude(),
            "area" => $apt[$i]->getArea(),
            "price" => $apt[$i]->getPrice(),
            "city" => $apt[$i]->getCity(),
            "amenities" => utf8_encode($apt[$i]->getAmenities()),
            "description" => $apt[$i]->getDescription(),
            "date" => $apt[$i]->getDate(),
            "images" => $apt[$i]->getImages()
        );
    }
    echo (json_encode($jsonAptArray));
}
else
{
    //echo "generalquery";
    $apt = ApartmentRepository::getAptDetails(); 
    $jsonAptArray = array();
    for($i = 0; $i < count($apt); $i++)
    {
    $jsonAptArray[$i] = array(
        "id" => $apt[$i]->getID(),
        "latitude" => $apt[$i]->getLatitude(),
        "longitude" => $apt[$i]->getLongitude(),
        "area" => $apt[$i]->getArea(),
        "price" => $apt[$i]->getPrice(),
        "city" => $apt[$i]->getCity(),
        "amenities" => utf8_encode($apt[$i]->getAmenities()),
        "description" => $apt[$i]->getDescription(),
        "date" => $apt[$i]->getDate(),
        "images" => $apt[$i]->getImages()
        );
    }
    echo (json_encode($jsonAptArray));
}
<?php

ini_set('error_reporting', E_ALL);
ini_set('user-agent', "PHP");

define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));

$dbhost = constant("DB_HOST"); // Host name 
$dbport = constant("DB_PORT"); // Host port
$dbusername = constant("DB_USER"); // Mysql username 
$dbpassword = constant("DB_PASS"); // Mysql password 
$db_name = constant("DB_NAME"); // Database name 

$con = mysql_connect($dbhost, $dbusername, $dbpassword) OR DIE ("Error: ". mysql_error($con));
mysql_select_db($db_name, $con);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ApartmentRepository{

    function add_apartments($a) {
    $price = intval($a->getPrice());
    $br = intval($a->getBedrooms());
    $amenities = mysql_real_escape_string($a->getAmenities());
    $city = mysql_real_escape_string($a->getCity());
    $des = mysql_real_escape_string($a->getDescription());
    $date = $a->getDate();
    $id = $a->getCrID();
    $lat = floatval($a->getLatitude());
    $long = floatval($a->getLongitude());
    $area = intval($a->getArea());
    $query = "insert into rentalapts(latitude, longitude, description, dateposted, area, bedrooms, price, amenities, city, craigslistID)"
              . " values($lat, $long, '$des', '$date', $area, $br, $price, '$amenities', '$city', '$id')";

    $result = mysql_query($query);
}


function add_apt_images($id, $images)
{
    $id = intval($id);
    for($i = 0; $i < count($images); $i++)
    {
        $query = "insert into aptphotos(ID, link) values($id,'$images[$i]')";
        $result = mysql_query($query);
    }
}

function get_no($id)
{
    $query = "select ID from rentalapts where craigslistID = $id";
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    return $row['ID'];          
}


function getAptDetails()
{
    $query = "select * from rentalapts order by dateposted desc";

    $result = mysql_query($query);
    $apt = array();
    while ($row = mysql_fetch_assoc($result)) {
        $a = self::getImage($row['ID']);
        $apt[] = new Apartment($row['ID'], $row['craigslistID'], $row['latitude'], $row['longitude'], $row['description'],
                $row['city'], $row['dateposted'],$row['area'],$row['price'], $row['bedrooms'],$row['amenities'], $a);
    }
    return $apt;
}

function getAptDetailsByID($id)
{
    $query = "select * from rentalapts where ID = $id";
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    $a = self::getImage($row['ID']);
    $apt = new Apartment($row['ID'], $row['craigslistID'], $row['latitude'], $row['longitude'], $row['description'],
                    $row['city'], $row['dateposted'],$row['area'],$row['price'], $row['bedrooms'],$row['amenities'], $a);
    return $apt;
}

function searchApts($value, $minprice, $maxprice, $bedroom)
{
    $query = "select * from rentalapts where (description like '%$value%' or amenities like '%$value%' or city like '%$value%') and (price >= $minprice and price <= $maxprice) and (bedrooms >= $bedroom)";
    $result = mysql_query($query);
    $apt = array();
    while ($row = mysql_fetch_assoc($result)) {
        $a = self::getImage($row['ID']);
        $apt[] = new Apartment($row['ID'], $row['craigslistID'], $row['latitude'], $row['longitude'], $row['description'],
                $row['city'], $row['dateposted'],$row['area'],$row['price'], $row['bedrooms'],$row['amenities'], $a);
    }
    return $apt;    
}

function getImage($id)
{
    $query = "select * from aptphotos where ID = $id";
    $result = mysql_query($query);
    $array = array();
    $i = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $array[$i] = $row['link'];
        $i++;
    }
    return $array;
}

function getAptCountByCraigslistID($id)
{
    $query = "select * from rentalapts where craigslistID = $id";
    $result = mysql_query($query);
    if(mysql_num_rows($result) > 0)
    {
        return TRUE;
    }
    return FALSE;
}
}

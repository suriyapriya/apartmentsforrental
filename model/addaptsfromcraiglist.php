<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include '../simple_html_dom.php';

    // Create DOM from URL or file
    $html = file_get_html('http://sfbay.craigslist.org/apa/#list');
    $nodes = $html->find("div.content", 0);
    $y = 0;
    for($i = 1; $i <= 20; $i++)
    {
        $price = 0;
        $br = 0;
        $amenities = NULL;
        $city = NULL;
        $des = NULL;
        $date = NULL;
        $id = NULL;
        $lat = NULL;
        $long = NULL;
        $area = 0;
        $images = NULL;
        
        if(!($s = $nodes->children($i)))
            continue;
        
        $a = new ApartmentParser($s);
        $a->setID();
        $a->setLatitude();
        $a->setLongitude();
        $a->setAmenities();
        $a->setDescription();
        $a->setCity();
        $a->setDate();
        $a->setPrice();
        $a->setArea();
        $a->setBedrooms();
        $a->setImage();
        $price = $a->getPrice();
        $br = $a->getBedrooms();
        $amenities = $a->getAmenities();
        $city = $a->getCity();
        $des = $a->getDescription();
        $date = $a->getDate();
        $id = $a->getID();
        $lat = $a->getLatitude();
        $long = $a->getLongitude();
        $area = $a->getArea();
        $images = $a->getImage();
        if(ApartmentRepository::getAptCountByCraigslistID($id))
        {
            echo "******* Same ID".'<br>';
            continue;
        }
        $newapt = new Apartment(0, $id, $lat, $long, $des, $city, $date, $area, $price, $br, $amenities, $images);
        ApartmentRepository::add_apartments($newapt);
        $no = ApartmentRepository::get_no($id);
        ApartmentRepository::add_apt_images($no, $images);
        echo "NO: ".$y++.'<br>';
        echo "ID: ".$id.'<br>';
        echo "Lat: ".$lat.'<br>';
        echo "Long: ".$long.'<br>';                
        echo "Price: ". $price.'<br>';
        echo "Bedrooms: ".$br.'<br>';
        echo "Area: ".$area.'<br>';
        echo "Description: ". $des.'<br>';
        echo "City: ".$city.'<br>';
        echo "Amenities: ".$amenities.'<br>';
        echo "date: ".$date.'<br>';
        echo $i.'****************************'.'<br>';
    }
      ?>
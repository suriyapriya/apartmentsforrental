<?php
//http://simplehtmldom.sourceforge.net/manual.htm#section_quickstart
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    require('../model/apartmentParser.php');
    require('../model/apartment.php');
    require('../model/apartment_repository.php');

    if(isset($_POST['action']))
        $action = $_POST['action'];
    else if(isset($_GET['action']))
        $action = $_GET['action'];
    else
        $action = 'list_apts';

    $error = "";
    if($action == 'add_apts')
    {
        include '../model/addaptsfromcraiglist.php';
    }
    else if($action == 'list_apts')
    {
        $apt = NULL;
        if(isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $search = $_GET['search'];       
                $apt = ApartmentRepository::searchApts($search);
                if(!isset($apt))
                {
                    $error = "NO RESULTS FOUND";
                }
            }
        }
        else
        {
            $apt = ApartmentRepository::getAptDetails();
        }
        include 'header.php';
        include 'sidebar.php';
        include 'showMainPage.php';
    }
    else if($action == 'show_map')
    {
        include 'header.php';
        include 'sidebar.php';
        $description = "";
        $city = "";
        if(isset($_POST['ID']))
        {
            $id = $_POST['ID'];
            $apt = ApartmentRepository::getAptDetailsByID($id);
            $lat = $apt->getLatitude();
            $long = $apt->getLongitude();
            $description = $apt->getDescription();
            $city = $apt->getCity();
            if($lat == 0 && $long == 0)
            {
                $error = "NO MAPS ARE AVAILABLE";
                //echo $lat.'<br>',$long.'<br>'.$city.'<br>';
            }
        }
        include 'showmap.php';
    }
    else if($action == 'show_amenities')
    {
        include 'header.php';
        include 'sidebar.php';
        if(isset($_POST['ID']))
        {
            $id = $_POST['ID'];
            $apt = ApartmentRepository::getAptDetailsByID($id);
            $amenities = $apt->getAmenities();
            if(empty($amenities))
            {
                $error = "NO IMAGES ARE AVAILABLE";
            }
        }
        else
        {
            $error = "NO IMAGES ARE AVAILABLE";
        }
        include 'showamenities.php';

    }
    else if($action == 'show_images')
    {
        include 'header.php';
        include 'sidebar.php';
        $images = array();
        if(isset($_POST['ID']))
        {
            $id = $_POST['ID'];
            $apt = ApartmentRepository::getAptDetailsByID($id);
            $images = $apt->getImages();
            if(!count($images))
            {
                $error = "NO IMAGES ARE AVAILABLE";
            }
        }
        include 'showimages.php';
    }
    else if($action == 'search_apts')
    {
        $value = NULL;
        include 'header.php';
        include 'sidebar.php';
        if(isset($_POST['search']))
        {
            if(!empty($_POST['search']))
            {
            $value = $_POST['search'];
            }
        }
        
        header("Location:.?action=list_apts&search=$value");
    }
?>
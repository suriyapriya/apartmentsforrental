<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Apartment{
    private $aptID, $craigslistID, $latitude, $longitude, $description, $dateposted,
            $area, $price, $bedrooms, $amenities, $city, $images;

    public function __construct($aptID, $CrID, $latitude, $longitude, $description, $city, $dateposted,
            $area, $price, $bedrooms, $amenities, $images) {
        $this->aptID = $aptID;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->description = $description;
        $this->city = $city;
        $this->dateposted = $dateposted;
        $this->area = $area;
        $this->price = $price;
        $this->bedrooms = $bedrooms;
        $this->amenities = $amenities;
        $this->images = $images;
        $this->craigslistID = $CrID;
    }
    
    public function setID($id) {
        $this->aptID = $id;
    }
    public function getID() {
        return $this->aptID;
    }

    public function setCrID($id) {
        $this->craigslistID = $id;
    }
    public function getCrID() {
        return $this->craigslistID;
    }
    
    public function setLatitude($lat) {
        $this->latitude = $lat;
    }
    public function getLatitude() {
        return $this->latitude;
    }  
    
    public function setLongitude($long) {
    $this->longitude = $long;
    }
    
    public function getLongitude() {
        return $this->longitude;
    }
    
    public function setDescription($describe) {
        $this->description = $describe;
    }
    public function getDescription() {
        return $this->description;
    }
    
    public function setPrice($price) {
        $this->price = $price;
    }
    public function getPrice() {
        return $this->price;
    }
    
    public function setBedrooms($br) {
        $this->bedrooms = $br;
    }
    
    public function getBedrooms() {
        return $this->bedrooms;
    }
    
    public function setDate($date) {
        $this->dateposted = $date;
    }
    public function getDate() {
        return $this->dateposted;
    }
    
    public function setArea($area) {
        $this->area = $area;
    }
    public function getArea() {
        return $this->area;
    }
    
    public function setAmenities($amenities) {
        $this->amenities = $amenities;
    }
    public function getAmenities() {
        return $this->amenities;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getImages()
    {
        return $this->images;
    }    
}

?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ApartmentParser
{
    CONST LINKTOCRAIGSLIST = "http://sfbay.craigslist.org";
    private $id, $lat, $long, $description, $dateupdated, $area, $price, $bedrooms, $amenities, $city, $image, $html, $list;
    
    public function __construct($s) {
            $this->list = $s;
            $s = $s->children(0)->getAttribute('href');
            $this->html = file_get_html(self::LINKTOCRAIGSLIST . $s);
    }
    
    public function setLatitude()
    {
        if($element = $this->html->getElementById("#map"))
        {
            $this->lat = $element->getAttribute('data-latitude');
        }
    }
    
    
    public function setLongitude()
    {
        if($element = $this->html->getElementById("#map"))
        {
            $this->long = $element->getAttribute('data-longitude');
        }
    }
    
    public function setID()
    {
        if($element = $this->list->getAttribute('data-pid'))
        {
            $this->id = $element;
        }
        if(!$this->id && $element = $this->html->getElementById(".postinginfos"))
        {
            if($val = $element->children(0))
            {
                $val = $val->plaintext;
                $val = split(':', $val);
                echo $val[1].'<br>';              
                $this->id = trim($val[1]);
            }
        }
    }
    
    public function setImage()
    {
        if(($ld = $this->html->find("figure.iw", 0)) && ($dd = $ld->getElementById("#thumbs")))
        {
            for($k = 0; ($r=$dd->children($k)); $k++)
            {
                $this->image[$k] = ($r->getAttribute('href'));
                //echo "image: ".$r->getAttribute('href').'<br>';
            }
        }
        if(!$this->image && ($ld = $this->html->find("figure.iw", 0)) && ($dd = $ld->children(0)))
        {
            if(($r = $dd->getElementById("#iwi")) && $dd = $r->getAttribute('src'))
            {
                $this->image[0] = $dd;
            }
        }
    }

    public function setAmenities()
    {
        if($element = $this->html->getElementById("#postingbody"))
        {
            //$array = [$id => $element->plaintext];
            //$this->amenities = $element->outertext;
            $this->amenities = $element->innertext;
            //$this->amenities = $element->plaintext;
        }
    }

    public function setDate()
    {
        if($element = $this->html->getElementById(".postinginfos"))
        {
            if($val = $element->children(2)->plaintext)
            {
                if(strstr($val, 'updated'))
                {
                    $this->dateupdated = $element->children(2)->children(0)->plaintext;
                    return;
                }                   
            }
            if($val = $element->children(1)->plaintext)
            {
                if(strstr($val, 'posted'))
                {
                    $this->dateupdated = $element->children(1)->children(0)->plaintext;
                    return;
                }
            }
        }
    }

    public function setPrice()
    {                   
        if(($title = $this->list->plaintext))
        {
                if(preg_match('/&#x0024;([0-9]+)/', $title, $d))
                {
                    $this->price = intval(trim($d[1]));
                }
        }
    }
    
    public function setArea()
    {
        if(($title = $this->list->plaintext))
        {
                if(preg_match('/([0-9]+)ft&sup2;/', $title, $d))
                {
                    $this->area = intval(trim($d[1]));
                }
        }
    }
    
    public function setBedrooms()
    {
        if(($title = $this->list->plaintext))
        {
            if(preg_match('/([0-9]?)br/', $title, $d))
            {
                $this->bedrooms = intval(trim($d[1]));
            }
        }
    }

    public function setCity()
    {
        if(($title = $this->list->plaintext))
        {
            if(preg_match('/[-]+[ ]+\(([a-z\/ A-Z]+)\)/', $title, $m))
            {
                    $this->city = $m[1];
            }
        }
    }

    public function setDescription()
    {
        if(($t = $this->list->children(2)) && ($w = $t->children(1)))
        {
            $this->description = $w->plaintext;
            //echo 'des: '.$v.'<br>';
        }
    }

    public function getID()
    {
        return $this->id;
    }

    public function getLatitude()
    {
        return $this->lat;
    }
    
    public function getLongitude()
    {
        return $this->long;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getPrice()
    {
        return $this->price;
    }

    public function getAmenities()
    {
        return $this->amenities;
    }
    
    public function getDate()
    {
        return $this->dateupdated;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getBedrooms()
    {
        return $this->bedrooms;
    }
    
    public function getArea()
    {
        return $this->area;
    }
    
    public function getImage()
    {
        return $this->image;
    }
}
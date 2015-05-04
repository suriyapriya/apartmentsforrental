<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include '../simple_html_dom.php';


// Create DOM from URL
$html = file_get_html('http://slashdot.org/');

// Find all article blocks
// Find all links 
foreach($html->find('a') as $element) 
       echo $element->href . '<br>';
?>
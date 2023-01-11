<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class TestController extends BaseController
{
    public function test()
    {
        // Initialize a connection with cURL (ch = cURL handle, or "channel")
        $ch = curl_init();

        $urls = [
            'LPbLcZ/floorplans-furniture-living-room-renovation-3d',
            'LPJaZZ/floorplans-house-terrace-furniture-decor-3d',
            'LPJPaZ/floorplans-living-room-3d'
        ];

        //foreach ($urls as $url) {

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, "https://planner5d.com/gallery/floorplans/LPJaZZ/floorplans-house-terrace-furniture-decor-3d");

        // Set the HTTP method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // Return the response instead of printing it out
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Send the request and store the result in $response
        return $this->html_to_obj(curl_exec($ch));


    }

    public function html_to_obj($html) {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        return $this->element_to_obj($dom->documentElement);
    }

    public function element_to_obj($element) {
        if (!isset($element->tagName)) {
            $element = $element->parentNode;
        }
        try {
            $obj = array( "tag" => $element->tagName );
        } catch (\Exception $e) {
            dd($e, $element->parentNode);
        }
        foreach ($element->attributes as $attribute) {
            $obj[$attribute->name] = $attribute->value;
        }
        foreach ($element->childNodes as $subElement) {
            if ($subElement->nodeType == XML_TEXT_NODE) {
                $obj["html"] = $subElement->wholeText;
            }
            else {
                $obj["children"][] = $this->element_to_obj($subElement);
            }
        }
        return $obj;
    }
}

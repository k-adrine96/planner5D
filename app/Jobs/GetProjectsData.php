<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetProjectsData implements ShouldQueue
{
    use Dispatchable;

    const TITLE            = "//div[@id='grid']//h3//a";
    const PREVIEW_PAGE_URL = "//div[@id='grid']//h3//a/@href";
    const THUMBNAIL        = "//div[@id='grid']//a//img[contains(@src,'thumbs.600')]/@src";

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function handle()
    {
        $pages = $this->getPages(3);
        $data  = $this->getProjectsData($pages);
        Project::insert($data);
    }

    /**
     * @return array
     */
    private function getPages($amount)
    {
        $pages = array();
        for ($i = 1; $i <= $amount; $i++) {
            $pages[] = "https://planner5d.com/gallery/floorplans?sort=editorschoice&page=".$i;
        }

        return $pages;
    }

    /**
     * @param $url
     *
     * @return array
     */
    function curl($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_CONNECTTIMEOUT => 500,
            CURLOPT_TIMEOUT        => 500,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT      => "",
            CURLOPT_COOKIESESSION  => false
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $output['content'] = curl_exec($ch);
        $output['err']     = curl_errno($ch);
        $output['errmsg']  = curl_error($ch);
        $output['header']  = curl_getinfo($ch);

        return $output;
    }

    private function getProjectsData($pages)
    {
        $doc      = new \DOMDocument();
        libxml_use_internal_errors(true);
        $nodeList = array();
        $index    = 0;
        foreach ($pages as $page) {
            $curl = $this->curl($page);
            $doc->loadHTML($curl['content']);
            $doc->preserveWhiteSpace = false;

            $xpath  = new \DOMXPath($doc);
            $urls   = $xpath->query(self::PREVIEW_PAGE_URL);
            $titles = $xpath->query(self::TITLE);
            $images = $xpath->query(self::THUMBNAIL);

            for ($i = 0; $i < count($urls); $i++) {
                $nodeList[$index]['url']   = $urls[$i]->nodeValue;
                $nodeList[$index]['title'] = trim($titles[$i]->nodeValue);
                $nodeList[$index]['image'] = $images[$i]->nodeValue;
                $index++;
            }
        }

        return $nodeList;
    }
}

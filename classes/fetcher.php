<?php

use Sunra\PhpSimple\HtmlDomParser;

/**
 * Description of fetcher
 *
 * @author Raimondas
 */
class Fetcher extends \SimplePie {
     /**
     * Instance of slim app
     *
     * @var \Slim\Slim 
     */
    public $slim;
    
    /**
     * Constructor
     * 
     * @param \Slim\Slim $app
     * 
     * @return \Fetcher
     */
    public function __construct(\Slim\Slim $app) {
        $this->slim = $app;  
        
        parent::__construct();
        
        parent::set_feed_url(SRC_RSS);
        parent::set_cache_location(
            dirname(__DIR__) . '/cache/'
        );
        parent::set_cache_duration(UPDATE_INTERVAL);
        parent::init();
        parent::handle_content_type();                
    }
    
    /**
     * Returns cached image for irem
     * 
     * @param \SimplePie_Item $item
     * 
     * @return string
     */
    public function getImageForItem(\SimplePie_Item &$item) {
        $htmlDOM = HtmlDomParser::str_get_html($item->get_content());
        $image = $htmlDOM->find('img')[0]->attr['src'];
        
        if (!$image) {
            $image = 'http://lorempixel.com/g/50/50/';
        }
        
        $fname = '/cache/' . sha1($image) . '.png';
        $real_name = dirname(__DIR__) . $fname;
        
        if (!file_exists($real_name)) {
            
            $ch = curl_init ($image);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
            $raw=curl_exec($ch);
            curl_close ($ch);                

            $img = \WideImage\WideImage::loadFromString($raw);
            $img->resize(50, 50)->saveToFile($real_name);
        }
        
        return '.' . $fname;
    }
    
    /**
     * Truncate string if needed
     * 
     * @param string $string
     * @param int $length
     * 
     * @return string
     */
    private function truncateIfNeeded($string, $length) {
         return mb_strlen($string) > $length ? mb_substr($string,0,$length)."..." : $string;
    }
    
    /**
     * Extracts data for feed
     * 
     * @param \SimplePie_Item $item
     * 
     * @return array
     */
    public function extractData(\SimplePie_Item &$item) {
        $ret = [
            'image_url' => $this->getImageForItem($item),
            'content' => html_entity_decode($item->get_content()),
            'title' => $this->truncateIfNeeded($item->get_title(), 100),
            'link' => $item->get_link()
        ];
        
        $ret['content'] = preg_replace('/<img[^>]+>/', '', $ret['content']);
        
        $ret['content'] = $this->truncateIfNeeded($ret['content'], 150);
        
        return $ret;
    }
    
}

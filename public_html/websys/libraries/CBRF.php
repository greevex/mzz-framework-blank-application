<?php
/**
 * CBRF course parser
 *
 * @package modules
 * @subpackage center
 * @version 1.0
 */
class CBRF
{
    
    private $url, $xml, $data;
    
    public $cachedir, $filename_pattern;
    
    public $course;
    
    function __construct($url = "http://www.cbr.ru/scripts/XML_daily.asp")
    {
        $this->url              = $url;
        $this->cachedir         = realpath(dirname(__FILE__)) . "/xml_cache";
        $this->filename_pattern = "/currency_%d-%m-%Y.xml";
    }
    
    /**
    * Парсим данные с сайта ЦБРФ или из кэша, если данные уже загружались сегодня.
    * 
    */
    private function parseData()
    {
        if(!is_array($this->course)) {
            if(!file_exists($this->cachedir)) {
                mkdir($this->cachedir, 0700);
            }
            
            if (!file_exists($this->cachedir . strftime($this->filename_pattern))) {
                $this->data = file_get_contents($this->url);
                file_put_contents($this->cachedir . strftime($this->filename_pattern), $this->data);
            }
            $this->data = file_get_contents($this->cachedir . strftime($this->filename_pattern));
            $this->xml = new XML($this->data);
            $this->course = $this->xml->getResult();
        }
    }
    
    /**
    * Метод получения курса по коду валюты
    * 
    * @param string $code
    * @return float
    */
    public function getCourse($code)
    {
        $this->parseData();
        return isset($this->course[$code]) ? $this->course[$code] : false;
    }
    
    /**
    * Метод получения всех курсов из ЦБРФ
    * 
    * @return array
    */
    public function getAllCourses()
    {
        return $this->course;
    }
}

/**
* XML Class
* 
* PHP Version 5
* 
* @author GreeveX
* @author lz_speedy
*/
class XML
{
    
    private $data;
    
    private $parsed;
    
    /**
    * Construct
    * 
    * @param mixed $content
    */
    function __construct($content)
    {
        $this->data = $this->my_xml2array($content);
        
        foreach ($this->data[0] as $data_key => $data_val) {
            if(intval($data_key) || $data_key === 0) {
                foreach ($data_val as $k => $v) {
                    if(intval($k) || $k === 0) {
                        $parsed[$data_key][$v['name']] = $v['value'];
                    }
                }
            }
        }
        $this->data = null;
        foreach($parsed as $p) {
            $this->data[$p['CharCode']] = str_replace(',', '.', $p['Value']);
        }
    }
    
    /**
    * Возвращаем массив валют
    * 
    * @return array
    */
    public function getResult()
    {
        return $this->data;
    }
    
    private function my_xml2array($contents) 
    { 
        $xml_values = array(); 
        $parser = xml_parser_create(''); 
        if(!$parser) 
            return false; 

        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8'); 
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
        xml_parse_into_struct($parser, trim($contents), $xml_values); 
        xml_parser_free($parser); 
        if (!$xml_values) 
            return array(); 
        
        $xml_array = array(); 
        $last_tag_ar =& $xml_array; 
        $parents = array(); 
        $last_counter_in_tag = array(1=>0); 
        foreach ($xml_values as $data) 
        { 
            switch($data['type']) 
            { 
                case 'open': 
                    $last_counter_in_tag[$data['level']+1] = 0; 
                    $new_tag = array('name' => $data['tag']); 
                    if(isset($data['attributes'])) 
                        $new_tag['attributes'] = $data['attributes']; 
                    if(isset($data['value']) && trim($data['value'])) 
                        $new_tag['value'] = trim($data['value']); 
                    $last_tag_ar[$last_counter_in_tag[$data['level']]] = $new_tag; 
                    $parents[$data['level']] =& $last_tag_ar; 
                    $last_tag_ar =& $last_tag_ar[$last_counter_in_tag[$data['level']]++]; 
                    break; 
                case 'complete': 
                    $new_tag = array('name' => $data['tag']); 
                    if(isset($data['attributes'])) 
                        $new_tag['attributes'] = $data['attributes']; 
                    if(isset($data['value']) && trim($data['value'])) 
                        $new_tag['value'] = trim($data['value']); 

                    $last_count = count($last_tag_ar)-1; 
                    $last_tag_ar[$last_counter_in_tag[$data['level']]++] = $new_tag; 
                    break; 
                case 'close': 
                    $last_tag_ar =& $parents[$data['level']]; 
                    break; 
                default: 
                    break; 
            }; 
        } 
        return $xml_array; 
    }
}
?>
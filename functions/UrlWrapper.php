<?php
class UrlWrapper
{
    /** @var string */
    private $url;
    
    public function __construct($url) {
        $this->url = $url;
    }
    
    public function getDecodedContent($debug = false)
    {
        $result = json_decode(trim(file_get_contents($this->url)));
        if ($debug
            or $result === null
        ) {
            if ($result === null) {
                print '<div style="color: red; font-weight:bold;">';                
            }
            print '<pre>';
            print $this->url . "\n";
            var_dump($result);
            print '</pre>';
            if ($result === null) {
                print '</div>';
                exit;
            }
        }
        return $result;
    }
}
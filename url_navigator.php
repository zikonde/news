<?php 

function add_to_url($includes = 0, $url = 0){
    $parsed_url = ($url === 0? parse_url(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:""):parse_url($url));  
    
    $next_url =  $parsed_url['path']."?".(isset($parsed_url['query'])? $parsed_url['query']:"");

    if($includes !== 0){
        foreach ($includes as $key => $value) {
            $next_url =  preg_replace('/&'."$key".'=[^&]+(&|$)/', '$1', $next_url);
            $next_url =  $next_url."&$key=$value";
        }
    }
    
    return $next_url;
}
?>
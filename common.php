<?php

function d($var){
    echo '<pre>';
    var_dump($var);
    echo PHP_EOL.'<br />';
}

function dump($var){
    echo '<pre>';
    var_dump($var);
}
//字符串截取
function get_co_use_pos($con,$start_str,$end_str){
    $len = strlen($start_str);
    $pos = strpos($con,$start_str);
    $pos_end = strpos($con, $end_str,$pos+$len);
    $target = substr($con, $pos+$len,$pos_end-$pos-$len);
    return $target;
}

function cache($url, $con='',$touch=false){
    $fileName = md5($url).'.txt';
    $file= CACHE_PATH.$fileName;

    if($touch){
        file_put_contents($file, $con);
        return true;
    }

    if(is_file($file)){
        $con = file_get_contents($file);
        return $con;
    }else{
        return false;
    }
}

function get_content($url,$cookie='',$ssl=false){
    $cache_con = cache($url);
    if($cache_con){
        return $cache_con;
    }else{
        $con = curl::get($url,0,$cookie,0,0,$ssl);
        if($con){
            cache($url,$con,1);
            return $con;
        }else{
            return false;
        }
    }
}

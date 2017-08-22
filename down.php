<?php
chdir(dirname(__FILE__));
include 'config.php';
include 'common.php';
include 'curl.class.php';

$ssl = true;
$cookie = 'cookie 登录网站之后抓取保存到这里';
$url = 'https://www.sijiaomao.com/topic/1';

$list = get_content($url,$cookie,$ssl);
$pat = '@<td class="km-c">\s+<h4>\s+(.*?)\s+(?:<span class="label label-success">免费观看</span>\s+)?</h4>\s+<p class="ex-opt">\s+<a target="_blank" class="btn btn-info"\s+href="/exam/\d+">单元测试</a>\s+<a class="btn btn-danger" href="/section/(\d+)">开始学习</a>\s+</p>\s+</td>@si';
preg_match_all($pat, $list,$mat);
$dirs = $mat[1];
$sections = $mat[2];
unset($mat);

$pat_video = '@<p>(?:.*?)/section/(\d+)(?:.*?)>([^<]+)</a>\s+</p>@s';
foreach ($dirs as $k=>$dir){
    $dir = mb_convert_encoding($dir, 'gbk','utf-8');
    $dir = ATTACHMENT_PATH.$dir;
    if(!is_dir($dir)){
        mkdir($dir);
    }
    
    $section = 'https://www.sijiaomao.com/section/'.$sections[$k];
    $section_con = get_content($section,$cookie,$ssl);
    
    $find = preg_match_all($pat_video, $section_con,$mat);
	
    if($find){
        $sub_sections = $mat[1];
        $files = $mat[2];
        $i = 1;
        foreach ($sub_sections as $kk=>$sub_section){
            $video_url = 'https://www.sijiaomao.com/video/'.$sub_section;
            $file = mb_convert_encoding($files[$kk], 'gbk','utf-8');
            $file = $dir.'/'.$i.'.'.$file.'.mp4';
            $file = strtr($file, '*?','__');
            $i++;
            echo $video_url.PHP_EOL;
            echo $file.PHP_EOL;
            
            if(is_file($file)){
                echo 'this file exist pass'.PHP_EOL;
                continue;
            }
            
            //download video
            echo 'start download'.PHP_EOL;
            $cmd = "curl -o \"$file\" -H \"Cookie: $cookie\" $video_url";
            exec($cmd);
        }
    }
}

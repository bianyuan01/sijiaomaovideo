<?php
$ls = glob('*');

foreach ($ls as $v){
    echo '<a href="/'.$v.'">'.$v.'</a><br />';
}
<?php
$url;
if(isset($_GET['url'])) 
{
   
$url = $_GET['url'];

include 'dom.php';
$html = file_get_html($url);

$div=$html->find('div.mw-search-result-heading',0);
if($div){
$link = $div->find('a',0);
 echo $link->href;
}
 
}
 else {
    $url = 'no page on wiki';
}

?>
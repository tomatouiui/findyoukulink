<?php
$url = $_POST["url"];
//$url = "http://www-935.ibm.com/services/au/en/it-services/Joe_pizzinga_CFO2013/index.html";
//$url = "https://www.ibm.com/cloud-computing/cn/zh/newplatform/";
$headers = get_headers($url,1);

if(strpos($headers[0],"404")>0){
  print_r($headers[0] . " | n | n ");	
}else{
$metatag = get_meta_tags($url);

include_once('simple_html_dom.php');
//$html=file_get_html($url);
$html = str_get_html(file_get_contents($url));
$title = $html->find('title', 0)->innertext;
$link = '<table>';

foreach($html->find('[href*=youku.com]') as $element){
	if($element->href){
	   $youkulink = $element->href;
	   if(strrpos($youkulink, "//") == 0){
          $youkulink = 'http:' . $youkulink;
	   }else if(strrpos($youkulink, "https:") == 0){
          $youkulink = str_replace('https','http',$youkulink);
	   }

	   if(strrpos($youkulink, "player") > 0){
          $youkulink = str_replace('http://player.youku.com/embed/','http://v.youku.com/v_show/id_',$youkulink);
	   }
	   
	   $html = str_get_html(file_get_contents($youkulink));
	   if(isset($html->find('title', 0)->innertext)){
		   $youkutitle = $html->find('title', 0)->innertext;
	   }else{
	   	   $youkutitle = '404';
	   }
	   $link .=  '<tr><td>'. $element . '</td><td>' . $element->href . '</td><td>' . $youkutitle . '</td></tr>';
	}
}

$link .= '</table>';

print_r($headers[0] . " || " . $title  . " || " . $link);
}
?>
<?php
$title="黑客抓包抓包监听12141";

$str="****";
$titles = preg_replace("/(黑客)|(抓包)|(监听)/",$str,$title);
$contents = preg_replace("/(黑客)|(抓包)|(监听)/",$str,$content);
echo $titles;

$str1="****";
$str="/(黑客)|(抓包)|(监听)/";
$content="=黑抓抓包听12141";
function str($str,$str1,$content){
    return preg_replace($str,$str1,$content);
}
echo str($str,$str1,$content);
?>
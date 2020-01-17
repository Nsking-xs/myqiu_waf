<?php
/*
myqiu_waf.php 1.0
www.myqiu.org
////////////////////
ver1.1
updete 2020.1.17 
修复了日志
增加了写入日志的内容条目
by nsking
*/

$getfilter="select|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
function Codepage($strgets,$strgetsq,$strgetsql){
	if(preg_match("/".$strgetsql."/is",$strgetsq)==1){
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        $hackclientip=$_SERVER['REMOTE_ADDR'] ;
	echo '<br>You have triggered the WAF protection rules';
        echo '<br>你已经触发waf防护规则';
        echo '<br>你的IP是'.$hackclientip;
        echo '<br>提交地址危险地址'.$url;
        $POSTSTRING=http_build_query($_POST);
        $GETSTRING=http_build_query($_GET);
        $COOKIESTRING=http_build_query($_COOKIE);
        echo  $_SERVER['SCRIPT_NAME'];
        $sqlfile=$_SERVER['DOCUMENT_ROOT'].'/badlog.txt' ;
        $content='  ip:'.$hackclientip.'  url:'.$url.' post:'.$POSTSTRING.'  get:'.$GETSTRING.'  cookie:'.$COOKIESTRING."\r\n";
        if($sqlfile_url=file_put_contents($sqlfile,$content,FILE_APPEND)){
        echo '你的操作记录已经被记录!';
}
	exit();	
}
}
foreach($_GET as $key=>$value){
	Codepage($key,$value,$getfilter);
}
foreach($_POST as $key=>$value){
	Codepage($key,$value,$postfilter);
}
foreach($_COOKIE as $key=>$value){
	Codepage($key,$value,$cookiefilter);
}
?>

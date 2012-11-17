<?php

//$lpCfgMySQLDebug=true;

$rpDomain="rp.jybox.net";
$rpAdminEmail="m@jybox.net";

$rpAdminUsers=array("rpadmin");
$rpNotAllowReg=array("root","default");

$lpUrl="/LightPHP/";
$lpCfgCallback="cbLogin";

$lpCfgMySQL=array(
                   "host" => "localhost",
                   "dbname" => "rpadmin",
                   "user" => "rpadmin",
                   "pwd" => "passwd",
                   "charset" => "utf8"
                 );
                 
$rpROOT=dirname(__FILE__);

$rpNewVirtualHost=array(
                          "id" => "XXOO",
                          "domains" => substr(md5(time()),0,8) . ".{$rpDomain}",
                          "template" => "web",
                          "type" => "only",
                          "php" => "php",
                          "cgi" => "",
                          "static" => "css js jpg gif png ico zip rar exe",
                          "indexs" => "index.php index.html index.htm",
                          "autoindex" => 1,
                          "is404" => 1,
                          "root" => "/home/" . lpAuth::getUName() . "/web/",
                          "alias" => "{}",
                          "nginxaccess" => "/home/" . lpAuth::getUName() . "/nginx.access.log",
                          "nginxerror" => "/home/" . lpAuth::getUName() . "/nginx.error.log",
                          "apacheaccess" => "/home/" . lpAuth::getUName() . "/apache.access.log",
                          "apacheerror" => "/home/" . lpAuth::getUName() . "/apache.error.log",
                          "isssl" => 0,
                          "sslcrt" => "",
                          "sslkey" => ""
                       );
                 
?>

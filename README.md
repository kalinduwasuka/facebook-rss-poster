# Create facebook post from rss feed

## Introduction

> This script will create facebook post from rss feed


## Installation

>First you need facebook php sdk

> Here some key points of the code.You need to add your facebook app token to config.php

 include 'config.php'; <br>
define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__.'/src/Facebook/'); <br>
require_once(__DIR__.'/src/Facebook/autoload.php');<br>

>Now  add your MySQL db credentials

$servername = "localhost";<br>
$username = "<-- DB username -->""; <br>
$password = "<-- DB password -->";<br>
$dbname = "<-- DB name -->"; <br>


//Rss url

  $xml=("https:/exsample.com/feed");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

>Add cornjob to automate this script

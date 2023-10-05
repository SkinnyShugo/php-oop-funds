<?php
require 'config.php';
require 'User.php';
require 'FundManager.php';
require 'ChatGPT.php';

$userClass = new User($pdo);
$fmClass = new FundManager($pdo);
$chatGPT = new ChatGPT('YOUR_OPENAI_API_KEY');

//you can your html code here check index2.php

//A new laravel project will be building with the same concept

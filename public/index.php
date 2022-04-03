<?php
session_start();
require "../private/core/autoload.php";

session_destroy();

$app = new App();
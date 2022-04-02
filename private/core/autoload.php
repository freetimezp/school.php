<?php

require "config.php";
require "functions.php";
require "Database.php";
require "Controller.php";
require "Model.php";
require "App.php";

spl_autoload_register(function ($class_name) {
    require "../private/models/" . ucfirst($class_name) . ".php";
});
<?php

class Students extends Controller
{
    function index($id = '')
    {
        echo "students page" . $id;
    }
}
<?php

class Single_class extends Controller
{
    function index($id = '')
    {
        $classes = new Classes_model();
        $user = new User();

        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if($row) {
            $crumbs[] = [$row->class, ''];
        }

        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';

        $this->view('single-class', [
            'row' => $row,
            'page_tab' => $page_tab,
            'crumbs' => $crumbs
        ]);
    }
}
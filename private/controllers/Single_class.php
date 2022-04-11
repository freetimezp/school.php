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

        $results = false;

        if($page_tab == 'lecturer-add' && count($_POST) > 0) {
            $user = new User();
            $name = "%" . $_POST['name'] . "%";
            $query = "SELECT * FROM users WHERE (firstname LIKE :fname OR lastname LIKE :lname) AND rank = 'lecturer' LIMIT 10 ";
            $results = $user->query("$query", [
                'fname' => $name,
                'lname' => $name
            ]);
        }

        $this->view('single-class', [
            'row' => $row,
            'page_tab' => $page_tab,
            'crumbs' => $crumbs,
            'results' => $results
        ]);
    }
}
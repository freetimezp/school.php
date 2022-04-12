<?php

class Single_class extends Controller
{
    function index($id = '')
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if($row) {
            $crumbs[] = [$row->class, ''];
        }

        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';

        $results = false;

        if($page_tab == 'lecturer-add' && count($_POST) > 0) {
            if(isset($_POST['search'])) {
                //find lecturer
                $user = new User();
                $name = "%" . trim($_POST['name']) . "%";
                $query = "SELECT * FROM users WHERE (firstname LIKE :fname OR lastname LIKE :lname) AND rank = 'lecturer' LIMIT 10 ";
                $results = $user->query("$query", [
                    'fname' => $name,
                    'lname' => $name
                ]);
            }elseif(isset($_POST['selected'])) {
                //add lecturer
                $arr = array();
                $arr['class_id'] = $id;
                $arr['disabled'] = 0;
                $arr['date'] = date("Y-m-d H:i:s");

                $lect = new Lecturers_model();
                $lect->insert($arr);

                $this->redirect('single_class/' . $id . '?tab=lecturers');
            }
        }

        $this->view('single-class', [
            'row' => $row,
            'page_tab' => $page_tab,
            'crumbs' => $crumbs,
            'results' => $results
        ]);
    }
}
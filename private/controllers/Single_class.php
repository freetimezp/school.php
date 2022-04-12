<?php

class Single_class extends Controller
{
    function index($id = '')
    {
        $errors = array();

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

        $lect = new Lecturers_model();
        $results = false;

        if(($page_tab == 'lecturer-add' || $page_tab == 'lecturer-remove')  && count($_POST) > 0) {
            if(isset($_POST['search'])) {
                //find lecturer
                if(!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = "%" . trim($_POST['name']) . "%";
                    $query = "SELECT * FROM users WHERE (firstname LIKE :fname OR lastname LIKE :lname) AND rank = 'lecturer' LIMIT 10 ";
                    $results = $user->query("$query", [
                        'fname' => $name,
                        'lname' => $name
                    ]);
                }else {
                    $errors[] = "Please type a name to find!";

                }
            }elseif(isset($_POST['selected'])) {
                //add lecturer
                $query = "SELECT id FROM class_lecturers WHERE user_id = :user_id AND class_id = :class_id AND disabled = 0 LIMIT 1";

                if($page_tab == 'lecturer-add') {
                    if(!$lect->query($query, [
                        'user_id' => $_POST['selected'],
                        'class_id' => $id
                    ])) {
                        $arr = array();
                        $arr['user_id'] = $_POST['selected'];
                        $arr['class_id'] = $id;
                        $arr['disabled'] = 0;
                        $arr['date'] = date("Y-m-d H:i:s");

                        $lect->insert($arr);

                        $this->redirect('single_class/' . $id . '?tab=lecturers');
                    }else{
                        $errors[] = "This lecturer already belong to this class";
                    }
                }elseif($page_tab == 'lecturer-remove') {
                    if($row = $lect->query($query, [
                        'user_id' => $_POST['selected'],
                        'class_id' => $id
                    ])) {
                        $arr = array();
                        $arr['disabled'] = 1;

                        $lect->update($row[0]->id, $arr);

                        $this->redirect('single_class/' . $id . '?tab=lecturers');
                    }else{
                        $errors[] = "That lecturer was not found in this class!";
                    }
                }

            }
        }elseif ($page_tab == 'lecturers') {
            $query = "SELECT * FROM class_lecturers WHERE class_id = :class_id AND disabled = 0";
            $lecturers = $lect->query($query, ['class_id' => $id]);
            $data['lecturers'] = $lecturers;
        }

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;

        $this->view('single-class', $data);
    }
}
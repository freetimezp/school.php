<?php

class Profile extends Controller
{
    function index($id = '')
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $data = array();

        $user = new User();
        $id = trim($id == '') ? Auth::getUser_id() : $id;
        $row = $user->first('user_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Profile', 'profile'];
        if($row) {
            $crumbs[] = [$row->firstname, 'profile'];
        }

        //get more information depending on tab
        $data['page_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'info';

        if($data['page_tab'] == 'classes') {
            $class = new Classes_model();

            $stud = new Students_model();
            $query = "SELECT * FROM class_students WHERE user_id = :user_id AND disabled = 0";
            $data['stud_classes'] = $stud->query($query, ['user_id' => $id]);

            $data['student_classes'] = array();

            if($data['stud_classes']) {
                foreach ($data['stud_classes'] as $key => $arow) {
                    $data['student_classes'][] = $class->first('class_id', $arow->class_id);
                }
            }
        }

        $data['row'] = $row;
        $data['crumbs'] = $crumbs;

        $this->view('profile', $data);
    }
}
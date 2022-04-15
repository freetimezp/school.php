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

        if($data['page_tab'] == 'classes' && $row) {
            $class = new Classes_model();

            $myTable = "class_students";

            if($row->rank == 'lecturer') {
                $myTable = "class_lecturers";
            }

            $query = "SELECT * FROM $myTable WHERE user_id = :user_id AND disabled = 0";
            $data['stud_classes'] = $class->query($query, ['user_id' => $id]);

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
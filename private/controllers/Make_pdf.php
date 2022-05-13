<?php

class Make_pdf extends Controller
{
    function index($id = '', $user_id = '')
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $folder = 'pdf/';
        if(!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        require_once __DIR__ . '/../models/mpdf/autoload.php';

        $mpdf = new \Mpdf\Mpdf();
        $html = file_get_contents(ROOT . '/make_test_pdf/fNHMGnH48iWfrx21Yy5DyjENwiRIJsi7xg2dLIIJLfnTnQEqWXBvjARUQauO/zoya.lokera');

        $mpdf->WriteHTML($html);
        $mpdf->Output($folder . 'mypdf.pdf');
        //$this->view('home');



    }
}



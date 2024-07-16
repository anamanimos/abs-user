<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');  // Load library session
        $this->load->helper('url');       // Load helper URL
        $this->load->database();          // Load database
        $this->load->model('User_model'); // Load user model
        $this->load->model('Absen_model');

        // Redirect to login if session is not set
        if (!$this->session->userdata('nisn')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $nisn = $this->session->userdata('nisn');
        $data['profile'] = $this->User_model->get_user_profile($nisn);

        // Check if today's absence has been done
        $student_id = $data['profile']->id;
        $class_id = $data['profile']->class_id;
        $today_absence = $this->Absen_model->check_today_absence($student_id, $class_id);

        if ($today_absence) {
            // If today's absence has been done, send flag to view
            $data['today_absence_done'] = true;
        } else {
            // If today's absence has not been done, send flag to view
            $data['today_absence_done'] = false;
        }
        $data['css'] = ['https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',];
        $data['js'] = [
            base_url('assets/js/absen.js?ver=' . time()),
            'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('absen', $data);
        $this->load->view('templates/footer', $data);
        // $this->load->view('old_absen', $data);
    }

    public function ajax()
    {
        $nisn = $this->session->userdata('nisn');
        $data['profile'] = $this->User_model->get_user_profile($nisn);


        // Retrieve data from POST
        $student_id = $data['profile']->id;
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $photo = $this->input->post('photo'); // Base64 image

        // Decode base64 image
        $photo_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
        $photo_name = 'photo_' . time() . '.jpg';
        $photo_path = './public/photos/' . $photo_name;

        // Save photo file
        file_put_contents($photo_path, $photo_data);

        // Call model function to save absence data
        $result = $this->Absen_model->save_absence($student_id, $latitude, $longitude, $photo_name);

        // Send response
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Absen berhasil disimpan');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menyimpan absen');
        }

        echo json_encode($response);
    }
}

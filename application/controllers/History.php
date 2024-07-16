<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
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
        $data['title'] = 'Riwayat Absensi';
        $data['profile'] = $this->User_model->get_user_profile($nisn);
        $student_id = $data['profile']->id;

        // Get month and year from GET parameters or use current month and year
        $month = $this->input->get('month') ? $this->input->get('month') : date('m');
        $year = $this->input->get('year') ? $this->input->get('year') : date('Y');

        // Fetch absence history
        $data['absence_history'] = $this->Absen_model->get_absence_history($student_id, $month, $year);

        $data['selected_month'] = $month;
        $data['selected_year'] = $year;
        $data['css'] = ['https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'];
        $data['js'] = [
            'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js',
            base_url('assets/js/pages/history.js?time='.time())
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('history', $data);
        $this->load->view('templates/footer', $data);
    }
}

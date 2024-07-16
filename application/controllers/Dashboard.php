<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');  // Load library session
        $this->load->helper('url');       // Load helper URL
        $this->load->database();          // Load database
        $this->load->model('User_model'); // Load user model
        $this->load->model('Absen_model');

        if (!$this->session->userdata('nisn')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $nisn = $this->session->userdata('nisn');
        $data['title'] = 'Dashboard';
        $data['profile'] = $this->User_model->get_user_profile($nisn);
        $data['last_absences'] = $this->Absen_model->get_last_absences($data['profile']->id);
        $data['css'] = [''];
        $data['js'] = [base_url('assets/js/pages/dashboard.js')];

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer', $data);
    }
}

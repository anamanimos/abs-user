<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
        $this->load->model('Auth_model');
    }

    public function index()
    {
        // Cek apakah user sudah login
        if ($this->session->userdata('nisn')) {
            redirect('dashboard');
        }

        $this->load->view('login');
    }

    public function login()
    {
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('pin', 'PIN', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $nisn = $this->input->post('nisn');
            $pin = $this->input->post('pin');
            $remember = $this->input->post('remember');

            $user = $this->Auth_model->login($nisn, $pin);

            if ($user) {
                $this->session->set_userdata('nisn', $user->nisn);

                if ($remember) {
                    $this->input->set_cookie('nisn', $nisn, 86500); // 1 day
                    $this->input->set_cookie('pin', $pin, 86500); // 1 day
                }

                // Send JSON response
                $response = array('status' => 'success', 'message' => 'Login berhasil');
                echo json_encode($response);
                return;
            } else {
                // Send JSON response
                $response = array('status' => 'error', 'message' => 'NISN atau PIN salah');
                echo json_encode($response);
                return;
            }
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('nisn');
        delete_cookie('nisn');
        delete_cookie('pin');
        redirect('auth');
    }

    public function register()
    {
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('pin', 'PIN', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('register');
        } else {
            $nisn = $this->input->post('nisn');
            $pin = password_hash($this->input->post('pin'), PASSWORD_BCRYPT);

            $data = array(
                'nisn' => $nisn,
                'secret_number' => $pin
            );

            $this->db->insert('students', $data);
            $this->session->set_flashdata('success', 'Registrasi berhasil, silakan login.');
            redirect('auth');
        }
    }
}

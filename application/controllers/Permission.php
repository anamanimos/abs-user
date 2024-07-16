<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permission extends CI_Controller
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
        $data['title'] = '';
        $data['profile'] = $this->User_model->get_user_profile($nisn);
        // Check if today's absence has been done
        $student_id = $data['profile']->id;
        $class_id = $data['profile']->class_id;
        $data['css'] = [''];
        $data['js'] = [''];

        $this->load->view('templates/header', $data);
        $this->load->view('permission_location', $data);
        $this->load->view('templates/footer-permission', $data);
    }

    public function camera()
    {
        $nisn = $this->session->userdata('nisn');
        $data['title'] = '';
        $data['profile'] = $this->User_model->get_user_profile($nisn);
        // Check if today's absence has been done
        $student_id = $data['profile']->id;
        $class_id = $data['profile']->class_id;
        $data['css'] = [''];
        $data['js'] = [''];

        $this->load->view('templates/header', $data);
        $this->load->view('permission_camera', $data);
        $this->load->view('templates/footer-permission', $data);
    }
    public function outofarea()
    {
        $nisn = $this->session->userdata('nisn');
        $data['title'] = '';
        $data['profile'] = $this->User_model->get_user_profile($nisn);
        // Check if today's absence has been done
        $student_id = $data['profile']->id;
        $class_id = $data['profile']->class_id;
        $data['css'] = [''];
        $data['js'] = [''];

        $this->load->view('templates/header', $data);
        $this->load->view('permission_outofarea', $data);
        $this->load->view('templates/footer-permission', $data);
    }
    
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');  // Load library session
        $this->load->helper('url');       // Load helper URL
        $this->load->database();          // Load database
        $this->load->model('User_model'); // Load user model

        // Redirect to login if session is not set
        if (!$this->session->userdata('nisn')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $nisn = $this->session->userdata('nisn');
        $data['title'] = 'Profil Saya';
        $data['profile'] = $this->User_model->get_user_profile($nisn);

        $data['css'] = ['https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'];
        $data['js'] = [
            base_url('assets/js/profile.js?ver=' . time()),
            'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js'
        ];

        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('profile', $data);
        $this->load->view('templates/footer');
    }

    public function update_pin()
    {
        $this->form_validation->set_rules('new_pin', 'New PIN', 'required|exact_length[6]|numeric');

        if ($this->form_validation->run() == false) {
            $response = array('status' => 'error', 'message' => validation_errors());
        } else {
            $nisn = $this->session->userdata('nisn');
            $new_pin = $this->input->post('new_pin');

            // Update PIN in database (you may need to adjust this based on your actual database structure)
            $update_data = array(
                'secret_number' => password_hash($new_pin, PASSWORD_DEFAULT) // Hash the PIN using default CI3 hashing
                // Adjust 'secret_number' to match your database field for storing hashed PIN
            );

            // Assuming 'students' is your table name and 'id' is the primary key field
            $this->db->where('nisn', $nisn);
            $this->db->update('students', $update_data);

            if ($this->db->affected_rows() > 0) {
                $response = array('status' => 'success', 'message' => 'PIN berhasil diperbarui');
            } else {
                $response = array('status' => 'error', 'message' => 'Gagal memperbarui PIN. Silakan coba lagi.');
            }
        }

        // Return response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

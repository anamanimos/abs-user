<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('template');
	}
    public function uploadfileabsen() {
        // Check for a valid password
        $valid_password = 'XaxiXu'; // Change this to your desired password
        $input_password = $this->input->post('password');
    
        if ($input_password !== $valid_password) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
            return;
        }
    
        // Validate file
        if (empty($_FILES['file']['name'])) {
            echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
            return;
        }
    
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
        // Validate file type
        $allowed_types = ['png', 'jpg', 'jpeg', 'pdf'];
        if (!in_array($file_ext, $allowed_types)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
            return;
        }
    
        // Validate file size (1MB = 1048576 bytes)
        if ($file_size > 1048576) {
            echo json_encode(['status' => 'error', 'message' => 'File size exceeds 1MB']);
            return;
        }
    
        // Generate new file name
        $new_file_name = 'absence_' . time() . '.' . $file_ext;
    
        // Set upload path
        $upload_path = './public/photos/';
    
        // Move file to the upload directory
        if (move_uploaded_file($file_tmp, $upload_path . $new_file_name)) {
            echo json_encode(['status' => 'success', 'file_name' => $new_file_name]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
        }
    }
    
}

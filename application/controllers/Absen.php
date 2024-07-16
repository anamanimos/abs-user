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
        $data['title'] = 'Absen';
        $data['profile'] = $this->User_model->get_user_profile($nisn);

        // Check if today's absence has been done
        $student_id = $data['profile']->id;
        $class_id = $data['profile']->class_id;


        $data['css'] = [
            'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',
            'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css'
        ];
        $data['js'] = [
            base_url('assets/js/pages/absen.js?ver=' . time()),
            'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js',
            'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('absen', $data);
        $this->load->view('templates/footer', $data);
        // $this->load->view('old_absen', $data);
    }

    public function action($action = ''){
        $data['title'] = '';
        echo '<input type="hidden" name="absence-camera" val="'.get_setting('absence_camera').'"/>';
        if($action == 'aXppbmF0YXV0aWthcw'){    //izin/sakit
            $session_id=2;
            $session = $this->db->query("SELECT * FROM student_absence_session WHERE id=$session_id")->row_array();
            $nisn = $this->session->userdata('nisn');
            $data['profile'] = $this->User_model->get_user_profile($nisn);
    
            // Check if today's absence has been done
            $student_id = $data['profile']->id;
            $class_id = $data['profile']->class_id;
            

            // Check if the current time is between session start and end
            $current_time = time(); // Get current time as a timestamp
            $today_date = date('Y-m-d'); // Get today's date in the format YYYY-MM-DD

            $session_start = strtotime($today_date . ' ' . $session['start']); // Convert session start to timestamp
            $session_end = strtotime($today_date . ' ' . $session['end']); // Convert session end to timestamp

            $time_to_absence = ($current_time >= $session_start && $current_time <= $session_end);

            $data['session'] = $session;
            $data['today_absence_done'] = $this->Absen_model->check_today_absence_un($student_id, $class_id);
            $data['time_to_absence'] = $time_to_absence;
            $data['css'] = ['https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',];
            $data['js'] = [
                base_url('assets/js/pages/absen-izin-sakit.js?ver=' . time()),
                'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js'
            ];
    
            $this->load->view('templates/header', $data);
            $this->load->view('absen-izin-sakit', $data);
            $this->load->view('templates/footer', $data);
        }elseif ($action == 'b2tldA') { //masuk
            $session_id=1;
            $session = $this->db->query("SELECT * FROM student_absence_session WHERE id=$session_id")->row_array();
            $nisn = $this->session->userdata('nisn');
            $data['profile'] = $this->User_model->get_user_profile($nisn);
    
            // Check if today's absence has been done
            $student_id = $data['profile']->id;
            $class_id = $data['profile']->class_id;
            $today_absence = $this->Absen_model->check_today_absence($student_id, $class_id,$session_id);
            echo $today_absence;
    
            if ($today_absence) {
                // If today's absence has been done, send flag to view
                $data['today_absence_done'] = true;
            } else {
                // If today's absence has not been done, send flag to view
                $data['today_absence_done'] = false;
            }

            // Check if the current time is between session start and end
            $current_time = time(); // Get current time as a timestamp
            $today_date = date('Y-m-d'); // Get today's date in the format YYYY-MM-DD

            $session_start = strtotime($today_date . ' ' . $session['start']); // Convert session start to timestamp
            $session_end = strtotime($today_date . ' ' . $session['end']); // Convert session end to timestamp

            $time_to_absence = ($current_time >= $session_start && $current_time <= $session_end);



            $data['session'] = $session;
            $data['time_to_absence'] = $time_to_absence;
            $data['css'] = ['https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',];
            $data['js'] = [
                base_url('assets/js/pages/absen-action.js?ver=' . time()),
                'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js'
            ];
    
            $this->load->view('templates/header', $data);
            $this->load->view('absen-masuk', $data);
            $this->load->view('templates/footer', $data);
        }elseif ($action == 'bmdhbHVw') { //pulang
            $session_id=2;
            $session = $this->db->query("SELECT * FROM student_absence_session WHERE id=$session_id")->row_array();
            $nisn = $this->session->userdata('nisn');
            $data['profile'] = $this->User_model->get_user_profile($nisn);
    
            // Check if today's absence has been done
            $student_id = $data['profile']->id;
            $class_id = $data['profile']->class_id;
            $today_absence = $this->Absen_model->check_today_absence($student_id, $class_id,$session_id);
            echo $today_absence;
    
            if ($today_absence) {
                // If today's absence has been done, send flag to view
                $data['today_absence_done'] = true;
            } else {
                // If today's absence has not been done, send flag to view
                $data['today_absence_done'] = false;
            }

            // Check if the current time is between session start and end
            $current_time = time(); // Get current time as a timestamp
            $today_date = date('Y-m-d'); // Get today's date in the format YYYY-MM-DD

            $session_start = strtotime($today_date . ' ' . $session['start']); // Convert session start to timestamp
            $session_end = strtotime($today_date . ' ' . $session['end']); // Convert session end to timestamp

            $time_to_absence = ($current_time >= $session_start && $current_time <= $session_end);

            echo $time_to_absence ? 'true' : 'false';

            $data['session'] = $session;
            $data['time_to_absence'] = $time_to_absence;
            $data['css'] = ['https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',];
            $data['js'] = [
                base_url('assets/js/pages/absen-action.js?ver=' . time()),
                'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js'
            ];
    
            $this->load->view('templates/header', $data);
            $this->load->view('absen-pulang', $data);
            $this->load->view('templates/footer', $data);
        }else{
            redirect(base_url());
        }
        
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
        $session_id = $this->input->post('session_id');
        if($session_id == 'b2tldA'){//masuk
            $session_id = 1;
        }elseif ($session_id == 'bmdhbHVw') {//pulang
            $session_id = 2;
        }else{//izin/sakit
            $session_id = 0;
        }
    
        // Decode base64 image
        $photo_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
        $photo_name = 'photo_' . time() . '.jpg';
        $photo_path = './public/photos/' . $photo_name;
    
        // Validate session time
        $this->db->where('id', $session_id);
        $session = $this->db->get('student_absence_session')->row();
    
        if ($session) {
            $current_time = date('H:i:s');
            if ($current_time >= $session->start && $current_time <= $session->end) {
                // Save photo file
                file_put_contents($photo_path, $photo_data);
    
                // Call model function to save absence data
                $result = $this->Absen_model->save_absence($student_id, $latitude, $longitude, $photo_name, $session_id);
    
                // Send response
                if ($result) {
                    $response = array('status' => 'success', 'message' => 'Absen berhasil disimpan');
                } else {
                    $response = array('status' => 'error', 'message' => 'Gagal menyimpan absen');
                }
            } else {
                $response = array('status' => 'error', 'message' => 'Absen hanya bisa dilakukan pada waktu yang ditentukan.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Sesi absensi tidak ditemukan.');
        }
    
        echo json_encode($response);
    }

    public function ajaxizinsakit() {

        $nisn = $this->session->userdata('nisn');
        $data['profile'] = $this->User_model->get_user_profile($nisn);
    
        $student_id    = $data['profile']->id;
        $class_id      = $data['profile']->class_id;
        $status = $this->input->post('status'); // 'sakit' atau 'izin'
        $reason = $this->input->post('reason');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $current_time = date('H:i:s');
        $absence_date = date('Y-m-d');

        // Handle file upload
        $config['upload_path'] = './public/photos/';  // Path to save the files
        $config['allowed_types'] = 'gif|jpg|png|pdf'; // Allowed file types
        $config['max_size'] = 1024; // Maximum file size in KB (1MB)
        $config['file_ext_tolower'] = TRUE; // Convert file extension to lower case
        $config['encrypt_name'] = TRUE; // Encrypt file name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode(['status' => 'error', 'message' => $error]);
            return;
        } else {
            $upload_data = $this->upload->data();
            $photo = $upload_data['file_name'];
        }

        // Get session times
        $sessions = $this->Absen_model->get_session_times();

        $session_start = strtotime($absence_date . ' ' . $sessions[1]['start']);
        $session_end = strtotime($absence_date . ' ' . $sessions[2]['end']);
        $current_time_stamp = strtotime($absence_date . ' ' . $current_time);

        // Check if there are already two absences
        if ($this->Absen_model->check_today_absence_un($student_id, $class_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Absence already recorded for both sessions today.']);
            return;
        }

        // Check if morning absence already exists
        $already_absent_in = $this->Absen_model->check_morning_absence($student_id, $absence_date);

        // Insert absence records based on conditions
        if ($current_time_stamp <= $session_start) {
            // Before or at start time
            $this->Absen_model->insert_absence(1, $status, $latitude, $longitude, $reason, $photo);
            $this->Absen_model->insert_absence(2, $status, $latitude, $longitude, $reason, $photo);
        } elseif ($current_time_stamp > $session_start && $current_time_stamp <= $session_end) {
            if (!$already_absent_in) {
                // After start time but before end time and no morning absence
                $this->Absen_model->insert_absence(1, $status, $latitude, $longitude, $reason, $photo);
                $this->Absen_model->insert_absence(2, $status, $latitude, $longitude, $reason, $photo);
            } else {
                // Insert afternoon absence only
                $this->Absen_model->insert_absence(2, $status, $latitude, $longitude, $reason, $photo);
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Absence recorded successfully.']);
    }

    public function check_area() {
        
        // Ambil koordinat pusat dan radius absen dari tabel setting
        $absence_coordinate = get_setting('absence_coordinate');
        $absence_radius = get_setting('absence_radius');

        if (!$absence_coordinate || !$absence_radius) {
            echo json_encode(['status' => 'error', 'message' => 'Setting not found']);
            return;
        }

        list($center_lat, $center_lon) = explode(',', $absence_coordinate);
        $radius = (float) $absence_radius;

        // Ambil koordinat pengguna dari request POST
        $user_lat = $this->input->post('latitude');
        $user_lon = $this->input->post('longitude');

        // Hitung jarak antara koordinat pengguna dan pusat absen
        $distance = $this->haversine_distance($center_lat, $center_lon, $user_lat, $user_lon);

        // Cek apakah pengguna berada dalam radius absen
        if ($distance <= $radius) {
            echo json_encode(['status' => 'success', 'message' => 'User is within the absence area']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User is outside the absence area']);
        }
    }

    private function haversine_distance($lat1, $lon1, $lat2, $lon2) {
        $earth_radius = 6371000; // dalam meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earth_radius * $c;
    }
    
}

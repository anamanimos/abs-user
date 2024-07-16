<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); // Load user model
    }

    /**
     * Check if today's absence already exists for the given student_id and class_id.
     *
     * @param string $student_id Student ID to check
     * @param string $class_id Class ID to check
     * @return bool True if absence exists, false otherwise
     */
    public function check_today_absence($student_id, $class_id, $session_id)
    {
        // Get today's date
        $today = date('Y-m-d');

        // Query to check if absence exists for today
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('absence_date', $today);
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('student_absence');

        // Check if there is any result
        if ($query->num_rows() > 0) {
            return true; // Absence exists for today
        } else {
            return false; // Absence does not exist for today
        }
    }

    /**
     * Save absence record to database.
     *
     * @param string $student_id Student ID
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param string $photo_name Name of the photo file
     * @return bool True if successfully saved, false otherwise
     */
    public function save_absence($student_id, $latitude, $longitude, $photo_name, $session_id)
    {
        $nisn = $this->session->userdata('nisn');
        $data['profile'] = $this->User_model->get_user_profile($nisn);
        // Prepare data
        $data = array(
            'student_id'    => $student_id,
            'class_id'      => $data['profile']->class_id,
            'absence_date'  => date('Y-m-d'),
            'session_id'    => $session_id,
            'status'        => 1,
            'type'          => 1,
            'coordinate'    => $latitude . ',' . $longitude,
            'photo'         => $photo_name,
            'reason'        => '',
            'date_created'  => time(),
            'last_update'  => time(),

        );

        // Insert data into database
        $this->db->insert('student_absence', $data);

        // Check if insert was successful
        return $this->db->affected_rows() > 0;
    }

    public function get_last_absences($student_id) {
        // Main query to get the required data
        $this->db->select('
            a.absence_date,
            FROM_UNIXTIME(a.date_created, "%H.%i") as absence_time,
            ss.label as session,
            sa.name as status,
            st.label as type,
            a.status as status_code
        ');
        $this->db->from('student_absence a');
        $this->db->join('student_absence_session ss', 'a.session_id = ss.id', 'left');
        $this->db->join('student_absence_status sa', 'a.status = sa.id', 'left');
        $this->db->join('student_absence_type st', 'a.type = st.id', 'left');
        $this->db->where('a.student_id', $student_id);
        $this->db->order_by('a.absence_date', 'DESC');
        $this->db->limit(6);
        $query = $this->db->get();

        $results = $query->result_array();
        $processed_results = [];
        $seen_entries = [];

        foreach ($results as $result) {
            $key = $result['absence_date'] . '-' . $result['status_code'] . '-' . $result['absence_time'];
            if (!isset($seen_entries[$key])) {
                if($result['status'] != 'Hadir'){
                    $result['session'] = '';
                }
                $seen_entries[$key] = true;
                $processed_results[] = $result;
            }
        }

        return $processed_results;
    }

    public function get_absence_history($student_id, $month, $year) {
        // Main query to get the required data
        $this->db->select('
            a.absence_date,
            FROM_UNIXTIME(a.date_created, "%H.%i") as absence_time,
            ss.label as session,
            sa.name as status,
            st.label as type,
            a.status as status_code
        ');
        $this->db->from('student_absence a');
        $this->db->join('student_absence_session ss', 'a.session_id = ss.id', 'left');
        $this->db->join('student_absence_status sa', 'a.status = sa.id', 'left');
        $this->db->join('student_absence_type st', 'a.type = st.id', 'left');
        $this->db->where('a.student_id', $student_id);
        $this->db->where('MONTH(a.absence_date)', $month);
        $this->db->where('YEAR(a.absence_date)', $year);
        $this->db->order_by('a.absence_date', 'DESC');
        $query = $this->db->get();

        $results = $query->result_array();
        $processed_results = [];
        $seen_entries = [];

        foreach ($results as $result) {
            $key = $result['absence_date'] . '-' . $result['status_code'] . '-' . $result['absence_time'];
            if (!isset($seen_entries[$key])) {
                if($result['status'] != 'Hadir'){
                    $result['session'] = '';
                }
                $seen_entries[$key] = true;
                $processed_results[] = $result;
            }
        }

        return $processed_results;
    }

    public function get_session_times() {
        $this->db->select('id, start, end');
        $query = $this->db->get('student_absence_session');
        $result = $query->result_array();

        $sessions = [];
        foreach ($result as $row) {
            $sessions[$row['id']] = $row;
        }

        return $sessions;
    }

    public function check_morning_absence($student_id, $absence_date) {
        $this->db->where('student_id', $student_id);
        $this->db->where('absence_date', $absence_date);
        $this->db->where('session_id', 1);
        $query = $this->db->get('student_absence');

        return $query->num_rows() > 0;
    }

    public function check_today_absence_un($student_id, $class_id) {
        $absence_date = date('Y-m-d');
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('absence_date', $absence_date);
        $query = $this->db->get('student_absence');

        if ($query->num_rows() == 0) {
            return false; // Tidak ada data absensi hari ini
        }

        $absences = $query->result_array();

        $session_ids = array_column($absences, 'session_id');

        if (count($session_ids) >= 2) {
            return true; // Ada 2 data absensi
        }

        return false; // Kondisi default jika tidak memenuhi kriteria di atas
    }

    public function insert_absence($session_id, $status, $latitude, $longitude, $reason, $photo) {

        $nisn = $this->session->userdata('nisn');
        $profile = $this->User_model->get_user_profile($nisn);

        $data = [
            'student_id' => $profile->id,
            'class_id' => $profile->class_id,
            'absence_date'  => date('Y-m-d'),
            'session_id' => $session_id,
            'status' => $status,
            'type' => 1,
            'coordinate'    => $latitude . ',' . $longitude,
            'reason' => $reason,
            'photo' => $photo,
            'date_created' => time(),
            'last_update' => time()
        ];

        $this->db->insert('student_absence', $data);
    }
}

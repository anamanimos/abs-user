<?php
// File: application/helpers/indonesian_date_helper.php

if (!function_exists('tanggal_indonesia')) {
    function tanggal_indonesia($tanggal)
    {
        $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        $bulan = array(
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        );

        $tanggal_split = explode('-', $tanggal);
        $hari_tanggal = date('w', strtotime($tanggal));

        $hasil = $hari[$hari_tanggal] . ', ' . ltrim($tanggal_split[2], '0') . ' ' . $bulan[$tanggal_split[1]] . ' ' . $tanggal_split[0];
        return $hasil;
    }
    function bulan_indonesia($bulan)
    {
        $bulan_indonesia = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return isset($bulan_indonesia[$bulan]) ? $bulan_indonesia[$bulan] : '';
    }

    function jamAbsen($timeString) {
        $time = DateTime::createFromFormat('H:i:s', $timeString);
        if ($time) {
            return $time->format('H.i');
        }
        return false; // Atau kembalikan nilai default jika input tidak valid
    }

    function get_setting($name) {
        $ci =& get_instance();
        $ci->db->where('name', $name);
        $query = $ci->db->get('settings');
        $return = $query->row_array();
        return $return['value'];
    }
        
}

<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {

        public function readUsers() {
            return $this->db->table('rrm_users')->get_all();
        }
    
        public function createUsers($rrm_last_name, $rrm_first_name, $rrm_email, $rrm_gender, $rrm_address) {
            $data = array(
                'rrm_last_name' => $rrm_last_name,
                'rrm_first_name' => $rrm_first_name,
                'rrm_email' => $rrm_email,
                'rrm_gender' => $rrm_gender,
                'rrm_address' => $rrm_address
            );
            return $this->db->table('rrm_users')->insert($data);
        }
    
        public function updateUsers($id, $rrm_last_name, $rrm_first_name, $rrm_email, $rrm_gender, $rrm_address) {
            $data = array(
                'rrm_last_name' => $rrm_last_name,
                'rrm_first_name' => $rrm_first_name,
                'rrm_email' => $rrm_email,
                'rrm_gender' => $rrm_gender,
                'rrm_address' => $rrm_address
            );
            return $this->db->table('rrm_users')->where('id', $id)->update($data);
        }
    
        public function deleteUsers($id) {
            return $this->db->table('rrm_users')->where('id', $id)->delete();
        }
    
        public function getUserById($id) {
            return $this->db->table('rrm_users')->where('id', $id)->get();
        }       
    }

?>

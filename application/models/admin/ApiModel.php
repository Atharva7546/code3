<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiModel extends CI_Model {
  

    public function login($email,$password) {
        // $this->db->where('id', $id);
        // $this->db->where('password', $data);
        // $this->db->insert('student',$data);
        // return $this->db->insert_id();
        
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('login');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function getstudentsByClassName($className) {
        $this->db->where('className', $className);
        $query = $this->db->get('student'); // Replace 'your_table_name' with the actual name of your table
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

        public function getStudents() {
            return $this->db->get('student')->result();

        }

        public function createStudent($data) {
            
            $this->db->insert('student',$data);
            return $this->db->insert_id();
        }
        
        public function updateStudent($data, $id) {
            $this->db->where('id',$id);
            return $this->db->update('student', $data);
            // return $this->db->update_id();
        }
        
        public function deleteStudent($id) {
            $this->db->where('id', $id);
            return $this->db->delete('student');
        }
        
        function getTimetable(){
            // $this->db->where('id',$id);
             return $this->db->get('class_timetable')->result();
         }    
        function createTimetable($formArray){
            $this->db->insert('class_timetable',$formArray);//INSERT INTO users(name,email) VALUES(?,?);
            return $this->db->insert_id();
        }
        
        public function updateTimetable($formArray, $id) {
            $this->db->where('id',$id);
            return $this->db->update('class_timetable', $formArray);
            // return $this->db->update_id();
        }
        
        function deleteTimetable($id){
            $this->db->where('id',$id);
            $this->db->delete('class_timetable');  
        } 
        
        public function getTasks() {
            return $this->db->get('task')->result();
        }

        function createTask($formArray){
            $this->db->insert('task',$formArray);//INSERT INTO users(name,email) VALUES(?,?);
            return $this->db->insert_id();
        }

        public function updateTask($data, $id) {
            $this->db->where('id',$id);
            return $this->db->update('task', $data);
            // return $this->db->update_id();
        }

        function deleteTask($id){
            $this->db->where('id',$id);
            $this->db->delete('task');  
        } 
      
        public function getAttendance() {
            return $this->db->get('class_attendance')->result();
        }

        function createAttendance($formArray){
            $this->db->insert('class_attendance',$formArray);//INSERT INTO users(name,email) VALUES(?,?);
            return $this->db->insert_id();
        }

        public function updateAttendance($data, $id) {
            $this->db->where('id',$id);
            return $this->db->update('class_attendance', $data);
            // return $this->db->update_id();
        }

        function deleteAttendance($id){
            $this->db->where('id',$id);
            $this->db->delete('class_attendance');  
        } 
}

?>
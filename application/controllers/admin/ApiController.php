<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiController extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/ApiModel');
        $this->load->library('form_validation');
        header('Access-Control-Allow-Origin: *');

        $this->output->set_content_type('application/json');
    }

    public function index()
    {
        // echo "HELLO";
        //     $this->load->model('ApiModel');
        //    $timetable=  $this->ApiModel->all();
        //    $data=array();
        //    $data['class_timetable']=$timetable;
        //     //$this->load->view('view',$data);
        //     $this->output->set_output(json_encode($timetable));
    }

    public function login()
    {
        header('Content-Type: application/json');
        // $this->formvalidation;
        $rollNo = $this->input->post('rollNo');
        $mobile = $this->input->post('mobile');
        // Validate the input
        if (empty($rollNo) || empty($mobile)) {
            $this->output->set_status_header(400);
            $response['status'] = 'error';
            $response['message'] = 'Roll number and mobile number are required.';
            $this->output->set_output(json_encode($response));
            return;
        }
        // Check if the credentials are valid
        $student = $this->ApiModel->login($rollNo, $mobile);

        if ($student) {
            $response['status'] = 'success';
            $response['message'] = 'Login successful.';
            $this->output->set_output(json_encode($response));
        } else {
            $this->output->set_status_header(401);
            $response['status'] = 'error';
            $response['message'] = 'Invalid roll number or mobile number.';
            $this->output->set_output(json_encode($response));
        }
    }

    public function getstudentsByClassName($className)
    {
        $results = $this->ApiModel->getstudentsByClassName($className); // Replace 'Your_model' with the actual name of your model

        if (!empty($results)) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($results));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(404)
                ->set_output(json_encode(['error' => 'No results found.']));
        }
    }


    // Fetch all students
    public function getStudents()
    {
        $students = $this->ApiModel->getStudents();
        $this->output->set_output(json_encode($students));
    }


    //}

    // Create a new student
    public function createStudent()
    {

        header('Content-Type: application/json');
        $data = array(
            'name' => $this->input->post('name'),
            'rollNo' => $this->input->post('rollNo'),
            'mobile' => $this->input->post('mobile'),
            'dob' => $this->input->post('dob'),
            'gender' => $this->input->post('gender'),
            'className' => $this->input->post('className'),
            'address' => $this->input->post('address'),
            'photo' => $this->input->post('photo'),
            // Set values for other fields
        );

        $student_id = $this->ApiModel->createStudent($data);
        if ($student_id) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Student created successfully',
                'student_id' => $student_id
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to create student'
            ]));
        }
        //  }
    }

    // Update a student
    public function updateStudent()
    {
        header('Content-Type: application/json');
        $data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'rollNo' => $this->input->post('rollNo'),
            'mobile' => $this->input->post('mobile'),
            'dob' => $this->input->post('dob'),
            'gender' => $this->input->post('gender'),
            'className' => $this->input->post('className'),
            'address' => $this->input->post('address'),
            'photo' => $this->input->post('photo')
            // Set values for other fields
        );
        $result = $this->ApiModel->updateStudent($data, $this->input->post('id'));
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Student updated successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to update student'
            ]));
        }
        // }
    }

    // Delete a student
    public function deleteStudent($id)
    {
        $result = $this->ApiModel->deleteStudent($id);
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Student deleted successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to delete student'
            ]));
        }
    }


    public function getTimetable()
    {
        $timetable = $this->ApiModel->getTimetable();
        $this->output->set_output(json_encode($timetable));
    }


    public function createTimetable()
    {

        header('Content-Type: application/json');
        $formArray = array();
        $formArray['day'] = $this->input->post('day');
        $formArray['className'] = $this->input->post('className');
        $formArray['subject'] = $this->input->post('subject');
        $formArray['timeFrom'] = $this->input->post('timeFrom');
        $formArray['timeTo'] = $this->input->post('timeTo');
        $formArray['lec_no'] = $this->input->post('lec_no');

        $timetable_id = $this->ApiModel->createTimetable($formArray);
        if ($timetable_id) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Timetable created successfully',
                'timetable_id' => $timetable_id
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to create timetable'
            ]));
        }
    }

    public function updateTimetable()
    {
        header('Content-Type: application/json');

        $formArray = array();
        $formArray['day'] = $this->input->post('day');
        $formArray['className'] = $this->input->post('className');
        $formArray['subject'] = $this->input->post('subject');
        $formArray['timeFrom'] = $this->input->post('timeFrom');
        $formArray['timeTo'] = $this->input->post('timeTo');
        $formArray['lec_no'] = $this->input->post('lec_no');
        $result = $this->ApiModel->updateTimetable($formArray, $this->input->post('id'));
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Timetable updated successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to update timetable'
            ]));
        }
        // }
    }
    function deleteTimetable($id)
    {
        $result = $this->ApiModel->deleteTimetable($id);
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Timetable entry deleted successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to delete timetable entry'
            ]));
        }

    }

    public function getTasks()
    {
        $tasks = $this->ApiModel->getTasks();
        $this->output->set_output(json_encode($tasks));
    }

    public function createTask()
    {

        header('Content-Type: application/json');
        $formArray = array();
        $formArray['className'] = $this->input->post('className');
        $formArray['taskDate'] = $this->input->post('taskDate');
        $formArray['taskTime'] = $this->input->post('taskTime');
        $formArray['taskTitle'] = $this->input->post('taskTitle');
        $formArray['description'] = $this->input->post('description');

        $task_id = $this->ApiModel->createTask($formArray);
        if ($task_id) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Task created successfully',
                'task_id' => $task_id
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to create task'
            ]));
        }
    }

    public function updateTask()
    {
        header('Content-Type: application/json');
        $data = array(
            'id' => $this->input->post('id'),
            'className' => $this->input->post('className'),
            'taskDate' => $this->input->post('taskDate'),
            'taskTime' => $this->input->post('taskTime'),
            'description' => $this->input->post('description')

        );
        $result = $this->ApiModel->updateTask($data, $this->input->post('id'));
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Task updated successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to update task'
            ]));
        }
        // }
    }

    function deleteTask($id)
    {
        $result = $this->ApiModel->deleteTask($id);
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Task entry deleted successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to delete task entry'
            ]));
        }

    }

    public function getAttendance()
    {
        $attendance = $this->ApiModel->getAttendance();
        $this->output->set_output(json_encode($attendance));
    }

    public function createAttendance()
    {

        header('Content-Type: application/json');
        $formArray = array();
        $formArray['rollNo'] = $this->input->post('rollNo');
        $formArray['className'] = $this->input->post('className');
        $formArray['attendanceDate'] = $this->input->post('attendanceDate');
        $formArray['attendanceTime'] = $this->input->post('attendanceTime');
        $formArray['presenty'] = $this->input->post('presenty');


        $attendance_id = $this->ApiModel->createAttendance($formArray);
        if ($attendance_id) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Attendance created successfully',
                'attendance_id' => $attendance_id
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to create Attendance'
            ]));
        }
    }

    public function updateAttendance()
    {
        header('Content-Type: application/json');
        $data = array(
            'id' => $this->input->post('id'),
            'rollNo' => $this->input->post('rollNo'),
            'className' => $this->input->post('className'),
            'attendanceDate' => $this->input->post('attendanceDate'),
            'attendanceTime' => $this->input->post('attendanceTime'),
            'presenty' => $this->input->post('presenty')

        );
        $result = $this->ApiModel->updateAttendance($data, $this->input->post('id'));
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Attendance updated successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to update Attendance'
            ]));
        }
        // }
    }

    function deleteAttendance($id)
    {
        $result = $this->ApiModel->deleteAttendance($id);
        if ($result) {
            $this->output->set_output(json_encode([
                'status' => true,
                'message' => 'Attendance entry deleted successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Failed to delete attendance entry'
            ]));
        }

    }






}

?>
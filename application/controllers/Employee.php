<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller{
	private $show;
	 function __construct(){
		parent::__construct();
		$this->load->model('employeemodel','m');
		$this->show["message"]="";
		$this->load->library('session');
	}
	 function index(){
		$this->load->view("layout/header");
		$this->load->view("employee/index");
		$this->load->view("layout/footer");
	}
	 function  showAllEmployee(){
		echo  json_encode( $this->m->showAllEmployee());
	}
	function saveEmployee(){
		$result  = $this->m->saveEmployee("employees",array("Name"=>$this->input->post('Name') ,"Adress"=>$this->input->post('Adress'), "Age"=>$this->input->post('Age') ));
		if ($result){
					$this->show["message"]="Success";
		}else {
					$this->show["message"]="Error to try insert";
		}
		echo json_encode($this->show);
	}
	function showEmployeeById()
	{
		echo json_encode($this->m->showEmployeeById("employees",$this->input->post("Id")));
	}
	function  showEmployeesByFilter(){
		echo json_encode($this->m->showEmployeesByFilter("employees",$this->input->post("Name")));
	}
	function updateEmployee(){

		$id = $this->input->post('Id');
		$name = $this->input->post('Name');
		$address= $this->input->post('Adress');
		 $age= $this->input->post('Age');
		
		if ($this->m->updateEmployee($id,$name,$address,$age) )
		{
			$this->show["message"]= "Updated successfuly";
		}
		else 
		{
			$this->show["message"]= "Error update";
		}
		echo json_encode($this->show);
	}

	function deleteUser(){
		echo json_encode($this->m->deleteUser($this->input->post("Id")));
	}
	function Login(){
		$query = $this->m->Login($this->input->post('Name'),$this->input->post('Age'));
		
		if ($query){
			$this->show["message"]= "Yes";
		}else {
			$this->show["message"]= "No";
		}
		echo json_encode($this->show);
	}
}

?>
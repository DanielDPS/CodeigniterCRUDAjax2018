<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Employeemodel extends CI_Model{
	
	 function __construct(){
		parent::__construct();
	}
    function  showAllEmployee(){
		$query =  $this->db->get('employees');
		if ($query->num_rows() >0){
			return  $query->result();
		}else 
		return false;
	}
	function saveEmployee($table,$array){
		return	$this->db->insert($table,$array);
	}
	function showEmployeeById($table,$id)
	{
		$this->db->where("Id",$id);
		return $this->db->get($table)->result();
	}
	function showEmployeesByFilter($table,$filter)
	{
		$this->db->like("Name",$filter);
		$this->db->or_like("Age",$filter);
		 return $this->db->get($table)->result();
	}
	function updateEmployee($id,$name,$address,$age){
		$data = array(
			"Name"=>$name,
			"Adress"=>$address,
			"Age"=>$age
		);
	    $this->db->where("Id =",$id);
		return $this->db->update("employees",$data);
	}
	function deleteUser($id){
		$this->db->where("Id",$id);
		return $this->db->delete("employees");
	}
	function Login($name,$age)
	{
		$array = array("Name"=>$name,"Age"=>$age);
		$this->session->set_userdata($array);
		return $this->db->get_where("employees",$array)->result();

	}


}

?>
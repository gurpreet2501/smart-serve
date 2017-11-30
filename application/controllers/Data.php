<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->database();
		$this->load->helper('url');
	}

	public function _example_output($output = null)
	{
		$this->load->view('crud.php',(array)$output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function products(){
		
	}


	public function categories(){

	}


	public function manageUsers()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->columns('username');
			$crud->fields('username','password','role');
			$crud->field_type('role','dropdown', array('admin' => 'Admin', 'operator' => 'Operator','manager' => 'Manager'));
			$crud->callback_field('password', array($this,'edit_password_callback'));
			$crud->callback_before_update(array($this,'on_update_encrypt_password_callback'));
      $crud->callback_before_insert(array($this,'on_update_encrypt_password_callback'));
			$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function userAccess()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->field_type('role','dropdown', array('operator' => 'Operator','manager' => 'Manager'));
			$crud->set_table('user_access');
			$crud->callback_field('feature',array($this,'get_menu_keys'));
			$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}

	function get_menu_keys($value = '', $primary_key = null)
	{  

		$menuItems = [];

		foreach($this->config->item('menu_access') as $key => $val):
			foreach($val as $feature => $url):
				$menuItems[] = $feature;
			endforeach;	
		endforeach;
		$dropDown = "<select class='form-control' name='feature'>";
		foreach($menuItems as $v):
		 $dropDown .= "<option value=".$v.">".ucwords(str_replace('_', ' ', $v))."</option>";
		endforeach;		

		$dropDown .= "</select>";
		
		return $dropDown;
		
	}

	function on_update_encrypt_password_callback($post_array){
		if($post_array['password'] != '__DEFAULT_PASSWORD_'){
      $password=$post_array['password'];
			$hasher = new PasswordHash(
	    		$this->config->item('phpass_hash_strength', 'tank_auth'),
		    	$this->config->item('phpass_hash_portable', 'tank_auth')
			);

			$post_array['password'] = $hasher->HashPassword($password);
			$post_array['activated'] = 1;
			return $post_array;
		}

		unset($post_array['password']);
		return $post_array;
	}

	  function edit_password_callback($post_array){
		return '<input type="password" class="form-control" value="__DEFAULT_PASSWORD_" name="password" style="width:462px">';
	}

}

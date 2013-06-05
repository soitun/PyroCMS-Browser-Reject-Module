<?php defined('BASEPATH') or exit('No direct script access allowed');


class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->lang->load('browser_reject');
        $this->load->driver('Streams');
        $this->load->model('browser_reject_m');
	}
	
	public function index()
	{
		$first_entry_exists = $this->browser_reject_m->first_entry_exists();
		
		//If exists I need to show the edit form - othervise I need to insert it
		$method = ( $first_entry_exists ) ? "edit" : "new";
		
		$options = array(
			'success_message' 	=> lang('browser_reject:form:success'),
			'failure_message' 	=> lang('browser_reject:form:failure'),
			'return' 			=> 'admin/browser_reject',
			'title' 			=> lang('browser_reject:form:title'),
            'required' 			=> ': <span>*</span>'
		);
		
		$this->streams->cp->entry_form('browser_reject','browser_reject',$method , 1, true, $options);
	}
}
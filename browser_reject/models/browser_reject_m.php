<?php defined('BASEPATH') or exit('No direct script access allowed');

class browser_reject_m extends CI_Model
{
	public function __construct()
	{
		parent::__construct();        
	}
	
	public function first_entry_exists()
	{
		$query = $this->db->get('browser_reject');
		if( $query->num_rows() > 0 )
			return true;
		return false;
	}
	
	public function get_all_options()
	{
		$query = $this->db->get('browser_reject');
		if( $query->num_rows() > 0 )
			return $query->result();
		return 0;
	}
}
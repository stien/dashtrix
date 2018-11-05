<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class admin_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$db = $this->load->database();
	}
	// Admin login
	public function admin_login($username,$pass)
	{
		$this->db->where(array('aUsername'=>$username,'aPassword'=>$pass));
		$query = $this->db->get('dev_web_admin');
		if ($query->num_rows() > 0)
		{
			$row 							= $query->result_array();
			$_SESSION['backendAdminSess'] 	= $row;	
			$return = 'yes';
		}
		else
		{
			$return = 'no';
		}
		return $return;
	}
	
	// ADD SIMPLE
	public function add_table_simple($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	// GET SIMPLE TABLE DATA
	public function get_table_data($table){
		$query 	= $this->db->get($table);
		$row 	= $query->result_object();
		return $row;
	}
	// Update Table Simple
	public function edit_table_simple($table,$data,$id){
		$this->db->where($id);
		$this->db->update($table, $data);
	}
	// delete fields
	public function delete_table_simple($table,$condition){
		$conditionPage = $condition;
		$this->db->delete($table,$conditionPage);
	}
	// GET SIMPLE TABLE DATA
	public function get_table_data_condition($table,$id){
		$this->db->where($id);
		$query 	= $this->db->get($table);
		$row 	= $query->result_object();
		return $row;
	}
	// GET SIMPLE TABLE DATA
	public function get_table_data_condition_countrce($table,$id){
		$this->db->where($id);
		$query 	= $this->db->get($table);
		//$row 	= $query->result_object();
		return $query;
	}
	
	// GET ALL CATEGORIES PARENT
	public function get_all_parents($pID){
		$this->db->where(array('catParent'=>$pID));
		$this->db->order_by("cID","desc");
		$query 	= $this->db->get('dev_web_categories');
		$row 	= $query->result_array();
		return $row;
	}
	// get selected parent category
	public function get_selected_categories($id){
		$this->db->where(array('catParent'=>$id));
		$query 	= $this->db->get('dev_web_categories');
		$row 	= $query->result_array();
		return $row;
	}
	// GET ALL CATEGORIES	
	public function get_all_categories(){
		$query 	= $this->db->query('SELECT P.catName,P.cID,P.catParent,P.catTitle,P.catDesp,P.catKeys,P.catLink,P.catImg,P.catIcon,P.catStatus, U.catName AS Parent_name FROM `dev_web_categories` AS P LEFT JOIN `dev_web_categories` AS U ON U.cID = P.catParent');
		$row 	= $query->result_array();
		return $row;
	}
	// GET SPECIFIC CATEGORIES
	public function get_category_edit($cID){
		$this->db->where(array('cID'=>$cID));
		$query 	= $this->db->get('dev_web_categories');
		$row 	= $query->result_array();
		return $row;
	}
	// Active multiple categories
	public function update_selected_category($id){
		$this->db->query("UPDATE `dev_web_categories` SET `catStatus` = 1 WHERE cID = '".$id."'");
	}
	// InActive multiple categories
	public function Inactive_selected_category($id){
		$this->db->query("UPDATE `dev_web_categories` SET `catStatus` = 0 WHERE cID = '".$id."'");
	}
	// Active multiple users
	public function update_selected_users($id){
		$this->db->query("UPDATE `dev_web_user` SET `uStatus` = 1 WHERE uID = '".$id."'");
	}
	// InActive multiple users
	public function Inactive_selected_users($id){
		$this->db->query("UPDATE `dev_web_user` SET `uStatus` = 0 WHERE uID = '".$id."'");
	}
	// Check email address address exits or not
	public function check_email_user($uemail){
		$this->db->where(array('uEmail'=>$uemail));
		$query 	= $this->db->get('dev_web_user');
		if ($query->num_rows() > 0)
		{
			$row 	= 'no';
		}
		else
		{
			$row 	= 'yes';
		}
		return $row;
	}
	// CHECK EMAIL AND COMPANY 
	public function check_comp_email_companyname($email,$company){
		$query = $this->db->query("SELECT * FROM `dev_web_user` WHERE `uEmail` = '".$email."' OR `uCompany` = '".$company."'");
		//$row 	= $query->result_object();
		return $query;
	}
	// GET EMAILS SETTINGS	
	public function get_emails_data($code){
		$this->db->where(array('eCode'=>$code));
		$query 	= $this->db->get('dev_web_emails');
		$row 	= $query->result_object();
		return $row;
	}
	// SELECT ALL USERS LIMIT 
	public function get_all_users_limit(){
		$query = $this->db->query('SELECT * FROM `dev_web_user` ORDER BY `uID` DESC LIMIT 0,5');
		$row 	= $query->result_object();
		return $row;
	}
	// SELECT ALL WEBSITES 
	public function getalljobs_limited(){
		$query = $this->db->query('SELECT * FROM `dev_web_jobs` ORDER BY `jID` DESC LIMIT 0,5');
		$row 	= $query->result_object();
		return $row;
	}
	// Get dashboard stats
	public function today_stats()
	{
		$query = $this->db->query("SELECT  * FROM
							(SELECT COUNT(*) AS userTotal FROM `dev_web_user` WHERE  DATE(joinDate) = CURDATE() AND `uActType` = 1) T1 JOIN
							(SELECT COUNT(*) AS catsTotal FROM `dev_web_categories`) T2 JOIN
                            (SELECT COUNT(*) AS webTotal FROM `dev_web_jobs` WHERE  DATE(jPostedDate) = CURDATE()) T3 JOIN
							(SELECT COUNT(*) AS revTotal FROM `dev_web_user` WHERE `uActType` = 1) T4 JOIN
							(SELECT COUNT(*) AS comTotal FROM `dev_web_user` WHERE DATE(joinDate) = CURDATE() AND `uActType` = 2) T5 JOIN
							(SELECT SUM(uPrice) AS comorder FROM `dev_web_order`) T6 JOIN
							(SELECT COUNT(*) AS visTotal FROM `dev_web_visitors`) T7 ON 1=1");
		
		$row = $query->result_array();
		return $row;
	}
	public function get_stats()
	{
		$query = $this->db->query("SELECT  * FROM
							(SELECT COUNT(*) AS userTotal FROM `dev_web_user`) T1 JOIN
							(SELECT COUNT(*) AS catsTotal FROM `dev_web_categories`) T2 JOIN
                            (SELECT COUNT(*) AS webTotal FROM `dev_web_jobs`) T3 JOIN
							(SELECT COUNT(*) AS revTotal FROM `dev_web_user` WHERE `uActType` = 1) T4 JOIN
							(SELECT COUNT(*) AS comTotal FROM `dev_web_user` WHERE `uActType` = 2) T5 JOIN
							(SELECT SUM(uPrice) AS comorder FROM `dev_web_order`) T6 JOIN
							(SELECT COUNT(*) AS agents FROM `dev_web_jobs` WHERE `jPostedUser` = '0') T7 JOIN
							(SELECT COUNT(*) AS totalviewd FROM `dev_web_jobs` WHERE `jViewed` = '1') T8 JOIN
							(SELECT COUNT(*) AS totalnotviewed FROM `dev_web_jobs` WHERE `jViewed` = '0') T9 JOIN
							(SELECT COUNT(*) AS visTotal FROM `dev_web_visitors`) T10 ON 1=1");
		
		$row = $query->result_array();
		return $row;
	}
	// GET Reviews Datewise
	public function date_reviews()
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS Datacount,`jPostedDate` AS Review FROM `dev_web_jobs` GROUP BY DATE(`jPostedDate`)");
		$row 	= $query->result_object();
		return $row;
	}
		// GET COMPLAINT LATEST WITH PAGINATION
	public function record_count() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_user` WHERE `uActType` = '2'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsHome($limit, $start)
	{
		$query = $this->db->query("SELECT * FROM `dev_web_user` WHERE `uActType` = '2' ORDER BY `uID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	public function record_count_search($search) {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_user` WHERE `uActType` = '2' AND `uFname` LIKE '%".$search."%' OR `uLname` LIKE '%".$search."%' OR `uEmail` LIKE '%".$search."%' OR `uCountry` LIKE '%".$search."%'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsHome_search($search,$limit, $start)
	{
		$query = $this->db->query("SELECT * FROM `dev_web_user` WHERE `uActType` = '2' AND `uFname` LIKE '%".$search."%' OR `uLname` LIKE '%".$search."%' OR `uEmail` LIKE '%".$search."%' OR `uCountry` LIKE '%".$search."%' ORDER BY `uID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET COMPLAINT LATEST WITH PAGINATION
	public function record_count_jobseeker() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_user` WHERE `uActType` = '1'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	// GET COMPLAINT LATEST WITH PAGINATION
	public function record_count_jobseeker_search($search) {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_user` WHERE `uActType` = '1' AND `uFname` LIKE '%".$search."%' OR `uLname` LIKE '%".$search."%' OR `uEmail` LIKE '%".$search."%' OR `uCountry` LIKE '%".$search."%'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsHome_jobseeker_search($search,$limit, $start)
	{
		$query = $this->db->query("SELECT * FROM `dev_web_user` WHERE `uActType` = '1' AND `uFname` LIKE '%".$search."%' OR `uLname` LIKE '%".$search."%' OR `uEmail` LIKE '%".$search."%' ORDER BY `uID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	public function getComplaintsHome_jobseeker($limit, $start)
	{
		$query = $this->db->query("SELECT * FROM `dev_web_user` WHERE `uActType` = '1' ORDER BY `uID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET COMPLAINT LATEST WITH PAGINATION
	public function record_count_all() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_user`");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsHome_all($limit, $start)
	{
		$query = $this->db->query("SELECT * FROM `dev_web_user` ORDER BY `uID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET COMPLAINT LATEST WITH PAGINATION
	public function record_count_all_search($search) {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_user` WHERE `uFname` LIKE '%".$search."%' OR `uLname` LIKE '%".$search."%' OR `uEmail` LIKE '%".$search."%' OR `uCountry` LIKE '%".$search."%'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getUserSearchrecords($search, $limit, $start)
	{
		$query = $this->db->query("SELECT * FROM `dev_web_user` WHERE `uFname` LIKE '%".$search."%' OR `uLname` LIKE '%".$search."%' OR `uEmail` LIKE '%".$search."%' OR `uCountry` LIKE '%".$search."%' ORDER BY `uID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// get specific user
	public function get_specific_user($uID){
		$this->db->where(array('uID'=>$uID));
		$query = $this->db->get('dev_web_user');
		$row 	= $query->result_array();
		return $row;
	}
	// BAN IP DATA
	public function add_ban_ip($data){
		$this->db->insert('dev_web_ip', $data);
	}
	// edit user
	public function edit_user_new($data,$id){
		$this->db->where(array('uID'=>$id));
		$this->db->update('dev_web_user', $data);
	}
	// delete fields
	public function deletebanIp($fid){
		$conditionPage = array ('ipID' => $fid);
		$this->db->delete('dev_web_ip',$conditionPage);
	}
	// GET BANNED IP
	public function getipaddbandetailsbyid(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_ip` WHERE `uID` = '0'");
		return $query;
	}
	// Update Password
	public function update_password($data,$id){
		$this->db->where(array('aID'=>$id));
		$this->db->update('dev_web_admin', $data);
	}
	// TODAY JOBS
	public function getjobstodayall(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_jobs` WHERE  `jPostedDate` = '".date("Y-m-d")."'");
		$row 	= $query->result_object();
		return $row;
	}
	public function gettodayuserslist($type)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE  DATE(joinDate) = CURDATE() AND `uActType` = '".$type."'");
		$row 	= $query->result_object();
		return $row;
	}
	public function verifiedemaileduser($type,$id)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE  `uActType` = '".$type."' AND `uverifyemail` = '".$id."'");
		$row 	= $query->result_object();
		return $row;
	}
	public function resumeuploaded($type)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` AS U INNER JOIN `dev_web_cv` AS R ON U.`uID` = R.`uID` WHERE  U.`uActType` = '".$type."'");
		$row 	= $query->result_object();
		return $row;
	}
	public function profilefilledjobseekers($type)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE `uFname` IS NOT NULL AND `uLname` IS NOT NULL AND `uCountry` IS NOT NULL AND `uGender` IS NOT NULL AND `uActType` = '".$type."'");
		$row 	= $query->result_object();
		return $row;
	}
}
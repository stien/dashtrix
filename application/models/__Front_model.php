<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class front_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$db = $this->load->database();
	}
	// Get Countries List
	public function get_countries(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_countries` ORDER BY `id` ASC");
		$row 	= $query->result_object();
		return $row;
	}
	
	// GET QUERY SETTINGS	
	public function get_query_simple($select,$table,$where=''){
		$this->db->select($select);
		$this->db->where($where);
		$query 	= $this->db->get($table);
		//echo $this->db->last_query();
		return $query;
	}
	// GET QUERY SETTINGS	
	public function get_query_orderby($select,$table,$where='',$orderby,$type){
		$this->db->select($select);
		$this->db->where($where);
		
		$this->db->order_by($orderby,$type);
		$query 	= $this->db->get($table);
		//echo $this->db->last_query();
		return $query;
	}
	// GET QUERY SETTINGS	
	public function get_query_orderby_limit($select,$table,$where='',$orderby,$type,$limit,$start){
		$this->db->select($select);
		$this->db->where($where);
		$this->db->order_by($orderby,$type);
		$this->db->limit($limit, $start);
		$query 	= $this->db->get($table);
		//echo $this->db->last_query();
		return $query;
	}
	// check all email address
	public function check_email_user($uemail){
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE `uEmail` = '".$uemail."'");
		return $query->num_rows();
	}
	// GET LAST ID
	public function add_user_new_fb($data){
		$this->db->insert('dev_web_user', $data);
		return $this->db->insert_id();
	}
	// TWITTER CHECK LOGIN
	public function check_user_login_details_twitter($uemail){
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE `uEmail` = '".$uemail."'");
		$count = $query->num_rows();
		if($count > 0){
			$row 							= $query->result_object();
			$_SESSION['JobsSessions'] 	= $row;	
			$ret = 1;
		}
		else
		{
			$ret = 0;
		}
		return $ret;
	}
	
	
	// check email address and password
	public function check_user_login_details($uemail,$upass){
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE `uEmail` = '".$uemail."' AND `uPassword` = '".$upass."' AND `uStatus` = '1'");
		$count = $query->num_rows();
		if($count > 0){
			$row = $query->result_object();
			$_SESSION['JobsSessions'] 	= $row;	
			$ret = 1;
		}
		else
		{
			$ret = 0;
		}
		return $ret;
	}
	
	// add Query
	public function add_query($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	// Update Query
	public function update_query($table,$data,$condition){
		$this->db->where($condition);
		$this->db->update($table,$data);
	}
	
	// Delete
	public function delete_query($table,$data){
		$this->db->delete($table, $data);
	}
	// GET EMAILS SETTINGS	
	public function get_emails_data($code){
		$this->db->where(array('eCode'=>$code));
		$query 	= $this->db->get('dev_web_emails');
		$row 	= $query->result_object();
		return $row;
	}
	// get cms page content
	public function get_cms_page($plink){
		$this->db->where(array('pLink'=>$plink));
		$query 	= $this->db->get('dev_web_pages');
		$row 	= $query->result_object();
		return $row;
	}
	
	// GET JOBS WITH COMPANY NAME
	public function get_jobs_list($limit, $start)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_jobs` AS J INNER JOIN `dev_web_user` AS U ON J.`uID` = U.`uID` WHERE J.`jJobStatus` = '1' ORDER BY J.`jID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	
	
	// GET JOB SEARCH
	public function job_search_records($search,$cid){
		$query 	= $this->db->query("SELECT * FROM `dev_web_jobs` WHERE `jTitle` LIKE '%".$search."%' OR `jCoutry` = '".$cid."' AND `jJobStatus` = '1' ORDER BY `jID` DESC LIMIT 0,10");
		$row = $query->result_object();
		return $row;
	}
	
	// GET APPLIED JOBS WITH
	public function get_applied_jobs($uid)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_applied` AS C INNER JOIN `dev_web_jobs` AS U ON C.`jID` = U.`jID` WHERE C.`uID` = '".$uid."' ORDER BY C.`aID` DESC");
		$row = $query->result_object();
		return $row;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// Get ALL CATEGORIES
	public function get_categoriesmain(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` ORDER BY `cID` ASC");
		//$row 	= $query->result_object();
		return $query;
	}
	// Get ALL CATEGORIES
	public function get_categoriesparentmain(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `catParent` = '0' ORDER BY `cID` ASC");
		//$row 	= $query->result_object();
		return $query;
	}
	// SELECT ALL Background 
	public function getbackgrounddetails(){
		$query = $this->db->query('SELECT * FROM `dev_web_background`');
		//$row 	= $query->result_array();
		return $query;
	}
	
	// GET ALL CATEGORIES PARENT Catname
	public function get_all_parents_links($pID){
		$this->db->where(array('catLink'=>$pID));
		$query 	= $this->db->get('dev_web_categories');
		$row 	= $query->result_object();
		return $row;
	}
	// GET ALL CATEGORIES PARENT
	public function get_all_parents($pID){
		$this->db->where(array('catParent'=>$pID));
		$query 	= $this->db->get('dev_web_categories');
		$row 	= $query->result_object();
		return $row;
	}
	// GET CITIES BY SEARCH
	public function getcities($search){
		$query 	= $this->db->query("SELECT * FROM `dev_web_cities` WHERE `city_name` LIKE '%".$search."%' ORDER BY `city_id` ASC");
		$row = $query->result_object();
		return $row;
	}
	// GET COMPANIES BY SEARCH
	public function getCompaniesSearch($search){
		$query 	= $this->db->query("SELECT * FROM `dev_web_company` WHERE `compName` = '".$search."'");
		$row = $query->result_object();
		return $row;
	}
	// GET ALL CATEGORIES PARENT
	public function update_company_data($data,$pID){
		$this->db->where(array('compID'=>$pID));
		$this->db->update('dev_web_company',$data);
	}
	// Get only non parent category
	public function get_no_parents(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `catParent` != '0' ORDER BY `catName` ASC LIMIT 0,20");
		return $query;
	}
	// Get only non parent category
	public function get_parents_id_ink($catlink){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `cID` = '".$catlink."'");
		$row 	= $query->result_object();
		return $row;
	}
	// Get only non parent category
	public function get_parents_categories_sub($catlink){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `catParent` = '".$catlink."'");
		$row 	= $query->result_object();
		return $row;
	}
	// Get category with parent
	public function getcatwithparentall(){
		$query 	= $this->db->query("SELECT P.catName,P.catStatus,P.catLink,P.cID,P.catParent,U.catName AS 
Parent_name FROM `dev_web_categories` AS P LEFT JOIN `dev_web_categories` AS U 
ON U.cID = P.catParent ORDER BY P.cID ASC");
		$row 	= $query->result_object();
		return $row;
	}
	// Get only non parent category
	public function get_no_parents_all(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `catParent` != '0' ORDER BY `catName`");
		return $query;
	}
	// get categories with count
	public function catwithcount(){
		$query 	= $this->db->query("SELECT Count(P.catName) AS Totalcount, U.cID AS cID, U.catName AS cName,U.catLink AS cLink,U.catIcon AS catIcon FROM `dev_web_categories` AS P LEFT JOIN `dev_web_categories` AS U ON U.cID = P.catParent WHERE U.cID = P.catParent GROUP BY P.catParent ORDER BY P.catName ASC");
		$row = $query->result_object();
		return $row;
	}
	// Get only parent category
	public function get_all_parentcategories(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `catParent` = '0' ORDER BY `cID` ASC");
		$row 	= $query->result_object();
		return $row;
	}
	// GET ALL CATEGORIES	
	public function get_all_categories(){
		//$query 	= $this->db->get('dev_web_categories');
		$query 	= $this->db->query('SELECT P.catName,P.cID,P.catParent,P.catLink,P.catIcon,P.catStatus, U.catName AS Parent_name FROM `dev_web_categories` AS P LEFT JOIN `dev_web_categories` AS U ON U.cID = P.catParent');
		$row 	= $query->result_object();
		return $row;
	}
	
	
	
	
	// add new user
	public function add_claim_new($data){
		$this->db->insert('dev_web_claim', $data);
	}
	// add User Points
	public function add_user_points($data){
		$this->db->insert('dev_web_points', $data);
	}
	// check user points address
	public function chec_user_points($uID,$pType){
		//echo "SELECT * FROM `dev_web_points` WHERE `uID` = '".$uID."' AND `pType` = '".$pType."'";
		$query 	= $this->db->query("SELECT * FROM `dev_web_points` WHERE `uID` = '".$uID."' AND `pType` = '".$pType."'");
		return $query;
		//return $query->num_rows();
	}
	
	// add new Notification
	public function add_notification_new($data){
		$this->db->insert('dev_web_notification', $data);
	}
	// add new Notification
	public function add_reputation_new($data){
		$this->db->insert('dev_web_reputation', $data);
	}
	// check user badges address
	public function check_userbadge_reputation($pType){
		$query 	= $this->db->query("SELECT * FROM `dev_web_reputation` WHERE `uID` = '".UID."' AND `bID` = '".$pType."'");
		return $query->num_rows();
	}
	
	// add new Complaint
	public function add_new_complaint($data){
		$this->db->insert('dev_web_complaints', $data);
	}
	// add new GROUP
	public function add_new_group($data){
		$this->db->insert('dev_web_groups', $data);
	}
	// add new Company
	public function add_new_company($data){
		$this->db->insert('dev_web_company', $data);
		return $this->db->insert_id();
	}
	
	// Check if company Already Exist
	public function checkcompanyadded($compLink)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_company` WHERE `compLink` = '".$compLink."'");
		return $query;
	}
	// Check if company Already Exist
	public function getByCompany($compLink)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_company` WHERE `compLink` = '".$compLink."'");
		return $query;
	}
	// Check if company Already Exist
	public function getComplaintsByCompany($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` WHERE C.`compID` = '".$compLink."' ORDER BY C.`cmID` DESC");
		$row 	= $query->result_object();
		return $row;
	}
	
	// Check if company Already Exist
	public function getcompanyrelatedComplaints($compID,$cmID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_complaints` WHERE `compID` = '".$compID."' AND `cmID` != '".$cmID."' ORDER BY `cmID` DESC");
		//$row 	= $query->result_object();
		return $query;
	}
	// Check if company Already Exist
	public function checkcompandatawithuID()
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_company` WHERE `uID` = '".UID."'");
		return $query;
	}
	// Check if company Data thourgh ID
	public function getcompanyData($compID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_company` WHERE `compID` = '".$compID."'");
		$row 	= $query->result_object();
		return $row;
	}
	// COMPLAINT IS VIDEO ORNOT INFO
	public function getcomplaintidVideo($compLink)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_complaints` WHERE `cmURL` = '".$compLink."'");
		$rpw = $query->result_object();
		return $rpw;
	}
	
	// GET COMPLAINTS AGAINST A USER
	public function getUserComplaints($uid)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_complaints` WHERE `uID` = '".$uid."' AND `cmStatus` = '1'");
		
		return $query;
	}
	// GET GROUPS AGAINST A USER
	public function getUserGroupsC($uid)
	{
		
		$query 	= $this->db->query("SELECT * FROM `dev_web_groups` WHERE `uID` = '".$uid."' AND `gStatus` = '1'");
		
		return $query;
	}
	// GET NOTIFICATION AGAINST A USER
	public function getUserNotifictaion()
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_notification` WHERE `uID` = '".UID."' AND nStatus= '0'");
		
		return $query;
	}
	
	// edit user
	public function edit_user_new_data($data,$id){
		$this->db->where(array('uID'=>$id));
		$this->db->update('dev_web_user', $data);
	}
	// GET COMPLAINT DATA WITH USER INFO
	public function getComplaintDataAll($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND C.`cmURL` = '".$compLink."'");
		return $query;
	}
	
	// GET COMPLAINT DATA WITH USER INFO
	public function getComplaintDataAllVideo($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND C.`cmURL` = '".$compLink."' AND `cVid` = '1'");
		return $query;
	}
	
	// GET NOTIFICATIONS DATA 
	public function getNotificationsWitHDetails()
	{
		/*echo "SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_notification` AS U ON C.`cmID` = U.`cmID` AND U.`uID` = '".UID."' ORDER BY `nID` DESC";*/
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_notification` AS U ON C.`cmID` = U.`cmID` AND U.`uID` = '".UID."' ORDER BY `nID` DESC");
		$row = $query->result_object();
		return $row;
	}
	// GET NOTIFICATIONS DATA 
	public function getNotificationsWitHDetailsUSER()
	{
		/*echo "SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_notification` AS U ON C.`cmID` = U.`cmID` AND U.`uID` = '".UID."' ORDER BY `nID` DESC";*/
		$query 	= $this->db->query("SELECT * FROM `dev_web_notification` WHERE `uID` = '".UID."' ORDER BY `nID` DESC");
		$row = $query->result_object();
		return $row;
	}
	// GET POINTS AND DATA TO DPSLAY DATA 
	public function getuserPointsAndDAta($uid)
	{
		$query 	= $this->db->query("SELECT SUM(P.points) AS POINTTOTAL,P.*,B.* FROM `dev_web_bagdes` AS B INNER JOIN `dev_web_points` AS P ON P.`pType` = B.`bType` AND P.`uID` = '".$uid."' GROUP BY P.`pType` ORDER BY B.`bID` DESC");
		$row = $query->result_object();
		return $row;
	}
	// GET USERS WHOLE BADGES 
	public function getuserallBadges($uid)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_bagdes` AS B INNER JOIN `dev_web_reputation` AS P ON P.`bID` = B.`bID` AND P.`uID` = '".$uid."' ORDER BY P.`rID` DESC");
		$row = $query->result_object();
		return $row;
	}
	// GET ALL BADGES INFO
	public function getallbadgeinfo()
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_bagdes` ORDER BY `bID` ASC");
		$row = $query->result_object();
		return $row;
	}
	
	// GET USERS WHOLE BADGES 
	public function getbadgesCount($uid,$btype)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS TOTALBADGE FROM `dev_web_reputation` WHERE `uID` = '".$uid."' AND `rBadge` = '".$btype."'");
		$row = $query->result_object();
		return $row[0]->TOTALBADGE;
	}
	
	// GET User Reputation 
	public function getReputationCount($uid)
	{
		$query 	= $this->db->query("SELECT SUM(rPoints) AS TOTALREPU FROM `dev_web_reputation` WHERE `uID` = '".$uid."'");
		$row = $query->result_object();
		return $row[0]->TOTALREPU;
	}
	// GET Complaint msgs count 
	public function getUidComplaintsCommentsCount($uid,$ptype)
	{
		$query 	= $this->db->query("SELECT SUM(points) AS TOTALREPU FROM `dev_web_points` WHERE `uID` = '".$uid."' AND `pType` = '".$ptype."'");
		$row = $query->result_object();
		return $row[0]->TOTALREPU;
	}
	// GET POINTS AND DATA TO DPSLAY DATA 
	public function getuserPointsAndDAtaCount($uid)
	{
		
		$query 	= $this->db->query("SELECT SUM(P.points) AS POINTTOTAL,P.*,B.* FROM `dev_web_bagdes` AS B INNER JOIN `dev_web_points` AS P ON P.`pType` = B.`bType` AND P.`uID` = '".$uid."' GROUP BY P.`pType` AND B.badge ORDER BY B.`bID` DESC");
		$row = $query->num_rows();
		return $row;
	}
	// GET Points DATA 
	public function getPointnotifcation()
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_notification` WHERE `pType` = '1' AND `uID` = '".UID."' ORDER BY `nID` DESC");
		$row = $query->result_object();
		return $row;
	}
	// GET TRICKS DATA WITH USER INFO
	public function getTricksDataAll($compLink)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_tricks` WHERE `tURL` = '".$compLink."'");
		return $query;
	}
	
	// GET GROUPS DATA WITH USER INFO
	public function getGtopusDataAll($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_groups` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND C.`gURL` = '".$compLink."'");
		return $query;
	}
	// GET Photos DATA WITH USER INFO
	public function getPhotosDataAll($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_photos` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND C.`pURL` = '".$compLink."'");
		return $query;
	}
	
	// GET PHOTOS FOR FOOTER INFO
	public function getFooterPhotosDataAll()
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_photos` ORDER BY pID DESC LIMIT 0,4");
		return $query;
	}
	// GET TICKEY DATA WITH USER INFO
	public function getTicketsDataAll($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_tickets` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND C.`tkCode` = '".$compLink."'");
		return $query;
	}
	// GET TICKEY DATA WITH USER INFO
	public function GetTicketCommentsMsgs($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_tickets_messages` AS C INNER JOIN `dev_web_tickets` AS U ON C.`tkID` = U.`tkID` AND U.`tkCode` = '".$compLink."'");
		$row = $query->result_object();
		return $row;
	}
	// GET Tirkcs DATA WITH USER INFO
	public function getTroclsDataAll($compLink)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_tricks` WHERE `tURL` = '".$compLink."'");
		return $query;
	}
	// GET QUESTION DATA WITH USER INFO
	public function getQuestionsDataAll($compLink)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_questions` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND C.`qURL` = '".$compLink."'");
		return $query;
	}
	// GET COMPLAINT LATEST WITH PAGINATION
	public function record_count() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND C.`cVid` = '0' AND `cmStatus` = '1'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsHome($limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' AND C.`cVid` = '0' ORDER BY `cmID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	public function getSpecificUserComplaints($uid)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' AND C.`cVid` = '0' WHERE U.`uUsername` = '".$uid."' ORDER BY `cmID` DESC ");
		return $query;
	}
	// GET VIDEO  LATEST WITH PAGINATION
	public function record_count_videos() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE `cVid` = '1'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsVideosPosts($limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE `cVid` = '1' ORDER BY `cmID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET LATEST GROUPS WITH PAGINATION
	public function record_count_groups() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_groups` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `gStatus` = '1'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsGroups($limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_groups` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `gStatus` = '1' ORDER BY `gID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET LATEST PHOTOS WITH PAGINATION
	public function record_count_photos() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_photos` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID`");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getComplaintsPhotos($limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_photos` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` ORDER BY `pID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET LATEST TIPS ANND TRICLS WITH PAGINATION
	public function record_count_tricks() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_tricks` WHERE `tStatus` = '1'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getTricks($limit, $start)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_tricks` WHERE `tStatus` = '1' ORDER BY `tID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET LATEST TICKET SYSTEM WITH PAGINATION
	public function record_count_tickest() {
        $query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_tickets` WHERE `uID` = '".UID."'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
    }
	public function getTicketsAll($limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_tickets` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` ORDER BY `tkID` DESC LIMIT ".$limit.", ".$start."");
		//$query 	= $this->db->query("SELECT * FROM `dev_web_tickets` WHERE `uID` = '".UID."' ORDER BY `tkID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// RECORDS BY CATERGORIS COMPLAIT
	public function getCATDataCOUNT($id)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE `cID` = '".$id."' AND `cVid` = '0'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
	}
	public function getcategoriesComplaints($id, $limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE `cID` = '".$id."' ORDER BY `cmID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	
	// RECORDS BY CATERGORIS QUESTION
	public function getCATDataQUESCOUNT($id)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_questions` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `qStatus` = '1' WHERE `cID` = '".$id."'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
	}
	public function getcategoriesQuestions($id, $limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_questions` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `qStatus` = '1' WHERE `cID` = '".$id."' ORDER BY `qID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// RECORDS BY CATERGORIS GROUPS
	public function getCATDataGroups($id)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_groups` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `gStatus` = '1' WHERE `cID` = '".$id."'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
	}
	public function getcategoriesGroups($id, $limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_groups` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `gStatus` = '1' WHERE `cID` = '".$id."' ORDER BY `gID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET COMPLAINTS BY COUNTRY
	public function getCOUNTDataCOUNT($id)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE C.`cmCountry` = '".$id."'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
	}
	public function getCountryComplaints($id, $limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE C.`cmCountry` = '".$id."' ORDER BY `cmID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	
	// GET COMPLAINTS BY CITY
	public function getCItyDataCOUNT($id)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE C.`cmCity` = '".$id."'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
	}
	public function getCityComplaints($id, $limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE C.`cmCity` = '".$id."' ORDER BY `cmID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	
	public function getQuestionsCOUNT()
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_questions` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` WHERE C.`qStatus` = '1'");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
	}
	public function getQuestions($limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_questions` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` WHERE C.`qStatus` = '1' ORDER BY `qID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// SEARCH COUNT
	public function getSearchDataCOUNT($search)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTCOMPLAINT FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE C.`cmTitle` LIKE '%".$search."%' ORDER BY `cmID` DESC ");
		$cout = $query->result_object();
		return $cout[0]->COUNTCOMPLAINT;
	}
	
	// SEARCH QUERY
	public function getSearchData($search, $limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE C.`cmTitle` LIKE '%".$search."%' ORDER BY `cmID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GTE COMPLAINTS NAME THROUGH COMID
	public function getComplaintDetailsByComID($rID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_complaints` WHERE `cmID` = '".$rID."'");
		$row 	= $query->result_object();
		return $row;
	}
	public function getreviewdataupdatecount($rID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_reviews` WHERE `rID` = '".$rID."'");
		$row 	= $query->result_object();
		return $row;
	}
	
	public function updatecountreviews($count,$rID)
	{
		$query 	= $this->db->query("UPDATE `dev_web_reviews` SET `rCount` = '".$count."' WHERE `rID` = '".$rID."'");
		//$row 	= $query->result_object();
		return $query;
	}
	
	public function updateNotification()
	{
		$query 	= $this->db->query("UPDATE `dev_web_notification` SET `nStatus` = '1' WHERE `uID` = '".UID."'");
		//$row 	= $query->result_object();
		return $query;
	}
	
	// GET REVIEW NAME
	public function getwebNameDataHeadertwo($rID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` WHERE `webURL` = '".$rID."'");
		return $query;
	}
	
	// GET IP IF BANNED
	public function get_ip_data($rID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_ip` WHERE `ipAdd` = '".$rID."'");
		return $query;
	}
	
	// 
	
	// get user profile info
	public function get_user_info_fb($uEmail){
		$this->db->where(array('uEmail'=>$uEmail));
		$query 	= $this->db->get('dev_web_user');
		$row 	= $query->result_object();
		return $row[0]->uID;
	}

	// get user profile info
	public function get_user_info($uID){
		$this->db->where(array('uID'=>$uID));
		$query 	= $this->db->get('dev_web_user');
		$row 	= $query->result_object();
		return $row;
	}
		
	// Post new ads
	public function postnewads($data){
		$query = $this->db->insert('dev_post_ads', $data);
		return $this->db->insert_id();
	}
	// Add thumbs ads
	public function add_thumbs($data){
		$this->db->insert('dev_ads_images', $data);
	}
	
	public function get_heading_listing($link)
	{
		$query 	= $this->db->query("SELECT count(A.piD) as totalcount,C.catLink,C.catName FROM `dev_post_ads` AS A LEFT OUTER JOIN `dev_web_categories` AS C ON C.cID = A.cID WHERE C.catLink = '".$link."'");
		$row 	= $query->result_object();
		return $row;
	}
	
	// get Ad Listing Details
	public function get_listing_details($link){
		$this->db->where(array('adLink'=>$link));
		$query 	= $this->db->get('dev_post_ads');
		$row 	= $query->result_object();
		return $row;
	}
	// Post new Message
	public function postnewmessage($data){
		$query = $this->db->insert('dev_web_messages', $data);
		return $query;
	}
	// Post new postnewcomment
	public function postnewcomment($data){
		$query = $this->db->insert('dev_web_comments', $data);
		return $query;
	}
	// Post new MESSUP IMAGES
	public function postNewMessups($data){
		$query = $this->db->insert('dev_web_photos', $data);
		return $query;
	}
	// Post new MESSUP IMAGES
	public function postNewCompanyBusiness($data){
		$query = $this->db->insert('dev_web_company', $data);
		return $query;
	}
	// Post new TICKET
	public function postNewTickets($data){
		$query = $this->db->insert('dev_web_tickets', $data);
		return $query;
	}
	// Post new TICKET MSG
	public function postNewTicketsMSG($data){
		$query = $this->db->insert('dev_web_tickets_messages', $data);
		return $query;
	}
	// Post new TICKET MSG
	public function doSubscription($data){
		$query = $this->db->insert('dev_web_subscription', $data);
		return $query;
	}
	// Post new PHOTO COMMENT
	public function postnewphtocomment($data){
		$query = $this->db->insert('dev_web_photos_comments', $data);
		return $query;
	}
	// Post TRICKS COMMENTS
	public function posttrickscomment($data){
		$query = $this->db->insert('dev_web_tricks_comments', $data);
		return $query;
	}
	// Post new Group Discussion
	public function postGroupDiscussion($data){
		$query = $this->db->insert('dev_web_groups_discussion', $data);
		return $query;
	}
	// Post new Group Discussion REPLIES
	public function postGroupDiscussionReplies($data){
		$query = $this->db->insert('dev_web_groups_replies', $data);
		return $query;
	}
	// Post new Question answers
	public function postQuestionAnswer($data){
		$query = $this->db->insert('dev_web_answers', $data);
		return $query;
	}
	// Post new QUESTION
	public function postnewQuestion($data){
		$query = $this->db->insert('dev_web_questions', $data);
		return $query;
	}
	// GET OTHER ADS
	public function get_unarchive_ads($uID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_post_ads` WHERE `uID` = '".$uID."' AND `archived` = '0'");
		$row 	= $query->result_array();
		return $row;
	}
	// GET Archived ADS
	public function get_archiveed_ads($uID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_post_ads` WHERE `uID` = '".$uID."' AND `archived` = '1'");
		$row 	= $query->result_array();
		return $row;
	}
	// GET Favorite ADS
	public function get_favorites_ads($uID)
	{
		$query 	= $this->db->query("SELECT A.*,F.* FROM `dev_post_ads` AS A INNER JOIN `dev_web_favorites` AS F ON F.piD = A.piD AND F.uID = '".$uID."' AND A.archived = 0");
		$row 	= $query->result_array();
		return $row;
	}
	// get Specifc user Ad Listing=
	public function get_user_ads($uID){
		$this->db->where(array('uID'=>$uID));
		$query 	= $this->db->get('dev_post_ads');
		$row 	= $query->result_array();
		return $row;
	}
	public function deleteadposted($piD)
	{
		$query 	= $this->db->query("DELETE FROM `dev_post_ads` WHERE `adCode` = '".$piD."'");
		return $query;
	}
	public function deleteUnscribe($piD)
	{
		$query 	= $this->db->query("DELETE FROM `dev_web_subscription` WHERE `sID` = '".$piD."'");
		return $query;
	}
	// Post new ads
	public function postnewsletter($data){
		$query = $this->db->insert('dev_web_newsletter', $data);
		//return $this->db->insert_id();
	}
	// Add to favorite listings
	public function add_fav_listings($data){
		$query = $this->db->insert('dev_web_favorites', $data);
		return $query;
	}
	
	// get Specifc Ad Listing=
	public function get_specific_extra_ads($piD,$content){
		$query = $this->db->query("UPDATE `dev_post_ads` SET `adContent` = '".$content."' WHERE `piD` = '".$piD."'");
		return $query;
	}
	// GET USER DETAILS ON CODE
	public function get_user_details_code($code){
		$query = $this->db->query("SELECT * FROM `dev_web_user` WHERE `uUsername` = '".$code."'");
		$row 	= $query->result_object();
		return $row;
	}
	
	// Confirm Account
	public function do_confirm_account($code){
		$query = $this->db->query("UPDATE `dev_web_user` SET `uStatus` = '1' WHERE `uCode` = '".$code."'");
		return $query;
	}
	// REPOST Specifc Ad Listing=
	public function repost_specific_ads($pid,$adCode,$expire,$repost){
		$query = $this->db->query("UPDATE `dev_post_ads` SET `archived` = '0',`expiredIn`='".$expire."',`repost` = '".$repost."',`visibility` = '0',`created` = '".date("Y-m-d h:i:s")."' WHERE `adCode` = '".$adCode."' AND `piD` = '".$pid."'");
		return $query;
	}
	public function get_repost_ads_Count($adCode)
	{
		$query 	= $this->db->query("SELECT `piD`,`repost` FROM `dev_post_ads` WHERE `adCode` = '".$adCode."'");
		$row 	= $query->result_array();
		return $row;
	}
	public function remove_ad_favorites($fID)
	{
		$query 	= $this->db->query("DELETE FROM `dev_web_favorites` WHERE `fID` = '".$fID."'");
		return $query;
	}
	
	
	
	// FORGOT PASS
	public function check_frogot_password($uEmail)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE `uEmail` = '".$uEmail."'");
		$count 	= $query->num_rows();
		if($count > 0)
		{
			$ret = 1;
		}else
		{
			$ret = 0;
		}
		return $ret;
	}
	
	public function update_password_checl($email,$pass)
	{
		$query 	= $this->db->query("UPDATE `dev_web_user` SET `uPassword` = '".$pass."' WHERE `uEmail` = '".$email."'");
		return $query;
	}
	
	// CHANGE PASS
	public function check_old_password($pass,$uid)
	{
		
	
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE `uPassword` = '".md5($pass)."' AND `uID` = '".$uid."'");
		$count 	= $query->num_rows();
		if($count > 0)
		{
			$ret = 1;
		}else
		{
			$ret = 0;
		}
		return $ret;
	}
	// UPDATE PASSWORD
	public function update_password_change($pass,$uid)
	{
		$query 	= $this->db->query("UPDATE `dev_web_user` SET `uPassword` = '".md5($pass)."' WHERE `uID` = '".$uid."'");
		return $query;
	}
	
	// UPDATE PROFILE
	public function update_profile_data($uDisplay,$uCountry,$uPhone,$uImage,$uAbout,$uID){
		$query = $this->db->query("UPDATE `dev_web_user` SET `uDisplay`='".$uDisplay."',`uCountry` = '".$uCountry."',`uPhone` = '".$uPhone."', `uImage` = '".$uImage."', `uAbout` = '".$uAbout."' WHERE `uID` = '".$uID."'");
		return $query;
	}
	// UPDATE PROFILE
	public function update_profile_data2($uDisplay,$uCountry,$uPhone,$uAbout,$uID){
		$query = $this->db->query("UPDATE `dev_web_user` SET `uDisplay`='".$uDisplay."',`uCountry` = '".$uCountry."',`uPhone` = '".$uPhone."', `uAbout` = '".$uAbout."' WHERE `uID` = '".$uID."'");
		return $query;
	}
	// ADD WEBSIE NEW
	public function addnewwebsitesdata($data){
		$query = $this->db->insert('dev_web_website', $data);
		return $query;
	}
	// ADD COMPLAINT USEFUL NEW
	public function addComplaintUseful($data){
		$query = $this->db->insert('dev_web_useful', $data);
		return $query;
	}
	// ADD WEBSIE NEW
	public function addnewwebsitesdataReviewPage($data){
		$this->db->insert('dev_web_website', $data);
		return $this->db->insert_id();
	}
	// ADD WEBSIE BOOKMARK
	public function addwebBookmark($data){
		$query = $this->db->insert('dev_web_bookmark', $data);
		return $query;
	}
	// GET ONLY WEBSITES
	public function getwebsitesdata(){
		$query 	= $this->db->get('dev_web_website');
		$row 	= $query->result_object();
		return $row;
	}
	// ADD WEBSIE Reviews
	public function addnewreviewsdata($data){
		$query = $this->db->insert('dev_web_reviews', $data);
		return $query;
	}
	// DISPLAY WEBSITE DATA
	public function get_website_data($webURL){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W WHERE W.webURL = '".$webURL."'");
		$row 	= $query->result_object();
		return $row;
	}
	// DISPLAY USEFUL
	public function display_usefuldata($webURL,$val){
		//echo "SELECT COUNT(uval) AS VOTE FROM `dev_web_useful` WHERE `cmID` = '".$webURL."' AND `uval` = '".$val."'";
		$query 	= $this->db->query("SELECT COUNT(uval) AS VOTE FROM `dev_web_useful` WHERE `cmID` = '".$webURL."' AND `uval` = '".$val."'");
		//$row 	= $query->num();
		return $query;
	}
	// DISPLAY USEFUL PER USER
	public function display_usefuldata_user($uid,$webURL){
		$query 	= $this->db->query("SELECT * FROM `dev_web_useful` WHERE  `uID` = '".$uid."' AND `cmID` = '".$webURL."'");
		//$row 	= $query->num();
		return $query;
	}
	public function getWebReviewData($webURL){
		$query 	= $this->db->query("SELECT * FROM `dev_web_reviews` WHERE wID = '".$webURL."'");
		$row 	= $query->result_object();
		return $row;
	}
	// GET LAST REVIEW DATE	
	public function getReviewDate($webURL){
		$query 	= $this->db->query("SELECT rdate FROM `dev_web_reviews` WHERE wID = '".$webURL."' ORDER BY `rID` DESC LIMIT 0,1");
		$row 	= $query->result_object();
		return $row[0]->rdate;
	}

	public function get_reviewcounts($webURL){
		$query 	= $this->db->query("SELECT count(*) AS COUNTREVIEWS FROM `dev_web_reviews` WHERE wID = '".$webURL."'");
		$row 	= $query->result_object();
		return $row[0]->COUNTREVIEWS;
	}
	public function getusereviewsallcount($uID){
		$query 	= $this->db->query("SELECT count(*) AS COUNTREVIEWS FROM `dev_web_reviews` WHERE uID = '".$uID."'");
		$row 	= $query->result_object();
		return $row[0]->COUNTREVIEWS;
	}
	public function getusereviewsallDESC($uID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W LEFT JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE R.uID = '".$uID."' ORDER BY R.rID DESC");
		$row 	= $query->result_object();
		return $row;
	}
	public function getusereviewsall($uID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W LEFT JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE R.uID = '".$uID."'ORDER BY R.rID DESC ");
		$row 	= $query->result_object();
		return $row;
	}
	public function getusereviewsallWEBPagesorting($uID,$type,$val){
		//echo "SELECT * FROM `dev_web_website` AS W INNER JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE W.webURL = '".$uID."' ORDER BY ".$type." ".$val."";
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W INNER JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE W.webURL = '".$uID."' ORDER BY ".$type." ".$val."");
		$row 	= $query->result_object();
		return $row;
	}
	public function getusereviewsallWEBPage($uID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W INNER JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE W.webURL = '".$uID."' ORDER BY R.rID DESC");
		$row 	= $query->result_object();
		return $row;
	}
	public function getreviewuserhome($limit){
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` AS W INNER JOIN `dev_web_reviews` AS R ON W.uiD = R.uiD ORDER BY R.rID DESC LIMIT 0,".$limit."");
		$row 	= $query->result_object();
		return $row;
	}
	public function getreviewuserhomemostviewd($limit){
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` AS W INNER JOIN `dev_web_reviews` AS R ON W.uiD = R.uiD ORDER BY R.rCount DESC LIMIT 0,".$limit."");
		$row 	= $query->result_object();
		return $row;
	}
	// GET TOTAL REVIEWS
	public function gethomereviecount(){
		$query 	= $this->db->query("SELECT count(*) AS COUNTREVIEWS FROM `dev_web_reviews`");
		$row 	= $query->result_object();
		return $row[0]->COUNTREVIEWS;
	}
	// GET TOTAL WEBSITES COUNT
	public function gethomewebcount(){
		$query 	= $this->db->query("SELECT count(*) AS COUNTREVIEWS FROM `dev_web_website`");
		$row 	= $query->result_object();
		return $row[0]->COUNTREVIEWS;
	}
	// GET RECENT WEBSITES
	public function recenthomewebsites($limit){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` ORDER BY wID DESC LIMIT 0,".$limit."");
		$row 	= $query->result_object();
		return $row;
	}
	// GET REVIEW FINAL COUNT
	public function webfinalcount($wid){
		
		$query 	= $this->db->query("SELECT COUNT(*) AS RCOUNT,SUM(rRating) AS RatSUm FROM `dev_web_reviews` WHERE `wID` = '".$wid."'");
		$row 	= $query->result_object();
		return $row;
	}
	// ADD WEBSIE BOOKMARK
	public function addreviewLikes($data){
		$query = $this->db->insert('dev_web_likes', $data);
		return $query;
	}
	// CHECK REVIEW LIKE
	public function checkreviewliked($uid,$rid){
		$query 	= $this->db->query("SELECT * FROM `dev_web_likes` WHERE `uID` = '".$uid."' AND `rID` = '".$rid."'");
		return $query;
	}
	// CHECK REVIEW LIKE COUNT
	public function checkreviewlikedtotal($rid){
		$query 	= $this->db->query("SELECT COUNT(*) AS Likecount FROM `dev_web_likes` WHERE `rID` = '".$rid."'");
		$row 	= $query->result_object();
		return $row[0]->Likecount;
	}
	// REMOVE LIKE
	public function removelike($piD)
	{
		$query 	= $this->db->query("DELETE FROM `dev_web_likes` WHERE `kID` = '".$piD."'");
		return $query;
	}
	// CHECK REVIEW COMENTS COUNT
	public function checkcomplaintcommentstotal($cmID){
		$query 	= $this->db->query("SELECT COUNT(*) AS Likecount FROM `dev_web_comments` WHERE `cmID` = '".$cmID."'");
		$row 	= $query->result_object();
		return $row[0]->Likecount;
	}
	// CHECK REVIEW PHOTOS COMMENTS COUNT
	public function checkphotoscommentstotal($cmID){
		$query 	= $this->db->query("SELECT COUNT(*) AS Likecount FROM `dev_web_photos_comments` WHERE `pID` = '".$cmID."'");
		$row 	= $query->result_object();
		return $row[0]->Likecount;
	}
	// CHECK TRICS COMENTS COUNT
	public function checkTrickscommentstotal($cmID){
		$query 	= $this->db->query("SELECT COUNT(*) AS Likecount FROM `dev_web_tricks_comments` WHERE `tID` = '".$cmID."'");
		$row 	= $query->result_object();
		return $row[0]->Likecount;
	}
	// CHECK GROUP POST
	public function checkGroupDiscussion($cmID){
		$query 	= $this->db->query("SELECT COUNT(*) AS Likecount FROM `dev_web_groups_discussion` WHERE `gID` = '".$cmID."'");
		$row 	= $query->result_object();
		return $row[0]->Likecount;
	}
	
	// CHECK QUESTION ANSWERS COUNT
	public function checkQuestioncommentstotal($cmID){
		$query 	= $this->db->query("SELECT COUNT(*) AS Likecount FROM `dev_web_answers` WHERE `qID` = '".$cmID."'");
		$row 	= $query->result_object();
		return $row[0]->Likecount;
	}
	// CHECK USER TOTAL COMENTS COUNT
	public function checkusercommentstotal($uid){
		$query 	= $this->db->query("SELECT COUNT(*) AS Likecount FROM `dev_web_comments` WHERE `uID` = '".$uid."'");
		$row 	= $query->result_object();
		return $row[0]->Likecount;
	}
	// GET ALL COMMENTS OF REVIEWS
	public function getspecificomplaintcomments($comID,$sort){
		$query 	= $this->db->query("SELECT * FROM `dev_web_comments` AS C INNER JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.cmID = '".$comID."' ORDER BY cID ".$sort."");
		$row 	= $query->result_object();
		return $row;
	}
	// GET SUBSCRIBED USERS INFO
	public function getSubscribedUserInfo($comID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_subscription` AS C INNER JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.cmID = '".$comID."'");
		//$row 	= $query->result_object();
		return $query;
	}
	// GET SUBSCRIBED USERS INFO
	public function getSubscribedUserInfoWithCOmpID($comID,$uID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_subscription` WHERE `cmID` = '".$comID."' AND `uID` = '".$uID."'");
		//$row 	= $query->result_object();
		return $query;
	}
	// GET ALL PHOTOS COMMENTS OF REVIEWS
	public function getspecifiphotoscomments($comID,$sort){
		$query 	= $this->db->query("SELECT * FROM `dev_web_photos_comments` AS C INNER JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.pID = '".$comID."' ORDER BY pcID ".$sort."");
		$row 	= $query->result_object();
		return $row;
	}
	// GET ALL COMMENTS OF TRICKS
	public function getspecifiTrickscomments($comID,$sort){
		$query 	= $this->db->query("SELECT * FROM `dev_web_tricks_comments` AS C INNER JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.tID = '".$comID."' ORDER BY tcID ".$sort."");
		$row 	= $query->result_object();
		return $row;
	}
	// GET ALL DISCUSSION  OF GROUP
	public function getspecifigroupDiscussion($comID,$sort){
		$query 	= $this->db->query("SELECT * FROM `dev_web_groups_discussion` AS C INNER JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.gID = '".$comID."' ORDER BY gID ".$sort."");
		$row 	= $query->result_object();
		return $row;
	}
	// GET ALL QUESTIONS ANSWERS SPECIIC 
	public function getspecificQuestAnswer($comID,$sort){
		$query 	= $this->db->query("SELECT * FROM `dev_web_answers` AS C INNER JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.qID = '".$comID."' ORDER BY qID ".$sort."");
		$row 	= $query->result_object();
		return $row;
	}
	// GET Comment Exist or not
	public function checkcommentexist($cid){
		$query 	= $this->db->query("SELECT * FROM `dev_web_votes` WHERE cID = '".$cid."' AND `uID` = '".UID."'");
		//$row 	= $query->num_rows();
		return $query;
	}
	
	// GET LATEST QUESTION COUNT 5
	public function getLatestQuestions(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_questions` WHERE qStatus = '1' ORDER BY `qID` DESC LIMIT 0,5");
		$row 	= $query->result_object();
		return $row;
	}
	
	// GET USER QUESTIONS
	public function getUserpostedQuestion($uid){
		$query 	= $this->db->query("SELECT * FROM `dev_web_questions` WHERE qStatus = '1' AND `uID` = '".$uid."' ORDER BY `qID` DESC");
		//$row 	= $query->result_object();
		return $query;
	}
	
	// GET LATEST COMPLAINTS WITH COMMENTS COUNT 5
	public function getLatestComplaintswithComments(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_complaints` AS C INNER JOIN `dev_web_comments` AS U ON C.`cmID`=U.`cmID` WHERE C.`cVid` = 0 GROUP BY U.`cmID` ORDER BY `cDate` DESC");
		$row 	= $query->result_object();
		return $row;
	}
	
	// GET COMPLAINTS WITH COMMENTS OF USERS
	public function getUserCommentsonComplants($uid){
		$query 	= $this->db->query("SELECT * FROM `dev_web_complaints` AS C INNER JOIN `dev_web_comments` AS U ON C.`cmID`=U.`cmID` WHERE U.`uID` = '".$uid."' ORDER BY U.`cID` DESC");
		//$row 	= $query->result_object();
		return $query;
	}
	
	// GET LATEST GROUPS COUNT 5
	public function getLatestGroups(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_groups` WHERE `gStatus` = '1' ORDER BY `gID` DESC LIMIT 0,5");
		$row 	= $query->result_object();
		return $row;
	}
	// GET WORST RATING
	public function getWorstRating(){
		$query 	= $this->db->query("SELECT SUM(vCount) AS COUNTRATE, C.* FROM `dev_web_votes` AS V INNER JOIN `dev_web_comments` AS C ON V.`cID` = C.`cID` GROUP BY V.`cID` ORDER BY COUNTRATE ASC");
		$row 	= $query->result_object();
		return $row;
	}
	// ADD VOTES AGANST OMMENT
	public function add_vote_comment($data){
		$this->db->insert('dev_web_votes', $data);
	}
	// UPDATE VOTES COUNT
	public function remove_same_votes_comment($piD,$content){
		$query = $this->db->query("DELETE FROM `dev_web_votes` WHERE `cID` = '".$piD."' AND `uID` = '".$content."'");
		return $query;
	}
	
	// GET VOTES TOTAL COUNT
	public function geTotalCountVotes($cid){
		$query 	= $this->db->query("SELECT SUM(vCount) AS COUNTRATE FROM `dev_web_votes` WHERE `cID` = '".$cid."'");
		$row 	= $query->result_object();
		return $row[0]->COUNTRATE;
	}
	
	// GET REPLIES TOTAL COUNT
	public function geTotalCountDiscussion($cid){
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTRATE FROM `dev_web_groups_replies` WHERE `dID` = '".$cid."'");
		$row 	= $query->result_object();
		return $row[0]->COUNTRATE;
	}
	public function getspecificDiscussionComments($rID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_groups_replies` AS C INNER JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.dID = '".$rID."' ORDER BY rID DESC");
		$row 	= $query->result_object();
		return $row;
	}
	public function getspecificreviewcomments2($rID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_comments` AS C LEFT JOIN `dev_web_user` AS U ON C.uID = U.uID WHERE C.rID = '".$rID."' ORDER BY cID DESC LIMIT 0,1");
		$row 	= $query->result_object();
		return $row;
	}
	// GET ALL COMMENTS OF REVIEWS
	// REMOVE Comments
	public function commentRemove($ciD)
	{
		$query 	= $this->db->query("DELETE FROM `dev_web_comments` WHERE `cID` = '".$ciD."'");
		return $query;
	}
	// GET TAGS REVIEWS
	public function gettagreviews($tags){
		//echo "SELECT * FROM `dev_web_website` AS W LEFT JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE FIND_IN_SET('".$tags."',R.`rTags`) > 0";
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W LEFT JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE FIND_IN_SET('".$tags."',R.`rTags`) > 0");
		$row 	= $query->result_object();
		return $row;
	}
	// GET REVIEWS DETAILS
	public function getreviewsingle($id){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W LEFT JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE R.`rID` = '".$id."'");
		$row 	= $query->result_object();
		return $row;
	}
// GET Category Reviews
	public function getcatreviewscategories($tags){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W LEFT JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD WHERE FIND_IN_SET('".$tags."',W.`wCategories`) > 0  ORDER BY R.`rRating` DESC LIMIT 0,3");
		$row 	= $query->result_object();
		return $row;
	}
	// GET TAGS REVIEWS
	public function getrecentreviews(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W INNER JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD ORDER BY `rID` DESC LIMIT 0,10");
		$row 	= $query->result_object();
		return $row;
	}
	// REMOVE REVIEW
	public function removeReview($rID)
	{
		$query 	= $this->db->query("DELETE FROM `dev_web_reviews` WHERE `rID` = '".$rID."'");
		return $query;
	}
	public function removeReviewComments($rID)
	{
		$query 	= $this->db->query("DELETE FROM `dev_web_comments` WHERE `rID` = '".$rID."'");
		return $query;
	}
	// GET CATEGORY NAME WEBSITE PAGE
	public function getcatwebname($cID){
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `cID` = '".$cID."'");
		$row 	= $query->result_object();
	//	return $row[0]->catName;
	return $row;
	}
	// GET WEBSITE RATING COUNTS PAGE
	public function getratingcountscharts($rate,$wid){
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTRATE FROM `dev_web_reviews` WHERE `rRating` = '".$rate."' AND `wID` = '".$wid."'");
		$row 	= $query->result_object();
		return $row[0]->COUNTRATE;
	}
	// GET BOOKMARKED
	public function getbookmarkeduser($uID,$wid){
		$query 	= $this->db->query("SELECT COUNT(*) AS COUNTRATE FROM `dev_web_bookmark` WHERE `uID` = '".$uID."' AND `wID` = '".$wid."'");
		$row 	= $query->result_object();
		return $row[0]->COUNTRATE;
	}
	// GET BOOKMARKED
	public function getbookmarkeduserdata($uID,$wid){
		$query 	= $this->db->query("SELECT * FROM `dev_web_bookmark` WHERE `uID` = '".$uID."' AND `wID` = '".$wid."'");
		$row 	= $query->result_object();
		return $row;
	}
	// REMOVE
	public function removewebbookmared($rID)
	{
		$query 	= $this->db->query("DELETE FROM `dev_web_bookmark` WHERE `bID` = '".$rID."'");
		return $query;
	}
	public function getusebookmarkwebid($uid){
		$query 	= $this->db->query("SELECT * FROM `dev_web_bookmark` AS W INNER JOIN `dev_web_website` AS R ON W.wiD = R.wiD  WHERE `uID` = '".$uid."' ORDER BY W.bID DESC");
		$row 	= $query->result_object();
		return $row;
	}
	// GET REVIEW NAME
	public function getwebName($rID)
	{
		$query 	= $this->db->query("SELECT webURL AS URLWEB FROM `dev_web_website` WHERE `wID` = '".$rID."'");
		$row 	= $query->result_object();
		return $row[0]->URLWEB;
	}
	
	// GET TOP RATED
	public function getTopRated()
	{
		$query 	= $this->db->query("SELECT COUNT(R.`rRating`) AS RAT,SUM(R.`rRating`)/COUNT(R.`rRating`) AS COUNTSUM,W.`wID` AS WID,R.*,W.* FROM `dev_web_website` AS W LEFT JOIN `dev_web_reviews` AS R ON W.wiD = R.wiD GROUP BY W.`wID` ORDER BY COUNTSUM DESC");
		$row 	= $query->result_object();
		return $row;
	}
	// GET REVIEW NAME
	public function getcategorydetails($cID)
	{
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `cID` = '".$cID."'");
		$row 	= $query->result_object();
		return $row;
	}
	// GET REVIEW NAME
	public function getcategorydetails_links($cID)
	{
		
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `catLink` = '".$cID."'");
		$row 	= $query->result_object();
		return $row;
	}
	// GET REVIEW NAME
	public function getcategorydetails_metatags($cID)
	{
		
		$query 	= $this->db->query("SELECT * FROM `dev_web_categories` WHERE `catLink` = '".$cID."'");
		//$row 	= $query->result_object();
		return $query;
	}
	public function getcatWebsites($cat){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` AS W WHERE FIND_IN_SET('".$cat."',W.`wCategories`) > 0");
		$row 	= $query->result_object();
		return $row;
	}
	public function getallfaqs(){
		$query 	= $this->db->query("SELECT * FROM `dev_web_faq` WHERE `fStatus` = '1'");
		$row 	= $query->result_object();
		return $row;
	}
	// ADD VISITORS
	public function addvisitors($data){
		$query = $this->db->insert('dev_web_visitors', $data);
		return $query;
	}
	
	public function getsearchresultsusers($search){
		$query 	= $this->db->query("SELECT * FROM `dev_web_user` WHERE `fName` LIKE '%".$search."%' OR `lName` LIKE '%".$search."%' OR `uCountry` LIKE '%".$search."%'  AND `uStatus` = '1'");
		$row 	= $query->result_object();
		return $row;
	}
	public function getsearchresultsweb($search){
		$query 	= $this->db->query("SELECT * FROM `dev_web_website` WHERE `webURL` LIKE '%".$search."%'");
		$row 	= $query->result_object();
		return $row;
	}
	// Update Ad	
	public function update_complaint_status_open($pid){
		
		$query 	= $this->db->query("UPDATE `dev_web_complaints` SET `coClose` = '1' WHERE `cmID` = '".$pid."'");
		//$row 	= $query->result_array();
		return $query;
	}
	// GET CATEGORY JOBS WITH LIMIT
	public function getCatJobs($id, $limit, $start)
	{
		$query 	= $this->db->query("SELECT U.*,C.* FROM `dev_web_complaints` AS C INNER JOIN `dev_web_user` AS U ON C.`uID` = U.`uID` AND `cmStatus` = '1' WHERE C.`cmCountry` = '".$id."' ORDER BY `cmID` DESC LIMIT ".$limit.", ".$start."");
		return $query;
	}
	// GET jOBS POSTED PER MONTH
	public function getMonthCountCharts($month,$uid)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS monthcount FROM `dev_web_jobs` WHERE MONTH(`jPostedDate`) = '".$month."' AND `uID` = '".$uid."'");
		$row 	= $query->result_object();
		return $row[0]->monthcount;
	}
	// GET CV VIEWED
	public function getcvViewedcount($uid)
	{
		$query 	= $this->db->query("SELECT COUNT(*) as cvcount, cvID FROM `dev_cv_viewed` WHERE `uID` = '".$uid."' GROUP BY cvID
");
		$row 	= $query->result_object();
		return $row;
	}
	// GET APPLIED POSTED PER MONTH
	public function getAppliedJobsCharts($month,$uid)
	{
		$query 	= $this->db->query("SELECT COUNT(*) AS monthcount FROM `dev_web_applied` WHERE MONTH(`appliedDate`) = '".$month."' AND `uID` = '".$uid."'");
		$row 	= $query->result_object();
		return $row[0]->monthcount;
	}
	
	// GET TAGS REVIEWS
	public function gettagreviewsdata($keywords){
		//echo "SELECT * FROM `dev_job_alerts` WHERE ".$keywords;
		$query = $this->db->query("SELECT * FROM `dev_job_alerts` WHERE ".$keywords);
		$row = $query->result_object();
		return $row;	
	}
	
	// SEARCH CV
	public function search_candidate_cvs($title,$job,$location,$type,$salfrom){
		
		$query = "SELECT * FROM `dev_web_cv` WHERE `pJobtitle` LIKE '%".$job."%' AND `cvView` = '1' ";
		if($title != ""){
			$query.="OR `cvTitle` LIKE '%".$title."%'";
		}
		if($location != ""){
			$query.="OR `pjoblocation` LIKE '%".$location."%'";
		}
		if($type != ""){
			$query.= "OR `pjobtype` LIKE '%".$type."%'";
		}
		if($salfrom != ""){
			$query.= "OR `psalaryfrom` LIKE '%".$salfrom."%' OR `psalaryto` LIKE '%".$salfrom."%'";
		}
		//echo $query;
		$queryshow = $this->db->query($query);
		$row = $queryshow->result_object();
		return $row;	
	}
	// SEARCH ADVANCE JOBS
	public function search_job_advance($title,$job,$location,$type,$salfrom){
		
		$query = "SELECT * FROM `dev_web_jobs` WHERE `cID` = '".$title."' AND `jJobStatus` = '1' ";
		if($title != ""){
			$query.="OR `jExpLevel` = '".$job."'";
		}
		if($location != ""){
			$query.="OR `jStartSalary` LIKE '".$location."'";
		}
		if($type != ""){
			$query.= "OR `jEndSalary` LIKE '".$type."'";
		}
		if($salfrom != ""){
			$query.= "OR `jNature` = '".$salfrom."'";
		}
		//echo $query;
		$queryshow = $this->db->query($query);
		$row = $queryshow->result_object();
		return $row;	
	}
	
	// GET RECOMMENDED 
	public function recommenededjobsrand($keywords){
		$query = $this->db->query("SELECT * FROM `dev_web_jobs` WHERE ".$keywords." AND `jJobStatus` = '1' ORDER BY RAND() LIMIT 0,4");
		$row = $query->result_object();
		return $row;	
	}
	// GET TOP VIEWED 
	public function topviewedJobs(){
		$query = $this->db->query("SELECT * FROM `dev_web_jobs` WHERE `jJobStatus` = '1' AND `jview` != '0' ORDER BY `jview` DESC LIMIT 0,4");
		$row = $query->result_object();
		return $row;	
	}
	// SEND ALERT TO THE INSTANT USERS 
	public function sendInstantAlerts($keywords){
		$query = $this->db->query("SELECT * FROM `dev_job_alerts` WHERE ".$keywords." AND `jobInstant` = '1'");
		$row = $query->result_object();
		return $row;	
	}
	// Get Last 7 days data 
	public function last7dayalerts($date,$datelast,$uid){
		$query = $this->db->query("SELECT * FROM `dev_cv_viewed` WHERE (`cvviewDate` BETWEEN '".$date."' AND '".$datelast."') AND `uID` = '".$uid."'");
		$row = $query->num_rows();
		return $row;	
	}
	// Get Last 7 days data 
	public function last7savedjobs($date,$datelast,$uid){
		$query = $this->db->query("SELECT * FROM `dev_web_saved` WHERE (`sDate` BETWEEN '".$date."' AND '".$datelast."') AND `uID` = '".$uid."'");
		$row = $query->num_rows();
		return $row;	
	}
	// Get Last 7 days data 
	public function last7jobsposted($date,$datelast,$uid){
		$query = $this->db->query("SELECT * FROM `dev_web_jobs` WHERE (`jPostedDate` BETWEEN '".$date."' AND '".$datelast."') AND `uID` = '".$uid."'");
		$row = $query->num_rows();
		return $row;	
	}
	// Get Last 7 days data 
	public function last7applicants($date,$datelast,$uid){
		$query = $this->db->query("SELECT * FROM `dev_web_applied` WHERE (`appliedDate` BETWEEN '".$date."' AND '".$datelast."') AND `jID` = '".$uid."'");
		$row = $query->num_rows();
		return $row;	
	}
	// Get Last 7 days data 
	public function last7applicantsapplied($date,$datelast,$uid){
		$query = $this->db->query("SELECT * FROM `dev_web_applied` WHERE (`appliedDate` BETWEEN '".$date."' AND '".$datelast."') AND `uID` = '".$uid."'");
		$row = $query->num_rows();
		return $row;	
	}
	// Get Last 7 days CV VIEW 
	public function last7cvViewjobs($date,$datelast,$uid){
		$query = $this->db->query("SELECT * FROM `dev_cv_viewed` WHERE (`cvviewDate` BETWEEN '".$date."' AND '".$datelast."') AND `cvID` = '".$uid."'");
		$row = $query->num_rows();
		return $row;	
	}
	// DAILY JOB ALERTS<br />
	public function dailyjobalertscrone($keywords,$date){
		$query = $this->db->query("SELECT * FROM `dev_web_jobs` WHERE (".$keywords.") AND `jPostedDate` = '".$date."'");
		$row = $query->result_object();
		return $row;	
	}
	// GET SIMILAR JOBS 
	public function simillarjobs($keywords){
		$query = $this->db->query("SELECT * FROM `dev_web_jobs` WHERE ".$keywords." AND `jJobStatus` = '1' ORDER BY RAND() LIMIT 0,5");
		$row = $query->result_object();
		return $row;	
	}
}
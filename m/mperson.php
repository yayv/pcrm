<?php 
class mperson extends model
{

	var $_password_tail;

	public function __construct()
	{
		$this->_password_tail = 'Tin7cak@';
	}

	public function getPersons($start,$limit=30)
	{
		$sql = "select * from pcrm_person order by id asc limit $start,$limit";
		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getPersonsValue($start,$limit,$strValue, $condition)
	{
		if($condition)
			$strCondition = "where ".$condition;
		else
			$strCondition = '';
		
		$sql = "select $strValue from pcrm_person $strCondition order by id asc limit $start,$limit";
		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getPersonById($id)
	{
		$sql = "select * from pcrm_person where id=$id";

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function getPersonsByIds($ids)
	{
		$strIds = implode(',',$ids);
		$sql = "select id,name,nickname from pcrm_person where id in ($strIds)";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getPersonByName($name)
	{
		$sql = "select id,name,nickname,mobile1,mobile2,comment,addtime from pcrm_person 
					where 
						name like '%$name%' or 
						nickname like '%$name%' or 
						english_name like '%$name%'";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getPersonByPhone($phone)
	{
		$sql = "select id,name,nickname,mobile1,mobile2,comment,addtime from pcrm_person 
					where 
						mobile1 like '%$phone%' or
						mobile2 like '%$phone%'";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getPersonByEmail($email)
	{
		$sql = "select id,name,nickname,mobile1,mobile2,comment,addtime from pcrm_person 
					where 
						email like '%$email%'";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getCompanyName($name)
	{
		$sql = "select company,company_address,company_zipcode from pcrm_person
					where
						company like '%$name%'";
		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function addNewPerson(
						$name,$nickname,$mobile1,$mobile2,$email,$gender,
						$vocation,$company,$department,$jobtitle,$companyaddress,$companyzipcode,
						$note)
	{
		$sql = "insert into pcrm_person(
					name, nickname, mobile1,mobile2,email,gender,
					vocation,company,department,job_title,company_address,company_zipcode,
					comment,addtime)
				values(
					'$name','$nickname', '$mobile1','$mobile2','$email','$gender',
					'$vocation','$company','$department','$jobtitle','$companyaddress','$companyzipcode',
					'$note',now())";

		$ret = $this->_db->query($sql);

		if($ret)
		{
			$id  = $this->_db->insert_id();

			return $id;
		}

		return $ret;
	}

	public function updatePerson(
						$id,$name,$nickname,$mobile1,$mobile2,$email,$gender,
						$vocation,$company,$department,$jobtitle,$companyaddress,$companyzipcode,
						$note)
	{
		$ret = $this->_db->fetch_one_assoc("select addtime from pcrm_person where id=$id");
		$addtime = $ret['addtime'];
		$sql = "replace into pcrm_person(
					id,name, nickname, mobile1,mobile2,email,gender,
					vocation,company,department,job_title,company_address,company_zipcode,
					comment,addtime)
				values(
					$id,'$name','$nickname', '$mobile1','$mobile2','$email','$gender',
					'$vocation','$company','$department','$jobtitle','$companyaddress','$companyzipcode',
					'$note','$addtime')";

		$ret = $this->_db->query($sql);

		if($ret)
		{
			$id  = $this->_db->insert_id();

			return $id;
		}

		return $ret;
	}

	public function updateText()
	{

	}

	public function findInText()
	{

	}

	public function addStage($userid,$start,$end,$desc)
	{
		$sql = "insert into pcrm_person_stage(personid,start,end,desc) 
				values($userid,'$start','$end','$desc')";

		$ret = $this->_db->query($sql);

		return $ret;
	}
}

<?php 
class moperson extends model
{
	public function getPersonNameList()
	{
		$sql = "select 
					id,name,nickname,source_id,source_name,source_type,source_relationship 
				from 
					pcrm_person_old
				where id>0";

		$result = $this->_db->fetch_all_assoc($sql);find

		return $result;
	}

	public function getCustomList()
	{
		$sql = "select 
					id,name,nickname,source_id,source_name,source_type,source_relationship 
				from 
					pcrm_person_old
				";

		$result = $this->_db->fetch_all_assoc($sql);

		return $result;
	}

	public function getThousandKill()
	{
		$sql = "select * from pcrm_person_old where id>0" ;

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function countNewpersonByDay()
	{
		$sql = "select count(id) num,addtime from pcrm_person_old group by addtime order by addtime desc limit 30";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function addNewPerson($name)
	{
		$sql = "insert into pcrm_person_old(name, nickname, addtime)
				values('$name','$name', now())";

		$ret = $this->_db->query($sql);

		if($ret)
		{
			$id  = $this->_db->insert_id();

			return $id;
		}

		return $ret;
	}

	public function updateSource($id, $source_id, $source_name, $source_type, $source_relationship)
	{
		$sql = "update pcrm_person_old set 
					source_type='$source_type', 
					source_id='$source_id', 
					source_name='$source_name', 
					source_relationship='$source_relationship'
				where
					id=$id
				";		

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function getPersonIdByName($name)
	{
		$sql = "select id from pcrm_person_old where name='$name'";

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret['id'];
	}

	public function getPersonNameById($id)
	{
		$sql = "select name from pcrm_person_old where id=$id";

		$ret = $this->_db->fetch_one_assoc($sql);

		if($ret)
			return $ret['name'];
		else
			return false;
	}

	public function getPersonNamesLike($name)
	{
		$sql = "select id,name,nickname from pcrm_person_old where name like '$name%'";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getPersonSourceById($id)
	{
		$sql = "select id, name, nickname, source_type, source_name, source_id, source_relationship from pcrm_person_old where id=$id";

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function setOwner($name)
	{
		$sql = "replace into pcrm_person_old(id, name) values(0,'$name')";

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function getPersonById($id)
	{
		$sql = "select * from pcrm_person_old where id=$id";

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function updateBasic(
				$personid, $name, $nickname, $englishname, $gender, $birthday, $confirm_birthday, 
				$household_register,$idcard_type, $idcard_no, $mobile1,$mobile2,$mobile3,$email1,$email2,
				$hometown, $nature,$attitude,
				$bank1,$account1,$bank2,$account2,$bank3,$account3,
				$address,$address_zipcode, $company,$company_address,$company_zipcode,
				$income,$vocation,$department,$job, $jobtitle, $residence, $marital,$children,
				$acquaint_time,$contact_degree,$meet_times,$engagement_diffcult,
				$recommend_ability
				)
	{
		$sql = "update pcrm_person_old set 
					nickname='$nickname',name='$name',`english_name`='$englishname',
					gender='$gender',birthday='$birthday',confirm_birthday=$confirm_birthday,
					household_register='$household_register',
					idcard_type='$idcard_type',idcard_no='$idcard_no',
					mobile1='$mobile1',mobile2='$mobile2',mobile3='$mobile3',
					email1='$email1', email2='$email2', 
					hometown='$hometown', nature='$nature', attitude='$attitude',
					address='$address', address_zipcode='$address_zipcode',
					bank1='$bank1',account1='$account1',bank2='$bank2',account2='$account2',bank3='$bank3',account3='$account3',
					company='$company',company_address='$company_address',company_zipcode='$company_zipcode',
					income='$income',
					vocation='$vocation', department='$department',job='$job', job_title='$jobtitle',residence='$residence',
					marital='$marital',children='$children',acquaint_time='$acquaint_time',
					contact_degree='$contact_degree',meet_times='$meet_times',
					engagement_diffcult='$engagement_diffcult',recommend_ability='$recommend_ability'
				where id=$personid";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function updateComment($id,$comment)
	{
		$sql = "update pcrm_person_old set comment='$comment' where id=$id";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function updateLastContact($personid,$date)
	{
		if($date=='today')
		{
			$day = date('Y-m-d');	
		}
		else if($date=='yestoday')
		{
			$day = date('Y-m-d',time()-3600*24);
		}
		else
		{
			$day = $date ;
		}
		
		$sql = "update pcrm_person_old set lastcontact='$day' where id=$personid";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function updateCustomLevel($personid, $newlevel)
	{
		$sql = "update pcrm_person_old set customlevel='$newlevel' where id=$personid";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function getOwner()
	{
		return $this->getPersonById(0);
	}

	// TODO: move this method to mlogtodonotify
	public function getAccessLog($personid)
	{
		$sql = "select * from pcrm_contact_log where person_id=$personid order by id desc";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	// TODO: move this method to mlogtodonotify
	public function getPersonByBirthday()
	{
		$sql = "SELECT *, year(curdate())-year(birthday) age FROM `pcrm_person_old` WHERE 
					dayofyear(curdate())<dayofyear(birthday)  and 
					dayofyear(curdate())+130>dayofyear(birthday)";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getLifeSection($personid)
	{
		$sql = "SELECT * FROM `pcrm_person_section` where personid=$personid order by start desc";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}
}

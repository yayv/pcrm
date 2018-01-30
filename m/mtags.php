<?php 
class mtags extends model
{
	public function __construct()
	{
		
	}

	public function getAllTags()
	{
		$sql = "select id, tagname from pcrm_tags order by id";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function fillNotTagPerson()
	{
		$sql = "select id from pcrm_person where id not in ( SELECT personid FROM `pcrm_tags_persontags`)";
		$ret = $this->_db->fetch_all_assoc($sql);

		foreach($ret as $k=>$v)
		{
			$personid = $v['id'];
			$sql = "insert into pcrm_tags_persontags(`personid`,`tags`) values($personid,'')";	
			$this->_db->query($sql);
		}
	}	

	public function getPersonsWithoutTag()
	{
		$sql = "select * from pcrm_tags_persontags where tags=''";
		$ret = $this->_db->fetch_all_assoc($sql);

		$personids = array();
		if($ret)
		foreach($ret as $k=>$v)
		{
			$personids[] = $v['personid'];
			
		}

		return $personids;
	}

	public function getTagsById($id)
	{
		$sql = "select tags from pcrm_tags_persontags where personid=$id";
		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret['tags'];
	}

	public function addNewTags($tags)
	{
		$strTags = '("'.implode('"),("',$tags).'")';

		$sql = "insert into `pcrm_tags`(`tagname`) values $strTags";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function formatTags($tags)
	{
		foreach($tags as $k=>$v)
		{
			$tags[$k] = trim($v);
		}

		$strTags = "'".implode("','",$tags)."'";
		
		$sql = "select * from pcrm_tags where tagname in ($strTags)";

		$exists = $this->_db->fetch_all_assoc($sql);

		$arrExists = array();

		if($exists)
		foreach ($exists as $key => $value) 
		{
			$arrExists[] = $value['tagname'] ;
		}

		$result = array_diff($tags, $arrExists);

		if(count($result)>0)
			$this->addNewTags($result);

		$exists = $this->_db->fetch_all_assoc($sql);

		return $exists;
	}

	public function updateTagsForId($personid, $strTags, $tags)
	{
		$sql = "replace into pcrm_tags_persontags(`personid`,`tags`) values($personid,'$strTags')";

		$ret = $this->_db->query($sql);

		if($ret)
		{
			$sql = "delete from pcrm_tags_personid where personid=$personid";
			$ret = $this->_db->query($sql);
			foreach($tags as $k=>$v)
			{
				$id  = $v['id'];
				$sql = "insert into `pcrm_tags_personid`(`id`,`personid`) values($id,$personid)";
				$ret = $this->_db->query($sql);
			}
		}

		return $ret;
	}

	public function getPersonsIdByTag($tag)
	{
		$sql = "select personid from pcrm_tags_personid where id in (select id from pcrm_tags where tagname='$tag')";

		$ret = $this->_db->fetch_all_assoc($sql);
		$personids = array();

		if($ret)
		foreach($ret as $k=>$v)
		{
			$personids[] = $v['personid'];
			
		}

		return $personids;
	}

	public function isTag($tag)
	{
		$sql = "select * from pcrm_tags where tagname = '$tag'";
		$ret = $this->_db->fetch_one_assoc($sql);
		return $ret;
	}
}

<?php 
// 这个类作为个人信息的扩展类吧，使用key-value方式进行信息管理
class mpersoninfo extends model
{


	public function __construct()
	{
	}

	public function getInfoById($id)
	{
		$sql = "select * from pcrm_person_info where id=$id";

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function saveText($personid, $text)
	{
		$sql = "update pcrm_person_infotext set `text`='$text' where personid=$personid";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function getText($personid)
	{
		$sql = "select * from pcrm_person_infotext where personid=$personid" ;

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function parseTextToKeyValue($personid)
	{

	}

	public function generateTextFromKeyValue($personid)
	{

	}

	public function updateValueForKeyById($id, $key, $value)
	{
		
	}

	public function updateAllInfo($id)
	{

	}

}

<?php
include_once('mplugins_interface.php');

class mpersoninfoex extends mplugins_interface
{
	
	public function getPanelInfo()
	{
		return array(
				'name'=>"个人信息",
				'code'=>"infoex",
				'template'=>"plugin_personinfoex.tpl.html",
			);
	}

	public function getPanelValue($panelname,$person)
	{
		switch($panelname)
		{
			case 'personinfo':
				$t = $this->getPersoninfoExText($person['id']);	
				return $t;
				break;
			default:
				break;
		}
		return false;
	}

	public function getPersoninfoEx($personid)
	{

	}

	public function getPersoninfoExText($personid)
	{
		$sql = "select * from pcrm_personinfoex_text where personid=$personid";
		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function updatePersoninfoExText($personid,$personinfoextext)
	{
		$sql = "replace into pcrm_personinfoex_text(`personid`,`infoex_text`) values($personid,'$personinfoextext')";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function parseText()
	{

	}

	public function exportText()
	{

	}
}


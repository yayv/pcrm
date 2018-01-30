<?php
include_once('mplugins_interface.php');

class mlifestage extends mplugins_interface
{
	public function getPanelInfo()
	{
		return array(
				'name'=>"人生经历",
				'code'=>"lifestage",
				'template'=>"plugin_lifestage.tpl.html",
			);
	}

	public function getPanelValue($panelname,$personid)
	{
		return false;
	}

	public function getLifeStagesForPerson()
	{

	}	

	public function addLifeStageForPerson()
	{

	}

	public function getLifeStagesByDateForPerson()
	{

	}

	// 根据时间段和所在公司，寻找客户之间的关系
	public function matchLifeStageByCompany()
	{

	}

	// 根据时间段，和地点寻找客户们之间的关系
	public function matchLifeStageByCity()
	{

	}
}

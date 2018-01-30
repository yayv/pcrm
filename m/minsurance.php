<?php
include_once('mplugins_interface.php');

class minsurance extends mplugins_interface
{
	
	public function getPanelInfo()
	{
		return array(
				'name'=>"保障信息",
				'code'=>"insurance",
				'template'=>"plugin_insurance.tpl.html",
			);
	}

	public function getPanelValue($panelname,$personid)
	{
		return false;
	}

}


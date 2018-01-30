<?php
include_once('mplugins_interface.php');

class mrelationship extends mplugins_interface
{
	
	public function getPanelInfo()
	{
		return array(
				'name'=>"社会关系",
				'code'=>"relationship",
				'template'=>"plugin_relationship.tpl.html",
			);
	}

	public function getPanelValue($panelname,$personid)
	{
		return false;
	}

}


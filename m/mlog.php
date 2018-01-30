<?php 
include_once('mplugins_interface.php');
// TODO: 那，生日和提醒的处理逻辑应该有所不同。
// 生日，检查是否已经存在，存在，且不同的，则更新
// 提醒，根据提醒类型，自动更改日期为下次提醒时间，过期1-3天后更改，具体看配置吧
class mlog extends mplugins_interface
{
	public function __construct()
	{
		
	}

	public function getPanelInfo()
	{
		return array(
				'name'=>"提醒",
				'code'=>"logtodonotify",
				'template'=>"plugin_logtodonotify.tpl.html",
			);
	}

	public function getPanelValue($panelname,$person)
	{
		switch($panelname)
		{
			case 'personinfo':
				return $this->getLogs($person['id']);	
				break;
			default:
				break;
		}
		return false;
	}

	// TODO: 根据当前日期，获得全部提醒信息, 当参数为false时，选择未来七天内的提醒
	public function getAllByDate($date=false)
	{
		if(!$date)
			$date=date('Y-m-d',time()+3600*24*7);

		// 
	}

	// TODO: 对于全部提醒和生日，更新到距离今天最近的一次提醒
	public function updateAllNotify()
	{
		// TODO: how to do ?
	}

	public function getLogTodoNotifis($personid, $type)
	{
		$sql = "select * from pcrm_person_logtodonotify where person_id=$personid and `type` like '$type'";

		$ret = $this->_db->fetch_all_assoc($sql);

		return $ret;
	}

	public function getLogs($personid)
	{
		return $this->getLogTodoNotifis($personid,'log');
	}

	public function getTodos($personid)
	{
		return $this->getLogTodoNotifis($personid,'todo');
	}

	public function getDones($personid)
	{
		return $this->getLogTodoNotifis($personid,'done');
	}

	public function getBirthday($personid)
	{
		return $this->getLogTodoNotifis($personid,'birthday');
	}

	public function getNotifies($personid)
	{
		return $this->getLogTodoNotifis($personid,'noti_%');
	}

	public function getAllThingsTodo($personid)
	{
		// TODO: 这里获得未来一定时期内，所有需要做和需要准备的事情，如todo, 生日和提醒
		// 1. 所有的TODO, 按列内日期，提前n天
		// 2. 所有的提醒, 按提醒日期，提前n天。对已经过期的，且没有结束标志的，进行周期性日期修改
		// 3. 所有的生日, 按列内日期，提前n天
		// 4. 混排？
	}

	// .....
	public function addTodo($personid,$personname,$date,$note)
	{
		$type = "todo";
		$sql = "insert into pcrm_person_logtodonotify
					(`person_id`,`person_name`,`date`,`type`,`content`) 
				values
					($personid,'$personname','$date','$type','$note') 
				";

		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function addNotify($personid,$personname,$date,$note,$t)
	{
		// TODO: 完善这个功能，实现
		$type = array("noti_year","noti_month","noti_week");
		if(!in_array($t, $type))
		{
			return false;
		}

		$sql = "insert into pcrm_person_logtodonotify
					(`person_id`,`person_name`,`date`,`type`,`content`) 
				values
					($personid,'$personname','$date','$t','$note') 
				";
		$ret = $this->_db->query($sql);
		return $ret;
	}

	public function addBirthday($personid,$personname,$date)
	{
		// TODO: 检查这个客户是不是已经有生日了
		$type = "birthday";
		$sql = "select * from pcrm_person_logtodonotify where person_id=$personid and `type`='$type'";
		$ret = $this->_db->fetch_one_assoc($sql);
		#echo '<pre>';print_r($ret);die();
		$sql = "insert into pcrm_person_logtodonotify
					(`person_id`,`person_name`,`date`,`type`,`content`) 
				values
					($personid,'$personname','$date','$type','$note') 
				";
		$ret = $this->_db->query($sql);
		return $ret;
	}

	// 
	// TODO: move this method to mlogtodonotify
	public function addLog($personid, $personname, $date, $note)
	{
		$type= 'log';
		$sql = "insert into pcrm_person_logtodonotify(`person_id`,`person_name`,`date`,`type`,`content`) 
				values($personid,'$personname','$date','$type','$note') 
				";
		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function doneTodo($id)
	{
		$sql = "update pcrm_person_logtodonotify set status='done' where id=$id";
		$ret = $this->_db->query($sql);

		return $ret;
	}

	public function doneNotify()
	{

	}

	public function doneBirthday()
	{

	}
}

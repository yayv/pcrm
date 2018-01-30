<?php 
class muser extends model
{

	var $_password_tail;

	public function __construct()
	{
		$this->_password_tail = 'Tin7cak@';
	}

	public function checkEmail($email)
	{
		$sql = "select count(*) c from t_users where email='$email'";

		$ret = $this->_db->fetch_one_assoc($sql);

		return $ret;
	}

	public function isValidateUser($email, $pass)
	{

		$pass = $pass. $this->_password_tail;
		$sql = "select passwd p1,md5('$pass') p2 from t_users where email='$email' ";

		$ret = $this->_db->fetch_one_assoc($sql);

		if($ret)
		{
			if($ret['p1'] == $ret['p2'])
				return true;
		}

		return false;
	}


}

<?php
	class authModel{
		private $auth = '';	//当前管理员信息
		
		public function __construct(){
			if(isset($_SESSION['auth']) && (!empty($_SESSION['auth']))){
				$this->auth = $_SESSION['auth'];
			}
		}

		public function loginsubmit(){		//进行登录验证的一系列业务逻辑
			if(empty($_POST['username']) || empty($_POST['password'])){
				return false;
			}

			$username = addslashes($_POST['username']);
			$password = addslashes($_POST['password']);

			//用户的验证操作-----拆分到另一个方法里面去写，减少这个方法的代码量
			
			if($this->auth = $this->checkuser($username,$password)){
				$_SESSION['auth'] = $this->auth;
				return true;
			}
			else{
				return false;
			}
		}

		private function checkuser($username,$password){
			$adminobj = M('admin');
			$auth = $adminobj->findOne_by_username($username);

			if(!empty($auth) && $auth['user_password'] == $password){
				return $auth;
			}
			else{
				return false;
			}
		}
		
		/*
		 *		获取auth函数
		 */
		public function getauth(){
			return $this->auth;
		}
		
		/*
		 *		退出登录
		 */
		public function logout(){
			unset($_SESSION['auth']);
			$this->auth = '';
		}
	}
?>
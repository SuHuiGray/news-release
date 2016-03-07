<?php
	class adminController{
		function test(){
			echo "hello";
		}

		public $auth = '';

		public function __construct(){

			//判断当前是否登录 ----auth模型去处理

			//如果不是登录页而且么有登录，就要跳转到登录页
			$authobj = M('auth');
			$this->auth = $authobj->getauth();
			if(empty($this->auth) && (PC::$method != 'login')){
				$this->showmessage("please login first","admin.php?controller=admin&method=login");
			}
		}

		public function login(){
			if(isset($_POST) && !empty($_POST)){
				//进行登录处理
				//登录处理的业务逻辑放在admin auth
				//admin同表名的模型：从数据库里取用户信息
				//auth模型：进行用户信息核对
				//把一系列的登录操作放到其他的方法里
				$this->checklogin();
			}
			else{
				//显示登陆界面
				VIEW::display("login.html");
			}
		}

		private function checklogin(){
			$authobj = M('auth');
			if($authobj->loginsubmit()){
				$this->showmessage("login success~","admin.php?controller=admin&method=index");
			}
			else{
				$this->showmessage("login falied","admin.php?controller=admin&method=login");
			}
		}

		private function showmessage($message,$url){
			echo "<script>alert('$message');window.location.href='$url'</script>";
			exit();
		}

		public function index(){
			$newsobj = M('news');
			$newsnum = $newsobj->count();
			VIEW::assign(array('newsnum'=>$newsnum));
			VIEW::display('index.html');
		}

		/*
		 *新闻的添加和修改
		*/
		public function newsadd(){
			//先判断是否有传递过来的数据
			if(empty($_POST) ){	//没有post数据
				//获取旧信息，业务逻辑层,传递新闻id，如果$_GET['id'],说明是修改
				if(isset($_GET['id'])){
					$data = M('news')->getnewsinfo($_GET['id']);
				}
				else{
					$data =array();
				}
				VIEW::assign(array('data'=>$data));
				VIEW::display('newsadd.html');
			}
			else{	//进入添加，修改处理程序
				$this->newssubmit();
			}
		}

		/*
		 *退出登录
		*/
		public function logout(){
			$authobj = M('auth');
			$authobj->logout();
			$this->showmessage('logout success~',"admin.php?controller=admin&method=login");
		}

		/*
		 *判断result的值，做相应的提示
		*/
		private function newssubmit(){
			$newsobj = M('news');
			$result = $newsobj->newssubmit($_POST);
			if($result == 0){
				$this->showmessage('please add title or content','admin.php?controller=admin&method=newsadd&id='.$_POST['id']);
			}
			if($result == 1){
				$this->showmessage('add success','admin.php?controller=admin&method=newslist');
			}
			if($result == 2){
				$this->showmessage('edit success','admin.php?controller=admin&method=newslist');
			}
		}

		/*
		 *按照时间顺序输出新闻列表
		*/
		public function newslist(){
			$newsobj = M('news');
			$data = $newsobj->findAll_orderby_dateline();
			VIEW::assign(array('data'=>$data));
			VIEW::display('newslist.html');
		}

		/*
		 *新闻删除功能
		 */
		public function newsdel(){
			if(!empty($_GET['id'])){
				$id = intval($_GET['id']);
				if(M('news')->newsdel($id)){
					$this->showmessage('delete success~',"admin.php?controller=admin&method=newslist");
				}
				else{
					$this->showmessage('delete fail~',"admin.php?controller=admin&method=newslist");
				}
			}
		}
	}
?>
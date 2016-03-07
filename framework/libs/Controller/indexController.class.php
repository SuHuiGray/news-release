<?php
	class indexController{
		function index(){
			$newsobj = M('news');
			$data = $newsobj->get_news_list();
			$this->showabout();
			VIEW::assign(array('data'=>$data));
			VIEW::display('newsshow.html');
		}

		/*
		 *新闻的详情页面
		 */
		 public function newsshow(){
			$newsobj = M('news');
			if(!empty($_GET['id']))
				$id = intval($_GET['id']);
			else
				$id = 0;
			$data = $newsobj->getnewsinfo($id);
			$this->showabout();
			VIEW::assign(array('data'=>$data));
			VIEW::display('show.html');
		 }

		/*
		 *关于我们的显示
		 */
		private function showabout(){
			$data = M('about')->aboutinfo();
			VIEW::assign(array('about'=>$data));
		 }
	}
?>
<?php
	class testController{//控制器的作用是调用模型，并调用视图，将模型产生的数据传递给视图，并让相关视图取显示
		public function show(){
		/*
			$testModel = M('test');
			$data = $testModel->get();
			$testView = V('test');
			$testView->display($data);
		*/
			global $view;
			$testModel = M('test');
			$data = $testModel->get();

			$view->assign('str','hahahah');
			$view->display('test2.tpl');
		}
	}
?>
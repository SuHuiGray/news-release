<?php
	class newsModel{
		public $table = 'news';

		function count(){
			$sql = "select count(*) from ".$this->table;
			return DB::findResult($sql,0,0);
		}

		/*
		 *读取新闻内容
		*/
		public function getnewsinfo($id){
			if(empty($id)){
				return array();
			}
			else{
				$id = intval($id);	//将id转换成整型，放置sql注入
				$sql = 'select * from '.$this->table.' where id='.$id;
				return DB::findOne($sql);
			}
		}

		public function newssubmit($data){
			extract($data);
			if(empty($title) || empty($content)){
				return 0;
			}
			$title = addslashes($title);
			$content = addslashes($content);
			$athor = addslashes($author);
			$from = addslashes($from);
			$data = array(
				'title'=>$title,
				'content'=>$content,
				'author'=>$author,
				'from'=>$from,
				'dateline'=>time()
			);
			if($_POST['id'] != ''){
				DB::update($this->table,$data,'id='.$id);
				return 2;
			}
			else{
				DB::insert($this->table,$data);
				return 1;
			}
		}

		/*
		 *按照时间顺序获取新闻
		 */
		public function findAll_orderby_dateline(){
			$sql = "select * from ".$this->table." order by dateline desc";
			 return DB::findAll($sql);
		}

		/*
		 *删除新闻
		 */
		public function newsdel($id){
			return DB::del($this->table,"id=".$id);
		}

		/*
		 *获取新闻列表
		 */
		 function get_news_list(){
			$data = $this->findAll_orderby_dateline();
			foreach($data as $key=>$news){
				$data[$key]['content'] = mb_substr(strip_tags($data[$key]['content']), 0, 200);
				$data[$key]['dateline'] = date('Y-m-d H:i:s',$data[$key]['dateline']);
			}
			return $data;
		 }
	}
?>
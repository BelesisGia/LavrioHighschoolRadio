<?php
	
	if (isset($_GET['action']) && $_GET['action'] == 'getArticle'){
		echo json_encode(NewsArticles::Get($_GET['index']),JSON_UNESCAPED_UNICODE);
		die();
	}

	class NewsArticles{

		public static function Add($title,$content,$useDate){
			if (empty($title) || empty($content)){
				return;
			}
			if ($useDate){
				$article = (object) ['title' => $title,'content' => $content, 'date' => date('d/m/Y')];
			}
			else{
				$article = (object) ['title' => $title,'content' => $content];
			}

			$news_file = file_get_contents('../api/news.json');
			$news = json_decode($news_file,true);

			array_unshift($news, $article);

			$json = json_encode($news,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			file_put_contents('../api/news.json', $json);
		}

		public static function Remove($index){
			$news_file = file_get_contents('../api/news.json');
			$news = json_decode($news_file,true);

			unset($news[$index]);

			$json = json_encode(array_values($news),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			file_put_contents('../api/news.json', $json);
		}

		public static function EditArticle($index,$title,$content,$useDate){
			$news_file = file_get_contents('../api/news.json');
			$news = json_decode($news_file,true);

			$news[$index]['title'] = $title;
			$news[$index]['content'] = $content;
			$news[$index]['date'] = date('d/m/Y');

			if (!$useDate){
				unset($news[$index]['date']);
			}

			$json = json_encode(array_values($news),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			file_put_contents('../api/news.json', $json);
		}

		public static function Get($index){
			$news_file = file_get_contents('../api/news.json');
			$news = json_decode($news_file,true);
			return $news[$index];
		}
	}

	class Admin{
		public static function AddOP($username,$password){
			if (empty($username) || empty($password)){
				return;
			}

			$new_op = (object) ['username' => $username,'password' => $password];

			$ops_json = file_get_contents('ops.json');
			$ops = json_decode($ops_json,true);

			$ops[] = $new_op;

			$json = json_encode($ops,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			file_put_contents('ops.json', $json);
		}

		public static function RemoveOP($index){
			if ($index == 0) return;
			$ops_json = file_get_contents('ops.json');
			$ops = json_decode($ops_json,true);

			unset($ops[$index]);

			$json = json_encode(array_values($ops),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			file_put_contents('ops.json', $json);
		}
	}
?>
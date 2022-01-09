<?php 
	session_start();
	if (!$_SESSION['loggedIn']){
		header('Location: login.php');
	}

	include('actions.php');

	//Action DeleteArticle
	if (isset($_POST['action']) && $_POST['action'] == 'deleteArticle'){
		NewsArticles::Remove($_POST['delete_index']);
	}
	//Action AddArticle
	if (isset($_POST['action']) && $_POST['action'] == 'addArticle'){
		if (isset($_POST['useDate'])){
			NewsArticles::Add($_POST['title'],$_POST['content'],true);
		}
		else NewsArticles::Add($_POST['title'],$_POST['content'],false);
	}
	//Action editArticle
	if (isset($_POST['action']) && $_POST['action'] == 'editArticle'){
		if (isset($_POST['useDate'])){
			NewsArticles::EditArticle($_POST['index'],$_POST['title'],$_POST['content'],true);
		}
		else NewsArticles::EditArticle($_POST['index'],$_POST['title'],$_POST['content'],false);
	}
	//Action RemoveOP
	if (isset($_POST['action']) && $_POST['action'] == 'RemoveOP'){
		Admin::RemoveOP($_POST['id']);
	}
	//Action AddOP
	if (isset($_POST['action']) && $_POST['action'] == 'AddOP'){
		Admin::AddOP($_POST['username'],$_POST['password']);
	}
?>

<?php 
	$news_file = file_get_contents('../api/news.json');
	$news = json_decode($news_file);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Tools</title>

	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

	<script type="text/javascript">
		window.onbeforeunload = function(event){
			xmlHttp = new XMLHttpRequest();
			xmlHttp.open("GET","./logout.php",true);
			xmlHttp.send();
		};

		document.addEventListener('DOMContentLoaded', function() {
		    var elems = document.querySelectorAll('.modal');
		    var instances = M.Modal.init(elems, {dismissible: false});
		});

		function EditArticleModal(index){
			xmlHttp = new XMLHttpRequest();
			xmlHttp.open("GET","./actions.php?action=getArticle&index=" + index,true);
			xmlHttp.onload = function(){
				var title = document.getElementById('editArticleTitle');
				var content = document.getElementById('editArticleContent');
				var indexInput = document.getElementById('editArticleIndex');
				var useDate = document.getElementById('useDate');

				var article = JSON.parse(xmlHttp.responseText);
				title.value = article.title;
				content.value = article.content;
				indexInput.value = index;
				if ('date' in article){
					useDate.setAttribute('checked','checked');
				}
				else{
					useDate.removeAttribute('checked','checked');
				}
			};
			xmlHttp.send();
		}
	</script>
	<style type="text/css">
		label{
			font-size: 20px;
		}
		textarea{
			resize: vertical;
			min-height: 12em;
			outline: none;
			border: 1px solid #9e9e9e;
			padding: 4px;
		}
		li > a{
			margin-bottom: 1em;
		}
		.btn{
			text-transform: unset !important;
		}
		.inline-block{
			display: inline-block;
		}
	</style>
</head>
<body style="padding: 5em;" class="amber lighten-5">
	<h3 class="center">Lavrio Highschool Radio <span class="red-text text-darken-1">Web Tools</span></h3>

	<!-- News Articles -->
	<div class="container left" style="width: 30%;">
		<h4>News Articles:</h4>
		<div class="divider"></div>

		<a class="btn waves-effect modal-trigger" href="#addArticle" style="margin: 1em 0;">Add</a>

		<?php foreach ($news as $index=>$article) { ?>
			<div class="card amber lighten-4" style="padding: 0 1em;">
				<div class="card-content" style="overflow: hidden;text-overflow: ellipsis; max-height: 25em;">
					<h5><?php echo htmlspecialchars($article->title); ?></h5>
					<p><?php echo nl2br(htmlspecialchars($article->content)); ?></p>
					<sub><?php if (isset($article->date)) echo $article->date ?></sub>
				</div>
				<div class="card-action">
					<form method="post" class="inline-block">
						<input type="hidden" name="action" value="deleteArticle">
						<input type="hidden" name="delete_index" value=<?php echo $index ?>>
						<button class="btn red">Delete</button>
					</form>
					<a class="btn green waves-effect inline-block modal-trigger" href="#editArticle" onclick="EditArticleModal(<?php echo $index ?>)">Edit</a>
				</div>
			</div>
		<?php } ?>

		<!-- Add Article Modal -->
		<div class="modal" id="addArticle">
			<div class="modal-content container">
				<h4 class="center" style="margin-bottom: 2em;">New Article</h4>
				<form method="post" id="addArticleForm" autocomplete="off">
					<input type="hidden" name="action" value="addArticle">
					<label>Title:</label>
					<input type="text" name="title">
					<div style="margin: 2em;"></div>
					<label>Content:</label>
					<textarea name="content" form="addArticleForm"></textarea>
					<label>
					    <input type="checkbox" class="filled-in" name="useDate"/>
					    <span>useDate</span>
					</label>
					<div style="margin: 2em;"></div>
					<div class="center">
						<button class="btn">Add</button>
					</div>
				</form>
			</div>
			<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
		</div>

		<!-- Edit Article Modal -->
		<div class="modal" id="editArticle">
			<div class="modal-content container">
				<h4 class="center" style="margin-bottom: 2em;">Edit Article</h4>
				<form method="post" id="editArticleForm" autocomplete="off">
					<input type="hidden" name="action" value="editArticle">
					<input type="hidden" name="index" id="editArticleIndex">
					<label>Title:</label>
					<input type="text" name="title" id="editArticleTitle">
					<div style="margin: 2em;"></div>
					<label>Content:</label>
					<textarea name="content" form="editArticleForm" id="editArticleContent"></textarea>
					<label>
					    <input type="checkbox" class="filled-in" name="useDate" id="useDate" />
					    <span>useDate</span>
					</label>
					<div style="margin: 2em;"></div>
					<div class="center">
						<button class="btn">Update</button>
					</div>
				</form>
			</div>
			<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
		</div>
	</div>

	<!-- Admin Commands -->
	<div class="container right" style="width: 20%;">
		<h4>Admin Commands:</h4>
		<div class="divider"></div>
		<div style="margin: 1em;"></div>
		<ul>
			<li><a class="btn waves-effect modal-trigger" href="#AddOP">Add Operator</a></li>
			<li><a class="btn red waves-effect modal-trigger" href="#RemoveOP">Remove Operator</a></li>
			<li><a class="btn blue waves-effect" href="./logout.php"><i class="material-icons" style="font-size: 1rem;padding: 0 2px 0 0">logout</i>Logout</a></li>
		</ul>

		<!-- Modal AddOP -->
		<div class="modal" id="AddOP" style="width: 30%;">
			<div class="modal-content container" style="padding: 4em;">
				<h4 class="center" style="margin-bottom: 2em;">Add Operator</h4>
				<form method="post" id="addArticleForm" autocomplete="off">
					<input type="hidden" name="action" value="AddOP">
					<label>Username:</label>
					<input type="text" name="username">
					<div style="margin: 2em;"></div>
					<label>Password:</label>
					<input type="text" name="password">
					<div style="margin: 2em;"></div>
					<div class="center">
						<button class="btn">Add</button>
					</div>
				</form>
			</div>
			<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
		</div>

		<!-- Modal RemoveOP -->
		<div class="modal" id="RemoveOP" style="width: 30%;">
			<div class="modal-content container">
				<ul>
					<h4>Current Operators:</h4>
					<div class="divider"></div>
					<?php 
						$ops_json = file_get_contents('ops.json');
						$ops = json_decode($ops_json);

						foreach ($ops as $index => $op) {
					?>
						<li>
							<h5 class="inline-block"><?php echo htmlspecialchars($op->username); ?></h5>
							<?php if ($index == 0) continue; ?>
							<form method="post" style="display: inline-block; margin-left: 2em;">
								<input type="hidden" name="action" value="RemoveOP">
								<input type="hidden" name="id" value=<?php echo htmlspecialchars($index); ?>>
								<button class="btn red btn-small">Remove</button>
							</form>
						</li>
					<?php } ?>
				</ul>
			</div>
			<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
		</div>
	</div>
</body>
</html>
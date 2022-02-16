<?php 
	session_start();
	if (!$_SESSION['loggedIn']){
		header('Location: login.php');
	}

	include('../utils.php');
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

	//Action changeSchedule
	if (isset($_POST['action']) && $_POST['action'] == 'changeSchedule'){
		Schedule::Change($_POST['title'],$_POST['mera'],$_POST['hour']);
	}
	//Action addScheduleRow
	if (isset($_POST['action']) && $_POST['action'] == 'addScheduleRow'){
		Schedule::AddRow($_POST['hours']);
	}
	//Action editScheduleHours
	if (isset($_POST['action']) && $_POST['action'] == 'editScheduleHours'){
		Schedule::EditHours($_POST['index'],$_POST['hours']);
	}
	//Action deleteScheduleRow
	if (isset($_POST['action']) && $_POST['action'] == 'deleteScheduleRow'){
		Schedule::DeleteRow($_POST['index']);
	} 

	//Action AddEkpompi
	if (isset($_POST['action']) && $_POST['action'] == 'addEkpompi'){
		Ekpompes::Add($_POST['title'],$_POST['description']);
	}
	//Action deleteEkpompi
	if (isset($_POST['action']) && $_POST['action'] == 'deleteEkpompi'){
		Ekpompes::Remove($_POST['delete_index']);
	}
	//Action editEkpompi
	if (isset($_POST['action']) && $_POST['action'] == 'editEkpompi'){
		Ekpompes::Edit($_POST['title'],$_POST['description']);
	}
	//Action RemoveOP
	if (isset($_POST['action']) && $_POST['action'] == 'RemoveOP'){
		Admin::RemoveOP($_POST['id']);
	}
	//Action AddOP
	if (isset($_POST['action']) && $_POST['action'] == 'AddOP'){
		Admin::AddOP($_POST['username'],$_POST['password']);
	}

	if (isset($_POST['action']) && $_POST['action'] == 'changeDecorations'){
		Admin::changeDecorations($_POST['page-decoration']);
	}
?>

<?php 
	$news_file = file_get_contents('../api/news.json');
	$news = json_decode($news_file);

	$SETTINGS = json_decode(file_get_contents('../api/settings.json'));
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

		//Modals
		document.addEventListener('DOMContentLoaded', function() {
		    var elems = document.querySelectorAll('.modal');
		    var instances = M.Modal.init(elems, {dismissible: false});
		});
		//Tooltips
		document.addEventListener('DOMContentLoaded', function() {
		    var elems = document.querySelectorAll('.tooltipped');
		    var instances = M.Tooltip.init(elems, {
		    	position: 'top',
		    	margin: 2,
		    	outDuration: 150,
		    	exitDelay: 0
		    });
		});
		//Select UI
		document.addEventListener('DOMContentLoaded', function() {
		  var elems = document.querySelectorAll('select');
		  var instances = M.FormSelect.init(elems, null);

		  var elem = document.getElementById('page-decoration-list');
		  elem.value = <?php echo $SETTINGS->decoration; ?>;
		  M.FormSelect.init(elem);
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

		function EditEkpompiModal(_title,_description){
			var title = document.getElementById('editEkpompiTitle');
			var description = document.getElementById('editEkpompiDescription');

			title.value = _title;
			description.value = _description;
		}

		function EditScheduleModal(_mera,_hour){
			var mera = document.getElementById('editScheduleMera');
			var hour = document.getElementById('editScheduleHour');
			mera.value = _mera;
			hour.value = _hour;
		}
		function SubmitEditScheduleForm(_title){
			var title = document.getElementById('editScheduleTitle');
			title.value = _title;
			document.getElementById('changeScheduleForm').submit();
		}
		function EditScheduleHoursForm(_index,_hours){
			var hours = document.getElementById('editScheduleHours_Hours');

			var indexes = document.querySelectorAll('[id=editScheduleHours_Index]');
			hours.value = _hours;
			for (var i = 0; i < indexes.length; i++) {
				indexes[i].value = _index;
			}
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
		td > a{
			color: black;
		}
		.btn{
			text-transform: unset !important;
		}
		.inline-block{
			display: inline-block;
		}
		table.striped > tbody > tr:nth-child(2n+1){
			background-color: #ffecb3 !important;
		}
		table > tbody > tr > td{
			max-width: 2em;
		}
		.dropmenu{
			color: black;
		}
		.dropmenu:hover{
			color: #009688;
			cursor: pointer;
		}
		.dropdown-content{
			background-color: #ffecb3;
		}
		.dropdown-content > li > span{
			color: black;
		}
	</style>
</head>
<body style="padding: 5em;" class="amber lighten-5">
	<div class="center" style="margin: 0 0 3em 0;">
		<h3>Lavrio Highschool Radio <span class="red-text text-darken-1">Web Tools</span></h3>
		<h5 class="red-text text-lighten-1">By: Mpelesis</h5>
	</div>

	<div class="row">
		<!-- News Articles -->
		<div class="container col s4 left">
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

		<!-- Schedule -->
		<div class="container col s5" style="margin-left: 4em;">
			<h4>Schedule:</h4>
			<div class="divider"></div>

			<!-- Table -->
			<table class="striped">
				<thead>
					<tr>
						<th>Ώρες</th>
						<th>Δευτέρα</th>
						<th>Τρίτη</th>
						<th>Τετάρτη</th>
						<th>Πέμπτη</th>
						<th>Παρασκευή</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$ekpompes = json_decode(file_get_contents('../api/ekpompes.json'),true);
						$programma_file = json_decode(file_get_contents('../api/programma.json'));
						$hours = $programma_file->hours;
						$meres = $programma_file->days;
					?>

					<?php foreach ($hours as $index => $hour) { ?>
						<tr>
							<td style="font-weight: 700;">
								<a href="#editScheduleHours" class="modal-trigger" onclick="EditScheduleHoursForm(<?php echo $index; ?>,<?php echo "'$hour'" ?>)">
									<span style="cursor: pointer;" class="tooltipped" data-tooltip='<span style="color:#8bc34a;">Edit</span>'>
										<?php echo $hour; ?>
									</span>
								</a>
							</td>
							<?php foreach ($meres as $key => $mera) {
								if (isset(((array)$mera)[$index])){
									$ekpompi = ((array)$mera)[$index];
									if (empty($ekpompi)){ ?>
										<td>
											<a class='modal-trigger' href='#editSchedule' onclick="EditScheduleModal(<?php toJS($key); ?>,<?php echo $index ?>)">--
											</a>
										</td>
									<?php }
									else{ ?>
										<td>
											<a class='modal-trigger' href='#editSchedule' onclick="EditScheduleModal(<?php toJS($key); ?>,<?php echo $index ?>)"><?php echo htmlspecialchars($ekpompi) ?>
											</a>
										</td>
									<?php }
								}
								else{ ?>
									<td>
										<a class='modal-trigger' href='#editSchedule' onclick="EditScheduleModal(<?php toJS($key); ?>,<?php echo $index ?>)">--
										</a>
									</td>
								<?php }
							} ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<a href="#addScheduleRow" class="modal-trigger" style="margin-left: 1em;color:grey;">Add Row</a>

			<!-- Edit Schedule Modal -->
			<div class="modal" id="editSchedule">
				<div class="modal-content container">
					<h4 class="center" style="margin-bottom: 2em;">Change Schedule</h4>
					<ul class="center">
						<li>
							<h5>
								<a class="dropmenu" onclick="SubmitEditScheduleForm(<?php toJS(''); ?>)">
									--
								</a>
							</h5>
						</li>
						<?php foreach ($ekpompes as $key => $value) { ?>
							<li>
								<h5><a class="dropmenu" onclick="SubmitEditScheduleForm(<?php toJS($key); ?>)"><?php echo htmlspecialchars($key);?></a></h5>
							</li>
						<?php } ?>
					</ul>
					<form method="post" id="changeScheduleForm">
						<input type="hidden" name="action" value="changeSchedule">

						<input type="hidden" name="title" id="editScheduleTitle">
						<input type="hidden" name="mera" id="editScheduleMera">
						<input type="hidden" name="hour" id="editScheduleHour">
					</form>
				</div>
				<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
			</div>

			<!-- Edit Schedule Hours Modal -->
			<div class="modal" id="editScheduleHours" style="width: 30%;">
				<div class="modal-content container">
					<h4 class="center" style="margin-bottom: 2em;">Edit Hours</h4>
					<form method="post" autocomplete="off">
						<input type="hidden" name="action" value="editScheduleHours">
						<input type="hidden" name="index" id="editScheduleHours_Index">
						<label>Hours:</label>
						<input type="text" name="hours" id="editScheduleHours_Hours">
						<div style="margin: 4em;"></div>
						<div class="center">
							<button class="btn">Update</button>
						</div>
					</form>
					<div style="margin: 2em;"></div>
					<form method="post">
						<input type="hidden" name="action" value="deleteScheduleRow">
						<input type="hidden" name="index" id="editScheduleHours_Index">
						<div class="center">
							<button class="btn red">Delete Row</button>
						</div>
					</form>
				</div>
				<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
			</div>

			<!-- Add Schedule Row Modal -->
			<div class="modal" id="addScheduleRow" style="width: 30%;">
				<div class="modal-content container">
					<h4 class="center" style="margin-bottom: 4em;">Add Row</h4>
					<form method="post" autocomplete="off">
						<input type="hidden" name="action" value="addScheduleRow">
						<label>Hours:</label>
						<input type="text" name="hours">
						<div style="margin: 2em;"></div>
						<div class="center">
							<button class="btn">Add</button>
						</div>
					</form>
				</div>
				<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
			</div>

			<!-- Ekpompes -->
			<h4>Ekpompes:</h4>
			<div class="divider"></div>

			<a href="#addEkpompi" class="btn waves-effect green modal-trigger" style="margin: 1em 0;">Add</a>
			<ul>
				<?php foreach ($ekpompes as $key => $value) { ?>
					<li>
						<h5 class="inline-block"><?php echo htmlspecialchars($key); ?></h5>
						<a href="#editEkpompi" class="inline-block btn waves-effect modal-trigger" style="margin: 0 0 0 2em;" onclick="EditEkpompiModal(<?php toJS($key); ?>,<?php toJS($value); ?>)">Edit</a>
						<form method="post" class="inline-block" style="margin: 0 0 0 1em;">
							<input type="hidden" name="action" value="deleteEkpompi">
							<input type="hidden" name="delete_index" value='<?php echo $key ?>'>
							<button class="btn red">Delete</button>
						</form>
					</li>
				<?php } ?>
			</ul>

			<!-- Add Ekpompi Modal -->
			<div class="modal" id="addEkpompi">
				<div class="modal-content container">
					<h4 class="center" style="margin-bottom: 2em;">New Entry</h4>
					<form method="post" id="addEkpompiForm" autocomplete="off">
						<input type="hidden" name="action" value="addEkpompi">
						<label>Title:</label>
						<input type="text" name="title">
						<div style="margin: 2em;"></div>
						<label>Description:</label>
						<textarea name="description" form="addEkpompiForm"></textarea>
						<p class="red-text">Can't use single quote chatacter ( ' )</p>
						<div style="margin: 2em;"></div>
						<div class="center">
							<button class="btn">Add</button>
						</div>
					</form>
				</div>
				<i class="material-icons modal-close" style="position: absolute;top: 1em;right: 1em;">close</i>
			</div>

			<!-- Edit Ekpompi Modal -->
			<div class="modal" id="editEkpompi">
				<div class="modal-content container">
					<h4 class="center" style="margin-bottom: 2em;">Edit Entry</h4>
					<form method="post" id="editEkpompiForm" autocomplete="off">
						<input type="hidden" name="action" value="editEkpompi">
						<label>Title:</label>
						<input readonly type="text" name="title" id="editEkpompiTitle">
						<div style="margin: 2em;"></div>
						<label>Description:</label>
						<textarea name="description" form="editEkpompiForm" id="editEkpompiDescription"></textarea>
						<p class="red-text">Can't use single quote chatacter ( ' )</p>
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
		<div class="container col s4 right" style="width: 15%;">
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

			<!-- Page Decorations -->
			<h4>Page Decorations:</h4>
			<div class="divider"></div>
			<form method="post">
				<input type="hidden" name="action" value="changeDecorations">
				<div class="input-field">
					<select name="page-decoration" id="page-decoration-list">
						<option value="0">None</option>
						<option value="1">Christmas</option>
						<option value="2">Velentine's Day</option>
					</select>
				</div>
				<div class="center">
					<button class="btn">Update</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
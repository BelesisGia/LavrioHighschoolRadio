<?php 
	$programa_file = fopen('api/programa.json', 'r');
	$programa = json_decode(fread($programa_file, filesize('api/programa.json')));

	$news_file = fopen('api/news.json', 'r');
	$news = json_decode(fread($news_file, filesize('api/programa.json')));
?>

<!DOCTYPE html>
<html>
<head>
	<title>Lavrio Highschool Radio</title>
	<link rel="icon" type="image/x-icon" href="images/favicon.ico">

	<meta charset="utf-8">
    
	<!-- Materialize Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Font Awesome-->
    <script src="https://kit.fontawesome.com/6b4c67839b.js" crossorigin="anonymous"></script>

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css">
    <!-- Special Decorations -->
    <link rel="stylesheet" type="text/css" href="stylesheets/decorations.css">
    <!--Page.js-->
    <script src="page.js"></script>
    <!--Anim.css-->
    <link rel="stylesheet" type="text/css" href="stylesheets/anim.css">
</head>
<body class="amber lighten-5">
	<!--
	<ul class="page-decoration-list unselectable" style="overflow-x: hidden;">
		<li><img class="page-decoration" src="images/page-decoration2.png"></li>
		<li><img class="page-decoration" src="images/page-decoration2.png"></li>
		<li><img class="page-decoration" src="images/page-decoration2.png"></li>
		<li><img class="page-decoration" src="images/page-decoration2.png"></li>
		<li><img class="page-decoration" src="images/page-decoration2.png"></li>
		<li><img class="page-decoration" src="images/page-decoration2.png"></li>
		<li><img class="page-decoration" src="images/page-decoration2.png"></li>
	</ul>
	-->
	<div>
		<!-- Title -->
		<div class="center-align unselectable">
			<img src="images/microphone.png" style="margin: 0px 20px 0px 0px;">
			<h1 class="font-watcher inline-block" style="margin: 2px 5px;position: relative;">
				<!-- Valentine's Day Decoration -->
				<img class="valentines-title hide-on-med-and-down" src="images/hearts.png">
				<img class="valentines-title-mobile hide-on-large-only" src="images/hearts.png">
				<!--
				<img class="title-decoration hide-on-med-and-down" src="images/christmas-hat.png">
				<img class="title-decoration-mobile hide-on-large-only" src="images/christmas-hat.png">
				-->
				Lavrio Highschool Radio
			</h1>
		</div>
		<!-- CONTENT -->
		<div class="container">
			<div class="divider"></div>
			<h4>&#8594 Listen Live: 
				<a href="https://lavriohighschool.radio12345.com" target="_self">
					https://lavriohighschool.radio12345.com
				</a>
			</h4>
			<!-- Stream Listener -->
			<div class="unselectable">
				<audio id="_Stream" src="https://freeuk23.listen2myradio.com/live.mp3?typeportmount=s1_14224_stream_829836720"></audio>
				<div>
					<img id="vinyl" src="images/vinyl.png" style="width: 8em;height:8em;">
					<!--Controls-->
					<div class="inline-block">
						<i class="medium material-icons cursor-pointer" onclick="_StreamPlay()" onselectstart="return false;">play_arrow</i>
						<i class="medium material-icons cursor-pointer" onclick="_StreamStop()" onselectstart="return false;">pause</i>
						<i class="medium material-icons cursor-pointer" onclick="document.getElementById('_Stream').volume += 0.1" onselectstart="return false;">volume_up</i>
						<i class="medium material-icons cursor-pointer" onclick="document.getElementById('_Stream').volume -= 0.1" onselectstart="return false;">volume_down</i>
						<i class="medium material-icons cursor-pointer" onclick="document.getElementById('_Stream').currentTime += document.getElementById('_Stream').duration;" onselectstart="return false;">fast_forward</i>
					</div>
				</div>
			</div>

			<!-- Abous Us -->
			<div>
				<div class="inline-block">
					<h4>Λίγα Λόγια Για Εμάς:</h4>
					<div class="divider"></div>
				</div>
				<p class="flow-text line-height">
					Το Γενικό Λύκειο Λαυρίου ξεκινά την δοκιμαστική λειτουργία του διαδικτυακού του ραδιοφώνου. Ακούστε καθημερινά από τις 8:30 το πρωί μέχρι τις 22:00 το βράδυ. Το ραδιόφωνο βρίσκεται σε πειραματικό στάδιο. Θα λειτουργήσει κανονικά από τις 13/12/2021. Το Γενικό Λύκειο Λαυρίου , με την τωρινή του μορφή, ιδρύθηκε το 1976 και αρχικά συστεγαζόταν με το Γυμνάσιο Λαυρίου. Εντούτοις η ιστορική του διαδρομή ξεκινά το 1923-24 με την ίδρυση στο Λαύριο του Πρακτικού Λυκείου Λαυρίου. Βρίσκεται στην οδό Α. Κορδέλα 4, μέσα στην πόλη του Λαυρίου και στεγάζεται σε ένα τριώροφο κτήριο που κατασκευάσθηκε το 1987, μέσα σε περιφραγμένο χώρο 12 στρεμμάτων.
				</p>
			</div>

			<!-- Social [Mobile Only]-->
			<div class="hide-on-large-only">
				<div class="inline-block">
					<h4 class="font-eroded-4em inline-block">Social <img class="valentines-social" src="images/chocolate.png"></h4>
					<div class="divider" style="margin-bottom: 1em;"></div>
				</div>
				<br>
				<a href="#" target="_self" class="btn btn-large blue waves-effect waves-light" style="margin-right:1em;"><i class="fab fa-facebook-square" style="font-size: 2rem;"></i></a>
				<a href="https://instagram.com/lavrio_high_school_radio" target="_self" class="btn btn-large instagram waves-effect waves-light"><i class="fab fa-instagram" style="font-size: 2rem;"></i></a>
			</div>

			<!-- News -->
			<div>
				<div class="inline-block">
					<h4>Νέα:</h4>
					<div class="divider"></div>
				</div>
				<div class="container" style="margin-left: 2em;">
					<?php 
					foreach ($news as $neo) {	
				 ?>
				 <div>
				 	<blockquote style="margin: 20px 0;padding-left: 1.5rem;border-left: 5px solid #ff7043;">
				 		<h5 class="red-text text-accent-2"><?php echo htmlspecialchars($neo->title); ?></h5>
				 	</blockquote>
				 	<div style="margin-left: 1em;font-size: 18px;">
				 		<?php echo nl2br(htmlspecialchars($neo->content)); ?> <br>
				 		<sub class="grey-text text-darken-2"><?php if(isset($neo->date)) echo $neo->date; ?></sub>
				 	</div>
				 </div>
				<?php } ?>
				</div>
			</div>

			<!-- Table of shows -->
			<div class="inline-block">
				<h4>Πρόγραμμα Εκπομπών:</h4>
				<div class="divider"></div>
				<blockquote>
					Πατήστε το όνομα της εκπομπής για περιγραφή.
				</blockquote>
			</div>
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
					<?php foreach ($programa as $mera) {
					?>
					<tr>
						<?php foreach ($mera as $index=>$ekpompi) {
								if ($index == 0){
									echo "<td style=\"font-weight: 700;\">{$ekpompi->title}</td>";
									continue;
								}
								if ($ekpompi->title == "") {
									echo "<td></td>";
								}
								elseif ($ekpompi->description == ""){
									echo "<td>{$ekpompi->title}</td>";
								}
								else{
									echo "<td class='tooltipped' data-tooltip='{$ekpompi->description}'>{$ekpompi->title}</td>";
								}
							}
							?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<!-- Footer -->
		<div class="container" style="margin-top: 2em;">
			<h6 class="grey-text">Website made by: Mpelesis</h6>
		</div>
	</div>
	
	<!-- Social [Desktop Only]-->
	<div class="fixed-top-right hide-on-med-and-down">
		<h4 class="font-eroded-4em">Social <img class="valentines-social" src="images/chocolate.png"></h4>
		<div class="divider"></div>
		<br>
		<a href="#" target="_self" class="btn btn-large blue waves-effect waves-light" style="margin-right:1em;"><i class="fab fa-facebook-square" style="font-size: 2rem;"></i></a>
		<a href="https://instagram.com/lavrio_high_school_radio" target="_self" class="btn btn-large instagram waves-effect waves-light"><i class="fab fa-instagram" style="font-size: 2rem;"></i></a>
	</div>
	<div style="margin-bottom:10em"></div>
</body>
</html>
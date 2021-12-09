//Init
document.addEventListener('DOMContentLoaded', function() {

	var elems = document.querySelectorAll('.fixed-action-btn');
	var instances = M.FloatingActionButton.init(elems, {
		direction: 'left',
		hoverEnabled: false
	});
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems, {
    	position: 'top',
    	margin: 2,
    	outDuration: 150,
    	exitDelay: 0
    });
  });

document.addEventListener('DOMContentLoaded',function(){
	document.getElementById('_Stream').volume = 0.5;
});

function _StreamPlay(){
	document.getElementById('_Stream').play();
	document.getElementById('vinyl').classList.add('rotating');
}

function _StreamStop(){
	document.getElementById('_Stream').pause();
	document.getElementById('vinyl').classList.remove('rotating');
}
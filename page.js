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

//MaterialBox
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.materialboxed');
    var instances = M.Materialbox.init(elems, null);
  });

//ScrollSpy
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.scrollspy');
    var instances = M.ScrollSpy.init(elems, {
        activeClass: 'scrollspy-active',
        scrollOffset: 600
    });
  });

//Stream
document.addEventListener('DOMContentLoaded',function(){
	_('_Stream').volume = 0.5;
});

function _StreamPlay(){
	_('_Stream').play();
	_('vinyl').classList.add('rotating');
}

function _StreamStop(){
	_('_Stream').pause();
	_('vinyl').classList.remove('rotating');
}

//Scroll
function ScrollToView(_id){
    _(_id).scrollIntoView({behavior:'smooth'});
}

function _(el) {
  return document.getElementById(el);
}
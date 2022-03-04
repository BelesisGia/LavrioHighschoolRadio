function _(el) {
  return document.getElementById(el);
}

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
var StreamVolume = 0.8;
var isMuted = false;
document.addEventListener('DOMContentLoaded',function(){
	_('_Stream').volume = StreamVolume;
});

function _StreamPlay(){
	_('_Stream').play();
	_('vinyl').classList.add('rotating');
}

function _StreamStop(){
	_('_Stream').pause();
	_('vinyl').classList.remove('rotating');
}

function _StreamIncrementVolume(amount){
  StreamVolume += amount;
  if (StreamVolume > 1) StreamVolume = 1;
  if (StreamVolume < 0) StreamVolume = 0;
  _('_Stream').volume = StreamVolume;
}

function _StreamMute(){
  if (!isMuted){
    _('_Stream').volume = 0;
    isMuted = true;
    _('_StreamMuteBtn').innerHTML = 'volume_up';
  }
  else{
    _('_Stream').volume = StreamVolume;
    isMuted = false;
    _('_StreamMuteBtn').innerHTML = 'volume_off';
  }
}

//Scroll
function ScrollToView(_id){
    _(_id).scrollIntoView({behavior:'smooth'});
}

//Stream Info
document.addEventListener('DOMContentLoaded',function(){
  UpdateInfo();
  setInterval(UpdateInfo, 5000);
});

function UpdateInfo(){
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.onload = function(){
    var data = JSON.parse(xmlHttp.responseText);
    //Stream status
    if (data.data.status == 1){
      _('streamStatus').innerHTML = 'Online';
    }
    else{
      _('streamStatus').innerHTML = '<span class="red-text">Offline<span>';
      return;
    }
    //Current Listeners
    _('currentListeners').innerHTML = data.data.listeners;
    if (data.data.song === ''){
      _('currentSong').innerHTML = 'no data';
    }
    else{
      _('currentSong').innerHTML = data.data.song;
    }
  };
  xmlHttp.open('GET','status.php');
  xmlHttp.send();
}
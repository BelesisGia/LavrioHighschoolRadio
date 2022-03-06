function _(el) {
  return document.getElementById(el);
}

function addTempClass(elem,className,delay){
  _(elem).classList.add(className);
  setTimeout(function(){
    _(elem).classList.remove(className);
  },delay);
}

function ScrollToView(_id){
    _(_id).scrollIntoView({behavior:'smooth'});
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
var StreamVolume = 0.5;
var isMuted = false;

document.addEventListener('DOMContentLoaded',function(){
	_('_Stream').volume = StreamVolume;
  _('_Stream').onerror = function(error){
    console.warn("Stream is not available playing backup audio!");
    _('_Stream').src = String.raw`audio\What makes me a good Demoman Song.mp3`;
    _('_Stream').setAttribute("loop",true);
    _('_Stream').onerror = function(ev){};

    _('currentSong').innerHTML = "What makes me a good Demoman Song(HQ)";
  };
});

function _StreamPlay(){
  addTempClass('_StreamPlayBtn','press',300);
	_('_Stream').play();
	_('vinyl').classList.add('rotating');
}

function _StreamStop(){
  addTempClass('_StreamStopBtn','press',300);
	_('_Stream').pause();
	_('vinyl').classList.remove('rotating');
}

function _StreamIncrementVolume(amount){
  StreamVolume += amount;
  if (StreamVolume > 1) StreamVolume = 1;
  if (StreamVolume < 0) StreamVolume = 0;
  _('_Stream').volume = StreamVolume;
  if (amount > 0){
    addTempClass('_StreamVolumeUpBtn','press',300);
  }
  else{
    addTempClass('_StreamVolumeDownBtn','press',300);
  }
}

function _StreamMute(){
  if (!isMuted){
    _('_Stream').volume = 0;
    isMuted = true;
    _('_StreamMuteBtn').classList.add('icon-shadow');
  }
  else{
    _('_Stream').volume = StreamVolume;
    isMuted = false;
    _('_StreamMuteBtn').classList.remove('icon-shadow');
  }
}

//Stream Info
var getStatusInterval;

document.addEventListener('DOMContentLoaded',function(){
  UpdateInfo();
   getStatusInterval = setInterval(UpdateInfo, 5000);
});

function UpdateInfo(){
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.onload = function(){
    //If Server Offline
    if(xmlHttp.status != 200){
      _('streamStatus').innerHTML = '<span class="red-text">Offline<span>';
      clearInterval(getStatusInterval);
      return;
    }

    var data = JSON.parse(xmlHttp.responseText);
    //Set Stream status
    if (data.data.status == 1){
      _('streamStatus').innerHTML = 'Online';
    }
    else{
      _('streamStatus').innerHTML = '<span class="red-text">Offline<span>';
      clearInterval(getStatusInterval);
      return;
    }
    //Set Current Listeners
    _('currentListeners').innerHTML = data.data.listeners;
    //Set Current Song
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
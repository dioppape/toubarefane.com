
			
			function audioPlayerSetupDone(){
				/* This will get called when component is ready to receive public function calls. */
				//console.log('audioPlayerSetupDone');
			}
			
			// SETTINGS
			var ap_settings = {
				/* activePlaylist: set active playlist that will be loaded on beginning (pass element 'id' attributte) */
				activePlaylist: 'playlist1',
				
				/* soundcloudApiKey: If you want to use SoundCloud music, register you own api key here for free: 
				'http://soundcloud.com/you/apps/new' and enter Client ID */
				soundcloudApiKey: '',

				/*defaultVolume: 0-1 (Irrelevant on ios mobile) */
				defaultVolume:0.5,
				/*autoPlay: true/false (false on mobile by default, important!) */
				autoPlay:true,
				/*randomPlay: true/false */
				randomPlay:false,
				/*loopingOn: true/false (loop on the end of the playlist) */
				loopingOn:true,
				
				/* addNumbersInPlaylist: true/false. Prepend numbers in playlist items. */
				addNumbersInPlaylist: true,
				
				/* useSongNameScroll: true/false. Use song name scrolling. */
				useSongNameScroll: true,
				/* scrollSpeed: speed of the scroll (number higher than zero). */
				scrollSpeed: 1,
				/* scrollSeparator: String to append between scrolling song name. */
				scrollSeparator: '&nbsp;&#42;&#42;&#42;&nbsp;',
				
				/* mediaTimeSeparator: String between current and total song time. */
				mediaTimeSeparator: '&nbsp;-&nbsp;',
				/* seekTooltipSeparator: String between current and total song position, for progress tooltip. */
				seekTooltipSeparator: '&nbsp;/&nbsp;',
				
				/* useRollovers: use button rollovers, true/false. */
				useRollovers:false,
				/* buttonsUrl: url of the buttons for normal and rollover state, so I dont hardcode them in jquery (rollover state is optional). */
				buttonsUrl: {prev: '/toubarefane/web/bootstrap/lecteuraudio/img/prev.png', prevOn: '/toubarefane/web/bootstrap/lecteuraudio/img/prev_on.png', 
						  	 next: '/toubarefane/web/bootstrap/lecteuraudio/img/next.png', nextOn: '/toubarefane/web/bootstrap/lecteuraudio/img/next_on.png', 
						 	 pause: '/toubarefane/web/bootstrap/lecteuraudio/img/pause.png', pauseOn: '/toubarefane/web/bootstrap/lecteuraudio/img/pause_on.png',
						 	 play: '/toubarefane/web/bootstrap/lecteuraudio/img/play.png', playOn: '/toubarefane/web/bootstrap/lecteuraudio/img/play_on.png',
						 	 volume: '/toubarefane/web/bootstrap/lecteuraudio/img/volume.png', volumeOn: '/toubarefane/web/bootstrap/lecteuraudio/img/volume_on.png', 
							 mute: '/toubarefane/web/bootstrap/lecteuraudio/img/mute.png', muteOn: '/toubarefane/web/bootstrap/lecteuraudio/img/mute_on.png', 
						  	 loop: '/toubarefane/web/bootstrap/lecteuraudio/img/loop.png', loopOn: '/toubarefane/web/bootstrap/lecteuraudio/img/loop_on.png',
						  	 shuffle: '/toubarefane/web/bootstrap/lecteuraudio/img/shuffle.png', shuffleOn: '/toubarefane/web/bootstrap/lecteuraudio/img/shuffle_on.png'}
			};
			
			//sound manager settings (http://www.schillmania.com/projects/soundmanager2/)
			soundManager.allowScriptAccess = 'always';
			soundManager.debugMode = false;
			soundManager.noSWFCache = true;
			soundManager.useConsole = false;
			soundManager.waitForWindowLoad = true;
			soundManager.url = 'swf/';//path to flash files
			soundManager.flashVersion = 9;
			soundManager.preferFlash = false; 
			soundManager.useHTML5Audio = true;
			
			//**********Start Delete this if you want to use just flash**********//
			var audio = document.createElement('audio'), mp3Support, oggSupport;
			if (audio.canPlayType) {
			   mp3Support = !!audio.canPlayType && "" != audio.canPlayType('audio/mpeg');
			   oggSupport = !!audio.canPlayType && "" != audio.canPlayType('audio/ogg; codecs="vorbis"');
			}else{
				//for IE<9
				mp3Support = true;
				oggSupport = false;
			}
			//console.log('mp3Support = ', mp3Support, ' , oggSupport = ', oggSupport);
			
			/*
			FF - false, true
			OP - false, true
			
			IE9 - true, false 
			SF - true, false 
			
			CH - true, true
			*/
		
		    soundManager.audioFormats = {
			  'mp3': {
				'type': ['audio/mpeg; codecs="mp3"', 'audio/mpeg', 'audio/mp3', 'audio/MPA', 'audio/mpa-robust'],
				'required': mp3Support
			  },
			  'mp4': {
				'related': ['aac','m4a'],
				'type': ['audio/mp4; codecs="mp4a.40.2"', 'audio/aac', 'audio/x-m4a', 'audio/MP4A-LATM', 'audio/mpeg4-generic'],
				'required': false
			  },
			  'ogg': {
				'type': ['audio/ogg; codecs=vorbis'],
				'required': oggSupport
			  },
			  'wav': {
				'type': ['audio/wav; codecs="1"', 'audio/wav', 'audio/wave', 'audio/x-wav'],
				'required': false
			  }
			};
			//**********End Delete this if you want to use just flash**********//
			
			jQuery(document).ready(function() {
                            var $ = jQuery.noConflict();
			    $.html5audio('#componentWrapper', ap_settings, 'sound_id1');
			    ap_settings = null;
    	    });
		
       
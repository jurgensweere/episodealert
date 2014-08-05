/*
 *Arie renskens
 *var global = {}

global.unfollow = function(data) {

}*/

(function($){
	$.fn.follow = function(options) {
		var opts = $.extend({
			remove: false
		}, options);

		$(this).each(function() {
			var alink = $(this).find(':nth-child(1)');
			var url = alink.attr('href');
			var id = url.split('/').slice(-1);

			if(alink.hasClass('following')) {
				followToggle(alink, {follow: id}, opts);
			} else {
				followToggle(alink, {unfollow: id}, opts);
			}
		});
	};

	function followToggle(obj, data, opts) {
		var id;
		
		var url = obj.attr('href');
		obj.removeAttr('href');
		if(!opts.login) {
			//obj.bind('click', function() { $('#login-button').click(); });
			return;
		}

		if(data.follow) {
			id = data.follow;
			obj.text('following').addClass('following').unbind()
				.mouseover(function(){$(this).text('unfollow')})
				.mouseout(function(){$(this).text('following')}).click(function() {
				if(opts.remove) {$.get('/unfollow/'+id, {}, function(data) {if ( $('.s'+id).length ) {$('.s'+id).fadeOut();}});}
				else {$.get('/unfollow/'+id, {}, function(data) {followToggle(obj, data, opts);}, 'json');}
				return false;
			});
		} else if (data.unfollow) {
			id = data.unfollow;
			obj.text('follow').removeClass('following').unbind()
				.click(function() {
					$.get('/follow/'+id, {}, function(data) {followToggle(obj, data, opts);}, 'json');return false;
				});
		}
	}
//
//	$.fn.episodeAccordion = function() {
//		$(this).each(function() {
//			$(this).bind('click', function(){
//				var visible = $(this).find('.accordion').is(':visible');
//				$('.accordion').slideUp();
//                                $('.episode').removeClass('selected');
//				if(!visible) {
//                                $(this).find('.accordion').slideDown();
//                                $(this).addClass('selected');
//                            }
//			});
//		});
//	}

	$.fn.seasoner = function(options) {
		var opts = $.extend({
			selectedSeason: 'last'
		}, options);

		$(this).each(function() {
			initSeasoner($(this), opts);
			createScrollableArea($(this), opts);
			getEpisodeData(opts.serieId, opts.selectedSeason);
			fetchBadgeData(opts.serieId);
		});

	};

	var appearTimeout;
	var mouseoverenabled = true;

	$.fn.seenButton = function(options) {
		var opts = $.extend({
		}, options);

		$(this).each(function() {
			var url = $(this).attr('href');
			var id = url.split('/').slice(-1);

			bindSeenKnop($(this), {episode: id});
		});
	}

	function bindSeenKnop(btn, data) {
		btn.bind('mouseover', function(){
			$('.seencontext').remove();
			appearTimeout = setTimeout( function(){seenMouseOver(btn,data)},200);
		});

		btn.bind('mouseout', function(){
			clearTimeout(appearTimeout);
		});

		btn.bind('click', function(event){
            event.stopPropagation();
            if( btn.hasClass('see') ){
                $.get('/seen/see/'+data.episode+'/single', {}, function(data) {handleSeenData(btn,data);}, 'json');
            } else {
                $.get('/seen/unsee/'+data.episode+'/single', {}, function(data) {handleSeenData(btn,data);}, 'json');
            }
            clearTimeout(appearTimeout);
        })

        btn.removeAttr('href');
	}

	function seenMouseOver(btn, data){
		if(!mouseoverenabled) return;
		
		var extraClass='';
		if( !btn.hasClass('see') ){
			extraClass='seen';
		}

		if(!btn.hasClass('single')){
			btn.after('<div class="seencontext"><ul class="'+extraClass+'"><li class="single">this episode</li><li class="until">until here</li><li class="season">entire season</li></ul></div>');
		}
		var context = btn.parent().find('.seencontext');
		context.bind('mouseout', function(){appearTimeout = setTimeout( function(){seenMouseOut(btn)},200);});
		context.bind('mouseover', function(){clearTimeout(appearTimeout);});

		if( btn.hasClass('see') ){
			context.find('li.single').bind('click', function() {
				mouseoverenabled = false;
				$.get('/seen/see/'+data.episode+'/single', {}, function(data) {handleSeenData(btn,data);}, 'json');
				seenMouseOut(btn);
				return false;
			});
			context.find('li.until').bind('click', function() {
				mouseoverenabled = false;
				$.get('/seen/see/'+data.episode+'/until', {}, function(data) {handleSeenData(btn,data);}, 'json');
				seenMouseOut(btn);
				return false;
			});
			context.find('li.season').bind('click', function() {
				mouseoverenabled = false;
				$.get('/seen/see/'+data.episode+'/season', {}, function(data) {handleSeenData(btn,data);}, 'json');
				seenMouseOut(btn);
				return false;
			});
		} else {
			context.find('li.single').bind('click', function() {
				mouseoverenabled = false;
				$.get('/seen/unsee/'+data.episode+'/single', {}, function(data) {handleSeenData(btn,data);}, 'json');
				seenMouseOut(btn);
				return false;
			});
			context.find('li.until').bind('click', function() {
				mouseoverenabled = false;
				$.get('/seen/unsee/'+data.episode+'/until', {}, function(data) {handleSeenData(btn,data);}, 'json');
				seenMouseOut(btn);
				return false;
			});
			context.find('li.season').bind('click', function() {
				mouseoverenabled = false;
				$.get('/seen/unsee/'+data.episode+'/season', {}, function(data) {handleSeenData(btn,data);}, 'json');
				seenMouseOut(btn);
				return false;
			});
		}
	}

	function seenMouseOut(btn) {
		$('.seencontext').remove();
	}

	function handleSeenData(button, data) {

		var toseen = false;
		if( button.hasClass('see') ){toseen = true;}

		$.each(data.episode, function(){
			var ep_id = this;
			if( toseen ){
				// button is unseen, must be turned into seen
				$('#ep_'+ep_id).find('a.btn').removeClass('see').addClass('seen').text('Seen');
			} else {
				// button is seen, must be turned into unseen
				$('#ep_'+ep_id).find('a.btn').removeClass('seen').addClass('see').text('Not seen');
			}
		})
		mouseoverenabled = true;
		fetchBadgeData(data.serie_id);
	}

	function fetchBadgeData(serie_id) {
		if($('.season-navigation').length > 0) {
			$.get('/seen/info/'+serie_id, {}, function(data){updateBadges(data)},'json');
		}
	}

	function updateBadges(data) {
		if(data.seen.length == 0) return;
		$('.season-navigation li').each(function(i){
			$(this).find('.badge').remove();
			var arr = $(this).attr('id').split('_');
			var id = arr[1];

			if(data.seen[id] == "SKIP") {

			} else if (data.seen[id] == "Y") {
				$(this).prepend('<span class="badge seen"><span>seen</span></span>');
			} else {
				$(this).prepend('<span class="badge"><span>' + data.seen[id]+ '</span></span>');
			}
		});
	}

	function getEpisodeData(serie_id, season) {
		$.get('/series/seasonlisting/'+ serie_id + '/' + season, {}, function(data){
			$('#seasonContent').html(data);
			$('.season-navigation li').removeClass();
			$('#season_'+season).addClass('selected');

			$('#seasonContent div.seen-button a').seenButton();
			$('#seasonContent .episode').episodeAccordion();

			// Jump to episode, if given
			if(window.location.hash != null && window.location.hash != '#_' ) {
				var episode_id = window.location.hash.substr(1);
				window.location.href = '#'+episode_id;
				$('#episode_'+episode_id).find('.accordion').slideDown();
			}
		}, 'html');

	}

   function initSeasoner(div, opts) {
	   div.after('<div id="seasonContent"></div>');

	   div.find('ul li').bind('click', {serieId: opts.serieId}, function(event){
		   window.location.hash = '_';
		   var id = $(this).attr('id');
		   var arr = id.split('_');
		   var season = arr[1];
		   getEpisodeData(event.data.serieId, season);
	   });

	   div.find('ul li a').removeAttr('href');
   }

   function createScrollableArea($div, opts) {
		var ul = $div.find('ul'), ulPadding = 30;

		$div.css({overflow: 'hidden'});
		var divWidth = $div.width();
		var lastLi = ul.find('li:last-child');
		var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;

		if(divWidth > ulWidth) return;

		$div.wrap('<div class="wrapper"></div>');
		$div.before('<div class="season-navigation-left"></div>');
		$div.after('<div class="season-navigation-right"></div>');

		var leftHandle  = $div.parent().find('.season-navigation-left');
		var rightHandle = $div.parent().find('.season-navigation-right');
		var rightScrollInterval, leftScrollInterval, scrollXpos = 4;

		leftHandle.mouseover(function(){leftScrollInterval=setInterval(doScrollLeft,6);});
		leftHandle.mouseout(function(){clearInterval(leftScrollInterval);});
		rightHandle.mouseover(function(){rightScrollInterval=setInterval(doScrollRight,6);});
		rightHandle.mouseout(function(){clearInterval(rightScrollInterval);});

		var doScrollRight=function() {if($div.scrollLeft() < ulWidth-divWidth){$div.scrollLeft($div.scrollLeft()+(scrollXpos));}}
		var doScrollLeft=function() {$div.scrollLeft($div.scrollLeft()-(scrollXpos));}

		// initial scroll to selected.
		var selectedLi;
		
		if(opts.selectedSeason == 'last') {
			selectedLi = ul.find('li:last-child');
		} else {
			selectedLi = ul.find('#season_' + opts.selectedSeason);
		}
		selectedLi.addClass('selected');
		 
		var scrollto = selectedLi[0].offsetLeft + selectedLi.outerWidth() + ulPadding -divWidth/2;
		if(scrollto > ulWidth-divWidth) scrollto = ulWidth-divWidth;
		$div.scrollLeft(scrollto);
	}



   $.fn.wordwraptext = function() {
		var text = this.text();
		if(text.length > 1000) {
			var trimmed = text.substr(0, text.substr(0, 1000).lastIndexOf(' ') );
			var more = $("<a>more</a>").attr('href','#').click(function(){
				$(this).parent().css('max-height','none');
				$(this).parent().html(text);
			});
			this.html(trimmed + ' ... ');
			this.append(more);
			this.css({overflow: 'hidden'});
		}
	};

	$.fn.seen = function() {};
        $.fn.loader = function(options) {
            var opts = $.extend({}, options);
            $(this).each(function() {
                $(this).hide();
                $(this).ajaxStart(function(){$(this).show();})
                $(this).ajaxStop(function(){$(this).hide();})
            });
	};

        $.fn.ajaxlinks = function(options) {
            var opts = $.extend({}, options);
            $(this).each(function() {
                var url = $(this).attr('href');
                $(this).removeAttr('href');
                $(this).click(function(){
                   $.get(url, {}, function(data){handleAjaxLink(data)},'json');
                });
            });
        }

        function handleAjaxLink(data) {
            if( data.action != undefined ) {
                if( data.action.click != undefined ) {
                    $(data.action.click).click();
                }
            }
        }
})(jQuery);

//jQuery lightbox
jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox();
  $('#loading').loader();
}) 

// Searchbox
$(document).ready(function(){
	if($('#query').val() == 'search' || $('#query').val() == '') {
		$('#query').val('search');
		$('#query').css("color","#aaa");
	}
	$('#query').bind('click', function(){
		if( $(this).val() == 'search' ) {
			$(this).val('');
		}
		$(this).css("color","#000");
	});
	$('#query').bind('blur', function(){
		if( $(this).val() == '' || $(this).val() == 'search' ) {
			$(this).val('search');
			$(this).css("color","#aaa");
		}
	});
});

function test () {
	alert('test');
}
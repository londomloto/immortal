
function getLastUrl() {
	return localStorage.getItem('lasturl');
}

function setLastUrl(url) {
	localStorage.setItem('lasturl', url);
}

function loadPage(url, push) {
	
	var state = {url: url},
		lastUrl = getLastUrl();

	$.ajax({
		url: url
	})
	.done(function(response){
		
		response = (response || '').replace(/(^\s+)/i, '');

		if (/^[\{\[]"success/.test(response)) {
			try {
				var d = JSON.parse(response);
				if ( ! d.success) {
					alert(d.message);
					if (d.redirect) {
						location.href = d.redirect;
					}
				}
			} catch(e) {}
		} else {
			$('.page-content').empty().html(response);	
		}

	});

	push = push === undefined ? true : push;

	if (lastUrl != url && push) {
		history.pushState(state, '', url);
	}
	
	setLastUrl(url);
}

$(document).ready(function(){

	function dispatch(e) {
		e.preventDefault();
		e.stopPropagation();
		
		var url = $(this).attr('href');

		loadPage(url);
	}

	function parseQuery(query) {
		var params = [],
			plusRe = /\+/g,
			findRe = /([^&=]+)=?([^&]*)/g,
			decode = function(str) { return decodeURIComponent(str.replace(plusRe, ' ')); },
			match;

		while(match = findRe.exec(query)) {
			params.push({
				name: decode(match[1]),
				value: decode(match[2])
			});
		}

		return params;
	}

	// handle link
	$('a[data-push]').on('click', dispatch);

	// handle dynamic link
	$('body').on('click', 'a[data-push]', dispatch);

	// handle dynamic form submit
	$('body').on('submit', 'form[data-push]', function(e){
		
		var method = $(this).attr('method') || 'get',
			action = $(this).attr('action') || currentUrl(),
			upload = $(this).find('input[type=file]').length;

		if ( ! upload) {

			e.preventDefault();

			var url = action,
				data = $(this).serialize();

			if (method === 'get') {

				var actBase = action, 
					actQuery = '',
					actMark = action.indexOf('?');

				if (actMark > -1) {
					actQuery = action.slice(actMark + 1);
					actBase  = action.substr(0, actMark);
				}

				var actParams = parseQuery(actQuery),
					frmParams = $(this).serializeArray(),
					frmTokens = frmParams.map(function(p){ return p.name; }),
					allParams = [],
					allQuery  = '',
					len = actParams.length,
					url,
					i;

				// remove duplicate
				for (i = len - 1; i >= 0; i--) {
					if (frmTokens.indexOf(actParams[i].name) > -1) {
						actParams.splice(i, 1);
					}
				}

				allParams = $.merge(frmParams, actParams);
				allQuery  = $.param(allParams);

				url = actBase + (allQuery ? '?' + allQuery : '');
				data = '';

			}

			$.ajax({
				url: url,
				type: method,
				data: data
			})
			.done(function(response){
				$('.page-content').empty().html(response);
			});

			var lastUrl = getLastUrl();

			if (lastUrl != url) {
				history.pushState({url: url}, '', url);
			}

			setLastUrl(url);
		}

	});

	$(window).on('popstate', function(e){
		var state = e.originalEvent.state;
		if (state) {
			loadPage(state.url, false);
		}
	});

	

	Site.run();

});
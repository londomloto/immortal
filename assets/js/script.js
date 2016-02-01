
$(document).ready(function(){

	var lastURL;

	$(document).on('click', 'a[data-push]', function(e){

		e.preventDefault();
		
		var href = $(this).attr('href'),
			state = {
				page: href
			};

		load(state.page);
		
		if (lastURL != href) {
			history.pushState(state, '', state.page);	
		}
		
		lastURL = href;

	});

	$(window).on('popstate', function(e){
		var state = e.originalEvent.state;
		
		if (state) {
			load(state.page);
		}
	});

	function load(page) {
		// $('.page').mask();
		$('.page-content').load(page, function(){
			// $('.page').unmask();
		});
	}

	Site.run();

});
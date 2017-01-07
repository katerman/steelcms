(function($){
	'use strict';

	if(window.Steel === undefined){

		var Steel = function(){

			var $this = this;

			/* Ajax's to what the page should be so we dont' have to refresh the page */
			this.replacePage = function(page){
				if(page === undefined){
					page = '/';
				}

				$.ajax({
					url: page,
					method: 'get',
					cache: false
				}).done(function(data){
					var newDoc = document.open("text/html", "replace");
					newDoc.write(data);
					newDoc.close();
				});

			}

			return this;

		}

		window.Steel = new Steel();

	}


})(jQuery);
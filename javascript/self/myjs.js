jQuery.noConflict();

(function($){

  $(document).ready(function(){
  	 $.ajaxSetup({
	   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});

    

//______________________________________________________________________________________________________
  }); //END DOC READY  

}(jQuery));

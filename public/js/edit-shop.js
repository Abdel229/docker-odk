
(function($) {

    var productId = @json($product);
	//<---------------- Shop Product ----------->>>>
	$(document).on('click','#shopProductBtn'+productId,function(s) {

		s.preventDefault();
		var element = $(this);

		element.attr({'disabled' : 'true'});
		element.find('i').addClass('spinner-border spinner-border-sm align-middle mr-1');

		(function() {

			 $("#shopProductForm"+productId).ajaxForm({
			 dataType : 'json',
			 error: function(responseText, statusText, xhr, $form) {
				element.removeAttr('disabled');
				
				console.log(responseText);
				if (! xhr) {
					xhr = '- ' + error_occurred;
				} else {
					xhr = '- ' + xhr;
				}

				$('.popout').removeClass('popout-success').addClass('popout-error').html(error_oops+' '+xhr+'').fadeIn('500').delay('5000').fadeOut('500');
					 element.find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
			 },
			 success: function(result) {
			console.log(result);
			 //===== SUCCESS =====//
		
			if (result.success && result.url) {
				 window.location.href = result.url;

			
			 } else {
				var error = '';
				var $key = '';

				for ($key in result.errors) {
					error += '<li><i class="fa fa-times-circle"></i> ' + result.errors[$key] + '</li>';
				}

				$('#showErrorsShopProduct'+productId).html(error);
				$('#errorShopProduct'+productId).fadeIn(500);

				element.removeAttr('disabled');
				element.find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
				}
			}//<----- SUCCESS
			}).submit();
		})(); //<--- FUNCTION %
	});//<<<-------- * END FUNCTION CLICK * ---->>>>



})(jQuery);

$(document).ready(function ()
{
	$('[data-toggle="modal"]').facebox();

	init_custom_tabs();
	function init_custom_tabs()
	{
		var container = $('div.tab-content');
		container.find('[role=custom_tab]:not(.active)').hide();

		$('[role=custom_tablist]').on('click', '[role=custom_tab]', function ()
		{
			var id = $(this).attr('href');

			container.find('[role=custom_tab]').hide();
			container.find(id + '[role=custom_tab]').show();
		});
	}

	(function ($)
	{
		$.fn.goTo = function ()
		{
			var body = $('html, body');

			body.animate({
				scrollTop: body.offset().top + 'px'
			}, 'fast');

			return this;
		}
	})(jQuery);
});


if(typeof Mustache != 'undefined' && typeof Mustache == 'object')(function($) 
{
	$.fn.mustache = function (data, templateFragments) 
	{
		var $self = $(this);
		var template = $self.filter('[type=html/x-mustache-template]');
		if(!template.length) 			throw 'Template is not defined';
		template = template.html().trim();
		var output = Mustache.render(template, data, templateFragments);
		return $(output).get();
	};
})(jQuery);
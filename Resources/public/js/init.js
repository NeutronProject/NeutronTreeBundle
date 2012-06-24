jQuery(document).ready(function() {
	jQuery('.neutron-tree').each(function() { 
		var options = jQuery.parseJSON(jQuery(this).text()); 
		console.log(options);
        var el = jQuery(this).prev();
        
		el.jstree({
			"json_data" : {
				'ajax' : {
					'type': 'POST',
					'url': options.data_uri,
					
					"data" : function (n) { 
						return { nodeId : n.attr ? n.attr("id").replace('li_', '') : 0 }; 
					}
				},
				 "progressive_render" : options.progressiveRender,
				 "progressive_unload": options.progressiveUnload,

			},
			"plugins" : options.plugins
		});
	});
});
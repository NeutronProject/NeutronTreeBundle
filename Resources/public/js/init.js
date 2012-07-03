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
			'ui': (options.plugins.ui == 'undefined') ? {} : options.plugins.ui,
			'contextmenu': { 
				'items': function(){
					var items = 
					{
						'ccp': false,
						'rename': false,
						'remove': false,
					};
					
					if(jQuery.inArray('contextmenu', options.enabledPlugins)){
						var createBtn = {
							'create' : {
								'label': options.plugins.contextmenu.createBtnOptions.label,
								'action'			: function (obj) { 
									var parentId = obj.attr('id').replace('li_', '');
									var uri = decodeURIComponent(options.plugins.contextmenu.createBtnOptions.uri).replace('{parentId}', parentId);
									window.location = uri;
								},
								'_disabled' : options.plugins.contextmenu.createBtnOptions.disabled,		

							}
						};
						
						$items = jQuery.extend(items, createBtn);
					}

					return items;
				}
				
			},
			"plugins" : jQuery.merge(['json_data', 'themes'], options.enabledPlugins)
		});
	});
});
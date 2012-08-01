jQuery(document).ready(function() {
	jQuery('.neutron-tree').each(function() { 
		var options = jQuery.parseJSON(jQuery(this).text()); 
		console.log(options);
        var el = jQuery(this).prev();
        var moving = false;
        
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
				'items': function(node){ 
					var items = 
					{
						'ccp': false,
						'rename': false,
						'remove': false,
					};
					
					if(jQuery.inArray('contextmenu', options.enabledPlugins)){
						var buttons = {
							'_create' : {
								'label': options.plugins.contextmenu.createBtnOptions.label,
								'action': function (obj) { 
									var parentId = obj.attr('id').replace('li_', '');
									var uri = decodeURIComponent(options.plugins.contextmenu.createBtnOptions.uri).replace('{parentId}', parentId);
									window.location = uri;
								},
								'_disabled' : options.plugins.contextmenu.createBtnOptions.disabled,		

							},
							'_update' : {
								'label': options.plugins.contextmenu.updateBtnOptions.label,
								'action': function (obj) { 
									var nodeId = obj.attr('id').replace('li_', '');
									var uri = decodeURIComponent(options.plugins.contextmenu.updateBtnOptions.uri).replace('{nodeId}', nodeId);
									window.location = uri;
								},
								'_disabled' : options.plugins.contextmenu.updateBtnOptions.disabled,	
								
							},
							'_delete' : {
								'label': options.plugins.contextmenu.deleteBtnOptions.label,
								'action': function (obj) { 
									var nodeId = obj.attr('id').replace('li_', '');
									var uri = decodeURIComponent(options.plugins.contextmenu.deleteBtnOptions.uri).replace('{nodeId}', nodeId);
									window.location = uri;
								},
								'_disabled' : options.plugins.contextmenu.deleteBtnOptions.disabled,		
								
							},
						};
						
						$items = jQuery.extend(items, buttons);
						
						if(node.hasClass('tree-root')){
							
							$items._update._disabled = true;
							$items._delete._disabled = true;
						}
						
						if(typeof(options.plugins.types) == 'object'){
							var pluginTypeOpts = options.plugins.types[node.attr('rel')];
							
							if(typeof(pluginTypeOpts) == 'object'){
								$items._create._disabled = pluginTypeOpts.disable_create_btn;
								$items._update._disabled = pluginTypeOpts.disable_update_btn;
								$items._delete._disabled = pluginTypeOpts.disable_delete_btn;
							}
							
						}
						
						
						
					}

					return items;
				}
				
			},
			'crrm' : {
				'move': {
					'check_move': function(m){
						
						if (!m.o.attr('id').replace('li_', '')) {
							return false;
						}
				
						if (m.r.hasClass('tree-root') && (m.p == 'after' || m.p == 'before')){
							return false;
						}
				
						return (moving == false);
					}
				}
			},
			'types': {
				'max_depth': -2,
				'max_children': -2,
				'valid_children': ['root'],
				'types': options.plugins.types,
			},
			"plugins" : jQuery.merge(['json_data'], options.enabledPlugins)
		});
		
		if(jQuery.inArray('crrm', options.enabledPlugins)){
			
			el.bind("move_node.jstree", function (e, data) {		
				moving = true;
				
				var node_id = data.rslt.o.attr("id").replace('li_', '');
				var ref_id = data.rslt.r.attr("id").replace('li_', '');
				var operation = data.rslt.p;
				
				var treeErrorEvent = jQuery.Event('neutron.tree.event.error');
				treeErrorEvent.name = options.name;
				
				var treeCompleteEvent = jQuery.Event('neutron.tree.event.complete');
				treeCompleteEvent.name = options.name;
				
				jQuery.ajax({
					async : true,
					type: 'POST',
					url: options.move_uri, 
					data : {  
						"nodeId" : node_id, 
						"refId" : ref_id,
						"operation" : operation
					},
					error : function(jqXHR, textStatus, errorThrown) {
						jQuery.jstree.rollback(data.rlbk);
						treeErrorEvent.response = null;
						treeErrorEvent.message = errorThrown;
						jQuery("body").trigger(treeErrorEvent);						
					},
					complete : function() {
						moving = false;
						jQuery("body").trigger(treeCompleteEvent);	
					},
					success : function(response) {
						if (response == undefined || response == null || response.success != true){
							jQuery.jstree.rollback(data.rlbk);
							treeErrorEvent.response = response;
							treeErrorEvent.message = 'Application Error';
							jQuery("body").trigger(treeErrorEvent);		
							return ;
						}					
						
					
					}
				});
			});
		}
		
		
	});
});
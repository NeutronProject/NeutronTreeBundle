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
					}

					return items;
				}
				
			},
			'dnd': {
				'drop_finish': function(data){
					alert('');
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
				
						return true;
					}
				}
			},
			"plugins" : jQuery.merge(['json_data', 'themes', 'dnd', 'crrm'], options.enabledPlugins)
		});
		
		el.bind("move_node.jstree", function (e, data) {		
			var node_id = data.rslt.o.attr("id").replace('li_', '');
			var ref_id = data.rslt.r.attr("id").replace('li_', '');
			var position = data.rslt.p;
			
			jQuery.ajax({
				async : true,
				type: 'POST',
				url: options.move_uri, 
				data : {  
					"nodeId" : node_id, 
					"refId" : ref_id,
					"position" : position
				},
				beforeSend: function() {
					timeout = setTimeout(function(){
						
					}, 500);
				},
				error : function() {
					alert('error');								
				},
				complete : function() {
					clearTimeout(timeout);
					
					
				},
				success : function(response) {
					if (response == undefined || response == null){
						alert('error');
						return ;
					}					
					
					if (response.error) {
						
					}
				}
			});
		});
	});
});
jQuery(document).ready(function($) {
            	
	setupRepeaters();
	setupTabs();
	setupImgCheckboxes();
	
});

function setupRepeaters(){

	/*  === Add Row ===  */

	jQuery('.jckTabs').on('click', '.jckAddRow', function(){
		var group = jQuery(this).closest('.jckGroup');
		var row = jQuery(this).closest('.jckGroupRow');
		var clone = row.clone();
		clone.find("script,noscript,style").remove().end().find('input').removeClass('hasTimepicker hasDatepicker').val('');
		row.after(clone);
		jckReindexRepeaters(group);
		jQuery('.cloneTrigger').click();
		return false;
	});
	
	/*  === Remove Row ===  */
	
	jQuery('.jckTabs').on('click', '.jckRmRow', function(){
		var group = jQuery(this).closest('.jckGroup');
		var row = jQuery(this).closest('.jckGroupRow');
		row.remove();
		jckReindexRepeaters(group);
		return false;
	});	            		
	
}

function setupTabs(){
	
	jQuery('.triggerTab').on('click', function(){
		
		/* === Set Nav Tab Active Class === */
		jQuery('.triggerTab').removeClass('nav-tab-active');
		jQuery(this).addClass('nav-tab-active');
		
		/* === Display Tab === */
		var tab = jQuery(this).attr('href');
		jQuery('.jckTabs').removeClass('activeTab');
		jQuery(tab).addClass('activeTab');
		
    	return false;
	});
	
}

function setupImgCheckboxes(){
	
	jQuery('.jckTabs').on('change', '.jckCheckImgInput', function(){
		var parent = jQuery(this).parent();
		if(jQuery(this).prop('checked')){
			parent.addClass('checked');
		} else {
			parent.removeClass('checked');
		}
	});
	
}

/*  === Helper Functions ===  */

function jckReindexRepeaters(group){

	if(group.find(".jckGroupRow").length == 1) {
		group.find(".jckRmRow").hide();
	} else {
		group.find(".jckRmRow").show();
	}
	
	group.find(".jckGroupRow").each(function(index) {
		jQuery(this).removeClass('alternate');
		if(index%2 == 0) jQuery(this).addClass('alternate');
        jQuery(this).find("input").each(function() {
			jQuery(this).attr('name', jQuery(this).attr('name').replace(/\[\d+\]/, '['+index+']'));
			jQuery(this).attr('id', jQuery(this).attr('id').replace(/\-id\d+\-/, '-id'+index+'-'));
        });
    });
}
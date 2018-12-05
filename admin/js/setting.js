jQuery(document).ready(function(){
	jQuery("#update_beacon_values").click(function(e){
		e.preventDefault();
		 if(jQuery("#beacon_enable").prop("checked") == true){
                var beacon_enable = '1'; 
            }else{
            	var beacon_enable = '0';

            }
		var beaconId = jQuery("#beacon_id").val();
		jQuery.ajax({
			type:"post",
			url:ajaxurl,
			data:{
				action:"update_beacon_values",
				beaconId:beaconId,beacon_enable:beacon_enable,
			},
			success:function(data){
				location. reload(true);
			}
		});
	});
});
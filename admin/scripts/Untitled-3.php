<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
<title>Untitled Document</title>
            <script type="text/javascript">
        var markers = [{ 'latitude': 3.0369755, 'longitude': 101.4892917 }];
        var option = { exclude:['nearby','construction'],tab:'map' };
        
        function load_gmap_service(){
			if(delay_loading) {
				var script = document.createElement("script");
				script.type = "text/javascript";     
				script.src = "http://maps.google.com/maps?file=api&v=2.225&key="+GMAP_KEY+"&sensor=false&async=2";
				document.body.appendChild(script);
				delay_loading = false;
			}
		}

        function showGoogleMap(){
        	load_gmap_service();
            var margin = ($(window).height() < 725) ? 60 : 100;
            var map_width = 760;
            //var map_height = ($(window).height() < 725) ? 320 : $(window).height()-425;
            var map_height = $(window).height()-margin-90;
            var excludes = '';
            if (option && option.exclude) {
                for (ex in option.exclude) excludes += '&exclude[' + option.exclude[ex] + ']=1';
            }
            var src = '/ps_dialog_nearby_map&lat=3.0369755&lng=101.4892917' + excludes + ((option && option.tab)? '&tab=' + option.tab : '') + '&map_width='+map_width+'&map_height='+map_height+'&frame_height='+($(window).height()-90-margin);
            loadDialog(810, $(window).height()-margin, 'Location Map', src, null, null, false);
        }

        function showMap(){
	    	load_gmap_service();
    	    var margin = ($(window).height() < 725) ? 60 : 100;
        	var map_width = 760;
		    //var map_height = ($(window).height() < 725) ? 320 : $(window).height()-425;
	        var map_height = $(window).height()-margin-90;
    	    var excludes = '';
        	if (option && option.exclude) {
            	for (ex in option.exclude) excludes += '&exclude[' + option.exclude[ex] + ']=1';
	        }
    	    var src = '/ps_dialog_nearby_map&lat=3.0369755&lng=101.4892917' + excludes + ((option && option.tab)? '&tab=' + option.tab : '') + '&map_width='+map_width+'&map_height='+map_height+'&frame_height='+($(window).height()-90-margin);
        	loadDialog(810, $(window).height()-margin, 'Location Map', src, null, null, false);
    	}
	
        $(document).ready(function() {
            if(!delay_loading){
                propertydetailmap();
            }
        });
    </script>
    </head>

<body>
</body>
</html>

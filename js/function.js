
var timeoutHandle;
function countdown(linkid,userid,minutes,stat) {
	
	//alert('In countdown function');
	var seconds = 60;
	var mins    = minutes;
	//alert(getCookie("linkid"));
	/* if(getCookie("minutes")&&getCookie("seconds")&&stat)
	{
		 var seconds = getCookie("seconds");
    	 var mins = getCookie("minutes");
		 //alert('seconds'+seconds);
		 //alert('min'+mins);
		} */

		function tick()
		{

			var counter = document.getElementById("timer");
			//setCookie("minutes",mins,10)
			//setCookie("seconds",seconds,10)
			var current_minutes = mins-1
			seconds--;
			counter.innerHTML   = current_minutes.toString() + ":" + (seconds < 10 ? "0" : "") + String(seconds);
		//save the time in cookie
		//alert(mins);
		//alert(seconds);
		if ( current_minutes == 5 )
		{
			if(seconds == 0)
			{
				alert('Five minutes remaining. Please save your inputs');
			}
		}	
		if ( current_minutes == 0 )
		{
			if(seconds == 0)
			{
				$("#execute_input").hide();
				alert('You have compeleted yor time. Please submit your changes.');
				$('.overlay').show();
      	// while auto submit then remove all required from inputs
      	$('input').each(function(){
      		$(this).prop('required',false);
      	});
      	$('#submit').trigger('click');
      	// location.reload();
				//document.forms["game_frm"].submit();
			}
		}

		if( seconds > 0 )
		{
			timeoutHandle=setTimeout(tick, 1000);
		}
		else
		{
			if(mins > 1)
			{
				// countdown(mins-1);   never reach “00? issue solved:Contributed by Victor Streithorst    
				setTimeout(function () { countdown(linkid,userid,parseInt(mins)-1,false); }, 1000);
			}
				//Add or Update timer in link and user wise....
					//alert(mins);
					$.ajax({
						type: "POST",
						url : "includes/ajax/ajax_update_execute_input.php",
						data: '&action=SaveTimer&linkid='+linkid+'&userid='+userid+'&timer='+mins,
						beforeSend: function() {

						},
						success: function(result) 
					{ //alert(result);
						//return true;
					}
				});
				}
			}
			tick();
		}
		function deletecookie(cname) {
	//alert(cname);
	document.cookie = cname +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
/* function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires;
}
 function getCookie(cname){
	 //alert('In getCookie function');
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
  } */

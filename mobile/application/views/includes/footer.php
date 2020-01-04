
</section>
<!-- model starts here-->
<!-- hiding this button by default, and trigger click whenever this is requred -->
<button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#ModalCenter" id="showModalCenter">
	Launch demo modal
</button>

<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>
<!-- model ends here-->
</body>
<script>
	$(document).ready(function(){
		// var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		// var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
		$('[data-toggle="tooltip"]').tooltip();
		// show pre-loader when ajax starts
		$(document).ajaxStart(function(){
			$('#pre-loader').show();
		});
		// hide pre-loader when ajax starts
		$(document).ajaxComplete(function(){
			$('#pre-loader').hide();
			$('[data-toggle="tooltip"]').tooltip();
		});
		$('.notAllowedToPlay').each(function(){
			$(this).on('click',function(){
				var startDate = $(this).data('startdate');
				var endDate   = $(this).data('enddate');
				var gameName  = $(this).data('gamename');
				var imageUrl  = $(this).data('imageurl');

				Swal.fire({
					imageUrl   : imageUrl,
					imageWidth : 200,
					imageHeight: 100,
					imageAlt   : 'Custom image',
					icon       : 'error',
					title      : '',
					html       : 'You are allowed to play <b>"'+gameName+'"</b> from <b>"'+startDate+'"</b> to <b>"'+endDate+'"</b>',
					// footer: '<a href>Why do I have this issue?</a>'
					showCancelButton  : true,
					showConfirmButton : false,
					cancelButtonColor : '#3085d6',
					footer            : ''
				});
			});
		});
		// when user choose replay then reset all the data
		$('.replaySimulation').each(function(){
			$(this).on('click',function(){
				var gameid   = $(this).data('gameid');
				var imageUrl = $(this).data('imageurl');

				Swal.fire({
					imageUrl          : imageUrl,
					imageWidth        : 200,
					imageHeight       : 100,
					imageAlt          : 'Custom image',
					title             : 'Are you sure?',
					text              : "Press YES to confirm your wish to play this simulation again else press NO",
					icon              : 'question',
					showCancelButton  : true,
					confirmButtonColor: '#5cb85c',
					cancelButtonColor : '#d33',
					confirmButtonText : 'Yes, Reset!',
					cancelButtonText  : 'No, Cancel!'
				}).then((result) => {
					if (result.value)
					{
						// trigger ajax to reset game data
						$.ajax({
							url     : '<?php echo base_url("Ajax/resetGameData/");?>'+gameid,
							type    : 'POST',
		          // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		          data    : {[csrfName]: csrfHash},
		          success: function(result){
		          	try
		          	{
		          		var result = JSON.parse( result );
		          		// updating csrf token value
		          		csrfHash = result.csrfHash;
		          		if(result.status.trim() == 200)
		          		{
		          			// if reset successfully then refresh the page
		          			window.location = "<?php echo base_url("SelectSimulation");?>";
		          		}
		          		else
		          		{
		          			swal.fire('Something went wrong. Please try later.');
		          			console.log(result);
		          		}
		          	}
		          	catch ( e )
		          	{
		          		swal.fire('Something went wrong. Please try later.');
		          		console.log(e + "\n" + result);
		          		window.location = "<?php echo base_url("Login");?>";
		          	}
		          }
		        });
					}
					// show on cancel
					// else
					// {
					// 	Swal.fire({
					// 		title: 'Custom animation with Animate.css',
					// 		showClass: {
					// 			popup: 'animated fadeInDown faster'
					// 		},
					// 		hideClass: {
					// 			popup: 'animated fadeOutUp faster'
					// 		}
					// 	})
					// }

				})					
			});
		});
		// window.addEventListener("beforeunload", function(e) {
		// 	// Cancel the event
		// 	e.preventDefault();
  // 		// Chrome requires returnValue to be set
  // 		e.returnValue = 'return some value here...';
  // 	});
  // show full image while clicking on image
  // $('.showImageModal').each(function(){
  // 	$(this).on('click',function(){
  // 		var imgSrc   = $(this).attr('src');
  // 		var imgTitle = $(this).attr('title');
  // 		$('#showModalCenter').trigger('click');
  // 		$('#modal-body').html('<center><img src="'+imgSrc+'" width="100%"></center>');
  // 		$('#exampleModalCenterTitle').text(imgTitle);
  // 		alert('clicked');
  // 	});
  // });
});

function showImageOnFullScreen(imageId)
{
	// show full image while clicking on image
	// console.log(imageId+' is clicked');
	var imgSrc   = $('#'+imageId).attr('src');
	var imgTitle = $('#'+imageId).attr('title');
	// $('#showModalCenter').trigger('click');
	// $('#modal-body').html('<center><img src="'+imgSrc+'" width="100%"></center>');
	// $('#exampleModalCenterTitle').text(imgTitle);
	// showing image into sweetalert model instead of normal bootstrap modal
	Swal.fire({
		// imageWidth : 200,
		// imageHeight: 100,
		// icon       : 'success',
		// html       : imgTitle,
		// footer: '<a href>Why do I have this issue?</a>'
		imageUrl         : imgSrc,
		imageAlt         : imgTitle,
		title            : imgTitle,
		showCancelButton : true,
		showConfirmButton: false,
		cancelButtonColor: '#dc3545',
		footer           : ''
	});
}

function countDown(time,status)
{
	var seconds = 59;
	if(status)
	{
		if(time < 1)
		{
				// if time is completed then submit the page
				$('#submitPage').trigger('click');
				return false;
			}

			time--;
			time   = appendZero(time);
			status = false;
		}
		myTimer = setInterval(function()
		{
			$('#showTimer').text(time+":"+seconds);
			seconds--;
			seconds = appendZero(seconds);

			if(time == 0 && seconds == 0)
			{
				$('#showTimer').text(time+":"+seconds);
				clearInterval(myTimer);
        // if time is completed then submit the page
        $('#submitPage').trigger('click');
      }
      if(seconds == 0)
      {
      	seconds = 59;
      	if(time>0)
      	{
      		time--;
      		seconds
      		time = appendZero(time);
      	}
      	// trigger ajax to update timer "
      	$.ajax({
      		url   : "<?php echo (isset($findLinkage->Link_ID))?base_url('Ajax/updateTimerWhilePlaying/'.$findLinkage->Link_ID):'';?>",
      		type  : 'POST',
      		data  : {[csrfName]: csrfHash},
      		global: false, // this is used to prevent the ajaxStart function
      		success: function(result){
      			try
      			{
      				var result = JSON.parse( result );
          		// updating csrf token value
          		csrfHash = result.csrfHash;
          		if(result.status.trim() == 200)
          		{
          			console.log('timer is updated');
          		}
          		else
          		{
          			swal.fire('Something went wrong(timer). Please try later.');
          			console.log(result);
          		}
          	}
          	catch ( e )
          	{
          		swal.fire('Something went wrong. Please try later.');
          		console.log(e + "\n" + result);
          	}
          }
        });
      }
    },1000);
	}

	function appendZero(value)
	{
		if(value<10)
		{
			value = '0'+value;
			return value;
		}
		else
		{
			return value;
		}
	}

	function testAnim(x,value) {
		$('#animationSandbox').show();
		$('#site__title').text(value);
		$('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass();
		});
	};
</script>
</html>
<!-- test animation values -->
<!-- bounce, flash, pulse, rubberBand, shake, headShake, swing, tada, wobble, jello, bounceIn, bounceInDown, bounceInLeft, bounceInRight, bounceInUp, bounceOut, bounceOutDown, bounceOutLeft, bounceOutRight, bounceOutUp, fadeIn, fadeInDown, fadeInDownBig, fadeInLeft, fadeInLeftBig, fadeInRight, fadeInRightBig, fadeInUp, fadeInUpBig, fadeOut, fadeOutDown, fadeOutDownBig, fadeOutLeft, fadeOutLeftBig, fadeOutRight, fadeOutRightBig, fadeOutUp, fadeOutUpBig, flipInX, flipInY, flipOutX, flipOutY, lightSpeedIn, lightSpeedOut, rotateIn, rotateInDownLeft, rotateInDownRight, rotateInUpLeft, rotateInUpRight, rotateOut, rotateOutDownLeft, rotateOutDownRight, rotateOutUpLeft, rotateOutUpRight, hinge, jackInTheBox, rollIn, rollOut, zoomIn, zoomInDown, zoomInLeft, zoomInRight, zoomInUp, zoomOut, zoomOutDown, zoomOutLeft, zoomOutRight, zoomOutUp, slideInDown, slideInLeft, slideInRight, slideInUp, slideOutDown, slideOutLeft, slideOutRight, slideOutUp, heartBeat -->
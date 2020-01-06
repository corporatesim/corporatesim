<style>
	.swal-size-sm{
		width: auto;
	}
</style>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<span> </span>
			</div>
		</div>
	</div>
</footer>

<!--<script src="js/jquery.min.js"></script>	-->
<!-- <script src="js/bootstrap.min.js"></script>			 -->
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo site_root; ?>assets/components/metisMenu/dist/metisMenu.min.js?v=<?php echo version;?>"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo site_root; ?>assets/dist/js/sb-admin-2.js?v=<?php echo version;?>"></script>
<script>
	
	$(document).ready(function() {
		$('input[type="search"]').on('focusin',function(){
			$(this).animate({width: "400px"});
		});

		$('input[type="search"]').on('focusout',function(){
			$(this).animate({width: "200px"});
		});
		// adding the restart/reset functionality
		$('.restart').each(function(){
			$(this).on('click',function(e){
				// var effectIn  = animateInArray[countInclick];
				// var effectOut = animateOutArray[countOutclick];
				e.stopPropagation();
				// var senderElement = e.target;
				// // if it has div.reduce_width then, if senderElement is img tag then stop event propagation for parent, i.e. not to redirect to result.php
				// if($(this).parents('div.reduce_width'))
				// if($(senderElement).is('img'))
				// {
				// 	// then disable click event propagation for parents div, i.e. result.php
				// 	console.log('remove event from parent');
				// }
				// console.log(senderElement);
				// return false;
				var GameID = $(this).attr('data-gameid');
				var ScenID = $(this).attr('data-scenid');
				var LinkID = $(this).attr('data-linkid');
				const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-success',
						cancelButton : 'btn btn-danger'
					},
					buttonsStyling: false,
				})

				swalWithBootstrapButtons.fire({
				// title: 'Are you sure?',
				text             : "Press YES to confirm your wish to play this simulation again else press NO",
				icon             : 'warning',
				showCancelButton : true,
				confirmButtonText: 'Yes, Reset !',
				cancelButtonText : 'No, cancel !',
				reverseButtons   : false,
				showClass: {
					popup: 'animated rotateInDownLeft faster'
					// popup: 'animated '+effectIn+' faster'
				},
				hideClass: {
					popup: 'animated rotateOutDownLeft faster'
					// popup: 'animated '+effectOut+' faster'
				}
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url : "includes/ajax/ajax_replay.php",
						type: "POST",
						data: "action=replay&GameID="+GameID+'&ScenID='+ScenID+'&LinkID='+LinkID,
						beforeSend: function(){
							$('.overlay').show();
						},
						success:function(result)
						{
							if(result == 'redirect')
							{
								// alert('Redirect User to input page');
								window.location = "<?php echo site_root.'selectgame.php'?>";
							} 
							else
							{
								$('.overlay').hide();
								// alert('Connection Problem');
								Swal.fire('Connection Problem');
								console.log(result);
							}
						}
					});
					// swalWithBootstrapButtons.fire(
					//   'Deleted!',
					//   'Your file has been deleted.',
					//   'success'
					//   )
				}
				//     else if (
				// // Read more about handling dismissals
				// result.dismiss === Swal.DismissReason.cancel
				// ) {
				//       swalWithBootstrapButtons.fire(
				//         'Cancelled',
				//         'Your imaginary file is safe :)',
				//         'error'
				//         )
				//     }
			})
			// countInclick++;
			// countOutclick++;
			// countInclick  = (countInclick == animateInArray.length)?0:countInclick;
			// countOutclick = (countOutclick == animateOutArray.length)?0:countOutclick;
		}); 
		});

		// show game leaderboard to user
		$('#showLeaderboard').click(function(){
			$.ajax({
				url : "includes/ajax/ajax_replay.php",
				type: "POST",
				data: {'action':'leaderboard', 'gameid':<?php echo ($gameid)?$gameid:'0'; ?>},
				complete: function(){
					$('[data-toggle="tooltip"]').tooltip();
					showImagePopUp();
				},
				success : function(result)
				{
					result = JSON.parse(result);
					if(result.status == 200)
					{
						Swal.fire({
							// icon             : 'success',
							title            : 'Leaderboard',
							html             : result.message,
							showConfirmButton: true,
							customClass      : 'swal-size-sm',
							showClass: {
								popup: 'animated bounceInRight faster'
							},
							hideClass: {
								popup: 'animated lightSpeedOut faster'
							}
						});
					} 
					else
					{
						Swal.fire({
							icon             : 'error',
							title            : '',
							html             : result.message,
							showConfirmButton: true,
							showClass: {
								popup: 'animated bounceInRight faster'
							},
							hideClass: {
								popup: 'animated lightSpeedOut faster'
							}
						});
						// console.log(result);
					}
				},
				error: function(jqXHR, exception)
				{
					Swal.fire({
						icon: 'error',
						html: jqXHR.responseText,
					});
					console.log(result);
					console.log(jqXHR);
				}
			});
		});
		showImagePopUp();
	});

	function showImagePopUp(){
		// show image pop up into alert form
		$('.showImagePopUp').each(function(){
			$(this).on('click', function(){
				var imageUrl = $(this).attr('src');
				// alert(this.width + 'x' + this.height);
				Swal.fire({
					// imageWidth       : 200,
					// imageHeight      : 100,
					imageUrl         : imageUrl,
					imageAlt         : 'Profile image',
					icon             : 'success',
					title            : '',
					showConfirmButton: true,
					showClass: {
						popup: 'animated flip faster'
					},
					hideClass: {
						popup: 'animated lightSpeedOut faster'
					}
					// html             : 'You are allowed to play <b>"'+gameName+'"</b> from <b>"'+startDate+'"</b> to <b>"'+endDate+'"</b>',
					// footer           : '<a href>Why do I have this issue?</a>'
					// showCancelButton : false,
					// cancelButtonColor: '#3085d6',
					// footer           : ''
				});
			});
		});
	}
</script>

<script>
	function searchGame() {

		var input, filter, cards, cardContainer, h5, title, i;
		input         = document.getElementById("myFilter");
		filter        = input.value.toUpperCase();
		cardContainer = document.getElementById("simulationGames");
		cards         = cardContainer.getElementsByClassName("col-md-4");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body h3.card-title");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				cards[i].style.display = "";
			} else {
				cards[i].style.display = "none";
			}
		}
	}

	function searcheLearning()
	{
		var input, filter, cards, cardContainer, h5, title, i;
		input         = document.getElementById("myeLearning");
		filter        = input.value.toUpperCase();
		cardContainer = document.getElementById("simulationElearning");
		cards         = cardContainer.getElementsByClassName("col-md-4");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body h3.card-title");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				cards[i].style.display = "";
			} else {
				cards[i].style.display = "none";
			}
		}
	}
	function searchassessment()
	{
		var input, filter, cards, cardContainer, h5, title, i;
		input         = document.getElementById("myAssessment");
		filter        = input.value.toUpperCase();
		cardContainer = document.getElementById("simulationAssesment");
		cards         = cardContainer.getElementsByClassName("col-md-4");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body h3.card-title");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				cards[i].style.display = "";
			} else {
				cards[i].style.display = "none";
			}
		}
	}
</script>

</body>
</html>
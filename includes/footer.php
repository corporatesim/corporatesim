<style>
	.swal-size-sm {
		width: auto;
	}
	.swal-size-90 {
		width: 90%;
	}
	.progress-bar.active, .progress.active .progress-bar{
		animation: progress-bar-stripes 2s reverse linear infinite;
		-webkit-animation: progress-bar-stripes 2s reverse linear infinite;
	}

	.buttonclick {
		background-color: #22ACC3;
		color: #fff;
		padding: 10px;
		border: 2px solid #19616f;
		font-size: 15px;
		border-radius: 5px !important;
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
<script src="<?php echo site_root; ?>assets/components/metisMenu/dist/metisMenu.min.js?v=<?php echo version; ?>"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo site_root; ?>assets/dist/js/sb-admin-2.js?v=<?php echo version; ?>"></script>
<script>
	$(document).ready(function() {
		// show guide popup
		$('#showGuide').on('click', function() {
			const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-success',
					cancelButton: 'btn btn-danger',
					popup: 'swal-size-sm',
				},
				buttonsStyling: false,
			});
			swalWithBootstrapButtons.fire({
				// icon: 'success',
				title: ' ',
				html: '<section id="modal-plans"><div class="wrapper"><div class="col-md-4 col-sm-6 col-xs-12"><h2 style="color: #d8853e;margin-top:-20px;margin-left: -40px;"><strong>Guide</strong></h2><p style="font-size: 15px;margin-left: -36px;"><strong>Click below for details</strong></p><div class="img-links"><ul style="list-style-type: none;"><li style="text-align: left;margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding:6px 57px;" id="0" value="Screen"></li><li style="text-align: left;margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding: 6px 56px;" id="1" value="Section"></li><li style="text-align: left;margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding: 6px 51px;" id="2" value="Scenario"></li><li style="text-align: left;margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding: 6px 64px;" id="3" value="Card"></li></ul></div></div><div class="col-md-8 col-sm-6 col-xs-12"><div class="featured-img"><img src="https://corpsim.in/corporatesim/picvid/Sapna/default.png" width="80%" alt="" style="margin-left:50px;"></div></div></div></section>',
				showConfirmButton: false,
				showCancelButton: true,
				cancelButtonText: 'Close',
			});

			imgSrcArray = ["https://corpsim.in/corporatesim/picvid/Sapna/screen.png", "https://corpsim.in/corporatesim/picvid/Sapna/section.png", "https://corpsim.in/corporatesim/picvid/Sapna/scenario.png", "https://corpsim.in/corporatesim/picvid/Sapna/card.png"];

			function changeImg(arrayIndex) {}
			$('.buttonclick').each(function() {
				$(this).on('click', function() {
					var arrayIndex = $(this).attr('id');
					$('.featured-img img').attr('src', imgSrcArray[arrayIndex]);
					// console.log(arrayIndex);
				});
			});
		});
		// end of showing guide popup
		$('.FullName').text("<?php echo 'Name: ' . $user_data[0]->FullName; ?>");
		// setting the ent name, if the user is ent user
		<?php if (empty($user_data[0]->SubEnterprise_Name)) { ?>
			$('.OrganizationName').text("<?php echo 'Organization Name: ' . $user_data[0]->Enterprise_Name; ?>");
		<?php } else { ?>
			// setting the sub_ent name, if the user is sub_ent user
			$('.OrganizationName').text("<?php echo 'Organization Name: ' . $user_data[0]->SubEnterprise_Name; ?>");
		<?php } ?>

		$('input[type="search"]').on('focusin', function() {
			$(this).animate({
				width: "400px"
			});
		});

		$('input[type="search"]').on('focusout', function() {
			$(this).animate({
				width: "200px"
			});
		});
		// adding the restart/reset functionality
		$('.restart').each(function() {
			$(this).on('click', function(e) {
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
						cancelButton: 'btn btn-danger'
					},
					buttonsStyling: false,
				})

				swalWithBootstrapButtons.fire({
					// title: 'Are you sure?',
					text: "You will not be able to access your current results anymore by clicking the green button. If you are allowed then download and save the result file before resetting for replay",
					icon: 'question',
					showCancelButton: true,
					confirmButtonText: 'Yes, Reset !',
					cancelButtonText: 'No, cancel !',
					reverseButtons: false,
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
							url: "includes/ajax/ajax_replay.php",
							type: "POST",
							data: "action=replay&GameID=" + GameID + '&ScenID=' + ScenID + '&LinkID=' + LinkID,
							beforeSend: function() {
								$('.overlay').show();
							},
							success: function(result) {
								if (result == 'redirect') {
									// alert('Redirect User to input page');
									window.location = "<?php echo site_root . 'selectgame.php' ?>";
								} else {
									$('.overlay').hide();
									// Swal.fire('Connection Problem');
									Swal.fire('Long time inactivity! Please refresh screen (ctrl+shft+R) to continue.');
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
		$('#showLeaderboard').click(function() {
			$.ajax({
				url: "includes/ajax/ajax_replay.php",
				type: "POST",
				data: {
					'action': 'leaderboard',
					'gameid': <?php echo ($gameid) ? $gameid : '0'; ?>
				},
				complete: function() {
					$('[data-toggle="tooltip"]').tooltip();
					showImagePopUp();
				},
				success: function(result) {
					result = JSON.parse(result);
					if (result.status == 200) {
						Swal.fire({
							// icon             : 'success',
							title: 'Leaderboard',
							html: result.message,
							showConfirmButton: true,
							customClass: 'swal-size-sm',
							showClass: {
								popup: 'animated bounceInRight faster'
							},
							hideClass: {
								popup: 'animated lightSpeedOut faster'
							}
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: '',
							html: result.message,
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
				error: function(jqXHR, exception) {
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
		setTimeout(function() {
				showProgressbarData();
			},
			100);
	});

	function showImageModal() {
			$('marquee').each(function() {
				$(this).on('mouseover', function() {
					this.stop();
				});
				$(this).on('mouseout', function() {
					this.start();
				});
			});

			$('.showImageModal').each(function() {
				$(this).on('click', function() {
					var srcImage = $(this).attr('src');
					const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-success',
						cancelButton: 'btn btn-danger',
						popup: 'swal-size-90',
				},
				buttonsStyling: false,
			});
			var showButtons = '<button type="button" class="btn btn-primary showPreviousImage" id="showPreviousImage" title="Previous"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" /></svg></button> <button type="button" class="btn btn-danger" onclick="return Swal.close();">Cancel</button> <button type="button" class="btn btn-primary showNextImage" id="showNextImage" title="Next" style="margin-left: 2px;"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" /></svg></button>';
			// next and previous image show on click feature need to be added like showNextPreviousImage()
			swalWithBootstrapButtons.fire({
						title : '',
						imageUrl : srcImage,
						imageAlt : 'Custom image',
						// html: showButtons,
						showConfirmButton: false,
						showCancelButton: true,
						cancelButtonText: 'Close',
						focusCancel: false,
						showCloseButton: true,
						closeButtonHtml: "<span style='font-size:50px; color:#fb5300; margin: -15px 0px 0px -5px; font-weight: bold;'>&times;</span>",
						showClass: {
						popup: 'animated fadeIn faster'
						},
						hideClass: {
							popup: 'animated fadeOut faster'
						},
					});
				});
			});
		}

	function showImagePopUp() {
		// show image pop up into alert form
		$('.showImagePopUp').each(function() {
			$(this).on('click', function() {
				var imageUrl = $(this).attr('src');
				// alert(this.width + 'x' + this.height);
				Swal.fire({
					// imageWidth       : 200,
					// imageHeight      : 100,
					imageUrl: imageUrl,
					imageAlt: 'Profile image',
					icon: 'success',
					title: '',
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
		input = document.getElementById("myFilter");
		filter = input.value.toUpperCase();
		cardContainer = document.getElementById("simulationGames");
		cards = cardContainer.getElementsByClassName("col-md-4");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body h3.card-title");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				cards[i].style.display = "";
			} else {
				cards[i].style.display = "none";
			}
		}
	}

	function searcheLearning() {
		var input, filter, cards, cardContainer, h5, title, i;
		input = document.getElementById("myeLearning");
		filter = input.value.toUpperCase();
		cardContainer = document.getElementById("simulationElearning");
		cards = cardContainer.getElementsByClassName("col-md-4");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body h3.card-title");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				cards[i].style.display = "";
			} else {
				cards[i].style.display = "none";
			}
		}
	}

	function searchassessment() {
		var input, filter, cards, cardContainer, h5, title, i;
		input = document.getElementById("myAssessment");
		filter = input.value.toUpperCase();
		cardContainer = document.getElementById("simulationAssesment");
		cards = cardContainer.getElementsByClassName("col-md-4");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body h3.card-title");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				cards[i].style.display = "";
			} else {
				cards[i].style.display = "none";
			}
		}
	}

	function showProgressbarData() {
		// trigering ajax to show the progress bar data
		fetch('includes/ajax/ajax_replay.php', {
				method: 'post',
				headers: {
					'Accept': 'application/json, text/plain, */*',
					"Content-type": "application/x-www-form-urlencoded;"
					// "Content-type": "application/json;"
				},
				body: "action=progress&gameid=<?php echo $gameid; ?>&userid=<?php echo $userid; ?>&page=<?php echo $_SERVER['SCRIPT_NAME'];?>"
			}).then(function(response) {
				return response.json();
			})
			.then(
				function(response) {
					if (response.status !== 200) {
						console.log('Looks like there was a problem while fetching progress bar data.\nStatus Code: ' +
							response.status+'.\nMsg: '+response.message);
						return;
					} else {
						// console.log(response);
						// console.log('<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="' + response.appendData + '" aria-valuemin="0" aria-valuemax="' + response.appendData + '" style="width:' + response.appendData + '%">' + response.appendData + '%</div>');
						// $('#progressbarData').html('<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="' + response.appendData + '" aria-valuemin="0" aria-valuemax="' + response.appendData + '" style="width:' + response.appendData + '%"></div>');
						$('#progressbarData').html(response.appendHtml);
					}

					// // Examine the text in the response
					// response.json().then(function(data) {
					// 	console.log('append data here');
					// 	console.log(data);
					// });
				}
			)
			.catch(function(err) {
				console.log('Fetch Error :-S', err);
			});
	}

	function showNextPreviousImage(element, classOfSuperParentDiv)
	{
		// console.log(element);
		var showButtons = '<button type="button" class="btn btn-primary showPreviousImage" id="showPreviousImage" title="Previous"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" /></svg></button> <button type="button" class="btn btn-danger" onclick="return Swal.close();">Close</button> <button type="button" class="btn btn-primary showNextImage" id="showNextImage" title="Next" style="margin-left: 2px;"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" /></svg></button>';
		var imageUrl  = $(element).attr('src');
		const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-success',
					cancelButton: 'btn btn-danger',
					popup: 'swal-size-90',
				},
				buttonsStyling: false,
			});
			swalWithBootstrapButtons.fire({
			// imageWidth       : 200,
			// imageHeight      : 100,
			// icon             : 'success',
			title            : '',
			imageUrl         : imageUrl,
			imageAlt         : 'Custom image',
			html: showButtons,
			showConfirmButton: false,
			showCloseButton: true,
			closeButtonHtml: "<span style='font-size:30px; color:#fb5300;'>&times;</span>",
			// showCancelButton: true,
			showClass: {
				popup: 'animated fadeIn faster'
			},
			hideClass: {
				popup: 'animated fadeOut faster'
			}
			// html             : 'You are allowed to play <b>"'+gameName+'"</b> from <b>"'+startDate+'"</b> to <b>"'+endDate+'"</b>',
			// footer           : '<a href>Why do I have this issue?</a>'
			// showCancelButton : false,
			// cancelButtonColor: '#3085d6',
			// footer           : ''
		});
		showNextImage(element, classOfSuperParentDiv);
		showPreviousImage(element, classOfSuperParentDiv);
	}

	function showNextImage(clickedImage, classOfParentDivHavingImage)
	{
		// console.log($(clickedImage).parents('.'+classOfParentDivHavingImage)); console.log(classOfParentDivHavingImage);
		$('.showNextImage').on('click', function(){
			// console.log(clickedImage); console.log(classOfParentDivHavingImage)
			$(clickedImage).parents('.'+classOfParentDivHavingImage).next().find('img').trigger('click');
		});
	}

	function showPreviousImage(clickedImage, classOfParentDivHavingImage)
	{
		// console.log($(clickedImage).parents('.'+classOfParentDivHavingImage)); console.log(classOfParentDivHavingImage);
		$('.showPreviousImage').on('click', function(){
			// console.log(clickedImage); console.log(classOfParentDivHavingImage)
			$(clickedImage).parents('.'+classOfParentDivHavingImage).prev().find('img').trigger('click');
		});
	}
</script>

</body>

</html>
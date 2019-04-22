<div class="col-md-3">
	<nav class="navbar navbar-inverse settings-nav">
		<div class="container-fluid" >
			<div class="side-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
			</div>
			<div class="collapse sidebar navbar-collapse" id="myNavbar" style="" >
				<div class="vertical-menu" style="margin-top:25px; margin-left:-20px;">
					<a style="width:295px;" href="selectgame.php" class="<?php echo ($_SESSION['userpage'] == 'selectgame')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-bishop"></i> Assigned Modules</a>
					<a style="width:295px;" href="gameCatalogue.php" class="<?php echo ($_SESSION['userpage'] == 'gameCatalogue')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-knight"></i> Simulation</a>
					<a style="width:295px;" href="eLearning.php" class="<?php echo ($_SESSION['userpage'] == 'eLearning')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-book"></i>eLearning</a>
					<a style="width:295px;" href="Assesment.php" class="<?php echo ($_SESSION['userpage'] == 'Assesment')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-book"></i>Assessment</a>
					<a style="width:295px;" href="settings.php" class="<?php echo ($_SESSION['userpage'] == 'settings')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-cog"></i>  Settings</a>
					<a style="width:295px;" href="my_profile.php" class="<?php echo ($_SESSION['userpage'] == 'my_profile')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-user"></i> My Profile</a>
					<a style="width:295px;" href="Feedback.php" class="<?php echo ($_SESSION['userpage'] == 'Feedback')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-envelope"></i> Feedback</a>
				</div>
			</div>
		</div>
	</nav>
</div>
<script>
	function searchGame() {
		var input, filter, cards, cardContainer, h5, title, i;
		input         = document.getElementById("myFilter");
		filter        = input.value.toUpperCase();
		cardContainer = document.getElementById("myItems");
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
<center style="margin: 15%;">
  <div>
    <h3>vimeo video</h3>
    <iframe id="vimeoVideo" frameborder="0" height="250" src="https://player.vimeo.com/video/389906452?autoplay=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;controls=0" autoplay="" allow="autoplay; fullscreen" allowfullscreen="" style="margin-top: -5%;margin-left: 15px;" width="100%"></iframe>
  </div>
  <br>
  </div>
  <div>
    <h3>YouTube video</h3>
    <iframe id="youtubeVideo" width="560" height="315" src="https://www.youtube.com/embed/?mute=1;autoplay=1" type="text/html" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen allow="autoplay;"></iframe>
  </div>
  <br><br>
  <div id="ytplayer"></div>


</center>

<script>
  $(document).ready(function() {
    // alert('hello');
    $('#youtubeVideo').attr('src', 'https://www.youtube.com/embed/OOPlVOZop50?autoplay=1');
    // $('#vimeoVideo').src('https://www.youtube.com/embed/OOPlVOZop50?autoplay=1');
    onYouTubePlayerAPIReady();

    // Load the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    // Replace the 'ytplayer' element with an <iframe> and
    // YouTube player after the API code downloads.
    var player;

    function onYouTubePlayerAPIReady() {
      player = new YT.Player('ytplayer', {
        height: '360',
        width: '640',
        videoId: 'OOPlVOZop50'
      });
    }
  });
</script>
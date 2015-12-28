<div id="footer">
	<div class="fb">
		<img src="images/icon/fb.png">&nbsp;<a href="https://www.facebook.com/diggyshelper"
		target="_blank">Facebook Diggy's Helper</a>
	</div>
	<div class="git">
		<img src="images/icon/git.png">&nbsp;<a href="https://github.com/Kubo2/diggyshelper"
		target="_blank">GitHub Diggy's Helper</a>
	</div>
	<div class="copy">
		&copy;&nbsp;2015&nbsp;Diggy's Helper / Vladimír WladinQ Jacko &amp; Jakub Kubo2 Kubíček
	</div>
</div>

<script src="<?= @ $absUrl ?: '.' ?>/diggyshelper.js?v=20150812@1.5-alpha2" async></script>

<?php // Google Analytics tracking code ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
</script><script>
// initialize the tracker
  ga('create', 'UA-37444056-2', 'auto');
  ga(function(tracker) {
  	// set correct title for topics page
  	if(location.pathname.substr(-15) == '/view_topic.php') {
  		tracker.set('title', document.getElementById('content').getElementsByTagName('h1')[0].textContent);
  	}

  	// track clicks to user profiles through topic listing
  	(function() {
  		var tbls = document.getElementsByTagName('table');
  		for(var l = tbls.length, i = 0, topics; i < l; i++) {
  			if(tbls[i].className.match(/newest-topics/)) {
  				topics = tbls[i].getElementsByTagName('tbody')[0];
  				break;
  			}
  		}
  		if(!topics) return;

  		for(var l = topics.rows.length, i = 0; i < l; i++) {
  			// the link in the second cell of each row
  			topics.rows[i].cells[1].getElementsByTagName('a')[0].onclick = function() {
  				ga('send', 'event', 'click', 'frontpage->userprofile', this.textContent.replace(/^\s+|\s+$/g, ''), { transport: 'beacon' })
  			};
  		}
  	})();
  });
  
// send hits
  ga('send', 'pageview');

</script>

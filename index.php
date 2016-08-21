<!--
    Fancy seeing you here.
    If you're looking at my source you must be pretty awesome.
    Check me out on github: github.com/danomoseley
-->
<!doctype html>
<?php
if ($pdf) {
  $prefix = realpath(dirname(__FILE__)) . '/';
} else {
  $prefix = '';
}
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dan Moseley - Software Engineer</title>
  <meta name="description" content="The resume of Daniel Moseley">
  <meta name="author" content="Daniel Moseley">
  <?php
    if (!$pdf) {
        echo '<link rel="stylesheet" type="text/css" href="' . $prefix . 'css/bootstrap.min.css" />';
    }
  ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $prefix; ?>css/resume.css" />
  <link rel="stylesheet" type="text/css" media="print" href="<?php echo $prefix; ?>css/print.css" />
  <?php
	if ($pdf) {
		echo '<link rel="stylesheet" type="text/css" href="'.$prefix.'css/print.css" />';
	}
  ?>
  <!--[if lt IE 10]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $prefix; ?>css/ie.css" />
  <![endif]-->
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-15878927-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>  
	<script src="<?php echo $prefix; ?>js/spin.min.js"></script>
	<script src="<?php echo $prefix; ?>js/jquery-1.8.2.min.js"></script>
	<script src="<?php echo $prefix; ?>js/jquery.lightbox_me.js"></script>
	<script src="<?php echo $prefix; ?>js/jquery.cookie.js"></script>
	<script src="<?php echo $prefix; ?>js/main.js"></script>
</head>
	<div class="container">
		<a href="resume.pdf" class="print"></a>
		<div class="header">
			<div class="info">
				<div class="contact">
					<div class="left">
                        <div>Brooklyn, NY</div>
                        <div><a href="http://github.com/danomoseley" target="_blank">github.com/danomoseley</a></div>
                    </div>
                    <div class="name">
			            <h1>Dan Moseley</h1>
                        <?php 
                        if ($pdf) {
                            echo date('F j, Y');
                        }
                        ?>
                    </div>
                    <div class="right">
                        <div><a href="mailto:dan.moseley@gmail.com" target = "_blank">dan.moseley@gmail.com</a></div>
                    </div>
                </div>
			</div>
			<!-- Used to have an objective in the upper right
			<div class="objective">
				
			</div>
			-->
			<div class="cleaner"></div>
		</div>
		<div class="about">
			<h2>
			    A web developer always looking to challenge my skills in both front end and back end development, devops, object oriented javascript, RESTful APIs, algorithm complexity analysis, and innovative problem solving.
			</h2>
		</div>
		<div class="section">
			<div class="sectionTitle">
				Skills
			</div>
			<div class="sectionRight">
				<div class="item">
					<b>Laguages:</b> Expert in Python, PHP, Javascript+JQuery, HTML5, and CSS3. Proficient skills in PostgreSQL,  MySQL, C++, and C. Intermediate skills in C#, ASP.net, Java, Perl, Pascal.<br/>
					<b>Protocols:</b> Intimate knowledge of the web services protocol stack.
				</div>
				<!--<div class="item smarterer">
					<div>
						<a target = "_blank" href="http://smarterer.com/danomoseley" >
							<div class="img" id="smarterer_php"></div>
							<div class="img" id="smarterer_html"></div>
							<div class="img" id="smarterer_html5"></div>
							<div class="img" id="smarterer_css"></div>
							<div class="img" id="smarterer_jquery"></div>
							<div style="clear:both;"></div>
						</a>
					</div>
				</div>-->
			</div>
			<div class="cleaner"></div>
		</div>
		<div class="section">
			<div class="sectionTitle">
				Experience
			</div>
			<div class="sectionRight">
                <div class="item">
					<div>
						<div class="title">
						    Freelance Technical Consultant
                        </div>
						<div class="secondaryTitle">
							January 2014 - Present
						</div>
						<div class="cleaner">
							Dan Moseley, Inc
						</div>
					</div>
                    <ul>
                        <li>
                            Full stack development in a diverse language set with a focus on data intensive input/output operations. 
                        </li>
                    </ul>
				</div>
				<div class="item">
					<div>
						<div class="title">
						    Tech Lead
                        </div>
						<div class="secondaryTitle">
							November 2011 - January 2014
						</div>
						<div class="cleaner">
							<a href="http://jooraccess.com" target = "_blank">JOOR</a>
						</div>
					</div>
					<ul>
						<li>
							<span class="skill"><a href="http://www.jooraccess.com" target="_blank">Full stack development</a> utilizing </span>
                            <span class="skill"><a href="http://cakephp.org/" target = "_blank">Cake PHP</a>, </span>
                            <span class="skill"><a href="https://www.djangoproject.com/" target="_blank">Python Django</a>, </span>
                            <span class="skill"><a href="http://www.postgresql.org/docs/9.2/static/plpgsql.html" target="_blank">PL/pgSQL</a>, </span>
                            <span class="skill"><a href="http://www.redis.io" target="_blank">Redis</a>, <span>
                            <span class="skill"><a href="http://jquery.com/" target="_blank">JQuery</a>, </span>
                            <span class="skill">and Java.</span>
						</li>
						<li>
							<span class="skill">Architecture and configuration of high availability EC2 hosted system, $750 million of order volume in 2013.</span>
						</li>
						<li>
							<span class="skill">Design, documentation, and implementation of client facing stateless JSON REST API.</span>
						</li>
                        <li>
                            <span class="skill">Message queue implementation in PHP and Redis.
                        </li>
					</ul>
				</div>
				<div class="item">
					<div>
						<div class="title">
							Mobile Web Developer, Project Manager
						</div>
						<div class="secondaryTitle">
							July 2010 - November 2011
						</div>
						<div class="cleaner">
							<a href="http://www.intelligentdata.com" target = "_blank">Intelligent Data Systems</a>
						</div>
					</div>
					<ul>
						<li>
							Designed and implemented RESTful API in ASP.net C# with MSSQL backend.
						</li>
						<li>
							Project manager for HTML5 JQuery based web application targetting iPad and iPad2 devices, utilizing continuous communication with API through JSON.
						</li>
						<li>
							Extensive experience with geolocation API and integration with google maps javascript API.
						</li>
						<li>
							HTML5 offline functionality using cache manifest, local storage, web SQL, and offline request queueing.
						</li>
						<li>
							Utilized <a href="http://www.phonegap.com" target = "_blank">PhoneGap</a> application wrapper to access iPhone and Android device camera functionality from within the web application.
						</li>
					</ul>
				</div>
				<div class="item">
					<div>
						<div class="title">
							PHP Architect
						</div>
						<div class="secondaryTitle">
							December 2009 - May 2010
						</div>
						<div class="cleaner">
							<a href="http://www.newmediaretailer.com/" target = "_blank">New Media Retailer</a>
						</div>
					</div>
					<ul>
						<li>
							Assisted with design and implementation of end-to-end social marketing infrastructure.
						</li>
						<li>
							Implemented MVC techniques in PHP using <a href="http://codeigniter.com/" target="_blank">CodeIgniter</a>, MySQL, JQuery, HTML, and CSS.
						</li>
						<li>
							Integration with Twitter, Facebook, and MailChimp APIs.
						</li>
					</ul>
				</div>
				<div class="item">
					<div>
						<div class="title">
							Laser Engraver
						</div>
						<div class="secondaryTitle">
							May 2003 - August 2007 (seasonal)
						</div>
						<div class="cleaner">
							<a href="http://cooperstownbat.com/" target = "_blank">Cooperstown Bat Company</a>
						</div>
					</div>
					<ul>
						<li>
							Managed and trained team of four to complete thousands of time-sensitive laser engravings per month.
						</li>
						<li>
							Created custom vector graphics for laser engraving on sports memorabilia.
						</li>
					</ul>
				</div>
			</div>
			<div class="cleaner"></div>
		</div>
		<div class="cleaner"></div>
		<div class="section">
			<div class="sectionTitle">
				Education
			</div>
			<div class="sectionRight">
				<div class="item">
					<div class="title"> 
						<a href="http://www.rpi.edu" target = "_blank">Rensselaer Polytechnic Institute (RPI), Troy, NY</a>
					</div>
					<div class="secondaryTitle gpa">
						GPA: 3.14
					</div>
					<div class="cleaner">
						Bachelor of Science in Computer Science, May 2010
					</div>
					<ul class="cleaner">
						<li>
							Memory efficient HTTP proxy server and TFTP server written in C with cross support for IPv4 and IPv6 clients using Berkley sockets and select multiplexing.
						</li>
						<li>
							Custom bash shell implementation written in C using POSIX threads. <a href="/classes/c-sample.html" class="link codeSample" target="_blank">View Code Sample</a>
						</li>
						<li>
							Polite HTTP web spider and reverse indexing search engine implementing the <a href="http://en.wikipedia.org/wiki/PageRank" target="_blank">pagerank algorithm</a> in Java.
						</li>
						<li>
							Created corporate task management system in Java EE with JSP, tomcat, ANT scripts, and SVN.
						</li>
					</ul>
				</div>
			</div>
			<div class="cleaner"></div>
		</div>
		<div class="cleaner"></div>
		<div class="section">
			<div class="sectionTitle">
				Projects
			</div>
			<div class="sectionRight">
				<div class="item">
					<div>
						<div class="title">
							Personal Projects
						</div>
					</div>
					<ul class="cleaner">
						<li>
							Web development (HTML, JQuery) for sites including <a href="http://havemeyerpark.danomoseley.com" target="_blank">havemeyerpark.com, <a href="http://malachifrance.danomoseley.com/" target = "_blank">malachifrance.com</a>, and <a href="http://keyboardcat.danomoseley.com" target = "_blank">keyboardcat.danomoseley.com</a>.
						</li>
					</ul>
				</div>
			</div>
			<div class="cleaner"></div>
		</div>
		<div class="cleaner"></div>
		<!--
		<div class="section">
			<div class="sectionTitle">
				Leadership
			</div>
			<div class="sectionRight">
				<div class="item">
					<div>
						<div class="title">
							<a href="http://www.rse.org" target = "_blank">Rensselaer Society of Engineers</a>
						</div>
						<div class="secondaryTitle">
							2005 - 2010
						</div>
					</div>
					<ul class="cleaner">
						<li>
							<b>Executive House Manager</b> - Elected by membership to maintain 86 year old fraternity house on challenging budget. Led group of 40 members in year long maintanence agenda.
						</li>
						<li>
							<b>Network Administrator</b> - Appointed to design and implement house network over cable internet using open source embedded routing software and QOS packet shaping and prioritization for 40 members. Managed network for two years.
						</li>
					</ul>
				</div>
			</div>
			<div class="cleaner"></div>
		</div>
		<div class="cleaner"></div>
		-->
		<div class="section">
			<div class="sectionTitle">
				Honors
			</div>
			<div class="sectionRight">
				<div class="item">
					<b>Boy Scouts of America - Eagle Scout</b><br/>
					<b><a href="http://www.usfirst.org/" target="_blank">FIRST Robotics</a> Team 145 2001-2005</b>
				</div>
			</div>
			<div class="cleaner"></div>
		</div>
	</div>
	<div id="sign_up" class="popup loading" style="left: 50%; margin-left: -223px; z-index: 1002; position: fixed; top: 50%; margin-top: -159px; display: none; ">
		<h2 class="first"></h2><h2 class="second"></h2><h2 class="third"></h2>
	</div>
</body>
</html>

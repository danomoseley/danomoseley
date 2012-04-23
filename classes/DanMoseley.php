<!--Dan Moseley-->
<!--danomoseley@gmail.com-->
<!--This php code segment queries a mysql database and builds a news page with the data results of the query-->

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
  xml:lang="en" lang="en">
<head>
  <title>Hidden Ponds Stables</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
<div id="header_background">
  <div id="center_panel">
    <div id="header">
      <img src="img/banner-full.png">
      <div id="logo">
        <a href="index.php"><img src="img/logo.png"></a>
      </div>
    </div>
    <div id="navigation">
      <a href="index.php"><img src="img/navbutton-stables.png"></a><a href="#"><img src="img/navbutton-horses.png"></a><a href="services.php"><img src="img/navbutton-services.png"></a><a href="events.php"><img src="img/navbutton-calendar.png"></a><a href="#"><img src="img/navbutton-forsale.png"></a>
    </div>
  </div>
</div>
<div id="center_pane">
  <div id="slideshow">
    <img src="img/slideshow-image.png">
  </div>
  <div id="content">
    <?
	  <!--All database connection info is stored in a file called dbinfo.inc.php-->
          include("dbinfo.inc.php");
	  mysql_connect($hostname,$username,$password);
          @mysql_select_db($database) or die( "Unable to select database");
          
	  <!--All database connection info is stored in a file called dbinfo.inc.php-->
	  $query="SELECT * FROM news WHERE deleted='0' ORDER BY date desc";
          $result=mysql_query($query);
          $num=mysql_numrows($result);
          $result2=mysql_query($query) or die(mysql_error());
          $num2=mysql_numrows($result2);
	  $query="SELECT * FROM config";
	  $result3=mysql_query($query);
          mysql_close();
        ?>
    <div id="left">
      <img src="img/content-heading1.png"> <br/>
      <br/>
      <?
            $intro=mysql_result($result3,$i,"intro");
            echo "$intro";
        ?>
      <br/>
      <br />
      <img src="img/content-divider.png"><br/>
      <br/>
      <img src="img/content-heading2.png"><br/>
      <br/>
      <?
          $i=0;
          while ($i < $num) {

            $title=mysql_result($result,$i,"title");
            $text=mysql_result($result,$i,"text");
            $author=mysql_result($result,$i,"author");
            $date=mysql_result($result,$i,"date");
	    
	    <!-- Add the local time difference from the server time to the post time -->
	    $date .= $timeDiff;
	    $date = strtotime( $date );
	    $time = date('g:i a',$date);
	    $day = date('l, F j Y',$date);
            echo "<br/><b>$title</b><br/> $text<br/>  -$time on $day<br/>";

            $i++;
          }
        ?>
    </div>
    <div id="right">
      <div id="calendar">
      <iframe scrolling="no" frameborder="0" height="306px" width="294px" src="calendar.php">
        
      </div>
      <a href="#"><img src="img/ad-summerCamp.png"></a>
    </div>
  </div>
</div>
</body>
</html>

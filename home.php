<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select logged in users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
?>

<!--Calendar-->
<?php
/* Set the default timezone */
  date_default_timezone_set("Europe/Ljubljana");

/* Set the date */
  $date = strtotime(date("Y-m-d"));

  $day = date('d', $date);
  $month = date('m', $date);
  $year = date('Y', $date);
  $firstDay = mktime(0,0,0,$month, 1, $year);
  $title = strftime('%B', $firstDay);
  $dayOfWeek = date('D', $firstDay);
  $daysInMonth = cal_days_in_month(0, $month, $year);

/* Get the name of the week days */
  $timestamp = strtotime('next Sunday');
  $weekDays = array();
    for ($i = 0; $i < 7; $i++) {
      $weekDays[] = strftime('%a', $timestamp);
      $timestamp = strtotime('+1 day', $timestamp);
    }
  $blank = date('w', strtotime("{$year}-{$month}-01"));
?>

<div style="margin-top:60px" class="container col-sm-8">
  <table class='table table-bordered' style="table-layout: fixed; background-color: white;">
    <tr>
     <th colspan="7" class="text-center"> <?php echo $title ?> <?php echo $year ?> </th>
    </tr>

    <tr>
      <?php foreach($weekDays as $key => $weekDay) : ?>
        <td class="text-center"><?php echo $weekDay ?></td>
      <?php endforeach ?>
    </tr>

    <tr>
      <?php for($i = 0; $i < $blank; $i++): ?>
      <td></td>
      <?php endfor; ?>
      <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
      <?php if($day == $i): ?>
      <td style="padding-bottom: 65px; text-align: center; background-color: #383e4e;color: white"><strong><?php echo $i ?></strong></td>
      <?php else: ?>

      <td  style="padding-bottom: 65px; text-align: center;">
        <?php echo $i ?>
      </td>

      <?php endif; ?>
      <?php if(($i + $blank) % 7 == 0): ?>
    </tr>

    <tr>
      <?php endif; ?>
      <?php endfor; ?>
      <?php for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
      <td></td>
      <?php endfor; ?>
    </tr>
  </table>
</div>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body style="background-color: #383e4e;">

	<nav style="background-color: #282c37" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a style="color: white" class="navbar-brand" href="index.php">nerda</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="logout.php?logout" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-user"></span>&nbsp;Sign out from <?php echo $userRow['userEmail']; ?>
            </li>
          </ul>
        </div>
      </div>
    </nav> 

    

	
    
</body>
</html>
<?php ob_end_flush(); ?>
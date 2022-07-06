<div class="row">
<div class="col-lg-12" align="center">
<h3>REGISTRATION FORM</h3>
</div>
</div>
<div class="row">
<div class="col-lg-12 hidden-xs hidden-sm" align="center">
<?php
     unset($info);
	 unset($data);
	$info["table"] = "registration";
	$info["fields"] = array("registration.*"); 
	$info["where"]   = "1   AND id='".$_SESSION['registration_id']."'";
	//$info["debug"]   = true;
	$arr =  $db->select($info);
	if(count($arr)>0)
	{
?>
<a href="index.php?cmd=list" class="btn blue"><i class="fa fa-arrow-circle-left"></i>Registration</a>
<?php
	}
	else
	{
?>
<a href="index.php?cmd=list" class="btn blue"><i class="fa fa-arrow-circle-left"></i>Registration</a>
<?php		
	}
?>

<?php
      unset($info);
	  unset($data);
	$info["table"] = "book_a_slot";
	$info["fields"] = array("book_a_slot.*"); 
	$info["where"]   = "1   AND registration_id='".$_SESSION['registration_id']."'";
	//$info["debug"]   = true;
	$arr =  $db->select($info);
	if(count($arr)>0)
	{
?>
<a href="index.php?cmd=list" class="btn blue"><i class="fa fa-arrow-circle-left">Book a Slot</a>
<?php
	}
	else
	{
?>
<a href="index.php?cmd=list" class="btn blue"><i class="fa fa-arrow-circle-left">Book a Slot</a>

<?php
	}
?>	


<?php
     
	if(isset($_SESSION['Patient_ID']))
	{
?>

<?php
	}
	else
	{
?>

<?php
	}
?>	
</div>
</div>
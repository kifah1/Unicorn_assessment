<?php
 include("../../template/header.php");
 include("../../template/registration_menu.php");
?>
<script type="text/javascript" src="../../tinybox2/tinybox.js"></script>
<link rel="stylesheet" type="text/css" href="../../tinybox2/style.css" />
<script type="text/javascript">
    function popUp(url)
    { 
      var parentWindow = window;
      TINY.box.show({iframe:url,closejs:function(){return false;},boxid:'frameless',width:850,height:600,fixed:false,maskid:'bluemask',maskopacity:40});
    } 
</script>
<?php
     if(isset($msg))
	 { 
       echo "<div align=\"center\">$msg</div>";
	 }
 ?>
<a href="index.php?cmd=edit" class="btn green"><i class="fa fa-plus-circle"></i> Book a slot</a> <br><br>
 <div class="portlet box blue">
            <div class="portlet-body">
	         <div class="table-responsive">	
                <table class="table">
                   <!--<tr>
						<td align="center" valign="top">
						  <form name="search_frm" id="search_frm" method="post">
							<div class="portlet-body">
					         <div class="table-responsive">	
				                <table align="right">
									  <TR>
										<TD  nowrap="nowrap">
										  <?php
											  $hash    =  getTableFieldsName("book_a_slot");
											  $hash    = array_diff($hash,array("id"));
										  ?>
										  Search Key:
										  <select   name="field_name" id="field_name"  class="form-control-static">
											<option value="">--Select--</option>
											<?php
											foreach($hash as $key=>$value)
											{
										    ?>
											<option value="<?=$key?>" <?php if($_SESSION['field_name']==$key) echo "selected"; ?>><?=str_replace("_"," ",$value)?></option>
											<?php
										    }
										  ?>
										  </select>
										</TD>
										<TD  nowrap="nowrap" align="right"><label for="searchbar"><img src="../../images/icon_searchbox.png" alt="Search"></label>
										   <input type="text"    name="field_value" id="field_value" value="<?=$_SESSION["field_value"]?>" class="form-control-static"></TD>
										<td nowrap="nowrap" align="right">
										  <input type="hidden" name="cmd" id="cmd" value="search_book_a_slot" >
										  <input type="submit" name="btn_submit" id="btn_submit"  value="Search" class="btn blue-hoki" />
										</td>
									  </TR>
									</table>
							</div>
							</div>
						  </form>
						</td>
				   </tr>-->
				   <tr>
				   <td> 
				
						<div class="portlet-body">
				      <div class="table-responsive">	
				          <table class="table">
							<tr bgcolor="#ABCAE0">
                                <td>Department</td>
                                <td>Doctor</td>
                                <td>Request Date</td>
                                <td>Request Time</td>
								<td>Exceeding 6 hrs?</td>
                                <td>Subject</td>
                                <td>Fee type</td>
                                <td>Fee amount</td>
                                <td>Status</td>                              
                                <td>Action</td>
							</tr>
						 <?php
								
								if($_SESSION["search"]=="yes")
								  {
									$whrstr = " AND ".$_SESSION['field_name']." LIKE '%".$_SESSION["field_value"]."%'";
								  }
								  else
								  {
									$whrstr = "";
								  }
						        $whrstr .= "AND registration_id='".$_SESSION['registration_id']."'";
							
								$rowsPerPage = 10;
								$pageNum = 1;
								if(isset($_REQUEST['page']))
								{
									$pageNum = $_REQUEST['page'];
								}
								$offset = ($pageNum - 1) * $rowsPerPage;  
						 
						 
											  
								$info["table"] = "book_a_slot";
								$info["fields"] = array("book_a_slot.*"); 
								$info["where"]   = "1   $whrstr ORDER BY id DESC  LIMIT $offset, $rowsPerPage";
													
								
								$arr =  $db->select($info);
								
								for($i=0;$i<count($arr);$i++)
								{
								
								   $rowColor;
						
									if($i % 2 == 0)
									{
										
										$row="#C8C8C8";
									}
									else
									{
										
										$row="#FFFFFF";
									}
								
						 ?>
							<tr bgcolor="<?=$row?>" onmouseover=" this.style.background='#ECF5B6'; " onmouseout=" this.style.background='<?=$row?>'; ">
							  <td>
		                            <?php
									    unset($info2);        
										$info2['table']    = "department";	
										$info2['fields']   = array("*");	   	   
										$info2['where']    =  "1 AND id='".$arr[$i]['department_id']."' LIMIT 0,1";
										$res2  =  $db->select($info2);
										echo $res2[0]['dept_name'];	
					                ?>
							  </td>
                              <td>
		                            <?php
									    unset($info2);        
										$info2['table']    = "users";	
										$info2['fields']   = array("*");	   	   
										$info2['where']    =  "1 AND id='".$arr[$i]['doctor_users_id']."' LIMIT 0,1";
										$res2  =  $db->select($info2);
										echo $res2[0]['first_name'].' '.$res2[0]['last_name'];	
					                ?>
							  </td>
                              <td><?=$arr[$i]['request_date']?></td>
                              <td><?=$arr[$i]['request_time']?></td>
                              <td><?=$arr[$i]['subject']?></td>
                              <td><?=$arr[$i]['fee_type']?></td>
                              <td><?=$arr[$i]['fee_amount']?></td>
                              <td><?=$arr[$i]['status']?></td>
			  
							  <td nowrap >
                                  <?php
								    if($arr[$i]['status']=='pending')
									{
								  ?>
								  <a href="index.php?cmd=edit&id=<?=$arr[$i]['id']?>"  class="btn default btn-xs purple"><i class="fa fa-edit"></i>Edit</a>
								  <?php
									}
							      ?>	
                                 <a  href="javascript:void();"  onClick="popUp('index.php?cmd=book_a_slot_details&id=<?=$arr[$i]['id']?>')" class="btn blue button-next">
									   Details
                                       <i class="m-icon-swapright m-icon-white"></i>                  
                                  </a>
								  <?php
                                    if($arr[$i]['status']=='pending')
                                    {
								  ?> 
                                 <a href="index.php?cmd=delete&id=<?=$arr[$i]['id']?>" class="btn btn-sm red filter-cancel"  onClick=" return confirm('Are you sure to delete this item ?');"><i class="fa fa-times"></i>Delete</a> 
							     <?php
									}
							     ?>	
                             </td>
						
							</tr>
						<?php
								  }
						?>
						
						<tr>
						   <td colspan="10" align="center">
                              <style>
								#navlist li
								{
									float:left;
									display: inline;
									list-style-type: none;
									padding-right: 20px;
								}
							   </style>
							  <?php              
									  unset($info);
					
									   $info["table"] = "book_a_slot";
									   $info["fields"] = array("count(*) as total_rows"); 
									   $info["where"]   = "1  $whrstr ORDER BY id DESC";
									  
									   $res  = $db->select($info);  
					
												
										$numrows = $res[0]['total_rows'];
										$maxPage = ceil($numrows/$rowsPerPage);
										$self = 'index.php?cmd=list';
										$nav  = '';
										
										$start    = ceil($pageNum/5)*5-5+1;
										$end      = ceil($pageNum/5)*5;
										
										if($maxPage<$end)
										{
										  $end  = $maxPage;
										}
										
										for($page = $start; $page <= $end; $page++)
										//for($page = 1; $page <= $maxPage; $page++)
										{
											if ($page == $pageNum)
											{
												$nav .= "<li>$page</li>"; 
											}
											else
											{
												$nav .= "<li><a href=\"$self&&page=$page\" class=\"nav\">$page</a></li>";
											} 
										}
										if ($pageNum > 1)
										{
											$page  = $pageNum - 1;
											$prev  = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Prev]</a></li>";
									
										   $first = "<li><a href=\"$self&&page=1\" class=\"nav\">[First Page]</a></li>";
										} 
										else
										{
											$prev  = '<li>&nbsp;</li>'; 
											$first = '<li>&nbsp;</li>'; 
										}
									
										if ($pageNum < $maxPage)
										{
											$page = $pageNum + 1;
											$next = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Next]</a></li>";
									
											$last = "<li><a href=\"$self&&page=$maxPage\" class=\"nav\">[Last Page]</a></li>";
										} 
										else
										{
											$next = '<li>&nbsp;</li>'; 
											$last = '<li>&nbsp;</li>'; 
										}
										
										if($numrows>1)
										{
										  echo '<ul id="navlist">';
										   echo $first . $prev . $nav . $next . $last;
										  echo '</ul>';
										}
									?>     
						   </td>
						</tr>
						</table>
						</div>
					 </div>				
				</td>
				</tr>
				</table>
				</div>
			</div>
		</div>
<?php
include("../../template/footer.php");
?>









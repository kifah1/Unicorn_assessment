<?php
 include("../template/header.php");
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
<a href="index.php?cmd=edit" class="btn green"><i class="fa fa-plus-circle"></i> Add a <?=ucwords(str_replace("_"," ","registration"))?></a> <br><br>
 <div class="portlet box blue">
           <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i><b><?=ucwords(str_replace("_"," ","registration"))?></b>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>             
            <div class="portlet-body">
	         <div class="table-responsive">	
                <table class="table">
                 <tr>
						<td align="center" valign="top">
						  <form name="search_frm" id="search_frm" method="post">
							<div class="portlet-body">
					         <div class="table-responsive">	
				                <table align="right">
									  <TR>
										<TD  nowrap="nowrap">
										  <?php
											  $hash    =  getTableFieldsName("registration");
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
										  <input type="hidden" name="cmd" id="cmd" value="search_registration" >
										  <input type="submit" name="btn_submit" id="btn_submit"  value="Search" class="btn blue-hoki" />
										</td>
									  </TR>
									</table>
							</div>
							</div>
						  </form>
						</td>
				   </tr>
				   <tr>
				   <td> 
						<div class="portlet-body">
				      <div class="table-responsive">	
				          <table class="table">
							<tr bgcolor="#ABCAE0">
							  <td>Hospital ID</td>
                              <td>Patient Title</td>
                              <td>Patient Name</td>
                              <td>Patient Initial</td>
                              <td>File Picture</td>
                              <td>Date Of Birth</td>
                              <td>Nationality</td>
                              <td>Patients Occupation</td>
                              <td>Father Mother Husband Name</td>
                              <td>Gender</td>
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
						 
								$rowsPerPage = 10;
								$pageNum = 1;
								if(isset($_REQUEST['page']))
								{
									$pageNum = $_REQUEST['page'];
								}
								$offset = ($pageNum - 1) * $rowsPerPage;  
						 
						 
											  
								$info["table"] = "registration";
								$info["fields"] = array("registration.*"); 
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
							  <td><?=$arr[$i]['Hospital_ID']?></td>
                              <td><?=$arr[$i]['Patient_Title']?></td>
                              <td><?=$arr[$i]['Patient_Name']?></td>
                              <td><?=$arr[$i]['Patient_Initial']?></td>
                              <td>
                                   <?php
								    if(is_file('../../'.$arr[$i]['file_picture'])&&file_exists('../../'.$arr[$i]['file_picture']))
									{
								 ?>
                                  <img src="../../<?=$arr[$i]['file_picture']?>" style="width:100px;height:100px;">
                                  <?php
									}
								  ?>	  
                              </td>
                              <td><?=$arr[$i]['Date_of_Birth']?></td>
                              <td><?=$arr[$i]['Nationality']?></td>
                              <td><?=$arr[$i]['Patients_Occupation']?></td>
                              <td><?=$arr[$i]['Father_Mother_Husband_Name']?></td>
                              <td><?=$arr[$i]['Gender']?></td>
                              <!--<td><?=$arr[$i]['Marital_Status']?></td>
                              <td><?=$arr[$i]['Religion']?></td>
                              <td><?=$arr[$i]['Religion_Others']?></td>
                              <td><?=$arr[$i]['Relationship']?></td>
                              <td><?=$arr[$i]['PerA_Door_No_Street']?></td>
                              <td><?=$arr[$i]['PerA_Area']?></td>
                              <td>
									<?php
                                        unset($info2);        
                                        $info2['table']    = country;	
                                        $info2['fields']   = array("country");	   	   
                                        $info2['where']    =  "1 AND id='".$arr[$i]['PerA_country_id']."' LIMIT 0,1";
                                        $res2  =  $db->select($info2);
                                        echo $res2[0]['country'];	
                                    ?>
                               </td>
                              <td><?=$arr[$i]['PerA_State']?></td>
                              <td><?=$arr[$i]['PerA_District']?></td>
                              <td><?=$arr[$i]['PerA_Thana']?></td>
                              <td><?=$arr[$i]['PerA_Post_Code']?></td>
                              <td><?=$arr[$i]['PreA_Door_No_Street']?></td>
                              <td><?=$arr[$i]['PreA_Area']?></td>
                              <td>
									<?php
                                        unset($info2);        
                                        $info2['table']    = country;	
                                        $info2['fields']   = array("country");	   	   
                                        $info2['where']    =  "1 AND id='".$arr[$i]['PreA_country_id']."' LIMIT 0,1";
                                        $res2  =  $db->select($info2);
                                        echo $res2[0]['country'];	
                                    ?>
                               </td>
                              <td><?=$arr[$i]['PreA_State']?></td>
                              <td><?=$arr[$i]['PreA_District']?></td>
                              <td><?=$arr[$i]['PreA_Thana']?></td>
                              <td><?=$arr[$i]['PreA_Post_Code']?></td>
                              <td><?=$arr[$i]['Mobile_No']?></td>
                              <td><?=$arr[$i]['Email_ID']?></td>
                              <td><?=$arr[$i]['LandLine_No']?></td>-->
                              <td><?=$arr[$i]['status']?></td>
			  
							  <td nowrap >
								  <a href="index.php?cmd=edit&id=<?=$arr[$i]['id']?>"  class="btn default btn-xs purple"><i class="fa fa-edit"></i>Edit</a>
								  <a  href="javascript:void();"  onClick="popUp('index.php?cmd=registration_details&id=<?=$arr[$i]['id']?>')" class="btn blue button-next">
									   Details
                                       <i class="m-icon-swapright m-icon-white"></i>                  
                                  </a> 
                                  <a href="index.php?cmd=delete&id=<?=$arr[$i]['id']?>" class="btn btn-sm red filter-cancel"  onClick=" return confirm('Are you sure to delete this item ?');"><i class="fa fa-times"></i>Delete</a> 
							 </td>
						
							</tr>
						<?php
								  }
						?>
						
						<tr>
						   <td colspan="10" align="center">
							  <?php              
									  unset($info);
					
									   $info["table"] = "registration";
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
include("../template/footer.php");
?>







<?php

session_start();

include_once "sqlQueries.php";	


// mysqli_close($conn);
if($_GET && $_GET['action'] && $_GET['action']=="logout"){
	unset($_SESSION['loggedIn']);
	unset($_SESSION['email']);
}

if(!$_SESSION['loggedIn']){
	header("location: ./login/login.php");
	die();
}


// queries executation


?>
<html>
	<head>
		<title>Homepage</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="index.css">
		<link rel="stylesheet" type="text/css" href="messages/messages.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="css/tags/jquery-ui.js"></script>
		<script src="css/tags/jquery-migrate-3.0.0.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="css/tags/bootstrap-tokenfield.js"></script>
		<script src="css/tags/typeahead.bundle.min.js"></script>
		<script src="slackScripts.js"></script>
		<link rel="stylesheet" type="text/css" href="css/tags/jquery-ui.css">
		<!-- delete pop links -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
		<!-- delete popup  -->

		<!-- pagination -->
		<script type="text/javascript" src="http://botmonster.com/jquery-bootpag/jquery.bootpag.js"></script>
		<!-- pagination ends -->

		<!-- multi select -->		
		<link rel="stylesheet" type="text/css" href="css/tags/bootstrap-tokenfield.css">
		<link rel="stylesheet" type="text/css" href="css/tags/bootstrap-tokenfield.css">	
		<!-- multi select -->
		<!-- type head for search -->
		 <!-- // <script src="typeahead.min.js"></script> -->
		<!-- end of type head  -->


	</head>
	<body>
		<div class="container nopadding col-xs-12" >
			<div class = "col-xs-12 nopadding " style='border-bottom: 0.15em solid  #404040;'>
				<div  class = " col-xs-3 nopadding" style="background-color: #404040;width: 13%;height: 74px;color: white;padding: 1% !important;
">
					
					
						<div>
							<div><label>ODUCS518F17</label></div>
							<div class="dropdown">
								<button onclick="userMenu()" class="dropbtn"><?php $result = getUserDetails($_SESSION['email']); echo $result['display_name']?><i class="fa fa-angle-down"></i></button>
								  <div id="myDropdown" class="dropdown-content userProfile">
								    <div style = 'color:black;'><img src=<?php echo "./assets/images/".$_SESSION['email'].".png" ?> alt='Contact_Img' class='contact_Img'><?php $result = getUserDetails($_SESSION['email']); echo $result['display_name']?></div>
								    <a href= "profilePage.php?email=<?php echo $_SESSION['email']; ?>">Profile View</a>
								    <a href="#contact">Contact</a>
								    <a href="./signOut.php">
          								<span class="glyphicon glyphicon-log-out">LogOut</span>
        							</a>
								  </div>
							</div>
							<!-- <label></label> -->
						</div>
				</div>

				<div class="col-xs-9 nopadding" style="height: 74px;background-color: white;padding-left: 2% !important;padding-top: 14px !important;">	
					<div class ="col-xs-5 nopadding ">
							<?php
								$result ="";
								$userChannels = userChannels($_SESSION['email']);
								if (isset($_GET["channel"])){
									if (in_array($_GET["channel"], $userChannels)) {
										$result = getChannelName($_GET["channel"],$_SESSION['email']);
									}else{
										$result = "<div><label class = 'channel_title'><b>Channel Title</b></label>";
									}
								}else{
									$result = "<div><label class = 'channel_title'><b>Channel Title</b></label>";
								}									
								echo $result;
							?>
							
						</div>
						<div class = "detailsOfChannel">
							<span class="fa fa-star checked"></span>
							<span class= "divider">|</span>
							<i style='font-size: 117%;color: #706c6c;' class="fa fa-users" aria-hidden="true"></i>
							<sub><?php echo membersInChannel($_GET["channel"]); ?></sub>
							<span class= "divider">|</span>
							<span class = "purposeChannel">
								<?php
									$result = "";
									if (isset($_GET["channel"])){
										if (in_array($_GET["channel"], $userChannels)) {
											$result = getChannelDetails($_GET["channel"]);
										}
									}
								echo $result['purpose']
							?>
							</span>
						</div>


					</div>
					<div class = 'pagination myPagination'>
						<p id="pagination-here"></p>
        				<!-- <p id="content">Dynamic page content</p> -->
					</div>
					<!-- <div class = "logout">
						<a href="./signOut.php">
          					<span class="glyphicon glyphicon-log-out">LogOut</span>
        				</a>
					</div> -->
					
				</div>

			</div>

			<div class="col-xs-12 nopadding">
		        <div class="col-xs-3  leftSideMenu nopadding">
		        	<div class = "profileView">
		        		<b><a class= 'link' href= "profilePage.php?email=<?php echo $_SESSION['email']; ?>" ><i class="fa fa-user" aria-hidden="true" style ='font-size: 126%;padding-right: 3%;'></i>ProfileView</a></b>

		        	</div>
		            <div >
		                <ul class="col-xs-12 nav nav-list nopadding">
		                    <!-- <li>
		                    	<div class="col-xs-12 Starreddiv ">
		                    		<div class="col-xs-12 nopadding">
		                    			<label><span>&#x2606;</span>Starred</label>
		                    		</div>
		                    	
	        					</div>
	        					</br>
	        					
	        					<div id="test">
			                        <ul class="nav nav-list tree starredList">
			                            <li ><a class="listbg" href="#">User 1</a></li>
			                            <li ><a class="listbg" href="#">Channel 1</a></li>
			                            <li ><a class="listbg" href="#">Channel 2</a></li>
			                            
			                        </ul>
		                    	</div>
		                    </li> -->
		                    
		                    <li class="divider"></li>
		                    <li>
		                    	<div class="col-xs-12 channeldiv">
		                    		<div class="col-xs-11 nopadding">
		                    			<b><a class ="link" href= "inviteMembersToChannel.php">Channels</a></b>
		                    			<a href = 'newChannel.php' class = 'newChannel'><i class="fa fa-plus"></i></a>
		                    			
		                    			<!-- Modal -->
										  <div class="modal fade" id="myModal" role="dialog">
										    <div class="modal-dialog modal-lg">
										      <div class="modal-content">
										        <div class="modal-header">
										          <button type="button" class="close modalClose" data-dismiss="modal">&times;</button>
										          <h4 class="modal-title">code posting Area</h4>
										        </div>
										        <div class="modal-body">
										          
										          <form action ='messages/messages.php' id= "codeForm" method = "post">
										          
										          <div class="form-group">
										            <label for="message-text" class="form-control-label">code</label>
										            <textarea class="form-control codeArea" name = "message" id="code" placeholder= " Snippet" autofocus required ></textarea>
										            <input type='hidden' name='channel' value=<?php echo $_GET['channel']; ?>>
										            <input type='hidden' name='email' value=<?php echo $_SESSION['email']; ?>>
										            <input type='hidden' name='text' value='1'>
										          </div>
										          
										          <div class="modal-footer">
										          <button type="button" class="btn btn-default modalClose" data-dismiss="modal">Close</button>
										           <button type="submit" name = "submit"  class="btn btn-success codeBtn" >submit code</button>
										          </div>
										          <div>
														
										          </div>		
										        </form>
										        </div>
										        <div class = "modal-body-result">
										        	<p class = "para" style='text-align:center;'></p>
										        </div>
										      </div>
										    </div>
										  </div>


										  <!-- thread modal -->
										  	<!-- Modal -->
									  <!-- <div class="modal fade" id="myThreadModal" role="dialog">
									    <div class="modal-dialog modal-lg">
									      <div class="modal-content">
									        <div class="modal-header">
									          <button type="button" class="close modalClose" data-dismiss="modal">&times;</button>
									          <h4 class="modal-title">code posting Area</h4>
									        </div>
									        <div class="modal-body">
									          
									          <form action ='messages/messages.php' id= "codeForm" method = "post">
									          
									          <div class="form-group">
									            <label for="message-text" class="form-control-label">code</label>
									            <textarea class="form-control codeArea" name = "message" id="code" placeholder= " Snippet" autofocus required ></textarea>
									            <input type='hidden' name='channel' value=<?php echo $_GET['channel']; ?>>
									            <input type='hidden' name='email' value=<?php echo $_SESSION['email']; ?>>
									            <input type='hidden' name='text' value='1'>
									          </div>
									          
									          <div class="modal-footer">
									          <button type="button" class="btn btn-default modalClose" data-dismiss="modal">Close</button>
									           <button type="submit" name = "submit"  class="btn btn-success threadMessageButton" >submit code</button>
									          </div>
									          <div>
													
									          </div>		
									        </form>
									        </div>
									        <div class = "modal-body-result">
									        	<p class = "para" style='text-align:center;'></p>
									        </div>
									      </div>
									    </div>
									  </div>
 -->
										  <!-- thread modal end -->
		                    		</div>
		                    		<!-- <div class="col-xs-1  icon-plus nopadding">
			                    	
 										<a href="#"><span class="name"></span></a>
										
	        						</div> -->
	        					</div>
	        					</br>
	        					<div id="Channel">
				                        <ul class="nav nav-list tree starredList">
				                 			<?php 
				                 				$user_array = getUserDetails($_SESSION['email']); 				                 				 
				                            	$result =getAllChannels($user_array['email']);
				                            	echo $result
				                            ?>
				                        </ul>
		                    	</div>
		                    </li>
		                    
		                    
		                    <li class="divider"></li>

		                   	<li> 
			                   	<form action="./uploadImage.php"  id = 'imgForm' method="post" enctype="multipart/form-data">
			     
			                        <div style="background-color: #404040;color: white;padding: 1% !important;"><label>Select image to upload:</label></div>
			                        <input type="file" name="fileToUpload" id="fileToUpload">
			                        <input type="submit" value="Upload Image" name="submit">
			                        <input type="hidden" name="channel" value=<?php echo '"'.$_GET["channel"].'"';?> >
			                    </form>
		                	</li>
		                	 <li class="divider"></li>
		                	 <!-- <li>
		                	 	<div class="bs-example">
       								 <input type="text" name="typeahead" class="typeahead tt-query"  spellcheck="false" placeholder="search with email...">
    							</div>
		                	 </li -->>
		                	<!-- <a href = 'newChannel.php'>new channel</a> -->
		                    <!-- <li>
		                    	<div class="col-xs-12 directmsgdiv ">
		                    		<div class="col-xs-11 nopadding">
		                    			<b><a class ="link" href= "">DirectMesssages</a></b>
		                    		</div>
		                    		<div class="col-xs-1  icon-plus nopadding"> -->
			                    		
 										<!-- <a href="#"><span class="name"></span></a> -->
										
	        						<!-- </div>
	        					</div>
	        					</br>
        						<div id="directmsg">
			                        <ul class="nav nav-list tree directmsgList">			         
			                            <?php $result =getAllUsers();echo $result ?>
			                        </ul>
	                    		</div>
		                    </li> -->
		                </ul>
		            </div>
		        </div>
		        <div id='message_container' class ='col-xs-10 headrow nopadding' style='width:87%;min-height:93%;background-color: white; '>
		        	<div class ='col-xs-12 nopadding' style='height:91%;overflow-y: auto; overflow-x: hidden;position:relative;'>
			        	<?php 
			        		$userChannels = userChannels($_SESSION['email']);
			        		if (isset($_GET['channel'])){
			        			if (in_array($_GET['channel'], $userChannels)) {				
				        			$result =getChannelMessages($_GET['channel']);
				        		}else{
				        			$result ="<h1 class ='emptyChannel'>Requested Channel does not exist</h1>";
				        		}
				        	}else{
				        		
				        		$result ="<h1 class ='emptyChannel'>Please select channel</h1>";
				        	}
			        		echo $result; 
			        		
			        	?>

		        	</div>



			</div>
	</div>

	
	</body>
</html>
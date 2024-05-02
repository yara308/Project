<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_account'));
include('header.php');?>
<style type="text/css">
.sidebar-widget.sidebar-border {
	border-bottom: none;
}
</style>
	<div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Manage My Account</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li class="active">My Account</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area login-register-area pt-30 pb-30">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">

                	<br>
                	<h2>My Profile</h2>

                	<!-- PROFILE START -->
                	<div class="row">
                		<div class="col-lg-4">
                			<div>
	                			<span>Full name</span>
	                			<h4>Najmul Hossain Milon</h4>
                			</div>
                			<br>
                			<div>
	                			<span>Birthday</span>
	                			<h4>20 June 2019</h4>
                			</div>
                		</div>

                		<div class="col-lg-4">
                			<div>
	                			<span>Email Address | <a style="color:blue;" href="account.php?tab=change_email">Change</a></span>
	                			<h4>bdbuzz360@gmail.com</h4>
                			</div>
                			<br>
                			<div>
	                			<span>Gender</span>
	                			<h4>Male</h4>
                			</div>
                		</div>

                		<div class="col-lg-4">
                			<div>
	                			<span>Gender | <a style="color:blue;" class="text-blue" href="account.php?tab=change_mobile">Change</a></span>
	                			<h4>+8801737346122</h4>
                			</div>
                		</div>
                	</div>
                	<!-- PROFILE END -->

                	<div class="row">
                		<div class="col-lg-12">
                			<br>
                			<br>
                			<a class="btn btn-info" href="account.php?tab=edit_profile">Edit Profile</a>
                			<a class="btn btn-info" href="account.php?tab=change_password">Change Password</a>
                		</div>
                	</div>

                	<br>
                	<br>


                	<h2>Edit Profile</h2>

                	<!-- PROFILE EDIT START -->
            		<form action="#" method="post">
            			<div class="form-row">
	                		<div class="col-lg-3">
		                        <div class="sin-login-register">
		                            <label>Full name <span>*</span></label>
		                            <input type="text" name="user-name" placeholder="Enter you first andf last name">
		                        </div>
		                    </div>
		                    <div class="col-lg-1">&nbsp;</div>
	                        <div class="col-lg-4">
	                			<div>
		                			<span>Email Address | <a style="color:blue;" href="account.php?tab=change_email">Change</a></span>
		                			<h4>bdbuzz360@gmail.com</h4>
	                			</div>
	                		</div>
	                		<div class="col-lg-4">
	                			<div>
		                			<span>Gender | <a style="color:blue;" class="text-blue" href="account.php?tab=change_mobile">Change</a></span>
		                			<h4>+8801737346122</h4>
	                			</div>
	                		</div>
	                	</div>
	                	<br>
	                	<div class="form-row">
	                		<div class="col-lg-6">
	                			<div class="sin-login-register">
		                            <label>Birthday <span>*</span></label>
		                            <div class="row">
		                            	<div class="col-lg-4">
		                            		<select id="birthday_month" name="birthday_month">
				                				<option value="1">January</option>
				                				<option value="2">February</option>
				                			</select>
		                            	</div>
		                            	<div class="col-lg-4">
		                            		<select id="birthday_day" name="birthday_day">
				                				<option value="1">01</option>
				                				<option value="2">02</option>
				                			</select>
		                            	</div>
		                            	<div class="col-lg-4">
		                            		<select id="birthday_year" name="birthday_year">
				                				<option value="2019">2019</option>
				                				<option value="1900">1900</option>
				                			</select>
		                            	</div>			
		                            </div>
		                        </div>
	                		</div>	
	                		<div class="col-lg-3">
	                			<div class="sin-login-register">
		                            <label>Gender <span>*</span></label>
		                            <select id="gender" name="gender">
		                				<option value="1">Male</option>
		                				<option value="2">Female</option>
		                			</select>
		                        </div>
	                		</div>
	                	</div>
	                	<div class="form-row">
	                		<div class="col-lg-12">
	                			<br>
	                			<button class="btn" type="submit">Save</button>
	                		</div>
	                    </div>
                    </form>
                	<!-- PROFILE EDIT END -->

                	<br>
                	<br>

                	<!-- ADDRESS BOOK START -->
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="card">
                				<div class="card-header">
                					<h2 class="card-title pull-left">Address Book</h2>
                					<div class="pull-right">
	                					<a class="text-info" href="">Defaut Shipping Address</a> | <a class="text-info" href="">Defaut Billing Address</a>
                					</div>
                				</div>
                				<div class="card-body">
                					<table class="table">
                						<tbody>
                							<tr>
                								<td>Full name</td>
                								<td>Address</td>
                								<td>Region</td>
                								<td>Phone Number</td>
                								<td class="text-center">Action</td>
                							</tr>
                							<tr>
                								<td>Milon</td>
                								<td>Uposhohor, Rajshahi</td>
                								<td>Rajshahi - Rajshahi - Sapura</td>
                								<td>1521504597</td>
                								<td class="text-center"><a href="account.php?tab=address_book&action=edit&id=1">EDIT</a></td>
                							</tr>
                							<tr>
                								<td class="text-right" colspan="6">
                									<a class="btn btn-success" href="account.php?tab=address_book&action=add_new">+ Add New Address</a>
                								</td>
                							</tr>
                						</tbody>
                					</table>
                				</div>
                			</div>
                		</div>
                	</div>
                	<!-- ADDRESS BOOK END -->

                	<br>
                	<br>

                	<h2>Change Password</h2>


                	<!-- CHANGE PASSWORD START -->
                	<div class="row">
                		<div class="col-lg-12">
	                		<form action="#" method="post">
	                            <div class="sin-login-register">
	                                <label>Current Password <span>*</span></label>
	                                <input type="text" name="user-name" placeholder="Please enter your current password">
	                            </div>
	                            <br>
	                            <div class="sin-login-register">
	                                <label>New Passwords <span>*</span></label>
	                                <input type="password" name="user-password" placeholder="Minimum 6 characters with a number and a letter">
	                            </div>
	                            <br>
	                            <div class="sin-login-register">
	                                <label>Retype Passwords <span>*</span></label>
	                                <input type="password" name="user-password" placeholder="Please retype your password">
	                            </div>
	                            <br>
	                            <button class="btn" type="submit">Save</button>
	                        </form>
                		</div>
                	</div>
                	<!-- CHANGE PASSWORD END -->

                	<br>
                	<br>

                	<h2>Write a Review</h2>

                	<!-- REVIEW START -->
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="card">
                				<div class="card-header">
                					<div class="card-title">
	                					Purchased on 21 Apr 2019
	                				</div>
	                				<span>Rate and Review purchased product</span>
                				</div>
                				<div class="card-body">
                					<div class="media">
									  <img class="mr-3" src="assets/img/product-details/client-1.jpg" alt="Generic placeholder image">
									  <div class="media-body">
									    <h5 class="mt-0">Utensils Aluminum Storage Rack Organizer</h5>
									    Color Family:Silver
									    <br>
									    <div class="container-star starCls" style="width: 280.1px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/colorful.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/colorful.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/default.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/default.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/default.png" style="width: 45.22px; height: 45.22px;">
									    </div>
									    <br>
									    <form action="#" method="post">
				                            <div class="rating-form-style mb-20">
                                                <label>Review detail <span>*</span></label>
                                                <textarea name="Your Review"></textarea>
                                            </div>
				                            <button class="btn btn-success" type="submit">SUBMIT</button>
				                        </form>
									  </div>
									</div>
   	             				</div>
                			</div>
	                		
                		</div>
                	</div>
                	<!-- REVIEW END -->


                	<br>
                	<br>

                	<h2>My Reviews</h2>

                	<!-- MY REVIEWS START -->
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="card">
                				<div class="card-header">
                					<div class="card-title">
	                					Purchased on 21 Apr 2019
	                				</div>
	                				<span>Your product rating & review:</span>
                				</div>
                				<div class="card-body">
                					<div class="media">
									  <img class="mr-3" src="assets/img/product-details/client-1.jpg" alt="Generic placeholder image">
									  <div class="media-body">
									    <h5 class="mt-0">Utensils Aluminum Storage Rack Organizer</h5>
									    Color Family:Silver
									    <br>
									    <div class="container-star starCls" style="width: 280.1px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/colorful.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/colorful.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/default.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/default.png" style="width: 45.22px; height: 45.22px;">
									    	<img class="star" src="assets/img/stars/default.png" style="width: 45.22px; height: 45.22px;">
									    </div>
									    <br>
									    <div class="card-body bg-light font-weight-bold">
									    	Delivered and Displayed product are not matched...It have lost my money!!! I am very much disappointed. I strongly recommend to avoid this product. 
									    </div>
									  </div>
									</div>
   	             				</div>
                			</div>
	                		
                		</div>
                	</div>
                	<!-- MY REVIEWS END -->


                	<br>
                	<br>
                	<h2>My Orders</h2>


                	<!-- MY ORDERS START -->
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="card">
                				<div class="card-header">
                					<h2 class="card-title">Order #601514567288597</h2>
									<span>Placed on 03 May 2019 20:57:22</span>
                				</div>
                				<div class="card-body">
                					<table class="table">
                						<tbody>
                							<tr>
                								<td class="text-center">Img</td>
                								<td class="text-center">4 USB And Four Socket Multiplug</td>
                								<td class="text-center">Qty: 1</td>
                								<td class="text-center">Delivered on 23 Apr 2019</td>
                							</tr>
                							<tr>
                								<td class="text-center">Img</td>
                								<td class="text-center">4 USB And Four Socket Multiplug</td>
                								<td class="text-center">Qty: 1</td>
                								<td class="text-center">Delivered on 23 Apr 2019</td>
                							</tr>
                						</tbody>
                					</table>
                				</div>
                			</div>
                		</div>
                	</div>
                	<!-- MY ORDERS END -->


                	<br>
                	<h2>My Cancellations</h2>


                	<!-- MY ORDERS START -->
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="card">
                				<div class="card-header">
                					<h2 class="card-title">Order #601514567288597</h2>
									<span>Canceled on 06 May 2019</span>
                				</div>
                				<div class="card-body">
                					<table class="table">
                						<tbody>
                							<tr>
                								<td class="text-center">Img</td>
                								<td class="text-center">4 USB And Four Socket Multiplug</td>
                								<td class="text-center">Qty: 1</td>
                								<td class="text-center">Cancelled</td>
                							</tr>
                							<tr>
                								<td class="text-center">Img</td>
                								<td class="text-center">4 USB And Four Socket Multiplug</td>
                								<td class="text-center">Qty: 1</td>
                								<td class="text-center">Cancelled</td>
                							</tr>
                						</tbody>
                					</table>
                				</div>
                			</div>
                		</div>
                	</div>
                	<!-- MY ORDERS END -->


                	<br>
                	<h2>My Wishlist</h2>


                	<!-- MY ORDERS START -->
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="card">
                				<div class="card-header">
                					<h2 class="card-title">Order #601514567288597</h2>
									<span>Canceled on 06 May 2019</span>
                				</div>
                				<div class="card-body">
                					<table class="table">
                						<tbody>
                							<tr>
                								<td class="text-center">Img</td>
                								<td>
                									<h4>Men Luxury Stainless Steel Quartz Military Sport Leather Band Dial Wrist Watch</h4>
													Watch Strap Color:…
                								</td>
                								<td class="text-center">
                									<span style="color:orange">৳ 375</span>
                								</td>
                								<td class="text-center">
                									<a class="btn btn-success" href="#">Add to Cart</a>
                								</td>
                							</tr>
                							<tr>
                								<td class="text-center">Img</td>
                								<td>
                									<h4>Men Luxury Stainless Steel Quartz Military Sport Leather Band Dial Wrist Watch</h4>
													Watch Strap Color:…
                								</td>
                								<td class="text-center">
                									<span style="color:orange">৳ 375</span>
                								</td>
                								<td class="text-center">
                									<a class="btn btn-success" href="#">Add to Cart</a>
                								</td>
                							</tr>
                						</tbody>
                					</table>
                				</div>
                			</div>
                		</div>
                	</div>
                	<!-- MY ORDERS END -->

                </div>
                <div class="col-lg-3">
                    <div class="shop-sidebar">
                    	
                    	<div class="sidebar-widget sidebar-border pb-45">
                            <!-- <h4 class="pro-sidebar-title">
                            	<a href="account.php?tab=manage">Manage My Account</a>
                            </h4> -->
                            <div class="sidebar-widget-list mt-30">
                               <ul>
                                   <li><a href="account.php?tab=profile">My Profile</a></li>
                                   <li><a href="account.php?tab=change_password">Change Password</a></li>
                                   <li><a href="account.php?tab=address">Address Book</a></li>
                                   <li><a href="account.php?tab=payment_option">My Payment Options</a></li>
                               </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget sidebar-border pb-45">
                            <h4 class="pro-sidebar-title">
                            	<a href="account.php?tab=orders">My Orders</a>
                            </h4>
                            <div class="sidebar-widget-list mt-30">
                               <ul>
                                   <li><a href="account.php?tab=returns">My Returns</a></li>
                                   <li><a href="account.php?tab=cancellations">My Cancellations</a></li>
                               </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget sidebar-border pb-45">
                            <h4 class="pro-sidebar-title">
                            	<a href="account.php?tab=reviews">My Reviews</a>
                            </h4>
                        </div>

                        <div class="sidebar-widget sidebar-border pb-45">
                            <h4 class="pro-sidebar-title">
                            	<a href="account.php?tab=wishlist">My Wishlist</a>
                            </h4>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>
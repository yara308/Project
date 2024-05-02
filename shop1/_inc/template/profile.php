<!-- PROFILE START -->
<div class="row">
	<div class="col-lg-5">
	<div>
		<span>Full name</span>
		<h4><?php echo $the_customer['customer_name'];?></h4>
	</div>
	<br>
	<div>
		<span>Email Address | <a style="color:blue;" href="account.php?tab=change_email">Change</a></span>
		<h4><?php echo $the_customer['customer_email'];?></h4>
	</div>
	</div>
	<div class="col-lg-2">
		<div>
			<span>Birthday</span>
			<h4><?php echo format_only_date($the_customer['dob']);?></h4>
		</div>
		<br>
		<div>
			<span>Gender</span>
			<h4><?php echo $the_customer['customer_sex'] == 1 ? 'Male' : 'Female';?></h4>
		</div>
	</div>

	<div class="col-lg-5">
		<div>
			<span>Phone | <a style="color:blue;" class="text-blue" href="account.php?tab=change_phone">Change</a></span>
			<h4><?php echo $the_customer['customer_mobile'];?></h4>
		</div>
		<div class="mt-20">
			<span>Address</span>
			<h6><?php echo $the_customer['customer_address'];?>.</h6>
		</div>
	</div>
</div>
<!-- PROFILE END -->

<div class="row d-none d-md-block">
<div class="col-lg-12">
<br>
<br>
<a class="btn btn-info" href="account.php?tab=profile_edit">Edit Profile</a>
<a class="btn btn-info" href="account.php?tab=change_password">Change Password</a>
</div>
</div>
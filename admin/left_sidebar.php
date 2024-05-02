         <div class="main_sidebar">
<div class="side-overlay" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></div>
       
           <!-- sidebar header -->
           <div class="sidebar-header">
               <!-- Logo-->
               <div id="logo">
                   <a href="dashboard.php"> <img src="../assets/images/logomid.png" alt=""></a>
				   <!-- <a href="dashboard.php"> <img src="../assets/images/logo.png" alt=""></a>-->
               </div>
               <span class="btn-close" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
			   
			   </span>
           </div>
       
           <!-- sidebar Menu -->
           <div class="sidebar">
               <div class="sidebar_innr" data-simplebar>
       
                   <div class="sections">
                       <ul>
                         <li class="<?php echo current_nav() == 'admin' || current_nav() == 'dashboard' ? ' active' : null; ?>">
        <a href="dashboard.php" uk-icon="heart">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
		 
		   <path fill="#047cac" d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z"></path>
          <span>
            <?php echo trans('menu_dashboard'); ?>
          </span>
		  </svg>
        </a>
      </li>
	  
	  
	  <?php if (user_group_id() == 1 || has_permission('access', 'create_sell_invoice')) : ?>
        <li class="<?php echo current_nav() == 'pos' ? 'active' : null; ?>">
          <a href="pos.php">
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#7d8250"
                                           d="M12,18H6V14H12M21,14V12L20,7H4L3,12V14H4V20H14V14H18V20H20V14M20,4H4V6H20V4Z">
                                       </path>
            <span>
              <?php echo trans('menu_point_of_sell'); ?>
            </span>
          </a>
        </li>
      <?php endif; ?>
			 <?php if (user_group_id() == 1 || has_permission('access', 'create_sell_invoice')) : ?>
        <li class="<?php echo current_nav() == 'pos' ? 'active' : null; ?>">
          <a href="order.php">
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#7d8250"
                                           d="M12,18H6V14H12M21,14V12L20,7H4L3,12V14H4V20H14V14H18V20H20V14M20,4H4V6H20V4Z">
                                       </path>
            <span>
              <?php echo trans('text_ordered'); ?>
            </span>
          </a>
        </li>
      <?php endif; ?>
                          <li class="treeview<?php echo current_nav() == 'pos' || current_nav() == 'invoice' || current_nav() == 'sell_return' || current_nav() == 'sell_log' || current_nav() == 'giftcard' || current_nav() == 'giftcard_topup' ? ' active' : null; ?>">
        <?php if(user_group_id() == 1 || has_permission('access', 'read_sell_list') ||  has_permission('access', 'read_sell_return') ||  has_permission('access', 'read_sell_log') ||  has_permission('access', 'read_giftcard') ||  has_permission('access', 'add_giftcard') ||  has_permission('access', 'read_giftcard_topup')): ?>
        <a href="invoice.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#8d73cc"
                                           d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zm-1-2V4H5v16h14zM7 6h4v4H7V6zm0 6h10v2H7v-2zm0 4h10v2H7v-2zm6-9h4v2h-4V7z">
                                       </path>
                                   </svg>
          <span><?php echo trans('menu_sell'); ?></span>
         
         </a>
        <?php endif; ?>
</li>		
		
						   
						   
          <?php if (user_group_id() == 1 || has_permission('access', 'read_product')) : ?>
        <li class="treeview<?php echo current_nav() == 'product' || current_nav() == 'product_details' ||  current_nav() == 'import_product' || current_nav() == 'stock_alert' || current_nav() == 'expired' ? ' active' : null; ?>">
          <a href="product.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#03A9F4"
                                           d="M5 3A2 2 0 0 0 3 5H5M7 3V5H9V3M11 3V5H13V3M15 3V5H17V3M19 3V5H21A2 2 0 0 0 19 3M3 7V9H5V7M7 7V11H11V7M13 7V11H17V7M19 7V9H21V7M3 11V13H5V11M19 11V13H21V11M7 13V17H11V13M13 13V17H17V13M3 15V17H5V15M19 15V17H21V15M3 19A2 2 0 0 0 5 21V19M7 19V21H9V19M11 19V21H13V19M15 19V21H17V19M19 19V21A2 2 0 0 0 21 19Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_product'); ?>
            </span> 
          </a>
        <?php endif; ?>
</li>
						   <?php if (user_group_id() == 1 || has_permission('access', 'read_purchase_list') || has_permission('access', 'create_purchase_invoice') || has_permission('access', 'read_purchase_return') || has_permission('access', 'read_purchase_log')) : ?>
        <li class="treeview<?php echo current_nav() == 'purchase' || current_nav() == 'purchase_return' || current_nav() == 'purchase_log' ? ' active' : null; ?>">
          <a href="purchase.php?box_state=open&sup_id=1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#009688"
                                           d="M21,9A1,1 0 0,1 22,10A1,1 0 0,1 21,11H16.53L16.4,12.21L14.2,17.15C14,17.65 13.47,18 12.86,18H8.5C7.7,18 7,17.27 7,16.5V10C7,9.61 7.16,9.26 7.43,9L11.63,4.1L12.4,4.84C12.6,5.03 12.72,5.29 12.72,5.58L12.69,5.8L11,9H21M2,18V10H5V18H2Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_purchase'); ?>
            </span>
          </a>
        <?php endif; ?>
</li>
						    <?php if (user_group_id() == 1 || has_permission('access', 'read_product')) : ?>
        <li class="treeview<?php echo current_nav() == 'barcode_print'  ? ' active' : null; ?>">
          <a href="barcode_print.php">
           <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg" version="1.1">

 <g>
  <title>Layer 1</title>
  <g stroke="null" id="surface1">
   <path stroke="#ffffff" id="svg_1" fill-rule="nonzero" fill="#000" d="m19.41229,4.71415l-1.76535,0l0,-2.65745c0,-0.72788 -0.59771,-1.31842 -1.33444,-1.31842l-11.00911,0c-0.73672,0 -1.33444,0.59055 -1.33444,1.31842l0,2.65745l-1.76534,0c-1.13983,0 -2.07116,0.92015 -2.07116,2.0463l0,8.65903c0,1.12958 0.93133,2.04974 2.07116,2.04974l0.7958,0c0.18418,0 0.33361,-0.14764 0.33361,-0.32961c0,-0.18197 -0.14943,-0.32961 -0.33361,-0.32961l-0.7958,0c-0.77495,0 -1.40394,-0.62488 -1.40394,-1.39052l0,-8.65903c0,-0.76564 0.62899,-1.38709 1.40394,-1.38709l17.20868,0c0.77494,0 1.40393,0.62144 1.40393,1.38709l0,8.65903c0,0.76564 -0.62899,1.39052 -1.40393,1.39052l-0.59772,0c-0.18418,0 -0.33361,0.14764 -0.33361,0.32961c0,0.18197 0.14943,0.32961 0.33361,0.32961l0.59772,0c1.13983,0 2.07115,-0.92015 2.07115,-2.04974l0,-8.65903c0,-1.12615 -0.93132,-2.0463 -2.07115,-2.0463zm-14.77612,-2.65745c0,-0.36394 0.29886,-0.65921 0.66722,-0.65921l11.00911,0c0.36836,0 0.66722,0.29527 0.66722,0.65921l0,2.63685l-12.34354,0l0,-2.63685zm0,0"/>
   <path stroke="#ffffff" id="svg_2" fill-rule="nonzero" fill="#000" d="m14.81126,14.93193l-8.00662,0c-0.18418,0 -0.33361,0.14764 -0.33361,0.32961c0,0.18197 0.14943,0.32961 0.33361,0.32961l8.00662,0c0.18418,0 0.33361,-0.14764 0.33361,-0.32961c0,-0.18197 -0.14943,-0.32961 -0.33361,-0.32961zm0,0"/>
   <path stroke="#ffffff" id="svg_3" fill-rule="nonzero" fill="#000" d="m14.81126,17.23918l-8.00662,0c-0.18418,0 -0.33361,0.14764 -0.33361,0.32961c0,0.18197 0.14943,0.32961 0.33361,0.32961l8.00662,0c0.18418,0 0.33361,-0.14764 0.33361,-0.32961c0,-0.18197 -0.14943,-0.32961 -0.33361,-0.32961zm0,0"/>
   <path stroke="#ffffff" id="svg_4" fill-rule="nonzero" fill="#000" d="m3.45465,7.2892c0,0.36394 -0.29886,0.65921 -0.66722,0.65921c-0.36837,0 -0.66722,-0.29527 -0.66722,-0.65921c0,-0.36395 0.29885,-0.65921 0.66722,-0.65921c0.36836,0 0.66722,0.29527 0.66722,0.65921zm0,0"/>
   <path stroke="#ffffff" id="svg_5" fill-rule="nonzero" fill="#000" d="m5.56403,7.2892c0,0.36394 -0.29886,0.65921 -0.66722,0.65921c-0.36836,0 -0.66722,-0.29527 -0.66722,-0.65921c0,-0.36395 0.29886,-0.65921 0.66722,-0.65921c0.36836,0 0.66722,0.29527 0.66722,0.65921zm0,0"/>
   <path stroke="#ffffff" id="svg_6" fill-rule="nonzero" fill="#000" d="m7.67689,7.2892c0,0.36394 -0.29886,0.65921 -0.66722,0.65921c-0.36836,0 -0.66722,-0.29527 -0.66722,-0.65921c0,-0.36395 0.29886,-0.65921 0.66722,-0.65921c0.36836,0 0.66722,0.29527 0.66722,0.65921zm0,0"/>
   <path stroke="#ffffff" id="svg_7" fill-rule="nonzero" fill="#000" d="m3.80215,20.53523l14.01159,0l0,-8.56975l-14.01159,0l0,8.56975zm0.80274,-7.77664l12.4061,0l0,6.98353l-12.4061,0l0,-6.98353zm0,0"/>
  </g>
 </g>
</svg>
            <span>
              <?php echo trans('menu_barcode_print'); ?>
            </span> 
          </a>
			 </li>
        <?php endif; ?>
<?php if (user_group_id() == 1 || has_permission('access', 'read_supplier')) : ?>
        <li class="treeview<?php echo current_nav() == 'supplier' || current_nav() == 'supplier_profile' ? ' active' : null; ?>">
          <a href="supplier.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#4caf50"
                                           d="M10,2H14A2,2 0 0,1 16,4V6H20A2,2 0 0,1 22,8V19A2,2 0 0,1 20,21H4C2.89,21 2,20.1 2,19V8C2,6.89 2.89,6 4,6H8V4C8,2.89 8.89,2 10,2M14,6V4H10V6H14Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_supplier'); ?>
            </span>
          </a>
        <?php endif; ?>
</li>
						  
						   
					 <?php if (user_group_id() == 1 || has_permission('access', 'read_category')): ?>
              <li class="<?php echo current_nav() == 'category' && !isset($request->get['box_state']) ? ' active' : null; ?>">
                <a href="category.php">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#f35d4d"
                                           d="M20,11H4V8H20M20,15H13V13H20M20,19H13V17H20M11,19H4V13H11M20.33,4.67L18.67,3L17,4.67L15.33,3L13.67,4.67L12,3L10.33,4.67L8.67,3L7,4.67L5.33,3L3.67,4.67L2,3V19A2,2 0 0,0 4,21H20A2,2 0 0,0 22,19V3L20.33,4.67Z">
                                       </path>
                                   </svg>
                   <?php echo trans('label_category'); ?>
                </a>
              </li>
            <?php endif; ?>	   
						   
  

<?php if (user_group_id() == 1 || has_permission('access', 'read_customer') || has_permission('access', 'read_customer_transaction')) : ?>
        <li class="treeview<?php echo current_nav() == 'customer' || current_nav() == 'customer_profile' || current_nav() == 'customer_transaction' ? ' active' : null; ?>">
          <a href="customer.php">
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#b2c17c"
                                           d="M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14M10,4A4,4 0 0,1 14,8C14,8.91 13.69,9.75 13.18,10.43C12.32,10.75 11.55,11.26 10.91,11.9L10,12A4,4 0 0,1 6,8A4,4 0 0,1 10,4M2,20V18C2,15.88 5.31,14.14 9.5,14C9.18,14.78 9,15.62 9,16.5C9,17.79 9.38,19 10,20H2Z">
                                       </path>
                                   </svg> 
            <span>
              <?php echo trans('menu_customer'); ?>
            </span>
           
          </a>
      
        <?php endif; ?>

</li>
		<!--  ahmed onz1-->				   
<?php if (user_group_id() == 1 || has_permission('access', 'read_collection_report') ) : ?>
        <li class="treeview<?php echo  current_nav() == 'report_collection'  ? ' active' : null; ?>">
          <a href="report_collection.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#009688"
                                           d="M21,9A1,1 0 0,1 22,10A1,1 0 0,1 21,11H16.53L16.4,12.21L14.2,17.15C14,17.65 13.47,18 12.86,18H8.5C7.7,18 7,17.27 7,16.5V10C7,9.61 7.16,9.26 7.43,9L11.63,4.1L12.4,4.84C12.6,5.03 12.72,5.29 12.72,5.58L12.69,5.8L11,9H21M2,18V10H5V18H2Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_report_collection'); ?>
            </span>
          </a>
        <?php endif; ?>
</li>

<?php if (user_group_id() == 1 || has_permission('access', 'send_sms') || has_permission('access', 'read_sms_setting') || has_permission('access', 'read_sms_report')) : ?>
        <li id="more-veiw" hidden="" class="treeview<?php echo current_nav() == 'sms_send' || current_nav() == 'sms_setting' || current_nav() == 'sms_report' ? ' active' : null; ?>">
          <a href="sms_send.php">
       <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
 <style type="text/css">
  <![CDATA[
	.st0{fill-rule:evenodd;clip-rule:evenodd;}
]]>
 </style>

 <g>
  <title>background</title>
  <rect fill="none" id="canvas_background" height="26" width="26" y="-1" x="-1"/>
 </g>
 <g>
  <title>Layer 1</title>
  <g stroke="null" id="svg_1">
   <path stroke="null" id="svg_2" d="m5.174113,0.240964l8.539432,0c0.696894,0 1.324297,0.274567 1.782936,0.716177c0.456654,0.441611 0.740574,1.052186 0.740574,1.724202l0,2.03909l-0.72469,0l0,-1.411234l-12.135087,0l0,17.101856l0,0l12.137072,0l0,-1.887406l0.72469,-0.572174l0,3.442644c0,0.673936 -0.28392,1.280671 -0.740574,1.724202c-0.456654,0.441611 -1.088028,0.716177 -1.782936,0.716177l-8.541417,0c-0.696894,0 -1.324297,-0.274567 -1.782936,-0.716177c-0.456654,-0.441611 -0.740574,-1.052186 -0.740574,-1.724202l0,-18.712775c0,-0.673936 0.28392,-1.280671 0.740574,-1.724202c0.456654,-0.441611 1.090014,-0.716177 1.782936,-0.716177l0,0l0,0l0,0zm14.803535,5.77166c1.459308,0 2.628739,1.128987 2.628739,2.542142l0,3.832413c0,1.413154 -1.167446,2.542142 -2.628739,2.542142l-2.521525,0c-1.099941,1.345953 -2.529467,2.156212 -4.221072,2.592063c-0.133025,0.034561 -0.275978,-0.00576 -0.373265,-0.107523c-0.136996,-0.147844 -0.123098,-0.374409 0.031767,-0.506892c0.214429,-0.182404 0.397091,-0.370569 0.544014,-0.556814c0.3276,-0.42049 0.520189,-0.929303 0.682996,-1.428515l-2.459976,0c-1.459308,-0.00192 -2.626754,-1.130908 -2.626754,-2.542142l0,-3.830493c0,-1.411234 1.167446,-2.542142 2.626754,-2.542142c2.773677,0 5.543384,0.00576 8.317061,0.00576l0,0l0,0zm-9.254195,5.067003l0.913308,-0.063362c0.019855,0.165124 0.061549,0.289927 0.121113,0.376329c0.099273,0.138243 0.24024,0.209285 0.424887,0.209285c0.136996,0 0.242225,-0.034561 0.317672,-0.107523c0.073462,-0.071042 0.111185,-0.155524 0.111185,-0.249606c0,-0.090242 -0.035738,-0.168964 -0.105229,-0.240006c-0.071476,-0.071042 -0.234283,-0.136323 -0.492392,-0.201605c-0.422901,-0.105603 -0.720719,-0.245766 -0.901396,-0.42049c-0.180676,-0.174724 -0.272007,-0.39553 -0.272007,-0.668176c0,-0.176644 0.045665,-0.345608 0.138982,-0.503052c0.093316,-0.159364 0.232298,-0.282247 0.416945,-0.372489s0.44077,-0.136323 0.766385,-0.136323c0.397091,0 0.700865,0.082562 0.909337,0.247686c0.208473,0.165124 0.331571,0.42625 0.373265,0.785299l-0.905366,0.059521c-0.023825,-0.157444 -0.075447,-0.270727 -0.150894,-0.343688c-0.077433,-0.071042 -0.184647,-0.107523 -0.319658,-0.107523c-0.111185,0 -0.19656,0.026881 -0.252152,0.078722c-0.055593,0.051841 -0.085374,0.117123 -0.085374,0.192005c0,0.053761 0.023825,0.103683 0.069491,0.147844c0.045665,0.044161 0.150894,0.086402 0.321643,0.126723c0.418931,0.099842 0.720719,0.203525 0.903381,0.307207s0.313702,0.230406 0.397091,0.384009c0.083389,0.153604 0.123098,0.324488 0.123098,0.512652c0,0.220805 -0.053607,0.42625 -0.164793,0.614415c-0.111185,0.186245 -0.264065,0.328328 -0.46261,0.42625c-0.198545,0.096002 -0.446727,0.145924 -0.748516,0.145924c-0.530116,0 -0.895439,-0.113283 -1.099941,-0.339848c-0.204502,-0.224645 -0.319658,-0.512652 -0.347454,-0.860181l0,0l0,0zm7.37,0l0.913308,-0.063362c0.019855,0.165124 0.061549,0.289927 0.121113,0.376329c0.099273,0.138243 0.24024,0.209285 0.424887,0.209285c0.136996,0 0.242225,-0.034561 0.317672,-0.107523c0.073462,-0.071042 0.111185,-0.155524 0.111185,-0.249606c0,-0.090242 -0.035738,-0.168964 -0.105229,-0.240006c-0.069491,-0.071042 -0.234283,-0.138243 -0.492392,-0.201605c-0.422901,-0.105603 -0.720719,-0.245766 -0.901396,-0.42049c-0.180676,-0.174724 -0.272007,-0.39553 -0.272007,-0.668176c0,-0.176644 0.045665,-0.345608 0.138982,-0.503052c0.093316,-0.157444 0.232298,-0.282247 0.416945,-0.372489s0.44077,-0.136323 0.766385,-0.136323c0.397091,0 0.700865,0.082562 0.909337,0.247686c0.208473,0.165124 0.331571,0.42625 0.373265,0.785299l-0.905366,0.059521c-0.023825,-0.157444 -0.075447,-0.270727 -0.150894,-0.343688c-0.077433,-0.071042 -0.184647,-0.107523 -0.319658,-0.107523c-0.111185,0 -0.19656,0.026881 -0.252152,0.078722c-0.055593,0.051841 -0.085374,0.117123 -0.085374,0.192005c0,0.053761 0.023825,0.103683 0.067505,0.147844c0.045665,0.044161 0.15288,0.088322 0.321643,0.126723c0.418931,0.099842 0.720719,0.203525 0.901396,0.307207c0.180676,0.101762 0.315687,0.230406 0.397091,0.384009c0.081404,0.151684 0.123098,0.324488 0.123098,0.512652c0,0.220805 -0.055593,0.42817 -0.164793,0.614415c-0.111185,0.186245 -0.264065,0.330248 -0.46261,0.42625s-0.446727,0.145924 -0.748516,0.145924c-0.52813,0 -0.895439,-0.113283 -1.099941,-0.339848c-0.200531,-0.224645 -0.315687,-0.512652 -0.343483,-0.860181l0,0l0,0zm-3.982818,-2.317496l1.268704,0l0.48445,2.106291l0.48445,-2.106291l1.262748,0l0,3.461844l-0.786239,0l0,-2.640064l-0.607549,2.640064l-0.712778,0l-0.605563,-2.640064l0,2.640064l-0.786239,0l0,-3.461844l-0.001985,0l0,0zm-4.665814,12.415022c0.569825,0 1.034421,0.449291 1.034421,1.000344c0,0.551053 -0.464596,1.000344 -1.034421,1.000344s-1.034421,-0.449291 -1.034421,-1.000344c0,-0.551053 0.46261,-1.000344 1.034421,-1.000344l0,0l0,0l0,0z" class="st0"/>
  </g>
 </g>
</svg>
            <span>
              <?php echo trans('menu_sms'); ?>
            </span>
          </a>
		          <?php endif; ?>
				  <?php if (user_group_id() == 1 || has_permission('access', 'read_transfer')) : ?>
        <li id="more-veiw" hidden="" class="treeview<?php echo current_nav() == 'transfer' || current_nav() == 'transfer_add' ? ' active' : null; ?>">
          <a href="transfer.php">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">

 <g>
  <title>background</title>
  <rect fill="none" id="canvas_background" height="26" width="26" y="-1" x="-1"/>
 </g>
 <g>
  <title>Layer 1</title>
  <g stroke="null" id="svg_1">
   <path stroke="null" id="svg_2" d="m3.126761,18.051142l5.841782,5.616227l0.00038,-3.614955l10.34412,0l0,-4.003304l-0.00038,0l0,-2.720726l0.00038,-0.078545l-0.000761,-3.586999l-4.002544,3.847927l0.00038,2.538532l-6.340626,0l-0.000761,-3.614955l-5.841972,5.616798l0,0zm18.142481,-12.136574l-5.841591,-5.616608l-0.00038,3.615526l-5.330956,0l-0.101366,-0.00038l-4.911798,0l-0.00038,0.194935l0,4.912939l0.00038,4.449088l0.626265,0l3.376469,-3.246195l0,-1.101907l0.00038,-0.101747l0,-1.103619l6.340626,0l0.000761,3.614575l5.841591,-5.616608l0,0l0,0z" clip-rule="evenodd" fill-rule="evenodd"/>
  </g>
 </g>
</svg>
            <span>
              <?php echo trans('menu_transfer'); ?>
            </span> 
          </a>
 </a>
		          <?php endif; ?>
</li>
 <?php if (user_group_id() == 1 || has_permission('access', 'read_expense') || has_permission('access', 'create_expense') || has_permission('access', 'read_expense_category') || has_permission('access', 'read_expense_summary') || has_permission('access', 'read_expense_monthwise')) : ?>
        <li class="treeview<?php echo current_nav() == 'expense' || current_nav() == 'expense_category' || current_nav() == 'expense_summary' || (current_nav() == 'expense_monthwise' && !isset($request->get['show_top'])) ? ' active' : null; ?>">
          <a href="expense.php">
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#8BC34A"
                                           d="M14.19,14.19L6,18L9.81,9.81L18,6M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,10.9A1.1,1.1 0 0,0 10.9,12A1.1,1.1 0 0,0 12,13.1A1.1,1.1 0 0,0 13.1,12A1.1,1.1 0 0,0 12,10.9Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_expenditure'); ?>
            </span>
           
          </a>
			  </li>
<?php endif; ?>
				   <?php if (user_group_id() == 1 || has_permission('access', 'read_bank_transactions')): ?>
              <li class="<?php echo current_nav() == 'bank_transactions' ? ' active' : null; ?>">
                <a href="bank_transactions.php">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">

 <g>
  <title>background</title>
  <rect fill="none" id="canvas_background" height="26" width="26" y="-1" x="-1"/>
 </g>
 <g>
  <title>Layer 1</title>
  <g stroke="null" id="svg_1">
   <path stroke="null" id="svg_2" d="m22.66129,8.45161c0.18731,0 0.33871,-0.15174 0.33871,-0.33871l0,-5.41935c0,-0.18697 -0.1514,-0.33871 -0.33871,-0.33871l-0.33871,0l0,-1.01613c0,-0.18697 -0.1514,-0.33871 -0.33871,-0.33871l-18.96774,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,1.01613l-0.33871,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,5.41935c0,0.18697 0.1514,0.33871 0.33871,0.33871l0.33871,0l0,11.51613l-0.33871,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,1.35484c0,0.18697 0.1514,0.33871 0.33871,0.33871l20.32258,0c0.18731,0 0.33871,-0.15174 0.33871,-0.33871l0,-1.35484c0,-0.18697 -0.1514,-0.33871 -0.33871,-0.33871l-0.33871,0l0,-11.51613l0.33871,0zm-19.30645,-6.77419l18.29032,0l0,0.67742l-18.29032,0l0,-0.67742zm-0.67742,1.35484l19.64516,0l0,4.74194l-19.64516,0l0,-4.74194zm18.96774,8.80645l-4.06452,0l0,-2.03226l4.06452,0l0,2.03226zm-4.74194,0l-4.06452,0l0,-2.03226l4.06452,0l0,2.03226zm-4.74194,0l-4.06452,0l0,-2.03226l4.06452,0l0,2.03226zm-4.74194,0l-4.06452,0l0,-2.03226l4.06452,0l0,2.03226zm14.90322,9.48387l-19.64516,0l0,-0.67742l19.64516,0l0,0.67742zm-8.80645,-1.35484l-0.67742,0l0,-5.08064c0,-0.18697 -0.1514,-0.33871 -0.33871,-0.33871l-6.77419,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,5.08064l-0.67742,0l0,-6.09677l8.80645,0l0,6.09677zm-7.45161,0l0,-4.74194l2.70968,0l0,4.74194l-2.70968,0zm3.3871,-4.74194l2.70968,0l0,4.74194l-2.70968,0l0,-4.74194zm10.83871,4.74194l-4.06452,0l0,-6.09677l4.06452,0l0,6.09677zm0.67742,0l0,-6.43548c0,-0.18697 -0.1514,-0.33871 -0.33871,-0.33871l-4.74194,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,6.43548l-1.35484,0l0,-6.43548c0,-0.18697 -0.1514,-0.33871 -0.33871,-0.33871l-9.48387,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,6.43548l-0.67742,0l0,-7.45161l18.29032,0l0,7.45161l-0.67742,0zm0.67742,-10.83871l-18.29032,0l0,-0.67742l18.29032,0l0,0.67742z"/>
   <path stroke="null" id="svg_3" d="m8.09677,3.70968l-1.35484,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,2.70968c0,0.18697 0.1514,0.33871 0.33871,0.33871l1.35484,0c0.56023,0 1.01613,-0.4559 1.01613,-1.01613c0,-0.26013 -0.09823,-0.49756 -0.25945,-0.67742c0.16123,-0.17985 0.25945,-0.41729 0.25945,-0.67742c0,-0.56023 -0.4559,-1.01613 -1.01613,-1.01613zm0,2.70968l-1.01613,0l0,-0.67742l1.01613,0c0.18697,0 0.33871,0.15208 0.33871,0.33871s-0.15174,0.33871 -0.33871,0.33871zm0,-1.35484l-1.01613,0l0,-0.67742l1.01613,0c0.18697,0 0.33871,0.15208 0.33871,0.33871s-0.15174,0.33871 -0.33871,0.33871z"/>
   <path stroke="null" id="svg_4" d="m11.14516,3.70968c-0.74719,0 -1.35484,0.60765 -1.35484,1.35484l0,2.03226l0.67742,0l0,-1.01613l1.35484,0l0,1.01613l0.67742,0l0,-2.03226c0,-0.74719 -0.60765,-1.35484 -1.35484,-1.35484zm-0.67742,1.69355l0,-0.33871c0,-0.3736 0.30382,-0.67742 0.67742,-0.67742s0.67742,0.30382 0.67742,0.67742l0,0.33871l-1.35484,0z"/>
   <path stroke="null" id="svg_5" d="m15.20968,5.74194l-1.42258,-1.89677c-0.08739,-0.11652 -0.23913,-0.16427 -0.378,-0.11821c-0.13853,0.0464 -0.23168,0.17545 -0.23168,0.32144l0,3.04839l0.67742,0l0,-2.03226l1.42258,1.89677c0.06503,0.08671 0.16631,0.13548 0.27097,0.13548c0.03556,0 0.07181,-0.00576 0.10703,-0.01727c0.13853,-0.0464 0.23168,-0.17545 0.23168,-0.32144l0,-3.04839l-0.67742,0l0,2.03226z"/>
   <path stroke="null" id="svg_6" d="m18.59677,3.70968l-0.67742,0c0,0.48029 -0.25911,0.91181 -0.67742,1.14145l0,-1.14145l-0.67742,0l0,3.3871l0.67742,0l0,-1.14145c0.41831,0.22965 0.67742,0.66116 0.67742,1.14145l0.67742,0c0,-0.70282 -0.36615,-1.33587 -0.96058,-1.69355c0.59444,-0.35768 0.96058,-0.99073 0.96058,-1.69355z"/>
   <path stroke="null" id="svg_7" d="m17.24193,17.25806l2.03226,0c0.18731,0 0.33871,-0.15174 0.33871,-0.33871l0,-2.03226c0,-0.18697 -0.1514,-0.33871 -0.33871,-0.33871l-2.03226,0c-0.18731,0 -0.33871,0.15174 -0.33871,0.33871l0,2.03226c0,0.18697 0.1514,0.33871 0.33871,0.33871zm0.33871,-2.03226l1.35484,0l0,1.35484l-1.35484,0l0,-1.35484z"/>
  </g>
 </g>
</svg><?php echo trans('title_bank_transactions'); ?>
                </a>
              </li>
            <?php endif; ?>
                  </ul>
       <a href="#" class="button secondary px-5 btn-more"
                           uk-toggle="target: #more-veiw; animation: uk-animation-fade">
                           <span id="more-veiw">See More <i class="icon-feather-chevron-down ml-2"></i></span>
                           <span id="more-veiw" hidden>See Less<i class="icon-feather-chevron-up ml-2"></i> </span>
                       </a>
                       </a>
                   </div>
        <div class="sections">
                       <h3> More Tool </h3>
                       <ul>
						   
 <li class="treeview<?php echo current_nav() == 'report_overview' ||  current_nav() == 'report_customer_due_collection' || current_nav() == 'report_supplier_due_paid' || current_nav() == 'report_sell_itemwise' || current_nav() == 'report_sell_categorywise' || current_nav() == 'report_sell_supplierwise' || current_nav() == 'report_purchase_itemwise' || current_nav() == 'report_purchase_categorywise' || current_nav() == 'report_purchase_supplierwise' || current_nav() == 'report_sell_payment' || current_nav() == 'report_purchase_payment' || current_nav() == 'report_sell_tax' || current_nav() == 'report_purchase_tax' || current_nav() == 'report_tax_overview' || current_nav() == 'report_stock'  ? ' active' : null; ?>">
        <?php if(user_group_id() == 1 || has_permission('access', 'read_overview_report') || has_permission('access', 'read_collection_report') || has_permission('access', 'read_customer_due_collection_report') || has_permission('access', 'read_supplier_due_paid_report') || has_permission('access', 'read_sell_report') || has_permission('access', 'read_purchase_report') || has_permission('access', 'read_sell_payment_report') || has_permission('access', 'read_purchase_payment_report') || has_permission('access', 'read_sell_tax_report') || has_permission('access', 'read_purchase_tax_report') || has_permission('access', 'read_tax_overview_report') || has_permission('access', 'read_stock_report')): ?>
        <a href="report_overview.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#f25e4e"
                                           d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z">
                                       </path>
                                   </svg>
          <span><?php echo trans('menu_reports'); ?></span>
         </a>
        <?php endif; ?>

</li>
						   <?php if (user_group_id() == 1 || has_permission('access', 'read_analytics')) : ?>
        <li class="<?php echo current_nav() == 'analytics' ? 'active' : null; ?>">
          <a href="analytics.php">
          <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">

 <g>
  <title>background</title>
  <rect fill="none" id="canvas_background" height="26" width="26" y="-1" x="-1"/>
 </g>
 <g>
  <title>Layer 1</title>
  <g stroke="null" id="svg_1">
   <path stroke="null" id="svg_2" d="m21.74048,6.35894l-0.4654,0a3.2251,3.2251 0 1 0 -4.80272,0l-4.40719,0l0,-3.58345a0.35834,0.35834 0 0 0 -0.35834,-0.35834l-1.43338,0a0.35834,0.35834 0 0 0 -0.35834,0.35834l0,3.58345l-0.35834,0l0,-5.01683a0.35834,0.35834 0 0 0 -0.35834,-0.35834l-1.43338,0a0.35834,0.35834 0 0 0 -0.35834,0.35834l0,5.01683l-0.35834,0l0,-2.50841a0.35834,0.35834 0 0 0 -0.35834,-0.35834l-1.43338,0a0.35834,0.35834 0 0 0 -0.35834,0.35834l0,2.50841l-2.50841,0a1.43499,1.43499 0 0 0 -1.43338,1.43338l0,10.75035a1.43499,1.43499 0 0 0 1.43338,1.43338l7.38638,0l-0.47794,1.43338l-1.17492,0a0.35834,0.35834 0 0 0 -0.35834,0.35834l0,0.71669l-3.58345,0a0.35834,0.35834 0 0 0 0,0.71669l15.76718,0a0.35834,0.35834 0 0 0 0,-0.71669l-3.58345,0l0,-0.71669a0.35834,0.35834 0 0 0 -0.35834,-0.35834l-1.17492,0l-0.47794,-1.43338l7.38638,0a1.43499,1.43499 0 0 0 1.43338,-1.43338l0,-10.75035a1.43499,1.43499 0 0 0 -1.43338,-1.43338zm-2.50841,-4.6325a2.51334,2.51334 0 0 1 2.12409,2.12409l-2.12409,0l0,-2.12409zm-0.21008,2.84078l2.33417,0a2.50671,2.50671 0 0 1 -3.9839,1.64973l1.64973,-1.64973zm-2.65668,-0.35834a2.51227,2.51227 0 0 1 2.15007,-2.48243l0,2.33417l-1.64973,1.64973a2.49533,2.49533 0 0 1 -0.50034,-1.50147zm-5.73352,-1.07503l0.71669,0l0,6.80855l-0.71669,0l0,-6.80855zm-1.07503,3.94179l0.35834,0l0,2.86676l-0.35834,0l0,-2.86676zm-1.43338,-5.37517l0.71669,0l0,8.24193l-0.71669,0l0,-8.24193zm-1.07503,5.37517l0.35834,0l0,2.86676l-0.35834,0l0,-2.86676zm-1.43338,-2.86676l0.71669,0l0,5.73352l-0.71669,0l0,-5.73352zm10.03366,17.91725l0,0.35834l-7.1669,0l0,-0.35834l7.1669,0zm-5.59466,-0.71669l0.47794,-1.43338l3.06654,0l0.47794,1.43338l-4.02242,0zm12.40321,-2.86676a0.71763,0.71763 0 0 1 -0.71669,0.71669l-19.35063,0a0.71763,0.71763 0 0 1 -0.71669,-0.71669l0,-0.71669l20.78401,0l0,0.71669zm0,-1.43338l-20.78401,0l0,-9.31697a0.71763,0.71763 0 0 1 0.71669,-0.71669l2.50841,0l0,2.86676l-0.35834,0l0,-2.15007a0.35834,0.35834 0 0 0 -0.35834,-0.35834l-1.43338,0a0.35834,0.35834 0 0 0 -0.35834,0.35834l0,2.50841a0.35834,0.35834 0 0 0 0.35834,0.35834l11.46704,0a0.35834,0.35834 0 0 0 0.35834,-0.35834l0,-2.50841a0.35834,0.35834 0 0 0 -0.35834,-0.35834l-1.43338,0a0.35834,0.35834 0 0 0 -0.35834,0.35834l0,2.15007l-0.35834,0l0,-2.86676l5.33396,0a3.21314,3.21314 0 0 0 2.94918,0l1.39217,0a0.71763,0.71763 0 0 1 0.71669,0.71669l0,9.31697zm-18.63394,-8.95862l0,1.79172l-0.71669,0l0,-1.79172l0.71669,0zm9.31697,1.79172l0,-1.79172l0.71669,0l0,1.79172l-0.71669,0z"/>
   <path stroke="null" id="svg_3" d="m4.89826,18.18432l-2.15007,0a0.35834,0.35834 0 0 0 0,0.71669l2.15007,0a0.35834,0.35834 0 0 0 0,-0.71669z"/>
   <path stroke="null" id="svg_4" d="m6.33164,18.18432l-0.35834,0a0.35834,0.35834 0 0 0 0,0.71669l0.35834,0a0.35834,0.35834 0 0 0 0,-0.71669z"/>
   <path stroke="null" id="svg_5" d="m16.00696,9.94239a0.35718,0.35718 0 0 0 0.25339,-0.10495l1.32838,-1.32843l3.0767,0a0.35834,0.35834 0 0 0 0,-0.71669l-3.2251,0a0.35834,0.35834 0 0 0 -0.25339,0.10495l-1.43338,1.43338a0.35834,0.35834 0 0 0 0.25339,0.61174z"/>
   <path stroke="null" id="svg_6" d="m20.66544,13.88418a1.07503,1.07503 0 0 0 -0.92946,0.53617l-3.75142,-2.18859a1.07503,1.07503 0 0 0 -2.1102,0.02688l-3.77516,2.83137a1.07409,1.07409 0 0 0 -1.85802,0.09765l-3.73127,-1.55477a1.07548,1.07548 0 1 0 -0.08779,0.73953l3.73127,1.55477a1.07481,1.07481 0 0 0 2.10259,-0.05913l3.77516,-2.83137a1.07383,1.07383 0 0 0 1.83025,-0.04703l3.75142,2.18859a1.07503,1.07503 0 1 0 1.05264,-1.29407zm-16.84221,0.00179a0.35924,0.35924 0 1 1 0,-0.00179l0,0.00179zm5.37517,2.14828a0.35884,0.35884 0 0 1 -0.35834,-0.35834l0,-0.00179a0.35834,0.35834 0 1 1 0.35834,0.36014zm5.73352,-3.2251a0.35834,0.35834 0 1 1 0.35834,-0.35834a0.35884,0.35884 0 0 1 -0.35834,0.35834zm5.73352,2.50841a0.35834,0.35834 0 1 1 0.35834,-0.35834a0.35884,0.35884 0 0 1 -0.35834,0.35834z"/>
   <path stroke="null" id="svg_7" d="m17.79868,16.03425l-2.50841,0a0.35834,0.35834 0 0 0 0,0.71669l2.50841,0a0.35834,0.35834 0 0 0 0,-0.71669z"/>
   <path stroke="null" id="svg_8" d="m17.79868,14.95922l-1.07503,0a0.35834,0.35834 0 0 0 0,0.71669l1.07503,0a0.35834,0.35834 0 0 0 0,-0.71669z"/>
   <path stroke="null" id="svg_9" d="m2.7482,11.73411l3.94179,0a0.35834,0.35834 0 0 0 0,-0.71669l-3.94179,0a0.35834,0.35834 0 0 0 0,0.71669z"/>
   <path stroke="null" id="svg_10" d="m7.76502,11.73411l0.35834,0a0.35834,0.35834 0 0 0 0,-0.71669l-0.35834,0a0.35834,0.35834 0 0 0 0,0.71669z"/>
  </g>
 </g>
</svg>
            <span>
              <?php echo trans('menu_analytics'); ?>
            </span>
          </a>
        </li>
      <?php endif; ?>
<?php if (user_group_id() == 1 || has_permission('access', 'activate_store')) : ?>
        <li class="<?php echo current_nav() == 'store_select' ? 'active' : null; ?>">
          <a href="../store_select.php">
            
            <span>
              <?php echo trans('menu_store_change'); ?>
            </span>
          </a>
        </li>
      <?php endif; ?>
                             
						   </ul>
                                     </div>
                   <!--  Optional Footer -->
                   <div id="foot">
       
                       <ul>
                           <li> <a href="#"> عن الشركه </a></li>
                           <li> <a href="#"> الاعدادت </a></li>
                           <li> <a href="#"> الخصوصيه </a></li>
                           <li> <a href="#"> القوانين والشروط </a></li>
                       </ul>
       
       
                       <div class="foot-content">
                           <p>© 2020 <strong>Midpos</strong>. كل الحقوق محفوظه. </p>
                       </div>
       
                   </div>
       
       
       
               </div>
       
       
           </div>
       
       </div>
  
                      
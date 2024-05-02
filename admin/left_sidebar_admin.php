         <div class="main_sidebar">
<div class="side-overlay" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></div>
       
           <!-- sidebar header -->
           <div class="sidebar-header">
               <!-- Logo-->
               <div id="logo">
                   <a href="dashboard.php"> <img src="../assets/images/logomid.png" alt=""></a>
               </div>
               <span class="btn-close" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
			   
			   </span>
           </div>
       
           <!-- sidebar Menu -->
           <div class="sidebar">
               <div class="sidebar_innr" data-simplebar>
       
                   <div class="sections">
                       <ul>
					<?php if (user_group_id() == 1 || has_permission('access', 'create_store')): ?>
                    <li class="<?php echo current_nav() == 'store_create' ? ' active' : null; ?>">
                       
 <a href="store_create.php" uk-icon="heart">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
		 
		   <path fill="#047cac" d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z"></path>
          <span>
            <?php echo trans('menu_create_store'); ?>
          </span>
		  </svg>
        </a>
      </li><?php endif; ?>
	 <?php if (user_group_id() == 1 || has_permission('access', 'read_store')) : ?>
                    <li class="<?php echo current_nav() == 'store_single' ? 'active' : null; ?>">
                   
 <a href="store_single.php" uk-icon="heart">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
		 
		   <path fill="#047cac" d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z"></path>
          <span>
            <?php echo trans('menu_store_setting'); ?>
          </span>
		  </svg>
        </a>
      </li><?php endif; ?>
	  
	  <?php if (user_group_id() == 1 || has_permission('access', 'read_store')): ?>
                    <li class="<?php echo current_nav() == 'store' ? ' active' : null; ?>">
                  <a href="store.php">
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#7d8250"
                                           d="M12,18H6V14H12M21,14V12L20,7H4L3,12V14H4V20H14V14H18V20H20V14M20,4H4V6H20V4Z">
                                       </path>
            <span>
              <?php echo trans('menu_store_list'); ?>
            </span>
          </a>
        </li>
      <?php endif; ?>
	   <?php if (user_group_id() == 1 || has_permission('access', 'create_user')) : ?>
              <li class="<?php echo current_nav() == 'user'  && isset($request->get['box_state']) ? 'active' : null; ?>">
                <a href="user.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#8d73cc"
                                           d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zm-1-2V4H5v16h14zM7 6h4v4H7V6zm0 6h10v2H7v-2zm0 4h10v2H7v-2zm6-9h4v2h-4V7z">
                                       </path>
                                   </svg>
          <span><?php echo trans('menu_user_list'); ?></span>
         
         </a>
        <?php endif; ?>
		<?php if (user_group_id() == 1 || has_permission('access', 'create_usergroup')) : ?>
              <li class="<?php echo current_nav() == 'user_group' && isset($request->get['box_state']) ? 'active' : null; ?>">
                <a href="user_group.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#8d73cc"
                                           d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zm-1-2V4H5v16h14zM7 6h4v4H7V6zm0 6h10v2H7v-2zm0 4h10v2H7v-2zm6-9h4v2h-4V7z">
                                       </path>
                                   </svg>
          <span><?php echo trans('menu_usergroup_list'); ?></span>
         
         </a>
        <?php endif; ?>
                       <?php if (user_group_id() == 1 || has_permission('access', 'receipt_template')) : ?>
              <li class="<?php echo current_nav() == 'receipt_template' ? 'active' : null; ?>">
                <a href="receipt_template.php?template_id=<?php echo get_preference('receipt_template') ? get_preference('receipt_template') : 1;?>">
                 
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#8d73cc"
                                           d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zm-1-2V4H5v16h14zM7 6h4v4H7V6zm0 6h10v2H7v-2zm0 4h10v2H7v-2zm6-9h4v2h-4V7z">
                                       </path>
                                   </svg>
          <span><?php echo trans('menu_receipt_template'); ?></span>
         
         </a>
        <?php endif; ?>
</li>		
		
						   
						   
           <?php if (user_group_id() == 1 || has_permission('access', 'read_currency')) : ?>
              <li class="<?php echo current_nav() == 'currency' ? 'active' : null; ?>">
                <a href="currency.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#03A9F4"
                                           d="M5 3A2 2 0 0 0 3 5H5M7 3V5H9V3M11 3V5H13V3M15 3V5H17V3M19 3V5H21A2 2 0 0 0 19 3M3 7V9H5V7M7 7V11H11V7M13 7V11H17V7M19 7V9H21V7M3 11V13H5V11M19 11V13H21V11M7 13V17H11V13M13 13V17H17V13M3 15V17H5V15M19 15V17H21V15M3 19A2 2 0 0 0 5 21V19M7 19V21H9V19M11 19V21H13V19M15 19V21H17V19M19 19V21A2 2 0 0 0 21 19Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_currency'); ?>
            </span> 
          </a>
        <?php endif; ?>
</li>
						   
					 <?php if (user_group_id() == 1 || has_permission('access', 'read_pmethod')) : ?>
              <li class="<?php echo current_nav() == 'pmethod' ? 'active' : null; ?>">
                <a href="pmethod.php">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#f35d4d"
                                           d="M20,11H4V8H20M20,15H13V13H20M20,19H13V17H20M11,19H4V13H11M20.33,4.67L18.67,3L17,4.67L15.33,3L13.67,4.67L12,3L10.33,4.67L8.67,3L7,4.67L5.33,3L3.67,4.67L2,3V19A2,2 0 0,0 4,21H20A2,2 0 0,0 22,19V3L20.33,4.67Z">
                                       </path>
                                   </svg>
                   <?php echo trans('menu_pmethod'); ?>
                </a>
              </li>
            <?php endif; ?>	   
			 <?php if (user_group_id() == 1 || has_permission('access', 'read_expense_category')) : ?>
              <li class="<?php echo current_nav() == 'expense_category' ? 'active' : null; ?>">
                <a href="expense_category.php">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#f35d4d"
                                           d="M20,11H4V8H20M20,15H13V13H20M20,19H13V17H20M11,19H4V13H11M20.33,4.67L18.67,3L17,4.67L15.33,3L13.67,4.67L12,3L10.33,4.67L8.67,3L7,4.67L5.33,3L3.67,4.67L2,3V19A2,2 0 0,0 4,21H20A2,2 0 0,0 22,19V3L20.33,4.67Z">
                                       </path>
                                   </svg>
                   <?php echo trans('menu_category'); ?>
                </a>
              </li>
            <?php endif; ?>	   
 
 <?php if (user_group_id() == 1 || has_permission('access', 'read_brand')): ?>
                    <li class="<?php echo current_nav() == 'brand'  && !isset($request->get['box_state']) ? ' active' : null; ?>">
                      <a href="brand.php">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#f35d4d"
                                           d="M20,11H4V8H20M20,15H13V13H20M20,19H13V17H20M11,19H4V13H11M20.33,4.67L18.67,3L17,4.67L15.33,3L13.67,4.67L12,3L10.33,4.67L8.67,3L7,4.67L5.33,3L3.67,4.67L2,3V19A2,2 0 0,0 4,21H20A2,2 0 0,0 22,19V3L20.33,4.67Z">
                                       </path>
                                   </svg>
                        <span>
                          <?php echo trans('menu_brand_list'); ?>
                        </span>
                      </a>
                    </li>
                  <?php endif; ?>			
						   
  <?php if (user_group_id() == 1 || has_permission('access', 'read_unit')) : ?>
              <li class="<?php echo current_nav() == 'unit' ? 'active' : null; ?>">
                <a href="unit.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#4caf50"
                                           d="M10,2H14A2,2 0 0,1 16,4V6H20A2,2 0 0,1 22,8V19A2,2 0 0,1 20,21H4C2.89,21 2,20.1 2,19V8C2,6.89 2.89,6 4,6H8V4C8,2.89 8.89,2 10,2M14,6V4H10V6H14Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_unit'); ?>
            </span>
          </a>
        <?php endif; ?>
</li>
<?php if (user_group_id() == 1 || has_permission('access', 'read_taxrate')) : ?>
              <li class="<?php echo current_nav() == 'taxrate' ? 'active' : null; ?>">
                <a href="taxrate.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#009688"
                                           d="M21,9A1,1 0 0,1 22,10A1,1 0 0,1 21,11H16.53L16.4,12.21L14.2,17.15C14,17.65 13.47,18 12.86,18H8.5C7.7,18 7,17.27 7,16.5V10C7,9.61 7.16,9.26 7.43,9L11.63,4.1L12.4,4.84C12.6,5.03 12.72,5.29 12.72,5.58L12.69,5.8L11,9H21M2,18V10H5V18H2Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_taxrate'); ?>
            </span>
          </a>
        <?php endif; ?>
</li>
 <?php if (user_group_id() == 1 || has_permission('access', 'read_box')) : ?>
              <li class="<?php echo current_nav() == 'box' ? 'active' : null; ?>">
                <a href="box.php">
 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#b2c17c"
                                           d="M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14M10,4A4,4 0 0,1 14,8C14,8.91 13.69,9.75 13.18,10.43C12.32,10.75 11.55,11.26 10.91,11.9L10,12A4,4 0 0,1 6,8A4,4 0 0,1 10,4M2,20V18C2,15.88 5.31,14.14 9.5,14C9.18,14.78 9,15.62 9,16.5C9,17.79 9.38,19 10,20H2Z">
                                       </path>
                                   </svg> 
            <span>
              <?php echo trans('menu_box'); ?>
            </span>
           
          </a>
      
        <?php endif; ?>

</li>


<?php if (user_group_id() == 1 || has_permission('access', 'read_printer')) : ?>
              <li class="<?php echo current_nav() == 'printer' ? 'active' : null; ?>">
                <a href="printer.php">
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
              <?php echo trans('menu_printer'); ?>
            </span>
          </a>
		          <?php endif; ?>
				  
				  
				 <?php if (user_group_id() == 1 || has_permission('access', 'read_language')) : ?>
				 
              <li class="<?php echo current_nav() == 'language' ? 'active' : null; ?>">
			  
                <a href="language.php?lang=ar">
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
              <?php echo trans('menu_language'); ?>
            </span> 
          </a>
 </a>
		          <?php endif; ?>
</li>
  <?php if ((user_group_id() == 1 || has_permission('access', 'reset')) && !DEMO) : ?>
              <li class="<?php echo current_nav() == 'reset' ? 'active' : null; ?>">
                <a href="reset.php">
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#8BC34A"
                                           d="M14.19,14.19L6,18L9.81,9.81L18,6M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,10.9A1.1,1.1 0 0,0 10.9,12A1.1,1.1 0 0,0 12,13.1A1.1,1.1 0 0,0 13.1,12A1.1,1.1 0 0,0 12,10.9Z">
                                       </path>
                                   </svg>
            <span>
              <?php echo trans('menu_data_reset'); ?>
            </span>
           
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
						   
 
						  
<?php if (user_group_id() == 1 || has_permission('access', 'activate_store')) : ?>
        <li class="<?php echo current_nav() == 'store_select' ? 'active' : null; ?>">
          <a href="../store_select.php">
            
            <span>
              <?php echo trans('menu_store_change'); ?>
            </span>
          </a>
        </li>
      <?php endif; ?>
                             <li>
                               <a href="dashboard.php">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path fill="#7d8250"
                                           d="M12,18H6V14H12M21,14V12L20,7H4L3,12V14H4V20H14V14H18V20H20V14M20,4H4V6H20V4Z">
                                       </path>
                                   </svg> chenge to Panle store </a>
                           </li>
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
  
                      
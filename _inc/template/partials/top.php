 <!-- midpos top  -->
<div class="main_content">

       <!-- header -->
       <div id="main_header">
           <header>
               <div class="header-innr">

                   <!-- Logo-->
                   <div class="header-btn-traiger is-hidden" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
                       <span></span></div>

                    <!-- Logo-->
                    <div id="logo">
                       <a href="#"> <img src="../assets/images/logo.png" alt=""></a>
                       <a href="#"> <img src="../assets/images/logo-light.png" class="logo-inverse"
                               alt=""></a>
                   </div>
                 <!-- form search-->
                   <div class="head_search">
				    
                                <!-- browse pos  -->
                       <a href="#" class="opts_icon uk-visible@s" uk-tooltip="title: اللغه ; pos: bottom ;offset:7">
                           <img src="../assets/midpos/img/flags/<?php echo $user->getAllPreference()['language'];?>.png" alt="<?php echo $user->getAllPreference()['language'];?>"" alt="">
                       </a>
                           
				    

                       <!-- browse apps dropdown -->
                       <div uk-dropdown="mode:click ; pos: bottom-center ; animation: uk-animation-scale-up"
                           class="icon-browse display-hidden">
						   
               <ul class="dropdown-search-list">
			   <li class="list-title">  </li>
			    <?php foreach(get_langs() as $the_lang): if($user->getAllPreference()['language'] == $the_lang['slug']) continue; ?>
                                   
                                   <li> <a href="<?php echo $_SERVER['PHP_SELF'];?>?lang=<?php echo $the_lang['code'];?>" title="<?php echo trans('text_'.$the_lang['slug']); ?>">
                                           <img src="../assets/midpos/img/flags/<?php echo $the_lang['code'];?>.png" class="language-img" >&nbsp;&nbsp;<?php echo trans('text_'.$the_lang['slug']); ?>
                                           
                                       </a>
                                   </li>
                                     <?php endforeach; ?>
                               </ul>


				   </div>
				    <a href="#" onClick="return false;" id="live_datetime"></a>
                  </div>
                 
				  
                   <!-- user icons -->
                   <div class="head_user">			 
					   <!-- browse pos  -->
                       <a href="pos.php" class="opts_icon uk-visible@s" uk-tooltip="title: البيع ; pos: bottom ;offset:7">
                           <img src="../assets/images/icons/pos.svg" alt="">
                       </a>

                       <!-- browse apps dropdown -->
                      


     
  
                       <!-- id="show-filter-box"  search dropdown -->
                       <a href="#"id="show-filter-box" class="opts_icon" uk-tooltip="title: تحديد وقت للتقارير ; pos: bottom ;offset:7" >
                           <img src="../assets/images/icons/search.svg" alt=""> <span></span>
                       </a>

                      


                       <!-- notificiation icon  -->
                       <a href="stock_alert.php" class="opts_icon"  uk-tooltip="title: انزارانتهاء المنتجات ; pos: bottom ;offset:7" >
                           <img src="../assets/images/icons/bell.svg" alt=""> 
						   <?php 
              $total_out_of_stock = total_out_of_stock();?>
              <?php if ($total_out_of_stock > 0) : ?>
                <span >
                  <?php echo $total_out_of_stock; ?></span>
              <?php endif; ?>
                       </a>


                       <!-- notificiation dropdown -->
                       

                       <!-- profile -image -->
                       <a class="opts_account" href="#"> <img src="../assets/images/avatars/avatar-2.jpg" alt=""></a>

                       <!-- profile dropdown-->
                       <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                           class="dropdown-notifications rounded display-hidden">

                           <!-- User Name / Avatar -->
                           <!-- User Name / Avatar -->
                           <a href="user_profile.php?id=<?php echo user_id();?>">

                               <div class="dropdown-user-details">

                                   <div class="dropdown-user-cover">
                                       <img src="../assets/images/avatars/profile-cover.jpg" alt="">
                                   </div>
                                   <div class="dropdown-user-avatar">
                                       <img src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/users'; ?>/<?php echo get_the_user(user_id(), 'user_image'); ?>" alt="">
                                   </div>
                                   <div class="dropdown-user-name" title="<?php echo $user->getUserName(); ?>" > <?php echo ucfirst(limit_char($user->getUserName(), 15)); ?></div>
								   <a href="user_profile.php?id=<?php echo user_id();?>">
          <i class="fa fa-circle user-status-dot"></i> 
          <?php echo limit_char($user->getRole(), 14); ?> 
        </a>
                               </div>

                           </a>
<ul class="dropdown-user-menu">
                              
                               <?php if ((user_group_id() == 1 || has_permission('access', 'change_password')) && !DEMO) : ?>
            
                               <li><a href="password.php"> <i class="fas fa-rocket"></i> <?php echo trans('menu_password'); ?> </a> </li>
							   <?php endif; ?>
                               <?php if (user_group_id() == 1 || has_permission('access', 'read_user_preference')) : ?>
                               <li><a href="user_preference.php?store_id=<?php echo store_id(); ?>"> <i class="fas fa-user-edit"></i> <?php echo trans('text_user_preference'); ?></a></li>
							   <?php endif; ?>
							    <?php if (user_group_id() == 1 || has_permission('access', 'read_store')) : ?>
             
                               <li><a href="store_single.php"> <i class="fas fa-user-cog"></i> Admi Area</a></li>
                                <?php endif; ?>
                              
                               <li><a href="logout.php"> <i class="fas fa-sign-out-alt"></i>Log Out</a>
                               </li>
                           </ul>
                          
                       </div>


                   </div>

               </div> <!-- / heaader-innr -->
           </header>

       </div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/60e48e22d6e7610a49a9eb1a/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
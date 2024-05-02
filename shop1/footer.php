    <footer class="footer-area border-top-1 pt-45">
        <div class="footer-top section-padding-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="footer-widget footer-about mb-30">
                            <img alt="" src="assets/img/logo/logo.png">
                            <p><?php echo shop('short_description');?> <a href="about.php"><u><?php echo trans('button_read_more');?></u></a></p>
                            <div class="footer-social">
                                <a href="<?php echo get_preference('twitter');?>"><i class="fa fa-twitter"></i></a>
                                <a href="<?php echo get_preference('facebook');?>"><i class="fa fa-facebook"></i></a>
                                <a href="<?php echo get_preference('youtube');?>"><i class="fa fa-youtube"></i></a>
                                <a href="<?php echo get_preference('linkedin');?>"><i class="fa fa-linkedin"></i></a>
                                <a href="<?php echo get_preference('instagram');?>"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="footer-custom-col">
                        <div class="footer-widget mb-30">
                            <div class="footer-title">
                                <h3><?php echo trans('text_useful_links');?></h3>
                            </div>
                            <div class="footer-list">
                                <ul>
                                    <li><a href="about.php"><?php echo trans('menu_about_us');?></a></li>
                                    <li><a href="contact.php"><?php echo trans('menu_contact_us');?></a></li>
                                    <li><a href="faq.php"><?php echo trans('menu_FAQ');?></a></li>
                                    <li><a href="return_refund.php"><?php echo trans('menu_returns_and_refunds');?></a></li>
                                    <li><a href="term_condition.php"><?php echo trans('menu_terms_and_conditioons');?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="footer-custom-col">
                        <div class="footer-widget mb-30">
                            <div class="footer-title">
                                <h3><?php echo trans('text_profile');?></h3>
                            </div>
                            <div class="footer-list">
                                <ul>
                                    <li><a href="account.php"><?php echo trans('menu_my_account');?></a></li>
                                    <li><a href="cart.php"><?php echo trans('menu_shopping_card');?></a></li>
                                    <li><a href="support.php"><?php echo trans('menu_help_and_support');?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-8">
                        <div class="footer-widget footer-about mb-30">
                            <div class="footer-title">
                                <h3><?php echo trans('text_payment_methods');?></h3>
                            </div>
                            <div class="subscribe-style">
                                <p><?php echo trans('text_our accepted payment methods');?></p>
                                <br>
                                <div class="payment-methods">
                                    <img style="max-width:100%;" src="assets/img/payment_methods.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom section-padding-1 pb-15 pt-40">
            <div class="container">
                <div class="copyright">
                    <p>© <?php echo date('Y');?> <a href="http://ONZWO.COM">ONZWO.COM</a>. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>
</div>


<!-- All JS is here
============================================ -->
<!-- Ajax Mail -->
<script src="assets/js/ajax-mail.js"></script>
<!-- Main JS -->
<script src="assets/js/main.js"></script>

<script src="assets/angular/controllers/PosController.js" type="text/javascript"></script>

</body>
</html>
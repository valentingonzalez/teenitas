	<?php /* Template Name: Landing Page */
    get_header('demo');
     ?>
     <div class="header-demo">
     <header class="tb-header-menu tb-header-menu-md">
			<div class="midle-header">
				<nav class="navbar navbar-inverse">
					<div class="container">
                    <div class="nav_pd">
						<div class="navbar-header-content">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a id="to-top" href="javascript:void(0)"><img src="../wp-content/themes/blance/assets/images/logolading.png" alt="logo" class="logo"></a>
							</div>
							<div class="collapse navbar-collapse" id="myNavbar">
								<ul class="nav navbar-nav navbar-right main-menu">
									<li><a href="#demos" >Demo</a></li>
									<li><a  href="#documentation">Documentation</a></li>
									<li><a href="#support">Support</a></li>
                                    <li class="hidden-lg hidden-md hidden-sm"><a target="_blank" href="https://themeforest.net/item/blance-clean-minimal-woocommerce-wordpress-theme/20846862?s_rank=1">Purchase Now</a></li>
								</ul>
							</div>
						</div>
                        <a target="_blank" class="buy hidden-xs" href="https://themeforest.net/item/blance-clean-minimal-woocommerce-wordpress-theme/20846862?s_rank=1"><i class="fa fa-shopping-cart"></i>Purchase Now</a>
                        </div>
					</div>
				</nav>
			</div>
		</header>
        </div>
        <div class="content_vc">
        <?php while ( have_posts() ) : the_post(); ?>
              <?php  the_content(); ?>
        	<?php endwhile; // end of the loop. ?>
        </div>
        <div class="content_ct">
            
            <div class="row_ct">
            <div class="container">
                <div class="icon">
                    <img src="../wp-content/themes/blance/assets/images/demo/demo1.png" alt="icon" class="icon" />
                    <img src="../wp-content/themes/blance/assets/images/demo/demo2.png" alt="icon" class="icon" />
                    <img src="../wp-content/themes/blance/assets/images/demo/demo3.png" alt="icon" class="icon" />
                    <img src="../wp-content/themes/blance/assets/images/demo/demo4.png" alt="icon" class="icon" />
                    <img src="../wp-content/themes/blance/assets/images/demo/demo5.png" alt="icon" class="icon" />
                    <img src="../wp-content/themes/blance/assets/images/demo/demo6.png" alt="icon" class="icon" />
                </div>
                </div>
            </div>
            <div id="demos" class="row_ct">
                <div class="home_demo row">
                <div class="container">
                    <h5 class="title_demo"><span>06 Unique</span>HomePages Design</h5>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                    <div class="demo">
                        <div class="img_inner">
                             <img src="../wp-content/themes/blance/assets/images/demo/h1.jpg" alt="icon" />
                             <div class="inner">
                                <a target="_blank" class="in" href="/home"><i class="fa fa-search"></i>view demo</a>
                             </div>
                        </div>
                        <div class="content">
                            <a target="_blank" href="/home">home layout 01</a>
                        </div>
                    </div>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                    <div class="demo">
                        <div class="img_inner">
                             <img src="../wp-content/themes/blance/assets/images/demo/h2.jpg" alt="icon"  />
                             <div class="inner">
                                <a target="_blank" class="in" href="/home-2"><i class="fa fa-search"></i>view demo</a>
                             </div>
                        </div>
                        <div class="content">
                            <a target="_blank" href="/home-2/">home layout 02</a>
                        </div>
                    </div>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                    <div class="demo">
                        <div class="img_inner">
                             <img src="../wp-content/themes/blance/assets/images/demo/h3.jpg" alt="icon"  />
                             <div class="inner">
                                <a target="_blank" class="in" href="h/home-3/"><i class="fa fa-search"></i>view demo</a>
                             </div>
                        </div>
                        <div class="content">
                            <a target="_blank" href="/home-3/">home layout 03</a>
                        </div>
                    </div>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                    <div class="demo">
                        <div class="img_inner">
                             <img src="../wp-content/themes/blance/assets/images/demo/h4.jpg" alt="icon"  />
                             <div class="inner">
                                <a target="_blank" class="in" href="/home-4"><i class="fa fa-search"></i>view demo</a>
                             </div>
                        </div>
                        <div class="content">
                            <a target="_blank" href="/home-4">home layout 04</a>
                        </div>
                    </div>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                    <div class="demo">
                        <div class="img_inner">
                             <img src="../wp-content/themes/blance/assets/images/demo/h5.jpg" alt="icon"  />
                             <div class="inner">
                                <a target="_blank" class="in" href="/home-5"><i class="fa fa-search"></i>view demo</a>
                             </div>
                        </div>
                        <div class="content">
                            <a target="_blank" href="/home-5">home layout 05</a>
                        </div>
                    </div>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                    <div class="demo">
                        <div class="img_inner">
                             <img src="../wp-content/themes/blance/assets/images/demo/h6.jpg" alt="icon" />
                             <div class="inner">
                                <a target="_blank" class="in" href="/home-instagram/"><i class="fa fa-search"></i>view demo</a>
                             </div>
                        </div>
                        <div class="content">
                            <a target="_blank" href="/home-instagram/">home instagram</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
         </div> 
         <div class="row_ct">
                <div class="header_demo row">
                <div class="container">
                    <h5 class="title_demo"><span>04 Customizable</span>Header Styles</h5>
                        <div class="img_header">
                        <a target="_blank" href="http://blance.jwsuperthemes.com/home">
                             <img src="../wp-content/themes/blance/assets/images/demo/header-1.png" alt="icon" />
                        </a>     
                        </div>
                        
                         <div class="img_header">
                         <a target="_blank" href="http://blance.jwsuperthemes.com/home-3/">
                             <img src="../wp-content/themes/blance/assets/images/demo/header-2.png" alt="icon" />
                             </a>
                        </div>
                         <div class="img_header">
                         <a target="_blank" href="http://blance.jwsuperthemes.com/home-4">
                             <img src="../wp-content/themes/blance/assets/images/demo/header-3.png" alt="icon" />
                             </a>
                        </div>
                         <div class="img_header">
                         <a target="_blank" href="http://blance.jwsuperthemes.com/home-5">
                             <img src="../wp-content/themes/blance/assets/images/demo/header-4.png" alt="icon" />
                             </a>
                        </div>
                </div>
            </div>
         </div>  
             <div id="documentation" class="row_ct">
                <div class="video_demo row">
                <div class="container">
                    <img class="seo-img" src="../wp-content/themes/blance/assets/images/demo/seo.png" alt="title" />
                    <h5 class="title_demo"><span>One-Click</span>Demo Content</h5>
                    <p class="text-center">Easiest and fastest way to build your website, one click import pages, post, blog, products, revolution slider, widgets, theme options and more! </p>
                    <div class="video-poup">
                        <img src="../wp-content/themes/blance/assets/images/demo/bg-video.jpg" alt="bg" />
                        <div class="btn_inner">
                            <a class="action-pp" href="https://www.youtube.com/watch?v=zH5cXcHtZ-4"><img src="../wp-content/themes/blance/assets/images/demo/bt-video.png" alt="btn" /></a>
                        </div>
                    </div>
                </div>
            </div>
         </div> 
        </div>
        <footer id="support">

            <div class="ft-top row">
                <div class="container">
                <h5 class="title_demo"><span>CREATE YOUR OWN WEBSITE TODAY !</span></h5>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 nt-ft">
                    <a href="#demos" class="ft-bt">VIEW ALL DEMO</a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 nt-ft">
                    <a href="https://themeforest.net/item/blance-clean-minimal-woocommerce-wordpress-theme/20846862?ref=jwsthemes" target="_blank" class="ft-bt"> PURCHASE NOW</a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 nt-ft">
                    <a href="http://docs.jwsuperthemes.com/blance/" class="ft-bt" target="_blank">DOCUMENTATION</a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 nt-ft">
                    <a href="https://jwsuperthemes.com/forums/" target="_blank" class="ft-bt">SUPPORT</a>
                </div>
                </div>
            </div>
            <div class="footer-bottom">
                <h6 class="text-center copy">Copyright @ 2018. All Right Reserved</h6>
                <div class="social">
                    <a target="_blank" class="icon-ft" href="https://www.facebook.com/jwsthemes"><i class="fa fa-facebook"></i></a>
                    <a target="_blank" class="icon-ft" href="https://www.youtube.com/channel/UCC6BVgdqs5XqxFVtf6biB0A"><i class="fa fa-youtube-play"></i></a>
                    <a target="_blank" class="icon-ft" href="https://twitter.com/jwsthemes"><i class="fa fa-twitter"></i></a>
                </div>
            </div>
        </footer>
     <?php
    get_footer('demo');
     ?>
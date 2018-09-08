<?php 
	$jwstheme_options = $GLOBALS['jwstheme_options'];
	$preset_color = (isset($jwstheme_options['preset_color'])&&$jwstheme_options['preset_color'])?$jwstheme_options['preset_color']: 'default';
	
?>
<div id="panel-style-selector">
	<div class="panel-wrapper">
		<div class="panel-selector-open"><i class="fa fa-cogs"></i></div>
		<h2 class="panel-selector-header">Style Selector</h2>
		<div class="panel-selector-body clearfix">
			<section class="panel-selector-section clearfix">
				<h3 class="panel-selector-title">Main Color</h3>
				<div class="panel-selector-row clearfix">
					<ul class="panel-primary-color">
						<li class="<?php if($preset_color == 'default') echo 'default active'; ?>" data-link="<?php echo esc_url(URI_PATH.'/assets/css/presets/default.css'); ?>">
							<div class="preset-item">
								<span style="background: #ec1c33;"></span>
								<span style="background: #29af8a;"></span>
							</div>
						</li>
						<li class="<?php if($preset_color == 'preset1') echo 'default active'; ?>" data-link="<?php echo esc_url(URI_PATH.'/assets/css/presets/preset1.css'); ?>">
							<div class="preset-item">
								<span style="background: #ff8c00;"></span>
								<span style="background: #556b2f;"></span>
							</div>
						</li>
						<li class="<?php if($preset_color == 'preset2') echo 'default active'; ?>" data-link="<?php echo esc_url(URI_PATH.'/assets/css/presets/preset2.css'); ?>">
							<div class="preset-item">
								<span style="background: #8b4513;"></span>
								<span style="background: #b8860b;"></span>
							</div>
						</li>
						<li class="<?php if($preset_color == 'preset3') echo 'default active'; ?>" data-link="<?php echo esc_url(URI_PATH.'/assets/css/presets/preset3.css'); ?>">
							<div class="preset-item">
								<span style="background: #dc143c;"></span>
								<span style="background: #f24a37;"></span>
							</div>
						</li>
						<li class="<?php if($preset_color == 'preset4') echo 'default active'; ?>" data-link="<?php echo esc_url(URI_PATH.'/assets/css/presets/preset4.css'); ?>">
							<div class="preset-item">
								<span style="background: #b77a10;"></span>
								<span style="background: #3a98af;"></span>
							</div>
						</li>
						<li class="<?php if($preset_color == 'preset5') echo 'default active'; ?>" data-link="<?php echo esc_url(URI_PATH.'/assets/css/presets/preset5.css'); ?>">
							<div class="preset-item">
								<span style="background: #01b289;"></span>
								<span style="background: #c4be52;"></span>
							</div>
						</li>
					</ul>
				</div>
			</section>

			<section class="panel-selector-section clearfix">
				<h3 class="panel-selector-title">Body Layout</h3>

				<div class="panel-selector-row clearfix">
					<a data-type="layout" data-value="wide" href="#" class="panel-selector-btn active">Wide</a>
					<a data-type="layout" data-value="boxed" href="#" class="panel-selector-btn">Boxed</a>
				</div>
			</section>
			<section class="panel-selector-section clearfix">
				<h3 class="panel-selector-title">Body Background</h3>

				<div class="panel-selector-row clearfix">
					<ul class="panel-primary-background">
						<li class="pattern-0" data-link="<?php echo esc_url(URI_PATH.'/assets/images/patterns/tree_bark.png'); ?>" data-type="pattern" style="<?php echo 'background: url('.esc_url(URI_PATH.'/assets/images/patterns/tree_bark.png').')'; ?>"></li>
						<li class="pattern-2" data-link="<?php echo esc_url(URI_PATH.'/assets/images/patterns/triangular.png'); ?>" data-type="pattern" style="<?php echo 'background: url('.esc_url(URI_PATH.'/assets/images/patterns/triangular.png').')'; ?>"></li>
						<li class="pattern-1" data-link="<?php echo esc_url(URI_PATH.'/assets/images/patterns/pattern-1.png'); ?>" data-type="pattern" style="<?php echo 'background: url('.esc_url(URI_PATH.'/assets/images/patterns/pattern-1.png').')'; ?>"></li>
						<li class="pattern-3" data-link="<?php echo esc_url(URI_PATH.'/assets/images/patterns/pattern-2.png'); ?>" data-type="pattern" style="<?php echo 'background: url('.esc_url(URI_PATH.'/assets/images/patterns/triangular_@2X.png').')'; ?>"></li>
						<li class="pattern-4" data-link="<?php echo esc_url(URI_PATH.'/assets/images/patterns/wild_flowers.png'); ?>" data-type="pattern" style="<?php echo 'background: url('.esc_url(URI_PATH.'/assets/images/patterns/pattern-2.png').')'; ?>"></li>
						<li class="pattern-5" data-link="<?php echo esc_url(URI_PATH.'/assets/images/patterns/triangular_@2X.png'); ?>" data-type="pattern" style="<?php echo 'background: url('.esc_url(URI_PATH.'/assets/images/patterns/triangular_@2X.png').')'; ?>"></li>
					</ul>
				</div>
			</section>
			<section class="panel-selector-section clearfix">
				<div class="panel-selector-row text-center">
					<a id="panel-selector-reset" href="#" class="panel-selector-btn">Reset</a>
				</div>
			</section>
		</div>
	</div>
</div>
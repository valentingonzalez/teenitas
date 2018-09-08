<?php
function jwstheme_autoCompileLess($inputFile, $outputFile) {
    require_once( ABSPATH.'/wp-admin/includes/file.php' );	
	WP_Filesystem();
	require_once ( ABS_PATH_FR . '/inc/lessc.inc.php' );
	global $wp_filesystem, $jwstheme_options;
    $less = new lessc();
    $less->setFormatter("classic");
    $less->setPreserveComments(true);
	/*Styling Options*/
	
	$preset_color = (isset($jwstheme_options['preset_color'])&&$jwstheme_options['preset_color'])?$jwstheme_options['preset_color']: 'default';
	$main_color = (isset($jwstheme_options['main_color'])&&$jwstheme_options['main_color'])?$jwstheme_options['main_color']: '#fcbaf8';
	$secondary_color = (isset($jwstheme_options['secondary_color'])&&$jwstheme_options['secondary_color'])?$jwstheme_options['secondary_color']: '#aaaaff';
	$three_color = (isset($jwstheme_options['three_color'])&&$jwstheme_options['three_color'])?$jwstheme_options['three_color']: '#7ac284';
	switch ($preset_color) {
		case 'preset1':
			$main_color = (isset($jwstheme_options['main_color_preset1'])&&$jwstheme_options['main_color_preset1'])?$jwstheme_options['main_color_preset1']: '#e5ae49';
			$secondary_color = (isset($jwstheme_options['secondary_color_preset1'])&&$jwstheme_options['secondary_color_preset1'])?$jwstheme_options['secondary_color_preset1']: '#73b79d';
            $three_color = (isset($jwstheme_options['three_color_preset1'])&&$jwstheme_options['three_color_preset1'])?$jwstheme_options['three_color_preset1']: '#73b79d';
			break;
		case 'preset2':
			$main_color = (isset($jwstheme_options['main_color_preset2'])&&$jwstheme_options['main_color_preset2'])?$jwstheme_options['main_color_preset2']: '#e5ae49';
			$secondary_color = (isset($jwstheme_options['secondary_color_preset2'])&&$jwstheme_options['secondary_color_preset2'])?$jwstheme_options['secondary_color_preset2']: '#73b79d';
            $three_color = (isset($jwstheme_options['three_color_preset2'])&&$jwstheme_options['three_color_preset2'])?$jwstheme_options['three_color_preset2']: '#73b79d';
            break;
		case 'preset3':
			$main_color = (isset($jwstheme_options['main_color_preset3'])&&$jwstheme_options['main_color_preset3'])?$jwstheme_options['main_color_preset3']: '#e5ae49';
			$secondary_color = (isset($jwstheme_options['secondary_color_preset3'])&&$jwstheme_options['secondary_color_preset3'])?$jwstheme_options['secondary_color_preset3']: '#73b79d';
			$three_color = (isset($jwstheme_options['three_color_preset3'])&&$jwstheme_options['three_color_preset3'])?$jwstheme_options['three_color_preset3']: '#73b79d';
            break;
		case 'preset4':
			$main_color = (isset($jwstheme_options['main_color_preset4'])&&$jwstheme_options['main_color_preset4'])?$jwstheme_options['main_color_preset4']: '#e5ae49';
			$secondary_color = (isset($jwstheme_options['secondary_color_preset4'])&&$jwstheme_options['secondary_color_preset4'])?$jwstheme_options['secondary_color_preset4']: '#73b79d';
			$three_color = (isset($jwstheme_options['three_color_preset4'])&&$jwstheme_options['three_color_preset4'])?$jwstheme_options['three_color_preset4']: '#73b79d';
            break;
		case 'preset5':
			$main_color = (isset($jwstheme_options['main_color_preset5'])&&$jwstheme_options['main_color_preset5'])?$jwstheme_options['main_color_preset5']: '#e5ae49';
			$secondary_color = (isset($jwstheme_options['secondary_color_preset5'])&&$jwstheme_options['secondary_color_preset5'])?$jwstheme_options['secondary_color_preset5']: '#73b79d';
			$three_color = (isset($jwstheme_options['three_color_preset5'])&&$jwstheme_options['three_color_preset5'])?$jwstheme_options['three_color_preset5']: '#73b79d';
            break;
		default:
			$main_color = (isset($jwstheme_options['main_color'])&&$jwstheme_options['main_color'])?$jwstheme_options['main_color']: '#fcbaf8';
			$secondary_color = (isset($jwstheme_options['secondary_color'])&&$jwstheme_options['secondary_color'])?$jwstheme_options['secondary_color']: '#29af8a';
            $three_color = (isset($jwstheme_options['three_color'])&&$jwstheme_options['three_color'])?$jwstheme_options['three_color']: '#7ac284';
        } 
	
    $variables = array(
		"main_color" => $main_color,
		"secondary_color" => $secondary_color,
        "three_color" => $three_color,
		
    );
    $less->setVariables($variables);
    $cacheFile = $inputFile.".cache";
    if (file_exists($cacheFile)) {
            $cache = unserialize($wp_filesystem->get_contents($cacheFile));
    } else {
            $cache = $inputFile;
    }
    $newCache = $less->cachedCompile($inputFile);
    if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
            $wp_filesystem->put_contents($cacheFile, serialize($newCache));
            $wp_filesystem->put_contents($outputFile, $newCache['compiled']);
    }
}
function jwstheme_addLessStyle() {
	global $jwstheme_options;
	$preset_color = (isset($jwstheme_options['preset_color'])&&$jwstheme_options['preset_color'])?$jwstheme_options['preset_color']: 'default';
	
	try {
		$inputFile = ABS_PATH.'/assets/css/less/style.less';
		$outputFile = ABS_PATH.'/assets/css/presets/'.$preset_color.'.css';
		jwstheme_autoCompileLess($inputFile, $outputFile);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
add_action('wp_enqueue_scripts', 'jwstheme_addLessStyle');
/* End less*/

<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_icons = array(
	'tg-icon-facebook',
	'tg-icon-vimeo',
	'tg-icon-twitter',
	'tg-icon-google-plus',
	'tg-icon-pinterest',
	'tg-icon-instagram',
	'tg-icon-vine',
	'tg-icon-tumblr',
	'tg-icon-linkedin',
	'tg-icon-flickr',
	'tg-icon-behance',
	'tg-icon-reddit',
	'tg-icon-github',
	'tg-icon-stack-overflow',
	'tg-icon-dropbox',
	'tg-icon-digg',
	'tg-icon-soundcloud',
	'tg-icon-skype',
	'tg-icon-thumbs-up',
	'tg-icon-comment',
	'tg-icon-comment-2',
	'tg-icon-comment-3',
	'tg-icon-comment-4',
	'tg-icon-chat',
	'tg-icon-chat-2',
	'tg-icon-zoom',
	'tg-icon-zoom-2',
	'tg-icon-zoom-3',
	'tg-icon-zoom-4',
	'tg-icon-zoom-5',
	'tg-icon-zoom-6',
	'tg-icon-shop-bag',
	'tg-icon-shop-bag-2',
	'tg-icon-shop-bag-3',
	'tg-icon-shop-bag-4',
	'tg-icon-shop-bag-5',
	'tg-icon-shop-cart',
	'tg-icon-shop-cart-2',
	'tg-icon-shop-cart-add',
	'tg-icon-credit-card',
	'tg-icon-tag',
	'tg-icon-tag-2',
	'tg-icon-bookmark',
	'tg-icon-map-marker',
	'tg-icon-download',
	'tg-icon-refresh',
	'tg-icon-circle',
	'tg-icon-circle-o',
	'tg-icon-font',
	'tg-icon-bold',
	'tg-icon-italic',
	'tg-icon-text-height',
	'tg-icon-text-width',
	'tg-icon-align-left',
	'tg-icon-align-center',
	'tg-icon-align-right',
	'tg-icon-align-justify',
	'tg-icon-list',
	'tg-icon-dedent',
	'tg-icon-indent',
	'tg-icon-calendar',
	'tg-icon-random',
	'tg-icon-phone',
	'tg-icon-floppy',
	'tg-icon-user',
	'tg-icon-paw',
	'tg-icon-envelope',
	'tg-icon-rotate-left',
	'tg-icon-legal',
	'tg-icon-rocket',
	'tg-icon-connect-develop',
	'tg-icon-diamond',
	'tg-icon-tools',
	'tg-icon-umbrella',
	'tg-icon-gamepad',
	'tg-icon-lightbulb',
	'tg-icon-ambulance',
	'tg-icon-fighter-jet',
	'tg-icon-smile',
	'tg-icon-frown',
	'tg-icon-keyboard',
	'tg-icon-desktop',
	'tg-icon-laptop',
	'tg-icon-tablet',
	'tg-icon-mobile',
	'tg-icon-quote-left',
	'tg-icon-quote-right',
	'tg-icon-quote',
	'tg-icon-ellipsis-v',
	'tg-icon-settings',
	'tg-icon-eye',
	'tg-icon-music',
	'tg-icon-video',
	'tg-icon-youtube-play',
	'tg-icon-play',
	'tg-icon-play-2',
	'tg-icon-play-3',
	'tg-icon-play-4',
	'tg-icon-pause',
	'tg-icon-pause-3',
	'tg-icon-pause-4',
	'tg-icon-angle-double-left',
	'tg-icon-angle-double-right',
	'tg-icon-arrow-prev',
	'tg-icon-arrow-next',
	'tg-icon-arrow-down',
	'tg-icon-arrow-up',
	'tg-icon-angle-double-up',
	'tg-icon-angle-double-down',
	'tg-icon-arrow-prev-thin',
	'tg-icon-arrow-next-thin',
	'tg-icon-arrow-up-thin',
	'tg-icon-arrow-down-thin',
	'tg-icon-close',
	'tg-icon-cancel',
	'tg-icon-add',
	'tg-icon-add-2',
	'tg-icon-add-3',
	'tg-icon-check',
	'tg-icon-arrows-out',
	'tg-icon-arrows-diagonal',
	'tg-icon-link',
	'tg-icon-chain-broken',
	'tg-icon-paperclip',
	'tg-icon-chain',
	'tg-icon-mail-forward',
	'tg-icon-reply',
	'tg-icon-share',
	'tg-icon-star',
	'tg-icon-star-half',
	'tg-icon-star-o',
	'tg-icon-heart',
	'tg-icon-heart-o',
	'tg-icon-like',
	'tg-icon-dislike'
);

return $tg_icons;

/*$icons = '';
$pattern = '/\.(tg-icon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
//$subject = file_get_contents(TG_PLUGIN_URL . 'frontend/assets/css/font-awesome.min.css');
preg_match_all($pattern, $icons, $matches, PREG_SET_ORDER);
$icons = array();
foreach($matches as $match){
	echo "'".$match[1]."',"."<br>";
}*/
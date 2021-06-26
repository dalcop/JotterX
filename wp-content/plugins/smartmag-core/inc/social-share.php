<?php
/**
 * Social sharing buttons
 */
class SmartMag_SocialShare
{
	/**
	 * Get an array of sharing services with links
	 */
	public function share_services($post_id = '') 
	{
		if (empty($post_id)) {
			$post_id = get_the_ID();
		}
		
		// Post and media URL
		$url   = rawurlencode(get_permalink($post_id));
		$media = rawurlencode(
			wp_get_attachment_url(get_post_thumbnail_id($post_id))
		);

		$the_title = get_post_field('post_title', $post_id, 'raw');
		$title     = rawurlencode($the_title);
		
		// Social Services
		$services = [
			'facebook' => [
				'label'      => esc_html__('Facebook', 'bunyad'),
				'label_full' => esc_html__('Share on Twitter', 'bunyad'), 
				'icon'       => 'tsi tsi-facebook',
				'url'        => 'https://www.facebook.com/sharer.php?u=' . $url,
			],
				
			'twitter' => [
				'label'      => esc_html__('Twitter', 'bunyad'), 
				'label_full' => esc_html__('Share on Twitter', 'bunyad'), 
				'icon'       => 'tsi tsi-twitter',
				'url'        => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title,
			],

			'pinterest' => [
				'label'      => esc_html__('Pinterest', 'bunyad'), 
				'label_full' => esc_html__('Share on Pinterest', 'bunyad'), 
				'icon'       => 'tsi tsi-pinterest',
				'url'        => 'https://pinterest.com/pin/create/button/?url='. $url . '&media=' . $media . '&description=' . $title,
				'key'        => 'sf_instagram_id',
			],
			
			'linkedin' => [
				'label'      => esc_html__('LinkedIn', 'bunyad'), 
				'label_full' => esc_html__('Share on LinkedIn', 'bunyad'), 
				'icon'       => 'tsi tsi-linkedin',
				'url'        => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url,
			],
				
			'tumblr' => [
				'label'      => esc_html__('Tumblr', 'bunyad'), 
				'label_full' => esc_html__('Share on Tumblr', 'bunyad'), 
				'icon'       => 'tsi tsi-tumblr',
				'url'        => 'https://www.tumblr.com/share/link?url=' . $url . '&name=' . $title,
			],

			'vk'     => [
				'label'      => esc_html__('VKontakte', 'bunyad'),
				'label_full' => esc_html__('Share on VKontakte', 'bunyad'), 
				'icon'       => 'tsi tsi-vk',
				'url'        => 'https://vk.com/share.php?url='. $url .'&title=' . $title,
			],
				
			'email'  => [
				'label'      => esc_html__('Email', 'bunyad'),
				'label_full' => esc_html__('Share via Email', 'bunyad'), 
				'icon'       => 'tsi tsi-envelope-o',
				'url'        => 'mailto:?subject='. $title .'&body=' . $url,
			],

			'whatsapp' => [
				'label'      => esc_html__('WhatsApp', 'bunyad'),
				'label_full' => esc_html__('Share on WhatsApp', 'bunyad'), 
				'icon'       => 'tsi tsi-whatsapp',

				// rawurlencode to preserve space properly
				'url'   => 'https://wa.me/?text='. $title . rawurlencode(' ') . $url,
			],

			'reddit' => [
				'label'      => esc_html__('Reddit', 'bunyad'),
				'label_full' => esc_html__('Share on Reddit', 'bunyad'), 
				'icon'       => 'tsi tsi-reddit-alien',
				'url'        => 'https://www.reddit.com/submit?url=' . $url . '&title='. $title,
			],

			'telegram' => [
				'label'      => esc_html__('Telegram', 'bunyad'),
				'label_full' => esc_html__('Share on Telegram', 'bunyad'), 
				'icon'       => 'tsi tsi-telegram',
				'url'        => 'https://t.me/share/url?url=' . $url . '&title='. $title,
			]
		];
		
		return apply_filters('bunyad_social_share_services', $services);
	}

	/**
	 * Render social sharing.
	 */
	public function render($type = '', $props = [])
	{
		include SmartMag_Core::instance()->path . 'social-share/views/' . sanitize_file_name($type) . '.php';
	}
}

// init and make available in Bunyad::get('smartmag_social')
Bunyad::register('smartmag_social', array(
	'class' => 'SmartMag_SocialShare',
	'init' => true
));
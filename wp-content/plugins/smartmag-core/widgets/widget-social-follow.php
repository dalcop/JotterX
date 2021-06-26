<?php
/**
 * Register Social Follow widget.
 */
class SmartMag_Widgets_SocialFollow extends WP_Widget 
{
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'bunyad-social',
			esc_html__('SmartMag - Social Follow & Counters', 'bunyad-admin'),
			['description' => esc_html__('Show social follower buttons.', 'bunyad-admin'), 'classname' => 'widget-social-b']
		);
		
	}

	/**
	 * Register the widget if the plugin is active
	 */
	public function register_widget() {
		
		if (!class_exists('\Sphere\Core\SocialFollow\Module')) {
			return;
		}
		
		register_widget(__CLASS__);
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) 
	{
		$title = apply_filters('widget_title', esc_html($instance['title']));

		echo $args['before_widget'];

		if (!empty($title)) {	
			echo $args['before_title'] . wp_kses_post($title) . $args['after_title']; // before_title/after_title are built-in WordPress sanitized
		}

		$services = $this->services();
		$active   = !empty($instance['social']) ? $instance['social'] : [];
		$style    = !empty($instance['style']) ? $instance['style'] : 'a';
		$columns  = 1;

		// Style set to type a-2 and so on.
		if (preg_match('/([a-z]+)\-(\d+)/', $style, $match)) {
			$columns = intval($match[2]);
			$style   = $match[1];
		}

		$classes =  [
			'spc-social-follow',
			'spc-social-follow-' . $style,

			// Background color for style a and b.
			in_array($style, ['a', 'b']) ? 'spc-social-bg' : 'spc-social-c-icon'
		];

		$grid_classes = [
			'grid-' . $columns,
			'md:grid-4',
			'sm:grid-2',
		];

		$show_counters = empty($instance['counters']) 
			? Bunyad::options()->sf_counters 
			: bool_from_yn($instance['counters']);

		?>
		<div class="<?php echo esc_attr(join(' ', $classes)); ?>">
			<ul class="services grid <?php echo esc_attr(join(' ', $grid_classes)); ?>" itemscope itemtype="http://schema.org/Organization">
				<link itemprop="url" href="<?php echo esc_url(home_url('/')); ?>">
				<?php 
				foreach ($active as $key):

					if (!isset($services[$key])) {
						continue;
					}
									
					$service = $services[$key];
					$count   = 0;
					
					if ($show_counters) { 
						$count = Bunyad::get('social-follow')->count($key);
					}

					$s_classes = [
						'service-link s-' . $key,
						($count > 0 ? 'has-count' : '')
					];
				?>
				
				<li class="service">

					<a href="<?php echo esc_url($service['url']); ?>" class="<?php echo esc_attr(join(' ', $s_classes)); ?>" target="_blank" itemprop="sameAs" rel="noopener">
						<i class="the-icon tsi tsi-<?php echo esc_attr($service['icon']); ?>"></i>
						<span class="label"><?php echo esc_html($service['text']); ?></span>

						<?php if ($count > 0): ?>
							<span class="count"><?php echo esc_html($this->readable_number($count)); ?></span>
						<?php endif; ?>	
					</a>

				</li>
				
				<?php 
				endforeach; 
				?>
			</ul>
		</div>
		
		<?php

		echo $args['after_widget'];
	}
	
	/**
	 * Supported services
	 */
	public function services()
	{
		/**
		 * Setup an array of services and their associate URL, label and icon
		 */
		$services = [
			'facebook' => [
				'label' => esc_html__('Facebook', 'bunyad'),
				'text'  => Bunyad::options()->sf_facebook_label,
				'icon'  => 'facebook',
				'url'   => 'https://facebook.com/%',
				'key'   => 'sf_facebook_id',
			],
				
			'twitter' => [
				'label' => esc_html__('Twitter', 'bunyad'), 
				'text'  => Bunyad::options()->sf_twitter_label,
				'icon'  => 'twitter',
				'url'   => 'https://twitter.com/%',
				'key'   => 'sf_twitter_id',
			],
				
			'pinterest' => [
				'label' => esc_html__('Pinterest', 'bunyad'), 
				'text'  => Bunyad::options()->sf_pinterest_label,
				'icon'  => 'pinterest-p',
				'url'   => 'https://pinterest.com/%',
				'key'   => 'sf_pinterest_id',
			],
				
			'instagram' => [
				'label' => esc_html__('Instagram', 'bunyad'), 
				'text'  => Bunyad::options()->sf_instagram_label,
				'icon'  => 'instagram',
				'url'   => 'https://instagram.com/%',
				'key'   => 'sf_instagram_id',
			],
			
			'youtube' => [
				'label' => esc_html__('YouTube', 'bunyad'), 
				'text'  => Bunyad::options()->sf_youtube_label,
				'icon'  => 'youtube-play',
				'url'   => '%',
				'key'   => 'sf_youtube_url',
			],
				
			'vimeo' => [
				'label' => esc_html__('Vimeo', 'bunyad'), 
				'text'  => Bunyad::options()->sf_vimeo_label,
				'icon'  => 'vimeo',
				'url'   => '%',
				'key'   => 'sf_vimeo_url',
			],

			'linkedin' => [
				'label' => esc_html__('LinkedIn', 'bunyad'), 
				'text'  => Bunyad::options()->sf_linkedin_label,
				'icon'  => 'linkedin',
				'url'   => '%',
				'key'   => 'sf_linkedin_url',
			],

			'soundcloud' => [
				'label' => esc_html__('Soundcloud', 'bunyad'), 
				'text'  => Bunyad::options()->sf_soundcloud_label,
				'icon'  => 'soundcloud',
				'url'   => 'https://soundcloud.com/%',
				'key'   => 'sf_soundcloud_id',
			],

			'twitch' => [
				'label' => esc_html__('Twitch', 'bunyad'), 
				'text'  => Bunyad::options()->sf_twitch_label,
				'icon'  => 'twitch',
				'url'   => 'https://twitch.tv/%',
				'key'   => 'sf_twitch_id',
			],

			'reddit' => [
				'label' => esc_html__('Reddit', 'bunyad'), 
				'text'  => Bunyad::options()->sf_reddit_label,
				'icon'  => 'reddit-alien',
				'url'   => '%',
				'key'   => 'sf_reddit_url',
			],

			'tiktok' => [
				'label' => esc_html__('TikTok', 'bunyad'), 
				'text'  => Bunyad::options()->sf_tiktok_label,
				'icon'  => 'tiktok',
				'url'   => 'https://www.tiktok.com/@%',
				'key'   => 'sf_tiktok_id',
			],

			'telegram' => [
				'label' => esc_html__('Telegram', 'bunyad'), 
				'text'  => Bunyad::options()->sf_telegram_label,
				'icon'  => 'telegram',
				'url'   => 'https://t.me/%',
				'key'   => 'sf_telegram_id',
			],

			'whatsapp' => [
				'label' => esc_html__('WhatsApp', 'bunyad'), 
				'text'  => Bunyad::options()->sf_whatsapp_label,
				'icon'  => 'whatsapp',
				'url'   => 'https://wa.me/%',
				'key'   => 'sf_whatsapp_id',
			],
		];
		
		$services = $this->_replace_urls($services);
		
		return $services;
	}
	
	/**
	 * Perform URL replacements
	 * 
	 * @param  array  $services
	 * @return array
	 */
	public function _replace_urls($services) 
	{
		foreach ($services as $id => $service) {
		
			if (!isset($service['key'])) {
				continue;
			}
			
			// Get the URL or username from settings.
			if ($the_url = Bunyad::options()->get($service['key'])) {
				$services[$id]['url'] = str_replace('%', $the_url, $service['url']);
			}
			else {
				// Try to fallback to social profile URLs.
				$profiles = Bunyad::options()->get('social_profiles');
				$services[$id]['url'] = !empty($profiles[$id]) ? $profiles[$id] : '';
			}

		}
			
		return $services;
	}


	/**
	 * Make count more human in format 1.4K, 1.5M etc.
	 * 
	 * @param integer $number
	 */
	public function readable_number($number)
	{
		if ($number < 1051) {
			return $number;
		}

		if ($number < 10^6) {
			return round($number / 1000, 1) . 'K';
		}
		
		return round($number / 10^6, 1) . 'M';
	}
		

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		$defaults = [
			'title'    => '', 
			'style'    => 'b-2',
			'social'   => [],
			'counters' => ''
		];

		$instance = array_replace($defaults, (array) $instance);
		
		extract($instance);
		
		// Merge current values for sorting reasons
		$services = array_replace(array_flip($social), $this->services());
		
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__('Title:', 'bunyad'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php echo esc_html__('Style:', 'bunyad'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>" class="widefat">
				<option value="b-2" <?php selected($style, 'b'); ?>><?php echo esc_html__('Modern BG - 2 Columns', 'bunyad-admin') ?></option>
				<option value="b" <?php selected($style, 'b'); ?>><?php echo esc_html__('Modern BG - 1 Column', 'bunyad-admin') ?></option>
				<option value="a" <?php selected($style, 'a'); ?>><?php echo esc_html__('Classic BG - 1 Column', 'bunyad-admin') ?></option>
				<option value="a-2" <?php selected($style, 'a-2'); ?>><?php echo esc_html__('Classic BG - 2 Columns', 'bunyad-admin') ?></option>
				<option value="c" <?php selected($style, 'c'); ?>><?php echo esc_html__('Light - 1 Columns', 'bunyad-admin') ?></option>
				<option value="c-2" <?php selected($style, 'c-2'); ?>><?php echo esc_html__('Light - 2 Columns', 'bunyad-admin') ?></option>				
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('counters')); ?>"><?php echo esc_html__('Show Counters:', 'bunyad'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('counters')); ?>" name="<?php echo esc_attr($this->get_field_name('counters')); ?>" class="widefat">
				<option value="" <?php selected($counters, ''); ?>><?php echo esc_html__('Global Inherit (From Customize > Social Follow)', 'bunyad-admin') ?></option>
				<option value="y" <?php selected($counters, 'y'); ?>><?php echo esc_html__('Yes', 'bunyad-admin') ?></option>
				<option value="n" <?php selected($counters, 'n'); ?>><?php echo esc_html__('No', 'bunyad-admin') ?></option>
			</select>
		</p>
		
		<div>
			<label for="<?php echo esc_attr($this->get_field_id('social')); ?>"><?php echo esc_html__('Social Icons:', 'bunyad'); ?></label>
			
			<p><small><?php esc_html_e('Drag and drop to re-order.', 'bunyad'); ?></small></p>
			
			<div class="bunyad-social-services">
			<?php 
				foreach ($services as $key => $service): 
					if (!is_array($service)) {
						continue;
					}
			?>
			
			
				<p>
					<label>
						<input class="widefat" type="checkbox" name="<?php echo esc_attr($this->get_field_name('social')); ?>[]" value="<?php echo esc_attr($key); ?>"<?php 
						echo (in_array($key, $social) ? ' checked' : ''); ?> /> 
					<?php echo esc_html($service['label']); ?></label>
				</p>
			
			<?php endforeach; ?>
			
			</div>
			
			<p><small><?php echo esc_html__('Configure from Customize > Social Follow.', 'bunyad'); ?></small></p>
			
		</div>
		
		<script>
		jQuery(function($) { 
			$('.bunyad-social-services').sortable();
		});
		</script>
	
	
		<?php
	}

	/**
	 * Save widget.
	 * 
	 * Strip out all HTML using wp_kses
	 * 
	 * @see wp_kses_post()
	 */
	public function update($new, $old)
	{
		foreach ($new as $key => $val) {

			// Social just needs intval
			if ($key === 'social') {
				
				array_walk($val, 'intval');
				$new[$key] = $val;

				continue;
			}
			
			// Filter disallowed html.
			$new[$key] = wp_kses_post_deep($val);
		}
		
		return $new;
	}
}

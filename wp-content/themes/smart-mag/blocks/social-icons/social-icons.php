<?php

namespace Bunyad\Blocks;

use \Bunyad;
use Bunyad\Blocks\Base\Block;

/**
 * Common Social Icons Block.
 */
class SocialIcons extends Block
{
	public $id = 'social-icons';

	/**
	 * @inheritdoc
	 */
	public static function get_default_props() 
	{
		$props = [
			'style'    => 'a',
			'services' => [
				'facebook',
				'twitter',
			],
			'links' => [],
			'class' => '',
		];

		return $props;
	}

	public function map_global_props($props) 
	{
		return array_replace([

			// Global social profile links.
			'links' => Bunyad::options()->social_profiles,
		], $props);
	}

	/**
	 * Render the social icons.
	 * 
	 * @return void
	 */
	public function render()
	{
		// At least one service has to be enabled.
		if (empty($this->props['services'])) {
			return;
		}

		$services_data = Bunyad::get('social')->get_services();
		$links         = $this->props['links'];

		$classes = [
			'spc-social spc-social-' . $this->props['style'],
			$this->props['class']
		];

		// Have background colors for this style.
		if ($this->props['style'] === 'c') {
			$classes[] = 'spc-social-bg';
		}

		?>

		<div class="<?php echo esc_attr(join(' ', $classes)); ?>">
		
			<?php		
			foreach ($this->props['services'] as $key):
				if (!isset($services_data[$key])) {
					continue;
				}
			
				$service = $services_data[$key];
				$url     = !empty($links[$key]) ? $links[$key] : '#';
			?>

				<a href="<?php echo esc_url($url); ?>" class="link s-<?php echo esc_attr($key); ?>" target="_blank" rel="noopener">
					<i class="icon <?php echo esc_attr($service['icon']); ?>"></i>
					<span class="visuallyhidden"><?php echo esc_html($service['label']); ?></span>
				</a>
									
			<?php endforeach; ?>

		</div>

		<?php

	}
}
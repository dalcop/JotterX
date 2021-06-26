<?php
/**
 * Bunyad framework factory extension.
 * 
 * This aids in better code completion for most IDEs.
 * Most methods here are simply a wrapper for Bunyad_Base::get() method.
 * 
 * @see Bunyad_Base
 * @see Bunyad_Base::get()
 * 
 * @method static Bunyad_Theme_Archives     archives($fresh, ...$args)
 * @method static Bunyad_Theme_Authenticate authenticate($fresh, ...$args)
 * @method static Bunyad_Theme_Media        media($fresh, ...$args)  Media Helpers.
 * @method static \Bunyad\Blocks\Helpers    blocks($fresh, ...$args)
 */
class Bunyad extends Bunyad_Base {

	/**
	 * Main Theme Object
	 *
	 * @return Bunyad_Theme_SmartMag
	 */
	public static function theme() {
		return self::get('theme');
	}
}
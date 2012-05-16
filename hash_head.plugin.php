<?php

class HashHead extends Plugin {

	/**
	 * Set priority to move inserted tags nearer to the end
	 * @return array
	 **/
	public function set_priorities()
	{
		return array(
			'theme_header' => 11,
		);
	}

	/**
	 * Configure path
	 * @return FormUI
	 **/
	public static function configure()
	{
		$form = new FormUI( "hash_head" );
		$form->append( new FormControlSelect( 'type', 'hashhead__path', _t( 'Hash to show', 'hash_head' ), array( '/' => "Habari root", '/system/' => "Habari /system" ) ) );
		$form->append( new FormControlSubmit( 'save', _t( 'Save', 'hash_head' ) ) );
		return $form;
	}

	/**
	 * Add tags to headers.
	 * @return array
	 **/
	public function theme_header( $theme )
	{
		return $this->make_hash_header();
	}

	/**
	 * Generate HTML for adding to headers.
	 * @return string String to add to headers.
	 **/
	private function make_hash_header()
	{
		return "<meta name='git_hash' content='" . self::get_git_short_hash() . "'>\n";
	}

	/**
	 * Attempt to return the shortened git hash of the system source tree
	 *
	 * @return String The first 7 chars of the revision hash
	 */
	public static function get_git_short_hash()
	{
		$rev = '';
		$ref_file = HABARI_PATH .'/system/.git/HEAD';
		if ( file_exists( $ref_file ) ) {
			$info = file_get_contents( $ref_file );
			// If the contents of this file start with "ref: ", it means we need to look where it tells us for the hash.
			// CAVEAT: This is only really useful if the master branch is checked out
			if ( strpos( $info, 'ref: ' ) === false ) {
				$rev = substr( $info, 0, 7 );
			}
			else {
				preg_match( '/ref: (.*)/', $info, $match );
				$rev = substr( file_get_contents( HABARI_PATH . Options::get( 'hashhead__path', '/system' ) . '.git/' . $match[1] ), 0, 7 );
			}
		}
		return $rev;
	}
}
?>

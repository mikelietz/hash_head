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
		$form->append( new FormControlSelect( 'type', 'hashhead__path', _t( 'Hash to show', 'hash_head' ), array( '/system/' => "Habari /system", '/' => "Habari root" ) ) );
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
		return "<meta name='git_hash' content='" . Version::get_git_short_hash( HABARI_PATH . Options::get( 'hashhead__path', '/system' ) ) . "'>\n";
	}
}
?>

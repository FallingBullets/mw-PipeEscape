<?php
/**
 * @file
 * @ingroup Extensions
 * @link http://www.mediawiki.org/wiki/Extension:Pipe_Escape Documentation
 *
 * @author David M. Sledge
 * @modifier Purodha Blissenbach
 * @copyright Copyright © 2008 David M. Sledge
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0
 *     or later
 * @version 0.1.0
 *     initial creation.
 * @version 0.1.1
 *     i18n support.
 *
 * @todo
 *     allow alias names.
 */

if ( !defined( 'MEDIAWIKI' ) )
{
    die( 'This file is a MediaWiki extension, it is not a valid entry point.' );
}

$wgHooks[ 'ParserFirstCallInit' ][] = 'ExtPipeEsc::setup';
$wgExtensionCredits[ 'parserhook' ][] = array(
	'path'            => __FILE__,
	'author'          => 'David M. Sledge',
	'name'            => 'Pipe Escape',
	'version'         => ExtPipeEsc::VERSION,
	'url'             => 'https://www.mediawiki.org/wiki/Extension:Pipe_Escape',
	'descriptionmsg'  => 'pipeescape-desc',
);

$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$wgExtensionMessagesFiles['PipeEscape'] = $dir . 'PipeEscape.i18n.php';
$wgExtensionMessagesFiles['PipeEscapeMagic'] = $dir . 'PipeEscape.i18n.magic.php';

class ExtPipeEsc
{
	const VERSION = '0.1.1';
	private static $parserFunctions = array(
			'!' => 'identity',
			'?' => 'slicer'
		);

	public static function setup( &$parser )
	{
		// register each hook
		foreach( self::$parserFunctions as $hook => $function )
			$parser->setFunctionHook( $hook,
				array( __CLASS__, $function ), SFH_OBJECT_ARGS );
		return true;
	}

	public static function identity( &$parser, $frame, $args )
	{
		$output = array_shift( $args );
		// no parameters means we're done.  spit out an empty string
		if ( !isset( $output ) )
			return '';
		// expand the first argument
		$output = $frame->expand( $output );
		// get the rest of the arguments, expand each one, prefix each expansion
		// with a pipe character, and append it to the output string.
		for ( $arg = array_shift( $args );
			isset( $arg );
			$arg = array_shift( $args ) )
		{
			$output .= '|' . $frame->expand( $arg );
		}
		//return '<pre><nowiki>'. trim( $output ) . '</nowiki></pre>';
		return trim( $output );
	}

	public static function slicer( &$parser, $frame, $args )
	{
		$len = $args[0];
		// no parameters means we're done.  spit out an empty string
		if ( !isset( $len ) )
			return '';
		// expand the first argument
		$len = intval($frame->expand( $len ));
		$out = array();
		for ( $i = 1; $i <= $len; $i++ )
		{
			$out[] = isset( $args[$i] )?$frame->expand( $args[$i] ):'';
		}
		return implode('|',$out);
	}
}

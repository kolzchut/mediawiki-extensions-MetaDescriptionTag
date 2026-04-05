<?php

namespace MediaWiki\Extension\MetaDescriptionTag;

use MediaWiki\Hook\OutputPageParserOutputHook;
use MediaWiki\Hook\ParserFirstCallInitHook;
use MediaWiki\Html\Html;
use MediaWiki\Output\OutputPage;
use MediaWiki\Parser\Parser;
use MediaWiki\Parser\ParserOutput;
use PPFrame;

class Hooks implements ParserFirstCallInitHook, OutputPageParserOutputHook {

	/**
	 * Sets up the MetaDescriptionTag parser hook.
	 *
	 * @param Parser $parser
	 */
	public function onParserFirstCallInit( $parser ): void {
		$parser->setHook( 'metadesc', [ $this, 'renderMetaDescriptionTag' ] );
	}

	/**
	 * Renders the <metadesc> tag.
	 *
	 * @param string|null $text The description to output
	 * @param array $params Attributes specified for the tag
	 * @param Parser $parser Reference to currently running parser
	 * @param PPFrame $frame
	 *
	 * @return string Always empty (because we don't output anything to the text).
	 */
	public function renderMetaDescriptionTag( ?string $text, array $params, Parser $parser, PPFrame $frame ): string {
		if ( $text === null ) {
			$errorText = wfMessage( 'metadescriptiontag-missing-content' )->inContentLanguage()->text();
			return Html::element( 'div', [ 'class' => 'errorbox' ], $errorText );
		}

		$parser->getOutput()->setExtensionData( 'metaDescription', trim( $text ) );

		return '';
	}

	/**
	 * @param OutputPage $out
	 * @param ParserOutput $parserOutput
	 */
	public function onOutputPageParserOutput( $out, $parserOutput ): void {
		$metaDescription = $parserOutput->getExtensionData( 'metaDescription' );
		if ( !empty( $metaDescription ) ) {
			$out->addMeta( 'description', htmlspecialchars( $metaDescription ) );
		}
	}
}

<?php

namespace MediaWiki\Extension\MetaDescriptionTag\Tests;

use MediaWiki\Extension\MetaDescriptionTag\Hooks;
use MediaWiki\Output\OutputPage;
use MediaWiki\Parser\Parser;
use MediaWiki\Parser\ParserOutput;
use MediaWikiUnitTestCase;
use PPFrame;

/**
 * @covers \MediaWiki\Extension\MetaDescriptionTag\Hooks
 */
class HooksTest extends MediaWikiUnitTestCase {

	private function newHooks(): Hooks {
		return new Hooks();
	}

	public function testOnParserFirstCallInitRegistersTag(): void {
		$hooks = $this->newHooks();

		$parser = $this->createMock( Parser::class );
		$parser->expects( $this->once() )
			->method( 'setHook' )
			->with( 'metadesc', $this->isType( 'array' ) );

		$hooks->onParserFirstCallInit( $parser );
	}

	public function testRenderMetaDescriptionTagStoresData(): void {
		$hooks = $this->newHooks();

		$parserOutput = $this->createMock( ParserOutput::class );
		$parserOutput->expects( $this->once() )
			->method( 'setExtensionData' )
			->with( 'metaDescription', 'Hello world' );

		$parser = $this->createMock( Parser::class );
		$parser->method( 'getOutput' )->willReturn( $parserOutput );

		$frame = $this->createMock( PPFrame::class );

		$result = $hooks->renderMetaDescriptionTag( '  Hello world  ', [], $parser, $frame );

		$this->assertSame( '', $result );
	}

	public function testRenderMetaDescriptionTagMissingContentReturnsError(): void {
		$hooks = $this->newHooks();

		$parser = $this->createMock( Parser::class );
		$frame = $this->createMock( PPFrame::class );

		$result = $hooks->renderMetaDescriptionTag( null, [], $parser, $frame );

		$this->assertStringContainsString( 'errorbox', $result );
	}

	public function testOnOutputPageParserOutputAddsMeta(): void {
		$hooks = $this->newHooks();

		$parserOutput = $this->createMock( ParserOutput::class );
		$parserOutput->method( 'getExtensionData' )
			->with( 'metaDescription' )
			->willReturn( 'A description' );

		$out = $this->createMock( OutputPage::class );
		$out->expects( $this->once() )
			->method( 'addMeta' )
			->with( 'description', $this->isType( 'string' ) );

		$hooks->onOutputPageParserOutput( $out, $parserOutput );
	}

	public function testOnOutputPageParserOutputSkipsEmptyDescription(): void {
		$hooks = $this->newHooks();

		$parserOutput = $this->createMock( ParserOutput::class );
		$parserOutput->method( 'getExtensionData' )
			->with( 'metaDescription' )
			->willReturn( null );

		$out = $this->createMock( OutputPage::class );
		$out->expects( $this->never() )->method( 'addMeta' );

		$hooks->onOutputPageParserOutput( $out, $parserOutput );
	}
}

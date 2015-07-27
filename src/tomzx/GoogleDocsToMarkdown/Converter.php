<?php

namespace tomzx\GoogleDocsToMarkdown;

use League\HTMLToMarkdown\HtmlConverter;
use tomzx\GoogleDocsToMarkdown\HtmlConverter\EmphasisConverter;

class Converter {
	/**
	 * @var \League\HTMLToMarkdown\HtmlConverter
	 */
	protected $converter;

	public function __construct()
	{
		$this->converter = new HtmlConverter([
			'header_style' => 'atx',
			'strip_tags' => true,
			'remove_nodes' => 'head',
		]);
	}

	/**
	 * @return \League\HTMLToMarkdown\HtmlConverter
	 */
	public function getConverter()
	{
		return $this->converter;
	}
}

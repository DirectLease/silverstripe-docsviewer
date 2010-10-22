<?php
/**
 * @package sapphiredocs
 */
class DocumentationParserTest extends SapphireTest {
	
	// function testRewriteCodeBlocks() {
	// 		$page = new DocumentationPage(
	// 			'test.md',
	// 			new DocumentationEntity('mymodule', '2.4', BASE_PATH . '/sapphiredocs/tests/docs/'),
	// 			'en',
	// 			'2.4'
	// 		);
	// 		$result = DocumentationParser::rewrite_code_blocks($page->getMarkdown());
	// 		$expected = <<<HTML
	// <pre class="brush: php">
	// code block
	// with multiple
	// lines
	// </pre>
	// HTML;
	// 		$this->assertContains($expected, $result);		
	// 	}
	
	function testImageRewrites() {
		// Page on toplevel
		$page = new DocumentationPage();
		$page->setRelativePath('subfolder/subpage.md');
		$page->setEntity(new DocumentationEntity('mymodule', '2.4', BASE_PATH . '/sapphiredocs/tests/docs/'));
		$page->setLang('en');
		$page->setVersion('2.4');
		
		$result = DocumentationParser::rewrite_image_links($page->getMarkdown(), $page, 'mycontroller/cms/2.4/en/');
		$this->assertContains(
			'[relative image link](' . Director::absoluteBaseURL() . '/sapphiredocs/tests/docs/en/subfolder/_images/image.png)',
			$result
		);
		$this->assertContains(
			'[parent image link](' . Director::absoluteBaseURL() . '/sapphiredocs/tests/docs/en/_images/image.png)',
			$result
		);
		// TODO Fix absolute image references
		// $this->assertContains(
		// 	'[absolute image link](' . Director::absoluteBaseURL() . '/sapphiredocs/tests/docs/en/_images/image.png)',
		// 	$result
		// );
	}
	
	function testApiLinks() {
		// Page on toplevel
		$page = new DocumentationPage();
		$page->setRelativePath('test.md');
		$page->setEntity(new DocumentationEntity('mymodule', '2.4', BASE_PATH . '/sapphiredocs/tests/docs/'));
		$page->setLang('en');
		$page->setVersion('2.4');
		
		
		$result = DocumentationParser::rewrite_api_links($page->getMarkdown(), $page, 'mycontroller/cms/2.4/en/');
		$this->assertContains(
			'[link: api](http://api.silverstripe.org/search/lookup/?q=DataObject&version=2.4&module=mymodule)',
			$result
		);
		$this->assertContains(	'[DataObject::$has_one](http://api.silverstripe.org/search/lookup/?q=DataObject::$has_one&version=2.4&module=mymodule)',
			$result
		);
	}
	
	function testHeadlineAnchors() {
		$page = new DocumentationPage();
		$page->setRelativePath('test.md');
		$page->setEntity(new DocumentationEntity('mymodule', '2.4', BASE_PATH . '/sapphiredocs/tests/docs/'));
		$page->setLang('en');
		$page->setVersion('2.4');
		
		$result = DocumentationParser::rewrite_heading_anchors($page->getMarkdown(), $page);
		
		/*
		# Heading one {#Heading-one}

		# Heading with custom anchor {#custom-anchor} {#Heading-with-custom-anchor-custom-anchor}

		## Heading two {#Heading-two}

		### Heading three {#Heading-three}

		## Heading duplicate {#Heading-duplicate}

		## Heading duplicate {#Heading-duplicate-2}

		## Heading duplicate {#Heading-duplicate-3}
		
		*/

		$this->assertContains('# Heading one {#Heading-one}', $result);
		$this->assertContains('# Heading with custom anchor {#custom-anchor}', $result);
		$this->assertNotContains('# Heading with custom anchor {#custom-anchor} {#Heading', $result);
		$this->assertContains('# Heading two {#Heading-two}', $result);
		$this->assertContains('# Heading three {#Heading-three}', $result);
		$this->assertContains('## Heading duplicate {#Heading-duplicate}', $result);
		$this->assertContains('## Heading duplicate {#Heading-duplicate-2}', $result);
		$this->assertContains('## Heading duplicate {#Heading-duplicate-3}', $result);
		
	}
		
	function testRelativeLinks() {
		// Page on toplevel
		$page = new DocumentationPage();
		$page->setRelativePath('test.md');
		$page->setEntity(new DocumentationEntity('mymodule', '2.4', BASE_PATH . '/sapphiredocs/tests/docs/'));

		$result = DocumentationParser::rewrite_relative_links($page->getMarkdown(), $page, 'mycontroller/cms/2.4/en/');

		$this->assertContains(
			'[link: subfolder index](mycontroller/cms/2.4/en/subfolder/)',
			$result
		);
		$this->assertContains(
			'[link: subfolder page](mycontroller/cms/2.4/en/subfolder/subpage)',
			$result
		);
		$this->assertContains(
			'[link: http](http://silverstripe.org)',
			$result
		);
		$this->assertContains(
			'[link: api](api:DataObject)',
			$result
		);
		
		// Page in subfolder
		$page = new DocumentationPage();
		$page->setRelativePath('subfolder/subpage.md');
		$page->setEntity(new DocumentationEntity('mymodule', '2.4', BASE_PATH . '/sapphiredocs/tests/docs/'));
		
		$result = DocumentationParser::rewrite_relative_links($page->getMarkdown(), $page, 'mycontroller/cms/2.4/en/');

		$this->assertContains(
			'[link: absolute index](mycontroller/cms/2.4/en/)',
			$result
		);
		$this->assertContains(
			'[link: absolute index with name](mycontroller/cms/2.4/en/index)',
			$result
		);
		$this->assertContains(
			'[link: relative index](mycontroller/cms/2.4/en/)',
			$result
		);
		$this->assertContains(
			'[link: relative parent page](mycontroller/cms/2.4/en/test)',
			$result
		);
		$this->assertContains(
			'[link: absolute parent page](mycontroller/cms/2.4/en/test)',
			$result
		);
		
		// Page in nested subfolder
		$page = new DocumentationPage();
		$page->setRelativePath('subfolder/subsubfolder/subsubpage.md');
		$page->setEntity(new DocumentationEntity('mymodule', '2.4', BASE_PATH . '/sapphiredocs/tests/docs/'));
		
		$result = DocumentationParser::rewrite_relative_links($page->getMarkdown(), $page, 'mycontroller/cms/2.4/en/');
		
		$this->assertContains(
			'[link: absolute index](mycontroller/cms/2.4/en/)',
			$result
		);
		$this->assertContains(
			'[link: relative index](mycontroller/cms/2.4/en/subfolder/)',
			$result
		);
		$this->assertContains(
			'[link: relative parent page](mycontroller/cms/2.4/en/subfolder/subpage)',
			$result
		);
		$this->assertContains(
			'[link: relative grandparent page](mycontroller/cms/2.4/en/test)',
			$result
		);
		$this->assertContains(
			'[link: absolute page](mycontroller/cms/2.4/en/test)',
			$result
		);
	}
	
	function testCleanPageNames() {
		$names = array(
			'documentation-Page',
			'documentation_Page',
			'documentation.md',
			'documentation.pdf',
			'documentation.file.txt',
			'.hidden'
		);
		
		$should = array(
			'Documentation Page',
			'Documentation Page',
			'Documentation',
			'Documentation',
			'Documentation',
			'.hidden' // don't display something without a title
		);
		
		foreach($names as $key => $value) {
			$this->assertEquals(DocumentationParser::clean_page_name($value), $should[$key]);
		}
	}
	
	function testGetPagesFromFolder() {
		$pages = DocumentationParser::get_pages_from_folder(BASE_PATH . '/sapphiredocs/tests/docs/en/');
		$this->assertContains('index', $pages->column('Filename'), 'Index');
		$this->assertContains('subfolder', $pages->column('Filename'), 'Foldername');
		$this->assertContains('test', $pages->column('Filename'), 'Filename');
		$this->assertNotContains('_images', $pages->column('Filename'), 'Ignored files');
		
		// test the order of pages
		$pages = DocumentationParser::get_pages_from_folder(BASE_PATH . '/sapphiredocs/tests/docs/en/sort');

		$this->assertEquals(
			array('1 basic', '2 intermediate', '3 advanced', '10 some page', '21 another page'),
			$pages->column('Title')
		);

	}
	
	function testGetPagesFromFolderRecursive() {
		$pages = DocumentationParser::get_pages_from_folder(BASE_PATH . '/sapphiredocs/tests/docs-recursive/en/', true);
		// check to see all the pages are found, we don't care about order
		$this->assertEquals($pages->Count(), 6);

		$pages = $pages->column('Title');
		
		foreach(array('Index', 'Subfolder testfile', 'Subsubfolder testfile', 'Testfile') as $expected) {
			$this->assertContains($expected, $pages);
		}
	}
	
}
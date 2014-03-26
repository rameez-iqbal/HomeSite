<?php
// src/Mysite/HomeBundle/Tests/Entity/BlogTest.php

namespace Mysite\HomeBundle\Tests\Entity;

use Mysite\HomeBundle\Entity\Blog;

class BlogTest extends \PHPUnit_Framework_TestCase
{
	public function testSlugify()
    {
        $blog = new Blog();

        $this->assertEquals('hello-world', $blog->slugify('Hello World'));
        $this->assertEquals('a-day-with-symfony2', $blog->slugify('A Day With Symfony2'));
		$this->assertEquals('hello-world', $blog->slugify('Hello    world'));
		$this->assertEquals('symblog', $blog->slugify('symblog '));
		$this->assertEquals('symblog', $blog->slugify(' symblog'));
    }
    
    public function testSetSlug()
	{
		$blog = new Blog();

		$blog->setSlug('Symfony2 Blog');
		$this->assertEquals('symfony2-blog', $blog->getSlug());
	}

	public function testSetTitle()
	{
		$blog = new Blog();

		$blog->setTitle('Hello World');
		$this->assertEquals('hello-world', $blog->getSlug());
	}
}

<?php
// src/Mysite/HomeBundle/Tests/Twig/Extensions/MysiteHomeExtensionTest.php

namespace Mysite\HomeBundle\Tests\Twig\Extensions;

use Mysite\HomeBundle\Twig\Extensions\MysiteHomeExtension;

class MysiteHomeExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatedAgo()
    {
        $home = new MysiteHomeExtension();

        $this->assertEquals("0 seconds ago", $home->createdAgo(new \DateTime()));
        $this->assertEquals("34 seconds ago", $home->createdAgo($this->getDateTime(-34)));
        $this->assertEquals("1 minute ago", $home->createdAgo($this->getDateTime(-60)));
        $this->assertEquals("2 minutes ago", $home->createdAgo($this->getDateTime(-120)));
        $this->assertEquals("1 hour ago", $home->createdAgo($this->getDateTime(-3600)));
        $this->assertEquals("1 hour ago", $home->createdAgo($this->getDateTime(-3601)));
        $this->assertEquals("2 hours ago", $home->createdAgo($this->getDateTime(-7200)));

        // Cannot create time in the future
        $this->setExpectedException('\InvalidArgumentException');
        $home->createdAgo($this->getDateTime(60));
    }

    protected function getDateTime($delta)
    {
        return new \DateTime(date("Y-m-d H:i:s", time()+$delta));
    }
}

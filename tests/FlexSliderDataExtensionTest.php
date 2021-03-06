<?php

class FlexSliderDataExtensionTest extends FlexSliderTest
{
    public function testTabNameConfig()
    {

        $page = new Page();
        $page->write();
        $extension = new FlexSlider();
        $pageFields = $page->getCMSFields();
        $extension->updateCMSFields($pageFields);
        $this->assertNotNull($pageFields->fieldByName('Root.Slides'));

        Config::inst()->update('Page', 'slide_tab_title', 'MyCustomSlideTitle');
        $page2 = Page::create();
        $page2->write();
        $page2Fields = $page2->getCMSFields();
        $extension->updateCMSFields($page2Fields);
        $this->assertNull($page2Fields->fieldByName('Root.Slides'));
        $this->assertNotNull($page2Fields->fieldByName('Root.MyCustomSlideTitle'));

    }

    public function testUpdateCMSFields()
    {
        $extension = new FlexSlider();
        $object = Page::create();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);
        $this->assertNull($fields->dataFieldByName('Slides'));

        $object->write();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);
        $this->assertNotNull($fields->dataFieldbyName('Slides'));
    }

    public function testGetSlideshow()
    {
        $object = singleton('Page');
        $object->write();
        $slide1 = $this->objFromFixture('SlideImage', 'slide1');
        $image = $this->objFromFixture('Image', 'image1');
        $slide1->ImageID = $image->ID;
        $object->Slides()->add($slide1);
        $slides = $object->SlideShow();
        $this->assertInstanceOf('DataList', $slides);
    }
}


Page::add_extension('FlexSlider');
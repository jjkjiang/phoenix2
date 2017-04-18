<?php

namespace AppBundle\Twig;

use AppBundle\Utils\Markdown;

class MarkdownExtension extends \Twig_Extension
{
    private $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'markdown',
                array($this, 'markdownToHTML'),
                array('is_safe' => array('html'))
            ),
        );
    }

    public function markdownToHTML($content)
    {
        return $this->parser->toHTML($content);
    }

    public function getName()
    {
        return 'markdown_extension';
    }
}

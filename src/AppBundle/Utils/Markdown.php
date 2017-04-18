<?php

namespace AppBundle\Utils;

class Markdown
{
    private $parser;

    public function __construct()
    {
        $this->parser = new \Parsedown();
    }

    public function toHTML($text)
    {
        $html = $this->parser->text($text);

        return $html;
    }
}

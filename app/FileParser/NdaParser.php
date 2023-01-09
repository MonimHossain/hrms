<?php


namespace App\FileParser;


use FontLib\Table\Type\name;

class NdaParser
{
    protected $content;
    protected $data;

    public function __construct($content)
    {
        $this->content = $content;
        $this->spitFile();
    }

    public function getData()
    {
        return $this->data;
    }

    public function spitFile()
    {
        preg_match_all('/^\-{3}(.*?)\-{3}(.*)/s',
            $this->content,
            $this->data);
        dd($this->data);
    }

    public function getName(string $name): ?string
    {
        if ($name) {
            return $name;
        } else {
            return null;
        }
    }

}

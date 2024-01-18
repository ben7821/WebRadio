<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileTransformer implements DataTransformerInterface
{
    private $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    public function transform($string)
    {
        return new File($this->directory.'/'.$string);
    }

    public function reverseTransform($file)
    {
        return $file->getPath();
    }
}
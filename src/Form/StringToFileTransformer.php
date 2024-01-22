<?php
namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileTransformer implements DataTransformerInterface
{
    private $directory;

    public function __construct()
    {
        $this->directory = "";
    }

    public function setDirectory($directory)
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
<?php
namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Exception\TransformationFailedException;
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
        return $string;
    }

    public function reverseTransform($file)
    {
        if ($file == null) {
            throw new TransformationFailedException();
        }
        return new File($this->directory . $file);
    }
}
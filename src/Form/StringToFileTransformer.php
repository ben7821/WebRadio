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

    public function setDirectory(string $directory)
    {
        $this->directory = $directory;
    }

    public function transform($string)
    {
        if (null === $string || !file_exists($this->directory . '/' . $string)) {
            return null;
        }

        $filePath = $this->directory . "/" . $string;

        if (!file_exists($filePath)) {
            // Handle the error, e.g., throw an exception or return a default value
            throw new \Exception(sprintf('No file found at "%s"', $filePath));
        }

        return new File($filePath);
    }


    public function reverseTransform($file)
    {
        if (null === $file) {
            return null;
        }
        return new File($file->getPathname());
    }
}

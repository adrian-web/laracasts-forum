<?php

namespace App\Filters;

class Spam
{
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    protected function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'yahoo customer support'
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('This reply contains spam');
            }
        }
    }
}

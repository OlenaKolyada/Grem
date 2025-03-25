<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait AutoSlugTrait
{
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlugFromTitle(): void
    {
        if (
            !method_exists($this, 'getTitle') ||
            !method_exists($this, 'getSlug') ||
            !method_exists($this, 'setSlug')
        ) {
            return;
        }

        $slug = $this->getSlug();
        $title = $this->getTitle();

        if (($slug === null || $slug === '') && $title) {
            $text = preg_replace('/[^a-z0-9]+/i', '-', $title);
            $text = trim($text, '-');
            $text = strtolower($text);

            $this->setSlug($text);
        }
    }
}
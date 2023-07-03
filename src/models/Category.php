<?php

namespace Wared2003\ThomannScrap\models;

class Category
{
    public string $name;

    /**
     * @return string
     */
    public function getParentCategory(): string
    {
        return $this->parentCategory;
    }
    public string $parentCategory;

    public function __construct(string $name, string $slug, string $parentCategory)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->parentCategory = $parentCategory;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    public string $slug;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
}

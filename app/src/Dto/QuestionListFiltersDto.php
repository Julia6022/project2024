<?php

/**
 * Question list filters DTO.
 */

namespace App\Dto;

use App\Entity\Category;
use App\Entity\Tags;

/**
 * Class QuestionListFiltersDto.
 */
class QuestionListFiltersDto
{
    /**
     * Constructor.
     *
     * @param Category|null $category Category entity
     * @param Tags|null     $tags     Tags entity
     */
    public function __construct(public readonly ?Category $category, public readonly ?Tags $tags)
    {
    }
}

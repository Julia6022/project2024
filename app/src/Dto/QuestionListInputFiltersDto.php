<?php

/**
 * Question list input filters DTO.
 */

namespace App\Dto;

/**
 * Class QuestionListInputFiltersDto.
 */
class QuestionListInputFiltersDto
{
    /**
     * Constructor.
     *
     * @param int|null $categoryId Category identifier
     * @param int|null $tagsId     Tags identifier
     */
    public function __construct(public readonly ?int $categoryId = null, public readonly ?int $tagsId = null)
    {
    }
}

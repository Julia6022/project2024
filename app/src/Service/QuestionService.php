<?php
/**
 * Question service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\Tags;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class QuestionService.
 */
class QuestionService implements QuestionServiceInterface
{
    /**
     * Constructor.
     *
     * @param QuestionRepository $questionRepository Question repository
     * @param PaginatorInterface $paginator          Paginator
     */
    public function __construct(private readonly QuestionRepository $questionRepository, private readonly PaginatorInterface $paginator)
    {
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface Pagination interface
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryAll(),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list for category.
     *
     * @param int      $page     Page number
     * @param Category $category Category entity
     *
     * @return PaginationInterface Pagination interface
     */
    public function queryByCategory(int $page, Category $category): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryByCategory($category),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list for tags.
     *
     * @param int  $page Page number
     * @param Tags $tags Tags entity
     *
     * @return PaginationInterface Pagination interface
     */
    public function queryByTags(int $page, Tags $tags): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryByTags($tags),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Question $question Question entity
     */
    public function save(Question $question): void
    {
        $this->questionRepository->save($question);
    }

    /**
     * Delete entity.
     *
     * @param Question $question Question entity
     */
    public function delete(Question $question): void
    {
        $this->questionRepository->delete($question);
    }
}

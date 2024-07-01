<?php

/**
 * Answer entity.
 */

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Answer.
 */
#[ORM\Entity(repositoryClass: AnswerRepository::class)]
#[ORM\Table(name: 'answers')]
class Answer
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Comment.
     */
    #[ORM\Column(length: 5000)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 5000)]
    private ?string $comment = null;

    /**
     * Created at.
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Updated at.
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * Question.
     */
    #[ORM\ManyToOne(targetEntity: Question::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Assert\NotNull]
    #[Assert\Type(Question::class)]
    private Question $question;

    /**
     * Author.
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    #[Assert\Type(User::class)]
    private ?User $author = null;

    /**
     * Best answer.
     */
    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private bool $bestAnswer = false;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for comment.
     *
     * @return string|null Comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Setter for comment.
     *
     * @param string $comment Comment
     *
     * @return $this
     */
    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Getter for created at.
     *
     * @return \DateTimeImmutable|null Created at
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for created at.
     *
     * @param \DateTimeImmutable $createdAt Created at
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Getter for updated at.
     *
     * @return \DateTimeImmutable|null Updated at
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updated at.
     *
     * @param \DateTimeImmutable $updatedAt Updated at
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Getter for question.
     *
     * @return Question Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * Setter for question.
     *
     * @param Question $question Question
     *
     * @return $this
     */
    public function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Getter for author.
     *
     * @return User|null Author
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for author.
     *
     * @param User|null $author Author
     *
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Getter for best answer flag.
     *
     * @return bool Best answer
     */
    public function isBestAnswer(): bool
    {
        return $this->bestAnswer;
    }

    /**
     * Setter for best answer flag.
     *
     * @param bool $bestAnswer Best answer
     *
     * @return $this
     */
    public function setBestAnswer(bool $bestAnswer): self
    {
        $this->bestAnswer = $bestAnswer;

        return $this;
    }
}

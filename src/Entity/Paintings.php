<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paintings
 *
 * @ORM\Table(name="paintings", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_CDBED5082B36786B", columns={"title"})}, indexes={@ORM\Index(name="IDX_CDBED50812469DE2", columns={"category_id"})})
 * @ORM\Entity
 */
class Paintings
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="smallint", nullable=false)
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="smallint", nullable=false)
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="smallint", nullable=false)
     */
    private $year;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;


}

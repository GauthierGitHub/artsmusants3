<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sales
 *
 * @ORM\Table(name="sales", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_6B817044B00EB939", columns={"painting_id"})}, indexes={@ORM\Index(name="IDX_6B8170449395C3F3", columns={"customer_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\SalesRepository")
 */
class Sales
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="canceled", type="boolean", nullable=false)
     */
    private $canceled = '0';

    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var \Paintings
     *
     * @ORM\ManyToOne(targetEntity="Paintings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="painting_id", referencedColumnName="id")
     * })
     */
    private $painting;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCanceled(): ?bool
    {
        return $this->canceled;
    }

    public function setCanceled(bool $canceled): self
    {
        $this->canceled = $canceled;

        return $this;
    }

    public function getCustomer(): ?Customers
    {
        return $this->customer;
    }

    public function setCustomer(?Customers $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPainting(): ?Paintings
    {
        return $this->painting;
    }

    public function setPainting(?Paintings $painting): self
    {
        $this->painting = $painting;

        return $this;
    }


}

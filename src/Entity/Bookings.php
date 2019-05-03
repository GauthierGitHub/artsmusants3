<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bookings
 *
 * @ORM\Table(name="bookings", indexes={@ORM\Index(name="IDX_7A853C359395C3F3", columns={"customer_id"}), @ORM\Index(name="IDX_7A853C35B00EB939", columns={"painting_id"})})
 * @ORM\Entity
 */
class Bookings
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

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


}

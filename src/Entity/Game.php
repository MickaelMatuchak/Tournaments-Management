<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $nameTeam1;

    /**
     * @ORM\Column(type="string")
     */
    public $nameTeam2;

    /**
     * @ORM\Column(type="integer")
     */
    public $scoreTeam1;

    /**
     * @ORM\Column(type="integer")
     */
    public $scoreTeam2;
}

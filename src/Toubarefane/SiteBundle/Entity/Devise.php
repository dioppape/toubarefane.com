<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace master\tp1Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devise
 *
 * @ORM\Table(name="devise")
 * @ORM\Entity(repositoryClass="master\tp1"
 */
class Devise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
}
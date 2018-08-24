<?php
/**
 * User: boshurik
 * Date: 24.08.18
 * Time: 11:17
 */

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Bar
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    public $name;
}
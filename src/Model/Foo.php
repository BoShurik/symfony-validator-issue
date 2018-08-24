<?php
/**
 * User: boshurik
 * Date: 24.08.18
 * Time: 11:17
 */

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class Foo
{
    /**
     * @var Bar[]
     *
     * @Assert\Valid()
     */
    public $bars;

    public function __construct()
    {
        $this->bars = [
            new Bar(),
            new Bar(),
        ];
    }

    /**
     * @Assert\Callback()
     *
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public function validation(ExecutionContextInterface $context, $payload)
    {
        $violations = $context->getValidator()->validate($this->bars, new Assert\Count([
            'min' => 3,
            'max' => 3,
        ]));

        if ($violations->count() === 0) {
            return;
        }

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $context
                ->buildViolation($violation->getMessage())
                ->atPath('bars')
                ->addViolation()
            ;
        }
    }
}
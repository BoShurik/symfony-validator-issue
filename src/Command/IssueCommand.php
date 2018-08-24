<?php
/**
 * User: boshurik
 * Date: 24.08.18
 * Time: 11:14
 */

namespace App\Command;

use App\Model\Foo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IssueCommand extends Command
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        parent::__construct(null);

        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('app:issue')
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $model = new Foo();
        $violations = $this->validator->validate($model);
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            dump(sprintf('%s: %s', $violation->getPropertyPath(), $violation->getMessage()));
        }

        /*
            Got:
            "bars: This collection should contain exactly 3 elements."
            "bars: This value should not be blank." <- not expected
            "bars: This value should not be blank." <- not expected
            "bars[0].name: This value should not be blank."
            "bars[1].name: This value should not be blank."
         */
    }
}
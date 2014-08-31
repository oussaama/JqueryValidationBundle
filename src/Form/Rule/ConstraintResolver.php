<?php
namespace Boekkooi\Bundle\JqueryValidationBundle\Form\Rule;

use Boekkooi\Bundle\JqueryValidationBundle\Form\Rule;
use Boekkooi\Bundle\JqueryValidationBundle\Form\RuleCollection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraint;

/**
 * @author Warnar Boekkooi <warnar@boekkooi.net>
 */
class ConstraintResolver implements ConstraintResolverInterface
{
    /**
     * @var ConstraintMapperInterface[]
     */
    protected $mappers;

    public function __construct()
    {
        $this->mappers = $this->getDefaultResolvers();
    }

    public function resolve($constraints)
    {
        $collection = new RuleCollection();
        foreach ($this->mappers as $mapper) {
            foreach ($constraints as $constraint) {
                if (!$mapper->supports($constraint)) {
                    continue;
                }

                $mapper->resolve($collection, $constraint);
            }
        }

        return $collection;
    }

    protected function getDefaultResolvers()
    {
        return array(
            new Mapping\RequiredRule(),

            new Mapping\NumberRule(),
            new Mapping\MinRule(),
            new Mapping\MaxRule(),

            new Mapping\MinLengthRule(),
            new Mapping\MaxLengthRule(),

            new Mapping\EmailRule(),
            new Mapping\UrlRule(),
            new Mapping\CreditcardRule()
        );
    }
}


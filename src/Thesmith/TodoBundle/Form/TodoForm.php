<?php

namespace Thesmith\TodoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TodoForm extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('todo', 'textarea');
    }
}

<?php

namespace Thesmith\TodoBundle\Controller;

use Thesmith\TodoBundle\Form\TodoForm;
use Thesmith\TodoBundle\Entity\Todo;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/todo/{name}", name="_todo_index")
     * @Template()
     */
    public function indexAction($name) {
      $redis = $this->container->get('redis.default_client');
      $todo = new Todo();
      $form = $this->createForm(new TodoForm(), $todo);

      $request = $this->get('request');
      if ('POST' == $request->getMethod()) {
          $form->bindRequest($request);
          if ($form->isValid()) {

              $redis->lpush($name, $todo->todo);
          }
      }

      $todoList = $redis->lrange($name, 0, 50);

      return array('todoList' => $todoList, 'form' => $form->createView(), 'name' => $name);
    }
}

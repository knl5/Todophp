<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    public static $session_key ='todolist';
    /* @Route('/', name: 'todolist_list') */
    public function list(RequestStack $requestStack): Response
    {
        $session = requestStack->getSession();
        return $this->render('todolist/index.html.twig', [
            'list' => $session -> get(self::$session_key),
        ]);
    }

    /* @Route('/add', name: 'todolist_add', methods={"POST"}) */
    public function add(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $list = $session->get(self::$session_key);
        $list[] = $requestStack->getMainRequest()->request->get('value');
        $session->set(self::$session_key, $list);

        return $this->redirectToRoute('todolist_list');
    }

    /* #[Route('/delete', name: 'todolist')]
    public function delete(RequestStack $requestStack): Response
    {
        return $this->render('conference/index.html.twig', [
            'controller_name' => 'TodoListController',
        ]);
    } */
}
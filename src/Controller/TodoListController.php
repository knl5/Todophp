<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    public static $session_key ='todolist';

    #[Route('/', name: 'todolist_list')]
    public function list(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();

        $list =$session->get('todolist');

        $template = $this->render('todolist/index.html.twig', [
            'list' => $list,
        ]);

        return $template;
        /* return $this->render('todolist/index.html.twig', [
            'list' => $session -> get(self::$session_key),
        ]); */
    }

    
    #[Route('/add', name: 'todolist_add')]
    public function add(RequestStack $requestStack): Response
    {
        $request = $requestStack->getMainRequest();
        $session = $requestStack->getSession();/* getSession(); */

        $list = $session->get(self::$session_key);
        $list[] = $request->query->get('value'); /* Stack->getMainRequest()->request->get('addItem'); */
        
        $session->set('todolist', $list);

        return $this->redirectToRoute('todolist_list');
    }

    
    #[Route('/delete/{$id}', name: 'todolist_delete')]
    public function delete(RequestStack $requestStack, $id): Response
    {
        $session = $requestStack->getSession();
        $list = $session->get('todoList');/* (self::$session_key) */;
        $list = array_values($list);
        unset($list[$id]);
        
        $session->set('todolist', $list);

        return $this->redirectToRoute('todolist_list');
        /* $removeElement = $requestStack->getMainRequest()->query->get('remove');
        unset($list[removeElement]);
        $new_list = []; */
    } 
}

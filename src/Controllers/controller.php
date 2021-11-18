<?php

declare(strict_types=1);

namespace App\Controllers;


use App\Controllers\AbstractController;
use App\Exception\NotFoundException;


class Controller extends AbstractController
{
    public function createAction(): void
    {

        if ($this->request->hasPost()) {

            $this->db->createNote([
                'title' => $this->request->postPara('title'),
                'description' => $this->request->postPara('description')
            ]);

            $this->redirect('/', ['before' => 'created']);
        }

        $this->view->render('create');
    }
    public function showAction(): void
    {
        $this->view->render('show', ['note' => $this->getNote()]);
    }
    public function listAction(): void
    {
        $sortby = $this->request->getPara('sortby','title');
        $orderby = $this->request->getPara('orderby','asc');


        if(!in_array($sortby,['title','created'])){
            $sortby = 'title';
        }
        if(!in_array($orderby,['asc','desc'])){
            $orderby = 'asc';
        }

        $this->view->render('list', [
            'notes' => $this->db->getNotes($sortby,$orderby) ?? [],
            'error' => $this->request->getPara('error'),
            'before' => $this->request->getPara('before'),
            'settings' => [
                'sortby' => $sortby,
                'orderby' => $orderby,
            ]
        ]);
    }
    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postPara('id');
            $this->db->deleteNote($noteId);
            $this->redirect('/', ['before' => 'delete']);
        }

        $this->view->render('delete', ['note' => $this->getNote()]);
    }
    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postPara('id');
            $noteData = [
                'title' => $this->request->postPara('title'),
                'description' => $this->request->postPara('description')
            ];

            $this->db->editNote($noteId, $noteData);

            $this->redirect('/', ['before' => 'edit']);
        }

        $this->view->render('edit', ['note' => $this->getNote()]);
    }
    private function getNote(): array
    {
        $currId = (int) $this->request->getPara('id');

        if (!$currId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }

        try {
            $note = $this->db->getNote($currId);
        } catch (NotFoundException $e) {
            $this->redirect('/', ['error' => 'noteNotFound']);
        }

        return $note;
    }
}
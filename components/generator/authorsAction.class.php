<?php
class authorsAction extends TController{

function actionUpdateFor() {
$this->controller()->findForIdCollection('tempUpdate');
}

function actionDeleteFor() {
$this->controller()->findForIdCollection('tempDelete');
}

function insertauthors() {
$template = 'insertauthors';
$this->controller()->dispatch($template,'authors');
}

function findAllauthors(){
$assign=TRecord::model()
->object('authors')
->findAll();
$this->controller()
->dispatch('getauthorsAll', $assign);
}

function findIdauthors(){
$assign=TRecord::model()
->object('authors')
->findForIdCollection();
$this->controller()
->dispatch('getauthorsId', $assign);
}
}
?>
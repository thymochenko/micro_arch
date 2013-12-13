<?php
include 'generateFilers.php';
/*
$xml_file=array 
  ('atendentes'=>'atendentes.xml',
	'clientes'=>'clientes.xml',
	'consultas'=>'consultas.xml',
	'medicos'=>'medicos.xml',
	'planos'=>'planos.xml',
	'prontuario'=>'prontuario.xml'
	);
	*/
	$xml=array(
		'venda'=>'venda.xml',
		'carrinho'=>'carrinho.xml',
		'mesa'=>'mesa.xml',
		'categoria'=>'categoria.xml',
		'item'=>'item.xml',
		'users'=>'users.xml',
		'pedido'=>'pedido.xml'
	);
	
foreach($xml as $k=>$file):new Aplication($file);endforeach;

    #$o=new LZGenerateTables;
	
    #$o->set('localhost','blog','root','')->init()->creat_table('autors.xml');
	#cria uma aplicação vazia
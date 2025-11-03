<?php
defined('BASEPATH') OR exit('Ação não permitida :(');


function to_dbase($dado=null){
  //Vamos converter caracteres especiais em entidades HTML, para prevenir vulnerabilidades de segurança como ataques de XSS
  return $data = html_escape($dado);
}



CREATE TABLE IF NOT EXISTS `usuarios` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` VARCHAR( 50 ) NOT NULL ,
      `usuario` VARCHAR( 25 ) NOT NULL ,
      `senha` VARCHAR( 40 ) NOT NULL ,
      `email` VARCHAR( 100 ) NOT NULL ,
      `nivel` VARCHAR( 2 ) NOT NULL DEFAULT '1',
      PRIMARY KEY (`id`),
      UNIQUE KEY `usuario` (`usuario`)
  ) ENGINE=MyISAM ;

  INSERT INTO `usuarios` VALUES (NULL, 'Teste', 'teste', SHA1( 'teste'), 'usuario@teste.com.br', '1');
  INSERT INTO `usuarios` VALUES (NULL, 'Administrador', 'admin', SHA1('admin' ), 'admin@teste.com.br', 2);
  INSERT INTO `usuarios` VALUES (NULL, 'Administrador', 'poha', SHA1('123' ), 'admin@teste.com.br', 2);

  nome, valor, isqn, quant, genero, editora, author

  CREATE TABLE IF NOT EXISTS `livro` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` VARCHAR( 50 ) NOT NULL,
      `valor` VARCHAR( 25 ) NOT NULL,
      `isqn` VARCHAR( 20 ) NOT NULL,
      `quant` VARCHAR( 10 ) NOT NULL,
      `genero` VARCHAR( 50 ) NOT NULL,
      `editora` VARCHAR( 50 ) NOT NULL,
      `author` VARCHAR( 50 ) NOT NULL,
      PRIMARY KEY (`id`)
  ) ENGINE=MyISAM ;

  INSERT INTO `livro` VALUES (NULL, 'Geografia', '50', '4f5d4gf', '5', 'Academico', 'Sao Paulo', 'Wilson');
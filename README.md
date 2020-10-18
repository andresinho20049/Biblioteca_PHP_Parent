# Biblioteca B²RAFS

## Projeto academico, disciplina de "Desenvolvimento De Software Para Web".
**Topicos**
- Desenvolver aplicação utilizando PHP
- Seguir os critétios de avaliação:
1. Versão escrita 
    - Presença de informações solicitadas pelo professor; 
    - Correção gramatical; 
    - Adequação às normas da ABNT (capa, folha de rosto, sumário, introdução, desenvolvimento, conclusão, referências e anexos); 
2. Apresentação gravada 
    - Estrutura linear, coerente e organizada; 
    - Participação significativa de todos integrantes da equipe; 
    - Fala espontânea, com clareza e tom de voz adequados; 
    - Uso adequado do tempo disponível (10 min. para cada equipe).

## Pré-requisito:
Para executar essa aplicação é nescessário que você tenha o docker instalado na sua maquina.

> **Obs:**  
 É recomendavel utilizar o docker, pela facilidade de implantação, execução e desenvolvimento, porem caso queira jogar o repositório dentro da sua pasta htdocs se você utilizar o xampp ou algo do tipo, fique a disposição, mas o projeto subiu em ambiente docker no dev.


## Como executar:
1. Execute o comando:
```git
git clone https://github.com/andresinho20049/Biblioteca_PHP_Parent.git
```

2. com o projeto em sua maquina, entre no diretório raiz do projeto e execute:
```dockerfile
docker-compose up -d
```

> **Obs:**   
Ná primeira execução pode demorar um pouco, pois estara baixando as dependencias para seu ambiente.

3. Acesse localhost


*PRONTO!*


Docker é PERFEITO! Com apenas `docker-compose up` é possivel subir um *ambiente* dentre de um container na sua maquina, sem precisa se preocupar com configuração de ambiente, ou coisas do tipo, e aquela velha frase, no meu pc funciona, não existe mais.
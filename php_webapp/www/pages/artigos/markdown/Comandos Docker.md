# Docker
## Sumario
1. Dockerfile
    1. [FROM](#FROM)
	2. [RUN](#RUN)
	3. [CMD](#CMD)
	4. [LABEL](#LABEL)
	5. [EXPOSE](#EXPOSE)
	6. [ENV](#ENV)
	7. [ADD](#ADD)
	8. [COPY](#COPY)
	9. [ENTRYPOINT](#ENTRYPOINT)
	10. [VOLUME](#VOLUME)
	11. [USUÁRIO](#USUÁRIO)
	12. [WORKDIR](#WORKDIR)
	13. [ARG](#ARG)
	14. [ONBUILD](#ONBUILD)
	15. [EXEMPLOS DE DOCKERFILE](#DOCKERFILE-EXAMPLE)
	16. [COMO USAR: GUIA](#GUIA)
		1. [COMANDOS PARA O DIA A DIA](#Comandos-para-o-dia-a-dia)
		2. [LISTA DE COMANDOS](#lista-de-comandos---docker)
2. [DOCKER-COMPOSE](#DOCKER-COMPOSE)
	1. [USAR COMPOSE](##usar-compose)
	2. [ATRIBUTOS DE CONTRUÇÃO](#atributos-de-construção)
		1. [ADD](#build)
		2. [ADD](#context)
		3. [ADD](#dockerfile-1)
	3. [ARGS](#ARGS)
	4. [REDE](#REDE)
	5. [TARGET](#TARGET)
		1. [COMPILAÇÕES DE VARIOS ESTAGIOS](#use-compilações-de-vários-estágios)
		2. [NOMEIE SEUS ESTÁGIOS](#nomeie-seus-estágios-de-construção)
	6. [COMMAND](#COMMAND)
	7. [DEPENDE_ON](#Depende_on)
	8. [EXPOSE](#EXPOR)
	9. [EXTERNAL_LINKS](#EXTERNAL_LINKS)
	10. [IMAGE](#IMAGE)
	11. [PORTAS](#PORTAS)
		1. [SINTAXE CURTA](#SINTAXE-CURTA)
		2. [SINTAXE LONGA](#SINTAXE-LONGA)
	12. [COMO USAR: GUIA COMPOSE](#GUIA-COMPOSE)
		1. [LISTA DE COMANDOS](#lista-de-comandos-docker-compose)
	13. [EXEMPLOS DE DOCKER-COMPOSE.YAML](#EXEMPLOS-DOCKER-COMPOSE)
	

## Dockerfile
O Docker pode construir imagens automaticamente lendo as instruções de a Dockerfile. A Dockerfile é um documento de texto que contém todos os comandos que um usuário pode chamar na linha de comando para montar uma imagem.

**Uso:** 
O comando docker build cria uma imagem a partir de um Dockerfile e um contexto . O contexto da construção é o conjunto de arquivos em um local especificado PATH ou URL. O PATH é um diretório em seu sistema de arquivos local. O URL é um local de repositório Git.

O Docker constrói imagens automaticamente lendo as instruções de um Dockerfile um arquivo de texto que contém todos os comandos, *em ordem*, necessários para construir uma determinada imagem.

Uma imagem Docker consiste em camadas somente leitura, cada uma das quais representa uma instrução Dockerfile. As camadas são empilhadas e cada uma é um delta das alterações da camada anterior. Considere o seguinte Dockerfile: 

```dockerfile
    FROM ubuntu:18.04
    COPY . /app
    RUN make /app
    CMD python /app/app.py
```
    
**Cada instrução cria uma camada:**
- FROM cria uma camada da `ubuntu:18.04` imagem Docker.
- COPY adiciona arquivos do diretório atual do seu cliente Docker.
- RUN constrói seu aplicativo com make.
- CMD especifica qual comando executar dentro do contêiner.

Ao executar uma imagem e gerar um contêiner, você adiciona uma nova camada gravável (a “camada do contêiner”) no topo das camadas subjacentes. Todas as alterações feitas no contêiner em execução, como gravar novos arquivos, modificar arquivos existentes e excluir arquivos, são gravadas nesta camada de contêiner gravável.

Para obter mais informações sobre camadas de imagem (e como o Docker constrói e armazena imagens), [consulte Sobre drivers de armazenamento .](https://docs.docker.com/storage/storagedriver/)

COMANDO | OBJETIVO | EXEMPLO
-------- | ---------- | ------- 
From | Primeira instrução sem comentários no Dockerfile | `From Ubuntu`
Copy | Copia vários arquivos de origem do contexto para o sistema de arquivos do contêiner no caminho especificado | `COPY .bash_profile /home`
Env | Define a variável de ambiente | `ENV HOSTNAME=test`
Run | Executa um comando | `RUN apt-get update`
CMD | Padrões para um contêiner em execução | `CMD ["/bin/echo", "hello world"]`
Expose | Informa as portas de rede em que o contêiner irá escutar | `EXPOSE 8093`

### FROM
`FROM [--platform=<platform>] <image> [AS <name>]`
A `FROM` instrução inicializa um novo estágio de construção e define a imagem de base para as instruções subsequentes. Como tal, um válido Dockerfile deve começar com uma `FROM` instrução. A imagem pode ser qualquer imagem válida - é especialmente fácil começar puxando uma imagem dos [Repositórios Públicos](https://docs.docker.com/engine/tutorials/dockerrepos/).

- ARG é a única instrução que pode preceder FROMno Dockerfile. 
- `FROM` pode aparecer várias vezes em um único Dockerfile para criar *várias imagens* ou usar um estágio de construção como uma dependência para outro. Simplesmente anote a última saída de ID de imagem pelo commit antes de cada nova `FROM` instrução. Cada `FROM` instrução limpa qualquer estado criado por instruções anteriores.
- Opcionalmente, um nome pode ser dado a um novo estágio de construção adicionando `AS name` à `FROM` instrução. O nome pode ser usado nas *instruções subsequentes* `FROM` e `COPY` `--from=<name>` para se referir à imagem construída neste estágio.
- Os valores `tag` ou `digest` são opcionais. Se você omitir qualquer um deles, o construtor assume uma `latest tag` por padrão. O construtor retorna um erro se não puder localizar o `tag` valor.

### RUN 
RUN tem 2 formulários:

- `RUN <command>`( forma de shell , o comando é executado em um shell, que por padrão está `/bin/sh -c` no Linux ou `cmd /S /C` no Windows)
    - O shell padrão para a forma de shell pode ser alterado usando o `SHELL` comando.
- `RUN ["executable", "param1", "param2"]`( formulário exec )

A `RUN` instrução executará todos os comandos em uma nova camada sobre a imagem atual e confirmará os resultados. A imagem confirmada resultante será usada para a próxima etapa no Dockerfile.

Na forma de shell , você pode usar uma `\`(barra invertida) para continuar uma única instrução RUN na próxima linha. Por exemplo, considere estas duas linhas:
```DOCKERFILE
    RUN /bin/bash -c 'source $HOME/.bashrc; \
    echo $HOME'
```

Juntos, eles são equivalentes a esta única linha:

```DOCKERFILE
    RUN /bin/bash -c 'source $HOME/.bashrc; echo $HOME'
```

Para usar um shell diferente, diferente de `'/ bin / sh'`, use o formulário exec passando o shell desejado. Por exemplo:

`RUN ["/bin/bash", "-c", "echo hello"]`

> **Nota**    
> O formulário exec é analisado como uma matriz JSON, o que significa que você deve usar aspas duplas (“) ao redor das palavras, não aspas simples (').

O cache para RUNinstruções não é invalidado automaticamente durante a próxima compilação. O cache para uma instrução como RUN apt-get dist-upgrade -yserá reutilizado durante a próxima construção. O cache para RUNinstruções pode ser invalidado usando o --no-cache sinalizador, por exemplo docker build --no-cache.

Divida `RUN` instruções longas ou complexas em várias linhas separadas por barras invertidas para torná Dockerfile-las mais legíveis, compreensíveis e fáceis de manter.

**APT-GET**
Provavelmente, o caso de uso mais comum para `RUN` é um aplicativo de `apt-get`. Como ele instala pacotes, o `RUN apt-get` comando tem várias dicas a serem observadas.

Evite `RUN apt-get upgrade` e `dist-upgrade`, como muitos dos pacotes "essenciais" das imagens pai não podem atualizar dentro de um contêiner sem privilégios . Se um pacote contido na imagem pai estiver desatualizado, entre em contato com seus mantenedores. Se você souber que existe um pacote específico foo, que precisa ser atualizado, use `apt-get install -y foo` para atualizar automaticamente.

Sempre combine `RUN apt-get update` com `apt-get install` na mesma `RUN` afirmação. Por exemplo:

```DOCkERFILE
RUN apt-get update && apt-get install -y \
package-bar \
package-baz \
package-foo
```
Usar `apt-get update` sozinho em uma `RUN` instrução causa **problemas de cache** e as `apt-get install` instruções subsequentes *falham*
```DOCKERFILE
RUN apt-get update && apt-get install -y \
    aufs-tools \
    automake \
    build-essential \
    curl \
    dpkg-sig \
    libcap-dev \
    libsqlite3-dev \
    mercurial \
    reprepro \
    ruby1.9.1 \
    ruby1.9.1-dev \
    s3cmd=1.1.* \
 && rm -rf /var/lib/apt/lists/*
```

### CMD
A `CMD` instrução tem três formas:
- CMD ["executable","param1","param2"]( formulário exec , este é o formulário preferido)
- CMD ["param1","param2"](como parâmetros padrão para ENTRYPOINT )
- CMD command param1 param2( forma de concha )

Só pode haver uma `CMD` instrução em a Dockerfile. Se você listar mais de um CMD , apenas o último `CMD` terá efeito.

O objetivo principal de a `CMD` é fornecer padrões para um contêiner em execução. Esses padrões podem incluir um executável ou omitir o executável. Nesse caso, você também deve especificar uma ENTRYPOINT instrução.

Se `CMD` for usado para fornecer argumentos padrão para a `ENTRYPOINT` instrução, as instruções `CMD` e `ENTRYPOINT` devem ser especificadas com o formato de matriz JSON.

### LABEL 
`LABEL <key>=<value> <key>=<value> <key>=<value> ...`
A `LABEL` instrução adiciona metadados a uma imagem. A `LABEL` é um par de valores-chave. Para incluir espaços dentro de um `LABEL` valor, use aspas e barras invertidas como faria na análise de linha de comando. Alguns exemplos de uso:
```DOCKERFILE
LABEL "com.example.vendor"="ACME Incorporated"
LABEL com.example.label-with-value="foo"
LABEL version="1.0"
LABEL description="This text illustrates \
that label-values can span multiple lines."
```

Uma imagem pode ter mais de um rótulo. Você pode especificar vários rótulos em uma única linha. Antes do Docker 1.10, isso diminuía o tamanho da imagem final, mas não é mais o caso. Você ainda pode escolher especificar vários rótulos em uma única instrução, de uma das seguintes maneiras:
```DOCKERFILE
LABEL multi.label1="value1" multi.label2="value2" other="value3"
LABEL multi.label1="value1" \
      multi.label2="value2" \
      other="value3"
```

Os rótulos incluídos nas imagens de base ou pai (imagens na `FROM` linha) são herdados por sua imagem. Se já existir um rótulo, mas com um valor diferente, o valor aplicado mais recentemente substituirá qualquer valor definido anteriormente.

Para ver os rótulos de uma imagem, use o `docker image inspect` comando. Você pode usar a `--format` opção de mostrar apenas os rótulos;

```CMD
docker image inspect --format='' myimage
{
  "com.example.vendor": "ACME Incorporated",
  "com.example.label-with-value": "foo",
  "version": "1.0",
  "description": "This text illustrates that label-values can span multiple lines.",
  "multi.label1": "value1",
  "multi.label2": "value2",
  "other": "value3"
}
```

### EXPOSE 
`EXPOSE <port> [<port>/<protocol>...]`
A `EXPOSE` instrução informa ao Docker que o contêiner escuta nas portas de rede especificadas no tempo de execução. Você pode especificar se a porta escuta em TCP ou UDP e o padrão é TCP se o protocolo não for especificado.

A `EXPOSE` instrução não publica realmente a porta. Funciona como uma espécie de documentação entre quem constrói a imagem e quem administra o container, sobre quais portas se pretende publicar. Para realmente publicar a porta ao executar o contêiner, use o `-p` sinalizador `docker run` para publicar e mapear uma ou mais portas, ou o `-P` sinalizador para publicar todas as portas expostas e mapeá-las para portas de alta ordem.

Independentemente das `EXPOSE` configurações, você pode substituí-las no tempo de execução usando o `-p` sinalizador. Por exemplo
`docker run -p 80:80/tcp`

### ENV 
- `ENV <key> <value>`
- `ENV <key>=<value> ...`

A `ENV` instrução define a variável de ambiente `<key>` para o valor `<value>`. Esse valor estará no ambiente para todas as instruções subsequentes no estágio de construção e também pode ser substituído sequencialmente em muitas.

### ADD
ADD tem duas formas:
- `ADD [--chown=<user>:<group>] <src>... <dest>`
- `ADD [--chown=<user>:<group>] ["<src>",... "<dest>"]`

O último formulário é necessário para caminhos que contêm espaços em branco.

A `ADD` instrução copia novos arquivos, diretórios ou URLs de arquivos remotos `<src>` e os adiciona ao sistema de arquivos da imagem no caminho `<dest>`

### COPY 
O COPY tem dois formulários:
- `COPY [--chown=<user>:<group>] <src>... <dest>`
- `COPY [--chown=<user>:<group>] ["<src>",... "<dest>"]`

Este último formulário é necessário para caminhos que contêm espaços em branco.

A `COPY` instrução copia novos arquivos ou diretórios `<src>` e os adiciona ao sistema de arquivos do contêiner no caminho `<dest>`.

Vários `<src>` recursos podem ser especificados, mas os caminhos dos arquivos e diretórios serão interpretados como relativos à origem do contexto da construção.

Cada um `<src>` pode conter curingas e a correspondência será feita usando as regras de caminho de `arquivo.Match` de `Go`. Por exemplo:

Para adicionar todos os arquivos começando com “hom”:
```DOCKERFILE
COPY hom* /mydir/
```

No exemplo abaixo, ?é substituído por qualquer caractere único, por exemplo, “home.txt”.
```DOCKERFILE
COPY hom?.txt /mydir/
```
O `<dest>` é um caminho absoluto ou relativo ao `WORKDIR` qual a origem será copiada dentro do contêiner de destino.

O exemplo abaixo usa um caminho relativo e adiciona `“test.txt”` a `<WORKDIR>/relativeDir/`:
```DOCKERFILE
COPY test.txt relativeDir/
```

Considerando que este exemplo usa um caminho absoluto e adiciona `“test.txt”` para `/absoluteDir/`
```DOCKERFILE
COPY test.txt /absoluteDir/
```

### ENTRYPOINT 
ENTRYPOINT tem dois formulários:
- O formulário exec , que é o formulário preferencial: `ENTRYPOINT ["executable", "param1", "param2"]`
- A forma de concha : `ENTRYPOINT command param1 param2`

Um `ENTRYPOINT` permite que você configure um contêiner que será executado como um executável.

Por exemplo, o seguinte inicia o nginx com seu conteúdo padrão, ouvindo na porta 80:
```CMD
$ docker run -i -t --rm -p 80:80 nginx
```
Os argumentos da linha de comando para docker run `<image>` serão acrescentados após todos os elementos em um formulário exec `ENTRYPOINT` e substituirão todos os elementos especificados usando `CMD`. Isso permite que os argumentos sejam passados para o ponto de entrada, ou seja, `docker run <image> -d` passará o `-d` argumento para o ponto de entrada. Você pode substituir a `ENTRYPOINT` instrução usando o `docker run --entrypoint` sinalizador.

O shell forma impede que qualquer `CMD` ou `run` de linha de comando argumentos de serem usados, mas tem a desvantagem de que o seu `ENTRYPOINT` será iniciado como um subcomando de `/bin/sh -c`, que não passa sinais. Isso significa que o executável não será o contêiner PID 1- e não receberá sinais do Unix - portanto, seu executável não receberá um `SIGTERM` de `docker stop <container>`.

Apenas a última `ENTRYPOINT` instrução do `Dockerfile` terá efeito.

### VOLUME      
`VOLUME ["/data"]`
A `VOLUME` instrução cria um ponto de montagem com o nome especificado e o marca como contendo volumes montados externamente do host nativo ou outros contêineres. O valor pode ser uma matriz `JSON VOLUME ["/var/log/"]`, ou uma string simples com vários argumentos, como `VOLUME /var/log` ou `VOLUME /var/log /var/db`. Para obter mais informações / exemplos e instruções de montagem por meio do cliente Docker, consulte a documentação [Compartilhar diretórios por meio de volumes](https://docs.docker.com/storage/volumes/).

O `docker run` comando inicializa o volume recém-criado com todos os dados existentes no local especificado na imagem base. 

### USUÁRIO    
`USER <user>[:<group>]`
ou
`USER <UID>[:<GID>]`

A `USER` instrução define o nome do usuário (ou UID) e, opcionalmente, o grupo de usuários (ou GID) a ser usado ao executar a imagem e para qualquer um `RUN, CMD` e as `ENTRYPOINT` instruções que o seguem no Dockerfile.

Observe que, ao especificar um grupo para o usuário, o usuário terá apenas a associação de grupo especificada. Quaisquer outras associações de grupo configuradas serão ignoradas.

> **Aviso**    
> Quando o usuário não tem um grupo primário, a imagem (ou as próximas instruções) será executada com o `root` grupo.   
> No Windows, o usuário deve ser criado primeiro se não for uma conta interna. Isso pode ser feito com o `net user` comando chamado como parte de um Dockerfile.

```DOCKERFILE
FROM microsoft/windowsservercore
# Create Windows user in the container 
RUN net user /add patrick
# Set it for subsequent commands
USER patrick
```

### WORKDIR     
`WORKDIR /path/to/workdir`
A `WORKDIR` instrução define o diretório de trabalho para quaisquer `RUN, CMD, ENTRYPOINT, COPY e ADD` instruções que o seguem no Dockerfile. Se `WORKDIR` não existir, ele será criado mesmo se não for usado em nenhuma Dockerfile instrução subsequente .

A `WORKDIR` instrução pode ser usada várias vezes em a Dockerfile. Se um caminho relativo for fornecido, ele será relativo ao caminho da `WORKDIR` instrução anterior . Por exemplo:
```DOCKERFILE
WORKDIR /a
WORKDIR b
WORKDIR c
RUN pwd
```

A saída do `pwd` comando final Dockerfile seria `/a/b/c`.

A `WORKDIR` instrução pode resolver variáveis de ambiente previamente definidas usando ENV. Você só pode usar variáveis de ambiente explicitamente definidas no Dockerfile. Por exemplo:

```DOCKERFILE
ENV DIRPATH /path
WORKDIR $DIRPATH/$DIRNAME
RUN pwd
```
A saída do `pwd` comando final neste Dockerfile seria `/path/$DIRNAME`

### ARG 
`ARG <name>[=<default value>]`
A `ARG` instrução define uma variável que os usuários podem passar no momento da construção para o construtor com o `docker build` comando usando o `--build-arg <varname>=<value>` sinalizador. Se um usuário especificar um argumento de construção que não foi definido no Dockerfile, a construção emitirá um aviso.

```CMD
[Warning] One or more build-args [foo] were not consumed.
```
Um Dockerfile pode incluir uma ou mais `ARG` instruções. Por exemplo, o seguinte é um Dockerfile válido:
```DOCKERFILE
FROM busybox
ARG user1
ARG buildno
# ...
```

> **Aviso:**      
> Não é recomendado usar variáveis de tempo de construção para passar segredos como chaves do github, credenciais de usuário, etc. Os valores das variáveis de tempo de construção são visíveis para qualquer usuário da imagem com o docker historycomando.  
>Consulte a seção [“construir imagens com BuildKit”](https://docs.docker.com/develop/develop-images/build_enhancements/#new-docker-build-secret-information) para aprender sobre maneiras seguras de usar segredos ao construir imagens.

**Valores padrão** 
Uma `ARG` instrução pode incluir opcionalmente um valor padrão:
```DOCKERFILE
FROM busybox
ARG user1=someuser
ARG buildno=1
# ...
```
Se uma `ARG` instrução tiver um valor padrão e nenhum valor for passado no momento da construção, o construtor usará o *padrão*.

**ARGs predefinidos** 
O Docker tem um conjunto de `ARG` variáveis predefinidas que você pode usar sem uma `ARG` instrução correspondente no Dockerfile.
- HTTP_PROXY
- http_proxy
- HTTPS_PROXY
- https_proxy
- FTP_PROXY
- ftp_proxy
- NO_PROXY
- no_proxy

Para usá-los, basta passá-los na linha de comando usando a sinalização:
`--build-arg <varname>=<value>`

### ONBUILD   
`ONBUILD <INSTRUCTION>`
A `ONBUILD` instrução adiciona à imagem uma instrução de gatilho para ser executada posteriormente, quando a imagem for usada como base para outra construção. O gatilho será executado no contexto do `build` downstream, como se tivesse sido inserido imediatamente após a `FROM` instrução no downstream Dockerfile.
Qualquer instrução de construção pode ser registrada como um gatilho.

Isso é útil se você estiver construindo uma imagem que será usada como base para construir outras imagens, por exemplo, um ambiente de construção de aplicativo ou um daemon que pode ser personalizado com configuração específica do usuário.

### DOCKERFILE EXAMPLE:
```DOCKERFILE
FROM openjdk:8

ARG PROFILE
ARG ADDITIONAL_OPTS

ENV PROFILE=${PROFILE}
ENV ADDITIONAL_OPTS=${ADDITIONAL_OPTS}

WORKDIR /opt/spring_boot

COPY /target/spring-boot*.jar spring_boot_com_mysql.jar

SHELL ["/bin/sh", "-c"]

EXPOSE 5005
EXPOSE 8080

CMD java ${ADDITIONAL_OPTS} -jar spring_boot_com_mysql.jar --spring.profiles.active=${PROFILE}
```

```DOCKERFILE
FROM php:7.4.1-apache
LABEL mantainer="rodrigorahman@gmail.com"

RUN buildDeps=" \
        default-libmysqlclient-dev \
        libbz2-dev \
        libmemcached-dev \
        libsasl2-dev \
    " \
    runtimeDeps=" \
        curl \
        git \
        libfreetype6-dev \
        libicu-dev \
        libjpeg-dev \
        libldap2-dev \
        libmemcachedutil2 \
        libpng-dev \
        libpq-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
    " \
    && apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y $buildDeps $runtimeDeps \
    && docker-php-ext-install bcmath bz2 calendar iconv intl mbstring mysqli opcache pdo_mysql pdo_pgsql pgsql soap zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap \
    && docker-php-ext-install exif \
    && pecl install memcached redis \
    && docker-php-ext-enable memcached.so redis.so \
    && apt-get purge -y --auto-remove $buildDeps \
    && rm -r /var/lib/apt/lists/* \
    && a2enmod rewrite

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer

ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1
```

### Guia
Contruir e executar contêiner:
1. Contruir contêiner:
    - Dockfile local: `docker build -t <name_tag> .` 
    - Dockfile URL: `docker build -t <name_tag> github.com/creack/docker-firefox`
2. Executar imagem como contêiner
    - Ex 1: `docker run [OPTIONS] IMAGE [COMMAND] [ARG...]`
    - Ex 2: `docker run -d -p 8080:8080 --name <name> <id or name container>`
3. Parar e Remover contêiner 
    - Stop: `docker stop <the-container-id>`
    - Remover após parar: `docker rm <the-container-id>`
    > Você pode parar e remover um contêiner em um único comando   
    `docker rm -f <the-container-id>`
4. Docker Hub
    1. Faça login: `docker login -u andresinho200498 .`
    2. Nomear imagem: `docker tag <nome_tag> <id or name container>/<repository>`
    3. Executar push: `docker push andresinho200498/<repository>`
    > **Testar no Play Docker:**
    1. [Acessar link](http://play-with-docker.com/)
    2. Exec RUN comando: `docker run -dp 3000:3000 andresinho200498/<repository>`


#### Comandos para o dia a dia  
- `docker version` - Retorna versão do client docker
- `docker images` - Retorna lista das images que temos no host
- `docker pull (parametro)` - Dowload de imagem
- `docker ps` - Retorna contêineres em execução / use `-a` para retorna todos
- `docker status <id-Container>` - Retorna informações do container
- `docker exec <id-Container>` - Executar comando dentro da docker
    - Exemplo criar pasta: `docker exec <id-Container> mkdir /nova_pasta/` 
- `docker exec -it <id-Container> /bin/bash` - Acessar terminal da docker
- `docker attach <id-Container>` - Acessar terminal com acesso root do container

#### Lista de Comandos - Docker:
- docker attach  – Acessar dentro do container e trabalhar a partir dele.
- docker build   – A partir de instruções de um arquivo Dockerfile eu possa criar uma imagem.
    - -f – file(Especificar path/nome do Dockerfile - Pradão ./Dockerfile)
    - --no-cache - Não utilizar cache no building da image
    - -t – Tag, especificar nome
- docker commit  – Cria uma imagem a partir de um container.
- docker cp      – Copia arquivos ou diretórios do container para o host.
- docker create  – Cria um novo container.
- docker diff    – Exibe as alterações feitas no filesystem do container.
- docker events  – Exibe os eventos do container em tempo real.
- docker exec    – Executa uma instrução dentro do container que está rodando sem - precisar atachar nele.
    - `--interactive` , `-i` – Mantenha o STDIN aberto, mesmo se não estiver conectado
    - `--tty` , `-t` – Alocar um pseudo-TTY
- docker export  – Exporta um container para um arquivo .tar.
- docker history – Exibe o histórico de comandos que foram executados dentro do container.
- docker images  – Lista as imagens disponíveis no host.
- docker import  – Importa uma imagem .tar para o host.
- docker info    – Exibe as informações sobre o host.
- docker inspect – Exibe r o json com todas as configurações do container.
- docker kill    – Da Poweroff no container.
- docker load    – Carrega a imagem de um arquivo .tar.
- docker login   – Registra ou faz o login em um servidor de registry.
- docker logout  – Faz o logout de um servidor de registry.
- docker logs    – Exibe os logs de um container.
- docker port    – Abre uma porta do host e do container.
- docker network – Gerenciamento das redes do Docker.
- docker node    – Gerenciamento dos nodes do Docker Swarm.
- docker pause   – Pausa o container.
- docker port    – Lista as portas mapeadas de um container.
- docker ps      – Lista todos os containers.
- docker pull    – Faz o pull de uma imagem a partir de um servidor de registry.
- docker push    – Faz o push de uma imagem a partir de um servidor de registry.
- docker rename  – Renomeia um container existente.
- docker restart – Restarta um container que está rodando ou parado.
- docker rm      – Remove um ou mais containeres.
    - `-f` – parar e remover um contêiner em um único comando, adicionando o sinalizador "force"
- docker rmi     – Remove uma ou mais imagens.
- docker run     – Executa um comando em um novo container.
    - `--detach` , `-d` – Execute o recipiente em segundo plano e imprima o ID do recipiente
    - `--env` , `-e` – Definir variáveis de ambiente
    - `--hostname` , `-h` – Nome do host do contêiner
    - `--link` – Adicionar link a outro contêiner
    - `--publish` , `-p` – Publica a (s) porta (s) de um contêiner para o host
    - `--publish-all` , `-P` – Publique todas as portas expostas em portas aleatórias
- docker save    – Salva a imagem em um arquivo .tar.
- docker search  – Procura por uma imagem no Docker Hub.
- docker service – Gernciamento dos serviços do Docker.
- docker start   – Inicia um container que esteja parado.
- docker stats   – Exibe informações de uso de CPU, memória e rede.
- docker stop    – Para um container que esteja rodando.
- docker swarm   – Clusterização das aplicações em uma orquestração de várias containers, aplicações junto.
- docker tag     – Coloca tag em uma imagem para o repositorio.
- docker top     – Exibe os processos rodando em um container.
- docker unpause – Inicia um container que está em pause.
- docker update  – Atualiza a configuração de um ou mais containers.
- docker version – Exibe as versões de API, Client e Server do host.
- docker volume  – Gerenciamento dos volumes no Docker.
- docker wait    – Aguarda o retorno da execução de um container para iniciar esse container.


## DOCKER-COMPOSE
Docker Compose é o orquestrador de containers da Docker. E como funciona um orquestrador em uma orquestra? Ele rege como uma banda deve se comportar/tocar durante uma determinada apresentação ou música.

Com o Docker Compose é a mesma coisa, mas os maestros somos nós! Nós que iremos reger esse comportamento através do arquivo chamado docker-compose, semelhante ao Dockerfile, escrito em YAML

#### O Compose File* 
Nesse arquivo Compose que mencionei no início do texto, descrevemos a infraestrutura como código e como ela vai se comportar ao ser iniciado. Se digo que preciso de um banco de dados para rodar minha aplicação Java/Php, descrevo isso no meu Compose e digo que minha aplicação depende do meu container de banco de dados MySQL para rodar.

Outra coisa legal, é que podemos definir o comportamento que o Docker vai ter caso um dos containers venha a falhar. Descrevo no Compose que, caso o banco de dados falhe por algum motivo, o Docker que suba outro imediatamente. Consigo isolar essas aplicações em uma rede separada e quais volumes essas aplicações vão utilizar para persistir os dados. Vamos subir todos esses serviços descritos no Compose com apenas um comando.

#### O que consigo fazer no Compose?
Outro ponto interessante para comentar, são as variáveis de ambiente, podemos configurar no Compose usando o environment, passando as variáveis que serão usadas por nossa aplicação em determinado ambiente, quando os serviços estiverem subindo.

No caso do banco de dados em nosso exemplo, passamos o host, porta, usuário e senha do banco de dados que o WordPress vai usar para poder instalar e depois funcionar.

Em resumo, utilizando o Docker Compose, em vez de o administrador executar o docker run na mão para cada container e subir os serviços separados, linkando os containers das aplicações manualmente, temos um único arquivo que vai fazer essa orquestração e vai subir os serviços/containers de uma só vez. Isso diminui a responsabilidade do Sysadmin ou do desenvolvedor de ter que gerenciar o deploy e se preocupar em rodar todos esses comandos para ter a sua aplicação rodando com todas as suas dependências.

### Usar Compose
Usar o Compose é basicamente um processo de três etapas:

1. Defina o ambiente do seu aplicativo com um `Dockerfile` para que possa ser reproduzido em qualquer lugar.
2. Defina os serviços que compõem seu aplicativo `docker-compose.yml` para que possam ser executados juntos em um ambiente isolado.
3. Execute `docker-compose up` e Compose constroi e executa todo o seu aplicativo.

### Atributos de contrução
#### Build 
Opções de configuração que são aplicadas no momento da construção.

`build` pode ser especificado como uma string contendo um caminho para o contexto de construção:
```YAML
version: "3.8"
services:
  webapp:
    build: ./dir
```
Ou, como um objeto com o caminho especificado em contexto e, opcionalmente, Dockerfile e args:
```YAML
version: "3.8"
services:
  webapp:
    build:
      context: ./dir
      dockerfile: Dockerfile
      args:
        buildno: 1
```
Se você especificar `image` bem como `build`, Compose nomeia a imagem construída com `webapp` e opcional `tag` especificado em `image`:
```YAML
build: ./dir
image: webapp:tag
```
Isso resulta em uma imagem nomeada `webapp` e marcada `tag`, construída a partir de `./dir`.

#### CONTEXT
Um caminho para um diretório contendo um `Dockerfile` ou um url para um repositório git.

Quando o valor fornecido é um caminho relativo, ele é interpretado como relativo à localização do arquivo Compose. Este diretório também é o contexto de construção que é enviado ao daemon do Docker.

O Compose o constrói e marca com um nome gerado e usa essa imagem depois disso.
```YAML
build:
  context: ./dir
```
#### DOCKERFILE
Dockerfile alternativo.
O Compose usa um arquivo alternativo para construir. Um caminho de construção também deve ser especificado.
```YAML
build:
  context: .
  dockerfile: Dockerfile-alternate
``` 
  
### ARGS
Adicione argumentos de construção, que são variáveis de ambiente acessíveis apenas durante o processo de construção.

Primeiro, especifique os argumentos em seu Dockerfile:
```YAML
ARG buildno
ARG gitcommithash

RUN echo "Build number: $buildno"
RUN echo "Based on commit: $gitcommithash"
```
Em seguida, especifique os argumentos na `build` chave. Você pode passar um mapeamento ou uma lista:
```YAML
build:
  context: .
  args:
    buildno: 1
    gitcommithash: cdc3b19
build:
  context: .
  args:
    - buildno=1
    - gitcommithash=cdc3b19
```

### REDE
>Adicionado no formato de arquivo da versão 3.4

Defina os contêineres de rede aos quais se conectar para obter as `RUN` instruções durante a construção.
```YAML
build:
  context: .
  network: host
build:
  context: .
  network: custom_network_1
 ```

Use nonepara desativar a rede durante a construção:
```YAML
build:
  context: .
  network: none
```

### TARGET
> Adicionado no formato de arquivo da versão 3.4

Construa o estágio especificado conforme definido dentro do Dockerfile. 
```YAML
build:
  context: .
  target: prod
```

#### Use compilações de vários estágios 
Com compilações de vários estágios, você usa várias `FROM` instruções em seu Dockerfile. Cada `FROM` instrução pode usar uma base diferente e cada uma delas inicia um novo estágio da construção. Você pode copiar artefatos seletivamente de um estágio para outro, deixando para trás tudo o que você não deseja na imagem final. Para mostrar como isso funciona, vamos adaptar o Dockerfile da seção anterior para usar compilações de vários estágios.

**Dockerfile:**
```DOCKERFILE
FROM golang:1.7.3
WORKDIR /go/src/github.com/alexellis/href-counter/
RUN go get -d -v golang.org/x/net/html  
COPY app.go .
RUN CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o app .

FROM alpine:latest  
RUN apk --no-cache add ca-certificates
WORKDIR /root/
COPY --from=0 /go/src/github.com/alexellis/href-counter/app .
CMD ["./app"]  
```
Você só precisa de um único Dockerfile. Você também não precisa de um `script` de construção separado. Apenas execute `docker build`.

```CMD
docker build -t alexellis2/href-counter:latest .
```
O resultado final é a mesma imagem de produção minúscula de antes, com uma redução significativa na complexidade. Você *não* precisa criar nenhuma imagem intermediária e não precisa extrair nenhum artefato para o seu sistema local.

**Como funciona?** A segunda `FROM` instrução inicia um novo estágio de construção com a `alpine:latest` imagem como base. A `COPY --from=0` linha copia apenas o artefato construído do estágio anterior para este novo estágio. O `Go SDK` e quaisquer artefatos intermediários são deixados para trás e não são salvos na imagem final.

#### Nomeie seus estágios de construção 
Por padrão, os estágios não são nomeados e você se refere a eles por seu número inteiro, começando com 0 para a primeira `FROM` instrução. No entanto, você pode nomear seus estágios, adicionando um `AS <NAME>` à `FROM` instrução. Este exemplo melhora o anterior nomeando os estágios e usando o nome na `COPY` instrução. Isso significa que, mesmo que as instruções em seu Dockerfile sejam reordenadas posteriormente, o `COPY` *não falha*.
```DOCKERFILE
FROM golang:1.7.3 AS builder
WORKDIR /go/src/github.com/alexellis/href-counter/
RUN go get -d -v golang.org/x/net/html  
COPY app.go    .
RUN CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o app .

FROM alpine:latest  
RUN apk --no-cache add ca-certificates
WORKDIR /root/
COPY --from=builder /go/src/github.com/alexellis/href-counter/app .
CMD ["./app"] 
```

### COMMAND  
Substitua o comando padrão.
```YAML
command: bundle exec thin -p 3000
```
O comando também pode ser uma lista, de maneira semelhante ao CMD dockerfile:
```YAML
command: ["bundle", "exec", "thin", "-p", "3000"]
```

### Depende_on 
Dependência expressa entre serviços. Dependências de serviço causam os seguintes comportamentos:

- `docker-compose up` inicia serviços em ordem de dependência. No exemplo a seguir, `db` e `redis` são iniciados antes `web`.
- `docker-compose up SERVICE` inclui automaticamente `SERVICE` as dependências de. No exemplo abaixo, `docker-compose up web` também cria e inicia `db` e `redis`.
`docker-compose stop` interrompe os serviços em ordem de dependência. No exemplo a seguir, `web` é interrompido antes de `db` e `redis`.
Exemplo simples:
```YAML
version: "3.8"
services:
  web:
    build: .
    depends_on:
      - db
      - redis
  redis:
    image: redis
  db:
    image: postgres
```

### expor 
Exponha as portas sem publicá-las na máquina host - elas estarão acessíveis apenas para serviços vinculados. Apenas a porta interna pode ser especificada.
```YAML
expose:
  - "3000"
  - "8000"
```

### external_links 
Link para contêineres iniciados fora deste `docker-compose.yml` ou mesmo fora do Compose, especialmente para contêineres que fornecem serviços compartilhados ou comuns. `external_links` siga a semântica semelhante à opção legado `link` sao especificar o nome do contêiner e o alias do link ( CONTAINER:ALIAS).
```YAML
external_links:
  - redis_1
  - project_db_1:mysql
  - project_db_1:postgresql
```

### image  
Especifique a imagem a partir da qual iniciar o contêiner. Pode ser um repositório / tag ou um ID de imagem parcial.
```YAML
image: redis
image: ubuntu:18.04
image: tutum/influxdb
image: example-registry.com:4000/postgresql
image: a4bc65fd
```
Se a imagem não existir, o Compose tenta puxá-la, a menos que você também tenha especificado `build`, caso em que ele a constrói usando as opções especificadas e a marca com a tag especificada.

### Portas 
Exponha portas.
> Nota  
O mapeamento da porta é incompatível com network_mode: host

- **SINTAXE CURTA**
Especifique ambas as portas ( HOST:CONTAINER) ou apenas a porta do contêiner (uma porta de host efêmera é escolhida).
    ```YAML
    ports:
      - "3000"
      - "3000-3005"
      - "8000:8000"
      - "9090-9091:8080-8081"
      - "49100:22"
      - "127.0.0.1:8001:8001"
      - "127.0.0.1:5000-5010:5000-5010"
      - "6060:6060/udp"
      - "12400-12500:1240"
    ```
- **SINTAXE LONGA**
A sintaxe da forma longa permite a configuração de campos adicionais que não podem ser expressos na forma curta.
    - target: a porta dentro do contêiner
    - published: a porta exposta publicamente
    - protocol: o protocolo da porta ( `tcp` ou `udp`)
    - mode: `host` para publicar uma porta de host em cada nó, ou `ingress` para uma porta de modo `swarm` ter balanceamento de carga.
    ```YAML
    ports:
      - target: 80
        published: 8080
        protocol: tcp
        mode: host
    ```
> **Nota**
Ao mapear portas no `HOST:CONTAINER` formato, você pode ter resultados errôneos ao usar uma porta de contêiner inferior a 60, porque YAML analisa os números no formato `xx:yy` como um valor de base 60. Por esse motivo, recomendamos sempre especificar explicitamente seus mapeamentos de porta como strings.

### Guia compose
Criar e executar Docker compose:
1. Construir containeres
    - `docker-compose up`
    - `docker-compose up --build --force-recreate` - Caso precise recriar as imagens
2. listar containeres
    - `docker-compose ps`
3. Interromper e parar containeres
    - `docker-compose down`

### Lista de comandos docker-compose
Comando	|	Objetivo
------- | ---------
`build`	|	Construir ou reconstruir serviços
`help`	|	Obtenha ajuda em um comando 
`kill`	|	Mate os contêineres
`logs`	|	Ver a saída de contêineres
`port`	|	Imprima a porta pública para uma ligação de porta
`ps`	|	Contêineres de lista
`pull`	|	Puxa imagens de serviço
`restart`|	Reiniciar serviços
`rm`	|	Remover recipientes parados
`run`	|	Execute um comando único
`scale`	|	Defina o número de contêineres para um serviço
`start`	|	Iniciar serviços
`stop`	|	Parar serviços
`up`		|	Criar e iniciar contêineres

> **Dica ao usar valores booleanos**  
Valores booleanos YAML ( "true", "false", "yes", "no", "on", "off") deve estar entre aspas, para que os interpreta analisador los como strings.

### Exemplos Docker-Compose
```YAML
version: '3'

services:
   db:
     image: mysql:5.7
     volumes:
       - db_data:/var/lib/mysql
     restart: always
     environment:
       MYSQL_ROOT_PASSWORD: wordpress
       MYSQL_DATABASE: wordpress
       MYSQL_USER: wordpress
       MYSQL_PASSWORD: wordpress

   wordpress:
     depends_on:
       - db
     image: wordpress:latest
     ports:
       - "8000:80"
     restart: always
     environment:
       WORDPRESS_DB_HOST: db:3306
       WORDPRESS_DB_USER: wordpress
       WORDPRESS_DB_PASSWORD: wordpress
volumes:
    db_data:
```

```YAML
version: '3'
services:
  php-server:
    build:
       context: ./
       dockerfile: Dockerfile
    volumes:
      - ./projetoPHP:/var/www/html
    ports:
      - "80:80"
    links:
      - db
  db:
    image: mysql:5.6
    ports:
      - "3306:3306"
    environment:
      - MYSQL_ROOT_HOST=%
      - MYSQL_DATABASE=banco-mysql
      - MYSQL_USER=root
      - MYSQL_ALLOW_EMPTY_PASSWORD=yes
    volumes:
      - ./docker/mysql_volume:/var/lib/mysql
```
```yaml
version: '3'
services:
  spring_boot_com_mysql:
    build:
      context: ./
      dockerfile: ./Dockerfile
    image: spring_boo_com_mysql/api
    ports:
      - '8080:8080'
      - '5005:5005'
    environment:
      - ADDITIONAL_OPTS=-agentlib:jdwp=transport=dt_socket,server=y,suspend=n,address=*:5005 -Xmx1G -Xms128m -XX:MaxMetaspaceSize=128m
      - PROFILE=dev
    links:
      - db
  db:
    image: mysql:5.6
    ports:
      - '3306:3306'
    environment:
      - MYSQL_ROOT_HOST=%
      - MYSQL_DATABASE=spring_boot_mysql
      - MYSQL_USER=root
      - MYSQL_ALLOW_EMPTY_PASSWORD=yes
    volumes:
      - ./docker/volume_mysql:/var/lib/mysql
```
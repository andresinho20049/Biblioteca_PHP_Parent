# Implantando contêineres Docker no Azure
## Execute contêineres Docker em ACI 
O Docker não só executa contêineres localmente, mas também permite que os desenvolvedores implantem contêineres Docker perfeitamente na ACI usando docker runou implantem aplicativos multi-contêiner definidos em um arquivo Compose usando o docker compose upcomando.

As seções a seguir contêm instruções sobre como implantar seus contêineres Docker na ACI.

### Faça login no Azure
Execute os seguintes comandos para fazer logon no Azure:
```CMD
docker login azure
```

### Crie um contexto ACI
Depois de fazer login, você precisa criar um contexto Docker associado à ACI para implantar contêineres na ACI. Por exemplo, vamos criar um novo contexto chamado `myacicontext:`
```CMD
docker context create aci myacicontext
```
Este comando usa automaticamente suas credenciais de logon do Azure para identificar suas IDs de assinatura e grupos de recursos. Você pode então selecionar interativamente a assinatura e o grupo que deseja usar. Se preferir, você pode especificar essas opções no CLI usando as seguintes bandeiras: `--subscription-id`, `--resource-group`, e `--location`.

Se você não tiver nenhum grupo de recursos existente em sua conta do Azure, o `docker context create aci myacicontext` comando criará um para você. Você não precisa especificar nenhuma opção adicional para fazer isso.

Depois de criar um contexto ACI, você pode listar seus contextos do Docker executando o `docker context ls` comando:

> **Nota**  
> Se você precisar alterar a assinatura e criar um novo contexto, deverá executar o docker login azurecomando novamente.

### Execute um contêiner 
Agora que você efetuou login e criou um contexto ACI, pode começar a usar comandos Docker para implantar contêineres na ACI.

Existem duas maneiras de usar seu novo contexto ACI. Você pode usar o `--context` sinalizador com o comando Docker para especificar que gostaria de executar o comando usando o contexto ACI recém-criado.
```CMD
docker --context myacicontext run -p 80:80 nginx
```
Ou você pode alterar o contexto usando `docker context use` para selecionar o contexto ACI a ser **seu foco para a execução de comandos do Docker**. 
Por exemplo, podemos usar o `docker context use` comando para implantar um contêiner ngnix:
```CMD
docker context use myacicontext
docker run -p 80:80 nginx
```
Depois de alternar para o `myacicontext` contexto, você pode usar `docker ps` para listar seus contêineres em execução na ACI.

**Para parar e remover um contêiner do ACI, execute:**
- `docker stop <CONTAINER_ID>`
- `docker rm <CONTAINER_ID>`

### Executando aplicativos Compose 
Você também pode implantar e gerenciar aplicativos de vários contêineres definidos em Compose files to ACI usando o `docker compose` comando. Para fazer isso:

Certifique-se de estar usando seu contexto ACI. Você pode fazer isso especificando o `--context myacicontext` sinalizador ou definindo o contexto padrão usando o comando `docker context use myacicontext`.

Execute `docker compose up` e `docker compose down` para iniciar e interromper um aplicativo Compose completo.

Por padrão, `docker compose up` usa o `docker-compose.yaml` arquivo na pasta atual. Você pode especificar o diretório de trabalho usando o sinalizador `--workdir` ou especificar o arquivo Compose diretamente usando o `--file` sinalizador.

Você também pode especificar um nome para o aplicativo Compose usando o `--project-name` sinalizador durante a implantação. Se nenhum nome for especificado, um nome será derivado do diretório de trabalho.

Você pode visualizar logs de contêineres que fazem parte do aplicativo Compose usando o comando `docker logs <CONTAINER_ID>`. Para saber o ID do contêiner, execute `docker ps`.
# Composer

## O que é?

O Composer é nada mais do que uma ferramenta onde podemos gerenciar o uso de bilbiotecas de terceiros em nossa aplicação, além de carregar nosso código sem a necessidade de tantos `require_once`, facilitando o uso de boas práticas de desenvolvimento no PHP. A ferramenta constitui-se apenas de um arquivo chamado `composer.phar` que faz toda a mágica de download dos pacotes, criação do `autoload.php`, etc.


## Mas o que isso quer dizer, na prática?

Bem, vamos imaginar o cenário onde você possui um sistema onde existe uma dezena de scripts e eles precisam ser incluídos no script atual.

Você faria dessa forma, certo?

```
<?php

	require_once("class/Loja/Usuario.php");
	require_once("class/Loja/Produto.php");
	require_once("class/Loja/Venda.php");
	(...)
``` 

Esssa abordagem possui alguns problemas, a saber: 

- Loop do require_once: Você pode acabar entrando nesse problema, onde cada arquivo incluído pode ter outro arquivo incluído, que por sua vez pode ter um dos scripts também adicionado via `require_once`.  Isso pode ocasionar um erro de `cannot redeclare Usuario`, dentre outras dores de cabeça.

Esse problema ocorre com frequência em sistemas mais antigos, onde diversos devs já passaram por ele e acabam fazendo implementações diferentes da desejada. 

- Gestão dos paths absolutos: Veja que nesse caso assumimos que o script atual saberá que existe o diretório `class` num nível abaixo do dele. Mas se por um acaso precisarmos mudar essa estrutura? Veja o trabalho que vai dar! 

- Orientação a objetos mais intuitiva: Não seria mais facil tratarmos os diretórios como namespaces? 

```
<?php

use Loja as MinhaLoja; 

(...)
$usuario = new MinhaLoja\Usuario;
$produto = new MinhaLoja\Produto;

```

- Uso de bibliotecas de terceiros: Digamos que você tem um formulário que precisa de alguns filtros de validação daquilo que o usuário insere. Seria mais fácil criar uma biblioteca inteira para este caso  ou importar uma biblioteca de terceiro, utilizado por mais pessoas, que possui uma comunidade engajada e pronta para lhe ajudar nos problemas? 

- Criação de aplicações usando frameworks: Alguns dos frameworks **de mercado** podem fazer uso do composer para criação de apps, como o *Laravel*, *Symfony*, *Zend Framework*, etc. Rodando apenas um comando: 


`composer create-project symfony/website-skeleton my-project`


Enfim, existe uma infinidade de benefícios ao se utilizar o Composer em suas aplicações PHP. Poderiamos até citar o exemplo de gerenciadores de libs de outras linguagens, como: `gems`, do Ruby, 'npm' do node.js, `pip`, do Python, etc. Mas preferimos que você descubra por si só e tire suas próprias conclusões. Com certeza você não vai se arrepender!


## Packagist: o repositório

Você com certeza já deve ter ouvido falar do Packagist, certo? Caso não tenha, fique tranquilo e guarde essa informação contigo: O Packagist é o maior repositório de bibliotecas/pacotes para uso junto com o Composer. Nele você pode encontrar bibliotecas desenvolvidas por terceiros, que irão lhe ajudar com tarefas simples como validação de formulários, ORMs, requisições externas, integração com outros webservices, etc.

O Packagist é grátis e não é necessário nenhuma conta para baixar as bibliotecas. Basta um arquivo que possua as referências que devem ser consideradas ao efetuar o download das libs, chamado `composer.json`.

Vamos utilizá-lo massivamente nesse howto e recomendo você dar uma olhada em packagist.org antes de começarmos pra valer, caso não saiba o que significa.

## Instalando o Composer

No Windows:

https://getcomposer.org/doc/00-intro.md#installation-windows



No Linux: 

Algumas distros já possuem o `composer` na lista de repositórios, então em alguns casos o `apt-get install composer` (Ubuntu/Debian) ou `sudo dnf install composer` (Fedora 25+) já resolvem e fazem a instalação global (você consegue rodar o comando de qualquer diretório).

Caso você não possua privilégios de `root` em sua máquina: 

1 - Baixe o instalador, rodando os comandos abaixo: 

```
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"

```

* PS: em caso de erro no hash ou mensagem de `Installer corrupt`, clique (https://getcomposer.org/download/[aqui], copie e cole o script atualizado em seu bash.

Existe uma outra maneira que é baixar o arquivo `composer.phar`e criar o link simbólico no diretório `/bin`. Como no exemplo abaixo, onde em meu $PATH tenho o diretório `/home/gustavo/utils` já configurado e o `composer.phar` no diretório `~/composer`:


```
cd ~/composer
wget -c https://getcomposer.org/download/1.6.4/composer.phar
ln -s /home/gustavo/composer/composer.phar /home/gustavo/utils/composer

```

Caso dê tudo certo, ao digitar o comando `composer` você verá a resposta abaixo:

[https://imgur.com/a/744WNnE](https://getcomposer.org/download/1.6.4/composer.phar)



## Estrutura do arquivo composer.json

Via de regra, o composer precisa do arquivo `composer.json`, que nada mais é do que uma referência para baixar os pacotes do Packagist. Vamos olhar mais de perto. Crie o arquivo `composer.json` no diretorio raiz de sua aplicação: 


```
{
  "name": "TutorialComposer",
  "description":"A simple tutorial on how to use composer",
  "require-dev": {
    "codeception/codeception": "2.4.0"
  },
  "require": {
    "guzzlehttp/guzzle": "*"
  },
  "autoload": {
    "psr-4":{
      "": "src/"
    }
  }
}

```

Agora digite `composer install`. Este será o resultado esperado: 

![](https://imgur.com/a/cFG51tf)


** Caso ocorra este problema (https://imgur.com/a/VPagOKr), apenas instale as extensões indicadas e rode novamente o composer install**.

Veja que foi criado a pasta `vendor` no mesmo diretório onde você executou o comando. Não se preocupe, é normal e voce certamente não irá precisar alterar estes arquivos.

O mais importante é o arquivo `vendor/autoload.php`, este é o autoload gerado automaticamente pelo Composer e é a ele que faremos referência. Este será o único `require_once` que faremos, uma única vez apenas.


Vamos falar sobre algumas tags: 

- require-dev: Todos os pacotes abaixo desse nível (exemplo nosso é o `codeception/codeception`) será instalado a não ser que você execute o composer com o parametro `--no-dev`. Este parâmetro é essencial quando fazemos um deploy em ambientes de homologação ou produção, uma vez que não precisamos (e nem podemos) incluir algumas bibliotecas, como o PHPUnit.


- require: Todos os pacotes serão instalados normalmente.

- autoload: Esta tag indica qual será o mapeamento do classpath. Em outras palavras, quando fizermos referência a uma classe `\Loja\Usuario`, é como se você estivesse fazendo um `require_once('/src/Loja/Usuario.php')`.

Vale a pena dar uma olhada nesse [link](https://imgur.com/a/cFG51tf) para maiores informações.



## Como incluir em sua aplicação

Nada melhor do que um exemplo!





## Referencias 

https://getcomposer.org/download/
https://symfony.com/doc/current/setup.html


# Composer

## O que é?

O Composer é nada mais do que uma ferramenta onde podemos gerenciar o uso de bilbiotecas de terceiros em nossa aplicação, além de carregar nosso código sem a necessidade de tantos `require_once`, facilitando o uso de boas práticas de desenvolvimento no PHP. A ferramenta constitui-se apenas de um arquivo chamado `composer.phar` que faz toda a mágica de download dos pacotes, criação do `autoload.php`, etc.


## Mas o que isso quer dizer, na prática?

Bem, vamos imaginar o cenário onde você possui um sistema onde existe uma dezena de scripts e eles precisam ser incluídos no script atual.

Você faria dessa forma, certo?

```
<?php

	require_once("class/Loja/Usuario.php");
	require_once("class/Loja/Produto.php");
	require_once("class/Loja/Venda.php");
	(...)
``` 

Esssa abordagem possui alguns problemas, a saber: 

- Loop do require_once: Você pode acabar entrando nesse problema, onde cada arquivo incluído pode ter outro arquivo incluído, que por sua vez pode ter um dos scripts também adicionado via `require_once`.  Isso pode ocasionar um erro de `cannot redeclare Usuario`, dentre outras dores de cabeça.

Esse problema ocorre com frequência em sistemas mais antigos, onde diversos devs já passaram por ele e acabam fazendo implementações diferentes da desejada. 

- Gestão dos paths absolutos: Veja que nesse caso assumimos que o script atual saberá que existe o diretório `class` num nível abaixo do dele. Mas se por um acaso precisarmos mudar essa estrutura? Veja o trabalho que vai dar! 

- Orientação a objetos mais intuitiva: Não seria mais facil tratarmos os diretórios como namespaces? 

```
<?php

use Loja as MinhaLoja; 

(...)
$usuario = new MinhaLoja\Usuario;
$produto = new MinhaLoja\Produto;

```

- Uso de bibliotecas de terceiros: Digamos que você tem um formulário que precisa de alguns filtros de validação daquilo que o usuário insere. Seria mais fácil criar uma biblioteca inteira para este caso  ou importar uma biblioteca de terceiro, utilizado por mais pessoas, que possui uma comunidade engajada e pronta para lhe ajudar nos problemas? 

- Criação de aplicações usando frameworks: Alguns dos frameworks **de mercado** podem fazer uso do composer para criação de apps, como o *Laravel*, *Symfony*, *Zend Framework*, etc. Rodando apenas um comando: 


`composer create-project symfony/website-skeleton my-project`


Enfim, existe uma infinidade de benefícios ao se utilizar o Composer em suas aplicações PHP. Poderiamos até citar o exemplo de gerenciadores de libs de outras linguagens, como: `gems`, do Ruby, 'npm' do node.js, `pip`, do Python, etc. Mas preferimos que você descubra por si só e tire suas próprias conclusões. Com certeza você não vai se arrepender!


## Packagist: o repositório

Você com certeza já deve ter ouvido falar do Packagist, certo? Caso não tenha, fique tranquilo e guarde essa informação contigo: O Packagist é o maior repositório de bibliotecas/pacotes para uso junto com o Composer. Nele você pode encontrar bibliotecas desenvolvidas por terceiros, que irão lhe ajudar com tarefas simples como validação de formulários, ORMs, requisições externas, integração com outros webservices, etc.

O Packagist é grátis e não é necessário nenhuma conta para baixar as bibliotecas. Basta um arquivo que possua as referências que devem ser consideradas ao efetuar o download das libs, chamado `composer.json`.

Vamos utilizá-lo massivamente nesse howto e recomendo você dar uma olhada em packagist.org antes de começarmos pra valer, caso não saiba o que significa.

## Instalando o Composer

No Windows:

Basta baixar e rodar o arquivo [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) em seu computador. Ele já configura automaticamente a variavel de ambiente $PATH de forma que o comando fique disponivel de maneira global.


Existe uma outra maneira, que é baixar o arquivo `composer.phar`, colocá-lo no diretório raiz a sua aplicação e rodá-lo através da linha de comando, usando o comando `php`: 


` php composer.phar install`

Esta abordagem possui o(s) problema(s): 
- você precisa ficar atento para *Não subir em produção o arquivo composer.phar*
- mante-lo sempre atualizado e 
- não repeti-lo em outras aplicações na mesma máquina (por exemplo).



No Linux: 

Algumas distros já possuem o `composer` na lista de repositórios, então em alguns casos o `apt-get install composer` (Ubuntu/Debian) ou `sudo dnf install composer` (Fedora 25+) já resolvem e fazem a instalação global (você consegue rodar o comando de qualquer diretório).

Caso você não possua privilégios de `root` em sua máquina: 

1 - Baixe o instalador, rodando os comandos abaixo: 

```
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"

```

* PS: em caso de erro no hash ou mensagem de `Installer corrupt`, clique (https://getcomposer.org/download/[aqui], copie e cole o script atualizado em seu bash.

Existe uma outra maneira que é baixar o arquivo `composer.phar`e criar o link simbólico no diretório `/bin`. Como no exemplo abaixo, onde em meu $PATH tenho o diretório `/home/gustavo/utils` já configurado e o `composer.phar` no diretório `~/composer`:


```
cd ~/composer
wget -c https://getcomposer.org/download/1.6.4/composer.phar
ln -s /home/gustavo/composer/composer.phar /home/gustavo/utils/composer

```

Caso dê tudo certo, ao digitar o comando `composer` você verá a resposta abaixo:

[https://imgur.com/a/744WNnE](https://getcomposer.org/download/1.6.4/composer.phar)



## Estrutura do arquivo composer.json

Via de regra, o composer precisa do arquivo `composer.json`, que nada mais é do que uma referência para baixar os pacotes do Packagist. Vamos olhar mais de perto. Crie o arquivo `composer.json` no diretorio raiz de sua aplicação: 


```
{
  "name": "TutorialComposer",
  "description":"A simple tutorial on how to use composer",
  "require-dev": {
    "codeception/codeception": "2.4.0"
  },
  "require": {
    "guzzlehttp/guzzle": "*"
  },
  "autoload": {
    "psr-4":{
      "": "src/"
    }
  }
}

```

Agora digite `composer install`. Este será o resultado esperado: 

![composer](https://imgur.com/a/cFG51tf)


** Caso ocorra este problema (https://imgur.com/a/VPagOKr), apenas instale as extensões indicadas e rode novamente o composer install**.

Veja que foi criado a pasta `vendor` no mesmo diretório onde você executou o comando. Não se preocupe, é normal e voce certamente não irá precisar alterar estes arquivos.

O mais importante é o arquivo `vendor/autoload.php`, este é o autoload gerado automaticamente pelo Composer e é a ele que faremos referência. Este será o único `require_once` que faremos, uma única vez apenas.


Vamos falar sobre algumas tags: 

- require-dev: Todos os pacotes abaixo desse nível (exemplo nosso é o `codeception/codeception`) será instalado a não ser que você execute o composer com o parametro `--no-dev`. Este parâmetro é essencial quando fazemos um deploy em ambientes de homologação ou produção, uma vez que não precisamos (e nem podemos) incluir algumas bibliotecas, como o PHPUnit.


- require: Todos os pacotes serão instalados normalmente.

- autoload: Esta tag indica qual será o mapeamento do classpath. Em outras palavras, quando fizermos referência a uma classe `\Loja\Usuario`, é como se você estivesse fazendo um `require_once('/src/Loja/Usuario.php').

Vale a pena dar uma olhada nesse [link](https://imgur.com/a/cFG51tf) para maiores informações.



## Como incluir em sua aplicação


Nada melhor do que um exemplo!


Vamos criar um app onde o usuário pode consultar a previsão do tempo diária do local em que ele está no momento, através de um formulário onde ele fará a digitação do Estado, Cidade e País. O app fará a consulta na API do OpenWeatherMap (http://api.openweathermap.org), que é gratuita.



## Mas e os frameworks?

Os frameworks, por padrão já fazem uso do Composer por padrão, embutidos em seu core. 
Inclusive você pode criar projetos com frameworks como Symfony, Zend Expressive e Laravel utilizando o Composer.

Faremos isso agora utilizando o primeiro.


` composer create-project symfony/website-skeleton previsao-do-tempo`


No Laravel: 

`composer global require "laravel/installer" `





## Referencias 

https://getcomposer.org/download/
https://symfony.com/doc/current/setup.html

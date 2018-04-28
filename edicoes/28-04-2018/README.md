# GIT

### O que é um sistema de controle de versões (VCS)

É uma ferramenta usada em desenvolvimento de software que permite times de desenvolvimento gerenciar seu código fonte ao longo do tempo. Mantém alterações salvas em uma espécie de banco de dados.

Mantém um histórico de cada alteração feita no codebase permitindo o controle/gerenciamento da evolução do código.

Mais sobre [aqui](https://www.atlassian.com/git/tutorials/what-is-version-control)

### Importância de  utilizar um VCS

- Gerenciamento da evolução do código (arquivo por arquivo) de forma sana
- Trabalho em time facilitado
- Tracking de inserções de bugs etc

## GIT

Sistema de controle de versões distribuído criado por [Linus Torvalds](https://pt.wikipedia.org/wiki/Linus_Torvalds). Talvez o mais utilizado no mercado, atualmente.

Mais no site [oficial](https://git-scm.com/)


### Comandos essenciais

**git clone:** Serve para clonar, localmente, um repositório git
```
git clone <url do seu repositório remoto no github/bitbucket>
```

**git status:** Exibe o status atual do repositório
```
git status

```
**git log:** Exibe o histórico do repositório dividido por commits
```
git log
```

**git add:** Adiciona arquivos modificados há uma lista a ser _commitada_
```
git add <nome do arquivo ou diretorio>
```

**git commit:** Dada uma lista de arquivos modificados, cria um "ponto" no histórico do repositório
```
git commit
```

**git push:** Envia as últimas alterações para um repositório remoto
```
git push <nome do repositorio remoto> <nome do branch>
```

**git pull:** Atualiza o repositório local com as modificações do repositório remoto
```
git pull <repositorio remoto> <nome do branch>
```

**git diff:** Dado um arquivo ou uma lista de arquivos, exibe a diferença entre a modificação mais recente e o último estado armazenado no repositório
```
git diff <arquivo ou diretorio>
```

**git checkout:** Desfaz modificações realizadas em um arquivo ou em todos os arquivos de um diretório. Também pode ser usado para navagar entre branches e criar novos.
```
// desfaz modificações
git checkout <arquivo ou diretório>

// cria um branch
git checkout -b <nome do novo branch>

// muda para outro branch
git checkout <nome do branch>
```


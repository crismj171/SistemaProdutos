# Funcionalidades


- Cadastro de produtos com nome, preço e descrição.
- Listagem de produtos cadastrados.
- Validação de dados (nome obrigatório, preço numérico, limites de tamanho).
- Persistência simples usando arquivo JSON.


## Casos de Teste Manuais


1. **Cadastro válido:** preencher nome, preço e descrição. Produto deve aparecer na lista e ser salvo no arquivo JSON.
2. **Nome vazio:** deixar o campo nome em branco. Deve retornar erro e não salvar.
3. **Preço inválido:** inserir valor não numérico ou negativo. Deve retornar erro.
4. **Persistência:** atualizar a página deve manter os produtos listados.
5. **Reset:** para limpar, zere o conteúdo do arquivo `storage/products.json` colocando `[]`.


## Conceitos Aplicados


- SRP: separação de responsabilidades entre validação, persistência e orquestração.
- PSR-4: autoload de classes via Composer.
- Inversão de dependência: o serviço depende de interfaces, permitindo trocar a implementação do repositório sem alterar o código da aplicação.

# Middleware de Cotação de Frete Braspress <> Tray😁

Este projeto é uma base para aprendizado para o desenvolvimento de APIs utilizando PHP com o framework Slim 3.

## 👨🏻‍💻 Sobre o Projeto

O objetivo deste projeto é desenvolver uma API que fará conectividade com a API de Cotação de Frete da transportadora Braspres, tratar seus dados e fornecer uma resposta compactiível com uma API de Cotação Padrão da Plataforma Tray.

**Link Documentação Tray:** https://developers.tray.com.br/#frete-x-api
**Link Documentação Braspress:** https://api.braspress.com/home

## ⬇️ Instalação

Antes de começar, certifique-se de ter o composer, servidor WEB e PHP (^7.4) instalado. 

1. Clone este repositório para o seu servidor WEB.
2. Acesse a pasta do projeto em um terminal.
3. Execute o seguinte comando para instalar as dependências:
```
composer install
```
4. Acessa a URL do servidor e verifique se não tem nenhum erro.

## ⚙️ Configurações

As configurações do projeto podem ser encontradas no arquivo `config.ini`. Nele, você poderá definir as credenciais de autenticação na API e outras variáveis de ambiente relevantes.

Segue a explicação de cada váriavel:
- **database-config**: Qual ambiente você está? (localhost/production)
- **displayErrorDetails**: Mostrar detalhamento de erro
- **addContentLengthHeader**: 
- **braspressUrl**: URL de API da Braspress
- **braspressUser**: Usuário de Autenticação da API
- **braspressPass**: Senha de Autenticação da API


## 🙏  Contribuição

Se você quiser contribuir para este projeto, fique à vontade para abrir uma issue ou enviar um pull request.

## 📄 Licença

Este projeto está licenciado sob a licença [MIT](LICENSE).

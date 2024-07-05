<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://saolucascontabilidade.com.br/wp-content/uploads/2023/10/Sem-titulo-13-1.jpg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
    <img alt="License: MIT" src="https://img.shields.io/badge/license-MIT-%2304D361">
    <img alt="Language: PHP" src="https://img.shields.io/badge/language-java-green">
    <img alt="Version: 1.0" src="https://img.shields.io/badge/version-1.0-yellowgreen">
</p>

## About Magalu Challenge

**Welcome to our selection process**

**Scenario**

Magalu faces the challenge of developing a communication platform. You have been chosen to start the development of the first sprint.

**Requirements**

- **There must be an endpoint to receive a request for scheduling communication delivery (1):**
  - This endpoint must have at least the following fields:
    - Date/Time for delivery
    - Recipient
    - Message to be delivered
  - The possible communications that can be sent are: email, SMS, push notifications, and WhatsApp.
  - At this stage, we need this input channel to schedule the delivery. The actual delivery will not be developed at this stage, so you do not need to worry about that.
  - For this sprint, it has been decided that the communication delivery scheduling request will be saved in the database. Therefore, as soon as you receive the scheduling request (1), it should be saved in the database.
  - Consider the database structure carefully. Even though you will not handle the delivery, the structure should be ready so that your colleague does not need to make any changes when developing this functionality. The focus at the time of delivery will be on sending and updating the record status in the database.

- **There must be an endpoint to check the status of the scheduled communication delivery (2):**
  - The scheduling will be done through endpoint (1), and the status check will be done through this other endpoint.

- **There must be an endpoint to remove a scheduled communication delivery.**

**General Observations and Guidelines**

- We prefer development in Java, Python, or Node, but any language can be used; just explain why you chose it.
- Use one of the following databases:
  - MySQL
  - PostgreSQL
- The APIs should follow the RESTful model with JSON format.
- Perform unit tests, focusing on a well-organized test suite.
- Follow what you consider best programming practices.
- You are free to decide how to create the database and tables, whether via script, application, etc.

Your challenge should preferably be submitted as a public GIT repository (Github, Gitlab, Bitbucket), with small and well-described commits, or as a compressed file (ZIP or TAR). Your repository should include an open-source license model. Do not send any files other than the compressed code and its documentation. Be careful not to send images, videos, audio, binaries, etc.

Follow good development, quality, and code governance practices. Guide the evaluators on how to install, test, and run your code: this can be in a README within the project.

We will evaluate your challenge according to the position and level you are applying for.

We greatly appreciate your willingness to participate in our selection process and wish you to have fun and good luck :)

## Sobre desafio Magalu PT-BR

<code>[Descrição em pt-br](./ABOUT.md)</code>

## Technologies

- PHP 8.3
- Laravel
- Redis
- Docker
- Laravel Sail
- Laravel Horizon

### Feature

|Testes|Validations|SMS Channel|PUSH Channel| Whatsapp Channel|
|---|---|---|---|---|
|&#x2610;|&#x2610;|&#x2610;|&#x2610;|&#x2610;|

### References

[Buildrun Tech!](https://www.youtube.com/@buildrun-tech?sub_confirmation=1)

## License

[MIT license](https://opensource.org/licenses/MIT).

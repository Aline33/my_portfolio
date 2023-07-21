# my_portfolio


Hello ! I'm Aline LEGENDRE a web developer in Bordeaux (FRANCE). 

Welcome on my portfolio repository ! This project is my final project for Wild Code School, and was developped in 3 days. You can find me in the "author" section down below.

The application is designed to present my work and my skills.

## Tech Stack

**Client:** Bootstrap, Twig, Webpack Encore

**Server:** PHP 8.2, Symfony 6.2, MySQL


## Installation

- Clone this repository

- Go the project directory
```bash
  cd the-project
  ```
- Open the project with your favorite code editor
- Create a .env.local file, which is a copy of the .env file but with your database informations

- Install dependencies

```bash
  composer install 
  ```
```bash
  yarn install 
```

- Set up the local database
```bash
  symfony console doctrine:database:create 
  ```
```bash
  symfony console doctrine:migrations:migrate 
```
```bash
  symfony console doctrine:fixtures:load 
```
- Start the local server
 ```bash
  symfony serve -d 
  ```
  ```bash
  yarn watch
```

## Built with

- [@Symfony](https://github.com/symfony/symfony)

## Authors

- [@Aline](https://github.com/Aline33)



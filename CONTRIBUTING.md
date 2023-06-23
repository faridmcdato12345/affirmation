## Affirmation

This file will serve as a guide on setting up the project on your local environment and also contains **coding standards and implementation.**

### Project Requirements
Here are the recommended requirements for this project.

1. PHP 8.1^
  Extensions
   - bcmath
   - soap
2. Composer
3. Node v18
4. MySql
5. GIT
6. ESLint on VSCode (enable format on save)


### Setup Configuration

***NOTE:*** Ask the project owner for some values that are needed on the ```.env``` file.

1. Clone the repository
2. Create a copy of the ```.env.example``` and add the necessary environmental variables. Ask the project owner
```bash
# Windows
> xcopy .env.example .env

# Linux
> cp .env.example .env
```
3. Run ```composer install``` and ```npm install```
4. Run ```php artisan migrate --seed```
5. Open two terminals have it split (VSCode) or whatever your preference is and run ```php artisan serve``` and ```npm run dev```

### Coding Standard
#### Backend
- Use FormRequest as much as possible for validation
- Atleast follow the [PSR12](https://www.php-fig.org/psr/psr-12/) Standards
- Remove unused imports
- ***SOLID*** and ***KISS*** principle as much as possible

### Frontend
- Use tailwind classes as much as possible
- If having a problem with linter you can run the ```npm run lint:fix``` to fix automatically all the problems. 
- As much as possible try to simplify a page/component by separating some parts into its own component.
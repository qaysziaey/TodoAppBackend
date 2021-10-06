# Symfony Projekt 
symfony new my_project

cd my_project

git remote add origin git@github.com:qaysziaey/TodoAppBackend.git
git branch -M main
git push -u origin main

# Annotations für Controller
composer require doctrine/annotations

# https://symfony.com/doc/current/doctrine.html
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
 

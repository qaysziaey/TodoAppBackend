# Todo App Backend

- Symfony Projekt 

```bash
symfony new my_project

cd my_project

git remote add origin git@github.com:qaysziaey/TodoAppBackend.git
git branch -M main
git push -u origin main
```

- Annotations für Controller

```bash
composer require doctrine/annotations
```

- https://symfony.com/doc/current/doctrine.html

```bash
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
``` 

## Database

```bash
# First put DATABASE_URL in .env.local

bin/console doctrine:database:create

# Than create Entity's

bin/console doctrine:schema:create

# After modifying Entity run

bin/console doctrine:schema:update --force
```

---

# .ENV.LOCAL

```.env
DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"
```

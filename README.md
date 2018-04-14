# ToDoList v0.4
Project Symfony 4
========
Symfony 4 web application who propose to manage your tasks & to-dos in one place.

---
### Prerequisites
- Server PHP 7 with admin right.
- SQL Database with admin right.
- Composer installed.
---
### Installing
1. Download this project and his dependency with composer. 
```bash 
php composer create-project Trenndal/ToDoList --repository-url="https://github.com/Trenndal/ToDoList" 
```
2. Modify the *config/packages/doctrine.yaml* file. 
```ini 
doctrine:
    dbal:
        connections:
            default:
                dbname:               Your_DB_Name
                host:                 DB_Location
                port:                 DB_Post or ~
                user:                 DB_Login
                password:             DB_Password or ~
                driver:               pdo_mysql or pdo_sqlite or pdo_pgsql or pdo_oci
```
3. Generate the Database :
```bash 
php bin/console doctrine:database:create 
php app/console doctrine:schema:update --force
``` 
4. [Deploy the project to production mode](https://symfony.com/doc/current/deployment.html)
---
### Contributing
 * [See the CONTRIBUTING.md file](https://github.com/Trenndal/ToDoList/blob/master/CONTRIBUTING.md)
 * [Report issues](https://github.com/Trenndal/ToDoList/issues) and
    [send Pull Requests](https://github.com/Trenndal/ToDoList/pulls)
    in the [main ToDoList repository](https://github.com/Trenndal/ToDoList)

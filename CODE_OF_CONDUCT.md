# Contributor Covenant Code of Conduct

## Coding Style

Laravel follows the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard and the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard.

### Naming Conventions

1. Class names MUST be declared in StudlyCaps.
2. Class constants MUST be declared in all upper case with underscore separators.
3. Method names MUST be declared in camelCase.
4. Method names should be **verb**
5. Class name and variable/property names should be **noun**
6. Variable/Property names MUST be declared in camelCase.

| What | How | Good | Bad |
| --- | --- | --- | --- |
| Controller | singular | UserController | ~~UsersController~~ |
| --- | --- | --- | --- |
| Route | plural | users/1 | ~~user/1~~ |
| Named route | snake\_case with dot notation | users.show\_active | ~~users.show-active, show-active-users~~ |
| Model | singular | User | ~~Users~~ |
| Table | plural | user\_comments | ~~user\_comment, userComments~~ |
| Migration | - | 2017\_01\_01\_000000\_create\_articles\_table | ~~2017\_01\_01\_000000\_articles~~ |
| Method | camelCase | getAll | ~~get\_all~~ |
| Variable | camelCase | articles\_with\_author~~ |
 |

### Comments

1. Use standard **PHPDoc** comment tags for the comments
2. Each and every files should have comments

### RDBMS

1. Table name should be plural and noun. If the table name contains two words then it should be separated by underscores like **user\_permissions**
2. Column names should be singular and noun and contains two words then it should be separated by underscores like **user\_id**
3. Foreign key column name should be like **user\_id** if the foreign key table is **users**
4. Column data type size should be appropriate

### Laravel

1. Mail functionality always should use [notification](https://laravel.com/docs/10.x/notifications) or [queues](https://laravel.com/docs/10.x/queues)
2. If you are doing multiple database operations in single request must use [Transactions](https://laravel.com/docs/10.x/database#database-transactions)
3. If set of statements or functionality used across multiple controllers then try to use [traits](https://www.php.net/manual/en/language.oop5.traits.php)
4. Exception mails should be included

### Controller

1. Controller should do business logic.
2. Database operations should not be done in controllers

### Model

1. Never use hard delete. Only soft delete with information about who deleted it
2. Every DB structure alternation should be in the migration file
3. Never use the **DB Facade** utility its necessary
4. DB retrieval should always specify the columns names
5. All the changes on the should be stored on the activity log
6. No hardcore DDL commands. Should use only [migration](https://laravel.com/docs/10.x/migrations)

### Git

1. Commit message should be informative

### Code Editor

1. Try to use VS Code
2. Install the EditorConfig package
3. Enable save on format option
4. Some of the useful VS Code extensions
    1. [Snipped](https://marketplace.visualstudio.com/items?itemName=JeffersonLicet.snipped) - For the code screenshot
    2. [TODO Highlight](https://marketplace.visualstudio.com/items?itemName=wayou.vscode-todo-highlight) - Highlight TODO, FIXME and other annotations within your code.
    3. [Alignment](https://marketplace.visualstudio.com/items?itemName=annsk.alignment) - This extension align chars in selection. It helps creating clean, formatted code.
    4. [Auto Close Tag](https://marketplace.visualstudio.com/items?itemName=formulahendry.auto-close-tag) - Automatically add HTML/XML close tag, same as Visual Studio IDE or Sublime Text
    5. [Error Lens](https://marketplace.visualstudio.com/items?itemName=usernamehw.errorlens) - Improve highlighting of errors, warnings and other language diagnostics.
    6. [GitLens — Git supercharged](https://marketplace.visualstudio.com/items?itemName=eamodio.gitlens) - Supercharge Git within VS Code — Visualize code authorship at a glance via Git blame annotations and CodeLens, seamlessly navigate and explore Git repositories, gain valuable insights via rich visualizations and powerful comparison commands, and so much more
    7. [PHP DocBlocker](https://marketplace.visualstudio.com/items?itemName=neilbrayfield.php-docblocker) - A simple, dependency free PHP specific DocBlocking package
    8. [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client) - PHP code intelligence for Visual Studio Code

### Don't do

1. Never install any packages without informing the superior

### HTML

1. Image tag
    - Always use alt attribue to describe about the image
    - Always use loading=lazy attribute for the loading the image in lazy technique

### JS

1. Always use let or const. When the variable required in global scope then only in var

### CSS

1. Never use inline css anywhere

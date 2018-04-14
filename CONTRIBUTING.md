# How to contribute
---
### Resources and documentation:
 * [Security and tests documentation.](https://github.com/Trenndal/ToDoList/blob/master/documentation.pdf) Please read this befor any modification.
 * [How to use Git](https://git-scm.com/docs/gittutorial)
 * [Symfony Tutorial](https://symfony.com/doc/current/index.html)
---
### Submitting changes

Please send a [GitHub Pull Request on the dev branch](https://github.com/Trenndal/ToDoList/pull/new/dev) with a clear list of what you've done (read more about [pull requests](http://help.github.com/pull-requests/)). When you send a pull request include PHPUnit tests for the new features and adapt previous tests. Please make sure all of your commits are atomic (one feature per commit).

Always write a clear log message for your commits. One-line messages are fine for small changes, but bigger changes should look like this:

    $ git commit -m "A brief summary of the commit
    > 
    > A paragraph describing what changed and its impact."
---
### Testing
 * [Speed audit with Blackfire](https://blackfire.io/docs/up-and-running/index)
 * [Automated Code Reviews with Scrutiniser-ci](https://scrutinizer-ci.com/docs/guides/php/)
 * Launche PHPUnit tests with the commande :
    > vendor/bin/simple-phpunit --env=test
   For windows :
    > vendor/bin/simple-phpunit.bat --env=test

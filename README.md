# ACM Phoenix 2.0
Welcome to the readme for phoenix2.

If you have any questions, feel free to contact the original author, Kyle Minshall.
He can be reached at `kyleminshall@gmail.com`.

## Overview
The project is written in Symfony 4 which is the latest major version of the best web framework for PHP.

Main things to know:

* Views/Templates: `templates/`
* Controllers: `src/Controllers`
* Web root: `public`

To run Symfony tools/scripts, run the command `php bin/console <command> <flags>` in your terminal of choice.

## Development

First, you need to install [composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).
Composer is a package manager for PHP. We use a few packages.

Second, you are going to need a SQL database. We use PostgreSQL on prod but we also use an ORM for all our our entity stuff.

1. Clone the repo: `git clone git@github.com:acm-ucr/phoenix2.git`
2. `cd` into the newly created phoenix2 directory
3. Create a new config/services.yaml file: `cp config/services.yaml.dist config/services.yaml`
4. Populate the services.yaml file with your database credentials (localhost, unless you're using prod data)
5. Run `composer install` to install all of the dependencies for the project. This should create and populate a `vendor/` directory.
6. Start the server: `php bin/console server:run -vvv`. The `-vvv` is maximum verbosity and can be omitted if you don't need/want it.
7. Navigate to `http://localhost:8000` and the site should appear.

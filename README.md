CONFIGURATION:

    Edit line27 dbuser and dbname in .env folder
    Creation of Entities and db form Migrations Repertory :
        php bin/console doctrine:database:create 
        php bin/console doctrine:mapping:import App\\Entity annotation --path=src/Entity
        php bin/console make:migration
        php bin/console doctrine:generate:entities
    You can also generate all the getter/setter/adder/remover methodsfor the properties of existing entities: 
        php bin/console make:entity --regenerate
    If repositories are not set, be sure that following line are in entities annonation
    exemple for booking
        @ORM\Entity(repositoryClass="App\Repository\BookingsRepository")
    Installing Encore
         composer require encore
         yarn install
    install and load sass
        npm install -g npm 
        yarn add sass-loader@^7.0.1 node-sass --dev
        https://symfony.com/doc/current/frontend/encore/css-preprocessors.html
        create scss/app.sass in assets folder
        edit assets/app/js
    compil css scss & js
        all folder must be in assets folder
        yarn encore dev
        see result in public/build
    Paginator
        https://github.com/KnpLabs/KnpPaginatorBundle
        composer require knplabs/knp-paginator-bundle
    Masonry
        npm install masonry-layout
        npm install jquery-bridget
        https://masonry.desandro.com/extras.html#bootstrap
    Translator v4.2.7
        composer require symfony/translation
        updates the French translation file with the missing strings for that locale
            php bin/console translation:update --dump-messages --force fr
            php bin/console cache:clear
        To inspect all messages in the fr locale for the application, run:
             php bin/console debug:translation fr
    Font Awesome
        yarn add --dev @fortawesome/fontawesome-free
    Filesystem (chmod on server)
        composer require symfony/filesystem

SERVER (localhost:8000):

    runserver
        php bin/console server:start
        php bin/console server:restart
        php bin/console server:stop

TEST:

    Install phpunit-bridge
        composer require --dev symfony/phpunit-bridge
        ./bin/phpunit
    Create unit-test
        php bin/console make:unit-test
    Run test
        ./bin/phpunit
    Run test with html creation 
        ./bin/phpunit --coverage-html=cov

## Blockly Game (Laravel)

  Requirements (Linux):
  - docker
  - docker-compose

  Requirements (Windows):
  - Docker Desktop
  - WSL2
  - Linux distribution (WSL2) integrated with Docker Desktop

How to run this application:
1. Use Linux distro (natively or in Windows) to clone this repo and navigate to root folder of application.
2. Install dependencies. https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects
3. Run command `cp .env.example .env`
4. Run command `./vendor/bin/sail up -d`
5. Run command `./vendor/bin/sail artisan key:generate`
6. Run command `./vendor/bin/sail artisan migrate --seed`
7. You can now log in with username `admin` and password `admin123` and play the game.

----------

<p  align="left"><img  width="30%"  src="https://developers.google.com/blockly/images/logos/logo_built_on.png">

</p>

Blockly is a library from Google for building beginner-friendly block-based programming languages.  

---------- 

<p  align="left"><img  src="https://laravel.com/assets/img/components/logo-laravel.svg">

</p>

The Laravel framework is open-sourced software licensed under the MIT license.  

----------

<p  align="left"><img  src="https://image4.owler.com/logo/playcanvas_owler_20180323_222343_large.png">

</p>

The PlayCanvas engine is open-sourced software licensed under the MIT license.
# unisys-api
Unisys basic API skeleton developed by Unite.

## Requirements

Unisys API skeleton requires:
- PHP 7.1+
- Database that supports `json` fields such as MySQL 5.7 or higher.

It uses Laravel 5.6, so it has to meet also all its requirements https://laravel.com/docs/5.6/installation#server-requirements.

## Installation

### New UniSys project

For clean API skeleton based on Laravel 5.6, you can use  weareunite/unisys-installer that do all the boring work for you. Let's install it globally:

```
composer global require "weareunite/unisys-installer"
```
Now you can create a new Unisys skeleton:

```
unisys new project_name
```

This is going to install all dependencies, publish all important vendor configs, migrate, setup some configs and run migrations.

Command is going to generate and print the password for the default administrator account. Do not forget to remember this password

### Add Unisys to existing project

Or alternatively, you can use your existing Laravel 5.6 application. Start with requiring these two main packages:

```
composer require weareunite/unisys-api
```
To install this package use:

```
php artisan unisys-api:init-env
```
and after:

```
php artisan unisys-api:install
```

This is going to install all dependencies, publish all important vendor configs, migrate, setup some configs, webpack config and run migrations.

Command is going to generate and print the password for the default administrator account. Save this password to your clipboard, we are going to need it soon.

## Requirements

Add your DSN to ``.env``:

```
SENTRY_LARAVEL_DSN=https://public:secret@sentry.example.com/1
```

### Optimization tools

Medialibrary will use these tools to [optimize converted images](https://docs.spatie.be/laravel-medialibrary/v7/converting-images/optimizing-converted-images) if they are present on your system:

- [JpegOptim](http://freecode.com/projects/jpegoptim)
- [Optipng](http://optipng.sourceforge.net/)
- [Pngquant 2](https://pngquant.org/)
- [SVGO](https://github.com/svg/svgo)
- [Gifsicle](http://www.lcdf.org/gifsicle/)

Here's how to install all the optimizers on Ubuntu:

```bash
sudo apt-get install jpegoptim
sudo apt-get install optipng
sudo apt-get install pngquant
sudo npm install -g svgo
sudo apt-get install gifsicle
```

And here's how to install the binaries on MacOS (using [Homebrew](https://brew.sh/)):

```bash
brew install jpegoptim
brew install optipng
brew install pngquant
brew install svgo
brew install gifsicle
```

To create derived images [GD](http://php.net/manual/en/book.image.php) should be installed on your server.
For the creation of thumbnails of svg's or pdf's you should also install [Imagick](http://php.net/manual/en/imagick.setresolution.php).

### Wkhtmltopdf Installation

Choose one of the following options to install wkhtmltopdf/wkhtmltoimage.

1. Download wkhtmltopdf from [here](http://wkhtmltopdf.org/downloads.html); 
2. Or install as a composer dependency. See [wkhtmltopdf binary as composer dependencies](https://github.com/KnpLabs/snappy#wkhtmltopdf-binary-as-composer-dependencies) for more information.

## Testing

1. Copy `.env.example` to `.env` and fill in your database credentials.
2. Run `vendor/bin/phpunit`.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
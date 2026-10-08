# %module_name%

%module_description%

A [Laravel module](https://laravelmodules.com) built with [Pollora](https://pollora.dev) from the [module-default](https://github.com/Pollora/module-default) template.

## What's inside

```
%module_name%/
├── app/                      # PHP classes, namespace %module_namespace%
│   └── Cms/Hooks/            # WordPress hooks, declared with attributes
├── resources/
│   ├── assets/               # app.js and app.css, built with Vite and Tailwind CSS v4
│   └── views/blocks/         # Gutenberg blocks, registered by Pollora
├── composer.json             # PSR-4 autoload, merged into the project's
├── module.json               # No providers: Pollora discovers the classes in app/
├── package.json
└── vite.config.js            # @pollora/vite-config, type "module"
```

Classes in `app/` are discovered: hooks, post types, taxonomies, REST routes and scheduled tasks declared with attributes need no service provider.

## Commands

From the project root:

```bash
php artisan pollora:make:block hero --module=%module_name%   # a block in resources/views/blocks
php artisan pollora:make:post-type Ticket --module=%module_name%
php artisan module:make-provider %module_name%ServiceProvider %module_name%   # when the module needs one
php artisan module:disable %module_name%
```

From the module's directory:

```bash
npm install
npm run dev      # Vite dev server with hot reload (port 5175, VITE_PORT to change it)
npm run build    # into public/build/module/%module_slug%
```

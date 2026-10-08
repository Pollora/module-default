# Pollora module template

The template `php artisan pollora:make:module` downloads to create a [Laravel module](https://laravelmodules.com) in a [Pollora](https://pollora.dev) project: discovered classes, Blade blocks and a Vite build shared with themes and plugins through [`@pollora/vite-config`](https://github.com/Pollora/vite-config).

```bash
php artisan pollora:make:module Crm
php artisan pollora:make:module Crm --provider --routes --database   # opt-in Laravel layers
```

## Placeholders

| Placeholder | Example |
| --- | --- |
| `%module_name%` | `Crm` |
| `%module_slug%` | `crm` |
| `%module_namespace%` | `Modules\Crm` |
| `%module_namespace_json%` | `Modules\\Crm` |
| `%module_description%` | `Customer relations` |
| `%module_author%` | `RuBee group` |

`.stub` files become `.php`; `bin/` and `.github/` are not copied. `php bin/scaffold.php <dir> [Name]` writes the template out the same way, and `php bin/check.php <dir>` checks the result; CI runs both, then builds the module.

## License

MIT, © [RuBee group](https://rubee.group).

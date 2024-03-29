## Password validation from Laravel 8.39+
> **Deprecation:** This tool is deprecated, since Password validation was added into Laravel core in version 8.39. Read more in [Laravel News](https://laravel-news.com/password-validation-rule-object-in-laravel-8) and in [Laravel documentation](https://laravel.com/docs/validation#validating-passwords)


# Password Rule for Laravel 5.5+

Package contains `PasswordRule` class for validation password fields with Laravel validator. Nowadays passwords containing numbers, lower and upper case characters (and symbols) are not enough. But it is still better than simple minimum length rule.

Custom Rule created with `Illuminate\Contracts\Validation\Rule` interface was introduced in Laravel 5.5. But you can simply copy logic and use in earlier Laravel version too.

**IMPORTANT NOTE** - Don't miss [Add to predefined Laravel Auth controllers](#add-to-predefined-Laravel-auth-controllers) section, as in original Controllers must be rules changed as well.

## Table of contents
* [Installation](#instalation)
* [Configuration](#configuration)
* [What PasswordRule can do](#what-passwordrule-can-do)
    *  [Message format](#message-format)
* [Usage](#usage)
    * [Overriding global settings](#overriding-global-settings)
    * [Add to predefined Laravel Auth controllers](#add-to-predefined-Laravel-auth-controllers)
* [Changelog](#changelog)

## Installation

Installing via composer is suggested:

```bash
composer require arxeiss/passwordrule
```

No more steps are needed, as Laravel 5.5+ provides [automatic package discovery](https://laravel.com/docs/5.5/packages).

## Configuration
By default, package contains *English* and *Czech* translations and default config is shown below. Do not change config file or translations in `vendor` folder. Run command

```bash
php artisan vendor:publish --provider="PasswordRule\PasswordRuleServiceProvider"
```

to  publish config file `config/passwordrule.php` and translation files into `resources/lang/vendor/passwordrule/`.

## What PasswordRule can do
PasswordRule can be used in Laravel to validate password input with four optional rules.

* **Minimum length** - mandatory rule, which test minimum length of password
* **Camel case** - optional rule. Password is tested if contains lower and upper case character
* **Numbers** - optional rule to test, if password contains number
* **Special characters** - optional rule to test, if password contains at least 1 special character from the list of characters

All settings can be set via global config file as well as in constructor for each instance.

### Message format
PasswordRule returns always single message, which is built according to settings. There is basic phrase, which is used always. According to settings above are then added more or less phrases. In language file are specified two join phrases. `join_comma` is used to join all phrases except the last one. Before the last one is inserted `join_and`.

Result message can looks like this:
* Password must contains at least 6 characters
* Password must contains at least 8 characters `and` number
* Password must contains at least 6 characters`,` lower and upper case character `and` number
* Password must contains at least 7 characters`,` lower and upper case character`,` number `and` at least 1 special symbol from @#%

## Usage
### Basic usage
**Form Request validation**:
```php
/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */
public function rules()
{
    return [
        'password' => ['required', new PasswordRule\PasswordRule, 'confirmed'],
    ];
}
```

**Request validation**:
```php
public function store(Request $request)
{
    $request->validate([
        'password' => ['required', new PasswordRule\PasswordRule, 'confirmed'],
    ]);
}
```

### Overriding global settings
PasswordRule constructor accepts 4 parameters, which can override global settings
`new PasswordRule($minLength, $camelCase, $numbers, $specialChars)`.
Pass `null` to load specific setting from global config.

```php
return [
    // Password must be at least 8 characters long and must contains "_"
    'password' => ['required', new PasswordRule\PasswordRule(8, false, false, "_"), 'confirmed'],
];
```

### Add to predefined Laravel Auth controllers
Laravel in his starter package [laravel/laravel](https://github.com/laravel/laravel) provides basic Auth controllers. Important now are **RegisterController** and **ResetPasswordController**, because in both controllers are original password rules.

In RegisterController are rules directly written, it is easy to change. But in ResetPasswordController must be overridden method `rules()` as shown in code below.

```php
/**
 * Get the password reset validation rules.
 *
 * @return array
 */
protected function rules()
{
    $rules = parent::rules();
    $rules['password'] = ["required", new PasswordRule, "confirmed"];
    return $rules;
}
```

## Changelog
### [1.0] - 14.8.2018
* First public release

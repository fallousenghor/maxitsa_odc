<?php
namespace Maxitsa\Core;

use Maxitsa\Enum\ErrorMessage;

class Validator {
    
    private static array $validators = [];

    public static function getValidators(): array
    {
        if (empty(self::$validators)) {
            self::$validators = [
                'email' => function($value) { return filter_var($value, FILTER_VALIDATE_EMAIL) !== false; },
                'empty' => function($value) { return empty($value); },
                'telephone' => function($value) { return preg_match('/^(77|78)\d{7}$/', $value); },
                'identite' => function($value) { return preg_match('/^(1|2)\d{12}$/', $value); },
                'unique_telephone' => function($value) {
                    $db = App::getDependency('core', 'Database')->getConnection();
                    $stmt = $db->prepare('SELECT COUNT(*) FROM personne WHERE telephone = :telephone');
                    $stmt->execute(['telephone' => $value]);
                    return $stmt->fetchColumn() == 0;
                },
                'unique_identite' => function($value) {
                    $db = App::getDependency('core', 'Database')->getConnection();
                    $stmt = $db->prepare('SELECT COUNT(*) FROM personne WHERE num_identite = :num_identite');
                    $stmt->execute(['num_identite' => $value]);
                    return $stmt->fetchColumn() == 0;
                }
            ];
        }
        return self::$validators;
    }
    public static function isEmail($email): bool
    {
        return self::getValidators()['email']($email);
    }

    public static function isEmpty($value): bool
    {
        return self::getValidators()['empty']($value);
    }

    public static function isValidTelephone($telephone): bool
    {
        return self::getValidators()['telephone']($telephone);
    }

    public static function isValidIdentite($num_identite): bool
    {
        return self::getValidators()['identite']($num_identite);
    }

    public static function isUniqueTelephone($telephone): bool
    {
        return self::getValidators()['unique_telephone']($telephone);
    }

    public static function isUniqueIdentite($num_identite): bool
    {
        return self::getValidators()['unique_identite']($num_identite);
    }

    public static function getErrorMessages() {
        $messages = [];
        foreach (ErrorMessage::cases() as $case) {
            $messages[$case->name] = $case->value;
        }
        return $messages;
    }

    public static function getErrorMessage($key) {
        $messages = self::getErrorMessages();
        return isset($messages[$key]) ? $messages[$key] : '';
    }
    private static array $errors = [];

    public static function reset(): void
    {
        self::$errors = [];
    }

    public static function addError($key, $message): void
    {
        self::$errors[$key][] = $message;
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }

    public static function isValid(): bool
    {
        return empty(self::$errors);
    }

    public static function validatePersonneData($telephone, $num_identite): bool
    {
        if (!self::isValidTelephone($telephone)) {
            self::addError('telephone', self::getErrorMessage('telephone_format'));
        } elseif (!self::isUniqueTelephone($telephone)) {
            self::addError('telephone', self::getErrorMessage('telephone_unique'));
        }
        if (!self::isValidIdentite($num_identite)) {
            self::addError('num_identite', self::getErrorMessage('identite_format'));
        } elseif (!self::isUniqueIdentite($num_identite)) {
            self::addError('num_identite', self::getErrorMessage('identite_unique'));
        }
        return self::isValid();
    }
}

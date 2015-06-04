<?php

class InternetFaker extends \Faker\Provider\Internet
{

    public static function usernameFromName($name)
    {
        $names = explode(" ", $name);
        $firstName = $names[0];
        $lastName = $names[count($names)-1];
        $userNameFormat = static::randomElement(static::$userNameFormats);
        $email = preg_replace_callback('/\{\{\s?(\w+)\s?\}\}/u', function($matches) use ($firstName, $lastName) {
            return strtolower(static::toAscii($$matches[1]));
        }, $userNameFormat);
        $email = static::bothify($email);

        //$email = preg_replace('/\s/u', '', $this->generator->parse($format));
        return static::toAscii($email);
    }

}

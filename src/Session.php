<?php

namespace Ajin;

/**
 * This file is part of the Ajin Components.
 *
 * @author Hisham Hadraoui <hichamhadraoui.hh@gmail.com>
 */
class Session
{
    /**
     * Checks if the key exists.
     *
     * @param string $key
     *
     * @return bool exists or not
     */
    public static function has(string $key)
    {
        return isset($_SESSION[(string) $key]) === true;
    }

    /**
     * Store a variable in the session.
     *
     * @param string $key   [The key of the stored variable]
     * @param mixed  $value [The value to store]
     *
     * @return mixed
     */
    public static function put(string $key, $value=null)
    {
        if (is_array($key))
        {
            return self::puts($key);
        } 

        return $_SESSION[(string) $key] = $value;
    }

    /**
     * Store a multiple variables in the session.
     *
     * @param array $data [Contains key and value for each item]
     *
     * @return mixed
     */
    protected static function puts(array $data)
    {
        foreach ($data as $key => $value) {
            self::put($key, $value);
        }
    }

    /**
     * Get the variable from the session.
     *
     * @param string $key [The key for the variable]
     *
     * @return mixed
     */
    public static function get(string $key)
    {
        if (is_array($key)) {
            return self::gets($key);
        }

        if (self::has($key)) {
            return $_SESSION[(string) $key];
        }

        return false;
    }

    /**
     * Get multiple variables from the session.
     *
     * @param array $keys [The keys for each variable]
     */
    protected static function gets(array $keys)
    {
        foreach ($keys as $key)
        {
            if (self::has($key))
            {
                $output[$key] = self::get($key);
            }
        }

        return $output;
    }

    /**
     * Deletes one variable.
     *
     * @param string $key [The key of the variable]
     *
     * @return bool [true: the key got deleted, false: the key didn't get deleted]
     */
    public static function forget($key)
    {
        if (self::has($key)) {
            unset($_SESSION[(string) $key]);

            return true;
        }

        return false;
    }

    /**
     * Dump all the session variables and values.
     *
     * @return array $_SESSION [All the items in the session array]
     */
    public static function dump()
    {
        echo '<pre>';
            print_r($_SESSION);
        echo '</pre>';
    }

    /**
     * Flash a Session.
     *
     * @param string $key   [The key of the stored flash variable]
     * @param mixed  $value [The value of the stored flash key]
     *
     * @return mixed
     */
    public static function flash($key, $value = '')
    {
        if (self::has($key)) {
            $value = self::get($key);
            self::forget($key);

            return $value;
        }
        self::put($key, $value);
    }

    /**
     * Get the session id.
     *
     * @return string session_id();
     */
    public static function id()
    {
        return session_id();
    }

    /**
     * Destroyes the session.
     *
     * @return mixed
     */
    public static function destroy()
    {
        if (session_id()) {
            return session_destroy();
        }

        return false;
    }
}

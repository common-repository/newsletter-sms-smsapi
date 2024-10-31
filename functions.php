<?php

if (!function_exists('smsapi_array_safe_get')) {
    function smsapi_array_safe_get(&$haystack, $needle, $default = null)
    {
        $haystack = is_array($haystack) ? $haystack : array();

        if (array_key_exists($needle, $haystack)) {
            return $haystack[$needle];
        }

        return $default;
    }
}

if (!function_exists('smsapi_is_ajax_request')) {
    function smsapi_is_ajax_request()
    {
        $ajaxHeader = $_SERVER['HTTP_X_REQUESTED_WITH'];

        if (!empty($ajaxHeader) && strtolower($ajaxHeader) == 'xmlhttprequest') {
            return true;
        }

        return false;
    }
}

if (!function_exists('smsapi_is_post_request')) {
    function smsapi_is_post_request()
    {
        return !empty($_POST);
    }
}

if (!function_exists('smsapi_send_file')) {
    function smsapi_send_file($filename, $download = NULL, array $options = NULL)
    {
        if (empty($download)) {
            $download = pathinfo($filename, PATHINFO_BASENAME);
        }

        $size = filesize($filename);

        if (!isset($mime)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $mime = finfo_file($finfo, $filename);

            finfo_close($finfo);
        }

        $file = fopen($filename, 'rb');

        if (!is_resource($file)) {
            throw new Exception(sprintf('Could not read file to send: %s', $download));
        }

        $disposition = empty($options['inline']) ? 'attachment' : 'inline';

        $headers = array();

        $headers['Content-Disposition'] = $disposition.'; filename="'.$download.'"';
        $headers['Content-Type'] = $mime;
        $headers['Content-Length'] = $size;

        if (!headers_sent()) {
            if (isset($_SERVER['SERVER_PROTOCOL'])) {
                $protocol = $_SERVER['SERVER_PROTOCOL'];
            } else {
                $protocol = 'HTTP/1.1';
            }

            header($protocol.' 200 OK');

            foreach ($headers as $name => $value){
                if (is_string($name)) {
                    $value = "{$name}: {$value}";
                }

                header($value, TRUE);
            }
        }

        while (ob_get_level()) {
            ob_end_flush();
        }

        ignore_user_abort(TRUE);

        set_time_limit(0);

        $block = 1024 * 16;

        while (!feof($file)) {
            if (connection_aborted()) {
                break;
            }

            echo fread($file, $block);

            flush();
        }

        fclose($file);

        if (!empty($options['delete'])) {
            try {
                unlink($filename);
            } catch (Exception $e) {}
        }

        exit;
    }
}

if (!function_exists('smsapi_text_random')) {
    function smsapi_text_random($length = 5)
    {
        $pool = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';

		$pool = str_split($pool, 1);

		$max = count($pool) - 1;

		$str = '';

		for ($i = 0; $i < $length; $i++) {
            $str .= $pool[mt_rand(0, $max)];
        }

		if ($length > 1) {
            if (ctype_alpha($str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(48, 57));
            } elseif (ctype_digit($str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(65, 90));
            }
        }

		return $str;
    }
}

if (!function_exists('session_get_once')) {
    function session_get_once($key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            if (is_array($_SESSION[$key])) {
                $returnValue = array_map('sanitize_text_field', $_SESSION[$key]);
            } else {
                $returnValue = sanitize_text_field($_SESSION[$key]);
            }
            unset($_SESSION[$key]);
        }

        return $returnValue ?? $default;
    }
}

if (!function_exists('smsapi_session_set')) {
    function smsapi_session_set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}

if (!function_exists('smsapi_session_get')) {
    function smsapi_session_get($key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            if (is_array($_SESSION[$key])) {
                return array_map('sanitize_text_field', $_SESSION[$key]);
            }
            return sanitize_text_field($_SESSION[$key]);
        }

        return $default;
    }
}

if (!function_exists('smsapi_set_flash_success')) {
    function smsapi_set_flash_success($message)
    {
        $_SESSION['flash_success'] = $message;
    }
}

if (!function_exists('smsapi_set_flash_warning')) {
    function smsapi_set_flash_warning($message)
    {
        $_SESSION['flash_warning'] = $message;
    }
}

if (!function_exists('smsapi_set_flash_error')) {
    function smsapi_set_flash_error($message)
    {
        $_SESSION['flash_error'] = $message;
    }
}

if (!function_exists('smsapi_get_flash_success')) {
    function smsapi_get_flash_success()
    {
        return session_get_once('flash_success');
    }
}

if (!function_exists('smsapi_get_flash_error')) {
    function smsapi_get_flash_error()
    {
        return session_get_once('flash_error');
    }
}

if (!function_exists('smsapi_get_flash_warning')) {
    function smsapi_get_flash_warning()
    {
        return session_get_once('flash_warning');
    }
}

if (!function_exists('smsapi_security_session_token')) {
    function smsapi_security_session_token($new = false)
    {
        if ($new) {
            $securityToken = smsapi_text_random();

            smsapi_session_set('security_token', $securityToken);

            return $securityToken;
        }

        return smsapi_session_get('security_token');
    }
}
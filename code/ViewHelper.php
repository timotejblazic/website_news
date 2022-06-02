<?php

class ViewHelper {
    public static function render($file, $variables = array()) {
        extract($variables);

        ob_start();
        include $file;
        $renderedView = ob_get_clean();

        echo $renderedView;
    }

    public static function redirect($url) {
        header("Location: $url");
    }

    public static function error404() {
        header("HTTP/1.0 404 Not Found", true, 404);
        $html404 = sprintf("<!doctype html>\n" .
                            "<title>Error 404: Page does not exist</title>\n" .
                            "<h1>Error 404: Page does not exist</h1>\n".
                            "<p>The page <i>%s</i> does not exist.</p>", $_SERVER["REQUEST_URI"]);

        echo $html404;
    }

    public static function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}
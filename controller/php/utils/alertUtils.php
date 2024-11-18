<?php

/**
 * AlertUtils
 *
 * Utility class for displaying alerts and redirecting to new locations.
 *
 * @package IlalinApp
 * @since   1.0.0
 */
class AlertUtils {

    /**
     * Displays an alert component with a message and optional body.
     * 
     * @param string $alert_message The main message to display in the alert.
     * @param string|null $alert_body Optional detailed message to display in the alert.
     */
    public static function alertComponent($alert_message, $alert_body = null) {
        echo '
            <script src="https://cdn.tailwindcss.com"></script>
            <div style="z-index: 99999;" id="alert-modal" tabindex="-1"
                class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 bottom-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="py-10 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <div>
                                <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">' . htmlspecialchars($alert_message) . '</h3>
                                ' . ($alert_body !== null ? '<p class="text-sm font-light text-gray-500 dark:text-gray-400 mt-2">' . htmlspecialchars($alert_body) . '</p>' : '') . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    /**
     * Displays an alert page with a message and optional body.
     * 
     * @param string $alert_message The main message to display on the page.
     * @param string|null $alert_body Optional detailed message to display on the page.
     */
    public static function showAlertPage($alert_message, $alert_body = null) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Alert</title>
            <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
            <script src="https://cdn.tailwindcss.com"></script>
            <script src="../tailwind.config.js"></script>
        </head>
        <body>
        '.self::alertComponent($alert_message, $alert_body).'            
        </body>
        </html>';
    }

    /**
     * Renders a script to redirect the browser to a specified URL after a timeout.
     * 
     * @param int $redirect_location_timeout The time in milliseconds before redirecting.
     * @param string $location_url The URL to redirect to.
     * 
     * The function will terminate the script execution using the `exit` keyword after rendering the redirect script.
     */
    public static function renderRedirectScript($redirect_location_timeout = 1000, $location_url) {
        echo '
        <script>
        var redirectTimeout = parseInt(' . (isset($redirect_location_timeout) ? $redirect_location_timeout : 1000) . ');
        if (redirectTimeout > 0) {
            setTimeout(function() {
                location.href = "' . htmlspecialchars($location_url) . '";
            }, redirectTimeout);
        } else {
            location.href = "' . htmlspecialchars($location_url) . '";
        }
        </script>';

        exit;
    }
}
<?php

abstract class Mail {

    static public function send($options = []) {
        $to = isset($options['to']) ? $options['to'] : 'contact@acode.cl';
        $subject = isset($options['subject']) ? $options['subject'] : 'Books & Dungeons';
        $message = isset($options['message']) ? $options['message'] : "Contact us";
        $message = "
            <html>
                <head><title>Books & Dungeons</title></head>
                <body>
                    <header>Books & Dungeons</header>
                    <main>{$message}</main>
                    <footer>Developed by acode.cl</footer>
                </body>
            </html>";
        $headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= 'From: <noreply@bnd.acode.cl>'."\r\n";
        $headers .= 'Cc: contact@acode.cl'."\r\n";
        mail($to, $subject, $message, $headers);
    }

}
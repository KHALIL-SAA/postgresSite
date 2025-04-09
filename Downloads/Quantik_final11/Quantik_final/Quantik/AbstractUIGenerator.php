<?php

namespace Quantik2024;


abstract class AbstractUIGenerator
{

    protected static function getDebutHTML(string $title = "Quantik Game"): string
    {
        return '<!DOCTYPE html>
                <html lang="fr">
                <head>
                <meta charset="utf-8" />
                <title>'.$title.'</title>
                <link rel="stylesheet" href="css/style.css" />
                </head>
                <body>
                <h1>'.$title.'</h1>';
    }


    protected static function getFinHTML(): string
    {
        return "</form></div></body>\n</html>";
    }

    public static function getPageErreur(string $message): string {
        return "ERREUR";
    }
}

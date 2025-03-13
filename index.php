<?php

$requestHeaders = apache_request_headers();
$Option = apache_request_headers()['Accept'];
$mHeader = 0;
$mValue = 0;

if ($mHeader < strlen("Request Headers")) {
    $mHeader = strlen("Request Headers");
}

// Calculate max header length and value length
foreach ($requestHeaders as $Header => $Value) {
    if ($mHeader < strlen($Header)) {
        $mHeader = strlen($Header);
    }

    if ($mValue < strlen($Value)) {
        $mValue = strlen($Value);
    }
}

if (str_contains($Option, 'text/html')) {
    printHtml($mHeader, $mValue);
} else {
    printText($mHeader, $mValue);
}

function printHtml($maxHeader, $maxValue) {
    // Variables
    $maxPost = 0;
    $column1 = 15;
    $column2 = 40;
    $requestHeaders = apache_request_headers();

    // function to make N hyphens for formatting
    function makeHyphens($length) {
        return str_repeat('-', $length);
    }

echo "<!DOCTYPE html>
<html>
<head>
    <title>View Request Headers</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
</head>
<body bgcolor=\"black\">
    <div id=`\"container`\">
    <pre>
        <code>
<span style=\"color:#55F\">            _</span>
<span style=\"color:#F55\">__   __</span><span style=\"color:#5F5\">_ __</span><span style=\"color:#55F\">| |__         </span><span style=\"color:#FFF\">View Request Headers</span>
<span style=\"color:#F55\">\ \ / /</span><span style=\"color:#5F5\">  __|</span><span style=\"color:#55F\"> _  \        </span><span style=\"color:#55F\"><a href=\"https://github.com/b-rito/vrh-PHP\">https://github.com/b-rito/vrh-PHP</a></span>
<span style=\"color:#F55\"> \ V /</span><span style=\"color:#5F5\">| |  </span><span style=\"color:#55F\">| | | |</span>
<span style=\"color:#F55\">  \_/ </span><span style=\"color:#5F5\">|_|  </span><span style=\"color:#55F\">|_| |_|</span>";

    $red = "<span style=\"color:#F55\">";
    $green = "<span style=\"color:#5F5\">";
    $blue = "<span style=\"color:#55F\">";
    $gray = "<span style=\"color:#555\">";
    $yellow = "<span style=\"color:#FF5\">";
    $white = "<span style=\"color:#FFF\">";
    $close = "</span>";

    // Outline
    printf("\n%s+ %s + %s +%s\n", $gray, makeHyphens($column1), makeHyphens($column2), $close);

    // Date time
    printf("%s|%s", $gray, $close);
    printf("%s %-{$column1}s %s", $green, "Date", $close);
    printf("%s=%s", $gray, $close);
    printf("%s %-{$column2}s %s", $yellow, date(DATE_RFC2822), $close);
    printf("%s|%s\n", $gray, $close);

    // Hostname information
    printf("%s|%s", $gray, $close);
    printf("%s %-{$column1}s %s", $green, "Hostname", $close);
    printf("%s=%s", $gray, $close);
    printf("%s %-{$column2}s %s", $yellow, gethostname(), $close);
    printf("%s|%s\n", $gray, $close);

    // Request Method information
    printf("%s|%s", $gray, $close);
    printf("%s %-{$column1}s %s", $green, "Request Method", $close);
    printf("%s=%s", $gray, $close);
    printf("%s %-{$column2}s %s", $yellow, $_SERVER['REQUEST_METHOD'], $close);
    printf("%s|%s\n", $gray, $close);

    // Request URI information
    printf("%s|%s", $gray, $close);
    printf("%s %-{$column1}s %s", $green, "Request URI", $close);
    printf("%s=%s", $gray, $close);
    printf("%s %-{$column2}s %s", $yellow, $_SERVER['REQUEST_URI'], $close);
    printf("%s|%s\n", $gray, $close);

    // Outline
    printf("%s+ %s + %s +%s\n", $gray, makeHyphens($column1), makeHyphens($column2), $close);
    printf("%s+ %s + %s +%s\n", $gray, makeHyphens($maxHeader), makeHyphens($maxValue), $close);

    // Title
    printf("%s|%s", $gray, $close);
    printf("%s %-{$maxHeader}s %s", $white, "Request Headers", $close);
    printf("%s|%s", $gray, $close);
    printf("%s %-{$maxValue}s %s", $white, "Request Values", $close);
    printf("%s|%s\n", $gray, $close);

    // Outline
    printf("%s+ %s + %s +%s\n", $gray, makeHyphens($maxHeader), makeHyphens($maxValue), $close);
    // Request Headers
    foreach ($requestHeaders as $Header => $Value) {
        printf("%s %-{$maxHeader}s %s", $green, $Header, $close);
        printf("%s : %s", $gray, $close);
        printf("%s %-{$maxValue}s %s\n", $yellow, $Value, $close);
    }

    // Outline
    printf("%s+ %s + %s +%s\n", $gray, makeHyphens($maxHeader), makeHyphens($maxValue), $close);

    // Variable for max POST size formatting, same length as Requests
    $maxPost = $maxHeader + $maxValue + 3;

    // Determine if POST is Form based or RAW and output
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (empty($_POST)) {
            $postData = file_get_contents('php://input');
                printf("%s+ %s +%s\n", $gray, makeHyphens($maxPost), $close);
                printf("%s|%s", $gray, $close);
                printf("%s %-{$maxPost}s %s\n", $white, "POST Form", $close);
                printf("%s|%s\n", $gray, $close);
                printf("%s+ %s +%s\n", $gray, makeHyphens($maxPost), $close);
                printf("%s %-*s %s\n", $yellow, $maxPost, $postData, $close);
                printf("%s+ %s +%s\n", $gray, makeHyphens($maxPost), $close);
        } else {
                printf("%s+ %s +%s\n", $gray, makeHyphens($maxPost), $close);
                printf("%s|%s", $gray, $close);
                printf("%s %-{$maxPost}s %s\n", $white, "POST Form", $close);
                printf("%s|%s\n", $gray, $close);
                printf("%s+ %s +%s\n", $gray, makeHyphens($maxPost), $close);
                print_r( $_POST);
                printf("%s+ %s +%s\n", $gray, makeHyphens($maxPost), $close);
        }
    }
            echo "</code>
        </pre>
        </div>
    </body>
    </html>";
}

function printText($maxHeader, $maxValue) {
    // Variables
    $maxPost = 0;
    $column1 = 15;
    $column2 = 40;
    $requestHeaders = apache_request_headers();

    // function to make N hyphens for formatting
    function makeHyphens($length) {
        return str_repeat('-', $length);
    }

    print "
                \033[0;34m_
    \033[0;31m__   __\033[0;32m_ __\033[0;34m| |__    \033[0;0m View Request Headers
    \033[0;31m\ \ / /\033[0;32m  __|\033[0;34m _  \   \033[0;0m https://github.com/b-rito/vrh-PHP
    \033[0;31m \ V /\033[0;32m| |  \033[0;34m| | | |
    \033[0;31m  \_/ \033[0;32m|_|  \033[0;34m|_| |_|\033[0;0m\n\n";

    // Outline
    printf("\033[0;90m+ %s + %s +\033[0;0m\n", makeHyphens($column1), makeHyphens($column2));

    // Date time
    printf("\033[0;90m|\033[0;0m");
    printf("\033[0;32m %-{$column1}s \033[0;0m", "Date");
    printf("\033[0;90m=\033[0;0m");
    printf("\033[0;93m %-{$column2}s \033[0;0m",  date(DATE_RFC2822));
    printf("\033[0;90m|\033[0;0m");
    printf("\n");

    // Hostname information
    printf("\033[0;90m|\033[0;0m");
    printf("\033[0;32m %-{$column1}s \033[0;0m", "Hostname");
    printf("\033[0;90m=\033[0;0m");
    printf("\033[0;93m %-{$column2}s \033[0;0m", gethostname());
    printf("\033[0;90m|\033[0;0m");
    printf("\n");

    // Request Method information
    printf("\033[0;90m|\033[0;0m");
    printf("\033[0;32m %-{$column1}s \033[0;0m", "Request Method");
    printf("\033[0;90m=\033[0;0m");
    printf("\033[0;93m %-{$column2}s \033[0;0m", $_SERVER['REQUEST_METHOD']);
    printf("\033[0;90m|\033[0;0m");
    printf("\n");

    // Request URI information
    printf("\033[0;90m|\033[0;0m");
    printf("\033[0;32m %-{$column1}s \033[0;0m", "Request URI");
    printf("\033[0;90m=\033[0;0m");
    printf("\033[0;93m %-{$column2}s \033[0;0m", $_SERVER['REQUEST_URI']);
    printf("\033[0;90m|\033[0;0m");
    printf("\n");

    // Outline
    printf("\033[0;90m+ %s + %s +\033[0;0m\n", makeHyphens($column1), makeHyphens($column2));
    printf("\033[0;90m+ %s + %s +\033[0;0m\n", makeHyphens($maxHeader), makeHyphens($maxValue));

    // Title
    printf("\033[0;90m|\033[0;0m");
    printf("\033[0;0m %-{$maxHeader}s \033[0;0m", "Request Headers");
    printf("\033[0;90m|\033[0;0m");
    printf("\033[0;0m %-{$maxValue}s \033[0;0m", "Request Values");
    printf("\033[0;90m|\033[0;0m");
    printf("\n");

    // Outline
    printf("\033[0;90m+ %s + %s +\033[0;0m\n", makeHyphens($maxHeader), makeHyphens($maxValue));

    // Output all Request Header-Values received
    foreach ($requestHeaders as $Header => $Value) {
        printf("\033[0;90m\033[0;32m %-{$maxHeader}s  ", $Header);
        printf("\033[0;90m:\033[0;93m %-{$maxValue}s ", $Value);
        printf("\033[0;90m\n");
    }

    // Outline
    printf("\033[0;90m+ %s + %s +\033[0;0m\n", makeHyphens($maxHeader), makeHyphens($maxValue));

    // Variable for max POST size formatting, same length as Requests
    $maxPost = $maxHeader + $maxValue + 3;

    // Determine if POST is Form based or RAW and output
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (empty($_POST)) {
            $postData = file_get_contents('php://input');
                printf("\033[0;90m+ %s +\033[0;0m\n", makeHyphens($maxPost));
                printf("\033[0;90m|\033[0;0m");
                printf("\033[0;0m %-{$maxPost}s \033[0;0m", "POST Form");
                printf("\033[0;90m|\033[0;0m\n");
                printf("\033[0;90m+ %s +\033[0;0m\n", makeHyphens($maxPost));
                printf("\033[0;0m  %-{$maxPost}s \033[0;0m\n", $postData);
                printf("\033[0;90m+ %s +\033[0;0m\n", makeHyphens($maxPost));
        } else {
            printf("\033[0;90m+ %s +\033[0;0m\n", makeHyphens($maxPost));
            printf("\033[0;90m|\033[0;0m");
            printf("\033[0;0m %-{$maxPost}s \033[0;0m", "POST Form");
            printf("\033[0;90m|\033[0;0m\n");
            printf("\033[0;90m+ %s +\033[0;0m\n", makeHyphens($maxPost));
            print_r( $_POST);
            printf("\033[0;90m+ %s +\033[0;0m\n", makeHyphens($maxPost));
        }
    }
}
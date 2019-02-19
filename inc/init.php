<?php
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
// Démarrage de session
session_start();
// Chemin physique
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . "FORMATIONS/PhP/10 - boutique/");
#echo RACINE_SITE;
#echo '<pre>'; print_r($_SERVER); echo '</pre>';
/*
C:/xampp/htdocs/PhP/10 - boutique/
Array
(
    [MIBDIRS] => C:/xampp/php/extras/mibs
    [MYSQL_HOME] => \xampp\mysql\bin
    [OPENSSL_CONF] => C:/xampp/apache/bin/openssl.cnf
    [PHP_PEAR_SYSCONF_DIR] => \xampp\php
    [PHPRC] => \xampp\php
    [TMP] => \xampp\tmp
    [HTTP_HOST] => localhost
    [HTTP_CONNECTION] => keep-alive
    [HTTP_CACHE_CONTROL] => max-age=0
    [HTTP_UPGRADE_INSECURE_REQUESTS] => 1
    [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36 */
#   [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8
/*  [HTTP_DNT] => 1
    [HTTP_REFERER] => http://localhost/PhP/10%20-%20boutique/inc/
    [HTTP_ACCEPT_ENCODING] => gzip, deflate, br
    [HTTP_ACCEPT_LANGUAGE] => en-US,en;q=0.9,fr-FR;q=0.8,fr;q=0.7,es-ES;q=0.6,es;q=0.5
    [HTTP_COOKIE] => _ga=GA1.1.713788990.1525428003; PHPSESSID=r4vu91pepbtufv27k593dokr86
    [PATH] => C:\Program Files (x86)\Common Files\Oracle\Java\javapath;C:\ProgramData\Oracle\Java\javapath;C:\WINDOWS\system32;C:\WINDOWS;C:\WINDOWS\System32\Wbem;C:\WINDOWS\System32\WindowsPowerShell\v1.0\;C:\Program Files\nodejs\;C:\Program Files\Git\cmd;C:\WINDOWS\System32\OpenSSH\;C:\Users\formation2\AppData\Local\Microsoft\WindowsApps;C:\Users\formation2\AppData\Local\GitHubDesktop\bin;C:\Users\formation2\AppData\Roaming\npm;C:\Program Files (x86)\SSH Communications Security\SSH Secure Shell;%USERPROFILE%\AppData\Local\Microsoft\WindowsApps;
    [SystemRoot] => C:\WINDOWS
    [COMSPEC] => C:\WINDOWS\system32\cmd.exe
    [PATHEXT] => .COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC
    [WINDIR] => C:\WINDOWS
    [SERVER_SIGNATURE] => 
Apache/2.4.29 (Win32) OpenSSL/1.1.0g PHP/7.2.2 Server at localhost Port 80


    [SERVER_SOFTWARE] => Apache/2.4.29 (Win32) OpenSSL/1.1.0g PHP/7.2.2
    [SERVER_NAME] => localhost
    [SERVER_ADDR] => ::1
    [SERVER_PORT] => 80
    [REMOTE_ADDR] => ::1
    [DOCUMENT_ROOT] => C:/xampp/htdocs
    [REQUEST_SCHEME] => http
    [CONTEXT_PREFIX] => 
    [CONTEXT_DOCUMENT_ROOT] => C:/xampp/htdocs
    [SERVER_ADMIN] => postmaster@localhost
    [SCRIPT_FILENAME] => C:/xampp/htdocs/PhP/10 - boutique/inc/init.php
    [REMOTE_PORT] => 58273
    [GATEWAY_INTERFACE] => CGI/1.1
    [SERVER_PROTOCOL] => HTTP/1.1
    [REQUEST_METHOD] => GET
    [QUERY_STRING] => 
    [REQUEST_URI] => /PhP/10%20-%20boutique/inc/init.php
    [SCRIPT_NAME] => /PhP/10 - boutique/inc/init.php
    [PHP_SELF] => /PhP/10 - boutique/inc/init.php
    [REQUEST_TIME_FLOAT] => 1527584823.661
    [REQUEST_TIME] => 1527584823
)
*/

define('URL', 'http://localhost/FORMATIONS/PhP/10 - boutique/'); // URL du site
#echo URL;

// Variables
$content = '';

// Inclusions 
require_once 'fonction.php';
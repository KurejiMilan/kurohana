# kurohana
this is the official git repository for the ongoing kurohana project.Kurohana is a web application where user can post their
creative and original work, earn with viewer pledges.

## table of Content
* [Technologies](#Technologies)
* [Developers and Contributors](#Developers-and-Contributors)
* [New Updates](#New-Updates)

## Technologies
Project is created with:
* php
* javascript
* css
* html
* jQuery framework
* Axios javascript native library
* LAMPP stack(linux os, apache server, MYsqli database, PHP server side language)
* OpenSSL

## Developers and Contributors
Here is the list of Developers and Contributors of this project:
* Milan Rai
* Samarthak Pakhrin

## New Updates
Read and write here for new Updates
* [OpenSSL](#OpenSSL)
* [Fix database table](#Fix-database-table)

### OpenSSL
Uses OpenSSL to convert the plain text to cipher text. OpenSSL must be installed on the machine
for openssl to work.
```
<?php
  openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
?>
```

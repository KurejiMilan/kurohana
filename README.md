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

<img src="https://scontent.fjkr1-1.fna.fbcdn.net/v/t1.0-9/97650504_3238879879669885_3359907105539620864_o.jpg?_nc_cat=110&ccb=2&_nc_sid=174925&_nc_ohc=_CnEtN_pEsUAX-TtpBm&_nc_ht=scontent.fjkr1-1.fna&oh=b79b5d92a965535dba24e5eb23ac71b6&oe=5FC158AA" alt="Milan Rai" width="250px" height="250px">

<imag src="https://scontent.fjkr1-1.fna.fbcdn.net/v/t1.0-1/p200x200/41547355_1658573577587178_7728894649602932736_o.jpg?_nc_cat=100&ccb=2&_nc_sid=7206a8&_nc_ohc=qWp3tCKOLbEAX8yTzRs&_nc_ht=scontent.fjkr1-1.fna&tp=6&oh=8011c8873920c72fc80b827320924183&oe=5FC0C06C" alt="Samarthak Pakhrin" width="250px" height="250px">

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
  openssl_decrypt($ciphertext, $cipher, $key, $options, $iv, $tag);
?>
```
### Fix database table
This script fixes some of the database table logical flaws and schema
go to the link http://localhost/kurohana/databaseSchemaFixScript.php
and read the usage to fix the correct table or all table.

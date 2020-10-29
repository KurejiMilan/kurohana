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
![Milan Rai](https://scontent.fjkr1-1.fna.fbcdn.net/v/t1.0-9/30729967_2528599807364566_7241857882361167872_n.jpg?_nc_cat=108&ccb=2&_nc_sid=174925&_nc_ohc=a_sL9vdcDaMAX-9P3la&_nc_ht=scontent.fjkr1-1.fna&oh=a96e4272f3106fbec07fe85db174cfe4&oe=5FBF176F)

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

# EmailMarketer
A laravel artisan console app for sending email campaigns

Usage
```
 mail:campaign [-sub|--subject="..."] [-f|--sender_address="..."] [-name|--sende
r_name="..."] [-b|--view="..."] [-s|--start[="..."]] [-e|--end[="..."]] file.csv
```
```
e.g

$ php artisan mail:campaign test.csv --view="emails.newsletter.dummy" -f="info@
jekaconnect.com" --sender_name="Mr abc" -sub="Hello"
"
```

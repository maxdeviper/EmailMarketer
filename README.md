# EmailMarketer
A laravel artisan console app for sending email campaigns

Usage
```
 mail:campaign [-t|--subject="..."] [-f|--sender_address="..."] [--sender_name="..."] [-b|--view="..."] [-s|--start[="..."]] [-e|--end[="..."]] file.csv

```
```
e.g

$ php artisan mail:campaign test.csv --view="emails.newsletter.dummy" -f="abc@
abc.com" --sender_name="Mr abc" -t="Hello"
"
```

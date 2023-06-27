## PHP Exercise - v21.0.2
In this exercise you need to create a PHP application that will have a form with the following fields:
● Company Symbol
● Start Date (YYYY-mm-dd)
● End Date (YYYY-mm-dd)
● Email

## The available options for the Company Symbol field can be found here:

https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0
b2142ca8d7df6/nasdaq-listed_json.json

## After the form submission, the following actions must be done:

## 1) Validate the form both on the client and server side and display the appropriate messages on
both cases. Validation rules:
● Company Symbol: required, a valid symbol
● Start Date: required, valid date, less or equal than End Date, less or equal than current
date
● End Date: required, valid date, greater or equal than Start Date, less or equal than
current date
● Email: required, valid email

## 2) Display on screen the historical quotes for the submitted Company Symbol in the given date
range in table format. Table columns:
Date | Open | High | Low | Close | Volume
Historical data should be retrieved using the API’s endpoint 'stock/v3/get-historical-data' which
is documented here: https://rapidapi.com/apidojo/api/yh-finance
## NOTE: Historical data service requires the token X-RapidAPI-Key which is provided in the same
email with this document.

## 3) Based on the Historical data retrieved, display on screen a chart of the Open and Close prices.

## 4) Send to the submitted Email an email message, using as:
● Subject: the submitted company’s name
○ i.e. for submitted Company Symbol = GOOG => Company’s Name = Google
● Body: Start Date and End Date
○ i.e. From 2020-01-01 to 2020-01-31


## Notes
● The exercise can be developed using plain PHP, but PHP framework (Symfony, Laravel
etc) is preferred
● Tests are a mandatory part of the exercise
● In case no PHP framework is used, the email must be sent using the Swift Mailer:
https://github.com/swiftmailer/swiftmailer
Or Symfony Mailer: https://github.com/symfony/mailer
● The user must enter Start Date and End Date using jQuery UI datepicker or any other
plugin/component with similar functionality: http://jqueryui.com/datepicker/

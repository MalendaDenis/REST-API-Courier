To install this project you need to execute 2 steps:
1)Clone this project in location where you need
2)Run from terminal file install.sh

File install.sh contain 5 command witch configure docker containers and after that install all bundles.

Next step is start using this porject, for that you need:
1) To import rest_api_requests.postman_collection.json file in your postman.
All requests send (if that is needed) data in json format add response come to in json format.

2) After import postman_collection you will have 7 requests, in addition, you can view all the data they send in the section Body and in this one find section raw :
    a)http://localhost/register  -creating an account with all needed information
    data send:
      email         : denis@denis.com
      name          : Denis Sined
      location      : 1
      plainPassword : 123123
    If courier acc is created you will see response status 200 and a confirmation message.

    b)http://localhost/login_check - now you need to login and get the JWT token.
    This project uses the JWT token for the courier part of the API, and this token is valid for 8 hours,
    in a real project its life will be about 15 minutes and will be exposed thanks to the so-called long-lived Token,
    but here I just extended the life of the first one otherwise it would be extremely inconvenient to use this API from Postman.
    data send:
        username    : denis@denis.com
        password    : 123123
    If your acc pass log in , you will got status 200 and your personal token for next 8 hours, use it for reques: e,f,g.

    c) 

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

    c) http://localhost/API/shopping/price This request simulates the calculation of the cost of delivery for some order in a location served by a courier service.
    data send:
        location_id : 1
        order_price : 1000  (if order_price >= 1000 then shipping cost = 0, if order_price < 1000 then shipping cost = cost which is specified for chosen location)
    If all is right you will got price for shipping.

    d) http://localhost/API/shopping/order That request is used by byer to create a order for delivery
    data send:
        location      : 1
        order_price   : 1000
        customer_name : Olga Aglo
        phone         : 37368686868
        address       : str. Cuza Voda 22/11 ap.11
        secret_word   : secret
    If all is right, this worder will be created and now couriers from the same location will see it.
    
    e) http://localhost/API/shipping/orders That request is used by logined couriers
        data send:
            In section Authorization choose type "Bearer Token", and in input field "Token" introduse your token which you got using http://localhost/login_check request.
       If you are logined , response will consist from orders which are ready for shipping.
       
    f) http://localhost/API/shipping/started Using this request you assign choosed order on your courier account and got all needed for shipping information. Also don't forgot about introducing your Token.
    data send:
        order        : 1
    If indicated order is ready for shipping and it is assigned on you then response will consist from all needed information.
    
    g) http://localhost/API/shipping/delivered This request is used when the courier delivered the order and it needs to be closed. He need to ask buyer secret word to introduce it in his APP and if this word is right the order will come closed.
    data send:
        order        : 1
        secret_word  : secret


    That's it. Now you know how this project works!

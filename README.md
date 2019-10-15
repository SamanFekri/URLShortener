# URLShortener
Simple url shortener as a serivce with go  
You can see the demo [here](http://s.hallows.ir)

## How use this service?
For get the short form of your url you can send a HTTP ``post`` request to [hallows.ir/add](http://s.halows.ir/add):
### Request
```JSON
{
  "long_url": "<Your URL>"
}
```

### Response 
```JSON
{
  "short_url": "<Shorted URL>"
}
```

### Warning
This service has absoloutly no guarantee 😂🤣  
Maybe we reset system sometimes 🤷‍♂️

## Run on your server
1.  first clone this repository on your server.
    ``` git
    git clone https://github.com/SamanFekri/URLShortener.git
    ```
2.  change the domain name in nginx and server.
    * `/nginx/nginx.conf`
        ```
        server_name <your domain>;
        ```
    * `src/server/main.go`
        ```go
        var baseUrl = <your domain with http>
        ```
3.  install [docker](https://docs.docker.com/install/)
4.  install [docker-compose](https://docs.docker.com/compose/install/)
5.  go to the urlshortener directory and run this command:
    ```bash
    docker-compose build
    docker-compose up
    ```
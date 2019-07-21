FROM golang:1.12.5-alpine

RUN apk update
RUN apk add git

RUN go get -u github.com/golang/dep/cmd/dep
WORKDIR /go/src/urlshortener
COPY ./src/server/main.go ./server/main.go
COPY ./src/shortener/shortener.go ./shortener/shortener.go
COPY ./Gopkg.toml .
COPY ./Gopkg.lock .
RUN dep ensure

RUN apk add bash
CMD ["go", "run", "/go/src/urlshortener/server/main.go"]

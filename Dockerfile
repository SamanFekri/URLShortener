FROM golang:1.12.5-alpine

RUN apk update
RUN apk add git

RUN go get -u github.com/golang/dep/cmd/dep
WORKDIR /go/src/urlshotener
COPY ./src .
COPY Gopkg.toml .
COPY Gopkg.lock .
RUN dep ensure


RUN go install -v ./src/...
CMD ["./src/server/main"]

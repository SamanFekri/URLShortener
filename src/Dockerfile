FROM golang:1.12.5-alpine

RUN apk update
RUN apk add git

WORKDIR /go/src/urlshotener
COPY ./src .
COPY Gopkg.toml Gopkg.toml

RUN go get -u github.com/golang/dep/cmd/dep
RUN dep ensure

# Build my app
RUN go install src
CMD ["./src/server/main"]
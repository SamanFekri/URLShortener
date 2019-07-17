FROM golang:1.12.5-alpine

RUN apk update
RUN apk add git

WORKDIR /go/src/urlshotener
COPY ./src .

RUN go get -d -v ./...
RUN go install -v ./...
CMD ["./src/server/main"]
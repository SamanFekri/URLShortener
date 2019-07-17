FROM golang:1.12.5-alpine

RUN apk update
RUN apk add git

WORKDIR /go/src/urlshotener
COPY ./src .

RUN go get -d -v ./src/...
RUN go install -v ./src/...
CMD ["./src/server/main"]
package main

import (
	"../shortener"
	"github.com/labstack/echo"
	gocache "github.com/patrickmn/go-cache"
	"net/http"
)

type Response struct {
	Msg      string `json:"msg,omitempty"`
	ShortURL string `json:"short_url,omitempty"`
}

var baseUrl string = "localhost:3000"

func main() {
	e := echo.New()
	cache := gocache.New(gocache.NoExpiration, gocache.NoExpiration)

	e.GET("/", func(c echo.Context) error {
		return c.String(http.StatusOK, shortener.Print(cache))
	})

	e.POST("/add", func(c echo.Context) error {
		longUrl := c.FormValue("long_url")
		if longUrl == "" {
			return c.JSON(http.StatusBadRequest, &Response{Msg: "Important parameter not set"})
		}
		key, ok := shortener.Add(longUrl, cache)
		if !ok {
			return c.JSON(http.StatusBadRequest, &Response{Msg: "An error occurred when program tries to create short url"})
		}
		return c.JSON(http.StatusCreated, &Response{ShortURL: baseUrl + "/" + key})
	})

	e.GET("/:key", func(c echo.Context) error {
		key := c.Param("key")
		isExist, url, err := shortener.Redirect(key, cache)
		if err != nil {
			return c.JSON(http.StatusBadRequest, &Response{Msg: "An error occurred when program tries to redirect"})
		}
		if !isExist {
			return c.JSON(http.StatusNotFound, &Response{Msg: "This url is not found"})
		}
		return c.Redirect(http.StatusPermanentRedirect, url)
	})

	e.Logger.Fatal(e.Start(":3000"))
}

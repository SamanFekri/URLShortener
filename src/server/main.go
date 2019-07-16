package main

import (
	"../shortener"
	"github.com/labstack/echo"
	gocache "github.com/patrickmn/go-cache"
	"net/http"
)

type AddResponse struct {
	Msg      string `json:"msg,omitempty"`
	ShortURL string `json:"short_url,omitempty"`
}

func main() {
	e := echo.New()
	cache := gocache.New(gocache.NoExpiration, gocache.NoExpiration)

	e.GET("/", func(c echo.Context) error {
		return c.String(http.StatusOK, "Hello, World1!")
	})

	e.POST("/add", func(c echo.Context) error {
		longUrl := c.FormValue("long_url")
		if longUrl == "" {
			return c.JSON(http.StatusBadRequest, &AddResponse{Msg: "Important parameter not set"})
		}
		key, ok := shortener.Add(longUrl, cache)
		if ok {
			return c.JSON(http.StatusCreated, &AddResponse{ShortURL: key})
		}
		return c.JSON(http.StatusBadRequest, &AddResponse{Msg: "An error occurred when program tries to create short url"})
	})

	e.GET("/:key", func(c echo.Context) error {
		return c.String(http.StatusOK, "Hello, World3!")
	})

	e.Logger.Fatal(e.Start(":3000"))
}

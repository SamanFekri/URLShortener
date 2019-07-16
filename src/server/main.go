package main

import (
	"github.com/labstack/echo"
	gocache "github.com/patrickmn/go-cache"
	"net/http"
)

func main() {
	e := echo.New()
	gocache.New(gocache.NoExpiration, gocache.NoExpiration)

	e.GET("/", func(c echo.Context) error {
		return c.String(http.StatusOK, "Hello, World1!")
	})

	e.POST("/add", func(c echo.Context) error {
		return c.String(http.StatusOK, "Hello, World2!")
	})

	e.GET("/:key", func(c echo.Context) error {
		return c.String(http.StatusOK, "Hello, World3!")
	})

	e.Logger.Fatal(e.Start(":1323"))
}

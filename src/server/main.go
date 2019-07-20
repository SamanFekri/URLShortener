package main

import (
	"github.com/labstack/echo"
	"github.com/labstack/echo/middleware"
	gocache "github.com/patrickmn/go-cache"
	"net/http"
	"sync"
	"urlshortener/shortener"
)

type Request struct {
	LongUrl string `json:"long_url" form:"long_url" xml:"long_url" validate:"required"`
}

type Response struct {
	Msg      string `json:"msg,omitempty"`
	ShortURL string `json:"short_url,omitempty"`
}

var baseUrl = "http://hallows.ir"
var mux sync.Mutex
var dbPath = "./src/server/db.gob"

func main() {
	e := echo.New()
	e.Use(middleware.Logger())

	cache, err := shortener.Load(dbPath)
	if err != nil {
		cache = gocache.New(gocache.NoExpiration, gocache.NoExpiration)
	}

	e.File("/", "src/server/UI/index.html")
	e.Static("/assets", "src/server/UI/assets")

	e.POST("/add", func(c echo.Context) error {
		r := new(Request)
		if err := c.Bind(r); err != nil {
			return c.JSON(http.StatusBadRequest, &Response{Msg: "Important parameter not set"})
		}
		longUrl := r.LongUrl
		if longUrl == "" {
			return c.JSON(http.StatusBadRequest, &Response{Msg: "Important parameter not set"})
		}
		key, ok := shortener.Add(longUrl, cache)
		if !ok {
			return c.JSON(http.StatusBadRequest, &Response{Msg: "An error occurred when program tries to create short url"})
		}
		shortener.Save(dbPath, cache, mux)
		return c.JSON(http.StatusCreated, &Response{ShortURL: baseUrl + "/" + key})
	})

	e.GET("/all", func(c echo.Context) error {
		return c.String(http.StatusOK, shortener.Print(cache))
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
		shortener.Save(dbPath, cache, mux)
		return c.Redirect(http.StatusTemporaryRedirect, url)
	})

	e.Logger.Fatal(e.Start(":80"))
}

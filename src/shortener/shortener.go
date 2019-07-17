package shortener

import (
	"crypto/sha1"
	"encoding/base64"
	"fmt"
	gocache "github.com/patrickmn/go-cache"
	"net/url"
	"strings"
	"time"
)

type address struct {
	url    string
	clicks int64
}

func Add(longUrl string, cache *gocache.Cache) (string, bool) {
	if longUrl == "" {
		return "", false
	}

	if !isValidUrl(longUrl) {
		longUrl = "http://" + longUrl
	}

	if !isValidUrl(longUrl) {
		return "", false
	}

	hasher := sha1.New()
	hasher.Write([]byte(longUrl + time.Now().String()))
	sha := base64.URLEncoding.EncodeToString(hasher.Sum(nil))
	sha = strings.ToUpper(sha)
	key := url.PathEscape(sha)

	index := 5
	for {
		if !(isExist(key[:index], cache)) {
			break
		}
		index++
		if index == len(key) {
			hasher.Write([]byte(longUrl + time.Now().String()))
			sha = base64.URLEncoding.EncodeToString(hasher.Sum(nil))
			sha = strings.ToUpper(sha)
			key += url.PathEscape(sha)
		}
	}

	err := cache.Add(key[:index], address{url: longUrl, clicks: 0}, gocache.NoExpiration)
	if err != nil {
		return "", false
	}

	return key[:index], true
}

func Redirect(key string, c *gocache.Cache) (bool, string, error) {
	item, isExist := c.Get(key)
	tmpUrl := ""
	if isExist {
		tmpUrl = item.(address).url
		item = address{tmpUrl, item.(address).clicks + 1}
		err := c.Replace(key, item, gocache.NoExpiration)
		if err != nil {
			return false, "", err
		}
	}
	return isExist, tmpUrl, nil
}

func Print(c *gocache.Cache) string {
	result := ""
	for key, item := range c.Items() {
		result += fmt.Sprintf("key:%v url:%v clicks:%d\n", key, item.Object.(address).url, item.Object.(address).clicks)
	}
	return result
}

func isExist(key string, c *gocache.Cache) bool {
	_, isExist := c.Get(key)
	return isExist
}

// isValidUrl tests a string to determine if it is a url or not.
func isValidUrl(toTest string) bool {
	_, err := url.ParseRequestURI(toTest)
	if err != nil {
		return false
	} else {
		return true
	}
}

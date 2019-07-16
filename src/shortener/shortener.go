package shortener

import (
	"crypto/sha1"
	"encoding/base64"
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

func isExist(key string, c *gocache.Cache) bool {
	_, isExist := c.Get(key)
	return isExist
}

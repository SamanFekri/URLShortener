package shortener

import (
	"crypto/sha1"
	"encoding/base64"
	"encoding/gob"
	"fmt"
	gocache "github.com/patrickmn/go-cache"
	"net/url"
	"os"
	"regexp"
	"strings"
	"sync"
	"time"
)

type address struct {
	Url    string
	Clicks int64
}

type Cat struct {
	age     int
	name    string
	friends []string
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

	err := cache.Add(key[:index], address{Url: longUrl, Clicks: 0}, gocache.NoExpiration)
	if err != nil {
		return "", false
	}

	return key[:index], true
}

func Redirect(key string, c *gocache.Cache) (bool, string, error) {
	item, isExist := c.Get(key)
	tmpUrl := ""
	if isExist {
		tmpUrl = item.(address).Url
		item = address{tmpUrl, item.(address).Clicks + 1}
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
		result += fmt.Sprintf("key:%v Url:%v Clicks:%d\n", key, item.Object.(address).Url, item.Object.(address).Clicks)
	}
	return result
}

func isExist(key string, c *gocache.Cache) bool {
	_, isExist := c.Get(key)
	return isExist
}

// isValidUrl tests a string to determine if it is a Url or not.
func isValidUrl(toTest string) bool {
	_, err := url.ParseRequestURI(toTest)
	if err != nil {
		return false
	} else {
		re := regexp.MustCompile(`^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+`)
		return re.MatchString(toTest)
	}
}

func Save(path string, c *gocache.Cache, mux sync.Mutex) error {
	mux.Lock()
	defer mux.Unlock()
	gob.Register(address{})
	// create a file
	dataFile, err := os.Create(path)
	if err != nil {
		return err
	}
	// serialize the data
	dataEncoder := gob.NewEncoder(dataFile)
	err = dataEncoder.Encode(c.Items())
	if err != nil {
		return err
	}

	dataFile.Close()
	return nil
}

func Load(path string) (c *gocache.Cache, err error) {
	var data map[string]gocache.Item
	// open data file
	gob.Register(address{})
	dataFile, err := os.Open(path)
	if err != nil {
		return
	}

	dataDecoder := gob.NewDecoder(dataFile)
	err = dataDecoder.Decode(&data)
	if err != nil {
		return
	}
	dataFile.Close()

	return gocache.NewFrom(gocache.NoExpiration, gocache.NoExpiration, data), nil
}

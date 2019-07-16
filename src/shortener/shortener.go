package shortener

import (
	"crypto/sha1"
	"encoding/base64"
	"fmt"
	"net/url"
	"strings"
	"time"
)

func Add(longUrl string) (string, bool) {
	if longUrl == "" {
		return "", false
	}
	hasher := sha1.New()
	hasher.Write([]byte(longUrl + time.Now().String()))
	sha := base64.URLEncoding.EncodeToString(hasher.Sum(nil))
	sha = strings.ToUpper(sha)
	key := url.PathEscape(sha)

	fmt.Println(key)

	return "", true
}

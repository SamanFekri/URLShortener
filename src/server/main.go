package main

import (
	"../shortener"
	"fmt"
	gocache "github.com/patrickmn/go-cache"
)

func main() {
	cache := gocache.New(gocache.NoExpiration, gocache.NoExpiration)
	for i := 0; i < 50; i++ {
		a, ok := shortener.Add("hhhh", cache)
		if !ok {
			fmt.Println("FUCK")
		}
		fmt.Println(a)
	}

}

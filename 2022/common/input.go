package common

import (
	"bufio"
	"log"
	"os"
)

func GetInputLines(fileName string, isExample bool) []string {
	path := "assets/inputs/" + fileName
	if isExample {
		path = "assets/inputs/examples/" + fileName
	}

	f, err := os.Open(path)
	if err != nil {
		log.Fatal(err)
	}
	defer f.Close()

	var lines []string
	scanner := bufio.NewScanner(f)
	for scanner.Scan() {
		lines = append(lines, scanner.Text())
	}
	return lines
}

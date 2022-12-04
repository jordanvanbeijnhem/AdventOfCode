package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"unicode"
)

func getAlphabetNumberOfRune(r rune) int {
	unicodeCharacterOffset := 96
	if unicode.IsUpper(r) {
		unicodeCharacterOffset = 38
	}
	return int(r) - unicodeCharacterOffset
}

func runPuzzle3Part1() {
	totalPriority := 0
	for _, line := range common.GetInputLines("day3.txt", false) {
		rucksackSize := len(line)
		compartmentSize := rucksackSize / 2
		firstCompartmentRunes := map[rune]bool{}
		for i, r := range line {
			if i < compartmentSize {
				firstCompartmentRunes[r] = false
			} else if _, ok := firstCompartmentRunes[r]; ok && firstCompartmentRunes[r] == false {
				totalPriority += getAlphabetNumberOfRune(r)
				firstCompartmentRunes[r] = true
			}
		}
	}
	fmt.Println(fmt.Sprintf("Total priority: %d", totalPriority))
}

func runPuzzle3Part2() {
	totalPriority := 0
	currentElfInGroup := 0
	matchingRunes := map[rune]int{}
	for _, line := range common.GetInputLines("day3.txt", false) {
		currentElfInGroup++
		for _, r := range line {
			if _, ok := matchingRunes[r]; currentElfInGroup == 1 && !ok || matchingRunes[r] == currentElfInGroup-1 {
				matchingRunes[r] = currentElfInGroup
			}
		}
		if currentElfInGroup == 3 {
			for key, value := range matchingRunes {
				if value == 3 {
					totalPriority += getAlphabetNumberOfRune(key)
				}
			}
			currentElfInGroup = 0
			matchingRunes = map[rune]int{}
		}
	}
	fmt.Println(fmt.Sprintf("Total priority: %d", totalPriority))
}

func RunPuzzle3() {
	log.Println("--- STARTING PUZZLE 3 ---")
	runPuzzle3Part1()
	runPuzzle3Part2()
	log.Println("--- FINISHED PUZZLE 3 ---")
}

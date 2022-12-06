package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"strings"
)

func findMarkerAndPosition(input string, uniqueSequenceLength int) (int, string) {
	for i := range input {
		str := input[i : i+uniqueSequenceLength]
		found := true
		for _, r := range str {
			if strings.Count(str, string(r)) > 1 {
				found = false
				break
			}
		}
		if found {
			return i + uniqueSequenceLength, str
		}
	}
	return -1, "Marker could not be found"
}

func runPuzzle6Part1() {
	line := common.GetInputLines("day6.txt", false)[0]
	position, marker := findMarkerAndPosition(line, 4)
	fmt.Println("Start of packet marker: ", position, marker)
}

func runPuzzle6Part2() {
	line := common.GetInputLines("day6.txt", false)[0]
	position, marker := findMarkerAndPosition(line, 14)
	fmt.Println("Start of message marker: ", position, marker)
}

func RunPuzzle6() {
	log.Println("--- STARTING PUZZLE 6 ---")
	runPuzzle6Part1()
	runPuzzle6Part2()
	log.Println("--- FINISHED PUZZLE 6 ---")
}

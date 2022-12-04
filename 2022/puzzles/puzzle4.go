package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"strconv"
	"strings"
)

func getStartAndEndOfRange(rng string) (int, int) {
	rangeArray := strings.Split(rng, "-")
	rangeStart, _ := strconv.Atoi(rangeArray[0])
	rangeEnd, _ := strconv.Atoi(rangeArray[1])
	return rangeStart, rangeEnd
}

func RunPuzzle4() {
	log.Println("--- STARTING PUZZLE 4 ---")
	totalOverlaps := 0
	totalCompleteOverlaps := 0
	for _, line := range common.GetInputLines("day4.txt", false) {
		elfAssignments := strings.Split(line, ",")
		firstElfStart, firstElfEnd := getStartAndEndOfRange(elfAssignments[0])
		secondElfStart, secondElfEnd := getStartAndEndOfRange(elfAssignments[1])
		if (firstElfStart >= secondElfStart && firstElfEnd <= secondElfEnd) || (secondElfStart >= firstElfStart && secondElfEnd <= firstElfEnd) {
			totalCompleteOverlaps++
		}
		if firstElfStart <= secondElfEnd && firstElfEnd >= secondElfStart {
			totalOverlaps++
		}
	}
	fmt.Println(fmt.Sprintf("Total complete overlaps: %d", totalCompleteOverlaps))
	fmt.Println(fmt.Sprintf("Total overlaps: %d", totalOverlaps))
	log.Println("--- FINISHED PUZZLE 4 ---")
}

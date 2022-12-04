package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"strings"
)

var shapeMap = map[string]int{
	"A": 1,
	"B": 2,
	"C": 3,
	"X": 1,
	"Y": 2,
	"Z": 3,
}

var winMap = map[int]int{
	1: 3,
	2: 1,
	3: 2,
}

var loseMap = map[int]int{
	1: 2,
	2: 3,
	3: 1,
}

func runPuzzle2Part1() {
	totalPoints := 0
	for _, line := range common.GetInputLines("day2.txt", false) {
		choices := strings.Split(line, " ")
		myChoice := shapeMap[choices[1]]
		opponentChoice := shapeMap[choices[0]]
		if myChoice == opponentChoice {
			totalPoints += myChoice + 3
		} else if winMap[myChoice] == opponentChoice {
			totalPoints += myChoice + 6
		} else {
			totalPoints += myChoice
		}
	}
	fmt.Println(fmt.Sprintf("Total points: %d", totalPoints))
}

func runPuzzle2Part2() {
	totalPoints := 0
	for _, line := range common.GetInputLines("day2.txt", false) {
		choices := strings.Split(line, " ")
		opponentChoice := shapeMap[choices[0]]
		myChoice := 0
		if choices[1] == "X" {
			myChoice = winMap[opponentChoice]
			totalPoints += myChoice
		} else if choices[1] == "Y" {
			myChoice = opponentChoice
			totalPoints += myChoice + 3
		} else {
			myChoice = loseMap[opponentChoice]
			totalPoints += myChoice + 6
		}
	}
	fmt.Println(fmt.Sprintf("Total points: %d", totalPoints))
}

func RunPuzzle2() {
	log.Println("--- STARTING PUZZLE 2 ---")
	runPuzzle2Part1()
	runPuzzle2Part2()
	log.Println("--- FINISHED PUZZLE 2 ---")
}

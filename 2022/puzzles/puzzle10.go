package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"math"
	"strconv"
	"strings"
)

func printPixelMap(pixels []bool) {
	for i, isPixelLit := range pixels {
		if isPixelLit {
			fmt.Print("#")
		} else {
			fmt.Print(".")
		}
		if (i+1)%40 == 0 {
			fmt.Println()
		}
	}
}

func runPuzzle10Part1() {
	lines := common.GetInputLines("day10.txt", false)
	signalStrengthCheckPoints := []int{20, 60, 100, 140, 180, 220}
	var pixels []bool
	totalCheckPointScore := 0
	currentCycle := 1
	executionCycle := 0
	currentLineIndex := 0
	xRegister := 1

	for {
		if currentLineIndex >= len(lines) {
			break
		}

		for _, checkpoint := range signalStrengthCheckPoints {
			if currentCycle == checkpoint {
				totalCheckPointScore += checkpoint * xRegister
				break
			}
		}

		row := math.Floor(float64(currentCycle-1) / 40)
		pixelLocation := int(row*40) + xRegister
		if pixelLocation-1 == currentCycle-1 || pixelLocation == currentCycle-1 || pixelLocation+1 == currentCycle-1 {
			pixels = append(pixels, true)
		} else {
			pixels = append(pixels, false)
		}

		currentLine := lines[currentLineIndex]
		if strings.HasPrefix(currentLine, "addx") {
			if currentCycle == executionCycle {
				amount, _ := strconv.Atoi(strings.Split(currentLine, " ")[1])
				xRegister += amount
				currentLineIndex++
			} else {
				executionCycle = currentCycle + 1
			}
		} else {
			currentLineIndex++
		}
		currentCycle++
	}
	fmt.Println("Total checkpoint score:", totalCheckPointScore)
	printPixelMap(pixels)
}

func RunPuzzle10() {
	log.Println("--- STARTING PUZZLE 10 ---")
	runPuzzle10Part1()
	log.Println("--- FINISHED PUZZLE 10 ---")
}

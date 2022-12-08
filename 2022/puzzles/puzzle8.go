package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"strconv"
)

func runPuzzle8Part1() {
	lines := common.GetInputLines("day8.txt", false)
	visibleTrees := 0
	for i, line := range lines {
		if i == 0 || i == len(lines)-1 {
			visibleTrees += len(line)
			continue
		}
		for j, r := range line {
			if j == 0 || j == len(line)-1 {
				visibleTrees += 1
				continue
			}
			currentValue, _ := strconv.Atoi(string(r))

			// Check row
			topOk := true
			bottomOk := true
			for row, rowLine := range lines {
				if row == i {
					continue
				}
				rowValue, _ := strconv.Atoi(string(rowLine[j]))
				if rowValue >= currentValue {
					if row < i {
						topOk = false
					} else {
						bottomOk = false
					}
				}
			}
			rowsOk := topOk || bottomOk

			// Check colum
			leftOk := true
			rightOk := true
			for column, columnRune := range line {
				if column == j {
					continue
				}
				columnValue, _ := strconv.Atoi(string(columnRune))
				if columnValue >= currentValue {
					if column < j {
						leftOk = false
					} else {
						rightOk = false
					}
				}
			}
			columnsOk := leftOk || rightOk

			if rowsOk || columnsOk {
				visibleTrees++
			}
		}
	}
	fmt.Println("Visible trees: ", visibleTrees)
}

func runPuzzle8Part2() {
	lines := common.GetInputLines("day8.txt", false)
	highestScore := 0
	for i, line := range lines {
		for j, r := range line {
			currentValue, _ := strconv.Atoi(string(r))

			// Check row
			topScore := i
			bottomScore := len(lines) - 1 - i
			for row, rowLine := range lines {
				if row == i {
					continue
				}
				rowValue, _ := strconv.Atoi(string(rowLine[j]))
				if rowValue >= currentValue {
					if row < i {
						topScore = i - row
					} else if bottomScore == len(lines)-1-i {
						bottomScore = row - i
					}
				}
			}
			rowScore := topScore * bottomScore

			// Check colum
			leftScore := j
			rightScore := len(line) - 1 - j
			for column, columnRune := range line {
				if column == j {
					continue
				}
				columnValue, _ := strconv.Atoi(string(columnRune))
				if columnValue >= currentValue {
					if column < j {
						leftScore = j - column
					} else if rightScore == len(line)-1-j {
						rightScore = column - j
					}
				}
			}
			columnScore := leftScore * rightScore

			totalScore := rowScore * columnScore
			if totalScore > highestScore {
				highestScore = totalScore
			}
		}
	}
	fmt.Println("Highest score: ", highestScore)
}

func RunPuzzle8() {
	log.Println("--- STARTING PUZZLE 8 ---")
	runPuzzle8Part1()
	runPuzzle8Part2()
	log.Println("--- FINISHED PUZZLE 8 ---")
}

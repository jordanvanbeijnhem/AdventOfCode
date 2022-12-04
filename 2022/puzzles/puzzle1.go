package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"sort"
	"strconv"
)

func RunPuzzle1() {
	log.Println("--- STARTING PUZZLE 1 ---")
	currentElfCalories := 0
	var caloriesPerElf []int
	for _, line := range common.GetInputLines("day1.txt", false) {
		if line != "" {
			calories, _ := strconv.Atoi(line)
			currentElfCalories += calories
		} else {
			caloriesPerElf = append(caloriesPerElf, currentElfCalories)
			currentElfCalories = 0
		}
	}
	sort.Sort(sort.Reverse(sort.IntSlice(caloriesPerElf)))

	topThreeCalories := 0
	for i := 0; i < 3; i++ {
		topThreeCalories += caloriesPerElf[i]
	}

	fmt.Println(fmt.Sprintf("Most calories: %d", caloriesPerElf[0]))
	fmt.Println(fmt.Sprintf("Top three calories combined: %d", topThreeCalories))
	log.Println("--- FINISHED PUZZLE 1 ---")
}

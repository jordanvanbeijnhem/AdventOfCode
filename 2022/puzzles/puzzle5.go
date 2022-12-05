package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"strconv"
	"strings"
)

type command struct {
	amount int
	from   int
	to     int
}

func getStacksAndCommands() ([][]string, []command) {
	lines := common.GetInputLines("day5.txt", false)
	numberOfRows := 0
	var stacks [][]string
	for _, line := range lines {
		if strings.HasPrefix(line, " 1") {
			rows := strings.Split(line, " ")
			numberOfRows, _ = strconv.Atoi(rows[len(rows)-1])
			for i := 0; i < numberOfRows; i++ {
				stacks = append(stacks, []string{})
			}
			break
		}
	}

	var commands []command
	for _, line := range lines {
		if strings.HasPrefix(line, "move") {
			words := strings.Split(line, " ")
			amount, _ := strconv.Atoi(words[1])
			from, _ := strconv.Atoi(words[3])
			to, _ := strconv.Atoi(words[5])
			commands = append(commands, command{amount: amount, from: from, to: to})
		} else if strings.Contains(line, "[") {
			for i := 0; i < numberOfRows; i++ {
				index := i*4 + 1
				if index > len(line)-1 || string(line[index]) == " " {
					continue
				} else {
					stacks[i] = append(stacks[i], string(line[index]))
				}
			}
		}
	}
	return stacks, commands
}

func getResult(stacks [][]string) string {
	result := ""
	for _, stack := range stacks {
		result += stack[0]
	}
	return result
}

func runPuzzle5Part1() {
	stacks, commands := getStacksAndCommands()
	for _, command := range commands {
		for i := 0; i < command.amount; i++ {
			stacks[command.to-1] = append([]string{stacks[command.from-1][0]}, stacks[command.to-1]...)
			stacks[command.from-1] = stacks[command.from-1][1:]
		}
	}
	fmt.Println("Part 1: " + getResult(stacks))
}

func runPuzzle5Part2() {
	stacks, commands := getStacksAndCommands()
	for _, command := range commands {
		var stackToMove []string
		for i := 0; i < command.amount; i++ {
			stackToMove = append(stackToMove, stacks[command.from-1][i])
		}
		stacks[command.to-1] = append(stackToMove, stacks[command.to-1]...)
		stacks[command.from-1] = stacks[command.from-1][command.amount:]
	}
	fmt.Println("Part 2: " + getResult(stacks))
}

func RunPuzzle5() {
	log.Println("--- STARTING PUZZLE 5 ---")
	runPuzzle5Part1()
	runPuzzle5Part2()
	log.Println("--- FINISHED PUZZLE 5 ---")
}
